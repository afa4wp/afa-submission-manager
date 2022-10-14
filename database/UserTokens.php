<?php 

namespace Database;

class UserTokens{

  public const DATABASE_NAME = "gra_user_tokens";
 
  /**
	 * Setup action & filter hooks.
	 */
  public function createTable(){

    require_once(ABSPATH.'wp-admin/includes/upgrade.php');
    global $wpdb;

    // criando a primeira tabela

    $sql = "CREATE TABLE IF NOT EXISTS ".$wpdb->prefix.SELF::DATABASE_NAME." (
        id BIGINT(20) NOT NULL AUTO_INCREMENT,
        user_id BIGINT(20)  UNSIGNED NOT NULL,
        access_token VARCHAR(255) NOT NULL,
        refresh_token VARCHAR(255) NOT NULL,
        PRIMARY KEY(id),
        FOREIGN KEY(user_id) REFERENCES ".$wpdb->prefix."users(ID),
        UNIQUE(access_token),
        UNIQUE(refresh_token)
      )".$wpdb->get_charset_collate();
   
       dbDelta($sql);
    }

}