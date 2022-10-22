<?php

namespace Controllers\WPF;

use Models\WPF\EntryMetaModel;

class EntryMetaController
{   
    private $entryMetaModel;
    public function __construct()
    {
        $this->entryMetaModel= new EntryMetaModel();
         
    }

    /**
     * WPF forms entry.
     *
     * @param WP_REST_Request $request The request.
     * 
     * @return array $forms GF forms.
     */
    public function entryMetaByEntryID($request)
    {   
        $entry_id = $request['entry_id'];

        $items = $this->entryMetaModel->entryMetaByEntryID($entry_id);
       
        return rest_ensure_response($items);
    }

    
}
