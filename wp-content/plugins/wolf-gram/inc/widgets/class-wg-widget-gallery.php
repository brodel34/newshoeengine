<?php
/**
 * Instagram Widget
 *
 * Displays Instagram widget
 *
 * @author WolfThemes
 * @category Widgets
 * @package WolfGram
 * @version 1.5.8
 * @extends WP_Widget
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class WG_Widget_Instagram_Gallery extends WP_Widget {

	var $wh_widget_cssclass;
	var $wh_widget_description;
	var $wh_widget_idbase;
	var $wh_widget_name;

	/**
	 * Constructor
	 */
	public function __construct() {

		/* Widget variable settings. */
		$this->wh_widget_cssclass 	= 'wolfgram-widget';
		$this->wh_widget_description = esc_html__( 'Display your last instagram shots', 'wolf-gram' );
		$this->wh_widget_idbase	= 'wolfgram-widget';
		$this->wh_widget_name 	= esc_html__( 'Instagram', 'wolf-gram' );

		/* Widget settings. */
		$widget_ops = array( 'classname' => $this->wh_widget_cssclass, 'description' => $this->wh_widget_description );

		/* Create the widget. */
		parent::__construct( 'wolfgram-widget', $this->wh_widget_name, $widget_ops );
	}

	/**
	 * widget function.
	 *
	 * @see WP_Widget
	 * @access public
	 * @param array $args
	 * @param array $instance
	 * @return void
	 */
	function widget( $args, $instance ) {

		extract( $args );


		$title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : esc_html__( 'Instagram', 'wolf-gram' );
		$title = apply_filters( 'widget_title', $title );
		$desc = isset( $instance['desc'] ) ? wp_kses( $instance['desc'], array( 'a' => array( 'href' => array(), 'target' => array() ) ) ) : '';
		$layout = isset( $instance['layout'] ) ? esc_attr( $instance['layout'] ) : '';
		$timeout = isset( $instance['timeout'] ) ? absint( $instance['timeout'] ) : 3000;
		$count = isset( $instance['count'] ) ? absint( $instance['count'] ) : 12;

		$slideshow = false;
		
		if ( $layout == '1' ) {
			$slideshow = true;
		}

		echo $before_widget;
		if ( ! empty( $title ) ) echo $before_title . $title . $after_title;
		if ( ! empty( $desc ) ) {
			echo '<p>';
			echo $desc;
			echo '</p>';
		}
		echo wolf_gram_widget_gallery( array( 'count' => $count, 'slideshow' => $slideshow, 'timeout' => $timeout ) );
		echo $after_widget;

	}

	/**
	 * update function.
	 *
	 * @see WP_Widget->update
	 * @access public
	 * @param array $new_instance
	 * @param array $old_instance
	 * @return array
	 */
	function update( $new_instance, $old_instance ) {

		$instance = $old_instance;

		$instance['title'] = esc_attr( $new_instance['title'] );
		$instance['desc'] = wp_kses( $new_instance['desc'], array( 'a' => array( 'href' => array(), 'target' => array() ) ) );
		$instance['count'] = absint( $new_instance['count'] );
		$instance['layout'] = esc_attr( $new_instance['layout'] );
		$instance['timeout'] = absint( $new_instance['timeout'] );

		if( $instance['timeout'] == 0 || $instance['timeout'] == '' ) $instance['timeout'] = 3500;

		if( $instance['count'] == 0 || $instance['count'] == '' ) $instance['count'] = 12;
		return $instance;
	}


	/**
	 * form function.
	 *
	 * @see WP_Widget->form
	 * @access public
	 * @param array $instance
	 * @return void
	 */
	function form( $instance ) {
			// Set up some default widget settings
			$defaults = array( 'title' => esc_html__( 'Instagrams', 'wolf-gram' ), 'desc' => '', 'count' => 12, 'layout' => '0', 'timeout' => '3500' );
			$instance = wp_parse_args( (array) $instance, $defaults );

		?>
		<script type="text/javascript">
			jQuery( function( $ ) {
				$( document ).on( 'change', '.wolf-instagram-layout-select', function() {

					var val = $( this ).val();

					if ( val == '1' ) {
						$( this ).parent().next().show();
					} else {
						$( this ).parent().next().hide();
					}
				} );
			} );
		</script>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title', 'wolf-gram' ); ?>:</label>
			<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'desc' ); ?>"><?php esc_html_e( 'Optional Text', 'wolf-gram' ); ?>:</label>
			<textarea class="widefat"  id="<?php echo $this->get_field_id( 'desc' ); ?>" name="<?php echo $this->get_field_name( 'desc' ); ?>" ><?php echo $instance['desc']; ?></textarea>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'count' ); ?>"><?php esc_html_e( 'Count', 'wolf-gram' ); ?>:</label>
			<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" value="<?php echo $instance['count']; ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'layout' ); ?>"><?php esc_html_e( 'Display', 'wolf-gram' ); ?>:</label>
			<select class="wolf-instagram-layout-select"  name="<?php echo $this->get_field_name( 'layout' ); ?>" id="<?php echo $this->get_field_id( 'layout' ); ?>">
				<option value="0" <?php if( $instance['layout'] == '0' ) echo 'selected="selected"'; ?>><?php esc_html_e( 'thumbnails', 'wolf-gram' ); ?></option>
				<option value="1" <?php if( $instance['layout'] == '1' ) echo 'selected="selected"'; ?>><?php esc_html_e( 'slideshow', 'wolf-gram' ); ?></option>
			</select>
		</p>
		<p <?php if( $instance['layout'] == '0' )  echo 'style="display:none"';  ?>>
			<label for="<?php echo $this->get_field_id( 'timeout' ); ?>"><?php esc_html_e( 'Time between animation in milliseconds', 'wolf-gram' ); ?>:</label>
			<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'timeout' ); ?>" name="<?php echo $this->get_field_name( 'timeout' ); ?>" value="<?php echo $instance['timeout']; ?>">
		</p>
		<?php
	}

}