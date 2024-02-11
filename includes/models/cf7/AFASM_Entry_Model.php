<?php
/**
 * The Entry Model Class.
 *
 * @package  claud/afa-submission-manager
 * @since 1.0.0
 */

namespace AFASM\Includes\Models\CF7;

use AFASM\Includes\Models\AFASM_User_Model;
use AFASM\Includes\Models\CF7\AFASM_Form_Model;
use AFASM\Includes\Models\AFASM_Abstract_Entry_Model;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class AbstractEntryModel
 *
 * Create model functions
 *
 * @since 1.0.0
 */
class AFASM_Entry_Model extends AFASM_Abstract_Entry_Model {

	/**
	 * Const to declare table name.
	 */
	public const TABLE_NAME = 'posts';

	/**
	 * The post type entry
	 *
	 * @var string
	 */
	private $post_type_entry;

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
		$this->post_type_entry        = 'flamingo_inbound';
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
	public function entries( $offset, $number_of_records_per_page, $order_by = 'DESC' ) {

		if ( ! class_exists( '\Flamingo_Inbound_Message' ) ) {
			return array();
		}

		$results = \Flamingo_Inbound_Message::find(
			array(
				'posts_per_page' => $number_of_records_per_page,
				'offset'         => $offset,
				'order'          => $order_by,
			)
		);

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
	public function entry_by_id( $entry_id, $id = null ) {

		if ( ! class_exists( '\Flamingo_Inbound_Message' ) ) {
			return array();
		}

		$post = new \Flamingo_Inbound_Message( $entry_id );

		$results = array();

		if ( empty( $post->channel ) ) {
			return $results;
		}

		$results[] = $post;

		$entries = $this->prepare_data( $results );

		if ( empty( $entries ) ) {
			return array();
		}

		return $entries[0];
	}

	/**
	 * Get form entries
	 *
	 * @param int $form_id The form id.
	 * @param int $offset The offset.
	 * @param int $number_of_records_per_page The posts per page.
	 *
	 * @return array
	 */
	public function entries_by_form_id( $form_id, $offset, $number_of_records_per_page ) {

		if ( ! class_exists( '\Flamingo_Inbound_Message' ) ) {
			return array();
		}

		$form_model = new AFASM_Form_Model();
		$channel    = $form_model->form_model_helper->form_chanel_by_id( $form_id );

		$results = \Flamingo_Inbound_Message::find(
			array(
				'channel'        => $channel,
				'posts_per_page' => $number_of_records_per_page,
				'offset'         => $offset,
				'order'          => 'DESC',
			)
		);

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

		$sql = 'SELECT fla.ID, fla.post_type FROM %i fla INNER JOIN %i wpu ON  
        fla.post_author = wpu.id WHERE fla.post_type = %s AND ( wpu.user_login LIKE %s OR wpu.user_email LIKE %s ) ORDER BY fla.id DESC LIMIT  %d,%d';

		$user_info = '%' . $wpdb->esc_like( $user_info ) . '%';
		$sql       = $wpdb->prepare( $sql, array( $this->table_name_with_prefix, $wpdb->users, $this->post_type_entry, $user_info, $user_info, $offset, $number_of_records_per_page ) );// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
		$results   = $wpdb->get_results( $sql, OBJECT );// phpcs:ignore
		$entries   = array();

		foreach ( $results as $value ) {
			$entries[] = $this->entry_by_id( $value->ID );
		}

		return $entries;
	}

	/**
	 * Get number of entries
	 *
	 * @return int
	 */
	public function mumber_of_items() {
		global $wpdb;

		$sql            = 'SELECT count(*)  as number_of_rows FROM %i WHERE post_type = %s ';
		$sql            = $wpdb->prepare( $sql, array( $this->table_name_with_prefix, $this->post_type_entry ) );// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
		$results        = $wpdb->get_results( $sql, OBJECT );// phpcs:ignore
		$number_of_rows = intval( $results[0]->number_of_rows );

		return $number_of_rows;
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

		$sql = 'SELECT count(*)  as number_of_rows FROM %i fla INNER JOIN  %i wpu ON  
        fla.post_author = wpu.id WHERE fla.post_type = %s AND ( wpu.user_login LIKE %s OR wpu.user_email LIKE %s ) ';

		$user_info      = '%' . $wpdb->esc_like( $user_info ) . '%';
		$sql            = $wpdb->prepare( $sql, array( $this->table_name_with_prefix, $wpdb->users, $this->post_type_entry, $user_info, $user_info ) );// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
		$results        = $wpdb->get_results( $sql, OBJECT );// phpcs:ignore
		$number_of_rows = intval( $results[0]->number_of_rows );

		return $number_of_rows;
	}

	/**
	 * Get Forms
	 *
	 * @param string $channel The post_name.
	 *
	 * @return int
	 */
	public function mumber_of_items_by_Channel( $channel ) {

		if ( ! class_exists( '\Flamingo_Inbound_Message' ) ) {
			return 0;
		}

		$args        = array( 'channel' => $channel );
		$total_items = \Flamingo_Inbound_Message::count( $args );
		return $total_items;
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

		foreach ( $results as $value ) {

			$form_model    = new AFASM_Form_Model();
			$post          = $form_model->form_model_helper->form_by_channel( $value->channel );
			$flamingo_post = get_post( $value->id() );

			$entry = array();

			$entry['id']           = $value->id();
			$entry['form_id']      = $value->meta['post_id'];
			$entry['date_created'] = '';
			$entry['created_by']   = '';
			$entry['author_info']  = (object) array();
			$entry['form_info']    = (object) array();

			if ( $post ) {
				$entry['date_created'] = $flamingo_post->post_date;
			}

			$user = get_user_by( 'ID', $flamingo_post->post_author );

			if ( $user ) {
				$user_model           = new AFASM_User_Model();
				$entry['created_by']  = $user->ID;
				$entry['author_info'] = $user_model->user_info_by_id( $user->ID );
			}

			if ( $post ) {
				$entry['form_info'] = $form_model->form_by_id( $post->ID );
			}

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
		global $wpdb;
		$sql     = 'SELECT MAX(ID) FROM %i WHERE post_type = %s ';
		$sql     = $wpdb->prepare( $sql, array( $this->table_name_with_prefix, $this->post_type_entry ) );// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
		$results = $wpdb->get_results( $sql,  OBJECT);// phpcs:ignore

		if ( empty( $results ) ) {
			return 0;
		}
		$last_inserted_id = intval( reset( $results )->{'MAX(ID)'} );
		return $last_inserted_id;
	}

}
