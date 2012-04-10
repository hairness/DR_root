<?php

add_action( 'widgets_init', 'load_format_filter_widget' );

function load_format_filter_widget() {
	register_widget( 'Format_Filter' );
}


class Format_Filter extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function Format_Filter() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'format-filter', 'description' => __('Filter query by format (Sketch, One-Off, Series)', 'format-filter') );

		/* Widget control settings. */
		$control_ops = array('id_base' => 'format-filter-widget' );

		/* Create the widget. */
		$this->WP_Widget( 'format-filter-widget', __('DR/ Format Filter', 'format-filter'), $widget_ops, $control_ops );
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
?>
		
		<script>
		jQuery(function() {
			jQuery( "#format" ).buttonset();
		});
		</script>
		
		<div id="format">
			<input type="checkbox" name="appearance[]" id="check1" value="0"/><label for="check1">Sketch</label>
			<input type="checkbox" name="appearance[]" id="check2" value="1"/><label for="check2">One-Off</label>
			<input type="checkbox" name="appearance[]" id="check3" value="2"/><label for="check3">Series</label>
		</div>
						
<?php		
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
		$defaults = array( 'title' => __('Format Filter', 'format-filter') );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'format-filter'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>

	<?php
	}
}

?>