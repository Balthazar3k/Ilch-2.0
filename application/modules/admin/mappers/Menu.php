<?php
/**
 * Holds Menu.
 *
 * @author Meyer Dominik
 * @copyright Ilch 2.0
 * @package ilch
 */

namespace Admin\Mappers;
use Admin\Models\Menu as MenuModel;
defined('ACCESS') or die('no direct access');

/**
 * The menu mapper class.
 *
 * @author Meyer Dominik
 * @package ilch
 */
class Menu extends \Ilch\Mapper
{
	/**
	 * Gets all menus.
	 *
	 * @return null|MenuModel[]
	 */
	public function getMenus()
	{
		$menus = array();
		$menusRows = $this->getDatabase()->selectArray
		(
			'*',
			'menus'
		);
		
		if(empty($menusRows))
		{
			return null;
		}
		
		foreach($menusRows as $menuRow)
		{
			$menuModel = new MenuModel();
			$menuModel->setId($menuRow['id']);
			$menuModel->setContent($menuRow['content']);
			$menus[] = $menuModel;
		}

		return $menus;
	}

	public function save()
	{
	}
}