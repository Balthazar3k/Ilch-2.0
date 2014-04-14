<?php
/**
 * @copyright Balthazar3k 2014
 * @package Calendar 1.0
 */
namespace Calendar\Models;

defined('ACCESS') or die('no direct access');

class Calendar extends \Ilch\Model
{
    /**
     * The id of the calendar.
     *
     * @var int
     */
    protected $_id;
    
    /**
     * The Module Key the calendar.
     *
     * @var string
     */
    protected $_moduleKey;
    
    /**
     * The Cycle of the calendar.
     *
     * @var int
     */
    protected $_cycle;
    
    /**
     * The Weekdays of the calendar.
     *
     * @var array
     */
    protected $_weekdays;
    
    /**
     * The Starttime of the calendar.
     *
     * @var string
     */
    protected $_timeStart;
    
    /**
     * The Endtime of the calendar.
     *
     * @var string
     */
    protected $_timeEnds;
    
    /**
     * The Date of the Start.
     *
     * @var (string) date
     */
    protected $_dateStart;
    
    /**
     * The Date of the Ends.
     *
     * @var (string) date
     */
    protected $_dateEnds;
    
    /**
     * The Organizer.
     *
     * @var int
     */
    protected $_organizer;
    
    /**
     * The Title of the calendar.
     *
     * @var string
     */
    protected $_title;
    
    /**
     * The Message of the calendar.
     *
     * @var string
     */
    protected $_message;
    
    /**
     * Created of the calendar.
     *
     * @var datetime
     */
    protected $_created;
    
    /**
     * Changed of the calendar.
     *
     * @var datetime
     */
    protected $_changed;
    
    /**
     * Serie of the calendar.
     *
     * @var int
     */
    protected $_series;

    /**
     * Gets the Id of the Calendar.
     *
     * @return int
     */
    public function getId()
    {
        return $this->_id;
    }
    
    /**
     * Sets the id of the Calendar.
     *
     * @param int $res
     */
    public function setId($res)
    {
        $this->_id = (int) $res;
    }
    
    /**
     * Gets the Modulekey of the Calendar.
     *
     * @return string
     */
    public function getModuleKey()
    {
        return $this->_moduleKey;
    }
    
    /**
     * Sets the module key of the Calendar.
     *
     * @param string $res
     */
    public function setModuleKey($res)
    {
        $this->_moduleKey = (string) $res;
    }
    
    /**
     * Gets the Cycle of the Calendar.
     *
     * @return int
     */
    public function getCycle()
    {
        return $this->_cycle;
    }
    
    /**
     * Sets the Cycle of the Calendar.
     *
     * @param int $res
     */
    public function setCycle($res)
    {
        $this->_cycle = (int) $res;
    }
    
    /**
     * Gets the Weekdays of the Calendar.
     *
     * @return array
     */
    public function getWeekdays()
    {
        return json_decode($this->_weekdays);
    }
    
    /**
     * Gets the Weekdays String of the Calendar.
     *
     * @return string
     */
    public function getWeekdaysString()
    {
        return $this->_weekdays;
    }
    
    /**
     * Sets the Weekdays of the Calendar.
     *
     * @param array/string $res
     */
    public function setWeekdays($res)
    {
        if( is_array($res) ){
            $this->_weekdays = json_encode($res);
        } else {
            $this->_weekdays = (string) $res;
        }
    }

    /**
     * Gets the Start Date of the Calendar.
     *
     * @return datetime
     */
    public function getDateStart()
    {
        return $this->_dateStart;
    }
    
    /**
     * Sets the Date Start of the Calendar.
     *
     * @param datetime $res
     */
    public function setDateStart($res)
    {
        $this->_dateStart = (string) $res;
    }
    
    /**
     * Gets the Ends Date of the Calendar.
     *
     * @return datetime
     */
    public function getDateEnds()
    {
        return $this->_dateEnds;
    }
    
    /**
     * Sets the Date Ends of the Calendar.
     *
     * @param string $res
     */
    public function setDateEnds($res)
    {
        $this->_dateEnds = (string) $res;
    }
    
    /**
     * Gets the Start time of the Calendar.
     *
     * @return string
     */
    public function getTimeStart()
    {
        return $this->_timeStart;
    }
    
    /**
     * Sets the Time Start of the Calendar.
     *
     * @param string $res
     */
    public function setTimeStart($res)
    {
        $this->_timeStart = (string) $res;
    }

    /**
     * Gets the Ends time of the Calendar.
     *
     * @return string
     */
    public function getTimeEnds()
    {
        return $this->_timeEnds;
    }
    
    /**
     * Sets the time Ends of the Calendar.
     *
     * @param string $res
     */
    public function setTimeEnds($res)
    {
        $this->_timeEnds = (string) $res;
    }
    
    /**
     * Gets the Organizer of the Calendar.
     *
     * @return int
     */
    public function getOrganizer()
    {
        return $this->_organizer;
    }
    
    /**
     * Sets the Organizer of the Calendar.
     *
     * @param int $res
     */
    public function setOrganizer($res)
    {
        $this->_organizer = (integer)$res;
    }
    
    /**
     * Gets the Title of the Calendar.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->_title;
    }
    
    /**
     * Sets the Title of the Calendar.
     *
     * @param string $res
     */
    public function setTitle($res)
    {
        $this->_title = (string)$res;
    }
    
    /**
     * Gets the Message of the Calendar.
     *
     * @return text
     */
    public function getMessage()
    {
        return $this->_message;
    }
    
    /**
     * Sets the module key of the Calendar.
     *
     * @param string $res
     */
    public function setMessage($res)
    {
        $this->_message = (string)$res;
    }
    
    /**
     * Gets the Created of the Calendar.
     *
     * @return datetime
     */
    public function getCreated()
    {
        return $this->_created;
    }
    
    /**
     * Sets the Created datetime of the Calendar.
     *
     * @param datetime $res
     */
    public function setCreated($res)
    {
        $this->_created = (string)$res;
    }
    
    /**
     * Gets the Changed of the Calendar.
     *
     * @return datetime
     */
    public function getChanged()
    {
        return $this->_changed;
    }
    
    /**
     * Sets the Changed datetime of the Calendar.
     *
     * @param datetime $res
     */
    public function setChanged($res)
    {
        $this->_changed = (string)$res;
    }
    
    /**
     * Gets the Series of the Calendar.
     *
     * @return int
     */
    public function getSeries()
    {
        return $this->_series;
    }
    
    /**
     * Sets the Series of the Calendar.
     *
     * @param int $res
     */
    public function setSeries($res)
    {
        $this->_series = (int) $res;
    }
    
    /**
     * Gets the Start timestamp of the Calendar.
     *
     * @return timestamp
     */
    public function getStartTimestamp()
    {
        return strtotime($this->_dateStart);
    }
    
    /**
     * Gets the Start of the Calendar.
     *
     * @param $format
     * @return timestamp
     */
    public function getStart($format = 'd.m.Y H:i')
    {
        return date($format, $this->getStartTimestamp());
    }
    
    /**
     * Gets the Ends timestamp of the Calendar.
     *
     * @return timestamp
     */
    public function getEndsTimestamp()
    {
        return strtotime($this->_dateEnds);
    }
    
    /**
     * Gets the Ends of the Calendar.
     *
     * @param $format
     * @return timestamp
     */
    public function getEnds($format = 'd.m.Y H:i')
    {
        return date($format, $this->getEndsTimestamp());
    }
    
    
    /**
     * The highest Date of the calendar.
     *
     * @var object
     */
    protected $_maxDate;
    
    /**
     * Gets the highest Date of the Calendar Series.
     *
     * @param $format
     * @return string
     */
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
    
    /**
     * Sets the MaxDate of the Calendar.
     */
    public function setMaxDate()
    {
        $this->_maxDate = (int) time();
    }

    
    /**
     * The lowest Date of the calendar.
     *
     * @var object
     */
    protected $_minDate;
    
    /**
     * Gets the lowest Date of the Calendar Series.
     *
     * @param $format
     * @return string
     */
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
    
    /**
     * Sets the MinDate of the Calendar.
     */
    public function setMinDate()
    {
        $this->_minDate = (int) time();
    }
    
    
    /**
     * The a list of the calendar Series.
     *
     * @var object
     */
    protected $_seriesList;
    
    /**
     * Gets a list of the Calendar Series.
     *
     * @return object
     */
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
    
    
    /**
     * The if is Series of the calendar.
     *
     * @var bool
     */
    protected $_isSeries;
    
    /**
     * Sets the Series of the Calendar.
     *
     * @param bool $bool
     */
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
    
    /**
     * Check is entry in a Series.
     *
     * @return bool
     */
    public function is_Series(){   

        if( $this->_isSeries ){
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * Check is entry in a Series. Put out
     *  
     * @param $val1
     * @param $val2
     * @return string/int
     */
    public function if_Series($val1, $val2){
        if( $this->is_Series() ){
            return $val1;
        } else {
            return $val2;
        }
    }
    
    /**
     * Check is Cycle in the Calendar entry.
     *  
     * @param $val1
     * @param $val2
     * @return string/int
     */
    public function is_Cycle( $val1 = NULL, $val2 = NULL ){   
        if( $this->_cycle && $val1 != NULL && $val2 != NULL ){
            return $val1;
        } else {
            return $val2;
        }
    }
    
    /**
     * Check is Today the Calendar
     *  
     * @param $val1
     * @param $val2
     * @return string/int
     */
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