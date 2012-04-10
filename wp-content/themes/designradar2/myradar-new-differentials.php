<?php
	global $object_differentials, $object_differentials_titles, $post;
	  
	$post_custom = get_post_custom($post->ID);
	  
	
	
	foreach($object_differentials as $object_differential_group){
	
		echo "<div><h3>".$object_differential_group['group']."</h3>";
		
		
		foreach($object_differential_group['differentials'] as $i => $object_differential){
	  
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
		  	
		  	if($i%2 != 1){
		  		$class .= " first";
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
		
		echo "</div>";
	
	}
?>	

<style>	
	.fl { float: left; }
	.fr { float: right; }
	
	.differential > span { display: block; width: 100%; float: left; margin: 4px 0 8px 0; }
	.differential { width: 220px; margin: 0 0 20px 30px; float: left; }
	.differential > p { float: left; }
	.differential label { display: inline !important; }
	.differential input{ width: auto !important; }
	.ignore { opacity: 0.4; }
</style>

<script>
	jQuery(function() {
		
		jQuery('.differential').hover(
			function() {
		      jQuery(this).stop().animate({opacity: "1"}, '100');
		    },
		    function() {
		      var checked = jQuery(this).find('input').is(':checked'); // is on ignore?
		      var std = (checked) ? 0.4 : 1; // set fallback opacity
		      jQuery(this).stop().animate({opacity: std}, '150');
		    }
		);
	
		
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
</script>