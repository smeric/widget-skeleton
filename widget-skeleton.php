<?php
/**
 * Plugin Name: Skeleton Widget
 * Description: Skeleton Widget description.
 * Version:     1.0
 * Text Domain: widget-skeleton-text-domain
 * Domain Path: /languages
 *
 * Plugin URI:        https://github.com/smeric/widget-skeleton
 * GitHub URI:        smeric/widget-skeleton
 * GitHub Plugin URI: smeric/widget-skeleton
 */

function widget_skeleton_register_widget() {
    register_widget( 'Widget_Skeleton_Widget' );
}
add_action( 'widgets_init', 'widget_skeleton_register_widget' );

class Widget_Skeleton_Widget extends WP_Widget {
    function __construct() {
        parent::__construct(
            // widget ID
            'widget-skeleton',
            // widget name
            __( 'Skeleton Widget', 'widget-skeleton' ),
            // widget description
            array(
                'description'                 => __( 'This widget is a skeleton and does nothing particular...', 'widget-skeleton-text-domain' ),
                'classname'                   => 'widget-skeleton',
                'customize_selective_refresh' => true,
            )
        );
    }

	/**
	 * How to display the widget on the screen.
	 */
    public function widget( $args, $instance ) {
		extract( $args, EXTR_SKIP );

		$title = apply_filters( 'pages_widget_title', $instance['title'] );
		$show_title = (bool) $instance['show_title'];
        $select = empty( $instance['select'] ) ? 'option1' : $instance['select'];

		/* Before widget (defined by themes). */
		echo $before_widget;

		if ( $title && $show_title )
			echo $before_title . $title . $after_title;

        sprintf( __( "I've selected %s", 'widget-skeleton-text-domain'), $select );

		/* After widget (defined by themes). */
		echo $after_widget;

    }

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
    public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		if ( in_array( $new_instance['select'], array( 'option1', 'option2', 'option3'  ) ) ) {
			$instance['select'] = $new_instance['select'];
		} else {
			$instance['select'] = 'option1';
		}

		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['show_title'] = (bool) $new_instance['show_title'];

		return $instance;
    }

    /**
	 * Update the widget settings.
	 */
    public function form( $instance ) {
		//Defaults
		$instance = wp_parse_args( (array) $instance, array( 'select' => 'option1' ) );
        ?>
		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'widget-de-test'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>

		<!-- Show Title ? Checkbox -->
		<p>
			<input class="checkbox" type="checkbox" <?php checked( (bool) $instance['show_title'], true ); ?> id="<?php echo $this->get_field_id( 'show_title' ); ?>" name="<?php echo $this->get_field_name( 'show_title' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'show_title' ); ?>"><?php _e('Display title', 'widget-de-test'); ?></label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('select'); ?>"><?php _e( 'Sort by :', 'widget-de-test' ); ?></label>
			<select name="<?php echo $this->get_field_name('select'); ?>" id="<?php echo $this->get_field_id('select'); ?>" class="widefat">
				<option value="option1"<?php selected( $instance['select'], 'option1' ); ?>><?php _e( 'Option 1', 'widget-de-test' ); ?></option>
				<option value="option2"<?php selected( $instance['select'], 'option2' ); ?>><?php _e( 'Option 2', 'widget-de-test' ); ?></option>
				<option value="option3"<?php selected( $instance['select'], 'option3' ); ?>><?php _e( 'Option 3', 'widget-de-test' ); ?></option>
			</select>
		</p>
        <?php
    }
}