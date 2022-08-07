<?php 

namespace Schema;



class UserSchema{

  /*
  *
  */
 
  function login(){
    
    $schema = array(

      'username'=>array(
        'required'    => true,
        'type'        => 'string',
        'validate_callback'=> function($value, $request, $key) {
          return true;
        }
      )

    );

    return  $schema;

  }



  
}