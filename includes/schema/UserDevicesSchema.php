<?php
/**
 * The User Device Schema Class
 *
 * @package  AFA_SUBMISSION_MANAGER
 * @since 1.0.0
 */

namespace Includes\Schema;

use ExpoSDK\Expo;
use Includes\Plugins\Language;

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
					return ( new Language() )->is_supported_language( $value );
				},
			),
		);
		return $schema;
	}

	/**
	 * Create language device schema
	 *
	 * @return array
	 */
	public function language() {
		$scheme = array(
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
					return ( new Language() )->is_supported_language( $value );
				},
			),
		);
		return $scheme;
	}
}
