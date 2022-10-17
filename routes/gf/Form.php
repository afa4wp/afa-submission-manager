<?php

namespace Routes\GF;



class Form
{

    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
	 * get all forms.
	 */
    public function forms()
    {
        register_rest_route(
            $this->name,
            '/gf/forms',
            array(
                array(
                    'methods' => 'GET',
                    'callback' => array($this, 'token'),
                    'permission_callback' => '__return_true',
                ),
            )
        );
    }

    public function token(){
        return rest_ensure_response(array(
            'ping' => 'pong',
        ));
    }
    
    /**
	 * Call all endpoints
	 */
    public function initRoutes()
    {
        $this->forms();
    }


}
