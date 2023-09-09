<?php
/**
 * The Form Route Class.
 *
 * @package  WP_All_Forms_API
 * @since 1.0.0
 */

namespace Includes\Routes\EFB;

use Includes\Controllers\EFB\FormController;
use Includes\Routes\AbstractFormRoute;
use Includes\Plugins\Config;

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
	 * Get all forms
	 */
	public function forms() {
		register_rest_route(
			$this->name,
			'/efb/forms/',
			array(
				array(
					'methods'             => 'GET',
					'callback'            => array( new FormController(), 'forms' ),
					'permission_callback' => array( new Config(), 'wp_afa_check_authorization' ),
				),
			)
		);
	}

	/**
	 * Get forms by id
	 */
	public function form_by_id() {
		register_rest_route(
			$this->name,
			'/efb/forms/(?P<id>[0-9]+)',
			array(
				array(
					'methods'             => 'GET',
					'callback'            => array( new FormController(), 'form_by_id' ),
					'permission_callback' => array( new Config(), 'wp_afa_check_authorization' ),
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
			'/efb/forms/page/(?P<page_number>[0-9]+)',
			array(
				array(
					'methods'             => 'GET',
					'callback'            => array( new FormController(), 'forms_pagination' ),
					'permission_callback' => array( new Config(), 'wp_afa_check_authorization' ),
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
			'/efb/forms/search/(?P<post_name>\S+)',
			array(
				array(
					'methods'             => 'GET',
					'callback'            => array( new FormController(), 'search_forms' ),
					'permission_callback' => array( new Config(), 'wp_afa_check_authorization' ),
				),
			)
		);
	}
}
