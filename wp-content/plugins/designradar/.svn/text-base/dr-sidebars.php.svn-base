<?php

	/* INITS ALL SIDEBARS */

	add_action( 'widgets_init', 'my_register_sidebars' );
	
	function my_register_sidebars(){
		
		$objects_index = array(
								'name'          => 'DR Objects Index',
								'id'            => 'sidebar-objects-index',
								'description'   => 'Index view /objects',
								'before_widget' => '<div id="%1$s" class="widget %2$s">',
								'after_widget'  => '</div>',
								'before_title'  => '<h2 class="widgettitle">',
								'after_title'   => '</h2>'
		);
		register_sidebar($objects_index);
		
		$clusters_index = array(
								'name'          => 'DR Cluster Index',
								'id'            => 'sidebar-clusters-index',
								'description'   => 'Index view /clusters',
								'before_widget' => '<div id="%1$s" class="widget %2$s">',
								'after_widget'  => '</div>',
								'before_title'  => '<h2 class="widgettitle">',
								'after_title'   => '</h2>'
		);
		register_sidebar($clusters_index);
			
		
		$frontpage = array(
								'name'          => 'DR Frontpage',
								'id'            => 'sidebar-frontpage',
								'description'   => 'Front page',
								'before_widget' => '<div id="%1$s" class="widget %2$s">',
								'after_widget'  => '</div>',
								'before_title'  => '<h2 class="widgettitle">',
								'after_title'   => '</h2>'
		);
		register_sidebar($frontpage);
		
	}
?>