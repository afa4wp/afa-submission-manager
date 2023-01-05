<?php

namespace Routes\GF;

use Routes\GF\Form;
use Routes\GF\Entry;
use Routes\GF\EntryMeta;

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
