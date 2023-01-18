<?php

namespace Models\CF7;

use Models\UserModel;
use Models\CF7\FormModel;
class EntryModel
{   
    public const TABLE_NAME = "posts";

    private $post_type_entry ;

    public function __construct()
    {
        $this->post_type_entry = "flamingo_inbound";
    }

    /**
	 * Get Forms entries
     * 
     * @return array
	 */
    public function entries($offset, $number_of_records_per_page)
    {
        $results = \Flamingo_Inbound_Message::find( [] );
        
        $entries = $this->prepareData($results);

        return $entries;
    }

    /**
	 * Get Forms entry by id
     * 
     * @return object
	 */
    public function entryByID($entry_id)
    {   
        $post = new \Flamingo_Inbound_Message( $entry_id );
        
        $results = [];

        if (empty($post->channel)){
            return $results;
        }

        $results[] = $post;
        
        $entries = $this->prepareData($results);

        if (empty($entries)){
            return [];
        }
        
        return $entries[0];
    }

    /**
	 * Get Forms entries by form_id
     * 
     * @return array
	 */
    public function entriesByFormID($form_id, $offset, $number_of_records_per_page)
    {   
        global $wpdb;

        $form_model = new FormModel();
        $channel = $form_model->formChanelByID($form_id);
        
        $results = \Flamingo_Inbound_Message::find( 
            [
                'channel' => $channel,
                'posts_per_page' => $number_of_records_per_page,
                'offset' =>$offset
            ] 
        );

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
     
        $results = $wpdb->get_results("SELECT fla.ID, fla.post_type FROM ".$wpdb->prefix.SELF::TABLE_NAME." fla INNER JOIN ".$wpdb->prefix."users wpu ON  
        fla.post_author = wpu.id WHERE fla.post_type ='$this->post_type_entry' AND ( wpu.user_login LIKE '%$user_info%' OR wpu.user_email LIKE '%$user_info%' ) ORDER BY fla.id DESC LIMIT ".$offset.",".$number_of_records_per_page, OBJECT); 
        
        $entries = [];

        foreach($results as $key => $value){
            $entries[] = $this->entryByID($value->ID);
        }

        return $entries;
    }

    /**
	 * Get Forms 
     * 
     * @return int
	 */
    public function mumberItems()
    {
        global $wpdb;
        
        $results = $wpdb->get_results("SELECT count(*)  as number_of_rows FROM ".$wpdb->prefix.SELF::TABLE_NAME." WHERE post_type='$this->post_type_entry' ");
        
        $number_of_rows = intval( $results[0]->number_of_rows );
        
        return $number_of_rows ;  
    }

    public function mumberItemsByUserInfo($user_info)
    {
        global $wpdb;
     
        $results = $wpdb->get_results("SELECT count(*)  as number_of_rows FROM ".$wpdb->prefix.SELF::TABLE_NAME." fla INNER JOIN ".$wpdb->prefix."users wpu ON  
        fla.post_author = wpu.id WHERE fla.post_type ='$this->post_type_entry' AND ( wpu.user_login LIKE '%$user_info%' OR wpu.user_email LIKE '%$user_info%' ) ", OBJECT); 
        
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
	 * Get Forms entries
     * 
     * @return array
	 */
    private function prepareData($results)
    { 
        $entries = [];

        foreach($results as $key => $value){

            $form_model = new FormModel();
            $post = $form_model->formByChannel($value->channel);
            $flamingo_post = get_post($value->id());

            $entry = [];

            $entry['id'] = $value->id();
            $entry['form_id'] = $value->meta['post_id']; // form_id esta diferente do form_info->form_id corrigir
            $entry['date_created'] = "";
            $entry['created_by']  = "";
            $entry['author_info'] = (object)[];
            $entry['form_info'] = (object)[];

            if ( $post ) {
                $entry['date_created'] = $flamingo_post->post_date;
            }
            
            $user = get_user_by('ID', $flamingo_post->post_author);
            
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

}
