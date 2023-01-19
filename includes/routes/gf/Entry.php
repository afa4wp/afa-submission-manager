<?php

namespace Includes\Routes\GF;

use Includes\Controllers\GF\EntryController;

class Entry
{
    private $name;
    
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
	 * get entry by id.
	 */
    public function entryByID()
    {
        register_rest_route(
            $this->name,
            '/gf/entries/(?P<entry_id>[0-9]+)',
            array(
                array(
                    'methods' => 'GET',
                    'callback' => array(new EntryController, 'entryByID'),
                    'permission_callback' => '__return_true',
                ),
            )
        );
    }

    /**
	 * get entry by id.
	 */
    public function entriesByFormID()
    {
        register_rest_route(
            $this->name,
            '/gf/entries/form_id/(?P<form_id>[0-9]+)/page/(?P<page_number>[0-9]+)',
            array(
                array(
                    'methods' => 'GET',
                    'callback' => array(new EntryController, 'entriesByFormID'),
                    'permission_callback' => '__return_true',
                ),
            )
        );
    }

    /**
	 * get all entries from specific user.
	 */
    public function searchEntriesByUser()
    {
        register_rest_route(
            $this->name,
            '/gf/entries/user/search/(?P<user_info>\S+)',
            array(
                array(
                    'methods' => 'GET',
                    'callback' => array(new EntryController, 'searchEntriesByUser'),
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
        $this->entryByID();
        $this->entriesByFormID();
        $this->searchEntriesByUser();
    }

}
