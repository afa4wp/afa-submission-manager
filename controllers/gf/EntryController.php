<?php

namespace Controllers\GF;

use Models\GF\EntryModel;
use WP_Error;

class EntryController
{   
    private $entryModel;
    private $number_of_records_per_page = 20;
    public function __construct()
    {
        $this->entryModel = new EntryModel();
    }

    /**
     * GF forms entry.
     *
     * @return array $forms GF forms.
     */
    public function entries()
    {   
        $entries_results = [];
        
        $offset = 0;

        //$forms = \GFAPI::get_forms();
        $entries =  $this->entryModel->entries($offset, $this->number_of_records_per_page);

        $info = [];
        $info["count"]  = $this->entryModel->mumberItems();
        $info["pages"]  = ceil($info["count"]/$this->number_of_records_per_page);
        
        $entries_results["info"] = $info;
        $entries_results["results"] = $entries;
 
        return rest_ensure_response($entries_results);
    }

    /**
     * GF forms entry.
     *
     * @return array $forms GF forms.
     */
    public function entryByID($request)
    {   
        $entry_id = $request['entry_id'];
        $entry =  $this->entryModel->entryByID($entry_id);
        return rest_ensure_response($entry);

    }

    /**
     * GF forms entries by id.
     *
     * @return array $forms GF forms.
     */
    public function entriesByFormID($request)
    {   
        $form_id = $request['form_id'];
        $page_number = $request['page_number'];

        $entries_results = [];
        
        $offset = ($page_number - 1) * $this->number_of_records_per_page;

        $entries = $this->entryModel->entriesByFormID($form_id, $offset, $this->number_of_records_per_page);

        $info = [];
  
        $info["count"]  = $this->entryModel->mumberItemsByFormID($form_id);
        $info["pages"]  = ceil($info["count"]/$this->number_of_records_per_page);
        
        $entries_results["info"] = $info;
        $entries_results["results"] = $entries;
 
        return rest_ensure_response($entries_results);
    }

    
}
