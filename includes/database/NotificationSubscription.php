<?php
/**
 * The NotificationSubscription Class.
 *
 * @package  AFA_SUBMISSION_MANAGER
 * @since 1.0.0
 */

namespace Includes\Database;

use AFASM\Includes\Plugins\AFASM_Constant;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Class NotificationSubscription
 *
 * Create table notification_subscription
 *
 * @since 1.0.0
 */
class NotificationSubscription {

	/**
	 * Table name
	 *
	 * @var string
	 */
	private $table_name;

	/**
	 * NotificationSubscription constructor.
	 */
	public function __construct() {
		global $wpdb;
		$this->table_name = $wpdb->prefix . AFASM_Constant::TABLE_NOTIFICATION_SUBSCRIPTION;
	}

	/**
	 * Create notification_subscription table.
	 */
	public function create_table() {

		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		global $wpdb;

		$sql = 'CREATE TABLE IF NOT EXISTS ' . $this->table_name . ' (
        id BIGINT(20) NOT NULL AUTO_INCREMENT,
        user_devices_id BIGINT(20) NOT NULL,
		notification_type_id BIGINT(20) NOT NULL,
		enabled BOOLEAN,
        PRIMARY KEY(id),
        FOREIGN KEY(user_devices_id) REFERENCES ' . $wpdb->prefix . AFASM_Constant::TABLE_USER_DEVICE . '(id) ON DELETE CASCADE,
		FOREIGN KEY(notification_type_id) REFERENCES ' . $wpdb->prefix . AFASM_Constant::TABLE_NOTIFICATION_TYPE . '(id),
        UNIQUE(user_devices_id, notification_type_id)
      )' . $wpdb->get_charset_collate();

		dbDelta( $sql );
	}

}
