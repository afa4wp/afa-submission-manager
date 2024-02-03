<?php
/**
 * The Config Controller Class.
 *
 * @package  claud/afa-submission-manager
 * @since 1.0.0
 */

namespace AFASM\Includes\Controllers;

use AFASM\Includes\Plugins\AFASM_Config;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class ConfigController
 *
 * Manipulate User info
 *
 * @since 1.0.0
 */
class AFASM_Config_Controller {

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
