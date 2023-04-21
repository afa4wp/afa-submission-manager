<?php
/**
 * The Abstarct Form Controllers Class.
 *
 * @package  WP_All_Forms_API
 * @since 1.0.0
 */

namespace Includes\Controllers;

use Includes\Plugins\Helpers\Pagination;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Class AbstractFormControllers
 *
 * Init all routes
 *
 * @since 1.0.0
 */
abstract class AbstractFormControllers {

	/**
	 * The number of items per page
	 *
	 * @var string
	 */
	public $number_of_records_per_page;

	/**
	 * The route name space
	 *
	 * @var Pagination
	 */
	protected $pagination_helper;

	/**
	 * Form Controllers constructor
	 */
	public function __construct() {
		$this->pagination_helper          = new Pagination();
		$this->number_of_records_per_page = $this->pagination_helper->get_number_of_records_per_page();
	}

	/**
	 * Get all forms
	 *
	 * @since 1.0.0
	 *
	 * @return array $forms WPAFA forms
	 */
	abstract public function forms();

	/**
	 * Get forms by id
	 *
	 * @since 1.0.0
	 *
	 * @param \WP_REST_Request $request The request.
	 *
	 * @return object $form WPAFA form
	 */
	abstract public function form_by_id( \WP_REST_Request $request );

	/**
	 * Get forms with pagination
	 *
	 * @since 1.0.0
	 *
	 * @param \WP_REST_Request $request The request.
	 *
	 * @return array $forms WPAFA forms
	 */
	abstract public function forms_pagination( \WP_REST_Request $request );


	/**
	 * Search forms by name.
	 *
	 * @since 1.0.0
	 *
	 * @param \WP_REST_Request $request The request.
	 *
	 * @return array $forms WPAFA forms
	 */
	abstract public function search_forms( \WP_REST_Request $request);

}
