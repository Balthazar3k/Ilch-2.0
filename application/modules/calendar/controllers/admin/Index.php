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
        ?><pre><?php
        print_r($this->getRequest()->getParam('controller'));
        ?></pre><?php
        
        $calendar = new \Calendar\Plugins\Calendar($this);
        $calendar->view($this->getRequest()->getParam('date'));
        
        $mapper = new \Calendar\Mappers\Calendar();
        $calendarItems = $mapper->getCalendar($calendar->where('date_start', 'Y-m-d H:i:s'));
        
        foreach( $calendarItems as $item){
        
  
        }
        
        $this->getView()->set('calendar', $calendar);
    }
	
    public function treatAction()
    {		
        $user = new UserMapper;
        $eventMapper = new EventMapper();
        
        if($this->getRequest()->isPost()) {
            $model = new EventModel();
            
            if ($this->getRequest()->getParam('id')) {
                $model->setId($this->getRequest()->getParam('id'));
            }
            
            $status = $this->getRequest()->getPost('status');
            $start = $this->getRequest()->getPost('start');
            $ends = $this->getRequest()->getPost('ends');
            $registrations = $this->getRequest()->getPost('registrations');
            $organizer = $this->getRequest()->getPost('organizer');
            $event = $this->getRequest()->getPost('event');
            
            if(!empty($this->getRequest()->getPost('newEvent'))){
                $event = $this->getRequest()->getPost('newEvent');
            }
            
            if($status == '') {
                $this->addMessage('missingStatus', 'danger');
            } elseif(empty($start)) {
                $this->addMessage('missingStart', 'danger');
            } elseif(empty($ends)) {
                $this->addMessage('missingEnds', 'danger');
            } elseif(empty($registrations)) {
                $this->addMessage('missingRegistrations', 'danger');
            } elseif($organizer == 0) {
                $this->addMessage('missingOrganizer', 'danger');
            } elseif(empty($event)) {
                $this->addMessage('missingEvent', 'danger');
            } else {

                $model->setStatus($status);
                $model->setStart($start);
                $model->setEnds($ends);
                $model->setRegistrations($registrations);
                $model->setOrganizer($organizer);
                $model->setEvent($event);
                $model->setTitle($this->getRequest()->getPost('title'));
                $model->setMessage($this->getRequest()->getPost('message'));
                $eventMapper->save($model);
                
                $this->addMessage('saveSuccess');
                
                $this->redirect(array('action' => 'index'));
            }
        }

        if ($evendId = $this->getRequest()->getParam('id')) {
            $this->getView()->set('event', $eventMapper->getEventById($evendId) );
        }
        
        $this->getView()->set('users', $user->getUserList(  ) );
        $this->getView()->set('status', json_decode($this->getConfig()->get('event_status'), true) );
        $this->getView()->set('eventNames', $eventMapper->getEventNames() );
        $this->getView()->set('config', $this->getConfig());
    }
	
}
?>