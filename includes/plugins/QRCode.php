<?php
/**
 * The QRCOde Plugin Class.
 *
 * @package  WP_All_Forms_API
 * @since 1.0.0
 */

namespace Includes\Plugins;

use chillerlan\QRCode\QRCode as ChillerlanQRCode;
use Includes\Models\UserQRCodeModel;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Class QRCode
 *
 * Manipulate QRCode view
 *
 * @since 1.0.0
 */
class QRCode {

	/**
	 * Class to generate QRCode
	 *
	 * @var ChillerlanQRCode
	 */
	private $chillerlan_qr_code;

	/**
	 * QRCode constructor.
	 */
	public function __construct() {
		$this->chillerlan_qr_code = new ChillerlanQRCode();
	}

	/**
	 * Generate new QRCode
	 *
	 * @return string
	 */
	public function generate_qr_code() {
		$data = $this->get_data();
		return $this->chillerlan_qr_code->render( $data );
	}

	/**
	 * Create new QRCode for logged user
	 *
	 * @return string
	 */
	private function get_data() {

		$user_qrcode_model = new UserQRCodeModel();

		$url = get_rest_url();

		$secret  = base64_encode( openssl_random_pseudo_bytes( 30 ) );
		$user_id = get_current_user_id();
		$user_qrcode_model->generate_new_qr_code( $user_id, $secret );
		
		$data = array(
			'url'    => $url,
			'secret' => $user_id.'|'.$secret,
		);

		return wp_json_encode( $data );
	}
}
