<?php

namespace Models\WEF;

use Plugins\Helpers\FormsShortcodeFinder;
use WP_Query;
use Models\WEF\EntryModel;
class FormModel
{   
    public const DATABASE_NAME = "posts";

    public function __construct()
    {}

    /**
	 * Get Forms 
     * 
     * @return array
	 */
    public function forms($offset, $number_of_records_per_page)
    {
        $posts =   new WP_Query(array(
            'post_type'=>'wpuf_contact_form',
            'posts_per_page' =>$number_of_records_per_page,
            'paged'=>$offset,
            'post_status'            => array( 'publish' ),
        ));

        $forms = [];

        while($posts->have_posts()){
           
            $posts->the_post();

            $form['id'] = $posts->post->ID;
            $form['title'] = $posts->post->post_title;
            $form['date_created'] = $posts->post->post_date;
            
            $form['registers'] = (new EntryModel())->mumberItemsByFormID($posts->post->ID);

            $form['user_created'] = $posts->post->post_author;
            $form['perma_links'] = $this->pagesLinks($posts->post->ID);

            $forms[] =  $form;
        }

        return $forms;
    }

    /**
	 * Get Form by id 
     * 
     * @param int     $id The form ID.
     * 
     * @return array
	 */
    public function formByID($id)
    {
        global $wpdb;
        $results = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix.SELF::DATABASE_NAME." WHERE id = $id ",OBJECT);
        
        $forms = [];

        foreach($results as $key => $value){
            
            $form = [];

            $form['id'] = $value->ID;
            $form['title'] = $value->post_title;
            $form['date_created'] = $value->post_date;
            
            $form['registers'] = (new EntryModel())->mumberItemsByFormID($value->ID);

            $form['user_created'] = $value->post_author;
            $form['perma_links'] = $this->pagesLinks($value->ID);

            $forms[] =  $form;
        }

        if(count($forms) > 0){
            return $forms[0];
        }

        return $forms;
    }

    /**
	 * Get Forms 
     * 
     * @return int
	 */
    public function mumberItems()
    {   
        global $wpdb;
        $results = $wpdb->get_results("SELECT count(*) as number_of_rows FROM ".$wpdb->prefix.SELF::DATABASE_NAME." WHERE post_type = 'wpuf_contact_form' AND post_status = 'publish' ");
        $number_of_rows = intval( $results[0]->number_of_rows );
        return $number_of_rows ;    
    }

     /**
	 * Get form pages links  
     * 
     * @param int     $formID The form ID.
     * 
     * @return array
	 */
    public function pagesLinks($formID)
    {
        $pages_with_form = (new FormsShortcodeFinder( $formID ))->wefFind();
        
        if(empty($pages_with_form)){
            return $pages_with_form;
        }

        $results = [];

        foreach ($pages_with_form as $key => $value) {
            $result = [];
            $result['page_name'] = $value;
            $result['page_link'] = get_page_link($key);
            $results = $result;
        }

        return $results;
    }
}
