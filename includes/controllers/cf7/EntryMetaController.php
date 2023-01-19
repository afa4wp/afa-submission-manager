<?php

namespace Includes\Controllers\CF7;

use Includes\Models\CF7\EntryMetaModel;
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
     * CF7 forms entry.
     *
     * @param WP_REST_Request $request The request.
     * 
     * @return array $forms CF7 forms.
     */
    public function entryMetaByEntryID($request)
    {   
        $entry_id = $request['entry_id'];

        $items = $this->entryMetaModel->entryMetaByEntryID($entry_id);
      
        return rest_ensure_response($items);
    }

    /**
     * CF7 forms entry.
     *
     * @param WP_REST_Request $request The request.
     * 
     * @return array $forms CF7 forms.
     */
    public function searchEntryMetaAnswer($request)
    {   
        $answer = urldecode($request['answer']);

        $items = $this->entryMetaModel->searchEntryMetaAnswer($answer);
      
        return rest_ensure_response($items);
    }

}
