<?php

namespace Routes\GF;

use Controllers\GF\FormController;


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
                    'callback' => array(new FormController, 'forms'),
                    'permission_callback' => '__return_true',
                ),
            )
        );
    }

    /**
	 * Call all endpoints
	 */
    public function initRoutes()
    {
        $this->forms();
    }


}
