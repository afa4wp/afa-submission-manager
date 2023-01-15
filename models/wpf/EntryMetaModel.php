<?php

namespace Models\WPF;

use Models\UserModel;
use Models\WPF\FormModel;
class EntryMetaModel
{   
    public const TABLE_NAME = "wpforms_entries";

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

    /**
	 * Get entry_meta by entry ID
     * 
     * @return array
	 */
    public function searchEntryMetaAnswer($answer, $offset, $number_of_records_per_page)
    {   
        
        $args = [
			'select'        => 'all',
			'value'         => $answer,
			'value_compare' => "contains",
		];

        $results = wpforms()->get( 'entry_fields' )->get_fields( $args );
        
        $items = [];

        foreach($results as $key => $value){
            
            $meta = $this->getTypeAndLabel($value->entry_id, $value->field_id);

            $item = [];

            $item['id'] = $value->id;
            $item['form_id'] = $value->form_id;
            $item['entry_id'] = $value->entry_id;
            $item['meta_key'] = $value->field_id;
            $item['meta_value'] = $value->value;
            $item['type'] = $meta["type"];
            $item['label'] = $meta["label"];

            $items[] = $item;
   
        }

        return $items;

    }

    /**
	 * Get label and type
     * 
     * @return array
	 */

    private function getTypeAndLabel($entry_id, $meta_key){
        
        $entry = wpforms()->entry->get( $entry_id, [ 'cap' => false ] );
        
        $results = wpforms_decode( $entry->fields );
        
        $item = [];
        $item['type'] = "";
        $item['label'] = "";

        foreach($results as $key => $value){
            
            if($value["id"] == $meta_key){
                $item['type'] = $value["type"];
                $item['label'] = $value["name"];
            }

        }

        return $item;

    }
    
    
}
