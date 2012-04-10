<?php
	
	/* ADMIN PANEL FOR DR_CLUSTER */
	
	add_action("admin_init", "cluster_custom_meta_boxes");
	
	 
	function cluster_custom_meta_boxes(){
	  add_meta_box("included_objects-meta", "Included Objects", "included_objects", "dr_cluster", "normal", "low");
	  add_meta_box("interpretation-meta", "Interpretation", 'interpretation', "dr_cluster", "normal", "low");  
	}
	 
	function included_objects($post){

	  $custom = get_post_custom($post->ID);
	  
	  if(isset($custom["included-object-id"])){
		  
		  $included_object_ids = $custom["included-object-id"]; //get an array of all featured object values
		  $featured_object_id = isset($custom["featured-object-id"][0]) ? $custom["featured-object-id"][0] : '';
		  
		  foreach($included_object_ids as $included_object_id){

			$selected = ($featured_object_id == $included_object_id) ? ' checked="true"' : '';
		  	
		  	echo "<div style='float: left;'>"
		  		 .get_the_post_thumbnail( $included_object_id, array(200, 145) )."<br>"
		  		 ."<input type='radio' id='featured-$included_object_id' name='featured-object-id' value='$included_object_id'$selected>"
		  		 ."<label for='featured-$included_object_id'>Featured Object</label>"
		  		 ."</div>";
		  	
		  }
		  
		  echo "<br class='clear'>";
		  
	  }//endif isset($custom["featured_object"])
	  
	  
	}
	
	function interpretation($post) {
	
		global $cluster_interpretation;
		
		
		$post_custom = get_post_custom($post->ID);
	
		foreach($cluster_interpretation as $i => $fragen){
		
			echo '<h2>'.$fragen[0].'</h2>';
			
			foreach ($fragen[1] as $j => $frage){
			
				$antwort = isset($post_custom["interpretation-$i-$j"][0]) ? $post_custom["interpretation-$i-$j"][0] : '';
			
				echo "<p>
						<strong>$frage</strong><br/>
						<textarea name='interpretation-$i-$j' style='width: 100%; height: 60px'>$antwort</textarea>
					  </p>";
				
			}
		
		}
	
	}    	
?>