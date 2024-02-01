<?php
/**
 * The UserNotification Subscription Schema Class
 *
 * @package  claud/afa-submission-manager
 * @since 1.0.0
 */

namespace  AFASM\Includes\Schema;

use ExpoSDK\Expo;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class NotificationSubscriptionSchema
 *
 * Create schema for notification subscription endpoints
 *
 * @since 1.0.0
 */
class AFASM_Notification_Subscription_Schema {

	/**
	 * Create notification subscription schema
	 *
	 * @return array
	 */
	public function subscribe_user() {
		$schema = array(
			'expo_token' => array(
				'required'          => true,
				'type'              => 'string',
				'validate_callback' => function ( $value, $request, $key ) {
					return ( new Expo() )->isExpoPushToken( $value );
				},
			),
		);
		return $schema;
	}

	/**
	 * Update subscription.
	 *
	 * @return array
	 */
	public function update_subscription_state() {
		$schema = array(
			'enabled' => array(
				'required' => true,
				'type'     => 'integer',
				'minimum'  => 0,
				'maximum'  => 1,
			),
		);
		return $schema;
	}
}
