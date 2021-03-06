<?php

	// JSON TAG SEARCH

	add_action('wp_ajax_dr_ajax_tag_search', 'dr_ajax_tag_search');
	add_action('wp_ajax_nopriv_dr_ajax_tag_search', 'dr_ajax_tag_search'); // for users that are not logged in.
	
	function dr_ajax_tag_search() {
		global $wpdb;
		
		$taxonomy = $_REQUEST['tax'];
		$s		  = $_REQUEST['q'];
		
		$results = $wpdb->get_col("SELECT t.name FROM $wpdb->term_taxonomy AS tt INNER JOIN $wpdb->terms AS t ON tt.term_id = t.term_id WHERE tt.taxonomy = '$taxonomy' AND t.name LIKE ('%" . $s . "%')");
		
		$response = json_encode($results);
		
		// response output
	    header( "Content-Type: application/json" );
	    echo $response; 
	    
	    // dont forget to…
	    exit;
	}
	
	// REGISTER BASIC STUFF
	
	function dr_register_ajax(){
	
		// embed the javascript file that makes the AJAX request
		//wp_enqueue_script( 'dr-ajax-requests', plugin_dir_url( __FILE__ ) . '../js/ajax.js', array( 'jquery' ) );
	 
		// declare the URL to the file that handles the AJAX request (wp-admin/admin-ajax.php)
		//wp_localize_script( 'dr-ajax-requests', 'dr_ajax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
		wp_localize_script( 'jquery', 'dr_ajax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
	
	}
	
	add_action('wp_enqueue_scripts', 'dr_register_ajax');
	


	// AJAX FUNCTIONS
	
	
	// AJAX OBJECT QUERY
	
	add_action('wp_ajax_dr_ajax_objects_query', 'dr_ajax_objects_query');
	add_action('wp_ajax_nopriv_dr_ajax_objects_query', 'dr_ajax_objects_query'); // for users that are not logged in.
	
	function dr_ajax_objects_query() {
	
		global $wpdb;
		
		$tags		= $_POST['tags'];
		$year		= explode(';', mysql_real_escape_string($_POST['year_spread']));
		$appearance = $_POST['appearance'];
		$color		= explode(";", $_POST['color']);
		$color_tol	= $_POST['color_tolerance'];
		
		
		// RESTRICT COLORS IF SET
			
		$target_color = array(
							'h' => array('min' => max(0, $color[0] - $color_tol), 'max' => min(255, $color[0] + $color_tol)),
							's' => array('min' => max(0, $color[1] - $color_tol), 'max' => min(255, $color[1] + $color_tol)),
							'l' => array('min' => max(0, $color[2] - $color_tol), 'max' => min(255, $color[2] + $color_tol))
		);	
			
			
		if( $color[1] < 2 ){
			$target_color['h']['min'] = 0;
			$target_color['h']['max'] = 255; // full range of hues if saturation is very low (grey, black white, etc)
		}
		
		if( ( $color[2] < 2 ) OR ( $color[2] > 253 ) ) {
			$target_color['h']['min'] = 0; $target_color['h']['max'] = 255; // white / black - full tolerance on hue and saturation
			$target_color['s']['min'] = 0; $target_color['s']['max'] = 255; // its white, black anyway…
		}
		
		
		// default query args (pagetype, number of posts, etc)
		$args = array(
			'post_type' => 'dr_object'
		);
		
		
		//query colors – and insert into POST query IIIIFFFFFF there is a color set!!!
		if(sizeof($color)>1){
			
			$color_match_post_ids = $wpdb->get_col("
												SELECT DISTINCT post_id 
												FROM wp_colors 
												WHERE 
														(h BETWEEN ".$target_color['h']['min']." AND ".$target_color['h']['max'].") 
												AND		(s BETWEEN ".$target_color['s']['min']." AND ".$target_color['s']['max'].")
												AND		(l BETWEEN ".$target_color['l']['min']." AND ".$target_color['l']['max'].")
											   ");
											   

			//some postids returned dont exist anymore – should be cleaned up on object_delete!
		
			$args['post__in'] = $color_match_post_ids; //only pull posts, that matched the color
		}	
		
		// loop through the incoming vars – check if empty, use a query-type
		// i.e. 'tax_query', 'meta_query'
		// check http://codex.wordpress.org/Class_Reference/WP_Query 
		
		if (!empty( $tags ) ) {
			$args ['tax_query'] = array(
										array(
											'taxonomy' => 'dr_tags',
											'field' => 'slug',
											'terms' => $tags
										)
			);
		}
		
		if (!empty( $year ) ) {
			$args['meta_query'] = array(
										// seems to work - should be in its own !empty(appearance) thingy
										array(
											'key' => 'appearance',
											'value' => $appearance,
											'type' => 'numeric',
											'compare' => 'IN'
										), 
										array(
											'key' => 'year_published',
											'value' => $year,
											'type' => 'numeric',
											'compare' => 'BETWEEN'
										)
			);
		}
		
		
		$query = new WP_Query( $args );
				
		$i = 0;
		while ( $query->have_posts() ) : $query->the_post();
			the_title();
		endwhile;
		
		wp_paginate();
		
		exit;
	}
	
	
	
	// ADD OBJECT TO CLUSTER // ARCHIVE.PHP
	
	add_action( 'wp_ajax_dr_ajax_add_object_to_cluster', 'dr_ajax_add_object_to_cluster' );
	 
	function dr_ajax_add_object_to_cluster() {
	    
	    // get the submitted parameters
	    $new_object_id = $_POST['new_object_id'];
	 	$cluster_id	   = $_POST['cluster_id'];
	 	
	 	// do it
	 	$success = add_post_meta($cluster_id, 'included-object', $new_object_id);
	 	 
	 	// query object ids
	 	$object_ids = get_post_meta($cluster_id, 'included-object');
	 	
	 	// set featured if its the first added object
	 	if( sizeof($object_ids) == 1 )
	 		update_post_meta($cluster_id, 'featured-object', $new_object_id);
	 	
	 	// craft the response
	 	$response = json_encode( array(
	 								'success' => true,
	 								'object_ids' => $object_ids
	 							 )
	 	);
	 		
	    // response output
	    header( "Content-Type: application/json" );
	    echo $response;
	 
	    // IMPORTANT: don't forget to "exit"
	    exit;
	}
	
	
	// REMOVE OBJECT FROM CLUSTER // ARCHIVE.PHP
	
	add_action( 'wp_ajax_dr_ajax_remove_object_from_cluster', 'dr_ajax_remove_object_from_cluster' );
	 
	function dr_ajax_remove_object_from_cluster() {
	    
	    // get the submitted parameters
	    $new_object_id = $_POST['new_object_id'];
	 	$cluster_id	   = $_POST['cluster_id'];
	 	
	 	// delete it
	 	$success = delete_post_meta($cluster_id, 'included-object', $new_object_id);
	 	
	 	// query object ids
	 	$object_ids = get_post_meta($cluster_id, 'included-object');
	 	
	 	// craft the response
	 	$response = json_encode( array(
	 								'success' => true,
	 								'object_ids' => implode($object_ids, ',')
	 							)
	 	);
	 		 		
	    // response output
	    header( "Content-Type: application/json" );
	    echo $response;
	 
	    // IMPORTANT: don't forget to "exit"
	    exit;
	}
	
	
	// REMOVE OBJECT FROM CLUSTER // ARCHIVE.PHP
	
	add_action( 'wp_ajax_dr_ajax_new_cluster_and_append_object', 'dr_ajax_new_cluster_and_append_object' );
	 
	function dr_ajax_new_cluster_and_append_object() {
	    
	    // get the submitted parameters
	    $new_object_id = $_POST['new_object_id'];
	    $new_cluster_title = $_POST['new_cluster_title'];
	    
	   	// get other parameters
	   	$user_logged_in = wp_get_current_user();

		// set up post parameters for cluster draft
		$post = array(
						  'post_author' => $user_logged_in->ID,
						  'post_status' => 'draft', 
						  'post_type'	=> 'dr_cluster',
						  'post_title' => $new_cluster_title
		);
		
		// insert post  
	 	$cluster_id = wp_insert_post($post);
	 	
	 	// include object
	 	add_post_meta($cluster_id, 'included-object', $new_object_id);
	 	update_post_meta($cluster_id, 'featured-object', $new_object_id);
	 	
	 	// craft the response
	 	$response = json_encode( array(
	 								'success' => true,
	 								'object_ids' => $new_object_id,
	 								'cluster_id' => $cluster_id
	 							)
	 	);
	 		 		
	    // response output
	    header( "Content-Type: application/json" );
	    echo $response;
	 
	    // IMPORTANT: don't forget to "exit"
	    exit;
	}

	// SET OBJECT ID AS FEATURED // DR_CLUSTER EDIT
	
	

	add_action( 'wp_ajax_dr_ajax_set_featured_object', 'dr_ajax_set_featured_object' );
	 
	function dr_ajax_set_featured_object() {
	    
	    // get the submitted parameters
	    $object_id = $_POST['object_id'];
	    $cluster_id = $_POST['cluster_id'];
	    	 	
	 	// include object
	 	update_post_meta($cluster_id, 'featured-object', $object_id);
	 	
	 	// craft the response
	 	$response = json_encode( array( 'success' => true ) );
	 		 		
	    // response output
	    header( "Content-Type: application/json" );
	    echo $response;
	 
	    // IMPORTANT: don't forget to "exit"
	    exit;
	}


	// GLOSSARY FOR TAXONOMIES
	
	add_action( 'wp_ajax_dr_ajax_glossary', 'dr_ajax_glossary' );
	 
	function dr_ajax_glossary() {
	
		// get the taxonomy
		$tax = $_POST['tax'];
		
		// nice menu
		$glossary = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', '0-9');
		
		$args = array(
						'taxonomy' => $tax
		);
		
		wp_tag_cloud( $args );
		
		
		exit;
	}

?>