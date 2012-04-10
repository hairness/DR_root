<?php

add_action( 'widgets_init', 'load_tags_filter_widget' );

function load_tags_filter_widget() {
	register_widget( 'Tags_Filter' );
}


class Tags_Filter extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function Tags_Filter() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'tags-filter', 'description' => __('Filter by tags.', 'tags-filter') );

		/* Widget control settings. */
		$control_ops = array('id_base' => 'tags-filter-widget' );

		/* Create the widget. */
		$this->WP_Widget( 'tags-filter-widget', __('DR/ Tag Filter', 'tags-filter'), $widget_ops, $control_ops );
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

		
		global $wpdb;
		
		$tags = $wpdb->get_results("SELECT DISTINCT $wpdb->terms.term_id, $wpdb->terms.name, $wpdb->terms.slug
FROM $wpdb->terms
    INNER JOIN $wpdb->term_taxonomy ON ($wpdb->terms.term_id = $wpdb->term_taxonomy.term_id)
    INNER JOIN $wpdb->term_relationships ON ($wpdb->terms.term_id = $wpdb->term_relationships.term_taxonomy_id)
    INNER JOIN $wpdb->posts ON ($wpdb->term_relationships.object_id = $wpdb->posts.ID)
WHERE $wpdb->term_taxonomy.taxonomy = 'dr_tags'
ORDER BY $wpdb->posts.post_date DESC LIMIT 30");
				
		foreach($tags as $tag){
				
			$tagname = $tag->name;
			$tagslug = $tag->slug;
						
			echo "<input type='checkbox' name='tags[]' value='$tagslug' id='$tagslug' class='tag-checkbox' /><label for='$tagslug'>$tagname</label>\n";

		}

?>
	<script>
	jQuery(document).ready( function() {
		jQuery( ".tag-checkbox" ).button();
	});
	</script>
		
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
		$defaults = array( 'title' => __('Filter by Tag', 'tags-filter'), 'name' => __('John Doe', 'tags-filter'), 'sex' => 'male', 'show_sex' => true );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'tags-filter'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>

	<?php
	}
}

?>