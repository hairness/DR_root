<?php

	/* SETUP THE COLORS TABLE */
		
	function dr_color_table_install() {
			
	   global $wpdb;
	
	   $table_name = $wpdb->prefix . "colors";
	    
	   $sql = "CREATE TABLE IF NOT EXISTS $table_name (  
										  id int(11) NOT NULL AUTO_INCREMENT,
										  post_id int(11) NOT NULL,
										  rank int(11) NOT NULL,
										  name tinytext NOT NULL,
										  h int(11) NOT NULL,
										  s int(11) NOT NULL,
										  l int(11) NOT NULL,
										  PRIMARY KEY (id),
			  							  UNIQUE KEY post_id (post_id,rank)
	  		  );"; 
	    
	   require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	   dbDelta($sql);	   
	   
	}
?>