<?php

namespace Includes\Controllers\GF;

use Includes\Models\GF\EntryMetaModel;
use WP_Error;

class EntryMetaController
{   
    private $entryMetaModel;

    private $number_of_records_per_page = 20;

    public function __construct()
    {
        $this->entryMetaModel= new EntryMetaModel();
         
    }

    /**
     * GF forms entry.
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

    /**
     * GF forms entry.
     *
     * @param WP_REST_Request $request The request.
     * 
     * @return array $forms GF forms.
     */
    public function searchEntryMetaAnswer($request)
    {   
        $answer = urldecode($request['answer']);

        $items = $this->entryMetaModel->searchEntryMetaAnswer($answer, 0, $this->number_of_records_per_page);
      
        return rest_ensure_response($items);
    }
}
