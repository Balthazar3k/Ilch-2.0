<?php

/**
 * @copyright Balthazar3k 2014
 * @package Calendar 1.0
 */
namespace Calendar\Plugins;

class Functions 
{
    public static function cycle( $option, $from, $to, $format = 'Y-m-d H:i:s' ){
        $dates = array();
        
        $from = strtotime($from);
        $to = strtotime($to);

        $h = date("H", $from);
        $i = date("i", $from);
        $m = date("m", $from);
        $d = date("d", $from);
        $y = date("Y", $from);

        switch($option)
        {
            case 'unique':
                $dates[] = $from; 
                return $dates; 
            break;

            case 'daily':
               
                $days = floor(($to-$from)/(86400));
                for( $x = 0; $x < $days+1; $x++){
                    $dates[] = date($format, mktime($h, $i, 0, $m, $d+($x), $y));
                }

                return $dates;
            break;

            case 'weekly': 

                $weeks = floor(($to-$from)/(86400*7));
                for( $x = 0; $x < $weeks+1; $x++){
                    $dates[] = date($format, mktime($h, $i, 0, $m, $d+(7*$x), $y));
                }

                return $dates;
            break;
            
            default:
                
                if( is_integer($option) && $option < 0 ){
                    
                    $anyOption = floor(($to-$from)/(86400*$option));
                    for( $x = 0; $x < $anyOption+1; $x++){
                        $dates[] = date($format, mktime($h, $i, 0, $m, $d+($option*$x), $y));
                    }

                    return $dates;                    
                } else {
                    trigger_error('Methode: '__METHOD__ . ' Class:'. __CLASS__ .', missing first Argument!'):
                }
                
            break;
        }
    }
}
?>