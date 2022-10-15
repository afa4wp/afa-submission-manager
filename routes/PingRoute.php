<?php

namespace Routes;

class PingRoute
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
	 * Create ping endpoint.
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
	 * Create ping callback.
	 */
    public function pingFunc()
    {
        return rest_ensure_response(array(
            'ping' => 'pong',
        ));
    }

    /**
	 * Call all endpoints
	 */
    public function initRoutes()
    {
        $this->ping();
    }

}
