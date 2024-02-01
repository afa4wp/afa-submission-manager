<?php
/**
 * The Notification Schema Class
 *
 * @package  claud/afa-submission-manager
 * @since 1.0.0
 */

namespace AFASM\Includes\Schema;

use AFASM\Includes\Database\AFASM_Supported_Plugins;
use AFASM\Includes\Plugins\AFASM_Language;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class NotificationSchema
 *
 * Create schema for notification endpoints
 *
 * @since 1.0.0
 */
class AFASM_Notification_Schema {

	/**
	 * Create notification  schema
	 *
	 * @return array
	 */
	public function get() {
		$schema = array(
			'device_language'  => array(
				'required'          => true,
				'type'              => 'string',
				'validate_callback' => function ( $value, $request, $key ) {
					return ( new AFASM_Language() )->is_supported_language( $value );
				},
			),
			'supported_plugin' => array(
				'required'          => true,
				'type'              => 'string',
				'validate_callback' => function ( $value, $request, $key ) {
					return ( new AFASM_Supported_Plugins() )->is_default_slug_exist( $value );
				},
			),
		);
		return $schema;
	}

}
