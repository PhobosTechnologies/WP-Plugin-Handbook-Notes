<?php

$post_id = '';
$meta_key = ''; # used to reference the meta_value in other places. ie: 'COMPANYKEY_name_of_whatnot'
$meta_value = ''; # string, integer, or array. Arrays will be automatically serialized before database.
$unique = TRUE; # makes the meta_value unique (post can only have one)

# add meta data
add_post_meta($post_id, $meta_key, $meta_value, $unique);

# update
# if not exist, will create
update_post_meta($post_id, $meta_key, $meta_value, $unique);

# delete
delete_post_meta($post_id, $meta_key, $meta_value);

# PROBLEM::
# post meta is passed through stripslashes() upon being stored; be careful with escaped sequences (ie: JSON)
# ie:  JSON value {"key":"value with \"escaped quotes\""}:
$escaped_json = '{"key":"value with \"escaped quotes\""}';
update_post_meta( $post_id, 'escaped_json', $escaped_json );
$broken = get_post_meta( $post_id, 'escaped_json', true );
/*
$broken, after stripslashes(), ends up unparsable:
{"key":"value with "escaped quotes""}
*/

# WORKAROUND::
# add another level of escaping with wp_slash()
$escaped_json = '{"key":"value with \"escaped quotes\""}';
update_post_meta( $post_id, 'double_escaped_json', wp_slash( $escaped_json ) );
$fixed = get_post_meta( $post_id, 'double_escaped_json', true );
/*
$fixed, after stripslashes(), ends up as desired:
{"key":"value with \"escaped quotes\""}
*/

# Hiding Custom Fields
# start your meta_key with _
# works on custom fields, post edit screen, and when using the_meta()
# useful when using add_meta_box()
#
# this adds meta field but won't display it:
add_post_meta( 68, '_color', 'red', true );

# Hiding Arrays
# if meta_value is an array, will not display on page edit screen

# CUSTOM META BOXES
# 'Editor', 'Publish', 'Tags', etc. are meta_boxes
# very useful edit screen elements

# NOTE: examples below omit nonces, security practices, and user capabilities. ADD THESE IN PRODUCTION!!!

# add meta box
function wporg_add_custom_box() {
	$screens = [ 'post', 'wporg_cpt' ];
	foreach ( $screens as $screen ) {
		add_meta_box(
			'wporg_box_id',                 // Unique ID
			'Custom Meta Box Title',      // Box title
			'wporg_custom_box_html',  // Content callback, must be of type callable
			$screen                            // Post type
		);
	}
}
add_action( 'add_meta_boxes', 'wporg_add_custom_box' );
# wporg_custom_box_html holds HTML for meta box

# add form elements, labels, etc.
function wporg_custom_box_html( $post ) {
	?>
	<label for="wporg_field">Description for this field</label>
	<select name="wporg_field" id="wporg_field" class="postbox">
		<option value="">Select something...</option>
		<option value="something">Something</option>
		<option value="else">Else</option>
	</select>
	<?php
}
# NOTE: meta boxes DO NOT have submit button
# all data transfered via POST when Publish or Update are clicked

# GET DATA
# if stored in postmeta table, get with get_post_meta()
function wporg_custom_box_html( $post ) {
	$value = get_post_meta( $post->ID, '_wporg_meta_key', true );
	?>
	<label for="wporg_field">Description for this field</label>
	<select name="wporg_field" id="wporg_field" class="postbox">
		<option value="">Select something...</option>
		<option value="something" <?php selected( $value, 'something' ); ?>>Something</option>
		<option value="else" <?php selected( $value, 'else' ); ?>>Else</option>
	</select>
	<?php
}

# SAVING DATA
# postmeta table is usually a good place, but you can store it anywhere
function wporg_save_postdata( $post_id ) {
	if ( array_key_exists( 'wporg_field', $_POST ) ) {
		update_post_meta(
			$post_id,
			'_wporg_meta_key',
			$_POST['wporg_field']
		);
	}
}
add_action( 'save_post', 'wporg_save_postdata' );

# post edit screens display meta boxes by calling do_meta_boxes(), looping through boxes, and calls each callback.
# markup is handled between each call

# REMOVING META BOXES
remove_meta_box(); # use same parameters it was created with

# OOP implementation
abstract class WPOrg_Meta_Box {


	/**
	 * Set up and add the meta box.
	 */
	public static function add() {
		$screens = [ 'post', 'wporg_cpt' ];
		foreach ( $screens as $screen ) {
			add_meta_box(
				'wporg_box_id',          // Unique ID
				'Custom Meta Box Title', // Box title
				[ self::class, 'html' ],   // Content callback, must be of type callable
				$screen                  // Post type
			);
		}
	}


	/**
	 * Save the meta box selections.
	 *
	 * @param int $post_id  The post ID.
	 */
	public static function save( int $post_id ) {
		if ( array_key_exists( 'wporg_field', $_POST ) ) {
			update_post_meta(
				$post_id,
				'_wporg_meta_key',
				$_POST['wporg_field']
			);
		}
	}


	/**
	 * Display the meta box HTML to the user.
	 *
	 * @param \WP_Post $post   Post object.
	 */
	public static function html( $post ) {
		$value = get_post_meta( $post->ID, '_wporg_meta_key', true );
		?>
		<label for="wporg_field">Description for this field</label>
		<select name="wporg_field" id="wporg_field" class="postbox">
			<option value="">Select something...</option>
			<option value="something" <?php selected( $value, 'something' ); ?>>Something</option>
			<option value="else" <?php selected( $value, 'else' ); ?>>Else</option>
		</select>
		<?php
	}
}

add_action( 'add_meta_boxes', [ 'WPOrg_Meta_Box', 'add' ] );
add_action( 'save_post', [ 'WPOrg_Meta_Box', 'save' ] );

# USING AJAX
# first define trigger. here it's 'change'
?>
<script>
    /*jslint browser: true, plusplus: true */
    (function ($, window, document) {
        'use strict';
        // execute when the DOM is ready
        $(document).ready(function () {
            // js 'change' event triggered on the wporg_field form field
            $('#wporg_field').on('change', function () {
                // our code
            });
        });
    }(jQuery, window, document));
</script>
<?php
# then do client-side code
# got URL from wporg_meta_box_obj
?>
<script>
    /*jslint browser: true, plusplus: true */
    (function ($, window, document) {
        'use strict';
        // execute when the DOM is ready
        $(document).ready(function () {
            // js 'change' event triggered on the wporg_field form field
            $('#wporg_field').on('change', function () {
                // jQuery post method, a shorthand for $.ajax with POST
                $.post(wporg_meta_box_obj.url,                        // or ajaxurl
                    {
                        action: 'wporg_ajax_change',               // POST data, action
                        wporg_field_value: $('#wporg_field').val() // POST data, wporg_field_value
                    }, function (data) {
                        // handle response data
                        if (data === 'success') {
                            // perform our success logic
                        } else if (data === 'failure') {
                            // perform our failure logic
                        } else {
                            // do nothing
                        }
                    }
                );
            });
        });
    }(jQuery, window, document));
</script>
<?php
# Enqueue client-side code
# goes here: /plugin-name/admin/meta-boxes/js/admin.js
# call from here: /plugin-name/plugin.php
?>
<script>
	function wporg_meta_box_scripts()
	{
	    // get current admin screen, or null
	    $screen = get_current_screen();
	    // verify admin screen object
	    if (is_object($screen)) {
	        // enqueue only for specific post types
	        if (in_array($screen->post_type, ['post', 'wporg_cpt'])) {
	            // enqueue script
	            wp_enqueue_script('wporg_meta_box_script', plugin_dir_url(__FILE__) . 'admin/meta-boxes/js/admin.js', ['jquery']);
	            // localize script, create a custom js object
	            wp_localize_script(
	                'wporg_meta_box_script',
	                'wporg_meta_box_obj',
	                [
	                    'url' => admin_url('admin-ajax.php'),
	        ]
	        );
	        }
	    }
	}
	add_action('admin_enqueue_scripts', 'wporg_meta_box_scripts');
</script>
<?php
# server-side code:
function wporg_meta_box_scripts() {
	// Get current admin screen, or null.
	$screen = get_current_screen();
	// Verify admin screen object before use.
	if ( is_object( $screen ) ) {
		// Enqueue only for specific post types.
		if ( in_array( $screen->post_type, [ 'post', 'wporg_cpt' ], true ) ) {
			wp_enqueue_script( 'wporg_meta_box_script', plugin_dir_url( __FILE__ ) . 'admin/meta-boxes/js/admin.js', [ 'jquery' ], '1.0.0', true );
			wp_localize_script(
				'wporg_meta_box_script',
				'wporg_meta_box_obj',
				[
					'url' => admin_url( 'admin-ajax.php' ),
				]
			);
		}
	}
}
add_action( 'admin_enqueue_scripts', 'wporg_meta_box_scripts' );

# non-exhaustive list of metadata rendering funcs
// the_meta() – Template tag that automatically lists all Custom Fields of a post
// get_post_custom() and get_post_meta() – Retrieves one or all metadata of a post.
// get_post_custom_values() – Retrieves values for a custom post field.

























