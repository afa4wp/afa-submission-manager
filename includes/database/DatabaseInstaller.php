<?php 

namespace Includes\Database;

use Includes\Database\UserTokens;

class DatabaseInstaller{

  /**
	 * Create tables.
	 */
  public function install(){
    (new UserTokens())->createTable();
  }
  
}