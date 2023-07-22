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

	const API_NAMESPACE                   = SELF::PLUGIN_LANGUAGE_DOMAIN;
	const API_VERSION                     = 'v1';
	const API_REFRESH_EXP_TOKEN_IN_MINUTE = 1;
	const API_ACCESS_EXP_TOKEN_IN_MINUTE  = 1;

	/*
	 * Define table name.
	 */
	const TABLE_USER_DEVICE               = self::PLUGIN_TABLE_PREFIX . 'user_devices';
	const TABLE_SUPPORTED_PLUGINS         = self::PLUGIN_TABLE_PREFIX . 'supported_plugins';
	const TABLE_NOTIFICATION_TYPE         = self::PLUGIN_TABLE_PREFIX . 'notification_type';
	const TABLE_NOTIFICATION_SUBSCRIPTION = self::PLUGIN_TABLE_PREFIX . 'notification_subscription';
	const TABLE_NOTIFICATION              = self::PLUGIN_TABLE_PREFIX . 'notification';

}
