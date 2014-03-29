<?php
/**
 * @copyright Balthazar3k 2014
 * @package Calendar 1.0
 */

namespace Eventplaner\Controllers\Admin;

defined('ACCESS') or die('no direct access');

use Eventplaner\Mappers\Eventplaner as EventMapper;
use Eventplaner\Models\Eventplaner as EventModel;
use User\Mappers\User as UserMapper;

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
        $date = new \Ilch\Date();
        $eventMapper = new EventMapper();

        if( $status = $this->getRequest()->getParam('status') ){
            $status = array('status' => $status );
        }

        $pagination = new \Ilch\Pagination();
        $pagination->setRowsPerPage($this->getConfig()->get('event_admin_rowsperpage'));
        $pagination->setPage($this->getRequest()->getParam('page'));
        $this->getView()->set('config', $this->getConfig());
        $this->getView()->set('eventList', $eventMapper->getEventList($status, $pagination) );
        $this->getView()->set('pagination', $pagination);
    }
    
    public function calendarAction()
    {
        $calendar = new \Eventplaner\Plugins\Calendar($this);
        $calendar->setSize($this->getConfig()->get('event_calendar_size'))->view($this->getRequest()->getParam('date'));
        
        $mapper = new EventMapper();
        $events = $mapper->getEvents($calendar->where('start', 'Y-m-d H:i:s'));
        $status = json_decode($this->getConfig()->get('event_status'), true);
        
        foreach( $events as $event){
        
            $calendar->fill($event->getStart(), '
                <a href="'.$this->getLayout()->getUrl(array('action' => 'treat', 'id' => $event->getId())).'">
                    <div class="calendarView">
                        <div class="title">'.$event->getEvent().'</div>
                        <div class="status" style="'.$status[$event->getStatus()]['style'].'">'.
                            $this->getTranslator()->trans($status[$event->getStatus()]['status']).' '.
                            $event->numRegistrations().'/'.$event->getRegistrations().
                        '</div>
                        <div class="time">'.$event->getStartDate('H:i').' - '.$event->getEndsDate('H:i').'</time>
                    </div>
                </a>
            ');
        }
        
        $this->getView()->set('calendar', $calendar);
    }


    public function statusAction()
    {
        if( $this->getRequest()->getParam('status') &&
            $this->getRequest()->getParam('id'))
        {
            $model = new EventModel();
            $model->setId($this->getRequest()->getParam('id'));
            $model->setStatus($this->getRequest()->getParam('status'));
            
            $mapper = new EventMapper();
            $mapper->changeStatus($model);
            
            $this->addMessage('saveStatusSuccess'); 
            $this->redirect(array('action' => 'index', 'page' => $this->getRequest()->getParam('page')));
        }
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