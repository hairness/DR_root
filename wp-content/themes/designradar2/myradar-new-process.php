<?php

	// you must first include the image.php file
	// for the function wp_generate_attachment_metadata() to work
	require_once(ABSPATH . 'wp-admin/includes/image.php');

	global $object_differentials;


	function save_return($in, $std_out){
		
		$data = mysql_real_escape_string($in);
		
		$output = isset( $in ) ? $in : $std_out;
		
		return $output;
		
	}

	
	// get all posted variables savely
	$title 			= save_return( $_POST['object_title'] , "");
	$image_file 	= save_return( $_POST['object_image_url'] , "");
	$year 			= save_return( $_POST['object_year'] , "");
	$format 		= save_return( $_POST['dr_format'] , "");
	
	$info 			= save_return( $_POST['object_information'] , "");
	$link 			= save_return( $_POST['object_link'] , "");

	// tag based
	$designers 		= save_return( $_POST['object_dr_designers'] , "");
	$manufactors 	= save_return( $_POST['object_dr_manufactors'] , "");
	
	$type	 		= save_return( $_POST['object_dr_type'] , "");
	$material 		= save_return( $_POST['object_dr_material_properties'] , "");
	$tags 			= save_return( $_POST['object_dr_tags'] , "");

	// convert from textext format to wp tags [\"lala\",\"didi\"]
	$designers = str_replace(array('[\"', '\"]', '\"', '[]'), "", $designers);
	$manufactors = str_replace(array('[\"', '\"]', '\"', '[]'), "", $manufactors);
	$type = str_replace(array('[\"', '\"]', '\"', '[]'), "", $type);
	$material = str_replace(array('[\"', '\"]', '\"', '[]'), "", $material);
	$tags = str_replace(array('[\"', '\"]', '\"', '[]'), "", $tags);
		
	// setup new post
	$object_args = array(
							'post_type'		=> 'dr_object',
							'post_title'	=> $title,
							'post_status'	=> 'draft'
	);
		
	$object_id = wp_insert_post($object_args);
	
	// add meta data
	add_post_meta($object_id, 'year_published', $year);
	add_post_meta($object_id, 'format', $format);
	add_post_meta($object_id, 'about-information', $info);
	add_post_meta($object_id, 'about-link', $link);
	
	// add tags
	wp_set_post_terms($object_id, $designers, 'dr_designers', false);
	wp_set_post_terms($object_id, $manufactors, 'dr_manufactors', false);
	wp_set_post_terms($object_id, $type, 'dr_type', false);
	wp_set_post_terms($object_id, $material, 'dr_material_properties', false);
	wp_set_post_terms($object_id, $tags, 'dr_tags', false);
	
	// differentials cycle
	foreach($object_differentials as $object_differential_group){
	  	foreach($object_differential_group['differentials'] as $object_differential){
	  		
	  		//if ignorecheckbox unchecked --> store differential
	  		if( !isset($_POST["diff-".$object_differential[0]."-ignore"]) ){
	  			if( isset($_POST["diff-".$object_differential[0]]) ) update_post_meta($object_id, "diff-".$object_differential[0], $_POST["diff-".$object_differential[0]]);
	  		}
	  		//if not – delete differential
	  		else {
	  			delete_post_meta($object_id, "diff-".$object_differential[0]);
	  		}
	  		
		}
	}
	
	// images
	
	$filename = $image_file;
	$wp_filetype = wp_check_filetype( basename($filename), null );
	$wp_upload_dir = wp_upload_dir();
	
	// move from /tmp/ to / folder
	$old_location = $wp_upload_dir['path'] . '/tmp/' . basename($filename);
	$new_location = $wp_upload_dir['path'] . '/' . basename($filename); 	
	rename( $old_location, $new_location);
	
	$attachment = array(
	 'guid' => $wp_upload_dir['baseurl'] . _wp_relative_upload_path( $new_location ), 
	 'post_mime_type' => $wp_filetype['type'],
	 'post_title' => preg_replace('/\.[^.]+$/', '', basename($new_location)),
	 'post_content' => '',
	 'post_status' => 'inherit'
	);
	
	$attach_id = wp_insert_attachment( $attachment, $new_location, $object_id );
	
	$attach_data = wp_generate_attachment_metadata( $attach_id, $new_location );
	wp_update_attachment_metadata( $attach_id, $attach_data );
	
	update_post_meta($object_id, '_thumbnail_id', $attach_id);
	
	// redirect to
	wp_redirect( home_url('/myradar') ); 
	
	exit;
?>