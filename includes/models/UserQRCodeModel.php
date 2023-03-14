<?php
/**
 * The User QRCOde Model Class.
 *
 * @package  WP_All_Forms_API
 * @since 1.0.0
 */

namespace Includes\Models;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Class UserQRCodeModel
 *
 * Manipulate UserQRCodeModel Table
 *
 * @since 1.0.0
 */
class UserQRCodeModel {

	/**
	 * Expire secret in second
	 *
	 * @var string
	 */
	const EXP_SECRET_IN_SECOND = 300;

	/**
	 * Data base name
	 *
	 * @var string
	 */
	private $data_base_name;

	/**
	 * UserQRCodeModel constructor.
	 */
	public function __construct() {
		$this->data_base_name = $_ENV['DATA_BASE_PREFIX'] . 'user_qr_codes';
	}

	/**
	 * Create new QRCode register
	 *
	 * @param string $user_id The user ID.
	 * @param string $secret The user access token.
	 *
	 * @return int|false
	 */
	public function create( $user_id, $secret ) {
		global $wpdb;

		$item = array(
			'user_id'       => $user_id,
			'secret'        => $secret,
			'created_at'    => gmdate( 'Y-m-d H:i:s' ),
			'expire_secret' => gmdate( 'Y-m-d H:i:s', time() + self::EXP_SECRET_IN_SECOND ),
		);

		$results = $wpdb->insert(
			$wpdb->prefix . $this->data_base_name,
			$item
		);

		return $results;
	}
}
