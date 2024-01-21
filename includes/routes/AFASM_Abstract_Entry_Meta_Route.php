<?php
/**
 * The Abstarct Entry Meta Route Class.
 *
 * @package  claud/afa-submission-manager
 * @since 1.0.0
 */

namespace AFASM\Includes\Routes;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class AbstractEntryMetaRoute
 *
 * Init all routes
 *
 * @since 1.0.0
 */
abstract class AFASM_Abstract_Entry_Meta_Route {

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
	 * Get entry_meta by entry id
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	abstract protected function entry_meta_by_entry_id();

	/**
	 * Get entry meta by search
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	abstract protected function search_entry_meta_answer();

	/**
	 * Call all endpoints.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function init_routes() {
		$this->entry_meta_by_entry_id();
		$this->search_entry_meta_answer();
	}

}
