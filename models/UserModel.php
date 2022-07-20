<?php 

namespace Models;

class UserModel{

  function __construct(){
   
  }

  /*
  *
  */

   public function login($username, $password){
    
        $login  = wp_signon(array(
                'user_login'=>$username,
                'user_password'=>$password
        ));

        return $login;
    
   }

}
