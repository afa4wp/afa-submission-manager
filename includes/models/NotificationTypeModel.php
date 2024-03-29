<?php
/**
 * The Notification Type Model Class.
 *
 * @package  AFA_SUBMISSION_MANAGER
 * @since 1.0.0
 */

namespace Includes\Models;

use Includes\Plugins\Constant;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Class NotificationTypeModel
 *
 * Hendler with notification_type table
 *
 * @since 1.0.0
 */
class NotificationTypeModel {

	/**
	 * Table name
	 *
	 * @var string
	 */
	private $table_name;

	/**
	 * NotificationTypeModel constructor.
	 */
	public function __construct() {
		global $wpdb;
		$this->table_name = $wpdb->prefix . Constant::TABLE_NOTIFICATION_TYPE;
	}

	/**
	 * Get notification type list
	 *
	 * @return array
	 */
	public function get_all_notification_type() {
		global $wpdb;
		$sql     = "SELECT * FROM {$this->table_name}";
		$results = $wpdb->get_results( $sql, OBJECT ); // phpcs:ignore

		return $results;
	}

	/**
	 * Get notification type by id
	 *
	 * @param int $id The notification type id.
	 *
	 * @return object
	 */
	public function get_notification_type_by_id( $id ) {

		global $wpdb;

		$sql = "SELECT * FROM {$this->table_name} WHERE id=%d";

		$sql = $wpdb->prepare( $sql, array( $id ) );// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared

		// phpcs:ignore
		$results = $wpdb->get_results( $sql, OBJECT );

		if ( count( $results ) > 0 ) {
			return $results[0];
		}

		return null;
	}

	/**
	 * Get notification type by type
	 *
	 * @param string $type The notification type.
	 *
	 * @return object
	 */
	public function get_notification_type_by_type( $type ) {

		global $wpdb;

		$sql = "SELECT * FROM {$this->table_name} WHERE `type`=%s";

		$sql = $wpdb->prepare( $sql, array( $type ) );// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared

		// phpcs:ignore
		$results = $wpdb->get_results( $sql, OBJECT );

		if ( count( $results ) > 0 ) {
			return $results[0];
		}

		return null;
	}

}
