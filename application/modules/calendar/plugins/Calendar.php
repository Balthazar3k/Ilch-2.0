<?php
/**
 * @copyright Balthazar3k 2014
 * @package Calendar 1.0
 */

namespace Calendar\Plugins;
use Calendar\Plugins\Cycle as Cycle;

class Calendar 
{
    /**
     * @var the Controller who ist called the Calendar
     */
    protected $controller;
    
    /**
     * @var Current view Day
     */
    protected $_day;
    
    /**
     * @var Current view Month
     */
    protected $_month;
    
    /**
     * @var Current view Year
     */
    protected $_year;
    
    /**
     * @var Current view Date
     */
    protected $_date;
    
    /**
     * @var Current view Timestamp
     */
    protected $_time;
    
    /**
     * @var Calendar sheet start date
     */
    protected $startDate;
    
    /**
     * @var Calendar sheet ends date
     */
    protected $endsDate;
    
    /**
     * @var Current view Day
     */
    protected $_size;

    protected $calendarArray = array();

    # Attribute für die Kalendertage
    public $today = array(
        'style' => 'opacity: 1;'
    );

    public $thisMonth = array(
        'style' => 'opacity: 0.7;'
    );

    public $otherMonth = array(
        'style' => 'opacity: 0.2;'
    );
    
    /**
     * Loads the Calendar
     * 
     * @param object $controller (the Controller who ist called the Calendar)
     * @return class Calendar
     */
    
    public function __construct($controller) {
        $this->controller = $controller;
        $this->setSize(940);
        return $this;
    }
    
    /**
     * shows the calendar sheet
     * 
     * @param string $view (date)
     * @return class Calendar
     */
       
    public function viewDate($view = false)
    {
        if( is_string( $view )){
            $ts = strtotime($view);
        }elseif(is_integer($view)){
            $ts = $view;
        }else{
            $ts = time();
        }
        
        $this->_time = $ts;
        $this->_date = date('d.m.Y', $ts);
        $this->_day = (int) date('d', $ts);
        $this->_month = (int) date('m', $ts);
        $this->_year = (int) date('Y', $ts);
        
        $this->init_CalendarArray();
        return $this;
    }
    
    /**
     * Sets the size of the calendar
     * 
     * @param integer $size
     * @return class Calendar
     */

    public function setSize($size)
    {
        $this->_size = (int) $size;
        return $this;
    }
    
    /**
     * filled entries in the calendar
     * 
     * @param string $datetime
     * @param string $html
     * @param array $attributes
     */
    public function fill( $datetime, $html, $attributes=array() )
    {	
        $ts = strtotime($datetime);
        $y = (int) date("Y", $ts);
        $m = (int) date("m", $ts);
        $d = (int) date("d", $ts);

        $this->calendarArray[$y][$m][$d][] = "<div class=\"eventItem\" ".$this->setAttr($attributes).">".$html."</div>";
    }
    
    /**
     * created a calendar array
     * 
     * @return array
     */
    
    private function init_CalendarArray()
    {
        $maxDays = 42;                              # A calendar page has illustration of a total of 42 days for an Optimal
        $countDays = 0;                             # Counter to calculate the next week
        $allDaysNow = date("t", $this->_time);      # Number of days in that month

        # Calculation of the final days of the previous month to the current month
        $allPastDays =        date("t", mktime(0,0,0,$this->_month-1,1,$this->_year));                      # Number of days in the previous month
        $allPastWeekdays =    date("w", mktime(0,0,0, $this->_month-1, $allPastDays, $this->_year));        # last day of week
        $allPastWeekdays =    ( $allPastWeekdays == 0 ? 6 : $allPastWeekdays-1);                            # how many days are in front of the last month
        
        
        
        # Last Month
        $firstDayLastMonth = ($allPastDays-$allPastWeekdays);
        $this->startDate[] = mktime( 0, 0, 0, $this->_month-1, $firstDayLastMonth, $this->_year);
        $this->startDate[] = mktime( 0, 0, 0, $this->_month, 1, $this->_year);
        
        

        for( $i=$firstDayLastMonth; $i<$allPastDays+1; $i++){
            $countDays++;
            $this->calendarArray[$this->_year][$this->_month-1][$i] = array("attributes" => $this->otherMonth);
            $this->calendarArray[$this->_year][$this->_month-1][$i][] = "<div class='dayTitle'>".$i."</div>";
        }

        # Current Viewed Month
        for( $i=1; $i<$allDaysNow+1; $i++){
            $countDays++;
            if( ($this->_day.".".$this->_month.'.'.$this->_year) == ($i.".".date('n.Y')) ){
                $this->calendarArray[$this->_year][$this->_month][$i] = array("attributes" => $this->today);
                $this->calendarArray[$this->_year][$this->_month][$i][] = "<div class='dayTitle today'>".$i." <span class='small'>today</span></div>";
            }else{
                $this->calendarArray[$this->_year][$this->_month][$i] = array("attributes" => $this->thisMonth);
                $this->calendarArray[$this->_year][$this->_month][$i][] = "<div class='dayTitle'>".$i."</div>";
            }
        }
        
        # Past Month
        $lastDayNextMonth = ($maxDays-$countDays)+1;
        $this->endsDate[] = mktime( 0, 0, 0, $this->_month+1, $lastDayNextMonth, $this->_year);
        $this->endsDate[] = mktime( 0, 0, 0, $this->_month, $allDaysNow, $this->_year);
        
        for( $i=1; $i<$lastDayNextMonth; $i++){
            $this->calendarArray[$this->_year][$this->_month+1][$i] = array("attributes" =>  $this->otherMonth);
            $this->calendarArray[$this->_year][$this->_month+1][$i][] = "<div class='dayTitle'>".$i."</div>";
        }

        return $this->calendarArray;
    }
    
    /**
     * created the sql where to records from the database to filter
     * 
     * @return string MySQL
     */
    
    public function where($feld, $format="Y-m-d H:i:s", $options = 0)
    {
        $startDate = date( $format, $this->startDate[$options]);
        $endsDate = date( $format, $this->endsDate[$options]);
        return "WHERE ".$feld .">'".$startDate."' AND ". $feld ."<'".$endsDate."'"; 
    }

    /**
     * set the HTML from Navigation
     * 
     * @return echo HTML
     */
  
    public function getNaviHtml()
    {
        $month = $this->controller->getTranslator()->getTranslations()['monthNames'];

        if( $this->_month == 1 ){
            $lastMonth = 12;
            $lastYear = $this->_year-1;
        }else{
            $lastMonth = $this->_month-1;
            $lastYear = $this->_year;
        }

        if( $this->_month == 12 ){
            $nextMonth = 1;
            $nextYear = $this->_year+1;
        }else{
            $nextMonth = $this->_month+1;
            $nextYear = $this->_year;
        }
        
        $lastDate = $this->_day.'.'.$lastMonth.'.'.$lastYear;
        $nextDate = $this->_day.'.'.$nextMonth.'.'.$nextYear;

        ?><a name="calendar"></a>
        <div class="btn-group calendar-navi">
            <a class="btn btn-default" href="<?=$this->controller->getLayout()->getUrl(array('date' => $lastDate));?>#calendar">
                <i class="fa fa-caret-square-o-left"></i> 
                <?=$month[$lastMonth]?>
            </a>
            <a class="btn btn-default" href="<?=$this->controller->getLayout()->getUrl(array('date' => date('d.m.Y')));?>#calendar">
                <i class="fa fa-calendar"></i> 
                <?php echo $month[$this->_month]." <b>".$this->_year."</b>"; ?>
            </a>
            <a class="btn btn-default" href="<?=$this->controller->getLayout()->getUrl(array('date' => $nextDate));?>#calendar">
                <?=$month[$nextMonth]?> 
                <i class="fa fa-caret-square-o-right"></i>
            </a>
        </div><?php
    }
    
    /**
     * set the HTML from Calendar
     * 
     * @return echo HTML
     */

    public function getCalendarHtml()
    {
        $rowSize = $this->_size/7;
        $ceilCounter = 0;
        
        ?><table cellspacing="1" width="<?=$size?>" class="calendar">
            <thead>
                <tr>
                    <?php foreach( $this->controller->getTranslator()->getTranslations()['dayNames'] as $key => $value): ?>
                    <th align="center" width="<?=$rowSize;?>" class="weekdays"><?=$value[0];?></th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
            <?php
                foreach( $this->calendarArray as $year => $yearArray):
                    foreach( $yearArray as $month => $daysArray):
                        foreach( $daysArray as $day => $dayArray):
                            $ceilCounter++; 
                            if( ($ceilCounter-1) % 7 == 0 ){ echo "<tr>"; } 
            ?>
                                <td valign="top" <?=$this->setAttr($dayArray['attributes'])?> width="<?=$rowSize;?>" height="<?=$rowSize;?>"><?php
                                        foreach( $dayArray as $i => $day ):
                                            if( !is_array( $day ) ){
                                                echo $day; 
                                            }
                                        endforeach;
            ?>
                                </td>
            <?php
                            if($ceilCounter % 7 == 0 ){ echo "</tr>"; }
                        endforeach;
                    endforeach;
                endforeach;?>
            </tbody>
        </table>
        <?php
    }
    
    /**
     * change the array to a HTML Atributes string
     * 
     * @param array $attributes
     * @return string
     */
    
    private function setAttr($attributes)
    {
        if( is_Array($attributes) && count($attributes) > 0 ){
            $attr = array();
            foreach( $attributes as $key => $value){
                $attr[] = $key . '="'.$value.'"';
            }
            return implode(' ', $attr);
        }
    }
}
?>
