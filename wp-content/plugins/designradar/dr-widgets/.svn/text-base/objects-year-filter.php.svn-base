<?php

add_action( 'widgets_init', 'load_year_filter_widget' );
function load_year_filter_widget() {
	register_widget( 'Year_Filter' );
}

class Year_Filter extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function Year_Filter() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'year-filter', 'description' => __('Filter by publishing year (from xxxx to yyyy).', 'year-filter') );

		/* Widget control settings. */
		$control_ops = array('id_base' => 'year-filter-widget' );

		/* Create the widget. */
		$this->WP_Widget( 'year-filter-widget', __('DR/ Year Filter', 'year-filter'), $widget_ops, $control_ops );
		
		/* Load scripts / styles */
		if ( is_active_widget( false, false, $this->id_base, true ) && !is_admin()) {			
			wp_enqueue_script( 'jquery-ui-slider' );					
		}	
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

		/* HTML GOES HERE */
?>

	<script>
	jQuery(function() {
		jQuery( "#slider-range" ).slider({
			range: true,
			min: 1900,
			max: <?php echo date('Y'); ?>,
			values: [ 1900, <?php echo date('Y'); ?> ],
			slide: function( event, ui ) {
				jQuery( "#amount" ).val( ui.values[ 0 ] + " - " + ui.values[ 1 ] );
			}
		});
		jQuery( "#amount" ).val( jQuery( "#slider-range" ).slider( "values", 0 ) +
			" - " + jQuery( "#slider-range" ).slider( "values", 1 ) );
	});
	</script>

<p>
	<label for="amount">Published between:</label>
	<input type="text" id="amount" name="year_spread" style="border:0; color:#f6931f; font-weight:bold;" />
</p>

<div id="slider-range"></div>

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
		$defaults = array( 'title' => __('Filter by Year', 'year-filter'), 'name' => __('John Doe', 'year-filter'), 'sex' => 'male', 'show_sex' => true );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'year-filter'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>

	<?php
	}
}

?>