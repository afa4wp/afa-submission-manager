<?php

namespace Models;
class UserTokensModel
{
    public const DATABASE_NAME = "frapi_user_tokens";

    public function __construct()
    {}

    /**
	 * Verify if Refresh token exist
     * 
     * @param string $user_id The user ID 
     * @param string $refresh_token The user refresh token   
     * 
     * @return bool
	 */
    public function checkIfRefreshTokenExist($user_id, $refresh_token)
    {
        global $wpdb; 
        
        $results = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix.SELF::DATABASE_NAME." WHERE user_id = $user_id AND refresh_token = '$refresh_token' ",OBJECT);

        if(count($results) > 0){
            return true;
        } 

        return false;
    }

    /**
	 * Create new token register
     * 
     * @param string $user_id The user ID
     * @param string $access_token The user access token
     * @param string $refresh_token The user refresh token   
     * 
     * @return int|false 
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

     /**
	 * Delete token register
     * 
     * @return int|false 
	 */
    public function deleteUserTokenByID($user_id)
    {
        global $wpdb;
        
        $item = array(
            "user_id" =>$user_id,
        );
        
        $results = $wpdb->delete(
            $wpdb->prefix.SELF::DATABASE_NAME,
            $item 
        );

        return  $results;
    }


}
