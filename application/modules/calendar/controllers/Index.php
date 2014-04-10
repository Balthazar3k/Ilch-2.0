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
        $calendar->viewDate($this->getRequest()->getParam('date'));
        
        $mapper = new \Calendar\Mappers\Calendar();
        $calendarItems = $mapper->getCalendar(
            $calendar->where('date_start', 'Y-m-d H:i:s', 0)
        );
        
        foreach( $calendarItems as $item){
            $calendar->fill($item->getDateStart(),
                '<a href="'.$this->getLayout()->getUrl(array('action' => 'details', 'id' => $item->getId())).'">
                    <div class="calendar-day-title" align="center">
                        <b>'.substr($item->getTitle(), 0, 10).'</b>'
                        .( $item->getMessage() != '' ? ' <i class="fa fa-comment"></i>' : '').
                        '<br />'
                        .$item->getStart('H:i - ') . $item->getEnds('H:i') .'
                    </div>
                </a>'
            );
        }
        
        $this->getView()->set('calendar', $calendar);
    }
    
    public function detailsAction()
    {
        if(empty($this->getRequest()->getParam('id'))){
            $this->redirect(array(
                'action' => 'index'
            ));
        }
        
        $mapper = new \Calendar\Mappers\Calendar();
        $item = $mapper->getCalendarItem($this->getRequest()->getParam('id'));
        
        $this->getLayout()->getHmenu()->add($this->getTranslator()->trans('calendar'), array('action' => 'index'));
        $this->getLayout()->getHmenu()->add($this->getTranslator()->trans('hmenu_details', $item->getTitle()), array('action' => 'details', 'id' => $this->getRequest()->getParam('id')));
       
        $this->getView()->set('item', $item);
    }
    
    public function listAction()
    {
        $this->getLayout()->getHmenu()->add($this->getTranslator()->trans('calendar'), array('action' => 'index'));
        
        $calendar = new \Calendar\Plugins\Calendar($this);
        $calendar->viewDate($this->getRequest()->getParam('date'));
        
        $mapper = new \Calendar\Mappers\Calendar();
        $calendarItems = $mapper->getCalendar(
            $calendar->where('date_start', 'Y-m-d H:i:s', 1)
        );
        
        $this->getView()->set('calendar', $calendar);
        $this->getView()->set('items', $calendarItems);
    }
}
?>
