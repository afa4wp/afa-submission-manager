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
		( new GFRoute( $this->name ) )->init_routes();
		( new WPFRoute( $this->name ) )->init_routes();
		( new WEFRoute( $this->name ) )->init_routes();
		( new CF7Route( $this->name ) )->init_routes();

	}


}
