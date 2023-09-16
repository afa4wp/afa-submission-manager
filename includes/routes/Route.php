<?php
/**
 * The Main Route Class.
 *
 * @package  WP_All_Forms_API
 * @since 1.0.0
 */

namespace Includes\Routes;

use Includes\Routes\PingRoute;
use Includes\Routes\UserRoute;
use Includes\Routes\ConfigRoute;
use Includes\Routes\UserDevicesRoute;
use Includes\Routes\NotificationSubscriptionRoute;
use Includes\Routes\NotificationRoute;
use Includes\Routes\GF\Route as GFRoute;
use Includes\Routes\WPF\Route as WPFRoute;
use Includes\Routes\WEF\Route as WEFRoute;
use Includes\Routes\CF7\Route as CF7Route;
use Includes\Routes\EFB\Route as EFBRoute;
use Includes\Plugins\Constant;
use Includes\Plugins\Config;
use phpDocumentor\Reflection\Types\This;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Class Route
 *
 * Init all routes
 *
 * @since 1.0.0
 */
class Route {

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
		( new PingRoute( $this->name ) )->init_routes();
		( new UserRoute( $this->name ) )->init_routes();
		( new ConfigRoute( $this->name ) )->init_routes();
		( new UserDevicesRoute( $this->name ) )->init_routes();
		( new NotificationSubscriptionRoute( $this->name ) )->init_routes();
		( new NotificationRoute( $this->name ) )->init_routes();

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
			Constant::FORM_SLUG_CF7 => new CF7Route( $this->name ),
			Constant::FORM_SLUG_GF  => new GFRoute( $this->name ),
			Constant::FORM_SLUG_WEF => new WEFRoute( $this->name ),
			Constant::FORM_SLUG_WPF => new WPFRoute( $this->name ),
			Constant::FORM_SLUG_EFB => new EFBRoute( $this->name ),
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
		$forms = ( new Config() )->installed_forms();

		foreach ( $forms as $key => $value ) {
			$form_route = $this->get_form_route( $key );

			if ( ! empty( $form_route ) ) {
				$form_route->init_routes();
			}
		}
	}

}
