<?php

namespace Controllers\WEF;

use Models\WEF\FormModel;
use Plugins\Helpers\Pagination;
use WP_Error;

class FormController
{   
    private $formModel;
    private $number_of_records_per_page;
    public function __construct()
    {
        $this->formModel = new FormModel();
        $this->paginationHelper = new Pagination();
        $this->number_of_records_per_page = $this->paginationHelper->getNumberofRecordsPerPage();
    }

    /**
     * WEF forms.
     *
     * @return array $forms WEF forms.
     */
    public function forms()
    {   
        $count = $this->formModel->mumberItems();
        
        $offset = 0;

        $forms =  $this->formModel->forms($offset, $this->number_of_records_per_page);

        $forms_results =  $this->paginationHelper->prepareDataForRestWithPagination($count, $forms);
 
        return rest_ensure_response($forms_results); 
    }

    /**
     * WEF forms.
     *
     * @param WP_REST_Request $request The request.
     * 
     * @return array $forms WEF forms.
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
