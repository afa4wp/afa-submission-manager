<?php
/**
 * The Config Route Class.
 *
 * @package  claud/afa-submission-manager
 * @since 1.0.0
 */

namespace AFASM\Includes\Routes;

use Includes\Controllers\ConfigController;
use AFASM\Includes\Plugins\AFASM_Config;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class ConfigRoute
 *
 * Init all config routes
 *
 * @since 1.0.0
 */
class AFASM_Config_Route {

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
	 * Create forms endpoint.
	 */
	public function forms() {
		register_rest_route(
			$this->name,
			'/config/forms',
			array(
				array(
					'methods'             => 'GET',
					'callback'            => array( new ConfigController(), 'forms' ),
					'permission_callback' => array( new AFASM_Config(), 'afa_check_authorization' ),
				),

			)
		);
	}

	/**
	 * Call all endpoints
	 */
	public function init_routes() {
		$this->forms();
	}

}
