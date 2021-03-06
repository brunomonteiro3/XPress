<?php
/**
 * Cron is something I feel is better suited for a plugin, but I still include some functions for reference
 *  
 * @since 0.1
 * @file  wp.cron.php
 */

// http://themocracy.com/2010/02/wp-cron-automating-scheduling/
add_filter('cron_schedules', 'xf_add_weekly_cron');

function xfadd_weekly_cron($schedules ) {
  $schedules['weekly'] = array(
    'interval' => 604800, //that's how many seconds in a week, for the unix timestamp
    'display' => __('Once Weekly')
  );
  return $schedules;
}


// add_action('weekly_events', 'weekly_events_fnc');

// activate 'CRON' event
// wp_schedule_event(time(), 'weekly', 'weekly_events');

// deactivate 'CRON' event
// wp_clear_scheduled_hook('my_hourly_event');

/*
function x_weekly_events_fnc() {
  // Do this once a week
  $args =  array( 'post_type' => array( 'memorial', 'pet_adopt')); 
  $args['post_status'] = 'pending';
  $query = new WP_Query(  $args);
  
}*/
