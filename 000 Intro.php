<?php
/**
 * https://semver.org/
 * https://flowcanon.com/software/versioning-strategy/
 * VERSIONING:
 * Given a version number MAJOR.MINOR.PATCH, increment the:
 *      MAJOR version when you make incompatible API changes,
 *      MINOR version when you add functionality in a backwards compatible manner, and
 *      PATCH version when you make backwards compatible bug fixes.
 *      Additional labels for pre-release and build metadata are available as extensions to the MAJOR.MINOR.PATCH format.
 *
 *
 * WP Header Fields:
 * Plugin Name: (required) The name of your plugin, which will be displayed in the Plugins list in the WordPress Admin.
 * Plugin URI: The home page of the plugin, which should be a unique URL, preferably on your own website. This must be unique to your plugin. You cannot use a WordPress.org URL here.
 * Description: A short description of the plugin, as displayed in the Plugins section in the WordPress Admin. Keep this description to fewer than 140 characters.
 * Version: The current version number of the plugin, such as 1.0 or 1.0.3.
 * Requires at least: The lowest WordPress version that the plugin will work on.
 * Requires PHP: The minimum required PHP version.
 * Author: The name of the plugin author. Multiple authors may be listed using commas.
 * Author URI: The author’s website or profile on another website, such as WordPress.org.
 * License: The short name (slug) of the plugin’s license (e.g. GPLv2). More information about licensing can be found in the WordPress.org guidelines.
 * License URI: A link to the full text of the license (e.g. https://www.gnu.org/licenses/gpl-2.0.html).
 * Text Domain: The gettext text domain of the plugin. More information can be found in the Text Domain section of the How to Internationalize your Plugin page.
 * Domain Path: The domain path lets WordPress know where to find the translations. More information can be found in the Domain Path section of the How to Internationalize your Plugin page.
 * Network: Whether the plugin can only be activated network-wide. Can only be set to true, and should be left out when not needed.
 *
 *
 * EXAMPLE 1:
 * Plugin Name:       My Basics Plugin
 * Plugin URI:        https://example.com/plugins/the-basics/
 * Description:       Handle the basics with this plugin.
 * Version:           1.10.3
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            John Smith
 * Author URI:        https://author.example.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       my-basics-plugin
 * Domain Path:       /languages
 *
 *
 * EXAMPLE 2: (Allows for PHPDoc DocBlock)
 * Plugin Name
 *
 * @package           PluginPackage
 * @author            Your Name
 * @copyright         2019 Your Name or Company Name
 * @license           GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       Plugin Name
 * Plugin URI:        https://example.com/plugin-name
 * Description:       Description of the plugin.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Your Name
 * Author URI:        https://example.com
 * Text Domain:       plugin-slug
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 *
 */

// AVOID NAME COLLISIONS: THREE METHODS
/*--------------------------------------------------------------------------------------------------------------------*/

// 1. PREFERRED: Variables defined within classes / methods are not accessible globally
//      You still need to prefix your class name

// Example:
if ( !class_exists( 'WPOrg_Plugin' ) ) {
    class WPOrg_Plugin
    {
        public static function init() {
            register_setting( 'wporg_settings', 'wporg_option_foo' );
        }

        public static function get_foo() {
            return get_option( 'wporg_option_foo' );
        }
    }

    WPOrg_Plugin::init();
    WPOrg_Plugin::get_foo();
}

// 2. Prefix everything (classes, functions, vars, etc.)

// 3. Check for existing implementations:
//      Variables: isset() (includes arrays, objects, etc.)
//      Functions: function_exists()
//      Classes: class_exists()
//      Constants: defined()

// Example:
//Create a function called "wporg_init" if it doesn't already exist
if ( !function_exists( 'wporg_init' ) ) {
    function wporg_init() {
        register_setting( 'wporg_settings', 'wporg_option_foo' );
    }
}

//Create a function called "wporg_get_foo" if it doesn't already exist
if ( !function_exists( 'wporg_get_foo' ) ) {
    function wporg_get_foo() {
        return get_option( 'wporg_option_foo' );
    }
}


// FILE ORGANIZATION
/*--------------------------------------------------------------------------------------------------------------------*/

//The root level of your plugin directory should contain your plugin-name.php file and,
//optionally, your uninstall.php file. All other files should be organized into sub folders whenever possible.

// Sample Directory Structure
/*
/plugin-name
    plugin-name.php
    uninstall.php
    /languages
    /includes
    /admin
        /js
        /css
        /images
    /public
        /js
        /css
        /images
*/


// CONDITIONAL LOADING
/*--------------------------------------------------------------------------------------------------------------------*/

// Separate admin code from public code using is_admin()
// Example:
if ( is_admin() ) {
    // we are in admin mode
    require_once __DIR__ . '/admin/plugin-name-admin.php';
}


// URLs AND PLUGIN FILES
/*--------------------------------------------------------------------------------------------------------------------*/

// always use plugins_url('filename.js',__FILE__) to get the scripts full URL
// Example:
plugins_url( 'myscript.js', __FILE__);

// then load it into the page with either wp_enqueue_script() or wp_enqueue_style() depending on js or css
// Example:
wp_enqueue_script(plugins_url('myjs.js', __FILE__));
wp_enqueue_style(plugins_url('mycss.css', __FILE__));

// Plugin url functions
plugins_url();
plugin_dir_url();
plugin_dir_path();
plugin_basename();

// Theme url functions
get_template_directory_uri();
get_stylesheet_directory_uri();
get_stylesheet_uri();
get_theme_root_uri();
get_theme_root();
get_theme_roots();
get_stylesheet_directory();
get_template_directory();

// Site Home url functions
home_url();
get_home_path();

// WP url functions
admin_url();
site_url();
content_url();
includes_url();
wp_upload_dir();

// Multisite url functions
get_admin_url();
get_home_url();
get_site_url();
network_admin_url();
network_site_url();
network_home_url();

// url constants
// Available per default in MS, not set in single site install
// Can be used in single site installs (as usual: at your own risk)
UPLOADS; // (If set, uploads folder, relative to ABSPATH) (for e.g.: /wp-content/uploads)
WP_CONTENT_DIR;  // no trailing slash, full paths only
WP_CONTENT_URL;  // full url
WP_PLUGIN_DIR;  // full path, no trailing slash
WP_PLUGIN_URL;  // full url, no trailing slash

// WP directories
home_url();     // Home URL:	            http://www.example.com
site_url();     // Site Directory URL:      http://www.example.com or http://www.example.com/wordpress
admin_url();    // Admin directory URL:     http://www.example.com/wp-admin
includes_url(); // Includes directory URL:	http://www.example.com/wp-includes
content_url();  // Content directory URL:	http://www.example.com/wp-content
plugins_url();  // Plugins directory URL:	http://www.example.com/wp-content/plugins
wp_upload_dir();// Upload directory URL:    (returns an array)	http://www.example.com/wp-content/uploads

# User Roles


// WP SECURITY
/*--------------------------------------------------------------------------------------------------------------------*/

# Database calls / use WP API
$post_title = 'Titles!';
$id = 13245;
$wpdb->update(
	$wpdb->posts,
	array('post_title'=>$post_title),
	array('ID'=>$id)
);

# update conditionals
$content = "blah blah blah";

$sets = array(
	'post_title'=>$post_title,
	'content'=>$content
);

$my_name = "blah blah blah";
$wheres = array(
	'post_type'=>'post',
	'post_name'=>$my_name
);

$wpdb->update($wpdb->posts, $sets, $wheres);

# db insert
$table = 'some table';
$data = 'some data';
$wpdb->insert($table, $data);

# for more complex select statements
$some_name = 'name';
$some_id = 234;

$wpdb->prepare(
	"SELECT * FROM $wpdb->posts
	WHERE post_name = %s OR ID=%d",
	$some_name,
	$some_id
);

# XSS (cross site scripting)
# all escaping functions begin with esc_
# basic esc function:  esc_attr_e();

# escape html
$title = 'title';
echo esc_html($title);

# escape attribute
esc_attr();

# escape urls
esc_url();
esc_url_raw();

# escape text areas
esc_textarea();

# escape html
wp_filter_kses();

# CSRF (cross-site request forgery)
# authorization: what you're allowed to do
# intention: what you want to do
# tricking somebody's browser into allowing you their authorizations

# Nonces
# just pass in a string that represents whatever you're using it for and stick it in a form
# ie:
?>
<form id="htafurms">
	<?=wp_nonce_field('plugin-action_object');?>
</form>
<?
# then verify the nonce with the same string used to create the nonce:
check_admin_referer('plugin-action_object');

# CSRF for Ajax/XHR
// 1. on the front end:
$nonce = wp_create_nonce('my_action');

// 2. add &_ajax_nonce=$nonce to your post/get vars

// 3. check it on the backend
check_ajax_referer('my_action');


// USER ROLES AND CAPABILITIES
/*--------------------------------------------------------------------------------------------------------------------*/

// Example of proper role utilization
// generates delete link based on the homepage url
function plugin_generate_delete_link($content){
	// Run only for single post page.
	if(is_single() && in_the_loop() && is_main_query()){
		// Add query arguments: action, post.
		$url = add_query_arg(
			[
				'action' =>'wporg_frontend_delete',
				'post'   =>get_the_ID(),
			], home_url());
		return $content.' <a href="'.esc_url($url).'">'.esc_html__('Delete Post', 'wporg').'</a>';
	}
    return null;
}

// request handler
function plugin_delete_post(){
	if(isset($_GET['action']) && 'wporg_frontend_delete' === $_GET['action']){
		// Verify we have a post id.
		$post_id = (isset($_GET['post'])) ? ($_GET['post']) : (null);
		// Verify there is a post with such a number.
		$post = get_post((int)$post_id);
		if(empty($post)){
			return;
		}
		// Delete the post.
		wp_trash_post($post_id);
		// Redirect to admin page.
		$redirect = admin_url('edit.php');
		wp_safe_redirect($redirect);
		// We are done.
		die;
	}
}

// THIS IS THE MAGIC PART RIGHT HERE => current_user_can('edit_others_posts')  <= RIGHT HERE!!!
if(current_user_can('edit_others_posts')){
	// Add the delete link to the end of the post content
	add_filter('the_content', 'wporg_generate_delete_link');
    // Register our request handler with the init hook.
	add_action('init', 'wporg_delete_post');
}

// DATA VALIDATION
/*--------------------------------------------------------------------------------------------------------------------*/

// along with the traditional PHP validation methods, WP provides a few awesome tools as well:

is_email();
term_exists();
username_exists();
validate_file();

// DATA SANITIZATION
/*--------------------------------------------------------------------------------------------------------------------*/

sanitize_key();
sanitize_email();
sanitize_file_name();
sanitize_hex_color();
sanitize_hex_color_no_hash();
sanitize_html_class();
sanitize_key();
sanitize_meta();
sanitize_mime_type();
sanitize_option();
sanitize_sql_orderby();
sanitize_text_field();
sanitize_textarea_field();
sanitize_title();
sanitize_title_for_query();
sanitize_title_with_dashes();
sanitize_user();
esc_url_raw();
wp_kses();
wp_kses_post();

// ESCAPING DATA
/*--------------------------------------------------------------------------------------------------------------------*/

// you can safely use most WP functions without escaping them as they escape data by default
// for example, the_title() can be called without wrapping it in an escape function
esc_attr();     // Use on everything else that’s printed into an HTML element’s attribute.
esc_html();     // Use anytime an HTML element encloses a section of data being displayed.
	esc_js();   // Use for inline Javascript.
esc_textarea(); // Use this to encode text for use inside a textarea element.
esc_url();      // Use on all URLs, including those in the src and href attributes of an HTML element.
esc_url_raw();  // Use when storing a URL in the database or in other cases where non-encoded URLs are needed.
wp_kses();      // Use for all non-trusted HTML (post text, comment text, etc.)
wp_kses_post(); // Alternative version of wp_kses() that automatically allows all HTML that is permitted in post content.
wp_kses_data(); // Alternative version of wp_kses() that allows only the HTML permitted in post comments.

// using *_e() and __() localization instead of echo()
esc_html_e('hello world', 'text_domain');
// or
echo esc_html(__('hello world', 'text_domain'));

// these combine localization AND escaping:
esc_html__();
esc_html_e();
esc_html_x();
esc_attr__();
esc_attr_e();
esc_attr_x();

// using the "kisses" functions to customize your escapes
$custom_content = '<html><body><div><a>click me</a></div></body></html>';
$allowed_html = array(
	'a'      => array(
		'href'  => array(),
		'title' => array(),
	),
	'br'     => array(),
	'em'     => array(),
	'strong' => array(),
);
echo wp_kses( $custom_content, $allowed_html );

wp_kses_post(); // is a wrapper function for wp_kses() where $allowed_html is a set of rules used by post content.

// NONCES (Number used ONCE)
/*--------------------------------------------------------------------------------------------------------------------*/
// wp article on nonces: https://markjaquith.wordpress.com/2006/06/02/wordpress-203-nonces/
wp_create_nonce(); // generated with each action available to the user
wp_verify_nonce(); // verifies the nonce after action is attempted

// here's some WP example code:
function wporg_generate_delete_link($content){
	// Run only for single post page.
	if(is_single() && in_the_loop() && is_main_query()){
		// Add query arguments: action, post, nonce
		$url = add_query_arg(
			[
				'action' =>'wporg_frontend_delete',
				'post'   =>get_the_ID(),
				'nonce'  =>wp_create_nonce('wporg_frontend_delete'),
			], home_url());
		return $content.' <a href="'.esc_url($url).'">'.esc_html__('Delete Post', 'wporg').'</a>';
	}
    return null;
}

function wporg_delete_post(){
	if(isset($_GET['action']) && isset($_GET['nonce']) && 'wporg_frontend_delete' === $_GET['action'] && wp_verify_nonce($_GET['nonce'], 'wporg_frontend_delete')){
		// Verify we have a post id.
		$post_id = (isset($_GET['post'])) ? ($_GET['post']) : (null);
		// Verify there is a post with such a number.
		$post = get_post((int)$post_id);
		if(empty($post)){
			return;
		}
		// Delete the post.
		wp_trash_post($post_id);
		// Redirect to admin page.
		$redirect = admin_url('edit.php');
		wp_safe_redirect($redirect);
		// We are done.
		die;
	}
}

if(current_user_can('edit_others_posts')){
	add_filter('the_content', 'wporg_generate_delete_link');
	add_action('init', 'wporg_delete_post');
}

// HOOKS
/*--------------------------------------------------------------------------------------------------------------------*/
// Two types of hooks: Actions & Filters
// Actions: Allows adding data or altering how WP functions. Actions interrupt code flow.
// Filters: Alters data during execution. Filters alter data for later use.
// * aside from the pre-packaged hooks, you can also build your own

// HOOKS:ACTIONS
/*--------------------------------------------------------------------------------------------------------------------*/
// two steps:
//    1. create callback function
//      will be called when action is run. Prefix new function and put in functions.php (or somewhere callable)
//    2. hook (assign) your callback function
add_action(); # will hook the function
// ie:
function wporg_callback(){
    // do your shit
}
// hooks wporg_callback to init action
// priority for callback function 1 through 20.
// default is 10.
// callbacks are run in ascending order 1, 2, 3, 4, 5, etc.
// priority is automatically assigned by default in the order they were registered
$priority = 1;
$accepted_args= 4; // number of args to pass to the callback
add_action('init','wporg_callback', $priority, $accepted_args);

// accepted_args ie:
do_action('save_post', $post->ID, $post);
add_action('save_post', 'wporg_custom', 10, 2);
function wporg_custom($post_id, $post){
    // whatevz
}

// HOOKS:FILTERS
/*--------------------------------------------------------------------------------------------------------------------*/
// should always function in isolated manner
// no side-effects like altering globals or output
// two steps:
// 1. create callback
// 2. hook callback

// filter ie:
function wporg_filter_title($title){
    return 'The '.$title.' was filtered';
}
add_filter('the_title', 'wporg_filter_title');

// another filter example:
function wporg_css_body_class($classes){
    if(! is_admin()){
        $classes[] = 'wporg-is-awesome';
    }
    return $classes;
}
add_filter('body_class','wporg_css_body_class');

// CUSTOM HOOKS
/*--------------------------------------------------------------------------------------------------------------------*/
// called same was as wpcore hooks
// do_action() for actions
// apply_filter() for filters

// actions ie:
do_action('wporg_after_settings_page_html');
add_action('wporg_after_settings_page_html', 'myprefix_add_settings');

// filter ie:
function wporg_create_post_type(){
    $post_type_params = [/* ... */];
    register_post_type('post_type_slug',
                       apply_filters('wporg_post_type_params',$post_type_params));
}

function myprefix_change_post_type_params($post_type_params){
    $post_type_params['hierarchical'] = true;
    return $post_type_params;
}

add_filter('wporg_post_type_params','myprefix_change_post_type_params');

// removing hooks and callbacks
// the parameters must be identical to the function's that registered it
// ie:
function wporg_setup_slider(){}
add_action('template_redirect','wporg_setup_slider',9);

// remove
function wporg_disable_slider(){
    // all parameters must match
    remove_action('template_redirect','wporg_setup_slider',9);
}
// call AFTER the add_action was called
add_action('after_setup_theme','wporg_disable_slider');

// remove all callbacks:
remove_all_actions();
remove_all_filters();

// debugging / determine the current hook
current_action();
current_filter();

// running hook once or checking how many times it's been run
function wp_org_custom(){
    if(did_action('save_post') !== 1){
        return;
    }
}
add_action('save_post','wporg_custom');

// debug with the "all" hook
function wporg_debug(){
    echo current_action();
}
add_action('all','wporg_debug');

// ADDING PRIVACY POLICY TO PLUGIN
/*--------------------------------------------------------------------------------------------------------------------*/
// Recommendations for privacy policy:
//What personal data we collect and why we collect it
//Their own manually input information
//WP: Contact forms
//WP: Comments
//WP: Cookies
//WP: Third party embeds
//Analytics
//Who we share your data with
//How long we retain your data
//What rights you have over your data
//Where we send your data
//Your contact information
//How we protect your data
//What data breach procedures we have in place
//What third parties we receive data from
//What automated decision making and/or profiling we do with user data
//Any industry regulatory disclosure requirements

// use to add your apps policy:
wp_add_privacy_policy_content (link);

// adding policy example:
function wporg_add_privacy_policy_content() {
	if ( ! function_exists( 'wp_add_privacy_policy_content' ) ) {
		return;
	}
	$content = '<p class="privacy-policy-tutorial">' . __( 'Some introductory content for the suggested text.', 'text-domain' ) . '</p>'
		. '<strong class="privacy-policy-tutorial">' . __( 'Suggested Text:', 'my_plugin_textdomain' ) . '</strong> '
		. sprintf(
			__( 'When you leave a comment on this site, we send your name, email address, IP address and comment text to example.com. Example.com does not retain your personal data. The example.com privacy policy is <a href="%1$s" target="_blank">here</a>.', 'text-domain' ),
			'https://example.com/privacy-policy');
	wp_add_privacy_policy_content( 'Example Plugin', wp_kses_post( wpautop( $content, false ) ) );
}
// add policy at install-ish init? whatever ... this ...
add_action( 'admin_init', 'wporgmy_example_plugin_add_privacy_policy_content' );

// ADDING PERSONAL DATA EXPORTER TO PLUGIN
/*--------------------------------------------------------------------------------------------------------------------*/
/**
 * Export user meta for a user using the supplied email.
 *
 * @param string $email_address   email address to manipulate
 * @param int    $page            pagination
 *
 * @return array
 */
function wporg_export_user_data_by_email( $email_address, $page = 1 ) {
	$number = 500; // Limit us to avoid timing out
	$page   = (int) $page;

	$export_items = array();

	$comments = get_comments(
		array(
			'author_email' => $email_address,
			'number'       => $number,
			'paged'        => $page,
			'order_by'     => 'comment_ID',
			'order'        => 'ASC',
		)
	);

	foreach ( (array) $comments as $comment ) {
		$latitude  = get_comment_meta( $comment->comment_ID, 'latitude', true );
		$longitude = get_comment_meta( $comment->comment_ID, 'longitude', true );

		// Only add location data to the export if it is not empty.
		if ( ! empty( $latitude ) ) {
			// Most item IDs should look like postType-postID. If you don't have a post, comment or other ID to work with,
			// use a unique value to avoid having this item's export combined in the final report with other items
			// of the same id.
			$item_id = "comment-{$comment->comment_ID}";

			// Core group IDs include 'comments', 'posts', etc. But you can add your own group IDs as needed
			$group_id = 'comments';

			// Optional group label. Core provides these for core groups. If you define your own group, the first
			// exporter to include a label will be used as the group label in the final exported report.
			$group_label = __( 'Comments', 'text-domain' );

			// Plugins can add as many items in the item data array as they want.
			$data = array(
				array(
					'name'  => __( 'Commenter Latitude', 'text-domain' ),
					'value' => $latitude,
				),
				array(
					'name'  => __( 'Commenter Longitude', 'text-domain' ),
					'value' => $longitude,
				),
			);

			$export_items[] = array(
				'group_id'    => $group_id,
				'group_label' => $group_label,
				'item_id'     => $item_id,
				'data'        => $data,
			);
		}
	}

	// Tell core if we have more comments to work on still.
	$done = count( $comments ) > $number;
	return array(
		'data' => $export_items,
		'done' => $done,
	);
}

/**
 * Registers all data exporters.
 *
 * @param array $exporters
 *
 * @return mixed
 */
function wporg_register_user_data_exporters( $exporters ) {
	$exporters['my-plugin-slug'] = array(
		'exporter_friendly_name' => __( 'Comment Location Plugin', 'text-domain' ),
		'callback'               => 'my_plugin_exporter',
	);
	return $exporters;
}

add_filter( 'wp_privacy_personal_data_exporters', 'wporg_register_user_data_exporters' );

// ADDING PERSONAL DATA ERASER
/*--------------------------------------------------------------------------------------------------------------------*/
/**
 * Removes any stored location data from a user's comment meta for the supplied email address.
 *
 * @param string $email_address   email address to manipulate
 * @param int    $page            pagination
 *
 * @return array
 */
function wporg_remove_location_meta_from_comments_for_email( $email_address, $page = 1 ) {
	$number = 500; // Limit us to avoid timing out
	$page   = (int) $page;

	$comments = get_comments(
		array(
			'author_email' => $email_address,
			'number'       => $number,
			'paged'        => $page,
			'order_by'     => 'comment_ID',
			'order'        => 'ASC',
		)
	);

	$items_removed = false;

	foreach ( (array) $comments as $comment ) {
		$latitude  = get_comment_meta( $comment->comment_ID, 'latitude', true );
		$longitude = get_comment_meta( $comment->comment_ID, 'longitude', true );

		if ( ! empty( $latitude ) ) {
			delete_comment_meta( $comment->comment_ID, 'latitude' );
			$items_removed = true;
		}

		if ( ! empty( $longitude ) ) {
			delete_comment_meta( $comment->comment_ID, 'longitude' );
			$items_removed = true;
		}
	}

	// Tell core if we have more comments to work on still
	$done = count( $comments ) < $number;
	return array(
		'items_removed'  => $items_removed,
		'items_retained' => false, // always false in this example
		'messages'       => array(), // no messages in this example
		'done'           => $done,
	);
}

/**
 * Registers all data erasers.
 *
 * @param array $exporters
 *
 * @return mixed
 */
function wporg_register_privacy_erasers( $erasers ) {
	$erasers['my-plugin-slug'] = array(
		'eraser_friendly_name' => __( 'Comment Location Plugin', 'text-domain' ),
		'callback'             => 'wporg_remove_location_meta_from_comments_for_email',
	);
	return $erasers;
}

add_filter( 'wp_privacy_personal_data_erasers', 'wporg_register_privacy_erasers' );

// PRIVACY RELATED OPTIONS, HOOKS, AND CAPABILITIES
/*--------------------------------------------------------------------------------------------------------------------*/

// Options:
wp_page_for_privacy_policy; // contains the page ID of a site’s privacy page

// Actions:
user_request_action_confirmed; // fired when a user confirms a privacy request
wp_privacy_delete_old_export_files; // a scheduled action used to prune old exports from the personal data exports folder
wp_privacy_personal_data_erased; // fired after the last page of the last eraser is complete
wp_privacy_personal_data_export_file; // used to create a personal data export file as part of the export flow
wp_privacy_personal_data_export_file_created; // fires after a personal data export file has been created

// Filters:
privacy_policy_url; //filters the URL of the privacy policy page.
the_privacy_policy_link; //filters the privacy policy page link HTML.
wp_get_default_privacy_policy_content; //filters the default content suggested for inclusion through the privacy policy guide.
user_request_action_confirmed_message; //allows modifying the action confirmation message displayed to the user
user_request_action_description; //filters the user action description.
user_request_action_email_content; //filters the text of the email sent when an account action is attempted.
user_request_action_email_headers; //filters the headers of the email sent when an account action is attempted.
user_request_action_email_subject; //filters the subject of the email sent when an account action is attempted.
user_request_confirmed_email_content; //filters the body of the user request confirmation email.
user_request_confirmed_email_headers; //filters the headers of the user request confirmation email.
user_request_confirmed_email_subject; //filters the subject of the user request confirmation email.
user_request_confirmed_email_to; //filters the recipient of the data request confirmation notification.
user_request_key_expiration; //filters the expiration time of confirmation keys for user requests.
wp_privacy_additional_user_profile_data; //filter to extend the user’s profile data for the privacy exporter.
wp_privacy_export_expiration; //controls how old export files are allowed to get, default is 3 days
wp_privacy_personal_data_email_content; //allows modifying the email message send to users with their personal data export file link
wp_privacy_personal_data_email_headers; //filters the headers of the email sent with a personal data export file.
wp_privacy_personal_data_email_subject; //filters the subject of the email sent when an export request is completed.

// Note:
// wp_privacy_personal_data_email_to
// Should be used with great caution to avoid sending the data export link to the wrong recipient email address(es).
wp_privacy_personal_data_email_to; //filters the recipient of the personal data export email notification.

wp_privacy_personal_data_erasers; //supports registration of core and plugin personal data erasers
wp_privacy_personal_data_erasure_page; //Filters a page of personal data eraser data. Allows the erasure response to be consumed by destinations in addition to Ajax.
wp_privacy_personal_data_exporters; //supports registration of core and plugin personal data exporters
wp_privacy_personal_data_export_page; //filters a page of personal data exporter data. Used to build the export report. Allows the export response to be consumed by destinations in addition to Ajax.
wp_privacy_anonymize_data; //filters the anonymous data for each type.
wp_privacy_exports_dir; //filters the directory used to store personal data export files.
wp_privacy_exports_url; //filters the URL of the directory used to store personal data export files.
user_confirmed_action_email_content; //Filters the body of the user request confirmation email. The email is sent to an administrator when an user request is confirmed.
user_erasure_fulfillment_email_to; //Filters the recipient of the data erasure fulfillment notification.
user_erasure_complete_email_subject; //Filters the subject of the email sent when an erasure request is completed.
user_confirmed_action_email_content; //Filters the body of the data erasure fulfillment notification. The email is sent to a user when a their data erasure request is fulfilled by an administrator.
user_erasure_complete_email_headers; //Filters the headers of the data erasure fulfillment notification.

// Capabilities:
// Access to the privacy tools is controlled by a few new capabilities. Administrators (on non-multisite installations)
// have these capabilities by default. These capabilities are:
erase_others_personal_data; // determines if the Erase Personal Data sub-menu is available under Tools
export_others_personal_data; // determines if the Export Personal Data sub-menu is available under Tools
manage_privacy_options; // determines if the Privacy sub-menu is available under Settings
