<?php
/**
 * The CF7 Notification Class.
 *
 * @package  claud/afa-submission-manager
 * @since 1.0.0
 */

namespace AFASM\Includes\Plugins\Notification;

use AFASM\Includes\Models\AFASM_User_Devices_Model;
use AFASM\Includes\Plugins\Notification\AFASM_Abstract_Form_Notification;
use AFASM\Includes\Models\AFASM_Supported_Plugins_Model;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Class CF7Notification
 *
 * Manipulate CF7 Notification
 *
 * @since 1.0.0
 */
class AFASM_CF7_Notification extends AFASM_Abstract_Form_Notification {

	/**
	 * Send push notification in bulk
	 *
	 * @param array $meta_value The meta_value of notification.
	 * @param int   $user_id The user ID.
	 *
	 * @return void
	 */
	public function create( $meta_value, $user_id = null ) {

		$supported_plugins_model_register = ( new AFASM_Supported_Plugins_Model() )->get_supported_plugin_by_slug( 'cf7' );
		$supported_plugin_id              = 0;

		if ( ! empty( $supported_plugins_model_register ) ) {
			$supported_plugin_id = $supported_plugins_model_register->id;
		}

		$notification_type_id = $this->get_form_submission_notification_type_id();
		$this->notifiacation->create( $notification_type_id, $meta_value, $supported_plugin_id, $user_id );

		$items = $this->prepare_push_notification( $notification_type_id, $meta_value, $user_id );
		$this->push_notification->push_notification_bulk( $items );
	}

	/**
	 * Prepare push notification for each user
	 *
	 * @param int   $notification_type_id The id of notification type.
	 * @param array $meta_value The meta_value of notification.
	 * @param int   $user_id The user ID.
	 *
	 * @return array
	 */
	private function prepare_push_notification( $notification_type_id, $meta_value, $user_id ) {
		$push_notifications_data = array();

		$divices = ( new AFASM_User_Devices_Model() )->get_enabled_register_by_notification_type( $notification_type_id );

		foreach ( $divices as $key => $divice ) {

			$item = array();

			// translators: %1$s is replaced with the site name.
			$push_notification_body = sprintf( __( 'New Form Submission Received from %1$s. Open app to view', 'afa-submission-manager' ), get_bloginfo( 'name' ) );

			$title = __( 'New Form Submission', 'afa-submission-manager' );

			$formatted_tiitle = sprintf( '📩 %s', $title );

			$item['title']          = $formatted_tiitle;
			$item['body']           = $push_notification_body;
			$item['exponent_token'] = $divice->expo_token;

			$push_notifications_data[] = $item;

		}

		return $push_notifications_data;
	}

	/**
	 * Load hooks for notifications
	 *
	 * @param int $post_id The post id.
	 *
	 * @return void
	 */
	public function submission_notification( $post_id ) {
		$post_type = get_post_type( $post_id );

		if ( 'flamingo_inbound' === $post_type ) {
			$notification_data = array();

			$flamingo_post = get_post( $post_id );

			$notification_data['entry_id']    = $post_id;
			$notification_data['post_type']   = 'flamingo_inbound';
			$notification_data['post_tiltle'] = $flamingo_post->post_title;
			$notification_data['user_id']     = $flamingo_post->post_author;

			$this->create( $notification_data, $notification_data['user_id'] );
		}
	}

	/**
	 * Load hooks for notifications
	 *
	 * @return void
	 */
	public function loads_hooks() {
		add_action( 'wp_insert_post', array( $this, 'submission_notification' ), 10, 1 );
	}

}
