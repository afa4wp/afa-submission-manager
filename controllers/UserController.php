<?php

namespace Controllers;

use Models\UserModel;

class UserController 
{ 
  private $userModel;
  
  function __construct()
  {
    $this->userModel = new UserModel();
  }

  public function login($request){

    $username = $request['username'];
    $password = $request['password'];
    
    $result = $this->userModel->login($username, $password);

    // retorna o erro se usuario não conseguir logar
    if(!isset($result->data)){
      return rest_ensure_response($result);
    }

    
    return rest_ensure_response($result);

  }
}