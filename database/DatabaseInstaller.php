<?php 

namespace Database;

use Database\UserTokens;



class DatabaseInstaller{

  /*
  *
  */

  public function install(){

    // create users_tokens_table
    (new UserTokens())->createTable();
 
  }



  
}