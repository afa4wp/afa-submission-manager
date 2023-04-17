<?php
/**
 * The Main Route Class for Contact Form 7.
 *
 * @package  WP_All_Forms_API
 * @since 1.0.0
 */

namespace Includes\Routes\CF7;

use Includes\Routes\CF7\Form;
use Includes\Routes\CF7\Entry;
use Includes\Routes\CF7\EntryMeta;

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
		( new Form( $this->name ) )->initRoutes();
		( new Entry( $this->name ) )->initRoutes();
		( new EntryMeta( $this->name ) )->initRoutes();
	}

}
