<?php
/**
 * Wolf Gram Shortcode.
 *
 * @class WG_Shortcode
 * @author WolfThemes
 * @category Core
 * @package WolfGram/Shortcode
 * @version 1.5.8
 * @since 1.4.8
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * WG_Shortcode class.
 */
class WG_Shortcode {
	/**
	 * Constructor
	 */
	public function __construct() {

		add_shortcode( 'wolfgram_gallery', array( $this, 'shortcode' ) ); // old shortcode
		add_shortcode( 'wolf_instagram_gallery', array( $this, 'shortcode' ) );
	}

	/**
	 * Shortcode
	 *
	 * @param array $atts
	 * @return string
	 */
	public function shortcode( $atts = array() ) {

		$atts = shortcode_atts(
			array(
				'count' => wolf_gram_get_option( 'count', 18 ),
				'columns' => wolf_gram_get_option( 'columns', 6 ),
				'username' => wolf_gram_get_user_id(),
				'api_key' => get_option( 'wolf_instagram_access_token' ),
				'button' => false,
				'button_text' => '',
				'tag' => '',
			),
			$atts
		);

		$atts['button'] = $this->shortcode_bool( $atts['button'] );

		return wolf_gram_gallery( $atts );
	}

	/**
	 * Helper method to determine if a shortcode attribute is true or false.
	 *
	 * @since 1.0.2
	 *
	 * @param string|int|bool $var Attribute value.
	 * @return bool
	 */
	protected function shortcode_bool( $var ) {
		$falsey = array( 'false', '0', 'no', 'n' );
		return ( ! $var || in_array( strtolower( $var ), $falsey, true ) ) ? false : true;
	}

} // end class

return new WG_Shortcode();