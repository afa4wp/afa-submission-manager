<?php
/**
 * The NotificationType Class.
 *
 * @package  AFA_SUBMISSION_MANAGER
 * @since 1.0.0
 */

namespace Includes\Database;

use Includes\Plugins\Constant;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Class NotificationType
 *
 * Create table notification_type
 *
 * @since 1.0.0
 */
class NotificationType {

	/**
	 * Table name
	 *
	 * @var string
	 */
	private $table_name;

	/**
	 * NotificationType constructor.
	 */
	public function __construct() {
		global $wpdb;
		$this->table_name = $wpdb->prefix . Constant::TABLE_NOTIFICATION_TYPE;
	}

	/**
	 * Create notification_type table.
	 */
	public function create_table() {

		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		global $wpdb;

		$sql = 'CREATE TABLE IF NOT EXISTS ' . $this->table_name . ' (
        id BIGINT(20) NOT NULL AUTO_INCREMENT,
        type VARCHAR(255),
		title VARCHAR(255),
        PRIMARY KEY(id),
        UNIQUE(type)
      	)' . $wpdb->get_charset_collate();

		dbDelta( $sql );

		$this->insert_default_values();
	}

	/**
	 * Get notification type
	 *
	 * @return array Notification type items
	 */
	public function get_default_values() {
		$values = array(
			array(
				'type'  => 'form_submission',
				'title' => 'New Form Submission',
			),
			array(
				'type'  => 'form_created',
				'title' => 'New Form Created',
			),
		);

		return $values;
	}

	/**
	 * Insert notification type items
	 *
	 * @return void
	 */
	private function insert_default_values() {
		global $wpdb;

		$table_name = $this->table_name;
		$values     = $this->get_default_values();

		foreach ( $values as $key => $value ) {
			// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
			$wpdb->insert(
				$table_name,
				$value
			);
		}

	}
}
