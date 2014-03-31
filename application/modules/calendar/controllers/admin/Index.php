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
                    'name' => 'calendar_view',
                    'active' => true,
                    'icon' => 'fa fa-calendar',
                    'url' => $this->getLayout()->getUrl(array('controller' => 'index', 'action' => 'index'))
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
                'name' => 'menu_action_insert_calendar',
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
            $calendar->fill($item->getDateStart(),
                '<div align="center"><b>'.$item->getTitle().'</b></div>'.
                '<center>'.$item->getStart('H:i - ') . $item->getEnds('H:i').'</center>' 
            );
        }
        
        $this->getView()->set('calendar', $calendar);
    }
	
    public function treatAction($menu = array())
    {		
        $mapper = new \Calendar\Mappers\Calendar();
        
        if($this->getRequest()->isPost()) {
            
            $model = new \Calendar\Models\Calendar();
            
            if ($this->getRequest()->getParam('id')) {
                $model->setId($this->getRequest()->getParam('id'));
            }
            
            if(is_array($menu) && count($menu) > 0){
                $model->setModuleUrl($this->getLayout()->getUrl($menu));
            } else {
                $model->setModuleUrl($this->getLayout()->getUrl(
                    array(
                        'controller' => 'index',
                        'action' => 'details'
                    )
                ));
            }
            
            $cycle = $this->getRequest()->getPost('cycle');
            $date_start = $this->getRequest()->getPost('date_start');
            $date_ends = $this->getRequest()->getPost('date_ends');
            $time_start = $this->getRequest()->getPost('time_start');
            $time_ends = $this->getRequest()->getPost('time_ends');
            
            $organizer = $this->getRequest()->getPost('organizer');
            $title = $this->getRequest()->getPost('title');
            $message = $this->getRequest()->getPost('message');
            
            $array = array();
                       
            if( empty($cycle) ) {
                $this->addMessage('missing_cycle', 'danger');
            } elseif(empty($date_start)) {
                $this->addMessage('missing_date_start', 'danger');
            } elseif(empty($date_ends)) {
                $this->addMessage('missing_date_ends', 'danger');
            } elseif(empty($time_start)) {
                $this->addMessage('missing_time_start', 'danger');
            } elseif(empty($time_ends)) {
                $this->addMessage('missing_time_ends', 'danger');
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
                $model->setTimeStart($time_start);
                $model->setTimeEnds($time_ends);
                
                $model->setTitle($title);
                $model->setOrganizer($organizer);
                $model->setMessage($message);
                
                $mapper->save($this, $model);
                
                $this->addMessage('calendar_save_success');
                
                $this->redirect(array(
                    'controller' => $this->getRequest()->getControllerName(),
                    'action' => 'index'
                ));
            }
        }

        if ($ItemId = $this->getRequest()->getParam('id')) {
            $this->getView()->set('item', $mapper->getCalendarById($ItemId) );
        }
        
    }
	
}
?>