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
	 * NotificationTypeModel constructor.
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
	 * @param int   $user_id The user ID.
	 *
	 * @return int|false
	 */
	public function create( $notification_type_id, $meta_value, $user_id = null ) {

		global $wpdb;

		$item = array(
			'notification_type_id' => $notification_type_id,
			'meta_value'           => maybe_serialize( $meta_value ), // phpcs:ignore
			'user_id'              => $user_id,
			'created_at'           => gmdate( 'Y-m-d H:i:s' ),
		);

		// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery
		$results = $wpdb->insert(
			$this->table_name,
			$item
		);

		return $results;
	}



}
