<?php 		
		// query recent clusters, query recent objects
		
		$args = array(
						'limit'		=> 6,
						'post_type' => 'dr_cluster',
						'post_status' => array('publish'),
						'orderby' => 'date'
		);	
		
		$recent_clusters = get_posts($args); 
		
		$args = array(
						'limit'		=> 6,
						'post_type' => 'dr_object',
						'post_status' => array('publish'),
						'orderby' => 'date'
		);	
		
		$recent_objects = get_posts($args);
?>

<?php get_header(); ?>

<div id="query" class="grid9 first">
<h1>STARTSEITE home.php</h1>
	<h3 style="background: none;">About Designradar</h3>
	<div id="about">
		<p>Hier Text über das Radar</p>			
	</div>
   
	<h3 style="background: none;">Most recent Clusters <a href="<?php bloginfo('wpurl'); ?>/cluster/">Discover more Clusters</a></h3>
	<div id="query-results">
	<?php 
		foreach( $recent_clusters as $nth => $post ) :	setup_postdata($post);
			get_template_part('card', 'cluster');
		endforeach;	
	?>		
	</div>
	
	<h3 style="background: none;">Most recent Objects<a href="<?php bloginfo('wpurl'); ?>/objects/">Discover more Objects</a></h3>
	<div>
	<?php 
		foreach( $recent_objects as $nth => $post ) :	setup_postdata($post);
			get_template_part('card', 'object');
		endforeach;	
	?>		
	</div>

			
 </div><!-- #query --> 
 
<?php //get_sidebar('sidebar-frontpage'); ?>
<div class="grid3 last">
	
	<?php dynamic_sidebar('frontpage'); ?>
</div>
<?php get_footer(); ?>