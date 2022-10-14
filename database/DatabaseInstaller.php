<?php 

namespace Database;

use Database\UserTokens;

class DatabaseInstaller{

  /**
	 * Setup action & filter hooks.
	 */
  public function install(){
    (new UserTokens())->createTable();
  }
  
}