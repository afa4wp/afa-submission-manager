<?php

namespace Includes\Database;

class UserTokens {

	private $dataBaseName;

	public function __construct() {
		 $this->dataBaseName = $_ENV['DATA_BASE_PREFIX'] . 'user_tokens';
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
        access_token VARCHAR(255) NOT NULL,
        refresh_token VARCHAR(255) NOT NULL,
		created_at DATETIME NOT NULL,
        PRIMARY KEY(id),
        FOREIGN KEY(user_id) REFERENCES ' . $wpdb->prefix . 'users(ID),
        UNIQUE(access_token),
        UNIQUE(refresh_token)
      )' . $wpdb->get_charset_collate();

		 dbDelta( $sql );
	}

}
