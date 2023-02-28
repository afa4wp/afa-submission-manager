<?php
/**
 * The staff tub item for configuration screen
 *
 * @package  WP_All_Forms_API
 * @since 1.0.0
 */

namespace Includes\Admin\Screens;
use Includes\Admin\Screens\Screen;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Class WP_AFA_Staff
 *
 * Render Staff content
 *
 * @since 1.0.0
 */
class ScreenStaff extends Screen{

	// Tab param .
	const ID = 'staff';

	/**
	 * Connection constructor.
	 */

	 public function __construct() {
		$this->id = self::ID;
		$this->label = 'Staff';
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
				ola render
			</div>
		<?php
	}

}

