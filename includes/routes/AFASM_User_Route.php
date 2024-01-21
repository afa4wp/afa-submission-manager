<?php
/**
 * The User Route Class.
 *
 * @package  claud/afa-submission-manager
 * @since 1.0.0
 */

namespace AFASM\Includes\Routes;

use Includes\Controllers\UserController;
use Includes\Schema\UserSchema;
use AFASM\Includes\Plugins\AFASM_Config;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class Route
 *
 * User routes
 *
 * @since 1.0.0
 */
class AFASM_User_Route {

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
					'args'                => ( new UserSchema() )->login_qr_code(),
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
					'permission_callback' => array( new AFASM_Config(), 'afa_check_authorization' ),
				),

			)
		);
	}

	/**
	 * Create user form type content endpoint.
	 */
	public function user_form_type_me() {
		register_rest_route(
			$this->name,
			'/user/(?P<form_type>\S+)/me',
			array(
				array(
					'methods'             => 'GET',
					'callback'            => array( new UserController(), 'user_form_type_me' ),
					'permission_callback' => array( new AFASM_Config(), 'afa_check_authorization' ),
					'args'                => ( new UserSchema() )->form_type(),
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
	 * Logout user.
	 */
	public function logout() {
		register_rest_route(
			$this->name,
			'/user/logout',
			array(
				array(
					'methods'             => 'POST',
					'callback'            => array( new UserController(), 'logout' ),
					'permission_callback' => array( new AFASM_Config(), 'afa_check_authorization' ),
					'args'                => ( new UserSchema() )->logout(),
				),
			)
		);
	}

	/**
	 * Create user form type home endpoint.
	 */
	public function user_form_type_home() {
		register_rest_route(
			$this->name,
			'/user/(?P<form_type>\S+)/home',
			array(
				array(
					'methods'             => 'GET',
					'callback'            => array( new UserController(), 'user_form_type_home' ),
					'permission_callback' => array( new AFASM_Config(), 'afa_check_authorization' ),
					'args'                => ( new UserSchema() )->form_type(),
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
		$this->user_form_type_me();
		$this->token();
		$this->logout();
		$this->user_form_type_home();
	}

}
