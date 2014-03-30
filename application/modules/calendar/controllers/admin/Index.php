<?php
/**
 * @copyright Balthazar3k 2014
 * @package Calendar 1.0
 */

namespace Calendar\Controllers\Admin;

defined('ACCESS') or die('no direct access');


class Index extends \Ilch\Controller\Admin
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
                'name' => 'menuNewCalendarItem',
                'icon' => 'fa fa-plus-circle',
                'url' => $this->getLayout()->getUrl(array('controller' => 'index', 'action' => 'treat'))
            )
        );
    }
	
    public function indexAction()
    {
        $calendar = new \Calendar\Plugins\Calendar($this);
        $calendar->view($this->getRequest()->getParam('date'));
        
        $mapper = new \Calendar\Mappers\Calendar();
        $calendarItems = $mapper->getCalendar(
            $calendar->where('date_start', 'Y-m-d H:i:s')
        );
        
        foreach( $calendarItems as $item){
       
        }
        
        $this->getView()->set('calendar', $calendar);
    }
	
    public function treatAction()
    {		
        
        
        if($this->getRequest()->isPost()) {
        
            $mapper = new \Calendar\Mappers\Calendar();
            $model = new \Calendar\Models\Calendar();
            
            if ($this->getRequest()->getParam('id')) {
                $model->setId($this->getRequest()->getParam('id'));
            }
            
            
            $cycle = $this->getRequest()->getPost('cycle');
            $date_start = $this->getRequest()->getPost('date_start');
            $date_ends = $this->getRequest()->getPost('date_ends');

            $organizer = $this->getRequest()->getPost('organizer');
            $title = $this->getRequest()->getPost('title');
            $message = $this->getRequest()->getPost('message');
            
            $array = array();
           
            
            if( empty($cycle) ) {
                $this->addMessage('missing_cycle', 'danger');
            } elseif(empty($date_start)) {
                $this->addMessage('missing_start', 'danger');
            } elseif(empty($date_ends)) {
                $this->addMessage('missing_ends', 'danger');
            } elseif(empty($title)) {
                $this->addMessage('missing_title', 'danger');
            } elseif(empty($organizer)) {
                $this->addMessage('missing_organizer', 'danger');
            } elseif(empty($message)) {
                $this->addMessage('missing_message', 'danger');
            } else {

                $model->setCycle($cycle);
                $model->setDateStart($date_start);
                $model->setDateEnds($date_ends);
                
                $model->setTitle($title);
                $model->setOrganizer($organizer);
                $model->setMessage($message);
                
                $mapper->save($model);
                
                $this->addMessage('save_success');
                
                $this->redirect(array(
                    'controller' => $this->getRequest()->getControllerName(),
                    'action' => 'index'
                ));
            }
        }

        if ($evendId = $this->getRequest()->getParam('id')) {
            $this->getView()->set('event', $eventMapper->getEventById($evendId) );
        }
        
        $this->getView()->set('users', $user->getUserList(  ) );
    }
	
}
?>