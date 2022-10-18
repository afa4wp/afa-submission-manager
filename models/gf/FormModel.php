<?php

namespace Models\GF;

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
        $results = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix.SELF::DATABASE_NAME."WHERE id = $id ",OBJECT);
        
        $forms = [];

        foreach($results as $key => $value){
            
            $form = [];

            $form['id'] = $value->id;
            $form['title'] = $value->title;
            $form['date_created'] = $value->date_created;
            $form['registers'] = \GFAPI::count_entries($value->id);
            $form['user_created'] = null;

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
}
