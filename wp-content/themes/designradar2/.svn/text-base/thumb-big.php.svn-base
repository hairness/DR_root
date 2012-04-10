<?php

	/* BIG THUMBNAIL (GRID3) */


	global $post, $current_thumb;
	
	// CHECK FOR POST TYPE (CLUSTER, OBJECT)
	$queried_single = $wp_query->is_single;
	$queried_post_type = $wp_query->query_vars['post_type'];
	
	
	// CSS CLASSES
	$pos_class = !($current_thumb % 3) ? ' first' : '';
	$thumb_class = 'thumbnail-big thumb-'. $post->post_type .$pos_class;
	$thumb_id = $post->ID;
	
	// MENU
	$overlay_menu = array(
							array(	'name' => 'info',
									'link' => get_permalink()
							)
	);
	
		// MANAGE MODE
		if( $wp_query->query_vars['pagename'] == 'myradar' ){
			$overlay_menu = array(
							array(	'name' => 'edit',
									'link' => get_permalink() . "&do=edit"
							)
			);

		}
	
	
	if($queried_post_type == 'dr_object'){
	// QUERIED OBJECT
	
		if(empty($queried_single)){
		// OBJECT OVERVIEW
			$overlay_menu[] = array(
										'name' => 'add',
										'link' => '#add-to-cluster'
			);
		}	
				
	}
	else if($queried_post_type == 'dr_cluster'){
	// QUERIED CLUSTER
	
		if(empty($queried_single)){
		// CLUSTER OVERVIEW

		}
		else {
		// CLUSTER DETAILS --> THUMBS = OBJECTS
			$overlay_menu[] = array(
										'name' => 'del',
										'link' => '#remove-cluster'
			);
			$overlay_menu[] = array(
										'name' => 'feat',
										'link' => '#set-featured'
			);
		}
	
	}
	
?>


<div class="<?php echo $thumb_class; ?>" id="<?php echo $thumb_id; ?>">

	<div class="image">
		<?php echo the_post_thumbnail(array(200, 145)); ?>
	</div>
	
	<div class="overlay">
		<h2><?php the_title(); ?></h2>
		<span>2012</span>
		<span>Hanspeter Kadel et al.</span>
		<div class="menu">
			<ul>
				<?php 
					foreach($overlay_menu as $item){
						echo "<li><a href='". $item['link'] ."'>". $item['name'] ."</a></li>";
					}
				?>
			</ul>
		</div>
	</div>

</div>