<?php
/**
 * The Form Route Class.
 *
 * @package  claud/afa-submission-manager
 * @since 1.0.0
 */

namespace AFASM\Includes\Routes\WPF;

use AFASM\Includes\Controllers\WPF\AFASM_Form_Controller;
use AFASM\Includes\Routes\AFASM_Abstract_Form_Route;
use AFASM\Includes\Plugins\AFASM_Config;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class Form
 *
 * Init all routes
 *
 * @since 1.0.0
 */
class AFASM_Form extends AFASM_Abstract_Form_Route {

	/**
	 * Get all forms
	 */
	public function forms() {
		register_rest_route(
			$this->name,
			'/wpf/forms',
			array(
				array(
					'methods'             => 'GET',
					'callback'            => array( new AFASM_Form_Controller(), 'forms' ),
					'permission_callback' => array( new AFASM_Config(), 'afa_check_authorization' ),
				),
			)
		);
	}

	/**
	 * Get form by id
	 */
	public function form_by_id() {
		register_rest_route(
			$this->name,
			'/wpf/forms/(?P<id>[0-9]+)',
			array(
				array(
					'methods'             => 'GET',
					'callback'            => array( new AFASM_Form_Controller(), 'form_by_id' ),
					'permission_callback' => array( new AFASM_Config(), 'afa_check_authorization' ),
				),
			)
		);
	}

	/**
	 * Get forms by pagination
	 */
	public function forms_pagination() {
		register_rest_route(
			$this->name,
			'/wpf/forms/page/(?P<page_number>[0-9]+)',
			array(
				array(
					'methods'             => 'GET',
					'callback'            => array( new AFASM_Form_Controller(), 'forms_pagination' ),
					'permission_callback' => array( new AFASM_Config(), 'afa_check_authorization' ),
				),
			)
		);
	}

	/**
	 * Search forms by name
	 */
	public function search_forms() {
		register_rest_route(
			$this->name,
			'/wpf/forms/search/(?P<post_name>\S+)',
			array(
				array(
					'methods'             => 'GET',
					'callback'            => array( new AFASM_Form_Controller(), 'search_forms' ),
					'permission_callback' => array( new AFASM_Config(), 'afa_check_authorization' ),
				),
			)
		);
	}

}
