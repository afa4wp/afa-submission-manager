<?php

namespace Controllers;

class UserController 
{
  
  public function login($request){

    $username = $request['username'];
    $password = $request['password'];
    
    return rest_ensure_response($request['username']);

  }
}