<?php

namespace Models\GF;

use Models\UserModel;
use Models\GF\FormModel;
use Models\EntryModel as MainEntryModel;

class EntryModel extends MainEntryModel
{   
    public const TABLE_NAME = "gf_entry";

    public function __construct()
    {
        parent::__construct(SELF::TABLE_NAME);
    }

    /**
	 * Get Forms entries
     * 
     * @return array
	 */
    public function entries($offset, $number_of_records_per_page, $order_by = 'id')
    {
        
        $results = parent::entries($offset, $number_of_records_per_page, $order_by);
        
        $entries = $this->prepareData($results);

        return $entries;
    }

    /**
	 * Get Forms entry by id
     * 
     * @return object
	 */
    public function entryByID($entry_id, $id = 'id')
    {    
        $results =  parent::entryByID($entry_id, $id);

        $entries = $this->prepareData($results);
        
        if (empty($entries)){
            return [];
        }
        
        return $entries[0];
    }

    /**
	 * Get Forms entries
     * 
     * @return array
	 */
    public function entriesByFormID($form_id, $offset, $number_of_records_per_page)
    {
        global $wpdb;
        
        $results = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix.SELF::TABLE_NAME." WHERE form_id = ".$form_id." ORDER BY id DESC LIMIT ".$offset.",".$number_of_records_per_page,OBJECT);
        
        $entries = $this->prepareData($results);
        
        return $entries;
    }

    /**
	 * Get Forms entries by user info
     * 
     * @return array
	 */
    public function searchEntriesByUser($user_info, $offset, $number_of_records_per_page)
    {   
        global $wpdb;
     
        $results = $wpdb->get_results("SELECT fla.* FROM ".$wpdb->prefix.SELF::TABLE_NAME." fla INNER JOIN ".$wpdb->prefix."users wpu ON  
        fla.created_by = wpu.id WHERE wpu.user_login LIKE '%$user_info%' OR wpu.user_email LIKE '%$user_info%' ORDER BY fla.id DESC LIMIT ".$offset.",".$number_of_records_per_page, OBJECT); 
        
        $entries = $this->prepareData($results);
        
        return $entries;

    }

    /**
	 * Count Forms entries
     * 
     * @return array
	 */
    public function mumberItemsByUserInfo($user_info)
    {
        global $wpdb;
     
        $results = $wpdb->get_results("SELECT count(*)  as number_of_rows FROM ".$wpdb->prefix.SELF::TABLE_NAME." fla INNER JOIN ".$wpdb->prefix."users wpu ON  
        fla.created_by = wpu.id WHERE wpu.user_login LIKE '%$user_info%' OR wpu.user_email LIKE '%$user_info%' ", OBJECT); 
        
        $number_of_rows = intval( $results[0]->number_of_rows );
        
        return $number_of_rows ;  
    }

    /**
	 * Get Forms entries
     * 
     * @return array
	 */
    private function prepareData($results)
    { 
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

            $form_model = new FormModel();
            $entry['form_info'] = $form_model->formByID($value->form_id);

            $entries[] =  $entry;
        }

        return $entries;
    }
}
