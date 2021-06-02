<?php
// Post-Types are stored in 'posts' table - allowing for custom types

# REGISTERING CUSTOM POST TYPES
/* WP default post types:
1. post
2. page
3. attachment
4. revision
5. menu
*/

// registration gives new type a top-level admin screen

// registering new post type using register_post_type().
// Call before admin_init hook and after after_setup_theme hook
// recommended to use init hook
// new post type name cannot be larger than 20 varchar ( database field is varchar(20) )
// use basic naming conventions to avoid collisions
$args_array = [];
register_post_type('prefix_post-type-name', $args_array);

// example:
function wporg_custom_post_type() {
	register_post_type('wporg_product',
	                   array(
		                   'labels'      => array(
			                   'name'          => __('Products', 'textdomain'),
			                   'singular_name' => __('Product', 'textdomain'),
		                   ),
		                   'public'      => true,
		                   'has_archive' => true,
	                   )
	);
}
add_action('init', 'wporg_custom_post_type');

# URLs
// custom post types get their own slugs
// default urls for cust post types: http://example.com/prefix_post-type/%post_name%

# CUSTOM SLUGS
// add 'rewrite'=>'value' in register_post_type() args for custom slug
function wporg_custom_post_type() {
	register_post_type('wporg_product',
	                   array(
		                   'labels'      => array(
			                   'name'          => __( 'Products', 'textdomain' ),
			                   'singular_name' => __( 'Product', 'textdomain' ),
		                   ),
		                   'public'      => true,
		                   'has_archive' => true,
		                   'rewrite'     => array( 'slug' => 'products' ), // my custom slug
	                   )
	);
}
add_action('init', 'wporg_custom_post_type');

# TEMPLATES
// custom templates for custom post types using single.php & archive.php
// ie:
// single-{post_type}.php
// archive-{post_type}.php
is_post_type_archive(); // self explanatory
post_type_archive_title(); // self explanatory

# QUERYING BY POST TYPE
$args = array(
	'post_type'      => 'product',
	'posts_per_page' => 10,
);
$loop = new WP_Query($args);
while ( $loop->have_posts() ) {
	$loop->the_post();
	?>
	<div class="entry-content">
		<?php the_title(); ?>
		<?php the_content(); ?>
	</div>
	<?php
}

# ALTERING MAIN QUERY
// add custom post types to main query automatically by using pre_get_posts action hook
function wporg_add_custom_post_types($query) {
	if ( is_home() && $query->is_main_query() ) {
		$query->set( 'post_type', array( 'post', 'page', 'movie' ) );
	}
	return $query;
}
add_action('pre_get_posts', 'wporg_add_custom_post_types');



















































