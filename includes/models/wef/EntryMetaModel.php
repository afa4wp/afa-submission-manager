<?php
/**
 * The Entry Meta Model Class.
 *
 * @package  AFA_SUBMISSION_MANAGER
 * @since 1.0.0
 */

namespace Includes\Models\WEF;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Class EntryMetaModel
 *
 * Hendler with gf_entry_meta table
 *
 * @since 1.0.0
 */
class EntryMetaModel {

	/**
	 * Table name witn entry
	 *
	 * @var string
	 */
	public const TABLE_NAME = 'weforms_entrymeta';

	/**
	 * Get entry_meta by entry ID
	 *
	 * @param int $entry_id The ID of the form submission entry.
	 *
	 * @return array
	 */
	public function entry_meta_by_entry_id( $entry_id ) {
		global $wpdb;

		if ( ! function_exists( 'weforms_get_entry_data' ) || ! function_exists( 'weforms_get_entry' ) ) {
			return array();
		}

		$table_name = $wpdb->prefix . self::TABLE_NAME;
		$query      = "
			SELECT *
			FROM $table_name
			WHERE weforms_entry_id = %d
		";

		$sql = $wpdb->prepare( $query, array( $entry_id ) ); // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
		// phpcs:ignore
		$results = $wpdb->get_results( $sql, OBJECT );

		$items      = array();
		$entry_data = weforms_get_entry_data( $entry_id );

		foreach ( $results as $key => $value ) {

			$item = array();

			$item['id']      = $value->meta_id;
			$entry           = weforms_get_entry( $value->weforms_entry_id );
			$item['form_id'] = $entry->form_id;

			$item['entry_id'] = $value->weforms_entry_id;

			$item['meta_key']   = $value->meta_key; // phpcs:ignore
			$item['meta_value'] = $value->meta_value; // phpcs:ignore

			$item['type']  = $entry_data['fields'][ $value->meta_key ]['type'];
			$item['label'] = $entry_data['fields'][ $value->meta_key ]['label'];

			$items[] = $item;

		}

		return $items;
	}

	/**
	 * Get entry_meta by answer
	 *
	 * @param string $answer The meta value.
	 * @param int    $offset The offset.
	 * @param int    $number_of_records_per_page The notifications per page.
	 *
	 * @return array
	 */
	public function search_entry_meta_answer( $answer, $offset, $number_of_records_per_page = 20 ) {
		global $wpdb;

		if ( ! function_exists( 'weforms_get_entry_data' ) || ! function_exists( 'weforms_get_entry' ) ) {
			return array();
		}

		$table_name = $wpdb->prefix . self::TABLE_NAME;
		$meta_value = '%' . $wpdb->esc_like( $answer ) . '%';

		$query = "
			SELECT *
			FROM $table_name
			WHERE meta_value LIKE %s
			ORDER BY meta_id DESC
			LIMIT %d, %d
		";
		$sql   = $wpdb->prepare( $query, array( $meta_value, $offset, $number_of_records_per_page ) ); // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared

		// phpcs:ignore
		$results = $wpdb->get_results( $sql, OBJECT );

		$items = array();

		foreach ( $results as $key => $value ) {

			$entry_data = weforms_get_entry_data( $value->weforms_entry_id );

			$item = array();

			$item['id']      = $value->meta_id;
			$entry           = weforms_get_entry( $value->weforms_entry_id );
			$item['form_id'] = $entry->form_id;

			$item['entry_id'] = $value->weforms_entry_id;

			$item['meta_key']   = $value->meta_key; // phpcs:ignore
			$item['meta_value'] = $value->meta_value; // phpcs:ignore

			$item['type']  = $entry_data['fields'][ $value->meta_key ]['type'];
			$item['label'] = $entry_data['fields'][ $value->meta_key ]['label'];

			$items[] = $item;

		}

		return $items;
	}

}
