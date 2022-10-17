<?php

namespace Models\GF;

class FormModel
{   
    public const DATABASE_NAME = "gf_form";

    public function __construct()
    {}

    /**
	 * Get Forms 
     * 
     * @return WP_User|WP_Error $user WP User object.
	 */
    public function forms()
    {
        global $wpdb;
        $results = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix.SELF::DATABASE_NAME." ",OBJECT);
        
        $forms = [];

        foreach($results as $key => $value){
            
            $form = [];

            $form['id'] = $value->id;
            $form['title'] = $value->title;
            $form['date_created'] = $value->date_created;
            $form['user_created'] = null;

            $forms[] =  $form;
        }

        return $forms;
    }

}
