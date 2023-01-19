<?php

require __DIR__ . '/vendor/autoload.php';

/**
 * Plugin Name:       WP Forms Rest API
 * Plugin URI:        https://example.com/plugins/the-basics/
 * Description:       Este é um plugin que gera as rotas para obter os dados do site wordpress, permitindo requisições autencticadas usando jwt
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            claudionhangapc
 * Author URI:        https://claudionhangapc.com/
 * License:           GPL v2 or later
 * License URI:       https://claudionhangapc/gpl-2.0.html
 * Update URI:        https://claudionhangapc.com
 * Text Domain:       https://claudionhangapc.com
 */

define('WP_FORMS_REST_API_PLUGIN', __FILE__);

use Includes\Plugins\JWT\JWTPlugin;
use Includes\Routes\Route;
use Includes\Database\DatabaseInstaller;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

/**
* Init api.
*/
function wp_forms_rest_api_init()
{
    $name_space =  $_ENV['API_NAME_SPACE'];
    (new Route($name_space) )->init();
 
    //add_filter('rest_pre_dispatch', [new JWTPlugin, 'validateTokenRestPreDispatch'], 10, 3);
}

/**
* Add actions 
*/
add_action('rest_api_init', 'wp_forms_rest_api_init');

/**
* Register hooks.
*/
register_activation_hook(WP_FORMS_REST_API_PLUGIN, [new DatabaseInstaller, 'install']);
