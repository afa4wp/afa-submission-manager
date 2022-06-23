<?php 

namespace Routes;

class UserRoute{

  /*
  *
  */

   function getUser($name_space){
    
    register_rest_route(
      $name_space, 
      '/user',
      array(
        'methods'  => 'GET',
        'callback' => array($this,'daina'),
        'permission_callback' => '__return_true'
      )
    );

  
  }

  function daina(){
    return rest_ensure_response(array(
      'ping'=>'pong'
    ));
  }


}