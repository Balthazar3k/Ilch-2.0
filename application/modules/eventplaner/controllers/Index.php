<?php
/**
 * @copyright Balthazar3k 2014
 * @package Eventplaner 2.0
 */
 
namespace Eventplaner\Controllers;
defined('ACCESS') or die('no direct access');

use Eventplaner\Mappers\Eventplaner as EventMapper;
use User\Mappers\User as UserMapper;

class Index extends \Ilch\Controller\Frontend
{
    public function indexAction()
    {    
        $this->getLayout()->getHmenu()->add($this->getTranslator()->trans('eventplaner'), array('action' => 'index'));
        
        $calendar = new \Eventplaner\Plugins\Calendar($this);
        $calendar->view($this->getRequest()->getParam('date'));
        
        $mapper = new EventMapper();
        $events = $mapper->getEvents($calendar->where('start', 'Y-m-d H:i:s'));
        
        $this->getView()->set('calendar', $calendar);
        $this->getView()->set('eventList', $events );
        $this->getView()->set('config', $this->getConfig());
    }
    
    public function calendarAction()
    {
        $this->getLayout()->getHmenu()->add($this->getTranslator()->trans('eventplaner'), array('action' => 'index'));
        
        $calendar = new \Eventplaner\Plugins\Calendar($this);
        $calendar->setSize($this->getConfig()->get('event_calendar_size'))->view($this->getRequest()->getParam('date'));
        
        $mapper = new EventMapper();
        $events = $mapper->getEvents($calendar->where('start', 'Y-m-d H:i:s'));
        $status = json_decode($this->getConfig()->get('event_status'), true);
        
        foreach( $events as $event ){
        
            $calendar->fill($event->getStart(), '
                <a title="Hallo" href="'.$this->getLayout()->getUrl(array('action' => 'details', 'id' => $event->getId())).'">
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
    
    public function detailsAction()
    {
        // Anmelden & Bearbeiten zu einem Event
        // Später muss noch eine Sicherheitsabfrage rein,
        // ob ein User sich überhaupt für einen Event Anmelden kann!
        if($this->getRequest()->isPost()){
            $reg = $this->getRequest()->getPost('eventRegistration');
            
            $model = new \Eventplaner\Models\Registrations();
            $model->setStatus($reg['status']);
            $model->setEid($this->getRequest()->getParam('id'));
            $model->setUid($reg['uid']);
            // Bei Cid erst mal Uid, da das Charakter Modul später kommt!
            $model->setCid($reg['uid']);
            $model->setComment($reg['comment']);
            
            if( $model->getStatus() ){
                $mapper = new \Eventplaner\Mappers\Registrations();
                $mapper->save($model);

                $this->addMessage('editSuccess');
                $this->redirect(array('action' => 'details', 'id' => $model->getEid()));
            }
        }
        
        $this->getLayout()->getHmenu()->add($this->getTranslator()->trans('eventplaner'), array('action' => 'index'));
        $this->getLayout()->getHmenu()->add($this->getTranslator()->trans('eventDetails'), array('action' => 'details', 'id' => $this->getRequest()->getParam('id')));
        
        $user = new UserMapper;
        $eventMapper = new EventMapper();
        
        if ($evendId = $this->getRequest()->getParam('id')) {
            $this->getView()->set('event', $eventMapper->getEventById($evendId) );
        }

        $this->getView()->set('users', $user->getUserList(  ) );
        $this->getView()->set('eventNames', $eventMapper->getEventNames() );
        $this->getView()->set('config', $this->getConfig());
    }
}
?>