<?php
/**
 * The User Tokens Model Class.
 *
 * @package  claud/afa-submission-manager
 * @since 1.0.0
 */

namespace AFASM\Includes\Models;

use AFASM\Includes\Plugins\AFASM_Constant;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class UserTokensModel
 *
 * Manipulate User logged info
 *
 * @since 1.0.0
 */
class AFASM_User_Tokens_Model {

	/**
	 * Table name
	 *
	 * @var string
	 */
	private $table_name;

	/**
	 * UserQRCodeModel constructor.
	 */
	public function __construct() {
		global $wpdb;
		$this->table_name = $wpdb->prefix . AFASM_Constant::PLUGIN_TABLE_PREFIX . 'user_tokens';
	}

	/**
	 * Verify if Refresh token exist
	 *
	 * @param string $user_id The user ID.
	 * @param string $refresh_token The user refresh token.
	 *
	 * @return bool
	 */
	public function check_if_refresh_token_exist( $user_id, $refresh_token ) {
		global $wpdb;
		$sql     = 'SELECT * FROM %i WHERE user_id = %d';
		$results = $wpdb->get_results( $wpdb->prepare( $sql, array( $this->table_name, $user_id ) ), OBJECT ); // phpcs:ignore

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
	 * @param int    $user_id The user ID.
	 * @param string $access_token The user access token.
	 * @param string $refresh_token The user refresh token.
	 *
	 * @return int|false
	 */
	public function create( $user_id, $access_token, $refresh_token ) {
		global $wpdb;

		$item = array(
			'user_id'       => $user_id,
			'access_token'  => hash( 'sha256', $access_token ),
			'refresh_token' => hash( 'sha256', $refresh_token ),
			'created_at'    => gmdate( 'Y-m-d H:i:s' ),
		);

		// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery
		$results = $wpdb->insert(
			$this->table_name,
			$item
		);

		return $results;
	}

	/**
	 * Delete token register
	 *
	 * @param string $user_id The user ID.
	 *
	 * @return int|false
	 */
	public function delete_user_token_by_id( $user_id ) {
		global $wpdb;

		$item = array(
			'user_id' => $user_id,
		);

		$item_format = array(
			'%d',
		);

		// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
		$results = $wpdb->delete(
			$this->table_name,
			$item,
			$item_format
		);

		return $results;
	}

	/**
	 * Get UserTokens
	 *
	 * @param int $offset The offset page.
	 * @param int $number_of_records_per_page The number of items.
	 *
	 * @return array
	 */
	public function users_tokens( $offset = 0, $number_of_records_per_page = 20 ) {

		global $wpdb;

		$sql = 'SELECT afasm_ut.id, afasm_ut.user_id, wp_u.display_name, wp_u.user_login FROM %i afasm_ut INNER JOIN %i wp_u ON afasm_ut.user_id = wp_u.ID ORDER BY id DESC LIMIT %d,%d';

		$sql = $wpdb->prepare( $sql, array( $this->table_name, $wpdb->users, $offset, $number_of_records_per_page ) );// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared

		// phpcs:ignore
		$results = $wpdb->get_results( $sql, ARRAY_A );

		return $results;
	}

	/**
	 * Get UserTokens
	 *
	 * @param string $user_info The user info.
	 * @param int    $offset The offset page.
	 * @param int    $number_of_records_per_page The number of items.
	 *
	 * @return array
	 */
	public function search_users_tokens( $user_info, $offset = 0, $number_of_records_per_page = 20 ) {

		global $wpdb;

		$sql = 'SELECT afasm_ut.id, afasm_ut.user_id, wp_u.display_name, wp_u.user_login FROM %i afasm_ut INNER JOIN %i wp_u ON afasm_ut.user_id = wp_u.ID WHERE wp_u.user_login LIKE %s OR wp_u.user_email LIKE %s OR wp_u.display_name LIKE %s ORDER BY id DESC LIMIT %d,%d';

		$user_info = '%' . $wpdb->esc_like( $user_info ) . '%';

		$sql = $wpdb->prepare( $sql, array( $this->table_name, $wpdb->users, $user_info, $user_info, $user_info, $offset, $number_of_records_per_page ) );// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared

		// phpcs:ignore 
		$results = $wpdb->get_results( $sql, ARRAY_A );

		return $results;
	}

	/**
	 * Get number of items
	 *
	 * @return int
	 */
	public function mumber_items() {

		global $wpdb;

		$sql = 'SELECT count(*) as number_of_rows FROM %i';

		$sql = $wpdb->prepare( $sql, array( $this->table_name ) );// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared

		// phpcs:ignore 
		$results = $wpdb->get_results( $sql );

		$number_of_rows = intval( $results[0]->number_of_rows );

		return $number_of_rows;
	}

	/**
	 * Get number of items by search
	 *
	 * @param string $user_info The user info.
	 *
	 * @return int
	 */
	public function mumber_items_search( $user_info ) {

		global $wpdb;

		$sql = 'SELECT count(*) as number_of_rows FROM %i afasm_ut INNER JOIN %i wp_u ON afasm_ut.user_id = wp_u.ID WHERE wp_u.user_login LIKE %s OR wp_u.user_email LIKE %s OR wp_u.display_name LIKE %s';

		$user_info = '%' . $wpdb->esc_like( $user_info ) . '%';

		$sql = $wpdb->prepare( $sql, array( $this->table_name, $wpdb->users, $user_info, $user_info, $user_info ) );// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared

		// phpcs:ignore
		$results = $wpdb->get_results( $sql, OBJECT );

		$number_of_rows = intval( $results[0]->number_of_rows );

		return $number_of_rows;
	}

}
