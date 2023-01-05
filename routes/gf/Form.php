<?php

namespace Routes\GF;

use Controllers\GF\FormController;


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
	 * get form by id.
	 */
    public function formByID()
    {
        register_rest_route(
            $this->name,
            '/gf/forms/(?P<id>[0-9]+)',
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
            '/gf/forms/page/(?P<page_number>[0-9]+)',
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
	 * search forms by name.
	 */
    public function searchForms()
    {
        register_rest_route(
            $this->name,
            '/gf/forms/search/(?P<post_name>\S+)',
            array(
                array(
                    'methods' => 'GET',
                    'callback' => array(new FormController, 'searchForms'),
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
        $this->searchForms();
    }

}
