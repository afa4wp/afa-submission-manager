<?php

namespace Includes\Routes;

use Includes\Controllers\UserController;
use Includes\Schema\UserSchema;

class UserRoute
{   
    /**
     * The slugs in the URL before the endpoint.
     */
    protected $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
	 * Create login endpoint.
	 */
    public function login()
    {
        register_rest_route(
            $this->name,
            '/user/login',
            array(
                array(
                    'methods' => 'POST',
                    'callback' => array(new UserController, 'login'),
                    'permission_callback' => '__return_true',
                    'args' => (new UserSchema())->login(),
                ),

            )
        );
    }

    /**
	 * Create info endpoint.
	 */
    public function user_me()
    {
        register_rest_route(
            $this->name,
            '/user/me',
            array(
                array(
                    'methods' => 'GET',
                    'callback' => array(new UserController, 'user'),
                    'permission_callback' => '__return_true',
                ),

            )
        );
    }

    /**
	 * Create refresh token endpoint.
	 */
    public function token()
    {
        register_rest_route(
            $this->name,
            '/user/tokens/refresh',
            array(
                array(
                    'methods' => 'POST',
                    'callback' => array(new UserController, 'token'),
                    'permission_callback' => '__return_true',
                    'args' => (new UserSchema())->token(),
                ),
            )
        );
    }

    /**
	 * Call all endpoints
	 */
    public function initRoutes()
    {
        $this->login();
        $this->user_me();
        $this->token();
    }

}
