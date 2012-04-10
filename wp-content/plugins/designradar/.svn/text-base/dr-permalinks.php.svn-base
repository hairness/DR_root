<?php

	/* DO SOME PERMALINK SPECIFIC STUFF */
	
	// Add permalink structure, flush rules on activation/deactivation
	
	function dr_rewrite_activate(){
		//dr_add_rewrites();
	    flush_rewrite_rules();	
	}
	
	function dr_rewrite_deactivate(){
	    flush_rewrite_rules();		
	}
	
	register_activation_hook( __FILE__, 'dr_rewrite_activate' ); 
	register_deactivation_hook( __FILE__, 'dr_rewrite_deactivate' );
	
	// Add rewrite endpoint
	function dr_add_rewrites() {
	        add_rewrite_endpoint('do', EP_ALL ); // for do/edit, do/remove, etc
			flush_rewrite_rules(); //shouldnt be here --> on_register_activation hook
	}
	add_filter('init', 'dr_add_rewrites');

?>