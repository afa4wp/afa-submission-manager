<?php

namespace Includes\Schema;

class UserSchema
{
    /**
	 * Create login schema.
	 */
    public function login()
    {
        $schema = array(
            'username' => array(
                'required' => true,
                'type' => 'string',
                'validate_callback' => function ($value, $request, $key) {
                    return true;
                },
            ),
            'password' => array(
                'required' => true,
                'type' => 'string',
            ),
        );
        return $schema;
    }

    /**
	 * Create token schema.
	 */
    public function token()
    {
        $schema = array(
            'refresh_token' => array(
                'required' => true,
                'type' => 'string',
                'validate_callback' => function ($value, $request, $key) {
                    return true;
                },
            ),
        );
        return $schema;
    }
}
