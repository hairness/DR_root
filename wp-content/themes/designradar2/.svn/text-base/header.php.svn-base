<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">

    <title><?php wp_title( '/', true, 'right' ); ?>Designradar</title>
    
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/style.css">
    <link rel="stylesheet/less" type="text/css" href="<?php bloginfo('template_directory'); ?>/css/styles.less">
        
    <?php wp_head();?>
	
</head>
<body>

	<div id="head_wrapper" class="clearfix">
		<div id="header">
   			<div id="logo" class="grid3 first">
				<img src="<?php bloginfo('template_directory'); ?>/images/logo-weiss.png" alt="logo-weiss" width="100" />
   			</div>
   			<div id="main_nav" class="grid6">   					
	   			<ul>
	   				<li><a href="<?php bloginfo('wpurl'); ?>/objects">Objects</a></li>
	   				<li><a href="<?php bloginfo('wpurl'); ?>/cluster">Cluster</a></li>
	   				<li><a href="<?php bloginfo('wpurl'); ?>/myradar">MyRadar</a></li>
	   			</ul>
   			</div>
   			<?php 
   				if( is_user_logged_in() ){
   					global $display_name;
   					get_currentuserinfo();
   					
   					echo "Howdy $display_name!";
   				}
   				else {
   					echo "<a href='#login'>Log-In</a>";
   				}
   			?>
   			<div id="login-modal">
   				<?php get_template_part('myradar', 'login'); ?>
   			</div>
   			<script>
   				jQuery(document).ready( function(){
   					
   					// LOGIN MODAL
					jQuery('div#login-modal').dialog({
						title: 'Login / Register',
						autoOpen: false,
						height: 300,
						width: 320,
						modal: true
					});
   					
   					// OPEN LOGIN MODAL
   					jQuery('a[href=#login]').click( function(){
   						jQuery('#login-modal').dialog('open');
   						return false;
   					});
   				});
   			</script>
   		</div><!-- header -->
	</div><!-- head_wrapper -->

   <div id="wrapper" class="clearfix">
   
   		<div id="main">
