<?php

	/* REGISTER CUSTOM TAXONOMIES */

	add_action( 'init', 'dr_taxonomies', 0 );  
	
	function dr_taxonomies() { 
	
		register_taxonomy( 'dr_designers', array("dr_object"), array(
																		"hierarchical" => false, 
																		"label" => "Designers", 
																		"singular_label" => "Designer", 
																		"rewrite" => array('slug' => 'designer')));
																		 
		register_taxonomy( 'dr_tags', array("dr_object", "dr_cluster"), array(
																		
																		"hierarchical" => false, 
																		"label" => "Tags", 
																		"singular_label" => "Tag", 
																		"rewrite" => array('slug' => 'tags')));
																		
		register_taxonomy( 'dr_material_properties', array("dr_object"), array(
																		
																		"hierarchical" => false, 
																		"label" => "Material properties", 
																		"singular_label" => "Material properties", 
																		"rewrite" => array('slug' => 'material_properties')));
																		
		register_taxonomy( 'dr_type', array("dr_object"), array(
																		
																		"hierarchical" => true, 
																		"label" => "Type of object", 
																		"singular_label" => "Type of object", 
																		"rewrite" => array('slug' => 'type')));																
																		
																		  
		register_taxonomy( 'dr_manufactors', array("dr_object"), array(
																		"hierarchical" => false, 
																		"label" => "Manufactors", 
																		"singular_label" => "Manufactor", 
																		"rewrite" => array('slug' => 'manufactors')));  
	
	}

?>