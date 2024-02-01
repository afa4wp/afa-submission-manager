<?php
/**
 * The Screen Mobile Login
 *
 * @package  AFA_SUBMISSION_MANAGER
 * @since 1.0.0
 */

namespace AFASM\Includes\Admin\Screens;

use AFASM\Includes\Admin\Screens\AFASM_Screen;
use AFASM\Includes\Plugins\AFASM_QR_Code;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class ScreenMobileLogin
 *
 * Render Staff content
 *
 * @since 1.0.0
 */
class AFASM_Screen_Mobile_Login extends AFASM_Screen {

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
		$this->label = __( 'Login', 'afa-submission-manager' );
	}

	/**
	 * Render content
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function render() {

		$qr_code           = new AFASM_QR_Code();
		$generated_qr_code = $qr_code->generate_qr_code();

		?>
			<div>
				<p>
				<?php esc_html_e( 'Scan the following QR Code using the AFA app.', 'afa-submission-manager' ); ?>
				</p>
			</div>
			<div>
				<img src="<?php echo esc_html( $generated_qr_code ); ?>"  alt="QR Code"/>
			</div>
		<?php
	}

}
