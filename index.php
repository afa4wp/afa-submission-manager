<?php

require __DIR__ . '/vendor/autoload.php';

/**
 * Plugin Name:       WP General Rest API
 * Plugin URI:        https://example.com/plugins/the-basics/
 * Description:       Este é um plugin que gera as rotas para obter os dados do site wordpress, permitindo requisições autencticadas usando jwt
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            claudionhangapc
 * Author URI:        https://author.example.com/
 * License:           GPL v2 or later
 * License URI:       https://claudionhangapc/gpl-2.0.html
 * Update URI:        https://oimark.com.br/
 * Text Domain:       https://oimark.com.br/
 */

define('GENERAL_REST_API_PLUGIN', __FILE__);

use Plugins\JWT\JWTPlugin;
use Routes\PingRoute;
use Routes\UserRoute;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();


// DataBase
use Database\DatabaseInstaller;

function wp_general_rest_api_init()
{
    //  name-space
    $name_space =  $_ENV['NAME_SPACE'];

    // init all route
    (new PingRoute($name_space))->initRoutes();
    (new UserRoute($name_space))->initRoutes();
    

    // pre hendler
    add_filter('rest_pre_dispatch', [new JWTPlugin, 'validateTokenRestPreDispatch'], 10, 3);

}


// init api
add_action('rest_api_init', 'wp_general_rest_api_init');

// create table on install plugin
function wp_general_rest_api_installer(){
  
    (new DatabaseInstaller())->install();
  
}


// Hooks 
register_activation_hook(GENERAL_REST_API_PLUGIN, 'wp_general_rest_api_installer');
