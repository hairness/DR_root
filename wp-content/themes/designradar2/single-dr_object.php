<?php get_header(); ?>

<div>
	<div class="grid8 first">
		
		<div class="object-image">
			<h2><?php the_title(); ?></h2>
		
			<?php the_post_thumbnail(array(600, 800)); ?>
			
			<p><?php the_dr_object_about(); ?></p>
		</div>
		
		<div class="object-comments">
			<?php comments_template(); ?>
		</div>
	
	</div>
	
	<div class="grid4">
		
		<div class="object-info">

			<table>
				<tr>
					<td class="title"><?php _e('Designer'); ?></td>
					<td><?php 					
								foreach(get_dr_object_designer() as $i => $designer){ 
									echo ($i>0) ? ",<br/>" : "";
									echo $designer->name;											} 
						?>
					</td>
				</tr>
				<tr>
					<td class="title"><?php _e('Published'); ?></td>
					<td><?php the_dr_object_year(); ?></td>
				</tr>
				<tr>
					<td class="title"><?php _e('Format'); ?></td>
					<td><?php 
								$check = get_dr_object_manufactor();
																
								the_dr_object_format(); 
								
								echo (isset($check[0])) ? ' '.__('by').' ' : '';
								
								foreach($check as $i => $manufactor){ 
									echo ($i>0) ? ",<br/>" : "";
									echo $manufactor->name;													} 
								
						?>
					</td>
				</tr>
				<tr>
					<td class="title"><?php _e('Materialeigenschaften'); ?></td>
					<td>
						<ul>
							<?php
									$materials = get_dr_object_materials();
							
									if( !empty($materials) ){
										foreach($materials as $material){
											$name = $material->name; 
											$slug = $material->slug;
											
											echo "<li><a href='".get_bloginfo('wpurl')."/tags/$slug'>$name</a></li>";
										
										}
									}
									else {
										echo "(Unbekant)";
									}
							?>
						</ul>
					</td>
				</tr>
				<tr>
					<td class="title"><?php _e('Key Colors'); ?></td>
					<td><?php
								$colors = get_dr_object_colors(); 	
								
								if(!empty($colors)){
									
									foreach($colors as $color){
										
										echo $color->h . ' / ' . $color->s . ' / ' .$color->l . '<br>';
										
									}
									
								} else {
									echo "(Unbekannt)";
								}
						?>
					</td>
				</tr>
				<tr>
					<td class="title"><?php _e('Tags'); ?></td>
					<td>
						<ul>
							<?php
									$tags = get_dr_object_tags();
							
									if( !empty($tags) ){
										foreach($tags as $tag){
											$name = $tag->name; 
											$slug = $tag->slug;
											
											echo "<li><a href='".get_bloginfo('wpurl')."/tags/$slug'>$name</a></li>";
										
										}
									}
									else {
										echo "(Unbekant)";
									}
							?>
						</ul>
					</td>
				</tr>
			</table>
			
		</div>

		<div class="object-differentials">
		
			<?php
					global $object_differentials, $object_differentials_titles;
					
					$post_custom = get_post_custom($post->ID);
					
					foreach($object_differentials as $object_differential_group){
					
						echo "<h2>".$object_differential_group['group']."</h2>";
						
						foreach($object_differential_group['differentials'] as $object_differential){
							
							if( isset($post_custom["diff-".$object_differential[0]][0]) ){
												
								$value = $post_custom["diff-".$object_differential[0]][0];
								$exl = $object_differentials_titles[$i][0];	
								$exr = $object_differentials_titles[$i][1];	
																
								echo "<div class='differential diff$value'>
									    <span style='float: left;'>$exl</span> <span style='float: right;'>$exr</span>
								  	  </div>";
							}
						}
						
					}
			?>

		</div><!-- .object-differentials -->
</div>
</div>

<?php get_footer(); ?>