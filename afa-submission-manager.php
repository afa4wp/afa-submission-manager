<?php
/**
 * Plugin Name:       AFA - Mobile-Ready Submission Manager
 * Plugin URI:        https://github.com/afa-submission-manager/afa-submission-manager
 * Description:       Simplify form management and gain insights with our robust WordPress plugin.
 * Version:           1.1.0
 * Requires at least: 5.0
 * Requires PHP:      7.0
 * Author:            claudionhangapc, marciogoes
 * Author URI:        https://claudionhangapc.com/
 * License:           GPL v2 or later
 * License URI:       https://claudionhangapc/gpl-2.0.html
 * Text Domain:       afa-submission-manager
 * Domain Path:       /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

require __DIR__ . '/vendor/autoload.php';

define( 'AFA_SUBMISSION_MANAGER_PLUGIN_FILE', __FILE__ );
define( 'AFA_SUBMISSION_MANAGER_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'AFA_SUBMISSION_MANAGER_PLUGIN_LANGUAGE_FOLDER', dirname( plugin_basename( __FILE__ ) ) . '/languages' );

use AFASM\Includes\Plugins\JWT\AFASM_JWT_Plugin;
use Includes\Routes\Route;
use Includes\Database\DatabaseInstaller;
use Includes\Admin\AdminOptions;
use AFASM\Includes\Plugins\AFASM_Constant;
use AFASM\Includes\Plugins\AFASM_Language;
use AFASM\Includes\Plugins\Notification\AFASM_Notification_Hooks_Plugin;

/**
 * Init api.
 */
function afa_submission_manager_rest_init() {
	$namespace = AFASM_Constant::API_NAMESPACE . '/' . AFASM_Constant::API_VERSION;
	( new Route( $namespace ) )->init();

	add_filter( 'rest_pre_dispatch', array( new AFASM_JWT_Plugin(), 'validate_token_rest_pre_dispatch' ), 10, 3 );
}

/**
* Add actions
*/
add_action( 'rest_api_init', 'afa_submission_manager_rest_init' );

/**
* Register hooks.
*/
register_activation_hook( AFA_SUBMISSION_MANAGER_PLUGIN_FILE, array( new DatabaseInstaller(), 'install' ) );


( new AdminOptions() )->init();

add_action( 'plugins_loaded', array( new AFASM_Language(), 'all_forms_load_textdomain' ) );

add_filter( 'plugin_locale', array( new AFASM_Language(), 'enforce_locale' ), 10, 2 );

( new AFASM_Notification_Hooks_Plugin() )->loads_hooks();
