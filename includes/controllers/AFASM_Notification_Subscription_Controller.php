<?php
/**
 * The Notification Subscription Controller Class.
 *
 * @package  claud/afa-submission-manager
 * @since 1.0.0
 */

namespace AFASM\Includes\Controllers;

use AFASM\Includes\Models\AFASM_Notification_Subscription_Model;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class NotificationSubscriptionController
 *
 * Hendler with notification_subscription
 *
 * @since 1.0.0
 */
class AFASM_Notification_Subscription_Controller {
	/**
	 * User Notification Subscription Model
	 *
	 * @var AFASM_Notification_Subscription_Model
	 */
	private $notification_subscription_model;

	/**
	 * NotificationSubscriptionController constructor.
	 */
	public function __construct() {
		$this->notification_subscription_model = new AFASM_Notification_Subscription_Model();
	}


	/**
	 *  Subscribe user to all notification.
	 *
	 * @param WP_REST_Request $request The request.
	 *
	 * @return int|false
	 */
	public function subscribe_user( $request ) {

		$expo_token = sanitize_text_field( $request['expo_token'] );

		$result = $this->notification_subscription_model->subscribe_user_all_notificions_by_expo_token( $expo_token );
		return rest_ensure_response( $result );

	}

	/**
	 * Fetch user notification subscriptions.
	 *
	 * @param WP_REST_Request $request The request.
	 *
	 * @return array
	 */
	public function fetch_subscriptions( $request ) {

		$expo_token = sanitize_text_field( $request['expo_token'] );

		$result = $this->notification_subscription_model->fetch_subscriptions_by_expo_token( $expo_token );
		return rest_ensure_response( $result );
	}

	/**
	 * Unsubscribe to all notification.
	 *
	 * @param WP_REST_Request $request The request.
	 *
	 * @return array
	 */
	public function unsubscribe( $request ) {

		$expo_token = sanitize_text_field( $request['expo_token'] );

		$result = $this->notification_subscription_model->unsubscribe( $expo_token );
		return rest_ensure_response( $result );
	}

	/**
	 * Update subscription.
	 *
	 * @param WP_REST_Request $request The request.
	 *
	 * @return boolean
	 */
	public function update_subscription_state( $request ) {

		$notification_subscription_id = absint( $request['notification_subscription_id'] );
		$enabled                      = absint( $request['enabled'] );

		$result = $this->notification_subscription_model->update_subscription_state( $notification_subscription_id, $enabled );
		return rest_ensure_response( $result );
	}

}
