<?php

namespace Models\GF;

use Models\UserModel;
use Models\GF\FormModel;
class EntryMetaModel
{   
    public const TABLE_NAME = "gf_entry_meta";

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
        $results = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix.SELF::TABLE_NAME." WHERE entry_id = $entry_id",OBJECT);
        
        $items = [];

        foreach($results as $key => $value){
            
            $item = [];

            $item['id'] = $value->id;
            $item['form_id'] = $value->form_id;
            $item['entry_id'] = $value->entry_id;
            $item['meta_key'] = $value->meta_key;
            $item['meta_value'] = $value->meta_value;

            $item['type'] = "";
            $item['label'] = "";
            
            $field = \GFAPI::get_field($value->form_id, $value->meta_key);
            if (!empty($field)){
                if (isset($field->type)){
                    $item['type'] = $field->type;
                }
                if (isset($field->label)){
                    $item['label'] = $field->label;
                }
            }

            $items[] = $item;
   
        }

        return $items;
    }

    
}
