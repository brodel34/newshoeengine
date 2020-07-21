<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'MailChimp' ) ) {
	/**
	 * Super-simple, minimum abstraction MailChimp API v2 wrapper
	 *
	 * Requires curl (I know, right?)
	 * This probably has more comments than code.
	 *
	 * @author Drew McLellan <drew.mclellan@gmail.com>
	 * @author WolfThemes - slightly modify for WordPress
	 * @version 1.0.1
	 */
	class MailChimp {
		private $api_key;
		private $api_endpoint = 'https://<dc>.api.mailchimp.com/2.0/';
		private $verify_ssl   = false;

		/**
		 * Create a new instance
		 * @param string $api_key Your MailChimp API key
		 */
		function __construct( $api_key )
		{
			$this->api_key = $api_key;

			if ( strpos( $this->api_key, '-' ) === false ) {
				return;
			}

			list(, $datacentre) = explode('-', $this->api_key);
			$this->api_endpoint = str_replace('<dc>', $datacentre, $this->api_endpoint);
		}

		/**
		 * Call an API method. Every request needs the API key, so that is added automatically -- you don't need to pass it in.
		 * @param  string $method The API method to call, e.g. 'lists/list'
		 * @param  array  $args   An array of arguments to pass to the method. Will be json-encoded for you.
		 * @return array          Associative array of json decoded API response.
		 */
		public function call($method, $args=array())
		{
			return $this->_raw_request($method, $args);
		}

		/**
		 * Performs the underlying HTTP request. Not very exciting
		 * replaced curl by wp_remote_post for WP
		 * @param  string $method The API method to be called
		 * @param  array  $args   Assoc array of parameters to be passed
		 * @return array          Assoc array of decoded result
		 */
		private function _raw_request($method, $args=array())
		{
			$args['apikey'] = $this->api_key;

			$result = null;
			$url = $this->api_endpoint.'/'.$method.'.json';
			$response = wp_remote_post( $url , array(
					'timeout' => 5,
					'body' => $args,
				)
			);

			if ( ! is_wp_error( $response ) && is_array( $response ) ) {
				$result = wp_remote_retrieve_body( $response ); // use the content
			}

			return $result ? json_decode( $result, true ) : false;
		}
	}
} // end class check