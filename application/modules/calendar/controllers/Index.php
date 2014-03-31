<?php
/**
 * @copyright Balthazar3k 2014
 * @package Calendar 1.0
 */
 
namespace Calendar\Controllers;

defined('ACCESS') or die('no direct access');


class Index extends \Ilch\Controller\Frontend
{
    public function indexAction()
    {
        $this->getLayout()->getHmenu()->add($this->getTranslator()->trans('calendar'), array('action' => 'index'));
        
        $calendar = new \Calendar\Plugins\Calendar($this);
        $calendar->view($this->getRequest()->getParam('date'));
        
        $mapper = new \Calendar\Mappers\Calendar();
        $calendarItems = $mapper->getCalendar(
            $calendar->where('date_start', 'Y-m-d H:i:s')
        );
        
        foreach( $calendarItems as $item){
            $calendar->fill($item->getDateStart(),
                '<a href="'.$item->getModuleUrl().'">'.
                    '<div align="center"><b>'.$item->getTitle().'</b></div>'.
                    '<center>'.$item->getStart('H:i - ') . $item->getEnds('H:i').'</center>'.
                '</a>'
            );
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