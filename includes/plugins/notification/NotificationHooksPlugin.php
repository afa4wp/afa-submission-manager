<?php
/**
 * The Notification Hooks Plugin Class.
 *
 * @package  WP_All_Forms_API
 * @since 1.0.0
 */

namespace Includes\Plugins\Notification;

use Includes\Plugins\Notification\CF7Notification;
use Includes\Plugins\Notification\GFNotification;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Class NotificationHooksPlugin
 *
 * Load Notifications Hooks
 *
 * @since 1.0.0
 */
class NotificationHooksPlugin {

	/**
	 * Load hooks for notifications
	 *
	 * @return void
	 */
	public function loads_hooks() {
		( new CF7Notification() )->loads_hooks();
		( new GFNotification() )->loads_hooks();
	}


}
