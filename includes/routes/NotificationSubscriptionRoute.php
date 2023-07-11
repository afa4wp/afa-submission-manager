<?php
/**
 * The Notification Subscription Route Class.
 *
 * @package  WP_All_Forms_API
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
	}

}
