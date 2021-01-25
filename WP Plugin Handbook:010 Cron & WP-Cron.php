<?php
# CRON
// WP uses WP-Cron for time-based / scheduling tasks
// WP-Cron ONLY RUNS AT PAGE LOAD!!!
// NOTE: Errors may occur if no page load until well after scheduled task
// all scheduled tasks are put into a queue and will eventually get run

# ADDING CUSTOM INTERVAL
// default intervals provided are: hourly, twicedaily, daily, and weekly
add_filter( 'cron_schedules', 'example_add_cron_interval' );
function example_add_cron_interval( $schedules ) {
	$schedules['five_seconds'] = array(
		'interval' => 5,
		'display'  => esc_html__( 'Every Five Seconds' ), );
	return $schedules;
}

# SCHEDULE WP-CRON EVENTS
# ADDING HOOKS
// add_action('name_of_my_hook', 'PREFIX_name_of_function_to_call');
add_action( 'bl_cron_hook', 'bl_cron_exec' );

# CHECK FOR SCHEDULE TASK
wp_next_scheduled( 'bl_cron_hook' );
// either return scheduled time or FALSE

# SCHEDULE TASK
/** wp_schedule_event takes a fourth parameter as well. An array of
	wp_schedule_event(  unix_timestamp_to_start,
						'name_of_interval',
						'name_of_custom_hook_to_call',
						array('full of data','to get passed','to function executing task')
                     );
*/
if ( ! wp_next_scheduled( 'bl_cron_hook' ) ) {
	wp_schedule_event( time(), 'five_seconds', 'bl_cron_hook' );
}

# CANCELLING TASK
$timestamp = wp_next_scheduled( 'bl_cron_hook' );
wp_unschedule_event( $timestamp, 'bl_cron_hook' );

# CANCELLING ALL TASKS WHEN YOUR PLUGIN IS DEACTIVATED
register_deactivation_hook( __FILE__, 'bl_deactivate' );

function bl_deactivate() {
	$timestamp = wp_next_scheduled( 'bl_cron_hook' );
	wp_unschedule_event( $timestamp, 'bl_cron_hook' );
}

# HOOKING WP-CRON INTO CRON
// simply create a tool to make a web request to wp-cron.php
// disable wp-cron from running on every page load:
define('DISABLE_WP_CRON', true); // add this to wp-config.php file

// set a cron job to call:
//     wget --delete-after http://YOUR_SITE_URL/wp-cron.php
// like this:
//    0 0 * * * wget --delete-after http://YOUR_SITE_URL/wp-cron.php

# TESTING WP-CRON
// use wp-cli which offers commands like:
//    wp cron event list
//    wp cron event run {job name}

# TEST WP-CRON WITH CUSTOM PLUGIN
// wp-content/plugins/prefix_cron-test/prefix_cron-test.php
// add this:

/*
Plugin Name: My WP-Cron Test
*/
echo '<pre>'; print_r( _get_cron_array() ); echo '</pre>';
// or
function PREFIX_print_tasks() {
	echo '<pre>'; print_r( _get_cron_array() ); echo '</pre>';
}
bl_print_tasks();

# visit: OUR_SITE_URL/wp-cron.php in browser
// WP initializes all loaded plugins ever page load by running plugin's main file (usually used for setup)
// since this just spits shit out - that's what we'll get mother fucker!
