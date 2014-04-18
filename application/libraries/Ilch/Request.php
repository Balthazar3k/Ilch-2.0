<?php
/**
 * @copyright Ilch 2.0
 * @package ilch
 */

namespace Ilch;
defined('ACCESS') or die('no direct access');

class Request
{
    /**
     * @var boolean
     */
    protected $_isAdmin = false;
    
    /**
     * @var boolean
     */
    protected $_isAjax = false;

    /**
     * @var string
     */
    protected $_moduleName;

    /**
     * @var string
     */
    protected $_controllerName;

    /**
     * @var string
     */
    protected $_actionName;

    /**
     * @var array
     */
    protected $_params;

    /**
     * Gets admin request flag.
     *
     * @return string
     */
    public function isAdmin()
    {
        return $this->_isAdmin;
    }

    /**
     * Sets admin request flag.
     *
     * @param boolean $admin
     */
    public function setIsAdmin($admin)
    {
        $this->_isAdmin = $admin;
    }
    
    /**
     * Gets Ajax request flag.
     *
     * @return boolean
     */
    public function isAjax()
    {
        return $this->_isAjax;
    }

    /**
     * Sets ajax request flag.
     *
     * @param boolean $ajax
     */
    public function setIsAjax($ajax)
    {
        $this->_isAjax = $ajax;
    }

    /**
     * Gets the current module name.
     *
     * @return string
     */
    public function getModuleName()
    {
        return $this->_moduleName;
    }

    /**
     * Sets the current module name.
     *
     * @param string $name
     */
    public function setModuleName($name)
    {
        $this->_moduleName = $name;
    }

    /**
     * Gets the current controller name.
     *
     * @return string
     */
    public function getControllerName()
    {
        return $this->_controllerName;
    }

    /**
     * Sets the current controller name.
     *
     * @param string $name
     */
    public function setControllerName($name)
    {
        $this->_controllerName = $name;
    }

    /**
     * Gets the current action name.
     *
     * @return string
     */
    public function getActionName()
    {
        return $this->_actionName;
    }

    /**
     * Sets the current action name.
     *
     * @param string $name
     */
    public function setActionName($name)
    {
        $this->_actionName = $name;
    }

    /**
     * Gets param with given key.
     *
     * @return string|null
     */
    public function getParam($key)
    {
        if (isset($this->_params[$key])) {
            return $this->_params[$key];
        }

        return null;
    }

    /**
     * Sets the param with the given key / value.
     *
     * @param string $name
     * @param string $value
     */
    public function setParam($key, $value)
    {
        $this->_params[$key] = $value;
    }

    /**
     * Get all key/value params.
     *
     * @return array
     */
    public function getParams()
    {
        return $this->_params;
    }

    /**
     * Set key/value params.
     *
     * @param array $params
     */
    public function setParams($params)
    {
        $this->_params = $params;
    }

    /**
     * Checks if request is a POST - request.
     *
     * @return boolean
     */
    public function isPost()
    {
        return !empty($_POST);
    }

    /**
     * Get post-value by key.
     *
     * @param  string $key
     * @return mixed
     */
    public function getPost($key = '')
    {
        if ($key === '') {
            return $_POST;
        } elseif (isset($_POST[$key])) {
            return $_POST[$key];
        } else {
            return null;
        }
    }

    /**
     * Get get-value by key.
     *
     * @param  string $key
     * @return mixed
     */
    public function getQuery($key = '')
    {
        if ($key === '') {
            return $_GET;
        } elseif (isset($_GET[$key])) {
            return $_GET[$key];
        } else {
            return null;
        }
    }

    /**
     * Checks if request is secure.
     *
     * @return boolean
     */
    public function isSecure()
    {
        if (isset($_SESSION['token'][$this->getPost('ilch_token')])
               || isset($_SESSION['token'][$this->getParam('ilch_token')])) {
            return true;
        }

        return false;
    }
}
