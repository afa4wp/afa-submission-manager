<?php
/**
 * The QRCOde Plugin Class.
 *
 * @package  claud/afa-submission-manager
 * @since 1.0.0
 */

namespace AFASM\Includes\Plugins;

use chillerlan\QRCode\QRCode as ChillerlanQRCode;
use AFASM\Includes\Models\AFASM_User_QR_Code_Model;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Class AFASM_QR_Code
 *
 * Manipulate AFASM_QR_Code view
 *
 * @since 1.0.0
 */
class AFASM_QR_Code {

	/**
	 * Class to generate AFASM_QR_Code
	 *
	 * @var ChillerlanQRCode
	 */
	private $chillerlan_qr_code;

	/**
	 * AFASM_QR_Code constructor.
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

		$user_qrcode_model = new AFASM_User_QR_Code_Model();

		$url = get_rest_url();

		$secret  = base64_encode( openssl_random_pseudo_bytes( 30 ) ); // phpcs:ignore
		$user_id = get_current_user_id();
		$user_qrcode_model->generate_new_qr_code( $user_id, $secret );

		$data = array(
			'url'    => $url,
			'secret' => $user_id . '|' . $secret,
		);

		return wp_json_encode( $data );
	}
}
