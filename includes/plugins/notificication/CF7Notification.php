<?php
/**
 * The CF7 Notification Class.
 *
 * @package  WP_All_Forms_API
 * @since 1.0.0
 */

namespace Includes\Plugins\Notification;

use Includes\Models\NotificationModel;
use Includes\Models\NotificationTypeModel;


// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Class CF7Notification
 *
 * Manipulate CF7 Notification
 *
 * @since 1.0.0
 */
class CF7Notification {

	/**
	 * Table name
	 *
	 * @var NotificationModel
	 */
	private $notifiacation;

	/**
	 * CF7Notification constructor.
	 */
	public function __construct() {
		$this->notifiacation = new NotificationModel();
	}

	/**
	 * Send push notification in bulk
	 *
	 * @param array $meta_value The meta_value of notification.
	 * @param int   $user_id The user ID.
	 *
	 * @return void
	 */
	public function create( $meta_value, $user_id = null ) {

		$notification_type_id = $this->get_notification_type_id();
		$this->notifiacation->create( $notification_type_id, $meta_value, $user_id );

	}

	/**
	 * Get notification type id
	 *
	 * @return int | null
	 */
	private function get_notification_type_id() {

		$notification_type_model = new NotificationTypeModel();

		$notification_type = $notification_type_model->get_notification_type_by_type( 'form_submition' );

		if ( empty( $notification_type ) ) {
			return null;
		}

		return $notification_type->id;
	}
}
