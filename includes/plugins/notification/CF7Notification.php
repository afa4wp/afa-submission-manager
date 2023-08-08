<?php
/**
 * The CF7 Notification Class.
 *
 * @package  WP_All_Forms_API
 * @since 1.0.0
 */

namespace Includes\Plugins\Notification;

use Includes\Models\UserDevicesModel;
use Includes\Plugins\Language;
use Includes\Plugins\Notification\AbstractFormNotification;
use Includes\Models\SupportedPluginsModel;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Class CF7Notification
 *
 * Manipulate CF7 Notification
 *
 * @since 1.0.0
 */
class CF7Notification extends AbstractFormNotification {

	/**
	 * Send push notification in bulk
	 *
	 * @param array $meta_value The meta_value of notification.
	 * @param int   $user_id The user ID.
	 *
	 * @return void
	 */
	public function create( $meta_value, $user_id = null ) {

		$supported_plugins_model_register = ( new SupportedPluginsModel() )->get_supported_plugin_by_slug( 'cf7' );
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

		$divices = ( new UserDevicesModel() )->get_enabled_register_by_notification_type( $notification_type_id );

		foreach ( $divices as $key => $divice ) {

			$plugin_language = new Language();

			$device_language = $divice->device_language;
			$item            = array();

			$switched_locale = switch_to_locale( $device_language );

			$plugin_language->load_textdomain_by_language_key( $device_language );

			// translators: %1$s is replaced with the site name.
			$push_notification_body = sprintf( __( 'New Form Submission Received from %1$s. Open app to view', 'wp-all-forms-api' ), get_bloginfo( 'name' ) );

			$title = __( 'New Form Submission', 'wp-all-forms-api' );

			$formatted_tiitle = sprintf( '📩 %s', $title );

			$item['title']          = $formatted_tiitle;
			$item['body']           = $push_notification_body;
			$item['exponent_token'] = $divice->expo_token;

			if ( $switched_locale ) {
				restore_previous_locale();
			}

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
