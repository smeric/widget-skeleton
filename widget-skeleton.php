<?php
/**
 * Plugin Name:       Skeleton Widget
 * Description:       Skeleton Widget description.
 * Version:           1.1.1
 * Text Domain:       widget-skeleton-text-domain
 * Domain Path:       /languages
 * Author:            Sébastien Méric
 * License:           GNU General Public License v2
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.html
 * Plugin URI:        https://github.com/smeric/widget-skeleton
 * GitHub Plugin URI: https://github.com/smeric/widget-skeleton
 * Requires at least: 5.2
 * Requires PHP:      5.6
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
		}
		else {
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
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'widget-skeleton-text-domain'); ?></label>
            <input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
        </p>

        <!-- Show Title ? Checkbox -->
        <p>
            <input class="checkbox" type="checkbox" <?php checked( (bool) $instance['show_title'], true ); ?> id="<?php echo $this->get_field_id( 'show_title' ); ?>" name="<?php echo $this->get_field_name( 'show_title' ); ?>" />
            <label for="<?php echo $this->get_field_id( 'show_title' ); ?>"><?php _e('Display title', 'widget-skeleton-text-domain'); ?></label>
        </p>

        <!-- Choose ? Select field -->
        <p>
            <label for="<?php echo $this->get_field_id('select'); ?>"><?php _e( 'Choose an option :', 'widget-skeleton-text-domain' ); ?></label>
            <select name="<?php echo $this->get_field_name('select'); ?>" id="<?php echo $this->get_field_id('select'); ?>" class="widefat">
                <option value="option1"<?php selected( $instance['select'], 'option1' ); ?>><?php _e( 'Option 1', 'widget-skeleton-text-domain' ); ?></option>
                <option value="option2"<?php selected( $instance['select'], 'option2' ); ?>><?php _e( 'Option 2', 'widget-skeleton-text-domain' ); ?></option>
                <option value="option3"<?php selected( $instance['select'], 'option3' ); ?>><?php _e( 'Option 3', 'widget-skeleton-text-domain' ); ?></option>
            </select>
        </p>
        <?php
    }
}