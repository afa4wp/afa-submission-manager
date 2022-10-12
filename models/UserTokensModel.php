<?php

namespace Models;

class UserTokensModel
{
    public const DATABASE_NAME = "gra_user_tokens";

    public function __construct()
    {

    }

    /*
     *
     */

    public function checkIfRefreshTokenExist($user_id, $refresh_token)
    {
        global $wpdb;
        $results = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix.SELF::DATABASE_NAME."WHERE user_id = $user_id AND refresh_token = $refresh_token",OBJECT);

        if(count($results) > 0){
            return true;
        } 

        return false;
       
    }

    /*
     *
     */

    public function create($user_id, $access_token, $refresh_token)
    {
        global $wpdb;
        
        $item = array(
            "user_id" =>$user_id,
            "access_token" => $access_token,
            "refresh_token" => $refresh_token
        );
        
        $results = $wpdb->insert(
            $wpdb->prefix.SELF::DATABASE_NAME,
            $item
        );

        return  $results;

    }

    /*
     *
     */

    public function deleteUserTokenByID($user_id)
    {
        global $wpdb;
        
        $item = array(
            "user_id" =>$user_id,
            ) ;
        
        $results = $wpdb->delete(
            $wpdb->prefix.SELF::DATABASE_NAME,
            $item 
        );

        return  $results;
    }


}
