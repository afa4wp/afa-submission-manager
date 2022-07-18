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

use Routes\UserRoute;
use Routes\PingRoute;


function oi_mark_api_inituu(){
  // definindo a name-space
  $name_space = "wp-general-rest-api/v1";

  $novoUser =  new UserRoute($name_space);
  $ping   = new PingRoute($name_space);

  $ping->initRoutes();
  $novoUser->initRoutes();

  // pre hendler
  //add_filter('rest_pre_dispatch','oi_mark_api_rest_pre_dispatchi',10,3);
 

}

function oi_mark_api_rest_pre_dispatchi($url, $server, $request){}


add_action('rest_api_init','oi_mark_api_inituu');
//add_action('init', 'oi_mark_api_init');