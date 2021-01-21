<?php
# USERS

// need: username, password, and email address
// stored in users table
// users are assigned roles
// each role has a set of capabilities

wp_create_user($username, $email, $password);
wp_insert_user($userdata); // object or array describing the user

# example:
// check if the username is taken
$user_id = username_exists( $user_name );

// check that the email address does not belong to a registered user
if ( ! $user_id && email_exists( $user_email ) === false ) {
	// create a random password
	$random_password = wp_generate_password( 12, false );
	// create the user
	$user_id = wp_create_user(
		$user_name,
		$random_password,
		$user_email
	);
}

# using wp_insert_user()
$username  = $_POST['username'];
$password  = $_POST['password'];
$website   = $_POST['website'];
$user_data = [
	'user_login' => $username,
	'user_pass'  => $password,
	'user_url'   => $website,
];

$user_id = wp_insert_user( $user_data );

// success
if ( ! is_wp_error( $user_id ) ) {
	echo 'User created: ' . $user_id;
}

// NOTE: if user already exists, then an update is performed
$user_id = 1;
$website = 'https://wordpress.org';

$user_id = wp_update_user(
	array(
		'ID'       => $user_id,
		'user_url' => $website,
	)
);

if ( is_wp_error( $user_id ) ) {
	// error
} else {
	// success
}

# Delete user with:
wp_delete_user($user_id);

# WORKING WITH USER METADATA
// USER TABLE CONTAINS: ID, user_login, user_pass, user_nicename, user_email, user_url, user_registered, user_activation_key, user_status and display_name
// for other user-specific data, use usermeta table

# Altering user data via form field:
// the show_user_profile hook fires when a user edits THEIR OWN profile
// the edit_user_profile hook fires when a user edits SOMEBODY ELSE's profile

/**
 * The field on the editing screens.
 *
 * @param $user WP_User user object
 */
function wporg_usermeta_form_field_birthday( $user )
{
	?>
	<h3>It's Your Birthday</h3>
	<table class="form-table">
		<tr>
			<th>
				<label for="birthday">Birthday</label>
			</th>
			<td>
				<input type="date"
				       class="regular-text ltr"
				       id="birthday"
				       name="birthday"
				       value="<?= esc_attr( get_user_meta( $user->ID, 'birthday', true ) ) ?>"
				       title="Please use YYYY-MM-DD as the date format."
				       pattern="(19[0-9][0-9]|20[0-9][0-9])-(1[0-2]|0[1-9])-(3[01]|[21][0-9]|0[1-9])"
				       required>
				<p class="description">
					Please enter your birthday date.
				</p>
			</td>
		</tr>
	</table>
	<?php
}

/**
 * The save action.
 *
 * @param $user_id int the ID of the current user.
 *
 * @return bool Meta ID if the key didn't exist, true on successful update, false on failure.
 */
function wporg_usermeta_form_field_birthday_update( $user_id )
{
	// check that the current user have the capability to edit the $user_id
	if ( ! current_user_can( 'edit_user', $user_id ) ) {
		return false;
	}

	// create/update user meta for the $user_id
	return update_user_meta(
		$user_id,
		'birthday',
		$_POST['birthday']
	);
}

// Add the field to user's own profile editing screen.
add_action(
	'show_user_profile',
	'wporg_usermeta_form_field_birthday'
);

// Add the field to user profile editing screen.
add_action(
	'edit_user_profile',
	'wporg_usermeta_form_field_birthday'
);

// Add the save action to user's own profile editing screen update.
add_action(
	'personal_options_update',
	'wporg_usermeta_form_field_birthday_update'
);

// Add the save action to user profile editing screen update.
add_action(
	'edit_user_profile_update',
	'wporg_usermeta_form_field_birthday_update'
);

# ALTER USER DATA PROGRAMMATICALLY

add_user_meta(
	int $user_id,
    string $meta_key,
    mixed $meta_value,
    bool $unique = false
);

update_user_meta(
	int $user_id,
    string $meta_key,
    mixed $meta_value,
    mixed $prev_value = ''
);

delete_user_meta(
	int $user_id,
    string $meta_key,
    mixed $meta_value = ''
);

get_user_meta(
	int $user_id,
    string $key = '',
    bool $single = false
);
// if only user id is passed, ALL data will be returned as an assoc array

# USER ROLES AND CAPABILITIES
// roles and capabilities are stored in options table under user_roles key
// default roles: super admin, administrator, editor, author, contributor, subscriber

function wporg_simple_role() {
	add_role(
		'simple_role',
		'Simple Role',
		array(
			'read'         => true,
			'edit_posts'   => true,
			'upload_files' => true,
		),
    );
}

// Add the simple_role.
add_action( 'init', 'wporg_simple_role' );

// ALTER USER CAPABILITIES
// first remove_role() then re-add role with add_role()

function wporg_simple_role_remove() {
	remove_role( 'simple_role' );
}

// Remove the simple_role.
add_action( 'init', 'wporg_simple_role_remove' );

# NOTE: DON'T REMOVE ADMINISTRATOR OR SUPER ADMIN
# NOTE: recommended to not delete default roles - instead, simply update them.
update_option('default_role', YOUR_NEW_DEFAULT_ROLE);

# CAPABILITIES
// first get role, then add capability
function wporg_simple_role_caps() {
	// Gets the simple_role role object.
	$role = get_role( 'simple_role' );

	// Add a new capability.
	$role->add_cap( 'edit_others_posts', true );
}

// Add simple_role capabilities, priority must be after the initial role definition.
add_action( 'init', 'wporg_simple_role_caps', 11 );
// remove capability
remove_cap();

# USING ROLES AND CAPABILITIES
get_role( $role );

// check if user can have a role or capability
user_can($user, $capability, $args);

// $args is undocumented, but you can include an object to test
// ie: pass postID to test capabilities of that post

// this is a wrapper for user_can()
// it automatically plugs in the current user's id
current_user_can( $capability );


// adding edit link in template file if user has capability
if ( current_user_can( 'edit_posts' ) ) {
	edit_post_link( esc_html__( 'Edit', 'wporg' ), '<p>', '</p>' );
}

// testing capabilities across blogs
current_user_can_for_blog( $blog_id, $capability );






























































