<?php

	/* REGISTER AJAX FUNCTIONS */
	
	/* AJAX QUERY */

	function dr_ajax_query() {
	
		global $wpdb;
		
		$tags		= $_POST['tags'];
		$year		= explode(';', mysql_real_escape_string($_POST['year_spread']));
		$appearance = $_POST['appearance'];
		$color		= explode(";", $_POST['color']);
		$color_tol	= $_POST['color_tolerance'];
		
			
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
			'post_type' => 'dr_object' //13.03 removed post__in and put below! 
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
											   
		//update 13.03.12 - select distinct (no doublettes)	
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
			dr_card();
		endwhile;
		
		if( function_exists('wp_paginate') ){ wp_paginate(); } ?>
			<script type="text/javascript" charset="utf-8">
			jQuery(document).ready(function(){
				jQuery('#.wp-paginate a').live('click', function(e){
					e.preventDefault();
					var link = jQuery(this).attr('href');
					//jQuery('#query-results').html('Loading...');
					//jQuery('#query-results').load(link+' #query-results');
					jQuery('#query-results').fadeOut(500).load(link + ' #query-results', function(){ jQuery('#query-results').fadeIn(500); });		
				});
			
			});
			</script>
		<?php	
		//die(); // TODO: don't know if this is normal, but without the die() it till output a "0" to the ajax-div	
		exit; //14.03.12 exit is better…
	}
	add_action('wp_ajax_dr_ajax_query', 'dr_ajax_query');
	add_action('wp_ajax_nopriv_dr_ajax_query', 'dr_ajax_query');//for users that are not logged in.

?>