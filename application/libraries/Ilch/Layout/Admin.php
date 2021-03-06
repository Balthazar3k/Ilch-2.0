<?php
/**
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
    private $menus = array();

    /**
     * @var array
     */
    private $menuActions = array();

    /**
     * @var boolean
     */
    private $showSidebar = true;

    /**
     * @return array
     */
    public function getMenus()
    {
        return $this->menus;
    }

    /**
     * Add menu to layout.
     *
     * @param string $headKey
     * @param array  $items
     */
    public function addMenu($headKey, $items)
    {
        $this->menus[$headKey] = $items;
     }

    /**
     * Add menu action to layout.
     *
     * @param array $actionArray
     */
    public function addMenuAction($actionArray)
    {
        $this->menuActions[] = $actionArray;
    }

    /**
     * @return array
     */
    public function getMenuAction()
    {
        return $this->menuActions;
    }

    /**
     * Removes sidebar on the left side.
     */
    public function removeSidebar()
    {
        $this->showSidebar = false;
    }

    /**
     * Defines if sidebar is shown or not.
     *
     * @return boolean
     */
    public function hasSidebar()
    {
        return (bool)$this->showSidebar;
    }
}
