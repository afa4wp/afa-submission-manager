<?php
/**
 * The Entry Model Class.
 *
 * @package  AFA_SUBMISSION_MANAGER
 * @since 1.0.0
 */

namespace Includes\Models\WEF;

use Includes\Models\UserModel;
use Includes\Models\WEF\FormModel;
use Includes\Models\AbstractEntryModel;
use Includes\Plugins\Helpers\EntryModelHelper;

/**
 * Class AbstractEntryModel
 *
 * Create model functions
 *
 * @since 1.0.0
 */
class EntryModel extends AbstractEntryModel {

	/**
	 * Const to declare table name.
	 */
	public const TABLE_NAME = 'weforms_entries';

	/**
	 * The EntryModelHelper
	 *
	 * @var EntryModelHelper
	 */
	public $entry_model_helper;

	/**
	 * Table name with WP prefix
	 *
	 * @var string
	 */
	private $table_name_with_prefix;

	/**
	 * Entry model constructor
	 */
	public function __construct() {
		global $wpdb;
		$this->entry_model_helper     = new EntryModelHelper( self::TABLE_NAME );
		$this->table_name_with_prefix = $wpdb->prefix . self::TABLE_NAME;
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

		$results = $this->entry_model_helper->entries( $offset, $number_of_records_per_page, $order_by );

		$entries = $this->prepare_data( $results );

		return $entries;
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

		$results = $this->entry_model_helper->entry_by_id( $entry_id, $id );

		$entries = $this->prepare_data( $results );

		if ( empty( $entries ) ) {
			return array();
		}

		return $entries[0];
	}


	/**
	 * Get Forms entries
	 *
	 * @param int $form_id The form id.
	 * @param int $offset The offset.
	 * @param int $number_of_records_per_page The posts per page.
	 *
	 * @return array
	 */
	public function entries_by_form_id( $form_id, $offset, $number_of_records_per_page ) {

		$results = $this->entry_model_helper->entries_by_form_id( $form_id, $offset, $number_of_records_per_page, 'id' );
		$entries = $this->prepare_data( $results );
		return $entries;

	}

	/**
	 * Get form entries by user info
	 *
	 * @param string $user_info The user info.
	 * @param int    $offset The offset.
	 * @param int    $number_of_records_per_page The posts per page.
	 *
	 * @return array
	 */
	public function search_entries_by_user( $user_info, $offset, $number_of_records_per_page ) {
		global $wpdb;

		$sql = "SELECT fla.* FROM {$this->table_name_with_prefix} fla INNER JOIN {$wpdb->prefix}users wpu ON  
        fla.user_id = wpu.id WHERE wpu.user_login LIKE %s OR wpu.user_email LIKE %s ORDER BY fla.id DESC LIMIT %d,%d ";

		$user_info = '%' . $wpdb->esc_like( $user_info ) . '%';

		$sql     = $wpdb->prepare( $sql, array( $user_info, $user_info, $offset, $number_of_records_per_page ) );// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
		$results = $wpdb->get_results( $sql, OBJECT );// phpcs:ignore
		$entries = $this->prepare_data( $results );

		return $entries;

	}

	/**
	 * Count Forms entries
	 *
	 * @param int $form_id The form id.
	 *
	 * @return int
	 */
	public function mumber_of_items_by_form_id( $form_id ) {
		return $this->entry_model_helper->mumber_of_items_by_form_id( $form_id );
	}

	/**
	 * Count Forms entries
	 *
	 * @param string $user_info The user info.
	 *
	 * @return array
	 */
	public function mumber_of_items_by_user_info( $user_info ) {
		global $wpdb;

		$sql = "SELECT count(*)  as number_of_rows FROM {$this->table_name_with_prefix} fla INNER JOIN {$wpdb->prefix}users wpu ON  
        fla.user_id = wpu.id WHERE wpu.user_login LIKE  %s OR wpu.user_email LIKE %s ";

		$user_info = '%' . $wpdb->esc_like( $user_info ) . '%';

		$sql            = $wpdb->prepare( $sql, array( $user_info, $user_info ) );// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
		$results        = $wpdb->get_results( $sql, OBJECT );// phpcs:ignore
		$number_of_rows = intval( $results[0]->number_of_rows );

		return $number_of_rows;
	}

	/**
	 * Format Forms entries
	 *
	 * @param array|object $results The entries data.
	 *
	 * @return array
	 */
	public function prepare_data( $results ) {
		$entries = array();

		foreach ( $results as $key => $value ) {

			$entry = array();

			$entry['id']           = $value->id;
			$entry['form_id']      = $value->form_id;
			$entry['date_created'] = $value->created_at;
			$entry['created_by']   = $value->user_id;
			$entry['author_info']  = array();

			if ( ! empty( $value->user_id ) ) {
				$user_model           = new UserModel();
				$entry['author_info'] = $user_model->user_info_by_id( $value->user_id );
			}

			$form_model         = new FormModel();
			$entry['form_info'] = $form_model->form_by_id( $value->form_id );

			$entries[] = $entry;
		}

		return $entries;
	}

	/**
	 * Get the last  entry id
	 *
	 * @return int
	 */
	public function last_entry_id() {
		$result = $this->entry_model_helper->last_entry_id( 'id' );
		return $result;
	}
}
