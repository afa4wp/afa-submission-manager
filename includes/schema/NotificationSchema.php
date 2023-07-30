<?php
/**
 * The Notification Schema Class
 *
 * @package  WP_All_Forms_API
 * @since 1.0.0
 */

namespace Includes\Schema;

use Includes\Database\SupportedPlugins;
use Includes\Plugins\Language;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Class NotificationSchema
 *
 * Create schema for notification endpoints
 *
 * @since 1.0.0
 */
class NotificationSchema {

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
					return ( new Language() )->is_supported_language( $value );
				},
			),
			'supported_plugin' => array(
				'required'          => true,
				'type'              => 'string',
				'validate_callback' => function ( $value, $request, $key ) {
					return ( new SupportedPlugins() )->is_default_slug_exist( $value );
				},
			),
		);
		return $schema;
	}

}
