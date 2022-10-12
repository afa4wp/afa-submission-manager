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

    public function __construct($nameSpace)
    {
        $this->nameSpace = $nameSpace;
    }

    public function getPublicRoutes()
    {
        return array_map(
            function ($value) {
                return $this->nameSpace . $value;
            },
            $this->publicRoutes
        );
    }

    public function isPublicRoute($route)
    {
        return in_array($route, $this->getPublicRoutes());
    }
}
