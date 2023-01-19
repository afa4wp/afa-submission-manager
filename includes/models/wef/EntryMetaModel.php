<?php

namespace Includes\Models\WEF;

use Includes\Models\UserModel;
use Includes\Models\WEF\FormModel;

class EntryMetaModel
{   
    public const TABLE_NAME = "weforms_entrymeta";

    public function __construct()
    {}

    /**
	 * Get entry_meta by entry ID
     * 
     * @return array
	 */
    public function entryMetaByEntryID($entry_id)
    {
        global $wpdb;
        $results = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix.SELF::TABLE_NAME." WHERE weforms_entry_id = $entry_id",OBJECT);
        
        $items = [];
        $entry_data = weforms_get_entry_data( $entry_id );

        foreach($results as $key => $value){
            
            $item = [];

            $item['id'] = $value->meta_id;
            $entry = weforms_get_entry($value->weforms_entry_id);
            $item['form_id'] = $entry->form_id;

            $item['entry_id'] = $value->weforms_entry_id;

            $item['meta_key'] = $value->meta_key;
            $item['meta_value'] = $value->meta_value;

            $item['type'] = $entry_data["fields"][$value->meta_key]["type"];
            $item['label'] = $entry_data["fields"][$value->meta_key]["label"];

            $items[] = $item;
   
        }

        return $items;
    }

    /**
	 * Get entry_meta by entry ID
     * 
     * @return array
	 */
    public function searchEntryMetaAnswer($answer, $offset, $number_of_records_per_page)
    {   
        global $wpdb;

        $results = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix.SELF::TABLE_NAME." WHERE meta_value LIKE '%$answer%' ORDER BY meta_id DESC LIMIT ".$offset.",".$number_of_records_per_page);
        
        $items = [];

        foreach($results as $key => $value){
            
            $entry_data = weforms_get_entry_data( $value->weforms_entry_id );

            $item = [];

            $item['id'] = $value->meta_id;
            $entry = weforms_get_entry($value->weforms_entry_id);
            $item['form_id'] = $entry->form_id;

            $item['entry_id'] = $value->weforms_entry_id;

            $item['meta_key'] = $value->meta_key;
            $item['meta_value'] = $value->meta_value;

            $item['type'] = $entry_data["fields"][$value->meta_key]["type"];
            $item['label'] = $entry_data["fields"][$value->meta_key]["label"];

            $items[] = $item;
   
        }

        return $items;
    }

}
