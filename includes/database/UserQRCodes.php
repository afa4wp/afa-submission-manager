<?php

namespace Includes\Database;

class UserQRCodes {

	private $dataBaseName;

	public function __construct() {
		 $this->dataBaseName = $_ENV['DATA_BASE_PREFIX'] . 'user_qr_codes';
	}
	/**
	 * create fra_user_tokens table .
	 */
	public function createTable() {

		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		global $wpdb;

		$sql = 'CREATE TABLE IF NOT EXISTS ' . $wpdb->prefix . $this->dataBaseName . ' (
        id BIGINT(20) NOT NULL AUTO_INCREMENT,
        user_id BIGINT(20)  UNSIGNED NOT NULL,
        secret VARCHAR(255) NOT NULL,
		created_at DATETIME NOT NULL,
		expire_secret DATETIME NOT NULL,
        PRIMARY KEY(id),
        FOREIGN KEY(user_id) REFERENCES ' . $wpdb->prefix . 'users(ID),
        UNIQUE(secret),
      )' . $wpdb->get_charset_collate();

		 dbDelta( $sql );
	}

}
