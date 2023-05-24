<?php
/**
 * The User Controller Class.
 *
 * @package  WP_All_Forms_API
 * @since 1.0.0
 */

namespace Includes\Controllers;

use Includes\Models\UserModel;
use Includes\Models\UserTokensModel;
use Includes\Plugins\JWT\JWTPlugin;
use Includes\Models\UserQRCodeModel;
use WP_Error;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Class UserController
 *
 * Manipulate User info
 *
 * @since 1.0.0
 */
class UserController {

	/**
	 * User Model
	 *
	 * @var UserModel
	 */
	private $user_model;

	/**
	 * JWT Plugin
	 *
	 * @var JWTPlugin
	 */
	private $jwt_plugin;

	/**
	 * User Tokens Model
	 *
	 * @var UserTokensModel
	 */
	private $user_tokens_model;

	/**
	 * UserController constructor.
	 */
	public function __construct() {
		$this->user_model        = new UserModel();
		$this->jwt_plugin        = new JWTPlugin();
		$this->user_tokens_model = new UserTokensModel();
	}

	/**
	 * Login user.
	 *
	 * @param WP_REST_Request $request The request.
	 *
	 * @return WP_User|WP_Error $user WP User with tokens info
	 */
	public function login( $request ) {
		$username = $request['username'];
		$password = $request['password'];

		$user = $this->user_model->login( $username, $password );

		if ( is_wp_error( $user ) ) {
			return rest_ensure_response( $user );
		}

		$this->user_tokens_model->delete_user_token_by_id( $user->data->ID );

		$access_token         = $this->jwt_plugin->generate_token( $user->data->ID );
		$access_refresh_token = $this->jwt_plugin->generate_refresh_token( $user->data->ID );

		$this->user_tokens_model->create( $user->data->ID, $access_token, $access_refresh_token );

		$data = array(
			'access_token'      => $access_token,
			'refresh_token'     => $access_refresh_token,
			'id'                => $user->data->ID,
			'user_email'        => $user->data->user_email,
			'user_nicename'     => $user->data->user_nicename,
			'user_display_name' => $user->data->display_name,
		);
		return rest_ensure_response( $data );
	}

	/**
	 * Login with QRCode .
	 *
	 * @param WP_REST_Request $request The request.
	 *
	 * @return WP_User|WP_Error $user WP User with tokens info
	 */
	public function login_qr_code( $request ) {

		$secret = $request['secret'];

		$result = explode( '|', $secret, 2 );

		if ( count( $result ) !== 2 ) {
			return new WP_Error(
				'qr_code_auth_invalid_token',
				'QRCode token bad format',
				array(
					'status' => 403,
				)
			);
		}

		$user_id = $result[0];
		$user    = get_user_by( 'ID', $user_id );

		if ( false === $user ) {
			return new WP_Error(
				'invalid_user',
				'User not found',
				array(
					'status' => 403,
				)
			);
		}

		if ( ! $this->user_model->user_can_manage_wp_afa( $user_id ) ) {
			return new \WP_Error(
				'invalid_role',
				'Sorry, you are not allowed to login',
				array(
					'status' => 401,
				)
			);
		}

		$secret = $result[1];

		$verify_qr_code = ( new UserQRCodeModel() )->verify_qr_code( $user_id, $secret );

		if ( is_wp_error( $verify_qr_code ) ) {
			return rest_ensure_response( $verify_qr_code );
		}

		$this->user_tokens_model->delete_user_token_by_id( $user->data->ID );

		$access_token         = $this->jwt_plugin->generate_token( $user->data->ID );
		$access_refresh_token = $this->jwt_plugin->generate_refresh_token( $user->data->ID );

		$this->user_tokens_model->create( $user->data->ID, $access_token, $access_refresh_token );

		$data = array(
			'access_token'      => $access_token,
			'refresh_token'     => $access_refresh_token,
			'id'                => $user->data->ID,
			'user_email'        => $user->data->user_email,
			'user_nicename'     => $user->data->user_nicename,
			'user_display_name' => $user->data->display_name,
		);

		return rest_ensure_response( $data );
	}


	/**
	 * Get user.
	 *
	 * @param WP_REST_Request $request The request.
	 *
	 * @return array $user Some User info.
	 */
	public function user( $request ) {
		return rest_ensure_response( $this->user_model->user() );
	}

	/**
	 * Decodes a JWT string into a PHP object.
	 * if sucess force user login and keep on
	 *
	 * @param WP_REST_Request $request The request.
	 *
	 * @return array $data The info with user id, acess token and  refresh token.
	 */
	public function token( $request ) {

		$refresh_token = $request['refresh_token'];
		$validate      = $this->jwt_plugin->validate_refresh_token( $refresh_token );

		if ( is_wp_error( $validate ) ) {
			return rest_ensure_response( $validate );
		}

		$user_id              = $validate->id;
		$check_resfresh_token = $this->user_tokens_model->check_if_refresh_token_exist( $user_id, $refresh_token );

		if ( ! $check_resfresh_token ) {
			return new WP_Error(
				'jwt_auth_invalid_token',
				'Refresh token not found',
				array(
					'status' => 403,
				)
			);
		}

		if ( ! $this->user_model->user_can_manage_wp_afa( $user_id ) ) {
			return new \WP_Error(
				'invalid_role',
				'Sorry, you are not allowed to login',
				array(
					'status' => 401,
				)
			);
		}

		$this->user_tokens_model->delete_user_token_by_id( $user_id );

		$access_token         = $this->jwt_plugin->generate_token( $user_id );
		$access_refresh_token = $this->jwt_plugin->generate_refresh_token( $user_id );

		$this->user_tokens_model->create( $user_id, $access_token, $access_refresh_token );

		$data = array(
			'access_token'  => $access_token,
			'refresh_token' => $access_refresh_token,
			'id'            => $user_id,
		);

		return rest_ensure_response( $data );
	}
}
