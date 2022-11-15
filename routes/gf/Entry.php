<?php

namespace Routes\GF;

use Controllers\GF\EntryController;


class Entry
{

    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
	 * get all entries.
	 */
    public function entries()
    {
        register_rest_route(
            $this->name,
            '/gf/entries',
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
	 * get all entries from specific user.
	 */
    public function searchEntriesUser()
    {
        register_rest_route(
            $this->name,
            '/gf/entries/user/search/(?P<user_info>\S+)',
            array(
                array(
                    'methods' => 'GET',
                    'callback' => array(new EntryController, 'searchEntriesUser'),
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
        $this->searchEntriesUser();
    }

}
