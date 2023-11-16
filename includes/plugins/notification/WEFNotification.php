<?php
/**
 * The WEF Notification Class.
 *
 * @package  AFA_SUBMISSION_MANAGER
 * @since 1.0.0
 */

namespace Includes\Plugins\Notification;

use Includes\Models\UserDevicesModel;
use Includes\Plugins\Language;
use Includes\Plugins\Notification\AbstractFormNotification;
use Includes\Models\SupportedPluginsModel;
use Includes\Models\WEF\EntryModel;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Class WEFNotification
 *
 * Manipulate WEF Notification
 *
 * @since 1.0.0
 */
class WEFNotification extends AbstractFormNotification {

	/**
	 * Send push notification in bulk
	 *
	 * @param array $meta_value The meta_value of notification.
	 * @param int   $user_id The user ID.
	 *
	 * @return void
	 */
	public function create( $meta_value, $user_id = null ) {

		$supported_plugins_model_register = ( new SupportedPluginsModel() )->get_supported_plugin_by_slug( 'wef' );
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
			$push_notification_body = sprintf( __( 'New Form Submission Received from %1$s. Open app to view', 'afa-submission-manager' ), get_bloginfo( 'name' ) );

			$title = __( 'New Form Submission', 'afa-submission-manager' );

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
	 * @param int   $entry_id      The ID of the submitted entry.
	 * @param int   $form_id       The ID of the form that the submission belongs to.
	 * @param int   $page_id       The ID of the page where the form is embedded (if applicable).
	 * @param array $form_settings The settings of the form.
	 *
	 * @return void
	 */
	public function submission_notification( $entry_id, $form_id, $page_id, $form_settings ) {
		$entry_model = new EntryModel();
		$entry       = $entry_model->entry_by_id( $entry_id );

		if ( ! empty( $entry ) ) {

			$notification_data['entry_id']    = (int) $entry['id'];
			$notification_data['post_type']   = '';
			$notification_data['post_tiltle'] = '';

			$notification_data['user_id'] = null;
			if ( ! empty( $entry['created_by'] ) ) {
				$notification_data['user_id'] = (int) $entry['created_by'];
			}

			$this->create( $notification_data, $notification_data['user_id'] );
		}
	}

	/**
	 * Load hooks for notifications
	 *
	 * @return void
	 */
	public function loads_hooks() {
		add_action( 'weforms_entry_submission', array( $this, 'submission_notification' ), 10, 4 );
	}

}
