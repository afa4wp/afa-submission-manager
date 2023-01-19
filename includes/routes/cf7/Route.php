<?php

namespace Includes\Routes\CF7;

use Includes\Routes\CF7\Form;
use Includes\Routes\CF7\Entry;
use Includes\Routes\CF7\EntryMeta;

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
