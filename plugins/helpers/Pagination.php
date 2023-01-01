<?php

namespace Plugins\Helpers;
/**
 * Handler with pagination info.
 */

class Pagination
{
    private $number_of_records_per_page = 20;

    private $count ;

    /**
     * Number of item per page.
     *
     * @return int $number_of_records_per_page.
     */
    public function getNumberofRecordsPerPage(){
        return $this->number_of_records_per_page;
    }

    /**
     * Forms.
     *
     * @return array $forms.
     */
    public function prepareDataForRestWithPagination($count, $data){
        
        $this->count = $count;
        
        $info = [];
        $info["count"] = $count;
        $info["pages"]  = $this->getPages();

        $data_results = [];

        $data_results["info"] = $info;
        $data_results["results"] = $data;

        return  $data_results;
    }

    /**
     * Number of pages.
     *
     * @return int
     */
    private function getPages(){
        return  ceil($this->count/$this->number_of_records_per_page);
    }

    /**
     * Calculate offset.
     *
     * @return int
     */

    public function getOffset($page , $count){
         
        $offset  = ($page - 1) * $count;
        
        return $offset;
    
    }

}