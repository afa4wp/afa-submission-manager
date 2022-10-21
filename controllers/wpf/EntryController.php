<?php

namespace Controllers\WEP;

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

    
}
