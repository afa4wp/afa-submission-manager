<?php

namespace Controllers;

use Models\UserModel;

use Plugins\JWT\JWTPlugin;

class UserController 
{ 
  private $userModel;

  private $JWTPlugin;
  
  function __construct()
  {
    $this->userModel = new UserModel();
    $this->JWTPlugin = new JWTPlugin();
  }

  public function login($request){

    $username = $request['username'];
    $password = $request['password'];
    
    $result = $this->userModel->login($username, $password);

    // retorna o erro se usuario não conseguir logar
    if(!isset($result->data)){
      return rest_ensure_response($result);
    }

    
    //return rest_ensure_response($result);
    return rest_ensure_response( $this->JWTPlugin->generateToken());
  }
}