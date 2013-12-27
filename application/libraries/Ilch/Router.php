<?php
/**
 * @copyright Ilch 2.0
 * @package ilch
 */

namespace Ilch;
defined('ACCESS') or die('no direct access');

class Router
{
    const DEFAULT_REGEX_PATTERN = '/?(?P<admin>admin)?/?(?P<module>\w+)/(?P<controller>\w+)(/(?P<action>\w+)?)?(/(?P<params>[a-zA-Z0-9_/]+)?)?';
    const DEFAULT_MATCH_STRATEGY = 'matchByQuery';

    /**
     * @var string
     */
    private $_query;

    /**
     * @var \ArrayObject|null
     */
    private $_config;

    /**
     * @var \Ilch\Request|null
     */
    private $_request;

    /**
     * Injects request.
     *
     * @param \Ilch\Request $request
     */
    public function __construct(\Ilch\Request $request)
    {
        $this->_request = $request;
        $this->_config = new \ArrayObject();
        $this->_config->offsetSet
        (
            '_DEFAULT_',
            array
            (
                'strategy' => self::DEFAULT_MATCH_STRATEGY,
                'pattern' => self::DEFAULT_REGEX_PATTERN
            )
        );
    }

    /**
     * @param \Ilch\Request $request
     */
    public function setRequest($request)
    {
        $this->_request = $request;
    }

    /**
     * @return \Ilch\Request|null
     */
    public function getRequest()
    {
        return $this->_request;
    }

    /**
     * @param \ArrayObject $config
     */
    public function setConfig($config)
    {
        $this->_config = $config;
    }

    /**
     * @return \ArrayObject|null
     */
    public function getConfig()
    {
        return $this->_config;
    }

    /**
     * Checks if route already exists.
     *
     * @param string $routeName
     * @return boolean
     */
    public function hasConfigItem($routeName)
    {
        return (bool)$this->_config->offsetExists($routeName);
    }

    /**
     * Adds new route to router.
     *
     * @param $routeName
     * @param array $value
     * @return boolean
     */
    public function addConfigItem($routeName, array $value)
    {
        if (!$this->hasConfigItem($routeName)) {
            $this->_config->offsetSet($routeName, $value);
            return true;
        }

        return false;
    }

    /**
     * Removes route from router.
     *
     * @param $routeName
     */
    public function removeConfigItem($routeName)
    {
        $this->_config->offsetUnset($routeName);
    }

    /**
     * Gets the router query.
     *
     * @return string
     */
    public function getQuery()
    {
        return $this->_query;
    }

    /**
     * Fills the router query.
     */
    protected function fillQuery()
    {
        $query = substr($_SERVER['REQUEST_URI'], strlen(REWRITE_BASE));
        $query = str_replace('index.php/', '', $query);
        $query = trim(str_replace('index.php', '', $query), '/');

        $this->_query = $query;
    }

    /**
     * Match given route by regular expression.
     *
     * @todo matchByRegexp not works at the moment.
     * @param string $route
     * @param array $params
     * @throws \Exception
     * @return array
     */
    public function matchByRegexp($route, array $params = array())
    {
        $matches = array();
        $pattern = !array_key_exists('pattern', $params) ? self::DEFAULT_REGEX_PATTERN : $params['pattern'];

        $matched = preg_match(
            '#^' . $pattern . '$#i',
            $route,
            $matches
        );

        if (count($matches) === 0) {
            throw new \Exception(sprintf('Expected route "%s" does not match with pattern "%s"', $route, $pattern));
        }

        return $matches;
    }

    /**
     * Match given route by query.
     * Fills the request object if rewrite is possible.
     *
     * @param string $query
     * @return array
     */
    public function matchByQuery($query)
    {
        $result = array();
        $queryParts = explode('/', $query);
        $i = 0;

        if ($queryParts[0] == 'admin') {
            $result['admin'] = $queryParts[0];
            unset($queryParts[0]);
            $i = 1;
        }

        if (isset($queryParts[$i])) {
            $result['module'] = $queryParts[$i];
            unset($queryParts[$i]);
        }

        $i++;

        if (isset($queryParts[$i])) {
            $result['controller'] = $queryParts[$i];
            unset($queryParts[$i]);
        }

        $i++;

        if (isset($queryParts[$i])) {
            $result['action'] = $queryParts[$i];
            unset($queryParts[$i]);
        }

        if (!empty($queryParts)) {
            $result['params'] = implode('/',$queryParts);
        }

        return $result;
    }

    /**
     * Converts a valid routed string of params into array.
     *
     * @param $string
     * @return array
     */
    public function convertParamStringIntoArray($string)
    {
        $array = explode('/', $string);
        $result = array();
        $prevKey = null;

        foreach ($array as $key => $value) {
            if ($key % 2 === 0) {
                $prevKey = $value;
            }
            if ($key % 2 === 1) {
                $result[$prevKey] = $value;
            }
        }

        return $result;
    }

    /**
     * Defines the start page.
     *
     * @param string $startPage
     * @param \Ilch\Translator $translator
     * @return null
     */
    public function defineStartPage($startPage, $translator)
    {
        if (!empty($this->_query)) {
            return;
        }
        
        $config = \Ilch\Registry::get('config');
        $locale = '';

        if ((bool)$config->get('multilingual_acp')) {
            if ($translator->getLocale() != $config->get('content_language')) {
                $locale = $translator->getLocale();
            }
        }

        if (strpos($startPage, 'module_') !== false) {
            $this->_request->setModuleName(str_replace('module_', '', $startPage));
            $this->_request->setControllerName('index');
            $this->_request->setActionName('index');
        } elseif (strpos($startPage, 'page_') !== false) {
            $this->_request->setModuleName('page');
            $this->_request->setControllerName('index');
            $this->_request->setActionName('show');
            $this->_request->setParam('id', str_replace('page_', '', $startPage));
            $this->_request->setParam('locale', $locale);
        } else {
            $this->_request->setModuleName(DEFAULT_MODULE);
            $this->_request->setControllerName('index');
            $this->_request->setActionName('index');
        }
    }

    /**
     * Match route by strategy.
     *
     * @param string $route
     * @param array $params
     * @return mixed
     */
    public function matchStrategy($route, array $params = array())
    {
        $callback = array();
        $strategy = array_key_exists('strategy', $params) ? $params['strategy'] : self::DEFAULT_MATCH_STRATEGY;

        /*
         * Select default strategy delivered by router.
         */
        if (is_string($strategy) && strtolower(substr($strategy, 0, 5)) === 'match' && method_exists($this, $strategy)) {
            $callback = array($this, $strategy);
        }

        if (is_callable($strategy)) {
            $callback = $strategy;
        }

        return call_user_func_array($callback, array($route, $params));
    }

    /**
     * Match the given route.
     *
     * @param string $route
     * @return array
     */
    public function match($route)
    {
        $results = array();

        foreach ($this->_config as $routeName => $config) {
            if (!array_key_exists('strategy', $config)) {
                $config['strategy'] = self::DEFAULT_MATCH_STRATEGY;
            }
            $results[] = $this->matchStrategy($route, $config);
        }

        return $results;
    }

    /**
     * Updates the request objext.
     *
     * @param $result
     */
    public function updateRequest($result)
    {
        if (array_key_exists('admin', $result) && strlen($result['admin']) > 0){
            $this->_request->setIsAdmin(true);
        }

        if (array_key_exists('module', $result)) {
            $this->_request->setModuleName($result['module']);
        }

        if (array_key_exists('controller', $result)) {
            $this->_request->setControllerName($result['controller']);
        }

        if (array_key_exists('action', $result)) {
            $this->_request->setActionName($result['action']);
        }

        if (array_key_exists('params', $result)) {
            $params = $this->convertParamStringIntoArray($result['params']);

            foreach($params as $key => $value) {
                $this->_request->setParam($key,$value);
            }
        }
    }

    /**
     * Fills the request object with the best matched route.
     */
    public function execute()
    {
        $this->_request->setModuleName('page');
        $this->_request->setControllerName('index');
        $this->_request->setActionName('index');

        $this->fillQuery();
        $query = $this->getQuery();

        if (!empty($query)) {
            $result = $this->match($query);
            $this->updateRequest(reset($result));
        }
    }
}
