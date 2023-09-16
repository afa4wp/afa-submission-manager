<?php
/**
 * The PingRoute Class.
 *
 * @package  WP_All_Forms_API
 * @since 1.0.0
 */

namespace Includes\Routes;

use Includes\Models\EFB\EntryModel;
/**
 * Class PingRoute
 *
 * Show if plugin is active
 *
 * @since 1.0.0
 */
class PingRoute {

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
		$entry_model = new EntryModel();
		return rest_ensure_response(
			array(
				'ping' => $entry_model->last_entry_id(),
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
