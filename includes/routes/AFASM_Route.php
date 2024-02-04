<?php
/**
 * The Main Route Class.
 *
 * @package  claud/afa-submission-manager
 * @since 1.0.0
 */

namespace AFASM\Includes\Routes;

use AFASM\Includes\Routes\AFASM_Ping_Route;
use AFASM\Includes\Routes\AFASM_User_Route;
use AFASM\Includes\Routes\AFASM_Config_Route;
use AFASM\Includes\Routes\AFASM_User_Devices_Route;
use AFASM\Includes\Routes\AFASM_Notification_Subscription_Route;
use AFASM\Includes\Routes\AFASM_Notification_Route;
use AFASM\Includes\Routes\GF\AFASM_Route as AFASM_GF_Route;
use AFASM\Includes\Routes\WPF\AFASM_Route as AFASM_WPF_Route;
use AFASM\Includes\Routes\WEF\AFASM_Route as AFASM_WEF_Route;
use AFASM\Includes\Routes\CF7\AFASM_Route as AFASM_CF7_Route;
use AFASM\Includes\Routes\EFB\AFASM_Route as AFASM_EFB_Route;
use AFASM\Includes\Plugins\AFASM_Constant;
use AFASM\Includes\Plugins\AFASM_Config;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class Route
 *
 * Init all routes
 *
 * @since 1.0.0
 */
class AFASM_Route {

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
	 * Init all routes.
	 */
	public function init() {
		( new AFASM_Ping_Route( $this->name ) )->init_routes();
		( new AFASM_User_Route( $this->name ) )->init_routes();
		( new AFASM_Config_Route( $this->name ) )->init_routes();
		( new AFASM_User_Devices_Route( $this->name ) )->init_routes();
		( new AFASM_Notification_Subscription_Route( $this->name ) )->init_routes();
		( new AFASM_Notification_Route( $this->name ) )->init_routes();

		// Forms routes.
		$this->init_all_forms_routes();

	}

	/**
	 * Get form route
	 *
	 * @since 1.0.0
	 *
	 * @param string $key The key of form type.
	 *
	 * @return object|null
	 */
	public function get_form_route( $key ) {
		$forms = array(
			AFASM_Constant::FORM_SLUG_CF7 => new AFASM_CF7_Route( $this->name ),
			AFASM_Constant::FORM_SLUG_GF  => new AFASM_GF_Route( $this->name ),
			AFASM_Constant::FORM_SLUG_WEF => new AFASM_WEF_Route( $this->name ),
			AFASM_Constant::FORM_SLUG_WPF => new AFASM_WPF_Route( $this->name ),
			AFASM_Constant::FORM_SLUG_EFB => new AFASM_EFB_Route( $this->name ),
		);

		if ( array_key_exists( $key, $forms ) ) {
			return $forms[ $key ];
		}

		return null;
	}

	/**
	 * Init forms routes
	 *
	 * @since 1.0.0
	 */
	public function init_all_forms_routes() {
		$forms = ( new AFASM_Config() )->installed_forms();

		foreach ( $forms as $key => $value ) {
			$form_route = $this->get_form_route( $key );

			if ( ! empty( $form_route ) ) {
				$form_route->init_routes();
			}
		}
	}

}
