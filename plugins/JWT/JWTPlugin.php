<?php

namespace Plugins\JWT;

use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Plugins\PublicRoute;
use WP_Error;

class JWTPlugin
{
    private $nameSpace;

    public function __construct()
    {
        $this->nameSpace = $_ENV['API_NAME_SPACE'];
    }

    /**
	 * Setup action & filter hooks.
	 */
    public function generateToken($id)
    {
        $issuedAt = time();
        $expTokenInMinute = $_ENV['ACCESS_EXP_TOKEN_IN_MINUTE'];
        
        if(empty($expTokenInMinute) || !is_numeric($expTokenInMinute)){
            $expTokenInMinute = 15;
        } 

        $expire = $issuedAt + (MINUTE_IN_SECONDS * $expTokenInMinute);

        $key = $_ENV['ACCESS_TOKEN_KEY'];
        
        $payload = array(
            'iss' => get_bloginfo('url'),
            'iat' => $issuedAt,
            'id' => $id,
            'exp' => $expire,
        );

        $jwt = JWT::encode($payload, $key, 'HS256');

        return $jwt;
    }

    /**
	 * Setup action & filter hooks.
	 */
    public function generateRefreshToken($id)
    {
        $issuedAt = time();
        $expTokenInMinute = $_ENV['REFRESH_EXP_TOKEN_IN_MINUTE'];
        
        if(empty($expTokenInMinute) || !is_numeric($expTokenInMinute)){
            $expTokenInMinute = 15;
        } 

        $expire = $issuedAt + (MINUTE_IN_SECONDS * $expTokenInMinute);

        $key = $_ENV['REFRESH_TOKEN_KEY'];
        
        $payload = array(
            'iss' => get_bloginfo('url'),
            'iat' => $issuedAt,
            'id' => $id,
            'exp' => $expire,
        );

        $jwt = JWT::encode($payload, $key, 'HS256');

        return $jwt;
    }

    /**
	 * Setup action & filter hooks.
	 */
    private function validateToken($url, $server, $request)
    {
        $authorization = $request->get_header('authorization');
        $url = strtok($_SERVER["REQUEST_URI"], '?');

        if (!empty($authorization)) {

            $key = $_ENV['ACCESS_TOKEN_KEY'];
            $splitAuthorization = explode(' ', $authorization);

            if (count($splitAuthorization) == 2) {
                try {

                    $jwt = $splitAuthorization[1];
                    //$decoded = JWT::decode($jwt, $key, array("HS256"));
                    $decoded = JWT::decode($jwt, new Key($key, 'HS256'));
                    wp_set_current_user($decoded->id);
                    return $request;
                } catch (Exception $e) {

                    return new WP_Error(
                        'jwt_auth_invalid_token',
                        $e->getMessage(),
                        array(
                            'status' => 403,
                        )
                    );
                }
            } else {
                return new WP_Error(
                    'jwt_auth_invalid_token',
                    'Incorrect JWT format',
                    array(
                        'status' => 403,
                    )
                );
            }
        } else {
            return new WP_Error('not-logged-in', 'API Requests to ' . $url . ' are only supported for authenticated requests', array('status' => 401));
        }
    }

    /**
	 * Setup action & filter hooks.
	 */
    public function validateRefreshToken($jwt)
    {
        try {
            //$decoded = JWT::decode($jwt, $key, array("HS256"))
            $key = $_ENV['REFRESH_TOKEN_KEY'];
            $decoded = JWT::decode($jwt, new Key($key, 'HS256'));
            return $decoded;
        } catch (Exception $e) {

            return new WP_Error(
                'jwt_auth_invalid_token',
                $e->getMessage(),
                array(
                    'status' => 403,
                )
            );
        }
    }

    /**
	 * Filter to hook the rest_pre_dispatch, if there is an error in the request
	 * send it, if there is no error just continue with the current request.
	 *
	 * @param mixed           $result Can be anything a normal endpoint can return, or null to not hijack the request..
	 * @param WP_REST_Server  $server Server instance.
	 * @param WP_REST_Request $request The request.
	 *
	 * @return array $payload The modified token's payload.
	 */
    public function validateTokenRestPreDispatch($url, $server, $request)
    {
        $url = $request->get_route(); 

        $explodeNameSpace = explode('/', $this->nameSpace);
        
        if(count($explodeNameSpace) == 2){
            
            if (strpos($url, $explodeNameSpace[0]) !== false) {

                $publicRoute = new PublicRoute($this->nameSpace);

                $requireToken = !$publicRoute->isPublicRoute(substr($url, 1));

                if ($requireToken) {
                    $response = $this->validateToken($url, $server, $request);
                    if (is_wp_error($response)) {
                        return $response;
                    }
                }

            }
        }
    }
}
