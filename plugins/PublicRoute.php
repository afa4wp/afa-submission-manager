<?php 

namespace Plugins;


class PublicRoute{

    private $nameSpace;//"wp-general-rest-api/v1";

    private  $publicRoutes = [
        '/user/login',
        '/ping'
    ];

    function __construct($nameSpace)
    {
        $this->nameSpace = $nameSpace;
    }

    public function getPublicRoutes(){
        return array_map(
            function($value) { return $this->nameSpace.$value; },
            $this->publicRoutes 
        );
    }

    public function isPublicRoute($route){
        return in_array( $route,  $this->getPublicRoutes());
    }
  
}