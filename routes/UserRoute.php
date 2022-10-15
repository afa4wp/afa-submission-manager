<?php

namespace Routes;

use Controllers\UserController;
use Schema\UserSchema;
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
	 * Create refres token endpoint.
	 */
    public function token()
    {
        register_rest_route(
            $this->name,
            '/user/token',
            array(
                array(
                    'methods' => 'GET',
                    'callback' => array(new UserController, 'token'),
                    'permission_callback' => '__return_true',
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
