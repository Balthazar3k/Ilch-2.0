<?php
/**
 * Holds Menu.
 *
 * @copyright Ilch 2.0
 * @package ilch
 */

namespace Admin\Mappers;
use Admin\Models\MenuItem;
use Admin\Models\Menu as MenuModel;
defined('ACCESS') or die('no direct access');

/**
 * The menu mapper class.
 *
 * @package ilch
 */
class Menu extends \Ilch\Mapper
{
    /**
     * Gets the menu id for the menu position.
     *
     * @param integer $position
     */
    public function getMenuIdForPosition($position)
    {
        $sql = 'SELECT id FROM [prefix]_menu
                ORDER BY id ASC
                LIMIT '.(int)($position-1).', 1';
        $id = $this->db()->queryCell($sql);

        return $id;
    }

    /**
     * Gets the menus.
     * 
     * @return \Admin\Models\Menu[]
     */
    public function getMenus()
    {
        $menus = array();
        $menuRows = $this->db()->selectArray
        (
            array('id'),
            'menu'
        );

        foreach ($menuRows as $menuRow) {
            $menu = $this->getMenu($menuRow['id']);
            $menus[] = $menu;
        }

        return $menus;
    }

    /**
     * Gets the menu for the given id.
     * 
     * @return \Admin\Models\Menu
     */
    public function getMenu($menuId)
    {
        $menu = new \Admin\Models\Menu();
        
        $menuRow = $this->db()->selectRow
        (
            array('id','title'),
            'menu',
            array('id' => $menuId)
        );

        $menu->setId($menuRow['id']);
        $menu->setTitle($menuRow['title']);

        return $menu;
    }

    /**
     * Gets all menu items by menu id.
     */
    public function getMenuItems($menuId)
    {
        $items = array();
        $itemRows = $this->db()->selectArray
        (
            '*',
            'menu_items',
            array
            (
                'menu_id' => $menuId,
            ),
            array('sort' => 'ASC')
        );

        if (empty($itemRows)) {
            return null;
        }

        foreach ($itemRows as $itemRow) {
            $itemModel = new MenuItem();
            $itemModel->setId($itemRow['id']);
            $itemModel->setType($itemRow['type']);
            $itemModel->setSiteId($itemRow['page_id']);
            $itemModel->setBoxId($itemRow['box_id']);
            $itemModel->setBoxKey($itemRow['box_key']);
            $itemModel->setHref($itemRow['href']);
            $itemModel->setTitle($itemRow['title']);
            $itemModel->setParentId($itemRow['parent_id']);
            $itemModel->setModuleKey($itemRow['module_key']);
            $itemModel->setMenuId($menuId);
            $items[] = $itemModel;
        }

        return $items;
    }

    /**
     * Gets all menu items by parent item id.
     */
    public function getMenuItemsByParent($menuId, $itemId)
    {
        $items = array();
        $itemRows = $this->db()->selectArray
        (
            '*',
            'menu_items',
            array
            (
                'menu_id' => $menuId,
                'parent_id' => $itemId
            ),
            array('sort' => 'ASC')
        );

        if (empty($itemRows)) {
            return null;
        }

        foreach ($itemRows as $itemRow) {
            $itemModel = new MenuItem();
            $itemModel->setId($itemRow['id']);
            $itemModel->setType($itemRow['type']);
            $itemModel->setSiteId($itemRow['page_id']);
            $itemModel->setBoxId($itemRow['box_id']);
            $itemModel->setBoxKey($itemRow['box_key']);
            $itemModel->setHref($itemRow['href']);
            $itemModel->setTitle($itemRow['title']);
            $itemModel->setModuleKey($itemRow['module_key']);
            $itemModel->setParentId($itemId);
            $itemModel->setMenuId($menuId);
            $items[] = $itemModel;
        }

        return $items;
    }

    /**
     * Save one menu item.
     *
     * @param  MenuItem $menuItem
     * @return integer
     */
    public function saveItem(MenuItem $menuItem)
    {
        $fields = array
        (
            'href' => $menuItem->getHref(),
            'title' => $menuItem->getTitle(),
            'menu_id' => $menuItem->getMenuId(),
            'sort' => $menuItem->getSort(),
            'parent_id' => $menuItem->getParentId(),
            'page_id' => $menuItem->getSiteId(),
            'box_id' => $menuItem->getBoxId(),
            'box_key' => $menuItem->getBoxKey(),
            'type' => $menuItem->getType(),
            'module_key' => $menuItem->getModuleKey(),
        );

        foreach ($fields as $key => $value) {
            if ($value === null) {
                unset($fields[$key]);
            }
        }

        $itemId = (int)$this->db()->selectCell('id')
            ->from('menu_items')
            ->where(array('id' => $menuItem->getId()))
            ->execute();

        if ($itemId) {
            $this->db()->update('menu_items')
                ->fields($fields)
                ->where(array('id' => $itemId))
                ->execute();
        } else {
            $itemId = $this->db()->insert('menu_items')
                ->fields($fields)
                ->execute();
        }

        return $itemId;
    }
    
    /**
     * Save one menu.
     *
     * @param MenuModel $menu
     * @return integer
     */
    public function save(MenuModel $menu)
    {
        $menuId = (int)$this->db()->selectCell('id')
            ->from('menu')
            ->where(array('id' => $menu->getId()))
            ->execute();

        if ($menuId) {
            $this->db()->update('menu')
                ->fields(array('title' => $menu->getTitle()))
                ->where(array('id' => $menuId))
                ->execute();
        } else {
            $menuId = $this->db()->insert('menu')
                ->fields(array('title' => $menu->getTitle()))
                ->execute();
        }

        return $menuId;
    }
 
    /**
     * Delete the given menu item.
     *
     * @param  MenuItem $menuItem
     */
    public function deleteItem($menuItem)
    {
        $this->db()->delete('menu_items')
            ->where(array('id' => $menuItem->getId()))
            ->execute();
    }

    /**
     * Delete the given menu.
     *
     * @param integer $id
     */
    public function delete($id)
    {
        $this->db()->delete('menu')
            ->where(array('id' => $id))
            ->execute();
    }
}
