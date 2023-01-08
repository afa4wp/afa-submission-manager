<?php

namespace Models\WPF;

use Plugins\Helpers\FormsShortcodeFinder;
use WP_Query;

class FormModel
{   
    public const TABLE_NAME = "posts";

    private  $post_type ;
    
    public function __construct()
    {
        $this->post_type = "wpforms";
    }

    /**
	 * Get Forms 
     * 
     * @return array
	 */
    public function forms($offset, $number_of_records_per_page)
    {
        $posts =   new WP_Query(array(
            'post_type'      => $this->post_type,
            'posts_per_page' => $number_of_records_per_page,
            'paged'          => $offset,
            'post_status'    => array( 'publish' ),
        ));

        $forms = [];

        while($posts->have_posts()){
           
            $posts->the_post();

            $form['id'] = $posts->post->ID;
            $form['title'] = $posts->post->post_title;
            $form['date_created'] = $posts->post->post_date;
            
            $form['registers'] = wpforms()->entry->get_entries(
                array(
                    'form_id' => $posts->post->ID,
                ),
                true
            );

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
        $results = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix.SELF::TABLE_NAME." WHERE id = $id ",OBJECT);
        
        $forms = [];

        foreach($results as $key => $value){
            
            $form = [];

            $form['id'] = $value->ID;
            $form['title'] = $value->post_title;
            $form['date_created'] = $value->post_date;
            
            $form['registers'] = wpforms()->entry->get_entries(
                array(
                    'form_id' => $value->ID,
                ),
                true
            );

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
        return wp_count_posts('wpforms')->publish ;  
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

        $forms = [];

        while($posts->have_posts()){
           
            $posts->the_post();

            $form['id'] = $posts->post->ID;
            $form['title'] = $posts->post->post_title;
            $form['date_created'] = $posts->post->post_date;
            
            $form['registers'] = wpforms()->entry->get_entries(
                array(
                    'form_id' => $posts->post->ID,
                ),
                true
            );

            $form['user_created'] = $posts->post->post_author;
            $form['perma_links'] = $this->pagesLinks($posts->post->ID);

            $forms[] =  $form;
        }

        return $forms;
    }
}
