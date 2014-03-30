<?php
/**
 * @copyright Balthazar3k 2014
 * @package Calendar 1.0
 */

namespace Calendar\Mappers;

use Calendar\Plugins\Functions as func;

defined('ACCESS') or die('no direct access');

class Calendar extends \Ilch\Mapper
{
    public function getCalendar($where = '')
    {

        $sql = ('
            SELECT 
                *
            FROM [prefix]_calendar
            '.$where.'
        ;');
        
        $entryArray = $this->db()->queryArray($sql);

        if (empty($entryArray)) {
            return array();
        }

        $entry = array();

        foreach ($entryArray as $res) {
            $model = new \Calendar\Models\Calendar();
            $model->setId($res['id']);
            $model->setModuleKey($res['module_key']);
            $model->setModuleUrl($res['module_url']);
            
            $model->setDateStart($res['date_start']);
            $model->setDateEnds($res['date_ends']);
            
            $model->setOrganizer($res['organizer']);
            $model->setTitle($res['title']);
            $model->setMessage($res['message']);
            
            $model->setArray($res['array']);
            
            $model->setCreated($res['created']);
            $model->setChanged($res['changed']);
            $model->setSeries($res['series']);
            $entry[] = $model;
        }   
        return $entry;
    }
	
    public function getCalendarItem($id)
    {   
        $res = $this->db()->selectRow('*')
                    ->from('ep_events')
                    ->where(array('id' => $eventId))
                    ->execute();

        if(empty($res)){
            return false;
        }

        
    }
	
    public function save($controller, \Calendar\Models\Calendar $model)
    {
        if( !is_object($controller) && empty($model->getModuleKey()) ){
            trigger_error('the methode save from Calendar, need the first Argument from Controller Object ($this)');
            return;
        } else {
            $model ->setModuleKey($controller->getRequest()->getControllerName());
        }
        
        $fields = array();
        
        $fields['module_key'] = $model->getModuleKey();
        $fields['module_url'] = $model->getModuleUrl();
        
        $fields['cycle'] = $model->getCycle();
        
        $dates = func::cycle(
            $model->getCycle(),
            $model->getDateStart(),
            $model->getDateEnds()
         );
        
        
        $fields['organizer'] = $model->getOrganizer();
        $fields['title'] = $model->getTitle();
        $fields['message'] = $model->getMessage();
        
        $fields['array'] = $model->getArray();
        
        $fields['created'] = $model->getCreated();
        $fields['changed'] = $model->getChanged();
        
        $CalendarItemId = (int)$this->db()->selectCell('id')
                ->from('calendar')
                ->where(array('id' => $model->getId()))
                ->execute();
        
        if($CalendarItemId) {
            $this->db()->update('calendar')
                ->fields($fields)
                ->where(array('id' => $CalendarItemId))
                ->execute();
        } else {
            
            if(is_array($dates)){
               
                $CalendarLastId = $this->db()->queryCell('
                    SELECT MAX(`id`) FROM `[prefix]_calendar`;
                ');
                
                $CalendarLastId++;
                
                $model->setSeries($CalendarLastId);
                $fields['series'] = $model->getSeries();
                
                foreach($dates[0] as $i => $date){
                    $fields['date_start'] = $date;
                    $fields['date_ends'] = $date[1][$i];
                    $this->db()->insert('calendar')
                        ->fields($fields)
                        ->execute();
                }
            }
            
        }
    }
}
?>