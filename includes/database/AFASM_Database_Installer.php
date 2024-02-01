<?php
/**
 * The DatabaseInstaller Class.
 *
 * @package  claud/afa-submission-manager
 * @since 1.0.0
 */

namespace AFASM\Includes\Database;

use AFASM\Includes\Database\AFASM_User_Tokens;
use AFASM\Includes\Database\AFASM_User_QR_Codes;
use AFASM\Includes\Database\AFASM_User_Devices;
use AFASM\Includes\Database\AFASM_Supported_Plugins;
use AFASM\Includes\Database\AFASM_Notification_Type;
use AFASM\Includes\Database\AFASM_Notification_Subscription;
use AFASM\Includes\Database\AFASM_Notification;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Class DatabaseInstaller
 *
 * Create tables on install
 *
 * @since 1.0.0
 */
class AFASM_Database_Installer {

	/**
	 * Create tables.
	 */
	public function install() {
		( new AFASM_User_Tokens() )->create_table();
		( new AFASM_User_QR_Codes() )->create_table();
		( new AFASM_User_Devices() )->create_table();
		( new AFASM_Supported_Plugins() )->create_table();
		( new AFASM_Notification_Type() )->create_table();
		( new AFASM_Notification_Subscription() )->create_table();
		( new AFASM_Notification() )->create_table();

		$this->create_secret_key_if_is_not_defined();
	}

	/**
	 * Create secret key if is not defined .
	 */
	public function create_secret_key_if_is_not_defined() {

		if ( ! defined( 'WP_AFA_ACCESS_TOKEN_SECRET_KEY' ) || empty( WP_AFA_ACCESS_TOKEN_SECRET_KEY ) ) {
			add_option( 'WP_AFA_ACCESS_TOKEN_SECRET_KEY', base64_encode( openssl_random_pseudo_bytes( 30 ) ), '', false ); // phpcs:ignore
		}

		if ( ! defined( 'WP_AFA_REFRESH_TOKEN_SECRET_KEY' ) || empty( WP_AFA_REFRESH_TOKEN_SECRET_KEY ) ) {
			add_option( 'WP_AFA_REFRESH_TOKEN_SECRET_KEY', base64_encode( openssl_random_pseudo_bytes( 30 ) ), '', false ); // phpcs:ignore
		}

	}

}
