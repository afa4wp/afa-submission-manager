<?php
/**
 * The Screen About
 *
 * @package  claud/afa-submission-manager
 * @since 1.0.0
 */

namespace AFASM\Includes\Admin\Screens;

use AFASM\Includes\Admin\Screens\AFASM_Screen;
use AFASM\Includes\Database\AFASM_Supported_Plugins;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class ScreenAbout
 *
 * Render Staff content
 *
 * @since 1.0.0
 */
class AFASM_Screen_About extends AFASM_Screen {

	// Tab param .
	const ID = 'about';

	/**
	 * Connection constructor.
	 */
	public function __construct() {
		$this->id    = self::ID;
		$this->label = __( 'About plugin', 'afa-submission-manager' );
	}

	/**
	 * Show staff content
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function render() {
		$supported_plugins = new AFASM_Supported_Plugins();
		$plugins_names     = implode( ', ', $supported_plugins->get_supported_plugins_name_list() );
		?>
		<div style='max-width:700px;'>
		<div>
	<p><?php esc_html_e( 'About Our Plugin', 'afa-submission-manager' ); ?></p>
</div>
<div>
	<p>
		<?php esc_html_e( 'Welcome to our powerful plugin designed to enhance your form management experience. Our plugin is built to simplify form entry management, providing you with the tools you need to streamline the process and save time.', 'afa-submission-manager' ); ?>
	</p>
	<p>
		<?php esc_html_e( 'Our plugin goes beyond the desktop by providing a robust API that empowers your mobile app users to effortlessly view form submissions on the go. Seamlessly integrate our plugin with popular WordPress form builders and grant your users the ability to oversee submissions from anywhere.', 'afa-submission-manager' ); ?>
	</p>
	<p>
		<?php esc_html_e( 'Stay organized, gain insights, and enhance user interactions, all within your WordPress dashboard and through our dedicated API. With our user-friendly plugin, you can stay in control and transform the way you manage form submissions. Dive into the possibilities today and revolutionize your approach to form management!', 'afa-submission-manager' ); ?>
	</p>
</div>

			<div >
				<p ><span style="font-weight: bold;"><?php esc_html_e( 'Supported plugins:', 'afa-submission-manager' ); ?></span> <span style="text-transform: uppercase;"><?php echo esc_html( $plugins_names ); ?></span>.</p>
			</div>
		</div>	
		<?php
	}

}

