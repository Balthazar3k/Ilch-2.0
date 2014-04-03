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
            
            $model->setCycle($res['cycle']);
            $model->setDateStart($res['date_start']);
            $model->setDateEnds($res['date_ends']);
            
            $model->setOrganizer($res['organizer']);
            $model->setTitle($res['title']);
            $model->setMessage($res['message']);
            
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
                    ->from('calendar')
                    ->where(array('id' => $id))
                    ->execute();

        if(empty($res)){
            return false;
        }
        
        $model = new \Calendar\Models\Calendar();
        $model->setId($res['id']);
        $model->setModuleKey($res['module_key']);
        $model->setModuleUrl($res['module_url']);

        $model->setCycle($res['cycle']);
        $model->setDateStart($res['date_start']);
        $model->setDateEnds($res['date_ends']);

        $model->setOrganizer($res['organizer']);
        $model->setTitle($res['title']);
        $model->setMessage($res['message']);

        $model->setCreated($res['created']);
        $model->setChanged($res['changed']);
        $model->setSeries($res['series']);

        return $model;
    }
    
    public function getCalendarSeries($series)
    {

        $entryArray = $this->db()->selectArray('*')
                ->from('calendar')
                ->where(array('series' => $series))
                ->execute();

        if (empty($entryArray)) {
            return array();
        }

        $entry = array();

        foreach ($entryArray as $res) {
            $model = new \Calendar\Models\Calendar();
            $model->setId($res['id']);
            $model->setModuleKey($res['module_key']);
            $model->setModuleUrl($res['module_url']);
            
            $model->setCycle($res['cycle']);
            $model->setDateStart($res['date_start']);
            $model->setDateEnds($res['date_ends']);
            
            $model->setOrganizer($res['organizer']);
            $model->setTitle($res['title']);
            $model->setMessage($res['message']);
            
            $model->setCreated($res['created']);
            $model->setChanged($res['changed']);
            $model->setSeries($res['series']);
            $entry[] = $model;
        }   

        return $entry;
    }
	
	
    public function save($controller, \Calendar\Models\Calendar $model)
    {
        if( !is_object($controller) && empty($model->getModuleKey()) ){
            exit('1 Argument from Calendar->save need the $this from controller!');
            return;
        } else {
            $model ->setModuleKey($controller->getRequest()->getModuleName());
            unset($controller);
        }
        
        $fields = array();
        
        $fields['module_key'] = $model->getModuleKey();
    
        $fields['organizer'] = $model->getOrganizer();
        $fields['title'] = $model->getTitle();
        $fields['message'] = $model->getMessage();
        
        func::ar($_POST, $model); exit();
               
        if( $model->is_Series() ){
            $this->db()->query('
                DELETE FROM `[prefix]_calendar` WHERE `series`=\''.$model->getSeries().'\';
            ');

            $CalendarLastId = $this->db()->queryCell('
                SELECT MAX(`id`) FROM `[prefix]_calendar`;
            ');

            $CalendarLastId++;

            $model->setSeries($CalendarLastId);
            $fields['series'] = $model->getSeries();
            $fields['cycle'] = $model->getCycle();
            
            $dates = func::cycle(
                $model->getCycle(),
                $model->getStartTimestamp(),
                $model->getEndsTimestamp()
             );

            foreach($dates[0] as $i => $date){
                $fields['date_start'] = $date . ' ' . $model->getTimeStart();
                $fields['date_ends'] = $date . ' ' . $model->getTimeEnds();

                $this->db()->insert('calendar')
                    ->fields($fields)
                    ->execute();
            }
        } else {
            $fields['date_start'] = $model->getDateStart() . ' ' . $model->getTimeStart();
            $fields['date_ends'] = $model->getDateEnds() . ' ' . $model->getTimeEnds();
            
            $this->db()->update('calendar')
                    ->fields($fields)
                    ->where(array( 'id' => $model->getId() ))
                    ->execute();
        }  
    }
    
    public function getSeries($id){
        return $this->db()->queryCell('
            SELECT `series` FROM `[prefix]_calendar` WHERE `id`=\''.$id.'\';
        ');
    }
    
    public function getSeriesMax($id){
        return strtotime($this->db()->queryCell('
            SELECT MAX(`date_start`) FROM `[prefix]_calendar` WHERE `series`=\''.$id.'\';
        '));
    }
    
    public function getSeriesMin($id){
        return strtotime($this->db()->queryCell('
            SELECT MIN(`date_start`) FROM `[prefix]_calendar` WHERE `series`=\''.$id.'\';
        '));
    }
}
?>