<?php

namespace Routes;

use Routes\PingRoute;
use Routes\UserRoute;
use Routes\GF\Route as GFRoute;
use Routes\WPF\Route as WPFRoute;
use Routes\WEF\Route as WEFRoute;
use Routes\CF7\Route as CF7Route;

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
        (new WPFRoute($this->name))->initRoutes();
        (new WEFRoute($this->name))->initRoutes();
        (new CF7Route($this->name))->initRoutes();
        
    }


}
