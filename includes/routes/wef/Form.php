<?php
/**
 * The Form Route Class.
 *
 * @package  WP_All_Forms_API
 * @since 1.0.0
 */

namespace Includes\Routes\WEF;

use Includes\Controllers\WEF\FormController;
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
	 * Get all forms.
	 */
	public function forms() {
		register_rest_route(
			$this->name,
			'/wef/forms',
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
	 * Get form by id.
	 */
	public function form_by_id() {
		register_rest_route(
			$this->name,
			'/wef/forms/(?P<id>[0-9]+)',
			array(
				array(
					'methods'             => 'GET',
					'callback'            => array( new FormController(), 'form_by_id' ),
					'permission_callback' => '__return_true',
				),
			)
		);
	}

	/**
	 * Get forms by pagination.
	 */
	public function forms_pagination() {
		register_rest_route(
			$this->name,
			'/wef/forms/page/(?P<page_number>[0-9]+)',
			array(
				array(
					'methods'             => 'GET',
					'callback'            => array( new FormController(), 'forms_pagination' ),
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
			'/wef/forms/search/(?P<post_name>\S+)',
			array(
				array(
					'methods'             => 'GET',
					'callback'            => array( new FormController(), 'search_forms' ),
					'permission_callback' => '__return_true',
				),
			)
		);
	}

}
