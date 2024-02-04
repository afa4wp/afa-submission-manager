<?php
/**
 * The Constants.
 *
 * @package  claud/afa-submission-manager
 * @since 1.0.0
 */

namespace AFASM\Includes\Plugins;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Class Constant
 *
 * Create all constants
 *
 * @since 1.0.0
 */
class AFASM_Constant {

	const PLUGIN_VERSION         = '1.0';
	const PLUGIN_LANGUAGE_DOMAIN = 'afa-submission-manager';
	const PLUGIN_TABLE_PREFIX    = 'afasm_';

	const API_NAMESPACE                   = self::PLUGIN_LANGUAGE_DOMAIN;
	const API_VERSION                     = 'v1';
	const API_REFRESH_EXP_TOKEN_IN_MINUTE = 43200;
	const API_ACCESS_EXP_TOKEN_IN_MINUTE  = 15;

	/*
	 * Define table name.
	 */
	const TABLE_USER_DEVICE               = self::PLUGIN_TABLE_PREFIX . 'user_devices';
	const TABLE_SUPPORTED_PLUGINS         = self::PLUGIN_TABLE_PREFIX . 'supported_plugins';
	const TABLE_NOTIFICATION_TYPE         = self::PLUGIN_TABLE_PREFIX . 'notification_type';
	const TABLE_NOTIFICATION_SUBSCRIPTION = self::PLUGIN_TABLE_PREFIX . 'notification_subscription';
	const TABLE_NOTIFICATION              = self::PLUGIN_TABLE_PREFIX . 'notification';
	const TABLE_USER_QR_CODES             = self::PLUGIN_TABLE_PREFIX . 'user_qr_codes';

	/*
	 * Define form slug.
	 */
	const FORM_SLUG_CF7 = 'cf7';
	const FORM_SLUG_GF  = 'gf';
	const FORM_SLUG_WEF = 'wef';
	const FORM_SLUG_WPF = 'wpf';
	const FORM_SLUG_EFB = 'efb';
}
