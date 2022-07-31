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
    
    $user = $this->userModel->login($username, $password);

    // retorna o erro se usuario não conseguir logar
    if(is_wp_error($user)){
      return rest_ensure_response($user);
    }

    $token = $this->JWTPlugin->generateToken($user->data->ID);
    
    $data = array(
      'token' => $token,
      'id' => $user->data->ID,
      'user_email' => $user->data->user_email,
      'user_nicename' => $user->data->user_nicename,
      'user_display_name' => $user->data->display_name
    );
    
    //return rest_ensure_response($result);
    return rest_ensure_response($data);
  }

  public function user($request){

   
    //return rest_ensure_response($result);
    return rest_ensure_response('ola');
  }
}