<?php
/**
 * The PingRoute Class.
 *
 * @package  claud/afa-submission-manager
 * @since 1.0.0
 */

namespace AFASM\Includes\Routes;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class PingRoute
 *
 * Show if plugin is active
 *
 * @since 1.0.0
 */
class AFASM_Ping_Route {

	/**
	 * The route name space
	 *
	 * @var string
	 */
	private $name;

	/**
	 * Route constructor.
	 *
	 * @param string $name The route name space.
	 */
	public function __construct( $name ) {
		$this->name = $name;
	}

	/**
	 * Create ping endpoint.
	 */
	public function ping() {
		register_rest_route(
			$this->name,
			'/ping',
			array(
				array(
					'methods'             => 'GET',
					'callback'            => array( $this, 'ping_callback' ),
					'permission_callback' => '__return_true',
				),
			)
		);

	}

	/**
	 * Create ping callback.
	 */
	public function ping_callback() {
		return rest_ensure_response(
			array(
				'ping' => 'pong',
			)
		);
	}

	/**
	 * Call all endpoints
	 */
	public function init_routes() {
		$this->ping();
	}

}
