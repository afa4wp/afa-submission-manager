<?php

namespace Models\CF7;

use Plugins\Helpers\FormsShortcodeFinder;
use WP_Query;
use Models\CF7\EntryModel;
use Models\FormModel as MainFormModel;
class FormModel extends MainFormModel
{   
    public const TABLE_NAME = "posts";

    public function __construct()
    {
        parent::__construct("wpcf7_contact_form");
    }

    /**
	 * Get Forms 
     * 
     * @return array
	 */
    public function forms($offset, $number_of_records_per_page)
    {
        $posts = parent::forms($offset, $number_of_records_per_page);

        $forms = $this->prepareData($posts);

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
       
        $results = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix.SELF::TABLE_NAME." WHERE id = $id ",OBJECT);
        
        $forms = $this->prepareDataArray($results);

        if(count($forms) > 0){
            return $forms[0];
        }

        return $forms;
    }

    /**
	 * Get number of Forms 
     * 
     * @return int
	 */
    public function mumberItems()
    {   
        global $wpdb;
        $results = $wpdb->get_results("SELECT count(*) as number_of_rows FROM ".$wpdb->prefix.SELF::TABLE_NAME." WHERE post_type = '$this->post_type' AND post_status = 'publish' ");
        $number_of_rows = intval( $results[0]->number_of_rows );
        return $number_of_rows ;    
    }

     /**
	 * Get Forms 
     * 
     * @return int
	 */
    public function mumberItemsByPostTitle($post_title)
    {   
        $posts =   new WP_Query(array(
            'post_type'      => $this->post_type,
            'post_status'    => array( 'publish' ),
            's'              => $post_title
        ));
        
        return  $posts->found_posts;
    }

    /**
	 * Get Form chanel by id
     * 
     * @return string
	 */
    public function formChanelByID($id)
    {   
        global $wpdb;
        $results = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix.SELF::TABLE_NAME." WHERE id = $id ",OBJECT);
        
        if(count($results) > 0){
            return $results[0]->post_name;
        }
        return "";    
    }

     /**
	 * Get Form chanel by id
     * 
     * @return object
	 */
    public function formByChannel($channel)
    {   
        global $wpdb;
        $forms = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix.SELF::TABLE_NAME." WHERE post_name = '$channel' ",OBJECT);
        
        if(count($forms) > 0){
            return $forms[0];
        }

        return $forms;
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
        $pages_with_form = (new FormsShortcodeFinder( $formID ))->cf7Find();
        
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

    /**
	 * Get Forms 
     * 
     * @return array
	 */

    public function searchForms($post_name, $offset, $number_of_records_per_page)
    {
       $posts =   new WP_Query(array(
            'post_type'      => $this->post_type,
            'posts_per_page' => $number_of_records_per_page,
            'paged'          => $offset,
            'post_status'    => array( 'publish' ),
            's'              => $post_name
        ));

        $forms = $this->prepareData($posts);

        return $forms;
    }
    
    /**
	 * Format Forms 
     * 
     * @return array
	 */
    private function prepareData($posts)
    { 
        $forms = [];

        while($posts->have_posts()){
           
            $posts->the_post();

            $form['id'] = $posts->post->ID;
            $form['title'] = $posts->post->post_title;
            $form['date_created'] = $posts->post->post_date; 
            $form['registers'] = (new EntryModel())->mumberItemsByChannel($posts->post->post_name);

            $form['user_created'] = $posts->post->post_author;
            $form['perma_links'] = $this->pagesLinks($posts->post->ID);
            $forms[] =  $form;
        }

        return $forms;
    }

    /**
	 * Format Forms 
     * 
     * @return array
	 */
    private function prepareDataArray($results)
    { 
        $forms = [];

        foreach($results as $key => $value){
            
            $form = [];

            $form['id'] = $value->ID;
            $form['title'] = $value->post_title;
            $form['date_created'] = $value->post_date;
            
            $form['registers'] = (new EntryModel())->mumberItemsByChannel($value->post_name);

            $form['user_created'] = $value->post_author;
            $form['perma_links'] = $this->pagesLinks($value->ID);

            $forms[] =  $form;
        }

        return $forms;

    }
}
