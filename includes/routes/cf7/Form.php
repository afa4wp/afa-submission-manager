<?php
/**
 * The Form Route Class.
 *
 * @package  WP_All_Forms_API
 * @since 1.0.0
 */

namespace Includes\Routes\CF7;

use Includes\Controllers\CF7\FormController;
use Includes\Routes\AbstractFormRoute;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Class Form
 *
 * Init all routes
 *
 * @since 1.0.0
 */
class Form extends AbstractFormRoute {

	/**
	 * Get form by id
	 */
	public function forms() {
		register_rest_route(
			$this->name,
			'/cf7/forms/',
			array(
				array(
					'methods'             => 'GET',
					'callback'            => array( new FormController(), 'forms' ),
					'permission_callback' => '__return_true',
				),
			)
		);
	}

	/**
	 * Get all forms
	 */
	public function forms_by_id() {
		register_rest_route(
			$this->name,
			'/cf7/forms/(?P<id>[0-9]+)',
			array(
				array(
					'methods'             => 'GET',
					'callback'            => array( new FormController(), 'formByID' ),
					'permission_callback' => '__return_true',
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
			'/cf7/forms/page/(?P<page_number>[0-9]+)',
			array(
				array(
					'methods'             => 'GET',
					'callback'            => array( new FormController(), 'formsPagination' ),
					'permission_callback' => '__return_true',
				),
			)
		);
	}

	/**
	 * Search forms by name.
	 */
	public function search_forms() {
		register_rest_route(
			$this->name,
			'/cf7/forms/search/(?P<post_name>\S+)',
			array(
				array(
					'methods'             => 'GET',
					'callback'            => array( new FormController(), 'searchForms' ),
					'permission_callback' => '__return_true',
				),
			)
		);
	}
}
