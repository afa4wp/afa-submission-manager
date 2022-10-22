<?php

namespace Models\WPF;

use Models\UserModel;
use Models\WPF\FormModel;
class EntryMetaModel
{   
    public const DATABASE_NAME = "wpforms_entries";

    public function __construct()
    {}

    /**
	 * Get entry_meta by entry ID
     * 
     * @return array
	 */
    public function entryMetaByEntryID($entry_id)
    {
        $entry = wpforms()->entry->get( $entry_id, [ 'cap' => false ] );
        $results = wpforms_decode( $entry->fields );
        
        $items = [];

        foreach($results as $key => $value){
            
            $item = [];

            $item['id'] = $key;
            $item['form_id'] = $entry->form_id;
            $item['entry_id'] = $entry->entry_id;
            $item['meta_key'] = $value["id"];
            $item['meta_value'] = $value["value"];

            $item['type'] = $value["type"];
            $item['label'] = $value["name"];

            $items[] = $item;
   
        }

        return $items;
    }

    
}
