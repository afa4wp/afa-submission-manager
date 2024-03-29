<?php
/**
 * The Config Route Class.
 *
 * @package  AFA_SUBMISSION_MANAGER
 * @since 1.0.0
 */

namespace Includes\Routes;

use Includes\Controllers\ConfigController;
use Includes\Plugins\Config;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Class ConfigRoute
 *
 * Init all config routes
 *
 * @since 1.0.0
 */
class ConfigRoute {

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
					'permission_callback' => array( new Config(), 'afa_check_authorization' ),
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
