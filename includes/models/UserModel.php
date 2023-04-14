<?php

namespace Includes\Models;

class UserModel {

	public function __construct() {
	}

	/**
	 * Login user
	 *
	 * @param string $username The user name.
	 * @param string $password The user password.
	 *
	 * @return WP_User|WP_Error $user WP User object.
	 */
	public function login( $username, $password ) {

		$login = wp_signon(
			array(
				'user_login'    => $username,
				'user_password' => $password,
			)
		);

		if ( ! is_wp_error( $login ) ) {
			if ( ! $this->user_can_manage_wp_afa( $login->ID ) ) {
				return new \WP_Error(
					'invalid_role',
					'Sorry, you are not allowed to login',
					array(
						'status' => 401,
					)
				);
			}
		}

		return $login;
	}

	 /**
	  * Get user
	  *
	  * @return WP_User $user Some User info.
	  */
	public function user() {
		$user = wp_get_current_user();
		return array(
			'id'           => $user->ID,
			'email'        => $user->data->user_email,
			'display_name' => $user->data->display_name,
			'user_login'   => $user->data->user_login,
		);
	}

	/**
	 * Get user by id
	 *
	 * @return WP_User $user Some User info.
	 */
	public function userInfoByID( $id ) {
		if ( empty( $id ) ) {
			return array();
		}

		 $user = get_user_by( 'ID', $id );

		if ( empty( $user ) ) {
			return array();
		}
		 $user_info = array();

		 $user_info['user_name']  = $user->display_name;
		 $user_info['user_email'] = $user->user_email;
		 $user_info['avatar_url'] = get_avatar_url( $id );

		 return $user_info;
	}

	public function user_can_manage_wp_afa( $user_id ) {
		$user = new \WP_User( $user_id );
		if($user->exists()){
			if (user_can( $user_id, 'manage_options' )){
				return true;
			}
			if ( in_array( 'wp_afa_staff', $user->roles, true ) ) {
				return true;
			}
			return false;
		}
		return false;
	}

	/**
	 * Add user as staff
	 *
	 * @since 1.0.0
	 *
	 * @param int $user_id The ID for user.
	 *
	 * @return void
	 */
	public function add_staff( $user_id ) {

		$user_can_manage_wp_afa = ( new UserModel() )->user_can_manage_wp_afa( $user_id );

		if ( ! $user_can_manage_wp_afa ) {
			$user = new \WP_User( $user_id );
			if ( $user->exists() ) {
				$user->add_role( 'wp_afa_staff' );
			}
		}

	}

	/**
	 * Remove user as staff
	 *
	 * @since 1.0.0
	 *
	 * @param int $user_id The ID for user.
	 *
	 * @return void
	 */
	public function remove_staff( $user_id ) {
		$user_can_manage_wp_afa = ( new UserModel() )->user_can_manage_wp_afa( $user_id );

		if ( $user_can_manage_wp_afa ) {
			$user = new \WP_User( $user_id );
			if ( $user->exists() ) {
				$user->remove_role( 'wp_afa_staff' );
			}
		}
	}
	
}
