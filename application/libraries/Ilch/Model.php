<?php
/**
 * @author Meyer Dominik
 * @copyright Ilch 2.0
 * @package ilch
 */

namespace Ilch;
defined('ACCESS') or die('no direct access');

class Model
{
    public function __construct($options = '')
    {
        if (is_array($options)) {
            foreach ($options as $key => $value) {
                 $this->$key = $value;
            }
        }
    }

    public function __get($name)
    {
        if (isset($this->$name)) {
            return $this->$name;
        }

        return null;
    }

    public function __isset($name)
    {
        return isset($this->$name);
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
    }
}
