<?php

namespace Models;

use WP_Query;

class FormModel
{   
    public const TABLE_NAME = "posts";
    
    public  $post_type ;

    public function __construct($post_type)
    {
        $this->post_type = $post_type;
    }

    /**
	 * Get Forms 
     * 
     * @return object
	 */
    public function forms($offset, $number_of_records_per_page)
    {
        $posts =   new WP_Query(array(
            'post_type'      => $this->post_type,
            'posts_per_page' => $number_of_records_per_page,
            'paged'          => $offset,
            'post_status'    => array( 'publish' ),
        ));

        return $posts;
    }

    /**
	 * Get Forms 
     * 
     * @return array
	 */

     public function searchForms($post_title, $offset, $number_of_records_per_page)
     {
        $posts =   new WP_Query(array(
             'post_type'      => $this->post_type,
             'posts_per_page' => $number_of_records_per_page,
             'paged'          => $offset,
             'post_status'    => array( 'publish' ),
             's'              => $post_title
         ));
 
         return $posts;
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

}
