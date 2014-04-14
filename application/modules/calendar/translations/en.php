<?php
/**
 * @copyright Balthazar3k 2014
 * @package Calendar 1.0
 */

defined('ACCESS') or die('no direct access');

return array(
    'calendar' => 'Calendar',
    'calendar_view' => 'Calendar View',
    'list_view' => 'List View',
    'time_options' => 'Time Settings',
    'hmenu_details' => 'Details from %s',
    
    'calendar_save_success' => 'Save Success.',
    'calendar_delete_success' => 'Delete was successful!.',
    'calendarSeries_delete_success' => 'Delete Series was successful!',
    'calendar_delete_error' => 'Clearing was unsuccessful!.',
    
    'missing_title' => 'Missing Title.',
    'missing_date_ends' => 'Missing Date for the Ende',
    'missing_date_start' => 'Missing Date for the Start',
    'missing_time_ends' => 'Missing Time for the Ende',
    'missing_time_start' => 'Missing Time for the Start',
    
    'title' => 'Title',
    'select_title' => 'Select a Title ',
    'cycle' => 'Cycle',
    'cycle_from_to' => '%s to %s',
    'cycle_unique' => 'Unique',
    'cycle_daily' => 'Daily',
    'cycle_weekly' => 'Weekly',
    'cycle_weekdays' => 'Weekdays',
    'time_start' => 'Start Time',
    'time_ends' => 'Ends Time',
    'date_start' => 'Start Date',
    'date_ends' => 'Ends Date',
    'today' => 'Today',
    
    'begin_datetime' => 'at <b>%s - %s</b> clock',
    'created' => 'Created @',
    'changed' => 'Changed @',
    
    'action_series' => 'The calendar entry is part of a series',
    'action_series_edit' => 'Edit',
    'action_series_true' => 'Yes, Series Edit',
    'action_series_false' => 'No, only this entry',
    'action_series_delete' => 'Delete series',
    
    'list_series' => 'series List - (%s)',
    'series_listing' => '<b>%s</b> @ <b>%s - %s</b> clock (%s)',
    
    'menu_action_insert_calendar' => 'create a calendar entry',
    'menu_action_update_calendar' => 'Calendar entry Edit',

    'monthNames' => array(	
         1 =>  'January',
         2 =>  'February',
         3 =>  'March',
         4 =>  'April',
         5 =>  'May',
         6 =>  'June',
         7 =>  'July',
         8 =>  'August',
         9 =>  'September',
         10 => 'October',
         11 => 'November',
         12 => 'December'
     ),
    
    'dayNames' => array(	
        1 => array('Monday','Mon'),
        2 => array('Tuesday','Tue'),
        3 => array('Wednesday','Wed'),
        4 => array('Thursday','Thu'),
        5 => array('Friday','Fri'),
        6 => array('Saturday','Sat'),
        0 => array('Sunday','Sun')
    )
);

?>