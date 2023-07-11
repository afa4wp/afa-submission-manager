<?php
/**
 * The Notification Subscription Controller Class.
 *
 * @package  WP_All_Forms_API
 * @since 1.0.0
 */

namespace Includes\Controllers;

use Includes\Models\NotificationSubscriptionModel;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Class NotificationSubscriptionController
 *
 * Hendler with notification_subscription
 *
 * @since 1.0.0
 */
class NotificationSubscriptionController {
	/**
	 * User Notification Subscription Model
	 *
	 * @var NotificationSubscriptionModel
	 */
	private $notification_subscription_model;

	/**
	 * NotificationSubscriptionController constructor.
	 */
	public function __construct() {
		$this->notification_subscription_model = new NotificationSubscriptionModel();
	}


	/**
	 *  Subscribe user to all notification.
	 *
	 * @param WP_REST_Request $request The request.
	 *
	 * @return int|false
	 */
	public function subscribe_user( $request ) {

		$expo_token = $request['expo_token'];

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

		$expo_token = $request['expo_token'];

		$result = $this->notification_subscription_model->fetch_subscriptions_by_expo_token( $expo_token );
		return rest_ensure_response( $result );
	}

}
