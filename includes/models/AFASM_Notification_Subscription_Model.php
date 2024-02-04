<?php
/**
 * The Notification Subscription Model Class.
 *
 * @package  claud/afa-submission-manager
 * @since 1.0.0
 */

namespace AFASM\Includes\Models;

use AFASM\Includes\Plugins\AFASM_Constant;
use AFASM\Includes\Models\AFASM_User_Devices_Model;
use AFASM\Includes\Models\AFASM_Notification_Type_Model;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class NotificationSubscriptionModel
 *
 * Hendler with notification_subscription table
 *
 * @since 1.0.0
 */
class AFASM_Notification_Subscription_Model {

	/**
	 * Table name
	 *
	 * @var string
	 */
	private $table_name;

	/**
	 * AFASM_Notification_Subscription_Model constructor.
	 */
	public function __construct() {
		global $wpdb;
		$this->table_name = $wpdb->prefix . AFASM_Constant::TABLE_NOTIFICATION_SUBSCRIPTION;
	}

	/**
	 * Subscribe user to all notification
	 *
	 * @param string $expo_token The user token for push notification.
	 *
	 * @return boolean
	 */
	public function subscribe_user_all_notificions_by_expo_token( $expo_token ) {

		global $wpdb;

		$device = ( new AFASM_User_Devices_Model() )->get_register_by_user_expo_token( $expo_token );

		if ( empty( $device ) ) {
			return false;
		}

		$notifications_types = ( new AFASM_Notification_Type_Model() )->get_all_notification_type();

		$controll = true;

		foreach ( $notifications_types as $key => $value ) {

			$item                         = array();
			$item['user_devices_id']      = $device->id;
			$item['notification_type_id'] = $value->id;
			$item['enabled']              = true;

			// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
			$reusult = $wpdb->insert(
				$this->table_name,
				$item
			);

			if ( ! $reusult ) {
				$controll = false;
			}
		}

		return $controll;

	}

	/**
	 * Get user notification subscription
	 *
	 * @param string $expo_token The user token for push notification.
	 *
	 * @return array
	 */
	public function fetch_subscriptions_by_expo_token( $expo_token ) {

		global $wpdb;

		$device = ( new AFASM_User_Devices_Model() )->get_register_by_user_expo_token( $expo_token );

		if ( empty( $device ) ) {
			return array();
		}

		$id = $device->id;

		$table_notification_type = $wpdb->prefix . AFASM_Constant::TABLE_NOTIFICATION_TYPE;
		$sql                     = "SELECT afasm_tns.id, afasm_tns.user_devices_id, afasm_tns.notification_type_id, afasm_tns.enabled, afasm_tnt.type, afasm_tnt.title FROM {$this->table_name} afasm_tns INNER JOIN {$table_notification_type} afasm_tnt ON afasm_tns.notification_type_id = afasm_tnt.id WHERE afasm_tns.user_devices_id=%d ";

		$sql = $wpdb->prepare( $sql, array( $id ) );// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared

		// phpcs:ignore
		$results = $wpdb->get_results( $sql, OBJECT );

		return $results;

	}

	/**
	 * Unsubscribe to all notification.
	 *
	 * @param string $expo_token The user token for push notification.
	 *
	 * @return int|false
	 */
	public function unsubscribe( $expo_token ) {
		global $wpdb;

		$device = ( new AFASM_User_Devices_Model() )->get_register_by_user_expo_token( $expo_token );

		if ( empty( $device ) ) {
			return false;
		}

		$item = array(
			'user_devices_id' => $device->id,
		);

		// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
		$results = $wpdb->delete(
			$this->table_name,
			$item
		);

		return $results;
	}

	/**
	 * Update subscription..
	 *
	 * @param int $notification_subscription_id The id of notification subscription.
	 * @param int $enabled The value of enabled field.
	 *
	 * @return int|false
	 */
	public function update_subscription_state( $notification_subscription_id, $enabled ) {
		global $wpdb;

		$item = array(
			'enabled' => 1 === $enabled ? true : false,
		);

		// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
		$results = $wpdb->update(
			$this->table_name,
			$item,
			array( 'id' => $notification_subscription_id )
		);

		return $results;
	}
}
