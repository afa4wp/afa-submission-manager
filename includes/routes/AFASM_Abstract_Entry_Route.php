<?php
/**
 * The Abstarct Entry Route Class.
 *
 * @package  claud/afa-submission-manager
 * @since 1.0.0
 */

namespace AFASM\Includes\Routes;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class AbastractEntryRoute
 *
 * Init all routes
 *
 * @since 1.0.0
 */
abstract class AFASM_Abstract_Entry_Route {

	/**
	 * The route name space
	 *
	 * @var string
	 */
	protected $name;

	/**
	 * Route constructor
	 *
	 * @param string $name The route name space.
	 */
	public function __construct( $name ) {
		$this->name = $name;
	}

	/**
	 * Get all entries
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	abstract protected function entries();

	/**
	 * Get entry by id
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	abstract protected function entry_by_id();

	/**
	 * Get entries by form id
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	abstract protected function entries_by_form_id();

	/**
	 * Search entries by user info.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	abstract protected function search_entries_by_user();

	/**
	 * Call all endpoints.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function init_routes() {
		$this->entries();
		$this->entry_by_id();
		$this->entries_by_form_id();
		$this->search_entries_by_user();
	}

}
