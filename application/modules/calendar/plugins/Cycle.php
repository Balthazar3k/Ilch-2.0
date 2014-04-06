<?php

/**
 * @copyright Balthazar3k 2014
 * @package Calendar 1.0
 */
namespace Calendar\Plugins;

class Cycle 
{
    /**
     * create the Dates for a Cycle
     * 
     * @param integer $option
     * @param integer $fromTS (from Timestamp)
     * @param integer $toTS (to Timestamp)
     * @param string $format
     * @return array of dates
     */
    
    public static function calc( $option, $fromTS, $toTS, $format = 'Y-m-d' ){
        $dates = array();

        $m1 = date("m", $fromTS); 
        $d1 = date("d", $fromTS);
        $y1 = date("Y", $fromTS);
        
        switch($option)
        {
            case 0:
                $dates[0][] = date($format, $fromTS);
                return $dates; 
            break;

            case 1:
               
                $days = floor(($toTS-$fromTS)/(86400));
                for( $x = 0; $x < $days+1; $x++){
                    $dates[0][] = date($format, mktime(0, 0, 0, $m1, $d1+($x), $y1));
                }

                return $dates;
            break;

            case 2: 

                $weeks = floor(($toTS-$fromTS)/(86400*7));
                for( $x = 0; $x < $weeks+1; $x++){
                    $dates[0][] = date($format, mktime(0, 0, 0, $m1, $d1+(7*$x), $y1));
                }

                return $dates;
            break;
            
            case 3: 
                $weekdays = array( 1, 2, 3, 4, 5);
                $days = floor(($toTS-$fromTS)/(86400));
                for( $x = 0; $x < $days+1; $x++){
                    if(in_array((int) date('w', mktime(0, 0, 0, $m1, $d1+($x), $y1)), $weekdays) ){
                        $dates[0][] = date($format, mktime(0, 0, 0, $m1, $d1+($x), $y1));
                    }
                }

                return $dates;
            break;
        }
    }
    
    /**
     * get the Array of Cycle
     * 
     * @return array $cycle
     */
    
    public static function getArray(){
        return array(
            0 => 'unique',
            1 => 'daily',
            2 => 'weekly',
            3 => 'weekdays'
        );
    }
    
    /**
     * get the Array of Cycle
     * 
     * @param integer $id
     * @return array $cycleName
     */

    public static function Name($id = integer)
    {
        return self::getArray()[$id];
    }


    public static function ar()
    {
        ?><pre><?php
        foreach(func_get_args() as $arg){
            if( is_array($arg) || is_object($arg)){
                print_r($arg);
                ?><hr><?php
            } else {
                echo $arg;
                ?><hr><?php
            }
        }
        ?></pre><?php
    }
    
    public static function dump()
    {
        ?><pre><?php
        foreach(func_get_args() as $arg){
            var_dump($arg);
            ?><hr><?php
        }
        ?></pre><?php
    }
}
?>