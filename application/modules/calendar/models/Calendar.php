<?php
/**
 * @copyright Balthazar3k 2014
 * @package Calendar 1.0
 */
namespace Calendar\Models;

defined('ACCESS') or die('no direct access');

class Calendar extends \Ilch\Model
{

    protected $_id;
    protected $_moduleKey;
    protected $_moduleUrl;
    protected $_cycle;
    protected $_weekdays;
    protected $_timeStart;
    protected $_timeEnds;
    protected $_dateStart;
    protected $_dateEnds;
    protected $_organizer;
    protected $_title;
    protected $_message;
    protected $_created;
    protected $_changed;
    protected $_series;

	
    public function getId()
    {
        return $this->_id;
    }
    
    public function setId($res)
    {
        $this->_id = (int) $res;
    }
    
    public function getModuleKey()
    {
        return $this->_moduleKey;
    }
    
    public function setModuleKey($res)
    {
        $this->_moduleKey = (string) $res;
    }
    
    public function getModuleUrl()
    {
        return $this->_moduleUrl;
    }
    
    public function setModuleUrl($res)
    {
        $this->_moduleUrl = (string) $res;
    }
    
    public function getCycle()
    {
        return $this->_cycle;
    }
    
    public function setCycle($res)
    {
        $this->_cycle = (int) $res;
    }
    
    public function getWeekdays()
    {
        return json_decode($this->_weekdays);
    }
    
    public function getWeekdaysString()
    {
        return $this->_weekdays;
    }
    
    public function setWeekdays($res)
    {
        if( is_array($res) ){
            $this->_weekdays = json_encode($res);
        } else {
            $this->_weekdays = (string) $res;
        }
    }

    public function getDateStart()
    {
        return $this->_dateStart;
    }
    
    public function setDateStart($res)
    {
        $this->_dateStart = (string) $res;
    }
	
    public function getDateEnds()
    {
        return $this->_dateEnds;
    }
    
    public function setDateEnds($res)
    {
        $this->_dateEnds = (string) $res;
    }
    
    public function getTimeStart()
    {
        return $this->_timeStart;
    }
    
    public function setTimeStart($res)
    {
        $this->_timeStart = (string) $res;
    }
	
    public function getTimeEnds()
    {
        return $this->_timeEnds;
    }
    
    public function setTimeEnds($res)
    {
        $this->_timeEnds = (string) $res;
    }
	
    public function getOrganizer()
    {
        return $this->_organizer;
    }
    
    public function setOrganizer($res)
    {
        $this->_organizer = (integer)$res;
    }

    public function getTitle()
    {
        return $this->_title;
    }
    
    public function setTitle($res)
    {
        $this->_title = (string)$res;
    }
	
    public function getMessage()
    {
        return $this->_message;
    }
    
    public function setMessage($res)
    {
        $this->_message = (string)$res;
    }
	
    public function getCreated()
    {
        return $this->_created;
    }
    
    public function setCreated($res)
    {
        $this->_created = (string)$res;
    }
	
    public function getChanged()
    {
        return $this->_changed;
    }
    
    public function setChanged($res)
    {
        $this->_changed = (string)$res;
    }
    
    public function getSeries()
    {
        return $this->_series;
    }
    
    public function setSeries($res)
    {
        $this->_series = (int) $res;
    }
    
    public function getStartTimestamp()
    {
        return strtotime($this->_dateStart);
    }
    
    public function getStart($format = 'd.m.Y H:i')
    {
        return date($format, $this->getStartTimestamp());
    }
    
    public function getEndsTimestamp()
    {
        return strtotime($this->_dateEnds);
    }
    
    public function getEnds($format = 'd.m.Y H:i')
    {
        return date($format, $this->getEndsTimestamp());
    }
    
    
    
    protected $_maxDate;
    
    public function getMaxDate($format='Y-m-d'){
        if(empty($this->_maxDate)){
            $obj = new \Calendar\Mappers\Calendar();
            $res = $obj->getSeriesMax($this->getSeries());
            $this->_maxDate = $res;
            return date( $format, $res);
        } else {
            return date( $format, $this->_maxDate);
        }
    }
    
    public function setMaxDate()
    {
        $this->_maxDate = (int) time();
    }

    
    
    protected $_minDate;
    
    public function getMinDate($format='Y-m-d'){
        if(empty($this->_minDate)){
            $obj = new \Calendar\Mappers\Calendar();
            $res = $obj->getSeriesMin($this->getSeries());
            $this->_minDate = $res;
            return date( $format, $res);
        } else {
            return date( $format, $this->_minDate);
        }
    }
        
    public function setMinDate()
    {
        $this->_minDate = (int) time();
    }
    
    
    
    protected $_seriesList;
    
    public function getSeriesList(){
        if(empty($this->_seriesList)){
            $obj = new \Calendar\Mappers\Calendar();
            $res = $obj->getCalendarSeries($this->getSeries());
            $this->_seriesList = $res;
            return $res;
        } else {
            return $this->_seriesList;
        }
    }
    
    
    
    protected $_isSeries;
    
    public function set_is_Series($bool){
        switch(strtolower($bool)){
            case '1':
            case 'on':
            case 'yes':
            case 'true':
                $this->_isSeries = true;
            break;
        
            default:
                $this->_isSeries = false;
            break;
        }
            
    }

    public function is_Series( $val1 = '', $val2 = '' ){   

        if( $this->_isSeries ){
            return true;
        } else {
            return false;
        }
    }
    
    public function if_Series($val1, $val2){
        if( $this->is_Series() ){
            return $val1;
        } else {
            return $val2;
        }
    }

    public function is_Cycle( $val1 = NULL, $val2 = NULL ){   
        if( $this->_cycle && $val1 != NULL && $val2 != NULL ){
            return $val1;
        } else {
            return $val2;
        }
    }
    
    public function is_Today($val1, $val2 = NULL)
    {
        if( date('Y-m-d') == $this->getStart('Y-m-d') ){
            return $val1;
        } else {
            return $val2;
        }
    }
    
}
?>