<?php

namespace Models\GF;

use WP_Query;
use Plugins\Helpers\FormsShortcodeFinder;
class FormModel
{   
    public const DATABASE_NAME = "gf_form";

    public function __construct()
    {}

    /**
	 * Get Forms 
     * 
     * @return array
	 */
    public function forms($offset, $number_of_records_per_page)
    {
        global $wpdb;
        $results = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix.SELF::DATABASE_NAME." ORDER BY id DESC LIMIT ".$offset.",".$number_of_records_per_page,OBJECT);
        
        $forms = [];

        foreach($results as $key => $value){
            
            $form = [];

            $form['id'] = $value->id;
            $form['title'] = $value->title;
            $form['date_created'] = $value->date_created;
            $form['registers'] = \GFAPI::count_entries($value->id);
            $form['user_created'] = null;
            $form['perma_links'] = $this->pagesLinks($value->id);

            $forms[] =  $form;
        }

        return $forms;
    }

    /**
	 * Get Form by id 
     * 
     * @param int     $id The form ID.
     * 
     * @return array
	 */
    public function formByID($id)
    {
        global $wpdb;
        $results = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix.SELF::DATABASE_NAME." WHERE id = $id ",OBJECT);
        
        $forms = [];

        foreach($results as $key => $value){
            
            $form = [];

            $form['id'] = $value->id;
            $form['title'] = $value->title;
            $form['date_created'] = $value->date_created;
            $form['registers'] = \GFAPI::count_entries($value->id);
            $form['user_created'] = null;
            $form['perma_links'] = $this->pagesLinks($value->id);
            $forms[] =  $form;
        }

        if(count($forms) > 0){
            return $forms[0];
        }

        return $forms;
    }

    /**
	 * Get Forms 
     * 
     * @return int
	 */
    public function mumberItems()
    {
        global $wpdb;
        $results = $wpdb->get_results("SELECT count(*)  as number_of_rows FROM ".$wpdb->prefix.SELF::DATABASE_NAME."");
        $number_of_rows = intval( $results[0]->number_of_rows );
        return $number_of_rows ;  
    }

    /**
	 * Get Forms 
     * 
     * @return int
	 */
    public function mumberItemsOnSerach($post_name)
    {
        global $wpdb;
        $results = $wpdb->get_results("SELECT count(*)  as number_of_rows FROM ".$wpdb->prefix.SELF::DATABASE_NAME."  WHERE title LIKE '%$post_name%' ");
        $number_of_rows = intval( $results[0]->number_of_rows );
        return $number_of_rows ;  
    }

    /**
	 * Get form pages links  
     * 
     * @param int     $formID The form ID.
     * 
     * @return array
	 */
    public function pagesLinks($formID)
    {
        $pages_with_form = (new FormsShortcodeFinder( $formID ))->gfFind();
        
        if(empty($pages_with_form)){
            return $pages_with_form;
        }

        $results = [];

        foreach ($pages_with_form as $key => $value) {
            $result = [];
            $result['page_name'] = $value;
            $result['page_link'] = get_page_link($key);
            $results = $result;
        }

        return $results;
    }

    /**
	 * Get Forms 
     * 
     * @return array
	 */
    public function searchForms($post_name, $offset, $number_of_records_per_page)
    {
        global $wpdb;
        $results = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix.SELF::DATABASE_NAME." WHERE title LIKE '%$post_name%' ORDER BY id DESC LIMIT ".$offset.",".$number_of_records_per_page,OBJECT);
        
        $forms = [];

        foreach($results as $key => $value){
            
            $form = [];

            $form['id'] = $value->id;
            $form['title'] = $value->title;
            $form['date_created'] = $value->date_created;
            $form['registers'] = \GFAPI::count_entries($value->id);
            $form['user_created'] = null;
            $form['perma_links'] = $this->pagesLinks($value->id);

            $forms[] =  $form;
        }

        return $forms;
    }

}
