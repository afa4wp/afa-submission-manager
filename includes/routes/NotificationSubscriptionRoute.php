<?php
/**
 * The Notification Subscription Route Class.
 *
 * @package  AFA_SUBMISSION_MANAGER
 * @since 1.0.0
 */

namespace Includes\Routes;

use Includes\Controllers\NotificationSubscriptionController;
use Includes\Schema\NotificationSubscriptionSchema;
use Includes\Plugins\Config;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Class Route
 *
 * User routes
 *
 * @since 1.0.0
 */
class NotificationSubscriptionRoute {

	/**
	 * The route name space
	 *
	 * @var string
	 */
	protected $name;

	/**
	 * NotificationSubscriptionRoute constructor.
	 *
	 * @param string $name The route name space.
	 */
	public function __construct( $name ) {
		$this->name = $name;
	}

	/**
	 * Subscribe user for notification.
	 */
	public function subscribe_user() {
		register_rest_route(
			$this->name,
			'/notification/subscription',
			array(
				array(
					'methods'             => 'POST',
					'callback'            => array( new NotificationSubscriptionController(), 'subscribe_user' ),
					'permission_callback' => array( new Config(), 'wp_afa_check_authorization' ),
					'args'                => ( new NotificationSubscriptionSchema() )->subscribe_user(),
				),

			)
		);
	}

	/**
	 * Fetch notification subscription.
	 */
	public function fetch_subscriptions() {
		register_rest_route(
			$this->name,
			'/notification/subscription',
			array(
				array(
					'methods'             => 'GET',
					'callback'            => array( new NotificationSubscriptionController(), 'fetch_subscriptions' ),
					'permission_callback' => array( new Config(), 'wp_afa_check_authorization' ),
					'args'                => ( new NotificationSubscriptionSchema() )->subscribe_user(),
				),

			)
		);
	}

	/**
	 * Unsubscribe to all notification.
	 */
	public function unsubscribe() {
		register_rest_route(
			$this->name,
			'/notification/subscription',
			array(
				array(
					'methods'             => 'DELETE',
					'callback'            => array( new NotificationSubscriptionController(), 'unsubscribe' ),
					'permission_callback' => array( new Config(), 'wp_afa_check_authorization' ),
					'args'                => ( new NotificationSubscriptionSchema() )->subscribe_user(),
				),

			)
		);
	}

	/**
	 * Update subscription.
	 */
	public function update_subscription_state() {
		register_rest_route(
			$this->name,
			'/notification/subscription/(?P<notification_subscription_id>[0-9]+)/enabled',
			array(
				array(
					'methods'             => 'PUT',
					'callback'            => array( new NotificationSubscriptionController(), 'update_subscription_state' ),
					'permission_callback' => array( new Config(), 'wp_afa_check_authorization' ),
					'args'                => ( new NotificationSubscriptionSchema() )->update_subscription_state(),
				),

			)
		);
	}

	/**
	 * Call all endpoints
	 */
	public function init_routes() {
		$this->subscribe_user();
		$this->fetch_subscriptions();
		$this->unsubscribe();
		$this->update_subscription_state();
	}

}
