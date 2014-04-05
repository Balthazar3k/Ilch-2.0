<?php
/**
 * @copyright Balthazar3k 2014
 * @package Calendar 1.0
 * 
 */

namespace Calendar\Controllers\Admin;

defined('ACCESS') or die('no direct access');

class Index extends \Ilch\Controller\Admin
{

    public function init()
    {
        $this->getLayout()->addMenu
        (
            'calendar',
            array
            (
                array
                (
                    'name' => 'calendar_view',
                    'active' => true,
                    'icon' => 'fa fa-calendar',
                    'url' => $this->getLayout()->getUrl(array('controller' => 'index', 'action' => 'index'))
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
        $viewDate = $this->getRequest()->getParam('date');
        $calendar = new \Calendar\Plugins\Calendar($this);
        $calendar->viewDate($viewDate);
        
        $mapper = new \Calendar\Mappers\Calendar();
        $calendarItems = $mapper->getCalendar(
            $calendar->where('date_start', 'Y-m-d H:i:s')
        );
        
        foreach( $calendarItems as $item){
            $calendar->fill($item->getDateStart(),
                '<a href="'.$this->getLayout()->getUrl(array('action' => 'series', 'id' => $item->getId(), 'date' => $viewDate)).'">'.
                    '<div align="center"><b>'.$item->getTitle().'</b></div>'.
                    '<center>'.$item->getStart('H:i - ') . $item->getEnds('H:i').'</center>'.
                '</a>'
            );
        }
        
        $this->getView()->set('calendar', $calendar);
    }
	
    public function treatAction()
    {		
        $mapper = new \Calendar\Mappers\Calendar();
        
        if($this->getRequest()->isPost()) {
            
            if( !$this->getRequest()->isSecure() ){
                return;
            }
            
            $model = new \Calendar\Models\Calendar();
            
            if ($this->getRequest()->getParam('id')) {
                $model->setId($this->getRequest()->getParam('id'));
            }
            
            $series = $this->getRequest()->getPost('series');
            $cycle = $this->getRequest()->getPost('cycle');
            $date_start = $this->getRequest()->getPost('date_start');
            $date_ends = $this->getRequest()->getPost('date_ends');
            $time_start = $this->getRequest()->getPost('time_start');
            $time_ends = $this->getRequest()->getPost('time_ends');
            
            $organizer = $this->getRequest()->getPost('organizer');
            $title = $this->getRequest()->getPost('title');
            $message = $this->getRequest()->getPost('message');
            
            $model->setSeries($series);
            $model->setCycle($cycle);
            $model->setDateStart($date_start);
            $model->setDateEnds($date_ends);
            $model->setTimeStart($time_start);
            $model->setTimeEnds($time_ends);

            $model->setTitle($title);
            $model->setOrganizer($organizer);
            $model->setMessage($message);
                                   
            $model->set_is_Series($this->getRequest()->getPost('is_series'));
            
            $this->getView()->set('item', $model );
                       
            if( empty($title) ) {
                $this->addMessage('missing_title', 'danger');
            } elseif( $cycle > 0 && empty($date_ends) ) {
                $this->addMessage('missing_date_ends', 'danger');
            } elseif(empty($date_start)) {
                $this->addMessage('missing_date_start', 'danger');
            } elseif(empty($time_start)) {
                $this->addMessage('missing_time_start', 'danger');
            } elseif(empty($time_ends)) {
                $this->addMessage('missing_time_ends', 'danger');
            } else {
                $mapper->save($this, $model);
                
                $this->addMessage('calendar_save_success');
                
                $this->redirect(array(
                    'controller' => $this->getRequest()->getControllerName(),
                    'action' => 'index'
                ));
            }
        }

        if ($ItemId = $this->getRequest()->getParam('id')) {
            $item = $mapper->getCalendarItem($ItemId);
            //func::dump($item);
            $item->set_is_Series($this->getRequest()->getParam('series'));
            $this->getView()->set('item', $item );
        }   
    }
    
    public function seriesAction(){
        if(empty($this->getRequest()->getParam('id'))){
            $this->redirect(array(
                'action' => 'index'
            ));
        }
        
        $mapper = new \Calendar\Mappers\Calendar();
        $item = $mapper->getCalendarItem($this->getRequest()->getParam('id'));
        
        $this->getView()->set('item', $item);
    }
    
    public function deleteAction()
    {
        $url = array();
        $by_id = (int) $this->getRequest()->getParam('d');
        $by_series = (int) $this->getRequest()->getParam('series');
        
        if( $by_series ){
            $where['series'] = $by_series;
            $msg = 'calendarSeries_delete_success';
            
            $url = array(
                'controller' => $this->getRequest()->getControllerName(),
                'action' => 'index'
            );
        } else {
            $where['id'] = $by_id;
            $msg = 'calendar_delete_success';
            
            $url = array(
                'controller' => $this->getRequest()->getControllerName(),
                'action' => 'series',
                'id' => $this->getRequest()->getParam('id'),
            );
        }
        
        $mapper = new \Calendar\Mappers\Calendar();
        if( $mapper->delete($where) ){
            $this->addMessage($msg);
        } else {
            $this->addMessage('calendar_delete_error', 'danger');
        }
        
        $this->redirect($url);
        
    }	
}
?>
