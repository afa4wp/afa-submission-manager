<?php
/**
 * The Form Entry Helper Class.
 *
 * @package  AFA_SUBMISSION_MANAGER
 * @since 1.0.0
 */

namespace Includes\Plugins\Helpers;

/**
 * Class FormModelHelper
 *
 * Handler with pagination info.
 *
 * @since 1.0.0
 */
class EntryModelHelper {
	/**
	 * Table name with WP prefix
	 *
	 * @var string
	 */
	private $table_name_with_prefix;

	/**
	 * Entry Model Helper constructor
	 *
	 * @param string $table_name The table name.
	 */
	public function __construct( $table_name ) {
		global $wpdb;
		$this->table_name_with_prefix = $wpdb->prefix . $table_name;
	}

	/**
	 * Get form entries
	 *
	 * @param int    $offset The offset.
	 * @param int    $number_of_records_per_page The posts per page.
	 * @param string $order_by The column name.
	 *
	 * @return array
	 */
	public function entries( $offset, $number_of_records_per_page, $order_by = 'id' ) {
		global $wpdb;

		$sql     = "SELECT * FROM {$this->table_name_with_prefix} ORDER BY {$order_by} DESC LIMIT %d,%d";
		$sql     = $wpdb->prepare( $sql, array( $offset, $number_of_records_per_page ) );// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared 
		$results = $wpdb->get_results( $sql, OBJECT );// phpcs:ignore

		return $results;
	}

	/**
	 * Get form entries
	 *
	 * @param int    $entry_id The form id.
	 * @param string $id The field.
	 *
	 * @return array
	 */
	public function entry_by_id( $entry_id, $id = 'id' ) {
		global $wpdb;
		$entry_id = (int) $entry_id;
		$sql      = "SELECT * FROM {$this->table_name_with_prefix} WHERE {$id} = %d ";
		$sql      = $wpdb->prepare( $sql, array( $entry_id ) );// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared 
		$results = $wpdb->get_results( $sql, OBJECT );// phpcs:ignore

		return $results;
	}

	/**
	 * Get Forms entries
	 *
	 * @param int    $form_id The form id.
	 * @param int    $offset The offset.
	 * @param int    $number_of_records_per_page The posts per page.
	 * @param string $order_by The column name.
	 *
	 * @return array
	 */
	public function entries_by_form_id( $form_id, $offset, $number_of_records_per_page, $order_by = 'id' ) {
		global $wpdb;

		$sql     = "SELECT * FROM {$this->table_name_with_prefix} WHERE form_id = %d ORDER BY {$order_by} DESC LIMIT %d,%d";
		$sql     = $wpdb->prepare( $sql, array( $form_id, $offset, $number_of_records_per_page ) );// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared 
		$results = $wpdb->get_results( $sql, OBJECT );// phpcs:ignore

		return $results;
	}

	/**
	 * Get number of entries
	 *
	 * @return int
	 */
	public function mumber_of_items() {
		global $wpdb;

		// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
		$results        = $wpdb->get_results( "SELECT count(*)  as number_of_rows FROM {$this->table_name_with_prefix} " );// phpcs:ignore
		$number_of_rows = intval( $results[0]->number_of_rows );

		return $number_of_rows;
	}

	/**
	 * Get Forms
	 *
	 * @param int    $form_id The form id.
	 * @param string $field   The field to filter by (default: 'form_id').
	 *
	 * @return int
	 */
	public function mumber_of_items_by_form_id( $form_id, $field = 'form_id' ) {
		global $wpdb;

		$sql            = "SELECT count(*)  as number_of_rows FROM {$this->table_name_with_prefix} WHERE {$field} = %d ";
		$sql            = $wpdb->prepare( $sql, array( $form_id ) );// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
		$results        = $wpdb->get_results( $sql, OBJECT ); // phpcs:ignore
		$number_of_rows = intval( $results[0]->number_of_rows );

		return $number_of_rows;
	}

	/**
	 * Get the last  entry id
	 *
	 * @param string $id The field.
	 *
	 * @return int
	 */
	public function last_entry_id( $id = 'id' ) {
		global $wpdb;
		$sql     = "SELECT MAX({$id}) FROM {$this->table_name_with_prefix} ";
		$results = $wpdb->get_results( $sql,  OBJECT);// phpcs:ignore

		if ( empty( $results ) ) {
			return 0;
		}
		$last_inserted_id = intval( reset( $results )->{"MAX({$id})"} );
		return $last_inserted_id;
	}
}
