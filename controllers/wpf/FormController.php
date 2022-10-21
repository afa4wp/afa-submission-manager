<?php

namespace Controllers\WPF;

use Models\WPF\FormModel;
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
     * WPF forms.
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
     * WPF forms.
     *
     * @param WP_REST_Request $request The request.
     * 
     * @return array $forms GF forms.
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
