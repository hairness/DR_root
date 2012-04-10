<?php

	$do = isset($wp_query->query_vars['do']) ? $wp_query->query_vars['do'] : 'index';
	
	switch($do){
	
		case 'index':
						get_template_part('myradar', 'index');
						break;
						
		case 'new/object': 
						get_template_part('myradar', 'new');
						break;
		
		default:
						get_template_part('myradar', 'index');
						break;
	}

?>