<?php
/**
 * The UserTokens Class.
 *
 * @package  AFA_SUBMISSION_MANAGER
 * @since 1.0.0
 */

namespace Includes\Database;

use Includes\Plugins\Constant;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Class UserTokens
 *
 * Create table user_tokens
 *
 * @since 1.0.0
 */
class UserTokens {

	/**
	 * Table name
	 *
	 * @var string
	 */
	private $table_name;

	/**
	 * UserTokens constructor.
	 */
	public function __construct() {
		global $wpdb;
		$this->table_name = $wpdb->prefix . Constant::PLUGIN_TABLE_PREFIX . 'user_tokens';
	}

	/**
	 * Create user_tokens table .
	 */
	public function create_table() {

		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		global $wpdb;

		$sql = 'CREATE TABLE IF NOT EXISTS ' . $this->table_name . ' (
        id BIGINT(20) NOT NULL AUTO_INCREMENT,
        user_id BIGINT(20)  UNSIGNED NOT NULL,
        access_token VARCHAR(255) NOT NULL,
        refresh_token VARCHAR(255) NOT NULL,
		created_at DATETIME NOT NULL,
        PRIMARY KEY(id),
        FOREIGN KEY(user_id) REFERENCES ' . $wpdb->users . '(ID),
        UNIQUE(access_token),
        UNIQUE(refresh_token)
      )' . $wpdb->get_charset_collate();

		dbDelta( $sql );
	}

}
