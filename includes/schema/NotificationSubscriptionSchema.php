<?php
/**
 * The UserNotification Subscription Schema Class
 *
 * @package  AFA_SUBMISSION_MANAGER
 * @since 1.0.0
 */

namespace Includes\Schema;

use ExpoSDK\Expo;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Class NotificationSubscriptionSchema
 *
 * Create schema for notification subscription endpoints
 *
 * @since 1.0.0
 */
class NotificationSubscriptionSchema {

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
