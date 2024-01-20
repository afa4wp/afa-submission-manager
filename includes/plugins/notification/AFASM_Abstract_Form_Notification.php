<?php
/**
 * The Abstract Form Notification Class.
 *
 * @package  claud/afa-submission-manager
 * @since 1.0.0
 */

namespace AFASM\Includes\Plugins\Notification;

use AFASM\Includes\Models\AFASM_Notification_Model;
use AFASM\Includes\Models\AFASM_Notification_Type_Model;
use AFASM\Includes\Plugins\Notification\AFASM_Push_Notification_Plugin;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Class AbstractFormNotification
 *
 * Create Form Notification Base
 *
 * @since 1.0.0
 */
abstract class AFASM_Abstract_Form_Notification {

	/**
	 * Table name
	 *
	 * @var AFASM_Notification_Model
	 */
	public $notifiacation;

	/**
	 * Table name
	 *
	 * @var AFASM_Push_Notification_Plugin
	 */
	public $push_notification;

	/**
	 * CF7Notification constructor.
	 */
	public function __construct() {
		$this->notifiacation     = new AFASM_Notification_Model();
		$this->push_notification = new AFASM_Push_Notification_Plugin();
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

		$notification_type_model = new AFASM_Notification_Type_Model();

		$notification_type = $notification_type_model->get_notification_type_by_type( 'form_submission' );

		if ( empty( $notification_type ) ) {
			return null;
		}

		return $notification_type->id;
	}


}
