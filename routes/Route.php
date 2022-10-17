<?php

namespace Routes;

use Routes\PingRoute;
use Routes\UserRoute;
use Routes\GF\Route as GFRoute;

class Route
{

    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
	 * Init all routes.
	 */
    public function init()
    {
        (new PingRoute($this->name))->initRoutes();
        (new UserRoute($this->name))->initRoutes();
        (new GFRoute($this->name))->initRoutes();    
        
    }


}
