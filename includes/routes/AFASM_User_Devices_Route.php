<?php
/**
 * The User Route Class.
 *
 * @package  claud/afa-submission-manager
 * @since 1.0.0
 */

namespace AFASM\Includes\Routes;

use Includes\Controllers\UserDevicesController;
use AFASM\Includes\Schema\AFASM_User_Devices_Schema;
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
class AFASM_User_Devices_Route {

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
					'permission_callback' => array( new AFASM_Config(), 'afa_check_authorization' ),
					'args'                => ( new AFASM_User_Devices_Schema() )->create(),
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
					'permission_callback' => array( new AFASM_Config(), 'afa_check_authorization' ),
					'args'                => ( new AFASM_User_Devices_Schema() )->language(),
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
