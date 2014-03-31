<?php

/**
 * @copyright Balthazar3k 2014
 * @package Calendar 1.0
 */
namespace Calendar\Plugins;

class Functions 
{
    public static function cycle( $option, $from, $to, $format = 'Y-m-d' ){
        $dates = array();
        
        $fromTS = strtotime($from);
        $toTS = strtotime($to);

        $h1 = date("H", $fromTS);     $h2 = date("H", $toTS);
        $i1 = date("i", $fromTS);     $i2 = date("i", $toTS);
        $m1 = date("m", $fromTS);     $m2 = date("m", $toTS);
        $d1 = date("d", $fromTS);     $d2 = date("d", $toTS);
        $y1 = date("Y", $fromTS);     $y2 = date("Y", $toTS);
        
        

        switch($option)
        {
            case 'unique':
                $dates[0][] = $from;
                $dates[1][] = $to;
                return $dates; 
            break;

            case 'daily':
               
                $days = floor(($toTS-$fromTS)/(86400));
                for( $x = 0; $x < $days+1; $x++){
                    $dates[0][] = date($format, mktime($h1, $i1, 0, $m1, $d1+($x), $y1));
                    $dates[1][] = date($format, mktime($h2, $i2, 0, $m2, $d2+($x), $y2));
                }

                return $dates;
            break;

            case 'weekly': 

                $weeks = floor(($toTS-$fromTS)/(86400*7));
                for( $x = 0; $x < $weeks+1; $x++){
                    $dates[0][] = date($format, mktime($h1, $i1, 0, $m1, $d1+(7*$x), $y1));
                    $dates[1][] = date($format, mktime($h2, $i2, 0, $m2, $d2+(7*$x), $y2));
                }

                return $dates;
            break;
            
            default:
                
                if( is_numeric($option) && $option > 0 ){
                    
                    $anyOption = floor(($toTS-$fromTS)/(86400*$option));
                    for( $x = 0; $x < $anyOption+1; $x++){
                        $dates[0][] = date($format, mktime($h1, $i1, 0, $m1, $d1+($option*$x), $y1));
                        $dates[1][] = date($format, mktime($h2, $i2, 0, $m2, $d2+($option*$x), $y2));
                    }

                    return $dates;                    
                } else {
                    trigger_error('Methode: '. __METHOD__ .' in Class:'. __CLASS__ .', missing first Argument or valid $option!');
                }
                
            break;
        }
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
}
?>