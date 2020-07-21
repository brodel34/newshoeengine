<?php
/**
 * Mailchimp signup widget
 *
 * Displays mailchimp newsletter subscription form
 *
 * @author WolfThemes
 * @category Widgets
 * @extends WP_Widget
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/* Register the widget */
function wvc_widget_socials_init() {

	register_widget( 'WVC_Widget_Socials' );
}
add_action( 'widgets_init', 'wvc_widget_socials_init' );

class WVC_Widget_Socials extends WP_Widget {

	var $wvc_widget_cssclass;
	var $wvc_widget_description;
	var $wvc_widget_idbase;
	var $wvc_widget_name;

	/**
	 * Constructor
	 */
	public function __construct() {

		/* Widget variable settings. */
		$this->wvc_widget_name 	= esc_html__( 'Socials', 'wolf-visual-composer' );
		$this->wvc_widget_description = esc_html__( 'You social profiles with icons', 'wolf-visual-composer' );
		$this->wvc_widget_cssclass 	= 'wvc_widget_socials';
		$this->wvc_widget_idbase 	= 'wvc_widget_socials';

		/* Widget settings. */
		$widget_ops = array( 'classname' => $this->wvc_widget_cssclass, 'description' => $this->wvc_widget_description );

		/* Create the widget. */
		parent::__construct( $this->wvc_widget_idbase, $this->wvc_widget_name, $widget_ops );
	}

	/**
	 * widget function.
	 *
	 * @see WP_Widget
	 * @param array $args
	 * @param array $instance
	 */
	function widget( $args, $instance ) {

		extract( $args );
		$title = ( isset( $instance['title'] ) ) ? sanitize_text_field( $instance['title'] ) : '';
		$title = apply_filters( 'widget_title', $title );
		$socials = ( isset( $instance['socials'] ) ) ? esc_attr( $instance['socials'] ) : null;
		echo $before_widget;
		if ( ! empty( $title ) ) echo $before_title . $title . $after_title;
		echo wvc_socials( array( 'services' => $socials, 'alignment' => 'left', ) );
		echo $after_widget;
	}

	/**
	 * update function.
	 *
	 * @see WP_Widget->update
	 * @param array $new_instance
	 * @param array $old_instance
	 * @return array
	 */
	function update( $new_instance, $old_instance ) {

		$instance = $old_instance;
		$instance['title'] = esc_attr( $new_instance['title'] );
		$instance['socials'] = esc_attr( $new_instance['socials'] );
		return $instance;
	}

	/**
	 * form function.
	 *
	 * @see WP_Widget->form
	 * @param array $instance
	 */
	function form( $instance ) {
		$defaults = array(
			'title' => '',
			'socials' => 'facebook,twitter,instagram',
		);
		$instance = wp_parse_args( ( array ) $instance, $defaults);
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title', 'wolf-visual-composer' ); ?>:</label>
			<input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'socials' ) ); ?>"><?php _e( 'Social Services', 'wolf-visual-composer' ); ?>:</label>
			<input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id( 'socials' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name('socials') ); ?>" value="<?php echo esc_attr( $instance['socials'] ); ?>">
			<br>
			<small><?php esc_html_e( 'You can set your social profiles in the plugin settings.', 'wolf-visual-composer' ); ?></small>
		</p>
		<?php
	}
}