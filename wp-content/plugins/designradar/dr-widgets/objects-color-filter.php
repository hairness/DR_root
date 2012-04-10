<?php

add_action( 'widgets_init', 'load_color_filter_widget' );

function load_color_filter_widget() {

	register_widget( 'Color_Filter' );
}


class Color_Filter extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function Color_Filter() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'color-filter', 'description' => __('Filter objects query by color.', 'color-filter') );

		/* Widget control settings. */
		$control_ops = array('id_base' => 'color-filter-widget' );

		/* Create the widget. */
		$this->WP_Widget( 'color-filter-widget', __('DR/ Color Filter', 'color-filter'), $widget_ops, $control_ops );
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		global $lux;
	
		extract( $args );

		/* Our variables from the widget settings. */
		$title = apply_filters('widget_title', $instance['title'] );

		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Display the widget title if one was input (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title;

		echo "<style>
				#color_chips label { height: 20px; width: 22px; border: none;}
			  </style>";
		
		echo "<div id='color_chips'>";
		
		global $color_chips;
		
		foreach($color_chips as $color_chip){
		
			echo "<input type='checkbox' name='color[]' id='$color_chip'><label for='$color_chip' style='background: #$color_chip'></label>";
			
		}
		
		echo "</div>";
		
		echo "<script>
				jQuery(function() {
					jQuery( '#color_chips' ).buttonset();
				});
			  </script>";

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
		$defaults = array( 'title' => __('Filter by Color', 'color-filter'), 'name' => __('John Doe', 'color-filter'), 'sex' => 'male', 'show_sex' => true );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'color-filter'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>

	<?php
	}
}

?>