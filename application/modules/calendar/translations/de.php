<?php
/**
 * @copyright Balthazar3k 2014
 * @package Calendar 1.0
 */

defined('ACCESS') or die('no direct access');

return array(
    'calendar' => 'Kalender',
    'calendar_view' => 'Kalenderansicht',
    'time_options' => 'Zeit Einstellungen',
    
    'calendar_save_success' => 'Eintrag/Einträge in den Kalender waren erfolgreich.',
    
    'title' => 'Titel',
    'cycle' => 'Zyklus',
    'cycle_unique' => 'Einmalig',
    'cycle_daily' => 'Täglich',
    'cycle_weekly' => 'Wöchentlich',
    'cycle_2_days' => 'alle 2 Tage',
    'cycle_3_days' => 'alle 3 Tage',
    'cycle_4_days' => 'alle 4 Tage',
    'cycle_5_days' => 'alle 5 Tage',
    'cycle_6_days' => 'alle 6 Tage',
    'time_start' => 'Zeit Begin',
    'time_ends' => 'Zeit Ende',
    'date_start' => 'Datum Begin',
    'date_ends' => 'Datum Ende',
    
    'begin_datetime' => '<b>%s</b> um <b>%s - %s</b> Uhr',
    'of_the' => 'Von dem',
    'to' => 'bis zum',
    'created' => 'Erstellt am',
    'changed' => 'Geändert am',
    
    'action_series' => 'Der Kalendereintrag ist teil einer Serie',
    'action_series_edit' => 'Bearbeiten',
    'action_series_true' => 'Ja, Serie bearbeiten',
    'action_series_false' => 'Nein, nur diesen Eintrag',
    
    'list_series' => 'Serienliste - (%s)',
    'series_listing' => '<b>%s</b> um <b>%s - %s</b> Uhr (%s)',
    
    'menu_action_insert_calendar' => 'Kalender eintrag erstellen',
    'menu_action_update_calendar' => 'Kalender eintrag bearbeiten',

    'monthNames' => array(	
         1 =>  'Januar',
         2 =>  'Februar',
         3 =>  'M&auml;rz',
         4 =>  'April',
         5 =>  'Mai',
         6 =>  'Juni',
         7 =>  'Juli',
         8 =>  'August',
         9 =>  'September',
         10 => 'Oktober',
         11 => 'November',
         12 => 'Dezember'
     ),
    
    'dayNames' => array(	
        1 => array('Montag','Mo'),
        2 => array('Dienstag','Di'),
        3 => array('Mittwoch','Mi'),
        4 => array('Donnerstag','Do'),
        5 => array('Freitag','Fr'),
        6 => array('Samstag','Sa'),
        0 => array('Sonntag','So')
    )
);

?>