<?php
/**
 * The Notification Class.
 *
 * @package  AFA_SUBMISSION_MANAGER
 * @since 1.0.0
 */

namespace Includes\Database;

use AFASM\Includes\Plugins\AFASM_Constant;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Class Notification
 *
 * Create table notification
 *
 * @since 1.0.0
 */
class Notification {

	/**
	 * Table name
	 *
	 * @var string
	 */
	private $table_name;

	/**
	 * Notification constructor.
	 */
	public function __construct() {
		global $wpdb;
		$this->table_name = $wpdb->prefix . AFASM_Constant::TABLE_NOTIFICATION;
	}

	/**
	 * Create notification table.
	 */
	public function create_table() {

		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		global $wpdb;

		$sql = 'CREATE TABLE IF NOT EXISTS ' . $this->table_name . ' (
		id BIGINT(20) NOT NULL AUTO_INCREMENT,
		user_id BIGINT(20) unsigned,
		notification_type_id BIGINT(20) NOT NULL,
		supported_plugin_id BIGINT(20) unsigned,
		meta_value LONGTEXT NOT NULL,
		created_at DATETIME NOT NULL,
		PRIMARY KEY(id),
        FOREIGN KEY(notification_type_id) REFERENCES ' . $wpdb->prefix . AFASM_Constant::TABLE_NOTIFICATION_TYPE . '(id)
      )' . $wpdb->get_charset_collate();

		dbDelta( $sql );
	}

}
