<?php
/**
 * The User Device Schema Class
 *
 * @package  WP_All_Forms_API
 * @since 1.0.0
 */

namespace Includes\Schema;

use ExpoSDK\Expo;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Class UserDevicesSchema
 *
 * Create schema for user device endpoints
 *
 * @since 1.0.0
 */
class UserDevicesSchema {

	/**
	 * Create new device register schema
	 *
	 * @return array
	 */
	public function create() {
		$schema = array(
			'expo_token'      => array(
				'required'          => true,
				'type'              => 'string',
				'validate_callback' => function ( $value, $request, $key ) {
					return ( new Expo() )->isExpoPushToken( $value );
				},
			),
			'device_id'       => array(
				'required'          => true,
				'type'              => 'string',
				'validate_callback' => function ( $value, $request, $key ) {
					return true;
				},
			),
			'device_language' => array(
				'required'          => true,
				'type'              => 'string',
				'validate_callback' => function ( $value, $request, $key ) {
					return ctype_alpha( $value ) && strlen( $value ) === 2;
				},
			),
		);
		return $schema;
	}
}
