<?php

namespace Controllers\CF7;

use Models\CF7\FormModel;
use WP_Error;

class FormController
{   
    private $formModel;
    private $number_of_records_per_page = 20;
    public function __construct()
    {
        $this->formModel = new FormModel();
    }

    /**
     * CF7 forms.
     *
     * @return array $forms GF forms.
     */
    public function forms()
    {   
        $forms_results = [];
        
        $offset = 0;

        $forms =  $this->formModel->forms($offset, $this->number_of_records_per_page);

        $info = [];
        $info["count"]  = $this->formModel->mumberItems();
        $info["pages"]  = ceil($info["count"]/$this->number_of_records_per_page);
        
        $forms_results["info"] = $info;
        $forms_results["results"] = $forms; 
 
        return rest_ensure_response($forms_results); 
    }

    /**
     * CF7 forms.
     *
     * @param WP_REST_Request $request The request.
     * 
     * @return array $forms CF7 forms.
     */
    public function formsPagination($request)
    {   
        $page = $request['page_number'];

        $forms_results = [];

        $offset  = ($page - 1) * $this->formModel->mumberItems();

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
