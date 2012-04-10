<?php

add_action( 'widgets_init', 'load_cluster_object_colors_widget' );

function load_cluster_object_colors_widget() {
	register_widget( 'Cluster_Object_Colors' );
}


class Cluster_Object_Colors extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function Cluster_Object_Colors() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'cluster-object-colors', 'description' => __('Colors of featured objects', 'cluster-object-colors') );

		/* Widget control settings. */
		$control_ops = array('id_base' => 'cluster-object-colors-widget' );

		/* Create the widget. */
		$this->WP_Widget( 'cluster-object-colors', __('DR/ Cluster Object Colors', 'cluster-object-colors'), $widget_ops, $control_ops );
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
	
		global $post, $wpdb;
		
		$object_ids = get_post_meta($post->ID, 'object_id'); //get all the linked objects
		
		$object_ids_string = implode(',', $object_ids);
											
		$matching_colors = $wpdb->get_results("SELECT h,s,l FROM wp_colors WHERE post_id IN ($object_ids_string) ORDER BY h,s,l");
			
		//print_r($matching_colors);	
				
		echo "<ul>";
		foreach($matching_colors as $color){
		
			$hex_color = rgb2html( _color_hsl2rgb($color->h, $color->s, $color->l) );

			echo '<li style="background: '.$hex_color.'; width: 28px; height: 20px; float: left;"></li>';
		
		}
		echo '<li style="clear: both"></li>';
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
		$defaults = array( 'title' => __('Cluster Object Colors', 'cluster-object-colors') );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'cluster-object-colors'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>

	<?php
	}
}

?>