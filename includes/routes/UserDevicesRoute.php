<?php
/**
 * The User Route Class.
 *
 * @package  WP_All_Forms_API
 * @since 1.0.0
 */

namespace Includes\Routes;

use Includes\Controllers\UserDevicesController;
use Includes\Schema\UserDevicesSchema;


// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Class Route
 *
 * User routes
 *
 * @since 1.0.0
 */
class UserDevicesRoute {

	/**
	 * The route name space
	 *
	 * @var string
	 */
	protected $name;

	/**
	 * User constructor.
	 *
	 * @param string $name The route name space.
	 */
	public function __construct( $name ) {
		$this->name = $name;
	}

	/**
	 * Create new device register endpoint.
	 */
	public function create() {
		register_rest_route(
			$this->name,
			'/user/device',
			array(
				array(
					'methods'             => 'POST',
					'callback'            => array( new UserDevicesController(), 'create' ),
					'permission_callback' => '__return_true',
					'args'                => ( new UserDevicesSchema() )->create(),
				),

			)
		);
	}

	/**
	 * Call all endpoints
	 */
	public function init_routes() {
		$this->create();
	}

}
