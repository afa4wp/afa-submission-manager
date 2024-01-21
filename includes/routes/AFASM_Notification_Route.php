<?php
/**
 * The Notification Route Class.
 *
 * @package  claud/afa-submission-manager
 * @since 1.0.0
 */

namespace AFASM\Includes\Routes;

use Includes\Controllers\NotificationController;
use AFASM\Includes\Plugins\AFASM_Config;
use Includes\Schema\NotificationSchema;

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
class AFASM_Notification_Route {

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
					'permission_callback' => array( new AFASM_Config(), 'afa_check_authorization' ),
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
