<?php
/**
 * @author Meyer Dominik
 * @copyright Ilch CMS 2.0
 * @package ilch
 */

defined('ACCESS') or die('no direct access');

class Install_IndexController extends Ilch_Controller
{
	public function init()
	{
		if(isset($_SESSION['language']))
		{
			$this->getTranslator()->setLocale($_SESSION['language']);
		}

		$menu = array
		(
			'index' => array
			(
				'langKey' => 'menuWelcomeAndLanguage'
			),
			'license' => array
			(
				'langKey' => 'menuLicence'
			),
			'systemcheck' => array
			(
				'langKey' => 'menuSystemCheck'
			),
			'database' => array
			(
				'langKey' => 'menuDatabase'
			),
			'config' => array
			(
				'langKey' => 'menuConfig'
			),
			'finish' => array
			(
				'langKey' => 'menuFinish'
			),
		);

		foreach($menu as $key => $values)
		{
			if($this->getRequest()->getActionName() === $key)
			{
				break;
			}

			$menu[$key]['done'] = true;
		}

		$this->getLayout()->menu = $menu;
	}

	public function indexAction()
	{
		$languages = array
		(
			'en_EN' => 'English',
			'de_DE' => 'German'
		);

		$this->getView()->languages = $languages;
		$local = $this->getRequest()->getQuery('language');

		if($local)
		{
			$this->getTranslator()->setLocale($local);
			$_SESSION['language'] = $local;
		}

		if($this->getRequest()->isPost())
		{
			$this->redirect(array('module' => 'install', 'action' => 'license'));
		}
	}

	public function licenseAction()
	{
		$this->getView()->licenceText = file_get_contents(APPLICATION_PATH.'/../licence.txt');

		if($this->getRequest()->isPost())
		{
			if($this->getRequest()->getPost('licenceAccepted'))
			{
				$this->redirect(array('module' => 'install', 'action' => 'systemcheck'));
			}
			else
			{
				$this->getView()->error = true;
			}
		}
	}

	public function systemcheckAction()
	{
		$errors = array();
		$this->getView()->phpVersion = phpversion();

		if(!version_compare(phpversion(), '5.3.0', '>'))
		{
			$errors['version'] = true;
		}

		if(!is_writable(CONFIG_PATH))
		{
			$errors['writableConfig'] = true;
		}

		if(!is_writable(APPLICATION_PATH.'/../.htaccess'))
		{
			$errors['writableHtaccess'] = true;
		}

		if($this->getRequest()->isPost() && empty($errors))
		{
			$this->redirect(array('module' => 'install', 'action' => 'database'));
		}
	}

	public function databaseAction()
	{
		$errors = array();

		if($this->getRequest()->isPost())
		{
			$_SESSION['install']['dbEngine'] = $this->getRequest()->getPost('dbEngine');
			$_SESSION['install']['dbHost'] = $this->getRequest()->getPost('dbHost');
			$_SESSION['install']['dbUser'] = $this->getRequest()->getPost('dbUser');
			$_SESSION['install']['dbPassword'] = $this->getRequest()->getPost('dbPassword');
			$_SESSION['install']['dbName'] = $this->getRequest()->getPost('dbName');
			$_SESSION['install']['dbPrefix'] = $this->getRequest()->getPost('dbPrefix');

			$ilch = new Ilch_Database_Factory();
			$db = $ilch->getInstanceByEngine($this->getRequest()->getPost('dbEngine'));
			$dbConnect = $db->connect($this->getRequest()->getPost('dbHost'), $this->getRequest()->getPost('dbUser'), $this->getRequest()->getPost('dbPassword'));

			if(!$dbConnect)
			{
				$errors['dbConnection'] = true;
			}

			if($dbConnect && !$db->setDatabase($this->getRequest()->getPost('dbName')))
			{
				$errors['dbDatabase'] = true;
			}

			if(empty($errors))
			{
				$this->redirect(array('module' => 'install', 'action' => 'config'));
			}

			$this->getView()->errors = $errors;
		}

		foreach(array('dbHost', 'dbUser', 'dbPassword', 'dbName', 'dbPrefix') as $name)
		{
			if(!empty($_SESSION['install'][$name]))
			{
				$this->getView()->$name = $_SESSION['install'][$name];
			}
		}
	}

	public function configAction()
	{
		if($this->getRequest()->isPost())
		{
			$cmsType = $this->getRequest()->getPost('cmsType');
			$config = new Ilch_Config();
			$config->setConfig('dbEngine', $_SESSION['install']['dbEngine']);
			$config->setConfig('dbHost', $_SESSION['install']['dbHost']);
			$config->setConfig('dbUser', $_SESSION['install']['dbUser']);
			$config->setConfig('dbPassword', $_SESSION['install']['dbPassword']);
			$config->setConfig('dbName', $_SESSION['install']['dbName']);
			$config->setConfig('dbPrefix', $_SESSION['install']['dbPrefix']);
			$config->saveConfigToFile(CONFIG_PATH.'/config.php');

			$dbFactory = new Ilch_Database_Factory();
			$db = $dbFactory->getInstanceByConfig($config);

			$sqlString = file_get_contents(__DIR__.'/../files/install_general.sql');
			$queryParts = explode(';', $sqlString);

			foreach($queryParts as $query)
			{
				$db->query($query);
			}

			unset($_SESSION['install']);

			$this->redirect(array('module' => 'install', 'action' => 'finish'));
		}
	}

	public function finishAction()
	{
	}
}