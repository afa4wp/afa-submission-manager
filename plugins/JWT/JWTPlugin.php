<?php

namespace Plugins\JWT;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTPlugin 
{ 
  

    public function generateToken($id){

        $issuedAt = time();
       
        $key = 'example_key';

        $payload = array(
            'iss' => get_bloginfo('url'),
            'iat' => $issuedAt,
            'id' =>$id 
        );

        $jwt = JWT::encode($payload, $key, 'HS256');

        return $jwt ;
    }
}