<?php
/**
 * The Screen About
 *
 * @package  WP_All_Forms_API
 * @since 1.0.0
 */

namespace Includes\Admin\Screens;

use Includes\Admin\Screens\Screen;
use Includes\Database\SupportedPlugins;

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
		$this->label = __( 'About plugin', 'wp-all-forms-api' );
	}

	/**
	 * Show staff content
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function render() {
		$supported_plugins = new SupportedPlugins();
		$plugins_names     = implode( ', ', $supported_plugins->get_supported_plugins_name_list() );
		?>
		<div style='max-width:700px;'>
		<div>
	<p><?php esc_html_e( 'About Our Plugin', 'wp-all-forms-api' ); ?></p>
</div>
<div>
	<p>
		<?php esc_html_e( 'Welcome to our powerful plugin designed to enhance your form management experience. Our plugin is built to simplify form entry management, providing you with the tools you need to streamline the process and save time.', 'wp-all-forms-api' ); ?>
	</p>
	<p>
		<?php esc_html_e( 'Our plugin goes beyond the desktop by providing a robust API that empowers your mobile app users to effortlessly view form submissions on the go. Seamlessly integrate our plugin with popular WordPress form builders and grant your users the ability to oversee submissions from anywhere.', 'wp-all-forms-api' ); ?>
	</p>
	<p>
		<?php esc_html_e( 'Stay organized, gain insights, and enhance user interactions, all within your WordPress dashboard and through our dedicated API. With our user-friendly plugin, you can stay in control and transform the way you manage form submissions. Dive into the possibilities today and revolutionize your approach to form management!', 'wp-all-forms-api' ); ?>
	</p>
</div>

			<div >
				<p ><span style="font-weight: bold;"><?php esc_html_e( 'Supported plugins:', 'wp-all-forms-api' ); ?></span> <span style="text-transform: uppercase;"><?php echo $plugins_names; ?></span>.</p>
			</div>
		</div>	
		<?php
	}

}

