<?php
/**
 * The Abstract Form Notification Class.
 *
 * @package  AFA_SUBMISSION_MANAGER
 * @since 1.0.0
 */

namespace Includes\Plugins\Notification;

use Includes\Models\NotificationModel;
use Includes\Models\NotificationTypeModel;
use Includes\Models\UserDevicesModel;
use Includes\Plugins\Notification\PushNotificationPlugin;
use Includes\Plugins\Language;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Class AbstractFormNotification
 *
 * Create Form Notification Base
 *
 * @since 1.0.0
 */
abstract class AbstractFormNotification {

	/**
	 * Table name
	 *
	 * @var NotificationModel
	 */
	public $notifiacation;

	/**
	 * Table name
	 *
	 * @var PushNotificationPlugin
	 */
	public $push_notification;

	/**
	 * CF7Notification constructor.
	 */
	public function __construct() {
		$this->notifiacation     = new NotificationModel();
		$this->push_notification = new PushNotificationPlugin();
	}

	/**
	 * Send push notification in bulk
	 *
	 * @param array $meta_value The meta_value of notification.
	 * @param int   $user_id The user ID.
	 *
	 * @return void
	 */
	abstract public function create( $meta_value, $user_id = null );

	/**
	 * Get notification type id
	 *
	 * @return int | null
	 */
	public function get_form_submission_notification_type_id() {

		$notification_type_model = new NotificationTypeModel();

		$notification_type = $notification_type_model->get_notification_type_by_type( 'form_submission' );

		if ( empty( $notification_type ) ) {
			return null;
		}

		return $notification_type->id;
	}


}
