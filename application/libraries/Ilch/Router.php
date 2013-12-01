<?php
/**
 * @author Meyer Dominik
 * @copyright Ilch 2.0
 * @package ilch
 */

namespace Ilch;
defined('ACCESS') or die('no direct access');

class Router
{
    /**
     * Injects request.
     *
     * @param Ilch_Request $request
     */
    public function __construct(Request $request)
    {
        $this->_request = $request;
    }

    public function getQuery()
    {
        return $this->_query;
    }

    /**
     * Fills the request object with the best matched route.
     */
    public function execute()
    {
        $query = substr($_SERVER['REQUEST_URI'], strlen(REWRITE_BASE));
        $query = str_replace('index.php/', '', $query);
        $query = trim(str_replace('index.php', '', $query), '/');
        $this->_query = $query;

        $this->_request->setModuleName(DEFAULT_MODULE);
        $this->_request->setControllerName('index');
        $this->_request->setActionName('index');

        if (!empty($query)) {
            $this->_executeRewrite($query);
        }
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

        if (strpos($startPage, 'module_') !== false) {
            $this->_request->setModuleName(str_replace('module_', '', $startPage));
            $this->_request->setControllerName('index');
            $this->_request->setActionName('index');
        } elseif (strpos($startPage, 'page_') !== false) {
            $this->_request->setModuleName('page');
            $this->_request->setControllerName('index');
            $this->_request->setActionName('show');
            $this->_request->setParam('id', str_replace('page_', '', $startPage));
            $this->_request->setParam('locale', $translator->getLocale());
        } else {
            $this->_request->setModuleName(DEFAULT_MODULE);
            $this->_request->setControllerName('index');
            $this->_request->setActionName('index');
        }

    }

    /**
     * Fills the request object if rewrite is possible.
     *
     * @param string $query
     */
    protected function _executeRewrite($query)
    {
        $queryParts = explode('/', $query);

        $i = 0;

        if ($queryParts[0] == 'admin') {
            $this->_request->setIsAdmin(true);
            unset($queryParts[0]);
            $i = 1;
        }

        if (isset($queryParts[$i])) {
            $this->_request->setModuleName($queryParts[$i]);
            unset($queryParts[$i]);
        }

        $i++;

        if (isset($queryParts[$i])) {
            $this->_request->setControllerName($queryParts[$i]);
            unset($queryParts[$i]);
        }

        $i++;

        if (isset($queryParts[$i])) {
            $this->_request->setActionName($queryParts[$i]);
            unset($queryParts[$i]);
        }

        if (!empty($queryParts)) {
            $paramKey = $paramValue = '';

            foreach ($queryParts as $value) {
                if (!empty($paramKey)) {
                    $this->_request->setParam($paramKey, $value);
                    $paramKey = '';
                }

                $paramKey = $value;
            }
        }
    }
}
