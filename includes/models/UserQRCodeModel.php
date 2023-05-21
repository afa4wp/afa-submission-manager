<?php
/**
 * The User QRCOde Model Class.
 *
 * @package  WP_All_Forms_API
 * @since 1.0.0
 */

namespace Includes\Models;

use Includes\Plugins\Constant;
use WP_Error;

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
		$this->table_name = $wpdb->prefix . Constant::PLUGIN_TABLE_PREFIX . 'user_qr_codes';
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
			'secret'        => hash( 'sha256', $secret ),
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

	/**
	 * Delete user QRCode register
	 *
	 * @param string $user_id The user ID.
	 *
	 * @return int|false
	 */
	public function delete_qr_code_by_user_id( $user_id ) {

		global $wpdb;

		$item = array(
			'user_id' => $user_id,
		);

		$results = $wpdb->delete(
			$this->table_name,
			$item
		);

		return $results;

	}

	/**
	 * Check if QRCode register exist for user
	 *
	 * @param string $user_id The user ID.
	 *
	 * @return true|false
	 */
	public function check_if_exist_qr_code_for_user_id( $user_id ) {

		global $wpdb;

		// phpcs:ignore WordPress.DB.DirectDatabaseQuery.NoCaching
		$results = $wpdb->get_var(
			$wpdb->prepare(
				"SELECT id FROM {$this->table_name} WHERE user_id=%d ", // phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
				(int) $user_id
			)
		);

		if ( ! $results ) {
			return false;
		}

		return true;
	}

	/**
	 * Generate new QRCode for user
	 *
	 * @param string $user_id The user ID.
	 * @param string $secret The user access token.
	 *
	 * @return void
	 */
	public function generate_new_qr_code( $user_id, $secret ) {

		$qr_code_exist = $this->check_if_exist_qr_code_for_user_id( $user_id );

		if ( $qr_code_exist ) {
			$this->delete_qr_code_by_user_id( $user_id );
		}

		$this->create( $user_id, $secret );

	}

	/**
	 * Verify QRCode
	 *
	 * @param string $user_id The user ID.
	 * @param string $secret The user token.
	 *
	 * @return void|WP_Error
	 */
	public function verify_qr_code( $user_id, $secret ) {

		global $wpdb;

		$results = $wpdb->get_results(
			// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
			$wpdb->prepare(
				"SELECT * FROM {$this->table_name} WHERE user_id=%d ",
				$user_id
			),
			OBJECT
		);

		if ( ! ( count( $results ) > 0 ) ) {
			return new WP_Error(
				'invalid_user',
				'User not found',
				array(
					'status' => 403,
				)
			);
		}

		if ( ! hash_equals( $results[0]->secret, hash( 'sha256', $secret ) ) ) {
			return new WP_Error(
				'qr_code_auth_invalid_token',
				'QRCode token not found',
				array(
					'status' => 403,
				)
			);
		}

		$date_time_now           = strtotime( gmdate( 'Y-m-d H:i:s' ) );
		$date_time_expire_secret = strtotime( gmdate( $results[0]->expire_secret ) );

		if ( $date_time_now > $date_time_expire_secret ) {
			return new WP_Error(
				'qr_code_auth_invalid_token',
				'QRCode token is expired',
				array(
					'status' => 403,
				)
			);
		}

		return true;

	}


}
