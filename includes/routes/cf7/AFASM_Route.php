<?php
/**
 * The Main Route Class for Contact Form 7.
 *
 * @package  claud/afa-submission-manager
 * @since 1.0.0
 */

namespace AFASM\Includes\Routes\CF7;

use AFASM\Includes\Routes\CF7\AFASM_Form;
use AFASM\Includes\Routes\CF7\AFASM_Entry;
use AFASM\Includes\Routes\CF7\AFASM_Entry_Meta;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class Route
 *
 * Init all routes
 *
 * @since 1.0.0
 */
class AFASM_Route {

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

		( new AFASM_Form( $this->name ) )->init_routes();
		( new AFASM_Entry( $this->name ) )->init_routes();
		( new AFASM_Entry_Meta( $this->name ) )->init_routes();

	}

}
