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

        $h1 = date("H", $from);     $h2 = date("H", $to);
        $i1 = date("i", $from);     $i2 = date("i", $to);
        $m1 = date("m", $from);     $m2 = date("m", $to);
        $d1 = date("d", $from);     $d2 = date("d", $to);
        $y1 = date("Y", $from);     $y2 = date("Y", $to);

        switch($option)
        {
            case 'unique':
                $dates[0][] = $from;
                $dates[1][] = $from;
                return $dates; 
            break;

            case 'daily':
               
                $days = floor(($to-$from)/(86400));
                for( $x = 0; $x < $days+1; $x++){
                    $dates[0][] = date($format, mktime($h1, $i1, 0, $m1, $d1+($x), $y1));
                    $dates[1][] = date($format, mktime($h2, $i2, 0, $m2, $d2+($x), $y2));
                }

                return $dates;
            break;

            case 'weekly': 

                $weeks = floor(($to-$from)/(86400*7));
                for( $x = 0; $x < $weeks+1; $x++){
                    $dates[0][] = date($format, mktime($h1, $i1, 0, $m1, $d1+(7*$x), $y1));
                    $dates[1][] = date($format, mktime($h2, $i2, 0, $m2, $d2+(7*$x), $y2));
                }

                return $dates;
            break;
            
            default:
                
                if( is_integer($option) && $option < 0 ){
                    
                    $anyOption = floor(($to-$from)/(86400*$option));
                    for( $x = 0; $x < $anyOption+1; $x++){
                        $dates[0][] = date($format, mktime($h1, $i1, 0, $m1, $d1+($option*$x), $y1));
                        $dates[1][] = date($format, mktime($h2, $i2, 0, $m2, $d2+($option*$x), $y2));
                    }

                    return $dates;                    
                } else {
                    trigger_error('Methode: '. __METHOD__ .' in Class:'. __CLASS__ .', missing first Argument!');
                }
                
            break;
        }
    }
}
?>