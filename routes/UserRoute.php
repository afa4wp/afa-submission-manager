<?php 

namespace Routes;
use WP_Error;

use Controllers\UserController;

class UserRoute{

  protected $name; 

  function __construct($name)
  {
    $this->name = $name;
  }

  /*
  *
  */

  function login(){
    
    register_rest_route(
      $this->name, 
      '/user/login',
      array(
        array(
          'methods'  => 'POST',
          'callback' => array(new UserController,'login'),
          'permission_callback' =>  '__return_true',  
          'args' => array(
            'username' => array(
              'required'    => true,
              'type'        => 'string',
              'validate_callback'=> function($value, $request, $key) {
                return true;
              }
            )
          ),
        ),
  
      )
    );

  }

  function user(){
    
    register_rest_route(
      $this->name, 
      '/user',
      array(
        array(
          'methods'  => 'GET',
          'callback' => array(new UserController,'user'),
          'permission_callback' =>  '__return_true'
        ),
  
      )
    );

  }

  



  public function prefix_validate_my_arg( $value, $request, $param ) {
    return new WP_Error( 'rest_invalid_param', sprintf( esc_html__( '%s was not registered as a request argument.', 'my-textdomain' ), $param ), array( 'status' => 400 ) );
    
  }

  /*
  *
  */

  public function initRoutes(){
    $this->login();
    $this->user();
    
  }

  
}