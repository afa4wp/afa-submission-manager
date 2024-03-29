<?php
/**
 * The Main Route Class for Contact Form 7.
 *
 * @package  AFA_SUBMISSION_MANAGER
 * @since 1.0.0
 */

namespace Includes\Routes\EFB;

use Includes\Routes\EFB\Form;
use Includes\Routes\EFB\Entry;
use Includes\Routes\EFB\EntryMeta;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Class Route
 *
 * Init all routes
 *
 * @since 1.0.0
 */
class Route {

	/**
	 * The route name space
	 *
	 * @var string
	 */
	private $name;

	/**
	 * Route constructor.
	 *
	 * @param string $name The route name space.
	 */
	public function __construct( $name ) {
		$this->name = $name;
	}

	/**
	 * Init all routes.
	 */
	public function init_routes() {

		( new Form( $this->name ) )->init_routes();
		( new Entry( $this->name ) )->init_routes();
		( new EntryMeta( $this->name ) )->init_routes();

	}

}
