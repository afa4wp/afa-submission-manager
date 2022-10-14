<?php

namespace Plugins;

class PublicRoute
{
    private $nameSpace; 

    private $publicRoutes = [
        '/user/login',
        '/user/token',
        '/ping',
    ];

    /**
	 * Setup action & filter hooks.
	 */
    public function __construct($nameSpace)
    {
        $this->nameSpace = $nameSpace;
    }

    /**
	 * Setup action & filter hooks.
	 */
    public function getPublicRoutes()
    {
        return array_map(
            function ($value) {
                return $this->nameSpace . $value;
            },
            $this->publicRoutes
        );
    }

    /**
	 * Setup action & filter hooks.
	 */
    public function isPublicRoute($route)
    {
        return in_array($route, $this->getPublicRoutes());
    }
}
