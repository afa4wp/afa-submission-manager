<?php
/**
 * The Abstarct Entry Model Class.
 *
 * @package  WP_All_Forms_API
 * @since 1.0.0
 */

namespace Includes\Models;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Class AbstractEntryModel
 *
 * Init all routes
 *
 * @since 1.0.0
 */
abstract class AbstractEntryModel {

	/**
	 * Get entry by id
	 *
	 * @since 1.0.0
	 *
	 * @param int $id The form id.
	 *
	 * @return object|array $entry WPAFA form
	 */
	abstract public function entries_by_form_id( $id );

	/**
	 * Get all entries
	 *
	 * @since 1.0.0
	 *
	 * @param int $offset The offset.
	 * @param int $number_of_records_per_page The posts per page.
	 *
	 * @return array $forms WPAFA entries
	 */
	abstract public function entries( $offset, $number_of_records_per_page );

	/**
	 * Search entries by user info.
	 *
	 * @since 1.0.0
	 *
	 * @param string $user_info The user info.
	 * @param int    $offset The offset.
	 * @param int    $number_of_records_per_page The posts per page.
	 *
	 * @return array $forms WPAFA entries
	 */
	abstract public function search_entries_by_user( $user_info, $offset, $number_of_records_per_page );

	/**
	 * Farmat data
	 *
	 * @since 1.0.0
	 *
	 * @param array|object $data The entries data.
	 *
	 * @return array $forms WPAFA entries
	 */
	abstract public function prepare_data( $data );

}
