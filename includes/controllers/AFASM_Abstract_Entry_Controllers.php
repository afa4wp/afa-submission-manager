<?php
/**
 * The Abstarct Entry Controllers Class.
 *
 * @package  claud/afa-submission-manager
 * @since 1.0.0
 */

namespace AFASM\Includes\Controllers;

use AFASM\Includes\Plugins\Helpers\AFASM_Pagination;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class AbstractEntryControllers
 *
 * Init all routes
 *
 * @since 1.0.0
 */
abstract class AFASM_Abstract_Entry_Controllers {

	/**
	 * The number of items per page
	 *
	 * @var string
	 */
	public $number_of_records_per_page;

	/**
	 * The route name space
	 *
	 * @var AFASM_Pagination
	 */
	protected $pagination_helper;

	/**
	 * Form Controllers constructor
	 */
	public function __construct() {
		$this->pagination_helper          = new AFASM_Pagination();
		$this->number_of_records_per_page = $this->pagination_helper->get_number_of_records_per_page();
	}

	/**
	 * Get all entries
	 *
	 * @since 1.0.0
	 *
	 * @return array $entries AFA entries
	 */
	abstract public function entries();

	/**
	 * Get entry by id
	 *
	 * @since 1.0.0
	 *
	 * @param \WP_REST_Request $request The request.
	 *
	 * @return object $form AFA entry
	 */
	abstract public function entry_by_id( \WP_REST_Request $request );

	/**
	 * Get forms with pagination
	 *
	 * @since 1.0.0
	 *
	 * @param \WP_REST_Request $request The request.
	 *
	 * @return array $forms AFA entries
	 */
	abstract public function entries_by_form_id( \WP_REST_Request $request );


	/**
	 * Search entries by name
	 *
	 * @since 1.0.0
	 *
	 * @param \WP_REST_Request $request The request.
	 *
	 * @return array $forms AFA entries
	 */
	abstract public function search_entries_by_user( \WP_REST_Request $request);

}
