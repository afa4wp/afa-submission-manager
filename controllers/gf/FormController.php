<?php

namespace Controllers\GF;

use Models\GF\FormModel;
use WP_Error;

class FormController
{   
    private $formModel;
    public function __construct()
    {
        $this->formModel = new FormModel();
    }

    /**
     * GF forms.
     *
     * @param WP_REST_Request $request The request.
     *
     * @return WP_User|WP_Error $user WP User with tokens info
     */
    public function forms()
    {
        //$forms = \GFAPI::get_forms();
        $forms =  $this->formModel->forms();
        return rest_ensure_response($forms);
    }
}
