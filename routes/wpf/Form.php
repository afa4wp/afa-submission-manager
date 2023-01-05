<?php

namespace Routes\WPF;

use Controllers\WPF\FormController;


class Form
{
    private $name;
    
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
            '/wpf/forms',
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
	 * get form by id.
	 */
    public function formByID()
    {
        register_rest_route(
            $this->name,
            '/wpf/forms/(?P<id>[0-9]+)',
            array(
                array(
                    'methods' => 'GET',
                    'callback' => array(new FormController, 'formByID'),
                    'permission_callback' => '__return_true',
                ),
            )
        );
    }

    /**
	 * get forms by pagination.
	 */
    public function formsPagination()
    {
        register_rest_route(
            $this->name,
            '/wpf/forms/page/(?P<page_number>[0-9]+)',
            array(
                array(
                    'methods' => 'GET',
                    'callback' => array(new FormController, 'formsPagination'),
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
        $this->formByID();
        $this->forms();
        $this->formsPagination();
    }

}
