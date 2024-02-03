<?php
/**
 * The Notification Subscription Route Class.
 *
 * @package  claud/afa-submission-manager
 * @since 1.0.0
 */

namespace AFASM\Includes\Routes;

use AFASM\Includes\Controllers\AFASM_Notification_Subscription_Controller;
use AFASM\Includes\Schema\AFASM_Notification_Subscription_Schema;
use AFASM\Includes\Plugins\AFASM_Config;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class Route
 *
 * User routes
 *
 * @since 1.0.0
 */
class AFASM_Notification_Subscription_Route {

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
					'callback'            => array( new AFASM_Notification_Subscription_Controller(), 'subscribe_user' ),
					'permission_callback' => array( new AFASM_Config(), 'afa_check_authorization' ),
					'args'                => ( new AFASM_Notification_Subscription_Schema() )->subscribe_user(),
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
					'callback'            => array( new AFASM_Notification_Subscription_Controller(), 'fetch_subscriptions' ),
					'permission_callback' => array( new AFASM_Config(), 'afa_check_authorization' ),
					'args'                => ( new AFASM_Notification_Subscription_Schema() )->subscribe_user(),
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
					'callback'            => array( new AFASM_Notification_Subscription_Controller(), 'unsubscribe' ),
					'permission_callback' => array( new AFASM_Config(), 'afa_check_authorization' ),
					'args'                => ( new AFASM_Notification_Subscription_Schema() )->subscribe_user(),
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
					'callback'            => array( new AFASM_Notification_Subscription_Controller(), 'update_subscription_state' ),
					'permission_callback' => array( new AFASM_Config(), 'afa_check_authorization' ),
					'args'                => ( new AFASM_Notification_Subscription_Schema() )->update_subscription_state(),
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
