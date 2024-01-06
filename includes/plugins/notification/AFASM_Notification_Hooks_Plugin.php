<?php
/**
 * The Notification Hooks Plugin Class.
 *
 * @package  claud/afa-submission-manager
 * @since 1.0.0
 */

namespace AFASM\Includes\Plugins\Notification;

use AFASM\Includes\Plugins\Notification\AFASM_CF7_Notification;
use AFASM\Includes\Plugins\Notification\AFASM_GF_Notification;
use AFASM\Includes\Plugins\Notification\AFASM_WPF_Notification;
use AFASM\Includes\Plugins\Notification\AFASM_WEF_Notification;
use AFASM\Includes\Plugins\Notification\AFASM_EFB_Notification;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Class NotificationHooksPlugin
 *
 * Load Notifications Hooks
 *
 * @since 1.0.0
 */
class AFASM_Notification_Hooks_Plugin {

	/**
	 * Load hooks for notifications
	 *
	 * @return void
	 */
	public function loads_hooks() {
		( new AFASM_CF7_Notification() )->loads_hooks();
		( new AFASM_WPF_Notification() )->loads_hooks();
		( new AFASM_WEF_Notification() )->loads_hooks();
		( new AFASM_GF_Notification() )->loads_hooks();
		( new AFASM_EFB_Notification() )->loads_hooks();
	}


}
