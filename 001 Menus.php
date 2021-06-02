<?php

$page_title = 'Great Page Title';
$menu_title = 'Menu Title';
$capability = 'dunno ...';
$menu_slug  = 'menu/';
$function   = 'callable_function_name';
$icon_url   = 'https://whatevz.com/pics/icons/stuffs/icon.ico';
$position   = 5; // the position the menu will render in

// add top-level menu in admin
add_menu_page(
	$page_title,
    $menu_title,
    $capability,
    $menu_slug,
    $function = '',
    $icon_url = '',
    $position = NULL
);

// TOP-LEVEL MENU EXAMPLE
/*--------------------------------------------------------------------------------------------------------------------*/
// NOTE: wrap HTML using <div> with the class: 'wrap'
function wporg_options_page_html(){
	?>
	<div class="wrap">
		<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
		<form action="options.php" method="post">
			<?php
			// output security fields for the registered setting "wporg_options"
			settings_fields( 'wporg_options' );
			// output setting sections and their fields
			// (sections are registered for "wporg", each field is registered to a specific section)
			do_settings_sections( 'wporg' );
			// output save settings button
			submit_button( __( 'Save Settings', 'textdomain' ) );
			?>
		</form>
	</div>
	<?php
}
?>

// REGISTER THE TOP-LEVEL MENU
/*--------------------------------------------------------------------------------------------------------------------*/
// registration should occur admin_menu action hook
<?php
add_action( 'admin_menu', 'wporg_options_page' );
function wporg_options_page() {
	add_menu_page(
		'WPOrg',
		'WPOrg Options',
		'manage_options',
		'wporg',
		'wporg_options_page_html',
		plugin_dir_url(__FILE__) . 'images/icon_wporg.png',
		20
	);
}
?>

// USING A PHP FILE FOR HTML
/*--------------------------------------------------------------------------------------------------------------------*/
// best practice: create callback that requires/includes the PHP file

// passing PHP file path via $menu_slug with a NULL function parameter:
<?php
add_action( 'admin_menu', 'wporg_options_page' );
function wporg_options_page() {
	add_menu_page(
		'WPOrg',
		'WPOrg Options',
		'manage_options',
		plugin_dir_path(__FILE__) . 'admin/view.php',
		Null, // see? IT'S NULL MOTHAFUCKA!!!
		plugin_dir_url(__FILE__) . 'images/icon_wporg.png',
		20
	);
}
?>

// REMOVE TOP-LEVEL MENU
/*--------------------------------------------------------------------------------------------------------------------*/
// WARNING: Removing a menu does NOT prevent user from accessing it
<?php
remove_menu_page(
	$menu_slug
);
?>

Example - removing "Tools" menu
<?php
add_action( 'admin_menu', 'wporg_remove_options_page', 99 );
function wporg_remove_options_page() {
	remove_menu_page( 'tools.php' );
}
?>

// SUBMITTING FORMS
/*--------------------------------------------------------------------------------------------------------------------*/
// Processing forms:
//  1. Use the URL of the page as the action attribute of the form.
//  2. Add a hook with the slug, returned by add_menu_page.

// form action attribute
<form action="<?php menu_page_url( 'wporg' ) ?>" method="post">

// processing forms:
// use the returned $hookname from add_menu_page()
// WP runs load-$hookname action before any HTML output.
// Use $hookname to assign a function and process the form.
// load-$hookname is executed before options page is loaded; even without a form.
<?
add_action( 'admin_menu', 'wporg_options_page' );
function wporg_options_page() {
	$hookname = add_menu_page(
		'WPOrg',
		'WPOrg Options',
		'manage_options',
		'wporg',
		'wporg_options_page_html',
		plugin_dir_url(__FILE__) . 'images/icon_wporg.png',
		20
	);

	add_action( 'load-' . $hookname, 'wporg_options_page_submit' );
}

// USING wporg_options_page_submit AS NEEDED
// IF using this outside of this context, wporg_options_page_submit must always be followed with:
// 1. Check if form is being submitted: ('POST' === $_SERVER['REQUEST_METHOD'])
// 2. CSRF verification
// 3. Validation
// 4. Sanitization

// ADD SUBMENU
/*--------------------------------------------------------------------------------------------------------------------*/
$parent_slug    = '/parent/slug/';
$page_title     = 'page/slug';
$menu_title     = 'Menu Title';
$capability     = 'capability??? ...';
$menu_slug      = 'menu/slug/';
$function       = 'function_name()';

add_submenu_page(
	$parent_slug,
    $page_title,
    $menu_title,
    $capability,
    $menu_slug,
    $function = ''
);

// EXAMPLE:
// create function to output the html
function wporg_options_page_html() {
    // check user capabilities
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }
    ?>
    <div class="wrap">
        <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
        <form action="options.php" method="post">
            <?php
            // output security fields for the registered setting "wporg_options"
            settings_fields( 'wporg_options' );
            // output setting sections and their fields
            // (sections are registered for "wporg", each field is registered to a specific section)
            do_settings_sections( 'wporg' );
            // output save settings button
            submit_button( __( 'Save Settings', 'textdomain' ) );
            ?>
        </form>
    </div>
    <?php
}

// register submenu
function wporg_options_page()
{
    add_submenu_page(
        'tools.php',
        'WPOrg Options',
        'WPOrg Options',
        'manage_options',
        'wporg',
        'wporg_options_page_html'
    );
}
add_action('admin_menu', 'wporg_options_page');

// PREDEFINED HELPER SLUGS FOR TOP-LEVEL MENUS
add_dashboard_page(); //index.php
add_posts_page(); //edit.php
add_media_page(); //upload.php
add_pages_page(); //edit.php?post_type=page
add_comments_page(); //edit-comments.php
add_theme_page(); //themes.php
add_plugins_page(); //plugins.php
add_users_page(); //users.php
add_management_page(); //tools.php
add_options_page(); //options-general.php
add_options_page(); //settings.php
add_links_page(); //link-manager.php; //requires a plugin since WP 3.5+
Custom Post Type; //edit.php?post_type=wporg_post_type
Network Admin; //settings.php

// SUBMITTING FORMS SUB-MENUS
// add_submenu_page() along with all functions for pre-defined sub-menus (add_dashboard_page, add_posts_page, etc.)
// will return a $hookname, which you can use as the first parameter of add_action in order to handle the submission
// of forms within custom pages:

function wporg_options_page() {
    $hookname = add_submenu_page(
        'tools.php',
        'WPOrg Options',
        'WPOrg Options',
        'manage_options',
        'wporg',
        'wporg_options_page_html'
    );

    add_action( 'load-' . $hookname, 'wporg_options_page_html_submit' );
}

add_action('admin_menu', 'wporg_options_page');

// ALWAYS CHECK FOR SUBMISSIONS!!!
// Check for form submission, do CSRF verification, validation, and sanitization.
