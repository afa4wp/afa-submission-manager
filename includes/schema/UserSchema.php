<?php
/**
 * The User Schema Class
 *
 * @package  WP_All_Forms_API
 * @since 1.0.0
 */

namespace Includes\Schema;

use Includes\Plugins\Config;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Class UserSchema
 *
 * Create schema for endpoints
 *
 * @since 1.0.0
 */
class UserSchema {

	/**
	 * Create login schema
	 *
	 * @return array
	 */
	public function login() {
		$schema = array(
			'username' => array(
				'required'          => true,
				'type'              => 'string',
				'validate_callback' => function ( $value, $request, $key ) {
					return true;
				},
			),
			'password' => array(
				'required' => true,
				'type'     => 'string',
			),
		);
		return $schema;
	}

	/**
	 * Create token schema
	 *
	 * @return array
	 */
	public function token() {
		$schema = array(
			'refresh_token' => array(
				'required'          => true,
				'type'              => 'string',
				'pattern'           => '^[A-Za-z0-9_-]{2,}(?:\.[A-Za-z0-9_-]{2,}){2}$',
				'validate_callback' => function ( $value, $request, $key ) {
					return true;
				},
			),
		);
		return $schema;
	}

	/**
	 * Create form_type schema
	 *
	 * @return array
	 */
	public function form_type() {
		$schema = array(
			'form_type' => array(
				'required'          => true,
				'type'              => 'string',
				'validate_callback' => function ( $value, $request, $key ) {
					return ( new Config() )->is_plugin_key_exists( $value );
				},
			),
		);
		return $schema;
	}
}
