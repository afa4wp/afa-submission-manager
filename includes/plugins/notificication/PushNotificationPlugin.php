<?php
/**
 * The Push Notification Plugin Class.
 *
 * @package  WP_All_Forms_API
 * @since 1.0.0
 */

namespace Includes\Plugins\Notification;

use ExpoSDK\Expo;
use ExpoSDK\ExpoMessage;
use Includes\Models\UserDevicesModel;
use Exception;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

Expo::addDevicesNotRegisteredHandler(
	function ( $tokens ) {
		// this callback is called once and receives an array of unregistered tokens.

		$user_devices_model = new UserDevicesModel();

		foreach ( $tokens as $key => $value ) {
			$user_devices_model->delete_register_by_expo_token( $value );
		}

	}
);

/**
 * Class QRCode
 *
 * Manipulate QRCode view
 *
 * @since 1.0.0
 */
class PushNotificationPlugin {

	/**
	 * Generate new QRCode
	 *
	 * @param string $title The title to display in the notification.
	 * @param string $body The message to display in the notification.
	 * @param string $exponent_token An Expo push token.
	 * @param array  $data A JSON object delivered to your app.
	 *
	 * @return string
	 */
	public function generate_push_notification_for_single_exponent_token( $title, $body, $exponent_token, $data = array() ) {

		$message = ( new ExpoMessage(
			array(
				'title' => $title,
				'body'  => $body,
				'to'    => $exponent_token,
			)
		) )
		->setData( $data )
		->setChannelId( 'default' )
		->setBadge( 0 )
		->playSound();

		$expo = new Expo();

		$response = $expo->send( $message )->push();

		return $response->getData()[0]['status'];
	}

}
