<?php
/**
 * The Form Entry Helper Class.
 *
 * @package  claud/afa-submission-manager
 * @since 1.0.0
 */

namespace AFASM\Includes\Plugins\Helpers;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Class FormModelHelper
 *
 * Handler with pagination info.
 *
 * @since 1.0.0
 */
class AFASM_Entry_Model_Helper {
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

		$sql     = 'SELECT * FROM %i ORDER BY %i DESC LIMIT %d,%d';
		$sql     = $wpdb->prepare( $sql, array( $this->table_name_with_prefix, $order_by, $offset, $number_of_records_per_page ) );// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared 
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
		$sql      = 'SELECT * FROM %i WHERE %i = %d ';
		$sql      = $wpdb->prepare( $sql, array( $this->table_name_with_prefix, $id, $entry_id ) );// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared 
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

		$sql     = 'SELECT * FROM %i WHERE form_id = %d ORDER BY %i DESC LIMIT %d,%d';
		$sql     = $wpdb->prepare( $sql, array( $this->table_name_with_prefix, $form_id, $order_by, $offset, $number_of_records_per_page ) );// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared 
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

		$sql = 'SELECT count(*)  as number_of_rows FROM %i ';
		$sql = $wpdb->prepare( $sql, array( $this->table_name_with_prefix ) );// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
		// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
		$results        = $wpdb->get_results( $sql );// phpcs:ignore
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

		$sql            = 'SELECT count(*)  as number_of_rows FROM %i WHERE %i = %d ';
		$sql            = $wpdb->prepare( $sql, array( $this->table_name_with_prefix, $field, $form_id ) );// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
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
		$sql     = 'SELECT MAX(%i) FROM %i ';
		$sql     = $wpdb->prepare( $sql, array( $id, $this->table_name_with_prefix ) );// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
		$results = $wpdb->get_results( $sql,  OBJECT);// phpcs:ignore

		if ( empty( $results ) ) {
			return 0;
		}
		$max_property_name = $wpdb->prepare( 'MAX(%i)', $id );
		$last_inserted_id  = intval( reset( $results )->$max_property_name );
		return $last_inserted_id;
	}
}
