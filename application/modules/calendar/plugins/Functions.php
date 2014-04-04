<?php

/**
 * @copyright Balthazar3k 2014
 * @package Calendar 1.0
 */
namespace Calendar\Plugins;

class Functions 
{
    public static function cycle( $option, $fromTS, $toTS, $format = 'Y-m-d' ){
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
            
            default:
                
                if( is_numeric($option) && $option > 0 ){
                    
                    $anyOption = floor(($toTS-$fromTS)/(86400*$option));
                    for( $x = 0; $x < $anyOption+1; $x++){
                        $dates[0][] = date($format, mktime(0, 0, 0, $m1, $d1+($option*$x), $y1));
                    }

                    return $dates;                    
                } else {
                    trigger_error('Methode: '. __METHOD__ .' in Class:'. __CLASS__ .', missing first Argument or valid $option!');
                }
                
            break;
        }
    }
    
    public static function cycleNames($id = NULL)
    {
        $options = array(
            0 => 'unique',
            1 => 'daily',
            2 => 'weekly'
        );
        
        if( $id != NULL ){
            return $options[$id];
        } else {
            return $options;
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
    
    public static function dump()
    {
        ?><pre><?php
        foreach(func_get_args() as $arg){
            if( is_array($arg) || is_object($arg)){
                var_dump($arg);
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