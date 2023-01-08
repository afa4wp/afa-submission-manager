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

     public function searchForms($post_name, $offset, $number_of_records_per_page)
     {
        $posts =   new WP_Query(array(
             'post_type'      => $this->post_type,
             'posts_per_page' => $number_of_records_per_page,
             'paged'          => $offset,
             'post_status'    => array( 'publish' ),
             's'              => $post_name
         ));
 
         return $posts;
     }
    
}
