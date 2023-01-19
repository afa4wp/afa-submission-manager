<?php

namespace Includes\Routes\GF;

use Includes\Routes\GF\Form;
use Includes\Routes\GF\Entry;
use Includes\Routes\GF\EntryMeta;

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
