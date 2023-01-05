<?php

namespace Routes\WPF;

use Routes\WPF\Form;
use Routes\WPF\Entry;
use Routes\WPF\EntryMeta;

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
    public function initRoutes()
    {
        (new Form($this->name))->initRoutes();
        (new Entry($this->name))->initRoutes();
        (new EntryMeta($this->name))->initRoutes();    
    }

}
