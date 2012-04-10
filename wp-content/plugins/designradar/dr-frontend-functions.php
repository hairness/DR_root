<?php

	/* ENABLE THUMBNAILS */
	add_action('after_setup_theme', 'enable_theme_functions');

	function enable_theme_functions(){
		add_theme_support('post-thumbnails');
	}


	/* DR_OBJECT FRONTEND DATA */

	// PUBLISHED YEAR
	function get_dr_object_year(){
		global $post;
		return get_post_meta($post->ID, 'year_published', true);
	}
	function the_dr_object_year(){
		$year = get_dr_object_year();
		$output = !empty($year) ? $year : '(Unknown)';
		echo $output;
	}

	// Designer / Designer
	function get_dr_object_designer(){ //outputs array
		global $post;
				
		$designers = wp_get_object_terms($post->ID, 'dr_designers');

		if(!empty($designers) && !is_wp_error( $designers )){
		    return $designers;
		}
		else {
			$unknown->name = "Unknown"; 
			return array($unknown);
		}
	}
	function the_dr_object_designer(){
	
		$designers = get_dr_object_designer();
		
		if( !empty($designers) ){
					
			echo '<a href="'.get_term_link($designers[0]->slug, 'dr_designers').'">'.$designers[0]->name.'</a>'; 

			if(sizeof($designers) > 1){
				_e(" and others.");
			}
		}
		else {
			echo '(Unknown)';
		}
	}
	
	// Format
	function get_dr_object_format(){ //outputs array
		global $post;
		
		$format = get_post_meta($post->ID, 'format', true);

		return $format;
	}
	function the_dr_object_format(){
		global $object_formats; //defined in dr-terms.php

		$format = get_dr_object_format(); //will be an integer 0;1;2
		
		if( !empty($format) )
			echo $object_formats[$format];
		else
			echo '(Unknown)';
	}
	
	
	// Manufactor
	function get_dr_object_manufactor(){ //outputs array
		global $post;
		
		$manufactors = wp_get_object_terms($post->ID, 'dr_manufactors');

		if(!empty($manufactors) && !is_wp_error( $manufactors )){
		    return $manufactors;
		}
		else {
			$unknown->name = "Unknown"; 
			return array($unknown);
		}

	}
	
	// Essence
	function the_dr_object_essence(){
		global $post;
		
		$essence = get_post_meta($post->ID, 'essence', true);
		
		echo $essence;
	}
	
	// Tags
	function get_dr_object_tags(){
		global $post;
		
		$tags = wp_get_object_terms($post->ID, 'dr_tags');

		if(!empty($tags)){
		  if(!is_wp_error( $tags )){
		    return $tags;
		  }
		}
	}
	
	// Material properties
	function get_dr_object_materials(){
		global $post;
		
		$tags = wp_get_object_terms($post->ID, 'dr_materials');

		if(!empty($tags)){
		  if(!is_wp_error( $tags )){
		    return $tags;
		  }
		}
	}
	
	// Colors
	function get_dr_object_colors(){
		global $post, $wpdb;
		
		$colors = $wpdb->get_results("SELECT * FROM wp_colors WHERE post_id = ".$post->ID);
	
		if( !empty($colors) ){
			return $colors;
		}
		
		return;
	}
	
	// About information
	function get_dr_object_about(){
		global $post;
		
		$about = get_post_meta($post->ID, 'about-information', true);

		return $about; 
	}
	function the_dr_object_about(){
		$about = get_dr_object_about();
		
		if( !empty($about) )
			echo $about;
		else
			echo "(Unbekannt)";
	}	





	/* THE AUTHOR - used for cluster */
	function dr_get_the_author(){
		global $post;
		return get_the_author();
	}
	function dr_the_author(){
		echo dr_get_the_author();
	}






	/* LINKED CLUSTERS */
	function dr_get_linked_clusters(){
		global $post;
	
		// get current user
		$user_logged_in = wp_get_current_user();
	
		$cluster_ids = new WP_Query( array( 'author' => $user_logged_in->ID,
											'post_status' => array('publish', 'draft'), 
											'post_type' => 'dr_cluster', 
											'meta_key' => 'object_id', 
											'meta_value' => $post->ID ) );
		return $cluster_ids->posts;
	}



	// CLUSTER FRONTEND SHIT
	
	function dr_common_tags($object_ids, $taxonomy){
	
		$common_dr_tags = wp_get_object_terms($object_ids, $taxonomy, array('orderby' => 'count', 'order' => 'DESC'));
					
		foreach($common_dr_tags as $dr_tag){
			echo "<li>".$dr_tag->name." (counts: ".$dr_tag->count.")</li>";
		}
	
	}
	
	function dr_common_colors($object_ids){
		global $wpdb;
	
		$object_ids_serialized = implode(',', $object_ids);
		$colors = $wpdb->get_results("SELECT h, s, l FROM wp_colors WHERE post_id IN ($object_ids_serialized)");
		
		foreach($colors as $color){
            
	      	$cssh = round(($color->h / 255) * 360);					//css hsl(0-360, 0-100%, 0-100%)
	      	$csss = round(($color->s / 255) * 100); $csss .= "%";
	      	$cssl = round(($color->l / 255) * 100); $cssl .= "%";
	      	
	      	echo "<div style='float: left; margin: 0 4px; width: 36px; height: 24px; background-color: hsl($cssh,$csss,$cssl);'></div>";
      	}
	}


?>