<?php
/**
 * The User Devices Controller Class.
 *
 * @package  WP_All_Forms_API
 * @since 1.0.0
 */

namespace Includes\Controllers;

use Includes\Models\UserDevicesModel;

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

		$expo_token      = $request['expo_token'];
		$device_id       = $request['device_id'];
		$device_language = $request['device_language'];

		$user   = wp_get_current_user();
		$result = $this->user_devices_model->create( $user->ID, $device_id, $device_language, $expo_token );
		return rest_ensure_response( $result );

	}



}
