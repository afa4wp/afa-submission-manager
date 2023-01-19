<?php

namespace Includes\Controllers\GF;

use Includes\Models\GF\FormModel;
use Includes\Plugins\Helpers\Pagination;
use WP_Error;

class FormController
{   
    private $formModel;

    private $number_of_records_per_page;
    
    private $paginationHelper;

    public function __construct()
    {
        $this->formModel = new FormModel();
        $this->paginationHelper = new Pagination();
        $this->number_of_records_per_page = $this->paginationHelper->getNumberofRecordsPerPage();
    }

    /**
     * GF forms.
     *
     * @return array $forms GF forms.
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
     * GF forms.
     *
     * @param WP_REST_Request $request The request.
     * 
     * @return aobject $form GF form.
     */
    public function formByID($request)
    {   
        $id = $request["id"];

        $form =  $this->formModel->formByID($id);

        return rest_ensure_response($form); 
    }

    /**
     * GF forms.
     *
     * @param WP_REST_Request $request The request.
     * 
     * @return array $forms GF forms.
     */
    public function formsPagination($request)
    {   
        $page = $request['page_number'];

        $count = $this->formModel->mumberItems();

        $offset = $this->paginationHelper->getOffset($page, $count);

        $forms =  $this->formModel->forms($offset, $this->number_of_records_per_page);

        $forms_results =  $this->paginationHelper->prepareDataForRestWithPagination($count, $forms);

        return rest_ensure_response($forms_results);
    }


    /**
     * GF forms.
     *
     * @param WP_REST_Request $request The request.
     * 
     * @return array $forms GF forms.
     */
    public function searchForms($request)
    {   
        $post_name = urldecode($request['post_name']);

        $forms_results = [];
        
        $offset = 0;

        $forms =  $this->formModel->searchForms($post_name, $offset, $this->number_of_records_per_page);

        $info = [];
        $info["count"]  = $this->formModel->mumberItemsOnSerach($post_name);
        $info["pages"]  = ceil($info["count"]/$this->number_of_records_per_page);
        
        $forms_results["info"] = $info;
        $forms_results["results"] = $forms;
 
        return rest_ensure_response($forms_results);

    }
  
}
