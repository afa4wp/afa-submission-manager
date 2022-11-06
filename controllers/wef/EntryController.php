<?php

namespace Controllers\WEF;

use Models\WEF\EntryModel;
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
     * WEF forms entry.
     *
     * @return array $forms WEF forms.
     */
    public function entries()
    {   
        $entries_results = [];
        
        $offset = 0;

        $entries =  $this->entryModel->entries($offset, $this->number_of_records_per_page);

        $info = [];
        $info["count"]  = $this->entryModel->mumberItems();
        $info["pages"]  = ceil($info["count"]/$this->number_of_records_per_page);
        
        $entries_results["info"] = $info;
        $entries_results["results"] = $entries;
 
        return rest_ensure_response($entries_results);
    }

    
}
