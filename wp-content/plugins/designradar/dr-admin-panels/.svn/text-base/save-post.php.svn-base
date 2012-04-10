<?php

	/* SAVE DR_OBJECT / DR_CLUSTER ON SUBMIT */
	
	add_action('save_post', 'save_dr_post_data');
	
	function save_dr_post_data( $post_id ){
	
		// do not autosave, only on sumit...
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
		  return;
		
		// verify this came from the our screen and with proper authorization,
		// because save_post can be triggered at other times
//		if ( !wp_verify_nonce( $_POST['dr_nonce'], plugin_basename( __FILE__ ) ) )
//		  return;
		
		// Check permissions
		if ( isset($_POST['post_type']) && ('dr_object' == $_POST['post_type'] || 'dr_cluster' == $_POST['post_type']) ) 
		{
			if ( !current_user_can( 'edit_post', $post_id ) ) return;
		}
		
		// OK, we're authenticated: we need to find and save the data
		
		
		if( isset($_POST['post_type']) && ('dr_object' == $_POST['post_type']) ){
			save_dr_object_data($post_id);
		}
		else if ( isset($_POST['post_type']) && ('dr_cluster' == $_POST['post_type']) ){
			save_dr_cluster_data($post_id);
		}

	} //save_dr_post_data
	
	
	// SAVE OBJECT
	
	function save_dr_object_data($post_id){
	
	  global $post;
	  global $wpdb;
	  global $object_differentials;
	  global $LuxInstance;
	 
	  if(!empty($_POST["dr_designers"])) update_post_meta($post_id, "dr_designers", $_POST["dr_designers"]);
	  if(!empty($_POST["dr_manufactors"])) update_post_meta($post_id, "dr_manufactors", $_POST["dr_manufactors"]);
	  if(!empty($_POST["dr_tags"])) update_post_meta($post_id, "dr_tags", $_POST["dr_tags"]);
	  if(!empty($_POST["year_published"])) update_post_meta($post_id, "year_published", $_POST["year_published"]);
	  if(!empty($_POST["format"])) update_post_meta($post_id, "format", $_POST["format"]);
	  if(!empty($_POST["about-information"])) update_post_meta($post_id, "about-information", $_POST["about-information"]);
	  if(!empty($_POST["about-link"])) update_post_meta($post_id, "about-link", $_POST["about-link"]);
	  
	  foreach($object_differentials as $object_differential_group){
	  	foreach($object_differential_group['differentials'] as $object_differential){
	  		
	  		//if ignorecheckbox unchecked --> store differential
	  		if( !isset($_POST["diff-".$object_differential[0]."-ignore"]) ){
	  				  			
	  			if( isset($_POST["diff-".$object_differential[0]]) ) update_post_meta($post_id, "diff-".$object_differential[0], $_POST["diff-".$object_differential[0]]);
	  		}
	  		//if not – delete differential
	  		else {
	  			delete_post_meta($post_id, "diff-".$object_differential[0]);
	  		}
	  		
	  		
	  		
	  	}
	  }
	  
	  //convert colors from hex to hsl and store in db
	  
	  if(!empty($_POST["update_colors"])){
	  
		  for($i=0; $i<3; $i++){
		  	
		  	// only proceed if not empty AND not -1 (code for undefined)
		  	if(!empty($_POST['color-'.$i]) && $_POST['color-'.$i]!="-1"){
		  	  	// get raw #hex
		  		$hex = $_POST['color-'.$i];
		  	
		  		//convert to hsl array
		  		$hsl = $LuxInstance->hex2hsl($hex); //array 0, 1, 2 normalized 0.0 - 1.0 hsl values
		  		  	
		  		$h = round($hsl[0] * 255); $s = round($hsl[1] * 255); $l = round($hsl[2] * 255); //denormalize values… :)
		  	
		  	
				//SUCKS HARD
				$wpdb->hide_errors();
		  		// try to update wp_colors 
		  		$updated = $wpdb->update('wp_colors', array('h'=> $h, 's' => $s, 'l' => $l), array('post_id' => $post_id, 'rank' => $i));
		 
		   		// wpdb return number of rows affacted… if 0  nothing got updated __> insert
		  		if($updated==0) $wpdb->insert('wp_colors', array('post_id' => $post_id, 'rank' => $i, 'h' => $h, 's' => $s, 'l' => $l)); 
		  		
		  		$wpdb->show_errors();
		  		
		  		
		  	} //endif
		  }//endfor
	  } //if(!empty($_POST["update_colors"]))	
	
	}
	
	
	// SAVE CLUSTER
	
	function save_dr_cluster_data($post_id){
		
		// featured object
		if(!empty($_POST["featured-object-id"])) update_post_meta($post_id, "featured-object-id", $_POST["featured-object-id"]);
		
		// interpretation
		
		global $cluster_interpretation;
		
		foreach($cluster_interpretation as $i => $fragen){		
			foreach ($fragen[1] as $j => $frage){
				if(!empty($_POST["interpretation-$i-$j"])) update_post_meta($post_id, "interpretation-$i-$j", $_POST["interpretation-$i-$j"]);
			}
		}	
	
	}

?>