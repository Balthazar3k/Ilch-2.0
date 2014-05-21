<?php
/**
 * Created by PhpStorm.
 * User: sebastian
 * Date: 02.05.14
 * Time: 08:35
 */

namespace Ilch\Database\Mysql;

use \Ilch\Database\Mysql as DB;

class Select extends QueryBuilder
{
    /**
     * @var integer|null
     */
    protected $limit;

    /**
     * @var integer|null
     */
    protected $offset;

    /**
     * @var integer|null
     */
    protected $page;

    /**
     * @var array|null
     */
    protected $order;

    /**
     * @var array
     */
    protected $fields = [];

    /**
     * @var Expression\Join[]
     */
    protected $joins = [];

    /**
     * @var array
     */
    protected $groupByFields = [];

    /** @var bool */
    protected $useFoundRows = false;

    /**
     * Create Select Statement Query Builder
     *
     * @param \Ilch\Database\Mysql $db
     * @param array|string|null $fields
     * @param string|null $table table without prefix
     * @param array|null $where conditions @see QueryBuilder::where()
     * @param array|null $orderBy
     * @param array|int|null $limit
     */
    public function __construct(
        DB $db,
        $fields = null,
        $table = null,
        $where = null,
        array $orderBy = null,
        $limit = null
    ) {
        parent::__construct($db);

        if (isset($fields)) {
            $this->fields($fields);
        }
        if (isset($table)) {
            $this->from($table);
        }
        if (isset($where)) {
            $this->where($where);
        }
        if (isset($orderBy)) {
            $this->order($orderBy);
        }
        if (isset($limit)) {
            $this->limit($limit);
        }
    }

    /**
     * Adds table to query builder.
     *
     * @param string|array $table table without prefix (as array with alias as key)
     * @return \Ilch\Database\Mysql\Select
     */
    public function from($table)
    {
        $this->table = $table;

        return $this;
    }

    /**
     * Adds fields to query builder.
     *
     * @param array|string $fields
     * @param boolean $replace [default: true]
     *
     * @return \Ilch\Database\Mysql\Select
     * @throws \InvalidArgumentException for invalid $fields parameter
     */
    public function fields($fields, $replace = true)
    {
        if ($fields === '*') {
            return $this;
        }

        $fields = $this->createFieldsArray($fields);

        if ($replace || empty($this->fields)) {
            $this->fields = $fields;
        } else {
            $this->fields = array_merge($this->fields. $fields);
        }

        return $this;
    }

    /**
     * Adds order to query builder.
     *
     * @param array $order [field => direction]
     * @return \Ilch\Database\Mysql\Select
     */
    public function order(array $order)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Sets page for query builder (offset will be used first)
     * @param $page
     * @return \Ilch\Database\Mysql\Select
     */
    public function page($page)
    {
        $this->page = $page;
        return $this;
    }

    /**
     * Adds limit to query builder.
     *
     * @param array|integer $limit if array -> [offset, limit]
     * @return \Ilch\Database\Mysql\Select
     */
    public function limit($limit)
    {
        if (is_array($limit)) {
            $limitCount = count($limit);
            if ($limitCount === 1) {
                $this->limit = $limit[0];
            } elseif ($limitCount > 1) {
                $this->offset = $limit[0];
                $this->limit = $limit[1];
            }
        } else {
            $this->limit = (int) $limit;
        }

        return $this;
    }

    /**
     * Sets offset for query builder
     *
     * @param $offset
     * @return \Ilch\Database\Mysql\Select
     */
    public function offset($offset)
    {
        $this->offset = $offset;
        return $this;
    }

    /**
     * Adds a join to the query (builder)
     *
     * @param Expression\Join $join
     * @return \Ilch\Database\Mysql\Select
     */
    public function join(Expression\Join $join)
    {
        $this->joins[] = $join;
        return $this;
    }

    /**
     * Add GROUP BY to the query (builder)
     *
     * @param array $fields
     * @param boolean $replace
     *
     * @return \Ilch\Database\Mysql\Select
     */
    public function group(array $fields, $replace = true)
    {
        if ($replace) {
            $this->groupByFields = $fields;
        } else {
            $this->groupByFields = array_merge($this->groupByFields, $fields);
        }

        return $this;
    }

    /**
     * @param $useFoundRows
     * @return \Ilch\Database\Mysql\Select
     */
    public function useFoundRows($useFoundRows = true)
    {
        $this->useFoundRows = (bool) $useFoundRows;
        return $this;
    }

    /**
     * Execute the generated query
     *
     * @return \Ilch\Database\Mysql\Result
     */
    public function execute()
    {
        return new Result($this->db->query($this->generateSql()), $this->db);
    }

    /**
     * Generate the SQL executed by execute()
     *
     * @return string
     * @throws \RuntimeException if sql could not be generated
     */
    public function generateSql()
    {
        if (empty($this->table)) {
            throw new \RuntimeException('table must be set');
        }

        $fields = $this->fields;

        $sql = 'SELECT ';

        if ($this->useFoundRows) {
            $sql .= 'SQL_CALC_FOUND_ROWS ';
        }

        $joinSql = [];
        foreach ($this->joins as $join) {
            $temp = $join->getType() . ' JOIN ' . $this->getTableSql($join->getTable());
            $joinCondition = $join->getConditions();
            if (!empty($joinCondition)) {
                $temp .= ' ON ' . $this->generateWhereSql($joinCondition);
            }
            $joinFields = $join->getFields();
            if (!empty($joinFields)) {
                $fields = array_merge($fields, $this->createFieldsArray($joinFields));
            }
            $joinSql[] = $temp;
        }

        $sql .= $this->getFieldsSql($fields)
            . ' FROM ' . $this->getTableSql($this->table);

        $sql .= implode(' ', $joinSql);

        $sql .= $this->generateWhereSql();

        // add ORDER BY to sql
        if (!empty($this->order)) {
            $sql .= ' ORDER BY';

            foreach ($this->order as $column => $direction) {
                $sql .= ' `'. $column.'` '.$direction;
            }
        }

        // add LIMIT to sql
        if (isset($this->offset) && !isset($this->limit)) {
            $limit = 99999999;
        } else {
            $limit = $this->limit;
        }

        if (isset($limit)) {
            $limitParts = [$limit];

            if (isset($this->offset)) {
                array_unshift($limitParts, $this->offset);
            } elseif (isset($this->page)) {
                array_unshift($limitParts, max($this->page - 1, 0) * $limit);
            }
            $sql .= ' LIMIT ' . implode(', ', $limitParts);
        }

        return $sql;
    }

    /**
     * Create the field part for the given array.
     *
     * @param  array $fields
     * @return string
     */
    protected function getFieldsSql($fields)
    {
        if (empty($fields)) {
            return '*';
        }

        $sqlFields = [];

        foreach ($fields as $key => $value) {
            if (!$value instanceof Expression\Expression) {
                $value = $this->db->quote($value);
            }
            //non int key -> alias
            if (!is_int($key)) {
                $value .= ' AS ' . $this->db->quote($key, true);
            }
            $sqlFields[] = $value;
        }

        return implode(',', $sqlFields);
    }

    /**
     * Create sql for a table (with optional alias)
     *
     * @param string|array $table
     *
     * @return string
     */
    protected function getTableSql($table)
    {
        if (is_array($table)) {
            $table = reset($table);
            $tableAlias = key($table);
        } else {
            $table = $this->table;
        }

        $sql = $this->db->quote('[prefix]_' . $table);
        if (isset($tableAlias)) {
            $sql .= ' AS ' . $this->db->quote($tableAlias, true);
        }

        return $sql;
    }

    /**
     * Create an array of fields
     *
     * @param string|array $fields
     *
     * @return array
     * @throws \InvalidArgumentException
     */
    protected function createFieldsArray($fields)
    {
        if (is_string($fields)) {
            //function like COUNT()
            if (strpos($fields, '(') !== false) {
                $fields = [new Expression\Expression($fields)];
                //single field
            } elseif (strpos($fields, ' ') === false) {
                $fields = [$fields];
            }
        } elseif ($fields instanceof Expression\Expression) {
            $fields = [$fields];
        }
        if (!is_array($fields)) {
            throw new \InvalidArgumentException('array or single field (or function) string expected');
        }

        return $fields;
    }
}
