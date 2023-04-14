<?php

namespace Includes\Models;

class UserTokensModel {


	private $table_name;

	public function __construct() {
		global $wpdb;
		$this->table_name = $wpdb->prefix . $_ENV['DATA_BASE_PREFIX'] . 'user_tokens';
	}

	/**
	 * Verify if Refresh token exist
	 *
	 * @param string $user_id The user ID
	 * @param string $refresh_token The user refresh token
	 *
	 * @return bool
	 */
	public function checkIfRefreshTokenExist( $user_id, $refresh_token ) {
		global $wpdb;

		$results = $wpdb->get_results( 'SELECT * FROM ' . $this->table_name . " WHERE user_id = $user_id", OBJECT );

		if ( ! ( count( $results ) > 0 ) ) {
			return false;
		}

		if ( hash_equals( $results[0]->refresh_token, hash( 'sha256', $refresh_token ) ) ) {
			return true;
		}

		return false;
	}

	/**
	 * Create new token register
	 *
	 * @param string $user_id The user ID
	 * @param string $access_token The user access token
	 * @param string $refresh_token The user refresh token
	 *
	 * @return int|false
	 */
	public function create( $user_id, $access_token, $refresh_token ) {
		 global $wpdb;

		$item = array(
			'user_id'       => $user_id,
			'access_token'  => hash( 'sha256', $access_token ),
			'refresh_token' => hash( 'sha256', $refresh_token ),
			'created_at'    => date( 'Y-m-d H:i:s' ),
		);

		$results = $wpdb->insert(
			$this->table_name,
			$item
		);

		return $results;
	}

	 /**
	  * Delete token register
	  *
	  * @return int|false
	  */
	public function deleteUserTokenByID( $user_id ) {
		global $wpdb;

		$item = array(
			'user_id' => $user_id,
		);

		$results = $wpdb->delete(
			$this->table_name,
			$item
		);

		return $results;
	}

	/**
	 * Get UserTokens
	 *
	 * @return array
	 */
	public function usersTokens( $offset, $number_of_records_per_page ) {
		global $wpdb;

		$results = $wpdb->get_results( 'SELECT afa_ut.id, afa_ut.user_id, wp_u.display_name, wp_u.user_login FROM ' . $this->table_name . ' afa_ut INNER JOIN ' . $wpdb->prefix . 'users wp_u ON afa_ut.user_id = wp_u.ID', ARRAY_A );

		return $results;
	}

	/**
	 * Get number of items
	 *
	 * @return int
	 */
	public function mumber_items() {

		global $wpdb;

		$results = $wpdb->get_results( 'SELECT count(*) as number_of_rows FROM ' . $this->table_name);

		$number_of_rows = intval( $results[0]->number_of_rows );

		return $number_of_rows;
	}


}
