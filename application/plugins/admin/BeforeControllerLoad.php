<?php
/**
 * Holds Admin_BeforeControllerLoadPlugin.
 *
 * @author Jainta Martin
 * @copyright Ilch CMS 2.0
 * @package ilch
 */

defined('ACCESS') or die('no direct access');

/**
 * Does admin operations before the controller loads.
 *
 * @author  Martin Jainta
 * @copyright Ilch CMS 2.0
 * @package ilch
 */
class Admin_BeforeControllerLoadPlugin
{
	/**
	 * Redirects the user to the admin login page, if the user is not logged in, yet.
	 */
	public function __construct(array $pluginData)
	{
		$request = $pluginData['request'];

		if($request->getModuleName() == 'admin' && $request->getControllerName() !== 'login' && !Ilch_Registry::get('user'))
		{
			$pluginData['controller']->redirect(array('module' => 'admin', 'controller' => 'login'));
		}
	}
}