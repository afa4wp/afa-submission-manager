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
					'permission_callback' => array( new Config(), 'wp_afa_check_authorization' ),
					'args'                => ( new UserDevicesSchema() )->create(),
				),
			)
		);
	}

	/**
	 * Update device language.
	 */
	public function language() {
		register_rest_route(
			$this->name,
			'/user/device/language',
			array(
				array(
					'methods'             => 'PUT',
					'callback'            => array( new UserDevicesController(), 'language' ),
					'permission_callback' => array( new Config(), 'wp_afa_check_authorization' ),
					'args'                => ( new UserDevicesSchema() )->language(),
				),
			)
		);
	}

	/**
	 * Call all endpoints
	 */
	public function init_routes() {
		$this->create();
		$this->language();
	}

}
