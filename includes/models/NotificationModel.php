<?php
/**
 * The Notification Model Class.
 *
 * @package  WP_All_Forms_API
 * @since 1.0.0
 */

namespace Includes\Models;

use Includes\Plugins\Constant;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Class NotificationModel
 *
 * Hendler with notification table
 *
 * @since 1.0.0
 */
class NotificationModel {

	/**
	 * Table name
	 *
	 * @var string
	 */
	private $table_name;

	/**
	 * NotificationModel constructor.
	 */
	public function __construct() {
		global $wpdb;
		$this->table_name = $wpdb->prefix . Constant::TABLE_NOTIFICATION;
	}

	/**
	 * Create notification
	 *
	 * @param int   $notification_type_id The id of notification type.
	 * @param array $meta_value The meta_value of notification.
	 * @param int   $supported_plugin_id The supported plugin ID to filter the notifications.
	 * @param int   $user_id The user ID.
	 *
	 * @return int|false
	 */
	public function create( $notification_type_id, $meta_value, $supported_plugin_id = 0, $user_id = 0 ) {

		global $wpdb;

		$item = array(
			'notification_type_id' => $notification_type_id,
			'meta_value'           => maybe_serialize( $meta_value ), // phpcs:ignore
			'user_id'              => $user_id,
			'supported_plugin_id'  => $supported_plugin_id,
			'created_at'           => gmdate( 'Y-m-d H:i:s' ),
		);

		// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery
		$results = $wpdb->insert(
			$this->table_name,
			$item
		);

		return $results;
	}

	/**
	 * Get notifications
	 *
	 * @param int $supported_plugin_id The supported plugin ID to filter the notifications.
	 * @param int $offset The offset.
	 * @param int $number_of_records_per_page The notifications per page.
	 *
	 * @return object
	 */
	public function notifications( $supported_plugin_id, $offset, $number_of_records_per_page = 20 ) {

		global $wpdb;

		$table_notification_type = $wpdb->prefix . Constant::TABLE_NOTIFICATION_TYPE;

		$sql = "SELECT afa_tn.id, afa_tn.user_id, afa_tn.notification_type_id, afa_tn.meta_value, afa_tn.created_at, afa_tnt.type, afa_tnt.title FROM {$this->table_name} afa_tn INNER JOIN  {$table_notification_type} afa_tnt ON afa_tn.notification_type_id = afa_tnt.id WHERE afa_tn.supported_plugin_id IN (0, %d) ORDER BY id DESC LIMIT %d,%d";

		$sql = $wpdb->prepare( $sql, array( $supported_plugin_id, $offset, $number_of_records_per_page ) );// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared

		// phpcs:ignore 
		$results = $wpdb->get_results( $sql, OBJECT );

		$modified_results = array();

		foreach ( $results as $result ) {
			$result->meta_value = maybe_unserialize( $result->meta_value );
			$modified_results[] = $result;
		}

		return $modified_results;
	}

	/**
	 * Get number of notifications
	 *
	 * @param int $supported_plugin_id The supported plugin ID to filter the notifications.
	 *
	 * @return int
	 */
	public function mumber_of_items( $supported_plugin_id ) {

		global $wpdb;

		$sql = "SELECT count(*) as number_of_rows FROM {$this->table_name} WHERE supported_plugin_id IN (0, %d)";

		$sql = $wpdb->prepare( $sql, array( $supported_plugin_id ) ); // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared

		// phpcs:ignore 
		$results = $wpdb->get_results( $sql );

		$number_of_rows = intval( $results[0]->number_of_rows );

		return $number_of_rows;
	}

}
