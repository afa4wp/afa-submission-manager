<?php
/**
 * The Entry Meta Model Class.
 *
 * @package  WP_All_Forms_API
 * @since 1.0.0
 */

namespace Includes\Models\CF7;

use Includes\Models\CF7\FormModel;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
/**
 * Class EntryMetaModel
 *
 * Hendler with flamingo_inbound table
 *
 * @since 1.0.0
 */
class EntryMetaModel {

	/**
	 * Table name witn entry
	 *
	 * @var string
	 */
	private $post_type_entry;

	/**
	 * Table name with postmeta
	 *
	 * @var string
	 */
	private $post_meta_table;

	/**
	 * EntryMetaModel constructor.
	 */
	public function __construct() {
		$this->post_type_entry = 'flamingo_inbound';
		$this->post_meta_table = 'postmeta';
	}

	/**
	 * Get entry_meta by entry ID
	 *
	 * @param int $entry_id The ID of the form submission entry.
	 *
	 * @return array
	 */
	public function entry_meta_by_entry_id( $entry_id ) {

		if ( ! class_exists( '\Flamingo_Inbound_Message' ) ) {
			return array();
		}

		$post = new \Flamingo_Inbound_Message( $entry_id );

		if ( empty( $post->channel ) ) {
			return array();
		}

		$form = ( new FormModel() )->form_model_helper->form_by_channel( $post->channel );

		$form_id = null;
		if ( ! empty( $form ) ) {
			$form_id = $form->ID;
		}

		$items = array();

		foreach ( (array) $post->fields as $key => $value ) {
			$item = array();

			$item['id']         = null;
			$item['form_id']    = $form_id;
			$item['entry_id']   = $entry_id;
			$item['meta_key']   = null; // phpcs:ignore
			$item['meta_value'] = $value; // phpcs:ignore
			$item['type']       = 'text';
			$item['label']      = $key;
			$items[]            = $item;
		}

		return $items;
	}

	/**
	 * Get entry_meta by answer
	 *
	 * @param string $answer The meta value.
	 *
	 * @return array
	 */
	public function search_entry_meta_answer( $answer ) {
		global $wpdb;

		if ( ! class_exists( '\Flamingo_Inbound_Message' ) ) {
			return array();
		}

		$table_postmeta = $wpdb->prefix . $this->post_meta_table;
		$table_posts    = $wpdb->prefix . 'posts';

		$meta_value = '%' . $wpdb->esc_like( $answer ) . '%';

		$query = "
		SELECT wp_p.ID, wp_p.post_name, wp_pm.meta_id, wp_pm.meta_key, wp_pm.meta_value, wp_pm.post_id
		FROM $table_postmeta AS wp_pm
		INNER JOIN $table_posts AS wp_p ON wp_pm.post_id = wp_p.ID
		WHERE wp_pm.meta_value LIKE %s AND wp_p.post_type = %s
			";
		$sql   = $wpdb->prepare( $query, array( $meta_value, $this->post_type_entry ) );// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared

		// phpcs:ignore
		$results = $wpdb->get_results( $sql, OBJECT );

		$items = array();

		foreach ( $results as $key => $value ) {

			$post = new \Flamingo_Inbound_Message( $value->ID );

			$form_id = null;

			if ( ! empty( $post->channel ) ) {

				$form = ( new FormModel() )->form_model_helper->form_by_channel( $post->channel );

				if ( ! empty( $form ) ) {
					$form_id = $form->ID;
				}
			}

			$item = array();

			$item['id']         = $value->meta_id;
			$item['form_id']    = $form_id;
			$item['entry_id']   = $value->ID;
			$item['meta_key']   = null; // phpcs:ignore
			$item['meta_value'] = $value->meta_key; // phpcs:ignore
			$item['type']       = 'text';
			$item['label']      = $value->meta_value;

			$items[] = $item;
		}

		return $items;
	}


}
