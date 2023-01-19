<?php

namespace Includes\Models;

class EntryModel
{   
    public  $table_name ;

    public function __construct($table_name)
    {
        $this->table_name = $table_name;
    }

    /**
	 * Get Forms entries
     * 
     * @return array
	 */
    public function entries($offset, $number_of_records_per_page, $order_by = 'id')
    {
        global $wpdb;
        
        $results = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix.$this->table_name." ORDER BY $order_by DESC LIMIT ".$offset.",".$number_of_records_per_page, OBJECT);

        return $results;
    }

    /**
	 * Get Forms entry by id
     * 
     * @return object
	 */
    public function entryByID($entry_id, $id = 'id')
    {   
        global $wpdb;
        
        $results = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix.$this->table_name." WHERE $id = $entry_id ", OBJECT);

        return $results;
    }

    /**
	 * Get Forms entries
     * 
     * @return array
	 */
    public function entriesByFormID($form_id, $offset, $number_of_records_per_page)
    {
        global $wpdb;
        
        $results = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix.$this->table_name." WHERE form_id = ".$form_id." ORDER BY id DESC LIMIT ".$offset.",".$number_of_records_per_page,OBJECT);
        
        return $results;
    }


    /**
	 * Get number of Forms 
     * 
     * @return int
	 */
    public function mumberItems()
    {
        global $wpdb;
        
        $results = $wpdb->get_results("SELECT count(*)  as number_of_rows FROM ".$wpdb->prefix.$this->table_name."");
        
        $number_of_rows = intval( $results[0]->number_of_rows );
        
        return $number_of_rows ;  
    }

    /**
	 * Get number of Forms by form_id 
     * 
     * @return int
	 */
    public function mumberItemsByFormID($form_id)
    {
        global $wpdb;

        $results = $wpdb->get_results("SELECT count(*)  as number_of_rows FROM ".$wpdb->prefix.$this->table_name." WHERE form_id = ".$form_id);
        
        $number_of_rows = intval( $results[0]->number_of_rows );
        
        return $number_of_rows ;  
    }
}
