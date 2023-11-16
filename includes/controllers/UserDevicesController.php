<?php
/**
 * The User Devices Controller Class.
 *
 * @package  AFA_SUBMISSION_MANAGER
 * @since 1.0.0
 */

namespace Includes\Controllers;

use Includes\Models\UserDevicesModel;
use Includes\Models\NotificationSubscriptionModel;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Class UserDevicesController
 *
 * Manipulate User device info
 *
 * @since 1.0.0
 */
class UserDevicesController {
	/**
	 * User Tokens Model
	 *
	 * @var UserDevicesModel
	 */
	private $user_devices_model;

	/**
	 * UserTokensController constructor.
	 */
	public function __construct() {
		$this->user_devices_model = new UserDevicesModel();
	}


	/**
	 * Create user device register.
	 *
	 * @param WP_REST_Request $request The request.
	 *
	 * @return int|false
	 */
	public function create( $request ) {

		$expo_token      = sanitize_text_field( $request['expo_token'] );
		$device_id       = sanitize_text_field( $request['device_id'] );
		$device_language = sanitize_text_field( $request['device_language'] );

		$user   = wp_get_current_user();
		$result = $this->user_devices_model->create_device_register_if_not_exist( $user->ID, $device_id, $device_language, $expo_token );

		if ( ! empty( $result ) ) {
			$notification_subscription_model = new NotificationSubscriptionModel();
			$notification_subscription_model->subscribe_user_all_notificions_by_expo_token( $expo_token );
		}
		return rest_ensure_response( $result );

	}

	/**
	 * Update language for user device register.
	 *
	 * @param WP_REST_Request $request The request.
	 *
	 * @return int|false
	 */
	public function language( $request ) {

		$device_id       = sanitize_text_field( $request['device_id'] );
		$device_language = sanitize_text_field( $request['device_language'] );

		$user   = wp_get_current_user();
		$result = $this->user_devices_model->language( $user->ID, $device_id, $device_language );
		return rest_ensure_response( $result );

	}


}
