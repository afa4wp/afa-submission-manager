<?php 

namespace Routes;
use WP_Error;

class PingRoute{

  protected $name; 

  function __construct($name)
  {
    $this->name = $name;
  }

  /*
  *
  */

   function ping(){
    
    register_rest_route(
      $this->name, 
      '/ping',
      array(
        array(
          'methods'  => 'GET',
          'callback' => array( $this,'pingFunc'),
          'permission_callback' => '__return_true'
          ),
      )
    );

  }

  /*
  *
  */


  public function pingFunc(){

    return rest_ensure_response(array(
        'ping'=>'pong'
      ));

  }

  public function initRoutes(){
    $this->ping();
  }

  
}