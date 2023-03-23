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
	 * Table base name
	 *
	 * @var string
	 */
	private $table_name;

	/**
	 * UserQRCodeModel constructor.
	 */
	public function __construct() {
		global $wpdb;
		$this->table_name = $wpdb->prefix . $_ENV['DATA_BASE_PREFIX'] . 'user_qr_codes';
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
			$this->table_name,
			$item
		); // db call ok; no-cache ok.

		return $results;
	}

	/**
	 * Get user QRCode register
	 *
	 * @param string $user_id The user ID.
	 *
	 * @return Object|null
	 */
	public function qr_code_by_user_id( $user_id ) {

		global $wpdb;

		$results = $wpdb->get_results(
			// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
			$wpdb->prepare(
				"SELECT * FROM {$this->table_name} WHERE user_id=%d ",
				$user_id
			),
			OBJECT
		);

		if ( count( $results ) > 0 ) {
			return $results[0];
		}

		return null;

	}
}
