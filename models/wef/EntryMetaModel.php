<?php

namespace Models\WEF;

use Models\UserModel;
use Models\WEF\FormModel;
class EntryMetaModel
{   
    public const DATABASE_NAME = "weforms_entrymeta";

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
        $results = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix.SELF::DATABASE_NAME." WHERE weforms_entry_id = $entry_id",OBJECT);
        
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

    
}
