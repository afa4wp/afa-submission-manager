<?php

namespace Models\CF7;

use Models\UserModel;
use Models\CF7\FormModel;
class EntryMetaModel
{   
    public const DATABASE_NAME = "gf_entry_meta";

    public function __construct()
    {}

    /**
	 * Get entry_meta by entry ID
     * 
     * @return array
	 */
    public function entryMetaByEntryID($entry_id)
    {    
        $post = new \Flamingo_Inbound_Message( $entry_id );
        if ( empty( $post->channel ) ) {
            return [];
        }

        $form = (new FormModel())->formByChannel($post->channel);

        $form_id = null;
        if (!empty($form)){
            $form_id = $form->ID;
        }

        $items = [];
        
        foreach ( (array) $post->fields as $key => $value ){
            $item = [];

            $item['id'] = null;
            $item['form_id'] = $form_id;
            $item['entry_id'] = $entry_id;
            $item['meta_key'] = null;
            $item['meta_value'] = $value;
            $item['type'] = "text";
            $item['label'] = $key;
            $items[] = $item;
        }

        return $items;
    }

    
}
