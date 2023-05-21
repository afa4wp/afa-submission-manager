<?php
/**
 * The Constants.
 *
 * @package  WP_All_Forms_API
 * @since 1.0.0
 */

namespace Includes\Plugins;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
/**
 * Class Constant
 *
 * Create all constants
 *
 * @since 1.0.0
 */
class Constant {

	const PLUGIN_VERSION         = '1.0';
	const PLUGIN_LANGUAGE_DOMAIN = 'wp-all-forms-api';
	const PLUGIN_TABLE_PREFIX    = 'afa_';

	const API_NAMESPACE                   = 'wp-forms-rest-api';
	const API_VERSION                     = 'v1';
	const API_REFRESH_EXP_TOKEN_IN_MINUTE = 1;
	const API_ACCESS_EXP_TOKEN_IN_MINUTE  = 1;


}
