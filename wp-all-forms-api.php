<?php

require __DIR__ . '/vendor/autoload.php';

/**
 * Plugin Name:       WP All Forms API
 * Plugin URI:        https://example.com/plugins/the-basics/
 * Description:       Este é um plugin que gera as rotas para obter os dados do site WordPress, permitindo requisições autencticadas usando jwt
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            claudionhangapc
 * Author URI:        https://claudionhangapc.com/
 * License:           GPL v2 or later
 * License URI:       https://claudionhangapc/gpl-2.0.html
 * Update URI:        https://claudionhangapc.com
 * Text Domain:       wp-all-forms-api
 * Domain Path:       /languages
 */

define( 'WP_ALL_FORMS_API_PLUGIN_FILE', __FILE__ );
define( 'WP_ALL_FORMS_API_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'WP_ALL_FORMS_API_PLUGIN_LANGUAGE_FOLDER', dirname( plugin_basename( __FILE__ ) ) . '/languages' );

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
function wp_all_forms_api_rest_init() {
	$namespace = Constant::API_NAMESPACE . '/' . Constant::API_VERSION;
	( new Route( $namespace ) )->init();

	add_filter( 'rest_pre_dispatch', array( new JWTPlugin(), 'validate_token_rest_pre_dispatch' ), 10, 3 );
}

/**
* Add actions
*/
add_action( 'rest_api_init', 'wp_all_forms_api_rest_init' );

/**
* Register hooks.
*/
register_activation_hook( WP_ALL_FORMS_API_PLUGIN_FILE, array( new DatabaseInstaller(), 'install' ) );


( new AdminOptions() )->init();

add_action( 'plugins_loaded', array( new Language(), 'wp_all_forms_load_textdomain' ) );

add_filter( 'plugin_locale', array( new Language(), 'enforce_locale' ), 10, 2 );

( new NotificationHooksPlugin() )->loads_hooks();
