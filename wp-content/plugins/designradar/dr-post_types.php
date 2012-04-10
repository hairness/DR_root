<?php

/* REGISTER CUSTOM POST TYPE FOR OBJECTS  & CLUSTERS */

add_action('init', 'object_register');
 
function object_register() {
 
	$labels = array(
		'name' => _x('Objects', 'post type general name'),
		'singular_name' => _x('Object', 'post type singular name'),
		'add_new' => _x('Add New', 'object'),
		'add_new_item' => __('Add New Object'),
		'edit_item' => __('Edit Object'),
		'new_item' => __('New Object'),
		'view_item' => __('View Object'),
		'search_items' => __('Search Objects'),
		'not_found' =>  __('Nothing found'),
		'not_found_in_trash' => __('Nothing found in Trash'),
		'parent_item_colon' => ''
	);
 
	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'query_var' => true,
		'has_archive' => 'objects', // this is the archive-slug (could be "objects/index"!!)
		'rewrite' => array( 'slug' => 'objects' ), // this is the prepended slug (like "objects/my-object")
		'capability_type' => 'post',
		'hierarchical' => false,
		'menu_position' => null,
		'supports' => array('title','thumbnail', 'revisions', 'comments')
	  ); 
 
	register_post_type( 'dr_object' , $args );
	flush_rewrite_rules();//shouldnt be here --> on_register_activation hook
}

add_action('init', 'cluster_register');
 
function cluster_register() {
 
	$labels = array(
		'name' => _x('Cluster', 'post type general name'),
		'singular_name' => _x('Cluster', 'post type singular name'),
		'add_new' => _x('Add New', 'cluster'),
		'add_new_item' => __('Add New Cluster'),
		'edit_item' => __('Edit Cluster'),
		'new_item' => __('New Cluster'),
		'view_item' => __('View Cluster'),
		'search_items' => __('Search Cluster'),
		'not_found' =>  __('Nothing found'),
		'not_found_in_trash' => __('Nothing found in Trash'),
		'parent_item_colon' => ''
	);
 
	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'query_var' => true,
		'has_archive' => true,
		'rewrite' => array( 'slug' => 'cluster' ),
		'capability_type' => 'post',
		'hierarchical' => false,
		'menu_position' => null,
		'supports' => array('title', 'custom-fields', 'revisions', 'comments')
	  ); 
 
	register_post_type( 'dr_cluster' , $args );
	flush_rewrite_rules(); //shouldnt be here --> on_register_activation hook
}

?>