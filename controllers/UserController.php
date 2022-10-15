<?php

namespace Controllers;

use Models\UserModel;
use Models\UserTokensModel;
use Plugins\JWT\JWTPlugin;
use WP_Error;
class UserController
{
    private $userModel;

    private $JWTPlugin;

    private $userTokensModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->JWTPlugin = new JWTPlugin();
        $this->userTokensModel = new UserTokensModel();
    }

    /**
	 * Setup action & filter hooks.
	 */
    public function login($request)
    {
        $username = $request['username'];
        $password = $request['password'];

        $user = $this->userModel->login($username, $password);

        // retorna o erro se usuario não conseguir logar
        if (is_wp_error($user)) {
            return rest_ensure_response($user);
        }

        $this->userTokensModel->deleteUserTokenByID($user->data->ID);

        $access_token = $this->JWTPlugin->generateToken($user->data->ID);
        $access_refresh_token = $this->JWTPlugin->generateRefreshToken($user->data->ID);

        $this->userTokensModel->create($user->data->ID, $access_token, $access_refresh_token);

        $data = array(
            'access_token' => $access_token,
            'refresh_token' => $access_refresh_token,
            'id' => $user->data->ID,
            'user_email' => $user->data->user_email,
            'user_nicename' => $user->data->user_nicename,
            'user_display_name' => $user->data->display_name,
        );
        return rest_ensure_response($data);
    }

    /**
     * Decodes a JWT string into a PHP object.
     * if sucess force user login and keep on
     *
     * @param WP_REST_Request $request The request.
     *
     * @return array $decoded The token's payload.
     */
    public function user($request)
    {
        return rest_ensure_response($this->userModel->user());
    }

    /**
     * Decodes a JWT string into a PHP object.
     * if sucess force user login and keep on
     *
     * @param WP_REST_Request $request The request.
     *
     * @return array $data The info with user id, acess token and  refresh token.
     */
    public function token($request)
    {
        $refresh_token = $request['refresh_token'];
        $validate = $this->JWTPlugin->validateRefreshToken($refresh_token);
        
        if (is_wp_error($validate)) {
            return rest_ensure_response($validate);
        }
        
        $user_id = $validate->id;
        $check_resfresh_token = $this->userTokensModel->checkIfRefreshTokenExist($user_id,  $refresh_token);
        
        if(!$check_resfresh_token){
            return new WP_Error(
                'jwt_auth_invalid_token',
                "Refresh token not found",
                array(
                    'status' => 403,
                )
            );
        }
        
        $this->userTokensModel->deleteUserTokenByID($user_id);

        $access_token = $this->JWTPlugin->generateToken($user_id);
        $access_refresh_token = $this->JWTPlugin->generateRefreshToken($user_id);

        $this->userTokensModel->create($user_id, $access_token, $access_refresh_token);

        $data = array(
            'access_token' => $access_token,
            'refresh_token' => $access_refresh_token,
            'id' => $user_id,
        );

        return rest_ensure_response($data);
    }
}
