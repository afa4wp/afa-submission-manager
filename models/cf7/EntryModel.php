<?php

namespace Models\CF7;

use Models\UserModel;
use Models\CF7\FormModel;
class EntryModel
{   
    public const DATABASE_NAME = "weforms_entries";

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
        $results = \Flamingo_Inbound_Message::find( [] );
        
        $entries = [];
        //return $results;
        foreach($results as $key => $value){

            $form_model = new FormModel();
            $post = $form_model->formByChannel($value->channel);

            $entry = [];

            $entry['id'] = $value->id();
            $entry['form_id'] = $value->meta['post_id'];
            $entry['date_created'] = "";
            $entry['created_by']  = "";
            $entry['author_info'] = [];
            $entry['form_info'] = [];

            if ( $post ) {
                $entry['date_created'] = $post->post_date;
            }
            
            $user = get_user_by_email( $value->from_email );
            
            if($user){
                $user_model = new UserModel();
                $entry['created_by'] = $user->ID;
                $entry['author_info'] = $user_model->userInfoByID($user->ID);
            }

            if ( $post ) {
                $entry['form_info'] = $form_model->formByID($post->ID);
            }
            
            $entries[] =  $entry;
        }

        return $entries;
    }

    /**
	 * Get Forms entry by id
     * 
     * @return object
	 */
    public function entryByID($entry_id)
    {
        global $wpdb;
        $post = new \Flamingo_Inbound_Message( $entry_id );
        $results = [];

        if (empty($post->channel)){
            return $results;
        }

        $results[] = $post;

        $results = \Flamingo_Inbound_Message::find( [] );
        
        $entries = [];

        foreach($results as $key => $value){

            $form_model = new FormModel();
            $post = $form_model->formByChannel($value->channel);

            $entry = [];

            $entry['id'] = $value->id();
            $entry['form_id'] = $value->meta['post_id'];
            $entry['date_created'] = "";
            $entry['created_by']  = "";
            $entry['author_info'] = [];
            $entry['form_info'] = [];

            if ( $post ) {
                $entry['date_created'] = $post->post_date;
            }
            
            $user = get_user_by_email( $value->from_email );
            
            if($user){
                $user_model = new UserModel();
                $entry['created_by'] = $user->ID;
                $entry['author_info'] = $user_model->userInfoByID($user->ID);
            }

            if ( $post ) {
                $entry['form_info'] = $form_model->formByID($post->ID);
            }
            
            $entries[] =  $entry;
        }

        return $entries[0];
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

    /**
	 * Get Forms 
     * 
     * @return int
	 */
    public function mumberItemsByChannel($channel)
    {
        $args = ['channel' =>$channel ];
        $total_items = \Flamingo_Inbound_Message::count($args); 
        return $total_items; 
    }

    /**
	 * Get Forms 
     * 
     * @return int
	 */
    public function mumberItemsByFormID($form_id)
    {
        global $wpdb;
        $results = $wpdb->get_results("SELECT count(*)  as number_of_rows FROM ".$wpdb->prefix.SELF::DATABASE_NAME." WHERE form_id = $form_id ");
        $number_of_rows = intval( $results[0]->number_of_rows );
        return $number_of_rows ;  
    }
}
