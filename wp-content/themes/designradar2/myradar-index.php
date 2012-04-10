<?php 
		/* LOAD SCRIPTS */
		
		function dr_myradar_scripts(){
			//wp_enqueue_script('jquery-ui-dialog');
		}
		add_action('wp_enqueue_scripts', 'dr_myradar_scripts');
		

		get_header();
?>

<div class="breadcrumb">
	<h2>MY RADAR</h2>
</div>

<div class="thumbnails grid9 first" style="background: yellow;">
	
	<h2>Object DRAFTS</h2>
	<div id="my-objects">	
		<?php
			//QUERY DRAFT OBJECTS
			$args = array(
						'author' => get_current_user_id(),
						'post_type' => 'dr_object',
						'post_status' => array('draft', 'pending'),
						'orderby' => 'date'
			);	
		
			$user_object_drafts = new WP_Query($args);
					
			$current_thumb = 0;
			while( $user_object_drafts->have_posts() ) : $user_object_drafts->the_post();
				get_template_part('thumb', 'big');
				$current_thumb++;	
			endwhile;
		?>
	</div>
	
	<h2 style="width: 100%; float: left;">Cluster DRAFTS</h2>
	<div id="my-cluster">	
		<?php
			//QUERY DRAFT OBJECTS
			$args = array(
						'author' => get_current_user_id(),
						'post_type' => 'dr_cluster',
						'post_status' => array('draft', 'pending'),
						'orderby' => 'date'
			);	
		
			$user_object_drafts = new WP_Query($args);
					
			$current_thumb = 0;
			while( $user_object_drafts->have_posts() ) : $user_object_drafts->the_post();
				get_template_part('thumb', 'big');
				$current_thumb++;	
			endwhile;
		?>
	</div>
	
</div>	
	
<div class="grid3">
	here dann die manage sidebar
	<?php //dynamic_sidebar('DR Objects Index'); ?>
</div>

<?php get_footer(); ?>