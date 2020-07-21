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
function wvc_widget_mailchimp_init() {

	register_widget( 'WVC_Widget_Mailchimp' );
}
add_action( 'widgets_init', 'wvc_widget_mailchimp_init' );

class WVC_Widget_Mailchimp extends WP_Widget {

	var $wvc_widget_cssclass;
	var $wvc_widget_description;
	var $wvc_widget_idbase;
	var $wvc_widget_name;

	/**
	 * Constructor
	 */
	public function __construct() {

		/* Widget variable settings. */
		$this->wvc_widget_name 	= 'Mailchimp';
		$this->wvc_widget_description = esc_html__( 'Newsletter signup form', 'wolf-visual-composer' );
		$this->wvc_widget_cssclass 	= 'widget_mailchimp';
		$this->wvc_widget_idbase 	= 'widget_mailchimp';

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
		wp_enqueue_script( 'wpb-mailchimp', WVC_JS . '/min/mailchimp.min.js', array( 'jquery' ), WVC_VERSION, true );
		wp_localize_script(
			'wpb-mailchimp', 'WPBMailchimpParams', array(
				'ajaxUrl' => esc_url( admin_url( 'admin-ajax.php' ) ),
			)
		);
		extract( $args );

		$title = ( isset( $instance['title'] ) ) ? sanitize_text_field( $instance['title'] ) : '';
		$title = apply_filters( 'widget_title', $title );
		$description = ( isset( $instance['description'] ) ) ? sanitize_text_field( $instance['description'] ) : '';
		$list = ( isset( $instance['list'] ) ) ? esc_attr( $instance['list'] ) : null;
		$show_bg = ( isset( $instance['show_bg'] ) ) ? esc_attr( $instance['show_bg'] ) : 'yes';
		$show_label = ( isset( $instance['show_label'] ) ) ? esc_attr( $instance['show_label'] ) : 'yes';
		$size = ( isset( $instance['size'] ) ) ? esc_attr( $instance['size'] ) : 'large';
		$text_alignement = ( isset( $instance['text_alignement'] ) ) ? esc_attr( $instance['text_alignement'] ) : 'center';
		echo $before_widget;
		if ( ! empty( $title ) ) echo $before_title . $title . $after_title;

		if ( ! empty( $description ) ) {
			echo '<p>';
			echo $description;
			echo '</p>';
		}

		echo wvc_mailchimp( array(
			'list' => $list,
			'show_bg' => $show_bg,
			'show_label' => $show_label,
			'size' => $size,
			'text_alignement' => $text_alignement,
		) );
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
		$instance['description'] = esc_attr( $new_instance['description'] );
		$instance['list'] = esc_attr( $new_instance['list'] );
		$instance['size'] = esc_attr( $new_instance['size'] );
		$instance['show_bg'] = esc_attr( $new_instance['show_bg'] );
		$instance['show_label'] = esc_attr( $new_instance['show_label'] );
		$instance['text_alignement'] = esc_attr( $new_instance['text_alignement'] );
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
			'description' => '',
			'list' => wolf_vc_get_option( 'mailchimp', 'default_mailchimp_list_id' ),
			'size' => 'large',
			'show_bg' => 'yes',
			'show_label' => 'yes',
			'text_alignement' => 'center',
		);
		$instance = wp_parse_args( ( array ) $instance, $defaults);
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title', 'wolf-visual-composer' ); ?>:</label>
			<input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'description' ) ); ?>"><?php esc_html_e( 'Description', 'wolf-visual-composer' ); ?>:</label>
			<textarea class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'description' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'description' ) ); ?>"><?php echo esc_attr( $instance['description'] ); ?></textarea>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'list' ) ); ?>"><?php esc_html_e( 'List ID', 'wolf-visual-composer' ); ?>:</label>
			<input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id( 'list' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'list' ) ); ?>" value="<?php echo esc_attr( $instance['list'] ); ?>">
			<br>
			<small><?php esc_html_e( 'Can be found in your mailchimp account -> Lists -> Your List Name -> Settings -> List Name & default', 'wolf-visual-composer' ); ?></small>
		</p>
		<p>
			<!-- show_bg -->
			<select name="<?php echo esc_attr( $this->get_field_name( 'show_bg' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'show_bg' ) ); ?>">
				<option value="yes" <?php selected( esc_attr( $instance['show_bg'] ), 'yes' ); ?>><?php esc_html_e( 'Yes', 'wolf-visual-composer' ); ?></option>
				<option value="no" <?php selected( esc_attr( $instance['show_bg'] ), 'no' ); ?>><?php esc_html_e( 'No', 'wolf-visual-composer' ); ?></option>
			</select>
			<label for="<?php echo esc_attr( $this->get_field_id( 'show_bg' ) ); ?>"><?php esc_html_e( 'Show Background', 'wolf-visual-composer' ); ?></label>
		</p>
		<p>
			<!-- show_label -->
			<select name="<?php echo esc_attr( $this->get_field_name( 'show_label' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'show_label' ) ); ?>">
				<option value="yes" <?php selected( esc_attr( $instance['show_label'] ), 'yes' ); ?>><?php esc_html_e( 'Yes', 'wolf-visual-composer' ); ?></option>
				<option value="no" <?php selected( esc_attr( $instance['show_label'] ), 'no' ); ?>><?php esc_html_e( 'No', 'wolf-visual-composer' ); ?></option>
			</select>
			<label for="<?php echo esc_attr( $this->get_field_id( 'show_label' ) ); ?>"><?php esc_html_e( 'Show Default Label', 'wolf-visual-composer' ); ?></label>
		</p>
		<p>
			<!-- size -->
			<select name="<?php echo esc_attr( $this->get_field_name( 'size' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'size' ) ); ?>">
				<option value="normal" <?php selected( esc_attr( $instance['size'] ), 'normal' ); ?>><?php esc_html_e( 'Normal', 'wolf-visual-composer' ); ?></option>
				<option value="large" <?php selected( esc_attr( $instance['size'] ), 'large' ); ?>><?php esc_html_e( 'Large', 'wolf-visual-composer' ); ?></option>
			</select>
			<label for="<?php echo esc_attr( $this->get_field_id( 'size' ) ); ?>"><?php esc_html_e( 'Size', 'wolf-visual-composer' ); ?></label>
		</p>
		<p>
			<!-- text_alignement -->
			<select name="<?php echo esc_attr( $this->get_field_name( 'text_alignement' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'text_alignement' ) ); ?>">
				<option value="center" <?php selected( esc_attr( $instance['text_alignement'] ), 'center' ); ?>><?php esc_html_e( 'Center', 'wolf-visual-composer' ); ?></option>
				<option value="left" <?php selected( esc_attr( $instance['text_alignement'] ), 'left' ); ?>><?php esc_html_e( 'Left', 'wolf-visual-composer' ); ?></option>
				<option value="right" <?php selected( esc_attr( $instance['text_alignement'] ), 'right' ); ?>><?php esc_html_e( 'Right', 'wolf-visual-composer' ); ?></option>
			</select>
			<label for="<?php echo esc_attr( $this->get_field_id( 'text_alignement' ) ); ?>"><?php esc_html_e( 'Text alignement', 'wolf-visual-composer' ); ?></label>
		</p>
		<?php
	}
}