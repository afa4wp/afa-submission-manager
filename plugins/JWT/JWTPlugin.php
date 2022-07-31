<?php

namespace Plugins\JWT;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use WP_Error;

class JWTPlugin 
{ 
    

    public function generateToken($id){

        $issuedAt = time();
        $expire = $issuedAt + (MINUTE_IN_SECONDS * 7);

        $key = 'example_key';

        $payload = array(
            'iss' => get_bloginfo('url'),
            'iat' => $issuedAt,
            'id' =>$id,
            'exp' => $expire, 
        );

        $jwt = JWT::encode($payload, $key, 'HS256');

        return $jwt ;
    }

    public function validateTokenRestPreDispatch($url, $server, $request){
        
        $authorization = $request->get_header('authorization');

        $url = strtok($_SERVER["REQUEST_URI"],'?');

        if(!empty($authorization)){
            
            $key = 'example_key';
            $splitAuthorization =  explode(' ',$authorization);

            if(count($splitAuthorization) == 2){
                $jwt = $splitAuthorization[1];
                $decoded = JWT::decode($jwt, new Key($key, 'HS256'));

                return $decoded ;
            } 
           
        }

        return new WP_Error( 'not-logged-in', 'API Requests to '.$url.' are only supported for authenticated requests', array( 'status' => 401 ) );
        
    }
}