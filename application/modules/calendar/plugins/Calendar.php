<?php
/**
 * @copyright Balthazar3k 2014
 * @package Calendar 1.0
 */

namespace Calendar\Plugins;
use Calendar\Plugins\Functions as func;

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
        $this->setSize(940);
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
        
        $this->_date = date('d.m.Y', $ts);
        $this->_day = (int) date('d', $ts);
        $this->_month = (int) date('m', $ts);
        $this->_year = (int) date('Y', $ts);
        
        $this->init_CalendarArray();
        return $this;
    }

    public function setSize($size)
    {
        $this->_size = (int) $size;
        return $this;
    }
    
    /* fill the Calender Array */ 
    public function fill( $datetime, $html, $attributes=array() )
    {	
        $ts = strtotime($datetime);
        $y = (int) intval(date("Y", $ts));
        $m = (int) intval(date("m", $ts));
        $d = (int) intval(date("d", $ts));

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
        $aDaysNow = date("t", $this->getCurrentTS());                                      # Anzahl der Tage in diesem Monat

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
            if( ($_day.".".$_month.'.'.$_year) == ($i.".".date('n.Y')) ){
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

  
    public function getNavigation()
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

        ?><div class="btn-group">
            <a class="btn btn-default" href="<?=$this->controller->getLayout()->getUrl(array('date' => $lastDate));?>"><i class="fa fa-caret-square-o-left"></i> <?=$month[$lastMonth]?></a>
            <a class="btn btn-default" href="<?=$this->controller->getLayout()->getUrl(array('date' => date('d.m.Y')));?>"><i class="fa fa-calendar"></i> <?php echo $month[intval($this->_month)]." ".$this->_year; ?></a>
            <a class="btn btn-default" href="<?=$this->controller->getLayout()->getUrl(array('date' => $nextDate));?>"><?=$month[$nextMonth]?> <i class="fa fa-caret-square-o-right"></i></a>
        </div><?php
    }


    public function getCalendarHtml()
    {
        $rowSize = $this->_size/7;
        $ceilCounter = 0;
        
        //func::ar($this->calendarArray);
        
        // Später noch ein Dynamisches Design mit DivContainern.
        ?><table cellspacing="1" width="<?=$size?>" class="calendar table table-hover table-striped">
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
            </tbody>
        </table>
        <?php
    }
    
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