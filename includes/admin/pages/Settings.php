<?php
/**
 * The Setting Page.
 *
 * @package  WP_All_Forms_API
 * @since 1.0.0
 */

namespace Includes\Admin\Pages;

use Includes\Admin\Screens\Screen;
use Includes\Admin\Screens\ScreenAbout;
use Includes\Admin\Screens\ScreenMobileLogin;
use Includes\Admin\Screens\ScreenStaff;


// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Class Setting
 *
 * Render settings page
 *
 * @since 1.0.0
 */
class Settings {

	/**
	 * Base settings page ID
	 *
	 * @var string
	 */
	const PAGE_ID = 'wp_all_forms_api_settings';

	/**
	 * Settings screens
	 *
	 * @var Screen;[]
	 */
	private $screens;

	/**
	 * Settings constructor.
	 */
	public function __construct() {
		$this->screens[ ScreenMobileLogin::ID ] = new ScreenMobileLogin();
		$this->screens[ ScreenStaff::ID ]       = new ScreenStaff();
		$this->screens[ ScreenAbout::ID ]       = new ScreenAbout();
	}

	/**
	 * Settings screens
	 *
	 * @return Screen[]
	 */
	public function get_screens() {

		$screens = array_filter(
			$this->screens,
			function( $value ) {

				return $value instanceof Screen;

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

		$current_tab = ScreenMobileLogin::ID;

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

