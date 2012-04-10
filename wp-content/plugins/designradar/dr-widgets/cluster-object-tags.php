<?php

add_action( 'widgets_init', 'load_cluster_object_tags_widget' );

function load_cluster_object_tags_widget() {
	register_widget( 'Cluster_Object_Tags' );
}


class Cluster_Object_Tags extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function Cluster_Object_Tags() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'cluster-object-tags', 'description' => __('Tagcloud of featured objects.', 'cluster-object-tags') );

		/* Widget control settings. */
		$control_ops = array('id_base' => 'cluster-object-tags-widget' );

		/* Create the widget. */
		$this->WP_Widget( 'cluster-object-tags-widget', __('DR/ Cluster Object Tags', 'cluster-object-tags'), $widget_ops, $control_ops );
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings. */
		$title = apply_filters('widget_title', $instance['title'] );

		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Display the widget title if one was input (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title;

	/* OUTPUT STARTS */
	
		global $post;
		
		$object_ids = get_post_meta($post->ID, 'object_id'); //get all the linked objects
						
		$cluster_objects_args = array(
				'post_type' => 'dr_object',
				'post__in' => $object_ids
		);
		
		$cluster_objects = new WP_Query( $cluster_objects_args ); //query dr_objects with linked ids
		
		$tags = array(); //blank array for storing the tags in
		
		while ( $cluster_objects->have_posts() ) : $cluster_objects->the_post();
						
			// get all post tags
			$posttags = get_the_terms($post->ID, 'dr_tags');
			
		    if ($posttags){
		        foreach ($posttags as $posttag){
		        	$tags[$posttag->term_id] = $posttag->name; // add to array of tag ids => names
		        }
		    }
		    
		endwhile;
		
		wp_reset_query(); // !important for following widgets
		
		// all tags are stored in $tags now
		
		
		echo "<ul>";
		foreach($tags as $tag){
		
			echo "<li>".$tag."</li>";
		
		}
		echo "</ul>";
		

	/* OUTPUT ENDS */
		
		/* After widget (defined by themes). */
		echo $after_widget;
	}

	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['name'] = strip_tags( $new_instance['name'] );

		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => __('Cluster Object Tags', 'cluster-object-tags') );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'cluster-object-tags'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>

	<?php
	}
}

?>