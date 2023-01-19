<?php

namespace Includes\Routes\WPF;

use Includes\Routes\WPF\Form;
use Includes\Routes\WPF\Entry;
use Includes\Routes\WPF\EntryMeta;

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
