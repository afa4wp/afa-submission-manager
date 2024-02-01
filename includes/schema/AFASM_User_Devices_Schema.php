<?php
/**
 * The User Device Schema Class
 *
 * @package  claud/afa-submission-manager
 * @since 1.0.0
 */

namespace AFASM\Includes\Schema;

use ExpoSDK\Expo;
use AFASM\Includes\Plugins\AFASM_Language;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class UserDevicesSchema
 *
 * Create schema for user device endpoints
 *
 * @since 1.0.0
 */
class AFASM_User_Devices_Schema {

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
					return ( new AFASM_Language() )->is_supported_language( $value );
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
					return ( new AFASM_Language() )->is_supported_language( $value );
				},
			),
		);
		return $scheme;
	}
}
