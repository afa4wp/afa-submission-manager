<?php
/**
 * The Entry Meta Model Class.
 *
 * @package  WP_All_Forms_API
 * @since 1.0.0
 */

namespace Includes\Models\GF;

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
	public const TABLE_NAME = 'gf_entry_meta';

	/**
	 * Get entry_meta by entry ID
	 *
	 * @param int $entry_id The ID of the form submission entry.
	 *
	 * @return array
	 */
	public function entry_meta_by_entry_id( $entry_id ) {
		if ( ! class_exists( '\GFAPI' ) ) {
			return array();
		}

		$entry = \GFAPI::get_entry( $entry_id );

		$form_id = $entry['form_id'];

		$form = \GFAPI::get_form( $form_id );

		$items = array();

		foreach ( $form['fields'] as $key => $value ) {

			$item = array();

			$item['id']         = null;
			$item['form_id']    = $form_id;
			$item['entry_id']   = $entry_id;
			$item['meta_key']   = $value->id; // phpcs:ignore
			$item['meta_value'] = $entry[ $value->id ]; // phpcs:ignore
			$item['type']       = $value->type;
			$item['label']      = $value->label;

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

		if ( ! class_exists( '\GFAPI' ) ) {
			return array();
		}

		$table_name = $wpdb->prefix . self::TABLE_NAME;
		$meta_value = '%' . $wpdb->esc_like( $answer ) . '%';

		$query = "
			SELECT *
			FROM $table_name
			WHERE meta_value LIKE %s
			ORDER BY id DESC
			LIMIT %d, %d
		";

		$sql = $wpdb->prepare( $query, array( $meta_value, $offset, $number_of_records_per_page ) );// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
		// phpcs:ignore
		$results = $wpdb->get_results( $sql, OBJECT );

		$items = array();

		foreach ( $results as $key => $value ) {

			$item = array();

			$item['id']         = $value->id;
			$item['form_id']    = $value->form_id;
			$item['entry_id']   = $value->entry_id;
			$item['meta_key']   = $value->meta_key; // phpcs:ignore
			$item['meta_value'] = $value->meta_value; // phpcs:ignore

			$item['type']  = '';
			$item['label'] = '';

			$field = \GFAPI::get_field( $value->form_id, $value->meta_key );
			if ( ! empty( $field ) ) {
				if ( isset( $field->type ) ) {
					$item['type'] = $field->type;
				}
				if ( isset( $field->label ) ) {
					$item['label'] = $field->label;
				}
			}

			$items[] = $item;
		}

		return $items;
	}

}
