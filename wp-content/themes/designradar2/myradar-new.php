<?php
		if( isset($_POST['action']) == 'new' ){
			// process data and create new post
			include_once('myradar-new-process.php');
			//
			// $object_id = nnn; //set in included -process.php
			
			// next action will be update
			$action = 'update';
		} 
		else {
			// action isnt set == first time view of this page
			$action = 'new';
		}
		

		/* INIT VARS */
		
		$current_page_url = "http://localhost:8888" . $_SERVER["REQUEST_URI"];
		
		/* INIT SCRIPTS */
		
		function dr_new_object_scripts(){
			wp_enqueue_script('textext', get_bloginfo('template_directory') . '/js/textext.js', array('jquery'));
			wp_enqueue_script('jquery-uploadify');
			wp_enqueue_script('suggest');
			wp_enqueue_script('jquery-ui-dialog');
			wp_enqueue_script('farbtastic-fix', admin_url() . '/js/farbtastic.js');
			wp_enqueue_style('farbtastic');
		}
		add_action('wp_enqueue_scripts', 'dr_new_object_scripts');
		
		
 		get_header();

?>

<h2>Neues Objekt einpflegen</h2>

<form action="<?php echo $current_page_url; ?>" method="post">
<input type="hidden" name="action" value="<?php echo $action; ?>">

<div class="grid6 first new-object-form" style="">

	<div id="image-upload-shizzle">
		
		<h3>Bilder Upload</h3>
		
		<div id="image-stage">
			<img src="<?php bloginfo('template_directory'); ?>/images/blank.png" id="object_image">
		</div>
		
		<input type="hidden" name="object_image_url" id="object_image_url">
		
		<input id="file_upload" type="file" name="file_upload" />
		<button>Thumbnail definieren</button>
		
	</div><!-- image-upload-shizzle -->
	
	<div id="basic-data">
		
		<h3>Basisdaten</h3>
		
		<p>
			<input type="text" name="object_title" id="object_title" value="Objekttitel">
		</p>

		<div class="grid3 first">
			<p>
				<label for="object_year">Jahr</label>
				<input type="text" name="object_year" id="object_year" value="YYYY" style="width: 110px !important; text-align: center">
			</p>		
		</div>
		
		<div class="grid3">
			<p style="margin-bottom: 0;">
				<label for="object_format">Format</label>
			</p>
			<div id="dr_format" style="margin-bottom: 4px;">
				<input type="radio" id="sketch" name="dr_format" value="0" checked="true"/><label for="sketch">Sketch</label>
				<input type="radio" id="oneoff" name="dr_format" value="1"/><label for="oneoff">One-Off</label>
				<input type="radio" id="series" name="dr_format" value="2"/><label for="series">Series</label>
			</div>		
		</div>
		
		<div class="grid6 first">			
			<div class="grid3 first">	
				<p>
					<label for="object_dr_designers">Designer</label>
					<textarea rows="1" name="object_dr_designers" id="object_dr_designers" style="width: 200px;"></textarea>
					<a href="#glossary" rel="dr_designers" title="Designerkatalog">Katalog</a>
				</p>
			</div>
			
			<div class="grid3">		
				<p>
					<label for="object_dr_manufactors">Hersteller</label>
					<textarea rows="1" name="object_dr_manufactors" id="object_dr_manufactors"></textarea>
					<a href="#glossary" rel="dr_manufactors" title="Herstellerkatalog">Katalog</a>
				</p>
			</div>
		</div>

		

	</div><!-- basic-data -->
	
	
	<div id="apperance">
	
		<h3>Objekterscheinung</h3>
		
		<div class="grid3 first">
			<p>
				<label for="object_dr_type">Gattung / Typ</label>
				<textarea rows="1" name="object_dr_type" id="object_dr_type"></textarea>
				<a href="#glossary" rel="dr_type" title="Objektgattungen Katalog">Katalog</a>
			</p>
		</div>
		
		<div class="grid3">
			<p>
				<label for="object_dr_material_properties">Materialeigenschaften</label>
				<textarea rows="1" name="object_dr_material_properties" id="object_dr_material_properties"></textarea>
				<a href="#glossary" rel="dr_material_properties" title="Materialeigenschaften Katalog">Katalog</a>		
				<a href="#add-color" id="open-color-modal" style="float: right">Farbe definieren</a>
			</p>	
		</div>
		
	</div>	
					
	<div id="association">
	
		<h3>Assoziative Tags</h3>
		
		<textarea rows="1" name="object_dr_tags" id="object_dr_tags" style="width: 472px !important"></textarea>
	
	</div><!-- apperance -->
	
	<div id="information">
	
		<h3>Informationen</h3>
		
		<textarea rows="4" name="object_information" id="object_information" style="width: 472px !important"></textarea>
		
		<label for="object_link">URL</label>
		<input type="text" name="object_link" id="object_link" value="http://">
	
	</div><!-- apperance -->
			
	<?php get_template_part('myradar-new', 'differentials'); ?>
	
	<input type="submit" value="Save Draft">
	
</form>	

</div>

<?php // **** MODALS *** ?>

<div id="glossary">
	<div id="glossary-nav">
	A B C D … Z
	</div>
	<div id="glossary-index">
	</div>
</div>

<div id="colors">
	<form>
		<input type="text" id="color" name="color" value="#123456" />
	</form>
		<div id="colorpicker"></div>
		<button id="add-color-tag">Add Color Tag</button>
</div>

<?php // **** MODALS ENDE *** ?>

<script type="text/javascript">
			jQuery(document).ready(function() { 
			
				// FILE UPLOADER
				jQuery('#file_upload').uploadify({
				  	'uploader'		: uploadify.path + 'uploadify.swf',
				  	'script'    	: uploadify.path + 'uploadify.php',
					'folder'    	: uploadify.uploads + '/tmp/',
					'auto'			: true,
					onComplete		: function(event, queueID, fileObj, response, data){
										jQuery('#object_image').attr('src', response);	
										jQuery('#object_image_url').val(response);	 
									}
				});
				
				
				// SUGGESTS
		    	jQuery('#object_dr_designers').textext({
			        plugins : 'tags prompt autocomplete ajax',
			        prompt : 'Add one...',
			        ajax : {
			            url : '<?php echo get_bloginfo('wpurl'); ?>/wp-admin/admin-ajax.php?action=dr_ajax_tag_search&tax=dr_designers',
			            dataType : 'json',
			            cacheResults : true
			        },
			        html: {
		                tag: '<div class="text-tag designer-tag"><div class="text-button"><span class="text-label"/><a class="text-remove"/></div></div>'
		            }
			    });

		    	jQuery('#object_dr_manufactors').textext({
			        plugins : 'tags prompt autocomplete ajax',
			        prompt : 'Add one...',
			        ajax : {
			            url : '<?php echo get_bloginfo('wpurl'); ?>/wp-admin/admin-ajax.php?action=dr_ajax_tag_search&tax=dr_manufactors',
			            dataType : 'json',
			            cacheResults : true
			        }
			    });

		    	jQuery('#object_dr_type').textext({
			        plugins : 'tags prompt autocomplete ajax',
			        prompt : 'Add one...',
			        ajax : {
			            url : '<?php echo get_bloginfo('wpurl'); ?>/wp-admin/admin-ajax.php?action=dr_ajax_tag_search&tax=dr_type',
			            dataType : 'json',
			            cacheResults : true
			        }
			    });

				jQuery('#object_dr_material_properties').textext({
			        plugins : 'tags prompt autocomplete ajax',
			        prompt : 'Add one...',
			        ajax : {
			            url : '<?php echo get_bloginfo('wpurl'); ?>/wp-admin/admin-ajax.php?action=dr_ajax_tag_search&tax=dr_material_properties',
			            dataType : 'json',
			            cacheResults : true
			        }
			    });
		    	
		    	jQuery('#object_dr_tags').textext({
			        plugins : 'tags prompt autocomplete ajax',
			        prompt : 'Add one...',
			        ajax : {
			            url : '<?php echo get_bloginfo('wpurl'); ?>/wp-admin/admin-ajax.php?action=dr_ajax_tag_search&tax=dr_tags',
			            dataType : 'json',
			            cacheResults : true
			        }
			    });
	
		    	
		    	// BUTTONS
				jQuery( "#dr_format" ).buttonset();	
				
				// MODALS 
				
				// (COLORS)
				jQuery('#colors').dialog({
					autoOpen: false,
					height: 320,
					width: 250,
					modal: true
				});
				
     			jQuery('#colorpicker').farbtastic('#color');
   				
   				jQuery('a[href=#add-color]').click( function() {
					jQuery('#colors').dialog('open');
					return false;
				});
				
				// HELPER
				jQuery.extend(jQuery.expr[":"], { "startWith": function(elem, i, match, array) { return (elem.textContent || elem.innerText || "").toLowerCase ().indexOf((match[3] || "").toLowerCase()) == 0; } });

				
				//inside the modal
				jQuery('button#add-color-tag').click( function() {
					var color = jQuery('input#color').val();
					var input = jQuery("textarea#object_dr_material_properties");
					
        			input.textext()[0].tags().addTags( [color] );
        			
        			jQuery('div.text-tags').find('span:startWith("#")').each( function(){
        				var color = jQuery(this).html();
        				
        				//empty
        				jQuery(this).html("");
        				
        				jQuery(this).parents('.text-button').css('background', color);
        				jQuery(this).parents('.text-button').css('width', '60px');
        			});
        			      					
					return false;
				});
				
				
				// (GLOSSARY)
				jQuery('#glossary').dialog({
					autoOpen: false,
					height: 300,
					width: 350,
					modal: true
				});
		
				jQuery('a[href=#glossary]').click( function() {
					
					// get taxonomy
					var tax = jQuery(this).attr('rel');
					var title = jQuery(this).attr('title');
											
					//open jquery dialog	
					jQuery('#glossary').bind( 'dialogopen', function(event, ui){
												
													//set the title
													jQuery(this).dialog('option', 'title', title );
													
													//set a hidden reference to the taxonomy
													jQuery('#glossary-index').attr('tax', tax);
													
													//empty div and add loading bg
													jQuery('#glossary-index').html('').css('height', '100%').css('background', 'url(<?php bloginfo('template_directory'); ?>/images/ajax-loader.gif)');
												
													jQuery.post(
													    dr_ajax.ajaxurl,
													    {
													        action : 'dr_ajax_glossary',
													        tax: tax
													    },
													    function( response ) {
													    	//render content
													        jQuery('#glossary-index').html(response);
													        //remove loading bg
													        jQuery('#glossary-index').css('background', 'none');
													    }
													);
												
					});
										
					jQuery('#glossary').dialog('open');
					
					return false;
				});	 
				
				// link glossary results to tag input
				
				jQuery('#glossary-index').find('a').live( 'click', function(){
					
					// grab tax
					var tax = jQuery('#glossary-index').attr('tax');
										
					// clicked tag
					var tag = jQuery(this).text();
					
					// input field
					var input = jQuery("#object_"+tax);
					
					input.textext()[0].tags().addTags( [tag] );
										
					return false;
				});
			
			});
		</script>

<?php get_footer(); ?>