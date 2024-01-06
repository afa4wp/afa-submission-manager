<?php
/**
 * The Config Controller Class.
 *
 * @package  AFA_SUBMISSION_MANAGER
 * @since 1.0.0
 */

namespace Includes\Controllers;

use AFASM\Includes\Plugins\AFASM_Config;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Class ConfigController
 *
 * Manipulate User info
 *
 * @since 1.0.0
 */
class ConfigController {

	/**
	 * Config Plugins
	 *
	 * @var Config
	 */
	private $config;

	/**
	 * ConfigController constructor.
	 */
	public function __construct() {
		$this->config = new AFASM_Config();
	}

	/**
	 * Get activated foms.
	 *
	 * @param WP_REST_Request $request The request.
	 *
	 * @return array Installed plugin.
	 */
	public function forms( $request ) {
		return rest_ensure_response( $this->config->installed_forms() );
	}

}
