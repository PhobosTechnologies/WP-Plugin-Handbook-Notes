<?php
# ENQUEUE SCRIPT
// For Ajax scripts you MUST
//    1. wp_enqueue_script(): enqueue scripts to get meta links to appear in page header correctly
//    2. send all requests to: wp-admin/admin-ajax.php (NEVER TO PLUGIN'S PAGE)

wp_enqueue_script(
	'ajax-script',  // tag used to refer to your script
	plugins_url( '/js/myjquery.js', __FILE__ ), // complete URL to your script file
	array( 'jquery' ),  // array of your scripts dependencies / must always include jquery
	'1.0.,0',
	true
);
// use plugins_url() for portability

// scripts MUST be enqueued via action hooks
//    use admin_enqueue_scripts hook for admin pages
//        admin_enqueue_scripts passes current filename to callback
//    use wp_enqueue_scripts for front-end pages
//        does not pass anything - instead use template tags (ie: is_home(), is_single(), etc.)
//    use login_enqueue_scripts for login page
add_action( 'admin_enqueue_scripts', 'my_enqueue' );
function my_enqueue( $hook ) {
	if ( 'myplugin_settings.php' !== $hook ) {
		return;
	}
	wp_enqueue_script(
		'ajax-script',
		plugins_url( '/js/myjquery.js', __FILE__ ),
		array( 'jquery' ),
		'1.0.0',
		true
	);
}
// you can use closure instead of a named function. NOTE: older PHP versions can't closure
// optionally use wp_register_script(); to create handle/tag to use script elsewhere

# CREATE NONCE
$title_nonce = wp_create_nonce( 'name_your_nonce' );

# LOCALIZE (aka: create my_ajax_obj )
// use wp_localize_script();
wp_localize_script(
	'ajax-script', // script handle
	'my_ajax_obj', // name the ajax object you'll use client side
	array(
		'ajax_url' => admin_url( 'admin-ajax.php' ),
		'nonce'    => $title_nonce,
	)
);

# ALL TOGETHER NOW!!!
add_action( 'admin_enqueue_scripts', 'my_enqueue' );

/**
 * Enqueue my scripts and assets.
 *
 * @param $hook
 */
function my_enqueue( $hook ) {
	if ( 'myplugin_settings.php' != $hook ) {
		return;
	}
	wp_enqueue_script(
		'ajax-script',
		plugins_url( '/js/myjquery.js', __FILE__ ),
		array( 'jquery' ),
		'1.0.0',
		true
	);
	$title_nonce = wp_create_nonce( 'title_example' );
	wp_localize_script(
		'ajax-script',
		'my_ajax_obj',
		array(
			'ajax_url' => admin_url( 'admin-ajax.php' ),
			'nonce'    => $title_nonce,
		)
	);
}

# HOOKING AJAX ACTION
add_action( 'wp_ajax_my_tag_count', 'my_ajax_handler' );
// wp_ajax_nopriv_my_tag_count if user is not logged in

/**
 * Handles my AJAX request.
 */
function my_ajax_handler() {
	// Handle the ajax request here

	wp_die(); // All ajax handlers die when finished
}

# CHECK NONCE
check_ajax_referer( 'title_example' );

# HANDLE DATA
update_user_meta( get_current_user_id(), 'title_preference', $_POST['title'] );

$args      = array(
	'tag' => $_POST['title'],
);
$the_query = new WP_Query( $args );

# RESPOND
WP_Ajax_Response(); // XML
wp_send_json(); // JSON
wp_send_json_success(); // triggers done() callback
wp_send_json_error(); // triggers fail() callback

// use any other suitable means for responding, for example:
echo $_POST['title'] . ' (' . $the_query->post_count . ') ';

// NOTE: the Ajax & XML functions die(); when done.
//    if using other method, must call die(); after response.

#COMPLETE AJAX HANDLER EXAMPLES:
/**
 * AJAX handler using JSON
 */
function my_ajax_handler__json() {
	check_ajax_referer( 'title_example' );
	update_user_meta( get_current_user_id(), 'title_preference', $_POST['title'] );
	$args      = array(
		'tag' => $_POST['title'],
	);
	$the_query = new WP_Query( $args );
	wp_send_json( $_POST['title'] . ' (' . $the_query->post_count . ') ' );
}

/**
 * AJAX handler not using JSON.
 */
function my_ajax_handler() {
	check_ajax_referer( 'title_example' );
	update_user_meta( get_current_user_id(), 'title_preference', $_POST['title'] );
	$args      = array(
		'tag' => $_POST['title'],
	);
	$the_query = new WP_Query( $args );
	echo $_POST['title'] . ' (' . $the_query->post_count . ') ';
	wp_die(); // All ajax handlers should die when finished
}
