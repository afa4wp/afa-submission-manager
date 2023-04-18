<?php
/**
 * The Screen About
 *
 * @package  WP_All_Forms_API
 * @since 1.0.0
 */

namespace Includes\Admin\Screens;

use Includes\Admin\Screens\Screen;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Class ScreenAbout
 *
 * Render Staff content
 *
 * @since 1.0.0
 */
class ScreenAbout extends Screen {

	// Tab param .
	const ID = 'about';

	/**
	 * Connection constructor.
	 */
	public function __construct() {
		$this->id    = self::ID;
		$this->label = 'About plugin';
	}

	/**
	 * Show staff content
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function render() {
		?>
			<div >
				about
			</div>
		<?php
	}

}

