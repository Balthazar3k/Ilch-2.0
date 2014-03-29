<?php
/**
 * @copyright Balthazar3k 2014
 * @package Calendar 1.0
 */

namespace Eventplaner\Plugins;

class Calendar 
{
    protected $controller;
    
    protected $startDate = '';
    protected $endsDate = '';

    protected $_day;    # Current Day
    protected $_month;  # Current Month
    protected $_year;   # Current Year
    protected $_date;   # Current Date
    
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
        'style' => 'opacity: 0.3;'
    );
    
    
    
    
    public function __construct($controller) {
        $this->controller = $controller;
    }
       
    public function view($view = false)
    {
        if( is_string( $view )){
            $ts = strtotime($view);
        }elseif(is_integer($view)){
            $ts = $view;
        }else{
            $ts = time();
        }
        
        $this->setTimestamp($ts);
        $this->init_CalendarArray();
        return $this;
    }

    public function setSize($size)
    {
        $this->_size = (int) $size;
        return $this;
    }

    public function setDay($day)
    {
        $this->_day = (int) $day;
        return $this;
    }
    
    public function setMonth($month)
    {
        $this->_month = (int) $month;
        return $this;
    }
    
    public function setYear($year)
    {
        $this->_year = (int) $year;
        return $this;
    }
    
    public function setDate($date)
    {
        $this->_date = (string) $date;
        return $this;
    }
    
    public function setTimestamp($ts)
    {
        $this->_date = date('d.m.Y', $ts);
        $this->setDay(date('d', $ts));
        $this->setMonth(date('m', $ts));
        $this->setYear(date('Y', $ts));
    }
    
    /* fill the Calender Array */ 
    public function fill( $datetime, $html, $attributes=array() )
    {	
        $ts = strtotime($datetime);
        $y = intval(date("Y", $ts));
        $m = intval(date("m", $ts));
        $d = intval(date("d", $ts));

        $this->calendarArray[$y][$m][$d][] = "<div class=\"eventItem\" ".$this->setAttr($attributes).">".$html."</div>";
    }
    
    private function getCurrentTS()
    {
        return mktime(0,0,0,  $this->_month, $this->_day, $this->_year);
    }

    private function init_CalendarArray(){
        # Hier wird eine Array erstellt
        # Das einem Monats blatt eines Kalenders gleich kommt
        
        $maxDays = 42;                                                                      # Ein Kalenderblatt hat insgesamt 42 Tage für eine Optimale darstellung
        $countDays = 0;                                                                     # Zähler um den nächsten Monat zu berechnen
        $_day   = $this->_day;                                                              # Der Heutige Tag
        $_month = $this->_month;                                                            # Der aktuelle Monat
        $_year  = $this->_year;                                                             # Das aktuelle Jahr
        $aDaysNow = date("t", $this->getCurrentTS());                                         # Anzahl der Tage in diesem Monat

        # Berechnung der letzten Tage des vorigen Monats auf dem aktuellen Monatsplatt
        $aDaysLast =        date("t", mktime(0,0,0,$_month-1,1,$_year));                    # Anzahl der Tage im vorigem Monate
        $aWeekDaysLast =    date("w", mktime(0,0,0, $_month-1, $aDaysLast, $_year));        # Ermittel den Letzten wochentag
        $aWeekDaysLast =    ( $aWeekDaysLast == 0 ? 6 : $aWeekDaysLast-1);                  # Ermittelt wiviele Tage vor dem Letzten Monat liegt für ein Kalender Monatsblatt

        # Schleife für den Monat davor
        $firstDayLastMonth = ($aDaysLast-$aWeekDaysLast);
        $this->startDate = mktime( 0, 0, 0, $_month-1, $firstDayLastMonth, $_year);

        for( $i=$firstDayLastMonth; $i<$aDaysLast+1; $i++){
            $countDays++;
            $this->calendarArray[$_year][$_month-1][$i] = array("attributes" => $this->otherMonth);
            $this->calendarArray[$_year][$_month-1][$i][] = "<div class='dayTitle'>".$i."</div>";
        }

        # Schleife für den aktuellen Monat
        for( $i=1; $i<$aDaysNow+1; $i++){
            $countDays++;
            if( ($_day.".".$_month) == ($i.".".intval(date('m'))) ){
                $this->calendarArray[$_year][$_month][$i] = array("attributes" => $this->today);
                $this->calendarArray[$_year][$_month][$i][] = "<div class='dayTitle today'>".$i." <span class='small'>today</span></div>";
            }else{
                $this->calendarArray[$_year][$_month][$i] = array("attributes" => $this->thisMonth);
                $this->calendarArray[$_year][$_month][$i][] = "<div class='dayTitle'>".$i."</div>";
            }
        }

        # Schleife für den letzten Monat
        $lastDayNextMonth = ($maxDays-$countDays)+1;

        $this->endsDate = mktime( 0, 0, 0, $_month+1, $lastDayNextMonth, $_year);

        for( $i=1; $i<$lastDayNextMonth; $i++){
            $this->calendarArray[$_year][$_month+1][$i] = array("attributes" =>  $this->otherMonth);
            $this->calendarArray[$_year][$_month+1][$i][] = "<div class='dayTitle'>".$i."</div>";
        }

        return $this->calendarArray;
    }
    
    public function where($feld, $format="U"){
        $startDate = date( $format, $this->startDate);
        $endsDate = date( $format, $this->endsDate);
        return "WHERE ".$feld .">'".$startDate."' AND ". $feld ."<'".$endsDate."'"; 
    }

    public static function monthName(){
        $monat = array(	
            1 =>  "Januar",
            2 =>  "Februar",
            3 =>  "M&auml;rz",
            4 =>  "April",
            5 =>  "Mai",
            6 =>  "Juni",
            7 =>  "Juli",
            8 =>  "August",
            9 =>  "September",
            10 => "Oktober",
            11 => "November",
            12 => "Dezember"
        );

            return $monat;
    }

    public static function weekDays()
    {
        $weekDays = array(	
            1 => "Montag",
            2 => "Dienstag",
            3 => "Mittwoch",
            4 => "Donnerstag",
            5 => "Freitag",
            6 => "Samstag",
            0 => "Sonntag"
        );

        return $weekDays;
    }
    
    public function navigation()
    {
        $month = $this->monthName();

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

        ?><div class="btn-group">
            <a class="btn btn-default" href="<?=$this->controller->getLayout()->getUrl(array('date' => $lastDate));?>"><i class="fa fa-caret-square-o-left"></i></a>
            <a class="btn btn-default" href="<?=$this->controller->getLayout()->getUrl(array('date' => date('d.m.Y')));?>"><i class="fa fa-calendar"></i> <?php echo $month[intval($this->_month)]." ".$this->_year; ?></a>
            <a class="btn btn-default" href="<?=$this->controller->getLayout()->getUrl(array('date' => $nextDate));?>"><i class="fa fa-caret-square-o-right"></i></a>
        </div><?php
    }


    public function getHtml()
    {
        $rowSize = $this->_size/7;
        $ceilCounter = 0;
        
        
        ?><table cellspacing="1" width="<?=$size?>" class="calendar">
            
            <tr>
                <?php foreach( $this->weekDays() as $key => $value): ?>
                <td align="center" width="<?=$rowSize;?>" class="weekdays"><?=$value;?></td>
                <?php endforeach; ?>
            </tr>
            <?php
                foreach( $this->calendarArray as $year => $yearArray):
                    foreach( $yearArray as $month => $daysArray):
                        foreach( $daysArray as $day => $dayArray):
                            $ceilCounter++; 
                            if( ($ceilCounter-1) % 7 == 0 ){ echo "<tr>"; } 
            ?>
                                <td valign="top" <?=$this->setAttr($dayArray['attributes'])?> width="<?=$rowSize;?>" height="<?=$rowSize;?>"><?php
                                        foreach( $dayArray as $i => $event ):
                                            if( !is_array( $event ) ){
                                                echo $event; 
                                            }
                                        endforeach;
            ?>
                                </td>
            <?php
                            if($ceilCounter % 7 == 0 ){ echo "</tr>"; }
                        endforeach;
                    endforeach;
                endforeach;?>
        </table>
        <?php
    }
    
    private function setAttr(array $attributes)
    {
        if( is_Array($attributes) ){
            $attr = array();
            foreach( $attributes as $key => $value){
                $attr[] = $key . '="'.$value.'"';
            }
            return implode(' ', $attr);
        }
    }
}
?>