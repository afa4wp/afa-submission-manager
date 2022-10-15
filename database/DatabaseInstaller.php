<?php 

namespace Database;

use Database\UserTokens;

class DatabaseInstaller{

  /**
	 * Create tables.
	 */
  public function install(){
    (new UserTokens())->createTable();
  }
  
}