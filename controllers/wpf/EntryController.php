<?php

namespace Controllers\WPF;

use Models\WPF\EntryModel;
use Plugins\Helpers\Pagination;
use WP_Error;

class EntryController
{   
    private $entryModel;
    private $number_of_records_per_page;
    public function __construct()
    {
        $this->entryModel = new EntryModel();
        $this->paginationHelper = new Pagination();
        $this->number_of_records_per_page = $this->paginationHelper->getNumberofRecordsPerPage();
    }

    /**
     * WPF forms entry.
     *
     * @return array $forms WPF forms.
     */
    public function entries()
    {   
        $count = $this->entryModel->mumberItems();
        
        $offset = 0;

        $entries =  $this->entryModel->entries($offset, $this->number_of_records_per_page);
        
        $entries_results = $this->paginationHelper->prepareDataForRestWithPagination($count, $entries);
 
        return rest_ensure_response($entries_results);
    }

    /**
     * WPF forms entry.
     *
     * @return array $forms WPF forms.
     */
    public function entryByID($request)
    {   
        $entry_id = $request['entry_id'];
        $entry =  $this->entryModel->entryByID($entry_id);
        return rest_ensure_response($entry);

    }

    /**
     * WPF forms entries by id.
     *
     * @return array $forms WPF forms.
     */
    public function entriesByFormID($request)
    {   
        $form_id = $request['form_id'];
        
        $page = $request['page_number'];

        $count = $this->entryModel->mumberItemsByFormID($form_id);
        
        $offset = $this->paginationHelper->getOffset($page, $count);

        $entries = $this->entryModel->entriesByFormID($form_id, $offset, $this->number_of_records_per_page);

        $entries_results = $this->paginationHelper->prepareDataForRestWithPagination($count, $entries);
 
        return rest_ensure_response($entries_results);
    }

    /**
     * WPF forms entries by user info.
     *
     * @return array $forms WPF forms.
     */
    public function searchEntriesByUser($request)
    {   
        $user_info = $request['user_info'];
        
        $offset = 0;

        $entries =  $this->entryModel->searchEntriesByUser($user_info, $offset, $this->number_of_records_per_page);

        $count = $this->entryModel->mumberItemsByUserInfo($user_info);

        $entries_results = $this->paginationHelper->prepareDataForRestWithPagination($count, $entries);
 
        return rest_ensure_response($entries_results);
    }
    

    
}
