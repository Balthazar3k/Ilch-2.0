<?php
/**
 * @author Meyer Dominik
 * @copyright Ilch 2.0
 * @package ilch
 */

namespace Ilch\Layout;
defined('ACCESS') or die('no direct access');

class Admin extends Base
{
    /**
     * @var array
     */
    private $_menus = array();

    /**
     * @var array
     */
    private $_menuActions = array();

    /**
     * @var boolean
     */
    private $_showSidebar = true;

    /**
     * @return array
     */
    public function getMenus()
    {
        return $this->_menus;
    }

    /**
     * Add menu to layout.
     *
     * @param string $headKey
     * @param array  $items
     */
    public function addMenu($headKey, $items)
    {
        $this->_menus[$headKey] = $items;
     }

    /**
     * Add menu action to layout.
     *
     * @param array $actionArray
     */
    public function addMenuAction($actionArray)
    {
        $this->_menuActions[] = $actionArray;
    }

    /**
     * @return array
     */
    public function getMenuAction()
    {
        return $this->_menuActions;
    }

    /**
     * Removes sidebar on the left side.
     */
    public function removeSidebar()
    {
        $this->_showSidebar = false;
    }

    /**
     * Defines if sidebar is shown or not.
     *
     * @return boolean
     */
    public function hasSidebar()
    {
        return (bool)$this->_showSidebar;
    }
}
