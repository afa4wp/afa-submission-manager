<?php
namespace Includes\Admin\Pages;

use Includes\Admin\Screens\Screen;
use Includes\Admin\Screens\ScreenAbout;
use Includes\Admin\Screens\ScreenMobileLogin;
use Includes\Admin\Screens\ScreenStaff;


// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

class Settings {

	/** @var string base settings page ID */
	const PAGE_ID = 'wp_all_forms_api_settings';

	/**
	 * Settings screens
	 *
	 * @var string[]
	 */
	private $screens;

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

	public function render() {

		$tabs = $this->get_tabs();

		$current_tab = ScreenMobileLogin::ID;

		if ( isset( $_GET['tab'] ) && in_array( $_GET['tab'], array_keys( $tabs ), true ) ) {
			$current_tab = sanitize_text_field( wp_unslash( $_GET['tab'] ) );
		}

		?>
			<div class="wrap">
				<h2><?php echo get_admin_page_title(); ?></h2>
				<h3 class="nav-tab-wrapper">
					<?php foreach ( $tabs as $id => $label ) : ?>
						<a href="<?php echo esc_html( admin_url( 'admin.php?page=' . self::PAGE_ID . '&tab=' . esc_attr( $id ) ) ); ?>" class="nav-tab <?php echo $current_tab === $id ? 'nav-tab-active' : ''; ?>"><?php echo esc_html( $label ); ?></a>
					<?php endforeach; ?>
				</h3>
				<div class="metabox-holder has-right-sidebar">ola</div>
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

