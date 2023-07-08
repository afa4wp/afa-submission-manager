<?php
/**
 * The DatabaseInstaller Class.
 *
 * @package  WP_All_Forms_API
 * @since 1.0.0
 */

namespace Includes\Database;

use Includes\Database\UserTokens;
use Includes\Database\UserQRCodes;
use Includes\Database\UserDevices;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Class DatabaseInstaller
 *
 * Create tables on install
 *
 * @since 1.0.0
 */
class DatabaseInstaller {

	/**
	 * Create tables.
	 */
	public function install() {
		( new UserTokens() )->create_table();
		( new UserQRCodes() )->create_table();
		( new UserDevices() )->create_table();

		$this->create_secret_key_if_is_not_defined();
	}

	/**
	 * Create secret key if is not defined .
	 */
	public function create_secret_key_if_is_not_defined() {

		if ( ! defined( 'WP_AFA_ACCESS_TOKEN_SECRET_KEY' ) || empty( WP_AFA_ACCESS_TOKEN_SECRET_KEY ) ) {
			add_option( 'WP_AFA_ACCESS_TOKEN_SECRET_KEY', base64_encode( openssl_random_pseudo_bytes( 30 ) ), '', false );
		}

		if ( ! defined( 'WP_AFA_REFRESH_TOKEN_SECRET_KEY' ) || empty( WP_AFA_REFRESH_TOKEN_SECRET_KEY ) ) {
			add_option( 'WP_AFA_REFRESH_TOKEN_SECRET_KEY', base64_encode( openssl_random_pseudo_bytes( 30 ) ), '', false );
		}

	}

}
