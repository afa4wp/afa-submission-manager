<?php
/**
 * The Entry Meta Model Class.
 *
 * @package  claud/afa-submission-manager
 * @since 1.0.0
 */

namespace AFASM\Includes\Models\EFB;

use AFASM\Includes\Models\EFB\AFASM_Entry_Model;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class EntryMetaModel
 *
 * Hendler with gf_entry_meta table
 *
 * @since 1.0.0
 */
class AFASM_Entry_Meta_Model {

	/**
	 * Table name witn entry
	 *
	 * @var string
	 */
	public const TABLE_NAME = 'e_submissions_values';

	/**
	 * Get entry_meta by entry ID
	 *
	 * @param int $entry_id The ID of the form submission entry.
	 *
	 * @return array
	 */
	public function entry_meta_by_entry_id( $entry_id ) {
		global $wpdb;

		$table_name = $wpdb->prefix . self::TABLE_NAME;
		$query      = "
			SELECT *
			FROM $table_name
			WHERE submission_id = %d
		";

		$sql = $wpdb->prepare( $query, array( $entry_id ) ); // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
		// phpcs:ignore
		$results = $wpdb->get_results( $sql, OBJECT );

		$items = array();

		$entry                    = ( new AFASM_Entry_Model() )->entry_by_id( $entry_id );
		$elementor_forms_snapshot = $this->get_elementor_forms_snapshot( $entry['form_id'], $entry['elementor_form_id'] );
		foreach ( $results as $key => $value ) {

			$item = array();

			$item['id'] = $value->id;

			$item['form_id'] = $entry['form_id'];

			$item['entry_id'] = $value->submission_id;

			$item['meta_key']   = $value->key; // phpcs:ignore
			$item['meta_value'] = $value->value; // phpcs:ignore

			$label = $value->key;
			if ( ! empty( $elementor_forms_snapshot ) ) {
				$label_from_snapshot_entry = $this->get_label_from_snapshot_entry( $elementor_forms_snapshot, $value->key );
				$label                     = $label_from_snapshot_entry ? $label_from_snapshot_entry : $label;
			}
			$item['type']  = $value->key;
			$item['label'] = $label;

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

		$table_name = $wpdb->prefix . self::TABLE_NAME;
		$meta_value = '%' . $wpdb->esc_like( $answer ) . '%';

		$query = "
			SELECT *
			FROM $table_name
			WHERE value LIKE %s
			ORDER BY id DESC
			LIMIT %d, %d
		";
		$sql   = $wpdb->prepare( $query, array( $meta_value, $offset, $number_of_records_per_page ) ); // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared

		// phpcs:ignore
		$results = $wpdb->get_results( $sql, OBJECT );

		$items = array();

		foreach ( $results as $key => $value ) {

			$entry                    = ( new AFASM_Entry_Model() )->entry_by_id( $value->submission_id );
			$elementor_forms_snapshot = $this->get_elementor_forms_snapshot( $entry['form_id'], $entry['elementor_form_id'] );

			$item = array();

			$item['id'] = $value->id;

			$item['form_id'] = $entry['form_id'];

			$item['entry_id'] = $value->submission_id;

			$item['meta_key']   = $value->key; // phpcs:ignore
			$item['meta_value'] = $value->value; // phpcs:ignore

			$label = $value->key;
			if ( ! empty( $elementor_forms_snapshot ) ) {
				$label_from_snapshot_entry = $this->get_label_from_snapshot_entry( $elementor_forms_snapshot, $value->key );
				$label                     = $label_from_snapshot_entry ? $label_from_snapshot_entry : $label;
			}
			$item['type']  = $value->key;
			$item['label'] = $label;

			$items[] = $item;

		}

		return $items;
	}

	/**
	 * Retrieve Elementor Forms Snapshot Data
	 *
	 * Retrieves Elementor Forms Snapshot data for a specific post and Elementor Form ID.
	 *
	 * @param int    $post_id               The ID of the WordPress post containing the snapshot data.
	 * @param string $elementor_form_id     The Elementor Form ID as a string to identify the specific form.
	 *
	 * @return array|null                  An array containing the Elementor Forms Snapshot data if found, or null if not found.
	 */
	public function get_elementor_forms_snapshot( $post_id, $elementor_form_id ) {

		$meta_key   = '__elementor_forms_snapshot';
		$meta_value = get_post_meta( $post_id, $meta_key, true );

		$meta_value_array = json_decode( $meta_value, true );

		if ( is_array( $meta_value_array ) ) {
			$elementor_form_id = $elementor_form_id;
			foreach ( $meta_value_array as $item ) {
				if ( isset( $item['id'] ) && $item['id'] === $elementor_form_id ) {
					return $item;
				}
			}
		}

		return null;
	}

	/**
	 * Get Label from Elementor Forms Snapshot Entry
	 *
	 * Retrieves the label from an Elementor Forms Snapshot entry based on the provided field ID.
	 *
	 * @param array  $snapshot_entry   The Elementor Forms Snapshot entry as an associative array.
	 * @param string $field_id         The ID of the field for which to retrieve the label.
	 *
	 * @return string|null            The label of the field if found, or null if the field ID is not found.
	 */
	public function get_label_from_snapshot_entry( $snapshot_entry, $field_id ) {

		if ( is_array( $snapshot_entry ) && isset( $snapshot_entry['fields'] ) ) {
			foreach ( $snapshot_entry['fields'] as $field ) {
				if ( isset( $field['id'] ) && $field['id'] === $field_id && isset( $field['label'] ) ) {
					return $field['label'];
				}
			}
		}

		return null;
	}

}
