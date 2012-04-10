<?php
	
	// DEFINE HOW THE COMMENTS INPUT LOOKS LIKE
	
	$form_args = array(
						//'fields'               => apply_filters( 'comment_form_default_fields', $fields ),
						'comment_field'        => '<p class="comment-form-comment"><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea></p>',
						'must_log_in'          => '<p class="must-log-in">must be logged in</p>',
						'logged_in_as'         => '',
						'comment_notes_before' => '',
						'comment_notes_after'  => '',
						'id_form'              => 'commentform',
						'id_submit'            => 'submit',
						'title_reply'          => __( 'Leave a Comment' ),
						'title_reply_to'       => __( 'Leave a Reply to %s' ),
						'cancel_reply_link'    => __( 'Cancel reply' ),
						'label_submit'         => __( 'Post Comment' ),
	);



function drt_comment($comment, $args, $depth) {

   $GLOBALS['comment'] = $comment; 
   
?>

   <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
     
     <div id="comment-<?php comment_ID(); ?>">
      
      	<span>	<?php comment_author_link(); ?>, 
      			<?php printf(__('%1$s, %2$s'), get_comment_date(),  get_comment_time()); ?>
      			<?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
      	</span>
     
		
		<?php if ($comment->comment_approved == '0') : ?>
	
					<em><?php _e('Your comment is awaiting moderation.') ?></em>
					
		<?php endif; ?>

		<?php comment_text(); ?>

		
	</div>
<?php }


		//  KOMMENTAR AUSGABE

		if ( have_comments() ) : 
?>
	
	<h3><?php comments_number(__('0 Comments'), __('1 Comment'), __('% Comments') );?></h3>
	
	<?php if(current_user_can('moderate_comments')){ echo "<a href='".admin_url('edit-comments.php?p='.$post->ID)."'>Edit Comments</a>"; } ?>
	
	<ul class="commentlist">
		<?php wp_list_comments('type=comment&callback=drt_comment'); ?>
	</ul>
	
<?php 	
		else :
		
			if ('open' != $post->comment_status) : echo '<p>'.__('Comments are closed.').'</p>'; endif;
	
		endif; 
		
		
		comment_form($form_args);
	
?>