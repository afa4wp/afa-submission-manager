<?php

namespace Routes\WPF;

use Routes\WPF\Form;


class Route
{

    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
	 * Init all routes.
	 */
    public function initRoutes()
    {
        (new Form($this->name))->initRoutes();    
    }


}
