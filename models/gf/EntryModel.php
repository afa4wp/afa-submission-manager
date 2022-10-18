<?php

namespace Models\GF;

use Models\UserModel;

class EntryModel
{   
    public const DATABASE_NAME = "gf_entry";

    public function __construct()
    {}

    /**
	 * Get Forms entries
     * 
     * @return array
	 */
    public function entries($offset, $number_of_records_per_page)
    {
        global $wpdb;
        $results = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix.SELF::DATABASE_NAME." ORDER BY id DESC LIMIT ".$offset.",".$number_of_records_per_page,OBJECT);
        
        $entries = [];

        foreach($results as $key => $value){
            
            $entry = [];

            $entry['id'] = $value->id;
            $entry['form_id'] = $value->form_id;
            $entry['date_created'] = $value->date_created;
            $entry['created_by'] = $value->created_by;
            $entry['author_info'] = [];

            if(!empty($value->created_by)){
                $user_model = new UserModel();
                $entry['author_info'] = $user_model->userInfoByID($value->created_by);
            }

            $entries[] =  $entry;
        }

        return $entries;
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
