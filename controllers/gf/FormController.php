<?php

namespace Controllers\GF;

use Models\GF\FormModel;
use WP_Error;

class FormController
{   
    private $formModel;
    public function __construct()
    {
        $this->formModel = new FormModel();
    }

    /**
     * GF forms.
     *
     * @return array $forms GF forms.
     */
    public function forms()
    {   
        $forms_results = [];
        $number_of_records_per_page = 20;

        //$forms = \GFAPI::get_forms();
        $forms =  $this->formModel->forms();

        $info = [];
        $info["count"]  = $this->formModel->mumberItems();
        $info["pages"]  = ceil($info["count"]/$number_of_records_per_page);
        
        $forms_results["info"] = $info;
        $forms_results["results"] = $forms;
 
        return rest_ensure_response($forms_results);
    }
}
