<?php

namespace Routes;

use Routes\PingRoute;
use Routes\UserRoute;

class Route
{

    public function __construct($name)
    {
        $this->name = $name;
    }

    /*
     *
     */

    public function init()
    {
        // init all route
        (new PingRoute($this->name))->initRoutes();
        (new UserRoute($this->name))->initRoutes();
            
    }


}
