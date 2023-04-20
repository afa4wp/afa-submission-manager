<?php
/**
 * The Abstarct Entry Route Class.
 *
 * @package  WP_All_Forms_API
 * @since 1.0.0
 */

namespace Includes\Routes;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Class AbastractEntryRoute
 *
 * Init all routes
 *
 * @since 1.0.0
 */
abstract class AbstractEntryRoute {

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
