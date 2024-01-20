<?php
/**
 * The Abstarct Entry Model Class.
 *
 * @package  claud/afa-submission-manager
 * @since 1.0.0
 */

namespace AFASM\Includes\Models;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class AbstractEntryModel
 *
 * Init all routes
 *
 * @since 1.0.0
 */
abstract class AFASM_Abstract_Entry_Model {


	/**
	 * Get entry by id
	 *
	 * @since 1.0.0
	 *
	 * @param int    $entry_id The form id.
	 * @param string $id The field.
	 *
	 * @return object|array $entry AFA form
	 */
	abstract public function entry_by_id( $entry_id, $id );

	/**
	 * Get entry by form id
	 *
	 * @since 1.0.0
	 *
	 * @param int $id The form id.
	 * @param int $offset The offset.
	 * @param int $number_of_records_per_page The posts per page.
	 *
	 * @return object|array $entry AFA form
	 */
	abstract public function entries_by_form_id( $id, $offset, $number_of_records_per_page );

	/**
	 * Get all entries
	 *
	 * @since 1.0.0
	 *
	 * @param int    $offset The offset.
	 * @param int    $number_of_records_per_page The posts per page.
	 * @param string $order_by The column name.
	 *
	 * @return array $forms AFA entries
	 */
	abstract public function entries( $offset, $number_of_records_per_page, $order_by);

	/**
	 * Search entries by user info.
	 *
	 * @since 1.0.0
	 *
	 * @param string $user_info The user info.
	 * @param int    $offset The offset.
	 * @param int    $number_of_records_per_page The posts per page.
	 *
	 * @return array $forms AFA entries
	 */
	abstract public function search_entries_by_user( $user_info, $offset, $number_of_records_per_page );

	/**
	 * Farmat data
	 *
	 * @since 1.0.0
	 *
	 * @param array|object $data The entries data.
	 *
	 * @return array $forms AFA entries
	 */
	abstract public function prepare_data( $data );

}
