<?php
/*
Plugin Name: Designradar
Plugin URI: http://designradar.net
Description: Registers custom post types, taxonomies, admin panels, sidebars, widgets. On activation creates table for colors (if not exists).
Version: 0.2
Author: Hanspeter Kadel
Author URI: http://supernodegree.com
License: Free
*/

	/* DEFINE SOME CONSTANTS USED BY THE PLUGIN */
	define('DR_PLUGIN_DIR_URL', plugin_dir_url(__FILE__));
	define('DR_PLUGIN_DIR_PATH', plugin_dir_path(__FILE__));
	
	/* HELPER CLASSES */
	//color class
	include_once('inc/lux.inc.php');
	$lux = new Lux_Color();
	
	/* INCLUDE + REGISTER SOME GLOBAL SCRIPTS */
	function dr_scripts(){
		
		// will be enqueued for adding objects
		wp_register_script('jquery-uploadify', plugin_dir_url(__FILE__) . 'inc/uploadify/jquery.uploadify.v2.1.4.min.js', array('jquery', 'swfobject') );
		$upload_dir = wp_upload_dir();
		wp_localize_script('jquery-uploadify', 'uploadify', array(
																	'path' => plugin_dir_url(__FILE__) . 'inc/uploadify/', 
																	'uploads' => $upload_dir['path'],
																	'uploads_url' => $upload_dir['url']
																	));
		
		
		// used all over the page
		wp_enqueue_script('jquery-ui-button');
		wp_enqueue_script('jquery-ui-dialog');
	
	}
	add_action('wp_enqueue_scripts', 'dr_scripts');
	
	function dr_styles(){
		wp_enqueue_style('jquery-ui-base', plugin_dir_url(__FILE__) . "css/smoothness/jquery-ui-1.8.18.custom.css");
	
	}
	add_action('wp_enqueue_scripts', 'dr_styles');
	

	
	/* INCLUDE TERMS todo: localize */
	include_once('dr-terms.php');

	/* SETUP COLORS TABLE ON ACTIVATION */
	include_once plugin_dir_path( __FILE__ ).'/dr-colors-table.php';
	register_activation_hook( __FILE__, 'dr_color_table_install' );
	
	/* REGISTER TAXONOMIES	dr_designers, dr_manufactors, dr_tags */
	include_once('dr-taxonomies.php');
	
	/* REGISTER CUSTOM POST TYPES dr_object, dr_cluster */
	include_once('dr-post_types.php');
	
	/* SETUP ADMIN PANELS FOR dr_object + dr_cluster */
	include_once('dr-admin-panels.php');
	
	/* SETUP PERMALINKS */
	include_once('dr-permalinks.php');
	
	/* REGISTER SIDEBARS */
	include_once('dr-sidebars.php');
	
	/* REGISTER SIDEBAR WIDGETS */
	include_once('dr-widgets.php');
	
	/* REGISTER FRONTEND FUNCTIONS */
	include_once('dr-frontend-functions.php');
	
?>