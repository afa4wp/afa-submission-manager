<?php

namespace Controllers\GF;

use WP_Error;

class EntryController
{   
    private $entryModel;
    private $number_of_records_per_page = 20;
    public function __construct()
    {
        //$this->formModel = new FormModel();
    }

    /**
     * GF forms entry.
     *
     * @return array $forms GF forms.
     */
    public function entries()
    {   
        $forms_results = [];
        
        $offset = 0;

        //$forms = \GFAPI::get_forms();
        $forms =  $this->formModel->forms($offset, $this->number_of_records_per_page);

        $info = [];
        $info["count"]  = $this->formModel->mumberItems();
        $info["pages"]  = ceil($info["count"]/$this->number_of_records_per_page);
        
        $forms_results["info"] = $info;
        $forms_results["results"] = $forms;
 
        return rest_ensure_response($forms_results);
    }

    
}
