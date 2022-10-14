<?php

namespace Models;

class UserModel
{
    public function __construct()
    {

    }

    /**
	 * Setup action & filter hooks.
	 */
    public function login($username, $password)
    {
        $login = wp_signon(array(
            'user_login' => $username,
            'user_password' => $password,
        ));
        return $login;

    }

    /**
	 * Setup action & filter hooks.
	 */
    public function user()
    {
        $user = wp_get_current_user();
        return array(
            'id' => $user->ID,
            'email' => $user->data->user_email,
            'display_name' => $user->data->display_name,
            'user_login' => $user->data->user_login,
        );
    }

}
