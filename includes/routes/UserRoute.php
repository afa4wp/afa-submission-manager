<?php
/**
 * The User Route Class.
 *
 * @package  WP_All_Forms_API
 * @since 1.0.0
 */

namespace Includes\Routes;

use Includes\Controllers\UserController;
use Includes\Schema\UserSchema;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Class Route
 *
 * User routes
 *
 * @since 1.0.0
 */
class UserRoute {

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
	 * Create login endpoint.
	 */
	public function login() {
		register_rest_route(
			$this->name,
			'/user/login',
			array(
				array(
					'methods'             => 'POST',
					'callback'            => array( new UserController(), 'login' ),
					'permission_callback' => '__return_true',
					'args'                => ( new UserSchema() )->login(),
				),

			)
		);
	}

	/**
	 * Create login with qrcode.
	 */
	public function login_qr_code() {
		register_rest_route(
			$this->name,
			'/user/login/qrcode',
			array(
				array(
					'methods'             => 'POST',
					'callback'            => array( new UserController(), 'login_qr_code' ),
					'permission_callback' => '__return_true',
				),

			)
		);
	}

	/**
	 * Create user info endpoint.
	 */
	public function user_me() {
		register_rest_route(
			$this->name,
			'/user/me',
			array(
				array(
					'methods'             => 'GET',
					'callback'            => array( new UserController(), 'user' ),
					'permission_callback' => '__return_true',
				),

			)
		);
	}

	/**
	 * Create refresh token endpoint.
	 */
	public function token() {
		register_rest_route(
			$this->name,
			'/user/tokens/refresh',
			array(
				array(
					'methods'             => 'POST',
					'callback'            => array( new UserController(), 'token' ),
					'permission_callback' => '__return_true',
					'args'                => ( new UserSchema() )->token(),
				),
			)
		);
	}

	/**
	 * Call all endpoints
	 */
	public function init_routes() {
		$this->login();
		$this->login_qr_code();
		$this->user_me();
		$this->token();
	}

}
