<?php

	//this is a funky little helper with functions like hex2hsl, etc...
	include_once( DR_PLUGIN_DIR_PATH . '/inc/lux.inc.php');  
	$LuxInstance = new Lux_Color;


	/* NEW/EDIT OBJECT PANEL */
	
	// hook
	add_action("admin_init", "object_custom_meta_boxes");
	
	// hook function 
	function object_custom_meta_boxes(){
	
	  add_meta_box("year_published-meta", 	"Year Published", 	"year_published", 	"dr_object", "side", "low");
	  add_meta_box("format-meta", 			"Format", 			"format", 			"dr_object", "side", "low");
	  add_meta_box("colors-meta", 			"Colors", 			"colors", 			"dr_object", "side", "low");
	  add_meta_box("about-meta", 			"About", 			"about",			"dr_object", "normal", "default");
	  add_meta_box("differentials-meta", 	"Differentials", 	"differentials",	"dr_object", "normal", "default");
	  
	  //enqueue scripts for the color selector
	  wp_enqueue_script('farbtastic');
	  wp_enqueue_style('farbtastic');
	  
	  //for the sliders
	  wp_enqueue_script('jquery-ui-slider');
	  wp_enqueue_style('jquery-style', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css');
	  
	}
	
	
	// HELPER FUNKTIONS
	
	function about($post){
			
		$info_raw = get_post_custom_values('about-information', $post->ID);
		$info = isset($info_raw[0]) ? $info_raw[0] : "";
		
		$link_raw = get_post_custom_values('about-link', $post->ID);
		$link = isset($link_raw[0]) ? $link_raw[0] : "";
		
		echo "Information: <br/>
		<textarea name='about-information' style='width: 100%'>$info</textarea>
		Link:<br>
		<input type='text' name='about-link' value='$link'>";
		
		
	
	} 
	 
	function differentials($post){
	  
	  global $object_differentials, $object_differentials_titles;
	  
	  $post_custom = get_post_custom($post->ID);
	  
	  foreach($object_differentials as $object_differential_group){
	  
	  	echo "<h2>".$object_differential_group['group']."</h2>";
	  	
	  	
	  	foreach($object_differential_group['differentials'] as $object_differential){
		  
		  	$class = "differential"; //standard class
		  	$value = 0; //standard value
		  	$ignore_state = "";
		  
		  	//check if theres already a value set (active differential)
		  	if( isset($post_custom["diff-".$object_differential[0]][0]) ){
		  		
		  		$value = $post_custom["diff-".$object_differential[0]][0];
		  	
		  	}
		  	else {
		  		$class .= " ignore";
		  		$ignore_state = " checked='checked'";
		  	}
		  	
		  
		  	$value = isset($post_custom["diff-".$object_differential[0]][0]) ? $post_custom["diff-".$object_differential[0]][0] : 0;
		  	$exl = $object_differential[1];	
		  	$exr = $object_differential[2];	
		  		
			echo "<div class='$class'>
					<input type='hidden' name='diff-".$object_differential[0]."' value='$value'>
					<strong class='fl'>$exl</strong><strong class='fr'>$exr</strong>
					<span></span>
					<p>
					<input type='checkbox' name='diff-".$object_differential[0]."-ignore' id='diff-".$object_differential[0]."-ignore'$ignore_state>
				  	<label for='diff-".$object_differential[0]."-ignore'>Keine Angabe / Unbekannt</label>
				  	</p>
				  </div>";
		}
		
	  }
	   
	  echo "<br class='clear'>
	  
	  		<style>	
	  				.fl { float: left; }
	  				.fr { float: right; }
	  				.differential > span { display: block; width: 100%; float: left; }
	  				.differential { width: 200px; margin: 10px 30px 30px 10px; float: left; }
	  				.differential > p { float: left; }
	  				.ignore { opacity: 0.4; }
	  		</style>
	  		
	  		<script>
				jQuery(function() {
					
					jQuery( '.differential' ).each(function() {
					
						var differential = jQuery( this );
						var ignore_checkbox = jQuery( this ).find('input[type=checkbox]');
						var input_field = jQuery( this ).find('input[type=hidden]');
						var slider_span = jQuery( this ).find('span');
						var value = input_field.val();
						
						
						slider_span.slider({	
												value: value,												
												min: -2,
												max: 2,
												step: 1,
												start: function() {
													ignore_checkbox.attr('checked', false);
													differential.removeClass('ignore');
												},
												slide: function(event, ui) {
													input_field.val( ui.value );
												}
						});
						
						ignore_checkbox.click( function() {
							if ( jQuery(this).is (':checked')) {
								jQuery(this).parents('.differential').addClass('ignore');
							}
							else {
								jQuery(this).parents('.differential').removeClass('ignore');
							}
						});
						
					});				
			
				});
			</script>";
		//endecho
	} 
	
	 
	function year_published($post){
	
	  $custom = get_post_custom($post->ID);
	  $year_published = !empty($custom["year_published"]) ? $custom["year_published"][0] : '';
	  ?>
	  <div style="width: 100%; text-align: center;">
	  	<input type="text" name="year_published" value="<?php echo $year_published; ?>" style="width: 80px; padding: 7px; text-align: center;"/>
	  </div>
	  <?php
	}
	
	function format($post){
	  global $object_formats;
	  	
	  $format = get_post_meta($post->ID, 'format', true);
	  	  	  
	  ?>
	  <div style="width: 100%; text-align: center;">    
	  		<script>
				jQuery(function() {
					jQuery( "#dr_format" ).buttonset();
				});
			</script>
					
			<div id="dr_format">
				<input type="radio" id="sketch" name="format" value="0"<?php echo ($format==0) ? ' checked="checked"' : ''; ?>/><label for="sketch"><?php echo $object_formats[0]; ?></label>
				<input type="radio" id="oneoff" name="format" value="1"<?php echo ($format==1) ? ' checked="checked"' : ''; ?>/><label for="oneoff"><?php echo $object_formats[1]; ?></label>
				<input type="radio" id="series" name="format" value="2"<?php echo ($format==2) ? ' checked="checked"' : ''; ?>/><label for="series"><?php echo $object_formats[2]; ?></label>
			</div>
	  </div>
	  <?php
	}
	
	
	function colors($post){
	
	  global $wpdb, $LuxInstance;
	
	  //query colors from wp_colors table
	  $colors = $wpdb->get_results("SELECT * FROM wp_colors WHERE post_id = ".$post->ID." ORDER BY rank"); 
	    
	  //loop colors
	  
	  echo "<p>Click inside the colored fields to manipulate tone.</p>";
	  
	  echo "<p>Update Colors? <input type='checkbox' name='update_colors'></p>";
	  
	  echo "<div id='colors'>";
	  	  
		  for($i=0; $i<3; $i++){
		  	$rank = $i;
		  	
		  	if(!empty($colors[$i])){
		  	
			  	$H = $colors[$i]->h / 255;
			  	$S = $colors[$i]->s / 255;
			  	$L = $colors[$i]->l / 255;
			  	
			  	$hex =  "#" . $LuxInstance->hsl2hex(array($H, $S, $L));
		  	
		  	}
		  	else
		  		$hex = -1;
		  	
		  	echo "<div id='colorbox1-$rank' style='float: left; text-align: center;'>";
		  	echo "	<strong>Color #$rank</strong><br>";
		  	echo "	<input type='text' class='color-box' id='color-$rank' name='color-$rank' value='$hex' style='width: 84px; height: 80px; background: $hex; color: $hex; cursor: pointer;'/>";
			echo "</div>";  	
		  }
	  
	  echo "</div>";
	    
	  echo "<div id='colorpicker' style='margin: 10px 30px; float: left;'></div><br class='clear'>";
	
	    
	  echo "<script type='text/javascript'>
	  			jQuery(document).ready(function() {
	  				
	  				var ft = jQuery.farbtastic('#colorpicker');
	  				
	  				jQuery('.color-box').click(function(){
	  					ft.linkTo(jQuery(this));
	
	  					return false;
	  				});
	  				
				});
	 		</script>";
	
	}

?>