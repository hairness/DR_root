<?php get_header(); ?>

helper:
<input type="text" name="cluster_id" value="<?php the_ID(); ?>" id="cluster_id">
<input type="text" name="cluster_permalink" value="<?php the_permalink(); ?>" id="cluster_permalink">

<div>
	<div class="grid9 first">
		
		<h2><?php the_title(); ?></h2>
		
		<div id="cluster-objects">
			<?php
				//QUERY THE FEATURED OBJECT
				
				$featured_object = get_post_meta($post->ID, 'featured-object');
								
				// current_thumb needs to be set here
				$current_thumb = 0;
				
				// if there is any featured_object - show it
				if( !empty($featured_object) ){
					
					// geht leider nicht kompakter
					$featured_object_query = new WP_Query("post_type=dr_object&p=".$featured_object[0]);

					// LOOP START
					while( $featured_object_query->have_posts() ){ 
						$featured_object_query->the_post();
						get_template_part('thumb', 'big');
						$current_thumb++;
					}
					
					wp_reset_query();
				
				}
				
				
				
				//LOOP FOR ALL INCLUDED OBJECTS
			
				$post_custom = get_post_custom($post->ID);
				$included_object_ids = isset($post_custom['included-object']) ? $post_custom['included-object'] : array(-1);
			
				
				//remove the featured from above (if set)
				$included_object_ids = array_diff($included_object_ids, $featured_object);
			
				$included_objects_query = new WP_Query( array(
																'post_type' => 'dr_object',
																'posts_per_page' => -1,
																'post__in'	=> $included_object_ids,
																'post_status' => array('draft', 'pending', 'publish')
														));					
					
				
				// LOOP START
				while( $included_objects_query->have_posts() ) : $included_objects_query->the_post();
				
					//OUTPUT
					get_template_part('thumb', 'big');
					
					//COUNTER
					$current_thumb++;
					
				endwhile;
				// LOOP END
			?>
		</div><!-- #cluster-objects -->	
		
		<div class="cluster-interpretation">
		<?php
			foreach($cluster_interpretation as $i => $fragen){
			
				echo '<h2>'.$fragen[0].'</h2>';
				
				foreach ($fragen[1] as $j => $frage){
				
					$antwort = isset($post_custom["interpretation-$i-$j"][0]) ? trim($post_custom["interpretation-$i-$j"][0]) : '';
				
					if(!empty($antwort)){
						echo "<strong>$frage</strong><br/>
						  	  <p>$antwort</p>";
					}
					
				}
			
			}
		?>
		</div>
		
		<div class="object-comments">
			<?php comments_template(); ?>
		</div>
	
	</div>	
	
	<div class="grid3 cluster-info">
		
		<div>
			<h2>Designer</h2>
			<?php dr_common_tags($included_object_ids, 'dr_designers'); ?>
			______
		</div>
		
		<div>
			<h2>Manufactors</h2>
			<?php dr_common_tags($included_object_ids, 'dr_manufactors'); ?>
			______
		</div>
		
		<div>
			<h2>Tags</h2>
			<?php dr_common_tags($included_object_ids, 'dr_tags'); ?>
			______
		</div>
		
		<div>
			<h2>Materials</h2>
			<?php dr_common_tags($included_object_ids, 'dr_materials'); ?>	
			______		
		</div>
		
		<div>
			<h2>Colors</h2>
			<?php dr_common_colors($included_object_ids); ?>
			______
		</div>

	</div>
</div>

<script>

	jQuery(document).ready( function(){
	
		jQuery('a[href=#set-featured]').live('click', function(e) {
			
			var object_id = jQuery(this).parents('.thumb-dr_object').attr('id');
			var cluster_id = jQuery('input#cluster_id').val();	
			var cluster_permalink = jQuery('input#cluster_permalink').val();
												
			// AJAX			
			jQuery.post(
			    dr_ajax.ajaxurl,
			    {
			        action : 'dr_ajax_set_featured_object',
			        object_id : object_id,
			        cluster_id : cluster_id
			    },
			    function( response ) {
			        if( response.success ){
			        	//on success - reload the objects
			        	jQuery('#cluster-objects').load(cluster_permalink + ' #cluster-objects');
			        	
			        	/*
jQuery.ajax({
						  url: '',
						  success: function(data) {
						    jQuery('#cluster-objects').html(data);
						    alert('Load was performed.');
						  }
						});	
*/
			        }
			    }
			);

			return false;
		});	
	
	});

</script>

<?php get_footer(); ?>