<?php

require __DIR__ . '/vendor/autoload.php';

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
 * Update URI:        https://claudionhangapc.com
 * Text Domain:       afa-submission-manager
 * Domain Path:       /languages
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

define( 'AFA_SUBMISSION_MANAGER_PLUGIN_FILE', __FILE__ );
define( 'AFA_SUBMISSION_MANAGER_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'AFA_SUBMISSION_MANAGER_PLUGIN_LANGUAGE_FOLDER', dirname( plugin_basename( __FILE__ ) ) . '/languages' );

use Includes\Plugins\JWT\JWTPlugin;
use Includes\Routes\Route;
use Includes\Database\DatabaseInstaller;
use Includes\Admin\AdminOptions;
use Includes\Plugins\Constant;
use Includes\Plugins\Language;
use Includes\Plugins\Notification\NotificationHooksPlugin;

/**
 * Init api.
 */
function afa_submission_manager_rest_init() {
	$namespace = Constant::API_NAMESPACE . '/' . Constant::API_VERSION;
	( new Route( $namespace ) )->init();

	add_filter( 'rest_pre_dispatch', array( new JWTPlugin(), 'validate_token_rest_pre_dispatch' ), 10, 3 );
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

add_action( 'plugins_loaded', array( new Language(), 'all_forms_load_textdomain' ) );

add_filter( 'plugin_locale', array( new Language(), 'enforce_locale' ), 10, 2 );

( new NotificationHooksPlugin() )->loads_hooks();
