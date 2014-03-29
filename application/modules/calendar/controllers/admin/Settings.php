<?php
/**
 * @copyright Balthazar3k 2014
 * @package Calendar 1.0
 */

namespace Eventplaner\Controllers\Admin;

defined('ACCESS') or die('no direct access');

class Settings extends \Ilch\Controller\Admin 
{
    public function init()
    {
        $this->getLayout()->addMenu
        (
            'eventplaner',
            array
            (
                array
                (
                    'name' => 'listView',
                    'active' => true,
                    'icon' => 'fa fa-th-list',
                    'url' => $this->getLayout()->getUrl(array('controller' => 'index', 'action' => 'index'))
                ),array
                (
                    'name' => 'calendarView',
                    'active' => true,
                    'icon' => 'fa fa-calendar',
                    'url' => $this->getLayout()->getUrl(array('controller' => 'index', 'action' => 'calendar'))
                ),array
                (
                    'name' => 'settings',
                    'active' => true,
                    'icon' => 'fa fa-cogs',
                    'url'  => $this->getLayout()->getUrl(array('controller' => 'settings', 'action' => 'index'))
                )
                
            )
        );
        
        $this->getLayout()->addMenuAction
        (
            array
            (
                'name' => 'menuActionNewEvent',
                'icon' => 'fa fa-plus-circle',
                'url' => $this->getLayout()->getUrl(array('controller' => 'index', 'action' => 'treat'))
            )
        );
    }
    
    public function indexAction() 
    {
        if ($this->getRequest()->isPost()) {
            
            $config = $this->getRequest()->getPost('eventConfig');
            $status = $this->getRequest()->getPost('statusConfig');
            
            foreach($config as $key => $value){
                $this->getConfig()->set($key, $value);
            }
            
            $this->getConfig()->set('event_status', json_encode($status, true));
            
            $this->addMessage('saveSuccess');
            $this->redirect(array('action' => 'index'));
        }
        
        $this->getView()->set('config', $this->getConfig());
    }
}
