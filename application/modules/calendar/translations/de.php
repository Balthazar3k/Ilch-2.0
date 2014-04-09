<?php
/**
 * @copyright Balthazar3k 2014
 * @package Calendar 1.0
 */

defined('ACCESS') or die('no direct access');

return array(
    'calendar' => 'Kalender',
    'calendar_view' => 'Kalenderansicht',
    'list_view' => 'Listenansicht',
    'time_options' => 'Zeit Einstellungen',
    'hmenu_details' => 'Detail von %s',
    
    'calendar_save_success' => 'In den Kalender eintragen waren erfolgreich.',
    'calendar_delete_success' => 'Löschen war erfolgreich!.',
    'calendarSeries_delete_success' => 'Serie löschen war erfolgreich!.',
    'calendar_delete_error' => 'Löschen war nicht erfolgreich!.',
    
    'missing_title' => 'Bitte füllen Sie da Feld: Titel aus.',
    'missing_date_ends' => 'Bitte geben Sie einen gültigen Datum für das Ende an',
    'missing_date_start' => 'Bitte geben Sie einen gültigen Datum für den Start an',
    'missing_time_ends' => 'Bitte geben Sie einen gültige Zeit für das Ende an',
    'missing_time_start' => 'Bitte geben Sie einen gültige Zeit für den Start an',
    
    'title' => 'Titel',
    'cycle' => 'Zyklus',
    'cycle_from_to' => 'start am %s bis zum %s',
    'cycle_unique' => 'Einmalig',
    'cycle_daily' => 'Täglich',
    'cycle_weekly' => 'Wöchentlich',
    'cycle_weekdays' => 'Wochentage',
    'time_start' => 'Zeit Begin',
    'time_ends' => 'Zeit Ende',
    'date_start' => 'Datum Begin',
    'date_ends' => 'Datum Ende',
    
    'begin_datetime' => '<b>%s</b> um <b>%s - %s</b> Uhr',
    'created' => 'Erstellt am',
    'changed' => 'Geändert am',
    
    'action_series' => 'Der Kalendereintrag ist teil einer Serie',
    'action_series_edit' => 'Bearbeiten',
    'action_series_true' => 'Ja, Serie bearbeiten',
    'action_series_false' => 'Nein, nur diesen Eintrag',
    'action_series_delete' => 'Serie Löschen',
    
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