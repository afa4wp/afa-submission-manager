<?php

namespace Routes\CF7;

use Controllers\CF7\EntryController;

class Entry
{

    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
	 * get all forms.
	 */
    public function entries()
    {
        register_rest_route(
            $this->name,
            '/cf7/entries',
            array(
                array(
                    'methods' => 'GET',
                    'callback' => array(new EntryController, 'entries'),
                    'permission_callback' => '__return_true',
                ),
            )
        );
    }


    /**
	 * Call all endpoints
	 */
    public function initRoutes()
    {
        $this->entries();
    }

}
