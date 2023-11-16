<?php
/**
 * The Abstarct Form Route Class.
 *
 * @package  AFA_SUBMISSION_MANAGER
 * @since 1.0.0
 */

namespace Includes\Routes;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Class AbstractFormRoute
 *
 * Init all routes
 *
 * @since 1.0.0
 */
abstract class AbstractFormRoute {

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
	 * Get all forms
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	abstract protected function forms();

	/**
	 * Get form by id
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	abstract protected function form_by_id();

	/**
	 * Get forms with pagination
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	abstract protected function forms_pagination();

	/**
	 * Search forms by name.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	abstract protected function search_forms();

	/**
	 * Call all endpoints.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function init_routes() {
		$this->forms();
		$this->form_by_id();
		$this->forms_pagination();
		$this->search_forms();
	}

}
