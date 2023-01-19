<?php

namespace Includes\Routes\CF7;

use Includes\Controllers\CF7\EntryMetaController;


class EntryMeta
{
    private $name;
    
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
	 * get entry_meta by entry ID.
	 */
    public function entrymetaByEntryID()
    {
        register_rest_route(
            $this->name,
            '/cf7/entrymeta/entry_id/(?P<entry_id>[0-9]+)',
            array(
                array(
                    'methods' => 'GET',
                    'callback' => array(new EntryMetaController, 'entryMetaByEntryID'),
                    'permission_callback' => '__return_true',
                ),
            )
        );
    }

    /**
	 * get entry_meta by search.
	 */
    public function searchEntryMetaAnswer()
    {
        register_rest_route(
            $this->name,
            '/cf7/entrymeta/search/(?P<answer>\S+)',
            array(
                array(
                    'methods' => 'GET',
                    'callback' => array(new EntryMetaController, 'searchEntryMetaAnswer'),
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
        $this->entrymetaByEntryID();
        $this->searchEntryMetaAnswer();
    }

}
