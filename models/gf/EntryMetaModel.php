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

        $entry = \GFAPI::get_entry($entry_id);

        $form_id = $entry['form_id'];
        
        $form  =  \GFAPI::get_form( $form_id );

        $items = [];

        foreach($form["fields"] as $key => $value){
            
            $item = [];

            $item['id'] = null;
            $item['form_id'] = $form_id;
            $item['entry_id'] = $entry_id;
            $item['meta_key'] = $value->id;
            $item['meta_value'] = $entry[$value->id];
            $item['type'] = $value->type;
            $item['label'] = $value->label;

            $items[] = $item;
        }

        return $items;
    }

    /**
	 * Get entry_meta by entry ID
     * 
     * @return array
	 */
    public function searchEntryMetaAnswer($answer)
    {   
       
    }
    
}
