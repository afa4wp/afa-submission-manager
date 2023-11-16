<?php
/**
 * The User QRCOdes Class Table.
 *
 * @package  AFA_SUBMISSION_MANAGER
 * @since 1.0.0
 */

namespace Includes\Database;

use Includes\Plugins\Constant;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Class UserQRCodes
 *
 * Create UserQRCodes Table
 *
 * @since 1.0.0
 */
class UserQRCodes {

	/**
	 * Data base name
	 *
	 * @var string
	 */
	private $data_base_name;

	/**
	 * UserQRCodes constructor.
	 */
	public function __construct() {
		$this->data_base_name = Constant::PLUGIN_TABLE_PREFIX . 'user_qr_codes';
	}

	/**
	 * Create user_qr_codes table .
	 */
	public function create_table() {

		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		global $wpdb;

		$sql = 'CREATE TABLE IF NOT EXISTS ' . $wpdb->prefix . $this->data_base_name . ' (
			id BIGINT(20) NOT NULL AUTO_INCREMENT,
			user_id BIGINT(20)  UNSIGNED NOT NULL,
			secret VARCHAR(255) NOT NULL,
			expire_secret DATETIME NOT NULL,
			created_at DATETIME NOT NULL,
			PRIMARY KEY(id),
			FOREIGN KEY(user_id) REFERENCES ' . $wpdb->prefix . 'users(ID),
			UNIQUE(secret)
		  )' . $wpdb->get_charset_collate();

		dbDelta( $sql );
	}

}
