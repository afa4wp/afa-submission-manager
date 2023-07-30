<?php
/**
 * The Notification Route Class.
 *
 * @package  WP_All_Forms_API
 * @since 1.0.0
 */

namespace Includes\Routes;

use Includes\Controllers\NotificationController;
use Includes\Plugins\Config;
use Includes\Schema\NotificationSchema;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Class Route
 *
 * User routes
 *
 * @since 1.0.0
 */
class NotificationRoute {

	/**
	 * The route name space
	 *
	 * @var string
	 */
	protected $name;

	/**
	 * NotificationRoute constructor.
	 *
	 * @param string $name The route name space.
	 */
	public function __construct( $name ) {
		$this->name = $name;
	}

	/**
	 * Fetch notifications.
	 */
	public function notifications() {
		register_rest_route(
			$this->name,
			'notification/page/(?P<page_number>[0-9]+)',
			array(
				array(
					'methods'             => 'GET',
					'callback'            => array( new NotificationController(), 'notifications' ),
					'permission_callback' => array( new Config(), 'wp_afa_check_authorization' ),
					'args'                => ( new NotificationSchema() )->get(),
				),

			)
		);
	}

	/**
	 * Call all endpoints
	 */
	public function init_routes() {
		$this->notifications();
	}

}
