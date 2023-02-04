<?php 

namespace Includes\Database;

use Includes\Database\UserTokens;

class DatabaseInstaller{

  /**
	 * Create tables.
	 */
  public function install(){
    (new UserTokens())->createTable();

    $this->createSecretKeyIfIsNotDefined();
  }

  public function createSecretKeyIfIsNotDefined(){
    
    if (!defined('WP_AFA_ACCESS_TOKEN_SECRET_KEY') || empty(WP_AFA_ACCESS_TOKEN_SECRET_KEY)) {
      add_option('WP_AFA_ACCESS_TOKEN_SECRET_KEY', base64_encode(openssl_random_pseudo_bytes(30)), '', false);
    }

    if (!defined('WP_AFA_REFRESH_TOKEN_SECRET_KEY') || empty(WP_AFA_REFRESH_TOKEN_SECRET_KEY)) {
      add_option('WP_AFA_REFRESH_TOKEN_SECRET_KEY', base64_encode(openssl_random_pseudo_bytes(30)), '', false); 
    }

  }
  
}