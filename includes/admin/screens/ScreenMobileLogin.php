<?php
/**
 * The staff tub item for configuration screen
 *
 * @package  WP_All_Forms_API
 * @since 1.0.0
 */

namespace Includes\Admin\Screens;

use Includes\Admin\Screens\Screen;
use Includes\Plugins\QRCode;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Class ScreenMobileLogin
 *
 * Render Staff content
 *
 * @since 1.0.0
 */
class ScreenMobileLogin extends Screen {

	/**
	 * Tab param
	 *
	 * @var string
	 */
	const ID = 'qrcode';

	/**
	 * ScreenMobileLogin constructor.
	 */
	public function __construct() {
		$this->id    = self::ID;
		$this->label = 'Generate QRCode';
	}

	/**
	 * Render content
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function render() {

		$qr_code           = new QRCode();
		$generated_qr_code = $qr_code->generate_qr_code();

		?>
			<div>
				Scan the following QR Code using the WP AFA app.
			</div>
			<div>
				<img src="<?php echo esc_html( $generated_qr_code ); ?>"  alt="QR Code"/>
			</div>
		<?php
	}

}
