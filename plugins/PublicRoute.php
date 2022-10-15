<?php

namespace Plugins;
class PublicRoute
{   
    /**
     * The slugs in the URL before the endpoint.
     */
    private $nameSpace; 

    /**
	 * Add public route.
	 */
    private $publicRoutes = [
        '/user/login',
        '/user/token',
        '/ping',
    ];

    public function __construct($nameSpace)
    {
        $this->nameSpace = $nameSpace;
    }

    /**
	 * Get publix routes  
     * 
     * @return array $publicRoutes all public route with namespace
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
	 * Verify if some rote is public or not
     * 
     * @param string $route The route that route being accessed  
     * 
     * @return bool
	 */
    public function isPublicRoute($route)
    {
        return in_array($route, $this->getPublicRoutes());
    }
}
