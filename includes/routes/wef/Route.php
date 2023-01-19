<?php

namespace Includes\Routes\WEF;

use Includes\Routes\WEF\Form;
use Includes\Routes\WEF\Entry;
use Includes\Routes\WEF\EntryMeta;

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
