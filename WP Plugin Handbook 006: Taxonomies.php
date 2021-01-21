<?php
# TAXONOMIES
// what you want to use when "Categories" and "Tags" don't quite fit the bill
// stored in term_taxonomy table
// taxonomies have terms which are what you use to group and classify things
// terms are stored in terms table
// ie: taxonomy 'music' has terms 'metal', 'hiphop', 'jazz'

# NOTE: taxonomies don't need custom plugins / can be added in a theme or part of an existing plugin.

/*
* Plugin Name: Course Taxonomy
* Description: A short example showing how to add a taxonomy called Course.
* Version: 1.0
* Author: developer.wordpress.org
* Author URI: https://codex.wordpress.org/User:Aternus
*/

function wporg_register_taxonomy_course() {
	$labels = array(
		'name'              => _x( 'Courses', 'taxonomy general name' ),
		'singular_name'     => _x( 'Course', 'taxonomy singular name' ),
		'search_items'      => __( 'Search Courses' ),
		'all_items'         => __( 'All Courses' ),
		'parent_item'       => __( 'Parent Course' ),
		'parent_item_colon' => __( 'Parent Course:' ),
		'edit_item'         => __( 'Edit Course' ),
		'update_item'       => __( 'Update Course' ),
		'add_new_item'      => __( 'Add New Course' ),
		'new_item_name'     => __( 'New Course Name' ),
		'menu_name'         => __( 'Course' ),
	);
	$args   = array(
		'hierarchical'      => true, // make it hierarchical (like categories)
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => [ 'slug' => 'course' ],
	);
	register_taxonomy( 'course', [ 'post' ], $args );
}
add_action( 'init', 'wporg_register_taxonomy_course' ); // adds this function to init hook

// The new taxonomy should show up under "Tags" in new post page

// examples of taxonomy related functions:
//  the_terms: Takes a Taxonomy argument and renders the terms in a list.
//  wp_tag_cloud: Takes a Taxonomy argument and renders a tag cloud of the terms.
//  is_taxonomy: Allows you to determine if a given taxonomy exists.
