<?php 

namespace Routes;

use Controllers\UserController;

class UserRoute{

  private $nameSpace; 

  function __construct($nameSpace)
  {
    $this->nameSpace = $nameSpace;
  }

  /*
  *
  */

   function login(){
    
    register_rest_route(
      $this->nameSpace, 
      '/user',
      array(
        'methods'  => 'GET',
        'callback' => array(new UserController,'login'),
        'permission_callback' => '__return_true'
      )
    );

  }

  /*
  *
  */

  public function initRoutes(){
    $this->login();
  }

  
}