<?php

namespace Routes\WPF;

use Controllers\WPF\EntryMetaController;


class EntryMeta
{

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
            '/wpf/entrymeta/entry_id/(?P<entry_id>[0-9]+)',
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
	 * Call all endpoints
	 */
    public function initRoutes()
    {
        $this->entrymetaByEntryID();
    }

}
