<?php
/**
 * The Entry Meta Model Class.
 *
 * @package  claud/afa-submission-manager
 * @since 1.0.0
 */

namespace AFASM\Includes\Models\WPF;

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

	public const TABLE_NAME = 'wpforms_entries';

	/**
	 * Get entry_meta by entry ID
	 *
	 * @param int $entry_id The ID of the form submission entry.
	 *
	 * @return array
	 */
	public function entry_meta_by_entry_id( $entry_id ) {
		if ( ! function_exists( 'wpforms' ) || ! function_exists( 'wpforms_decode' ) ) {
			return array();
		}

		$entry   = wpforms()->entry->get( $entry_id, array( 'cap' => false ) );
		$results = wpforms_decode( $entry->fields );

		$items = array();

		foreach ( $results as $key => $value ) {

			$item = array();

			$item['id']         = $key;
			$item['form_id']    = $entry->form_id;
			$item['entry_id']   = $entry->entry_id;
			$item['meta_key']   = $value['id']; // phpcs:ignore
			$item['meta_value'] = $value['value']; // phpcs:ignore

			$item['type']  = $value['type'];
			$item['label'] = $value['name'];

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
		if ( ! function_exists( 'wpforms' ) ) {
			return array();
		}

		$args = array(
			'select'        => 'all',
			'value'         => $answer,
			'value_compare' => 'contains',
		);

		$results = wpforms()->get( 'entry_fields' )->get_fields( $args );

		$items = array();

		foreach ( $results as $key => $value ) {

			$meta = $this->get_type_and_label( $value->entry_id, $value->field_id );

			$item = array();

			$item['id']         = $value->id;
			$item['form_id']    = $value->form_id;
			$item['entry_id']   = $value->entry_id;
			$item['meta_key']   = $value->field_id; // phpcs:ignore
			$item['meta_value'] = $value->value; // phpcs:ignore
			$item['type']       = $meta['type'];
			$item['label']      = $meta['label'];

			$items[] = $item;

		}

		return $items;

	}

	/**
	 * Get label and type
	 *
	 * @param int $entry_id The ID of the form submission entry.
	 * @param int $meta_key The meta_key.
	 *
	 * @return array
	 */
	private function get_type_and_label( $entry_id, $meta_key ) {
		if ( ! function_exists( 'wpforms' ) || ! function_exists( 'wpforms_decode' ) ) {
			return array();
		}

		$entry = wpforms()->entry->get( $entry_id, array( 'cap' => false ) );

		$results = wpforms_decode( $entry->fields );

		$item          = array();
		$item['type']  = '';
		$item['label'] = '';

		foreach ( $results as $key => $value ) {

			if ( $value['id'] === $meta_key ) {
				$item['type']  = $value['type'];
				$item['label'] = $value['name'];
			}
		}

		return $item;

	}


}
