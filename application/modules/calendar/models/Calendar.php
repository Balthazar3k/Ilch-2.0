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
    protected $_dateStart;
    protected $_dateEnds;
    protected $_organizer;
    protected $_title;
    protected $_message;
    protected $_array;
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
        return json_decode($this->_moduleUrl, true);
    }
    
    public function setModuleUrl($res)
    {
        if( is_array($res) ){
            $res = json_encode($res, true);
        }
        
        $this->_moduleUrl = (string) $res;
    }
    
    public function getCycle()
    {
        return $this->_cycle;
    }
    
    public function setCycle($res)
    {
        $this->_cycle = (string) $res;
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
        return $this->_DateEnds;
    }
    
    public function setDateEnds($res)
    {
        $this->_dateEnds = (string) $res;
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
    
    public function getArray()
    {
        return json_decode($this->_array, true);
    }
    
    public function setArray($res)
    {
        if( is_array($res) ){
            $res = json_encode($res, true);
        }
        
        $this->_array = (string) $res;
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
}
?>