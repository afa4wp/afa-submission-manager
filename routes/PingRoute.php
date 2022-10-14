<?php

namespace Routes;

class PingRoute
{

    protected $name;

    /**
	 * Setup action & filter hooks.
	 */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
	 * Setup action & filter hooks.
	 */
    public function ping()
    {
        register_rest_route(
            $this->name,
            '/ping',
            array(
                array(
                    'methods' => 'GET',
                    'callback' => array($this, 'pingFunc'),
                    'permission_callback' => '__return_true',
                ),
            )
        );

    }

    /**
	 * Setup action & filter hooks.
	 */
    public function pingFunc()
    {
        return rest_ensure_response(array(
            'ping' => 'pong',
        ));
    }

    /**
	 * Setup action & filter hooks.
	 */
    public function initRoutes()
    {
        $this->ping();
    }

}
