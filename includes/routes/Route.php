<?php

namespace Includes\Routes;

use Includes\Routes\PingRoute;
use Includes\Routes\UserRoute;
use Includes\Routes\GF\Route as GFRoute;
use Includes\Routes\WPF\Route as WPFRoute;
use Includes\Routes\WEF\Route as WEFRoute;
use Includes\Routes\CF7\Route as CF7Route;

class Route
{
    private $name;
    
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
