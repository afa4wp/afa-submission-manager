<?php
/**
 * The Setting Page.
 *
 * @package  claud/afa-submission-manager
 * @since 1.0.0
 */

namespace AFASM\Includes\Admin\Pages;

use AFASM\Includes\Admin\Screens\AFASM_Screen;
use AFASM\Includes\Admin\Screens\AFASM_Screen_About;
use AFASM\Includes\Admin\Screens\AFASM_Screen_Mobile_Login;
use AFASM\Includes\Admin\Screens\AFASM_Screen_Staff;


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class Setting
 *
 * Render settings page
 *
 * @since 1.0.0
 */
class AFASM_Settings {

	/**
	 * Base settings page ID
	 *
	 * @var string
	 */
	const PAGE_ID = 'afasm_settings';

	/**
	 * Settings screens
	 *
	 * @var AFASM_Screen[]
	 */
	private $screens;

	/**
	 * Settings constructor.
	 */
	public function __construct() {
		$this->screens[ AFASM_Screen_Mobile_Login::ID ] = new AFASM_Screen_Mobile_Login();
		$this->screens[ AFASM_Screen_Staff::ID ]        = new AFASM_Screen_Staff();
		$this->screens[ AFASM_Screen_About::ID ]        = new AFASM_Screen_About();
	}

	/**
	 * Settings screens
	 *
	 * @return AFASM_Screen[]
	 */
	public function get_screens() {

		$screens = array_filter(
			$this->screens,
			function( $value ) {

				return $value instanceof AFASM_Screen;

			}
		);

		return $screens;
	}

	/**
	 * Render tabs
	 *
	 * @return void
	 */
	public function render() {

		$tabs = $this->get_tabs();

		$current_tab = AFASM_Screen_Mobile_Login::ID;

		// phpcs:ignore WordPress.Security.NonceVerification.Recommended
		if ( isset( $_GET['tab'] ) && in_array( $_GET['tab'], array_keys( $tabs ), true ) ) {
			// phpcs:ignore WordPress.Security.NonceVerification.Recommended
			$current_tab = sanitize_text_field( wp_unslash( $_GET['tab'] ) );
		}

		$screen = $this->screens[ $current_tab ];

		?>
			<div class="wrap">
				<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
				<h3 class="nav-tab-wrapper">
					<?php foreach ( $tabs as $id => $label ) : ?>
						<a href="<?php echo esc_html( admin_url( 'admin.php?page=' . self::PAGE_ID . '&tab=' . esc_attr( $id ) ) ); ?>" class="nav-tab <?php echo $current_tab === $id ? 'nav-tab-active' : ''; ?>"><?php echo esc_html( $label ); ?></a>
					<?php endforeach; ?>
				</h3>
				<div class="metabox-holder has-right-sidebar">
					<?php
						$screen->render();
					?>
				</div>
			</div>
		<?php
	}

	/**
	 * Gets the tabs.
	 *
	 * @return string[]
	 */
	public function get_tabs() {

		$tabs = array();

		foreach ( $this->get_screens() as $screen_id => $screen ) {
			$tabs[ $screen_id ] = $screen->get_label();
		}

		return $tabs;
	}
}

