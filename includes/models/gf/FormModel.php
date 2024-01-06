<?php
/**
 * The Form Model Class.
 *
 * @package  AFA_SUBMISSION_MANAGER
 * @since 1.0.0
 */

namespace Includes\Models\GF;

use AFASM\Includes\Plugins\Helpers\AFASM_Form_Model_Helper;
use Includes\Models\AbstractFormModel;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
/**
 * Class AbstractFormModel
 *
 * Create model functions
 *
 * @since 1.0.0
 */
class FormModel extends AbstractFormModel {

	/**
	 * Const to declare table name.
	 */
	const TABLE_NAME = 'gf_form';

	/**
	 * Const to declare shortcode.
	 */
	const SHORTCODE = 'gravityform';

	/**
	 * Table name with WP prefix
	 *
	 * @var string
	 */
	private $table_name_with_prefix;

	/**
	 * The AFASM_Form_Model_Helper
	 *
	 * @var AFASM_Form_Model_Helper
	 */
	public $form_model_helper;

	/**
	 * Form model constructor
	 */
	public function __construct() {
		global $wpdb;
		$this->form_model_helper      = new AFASM_Form_Model_Helper( '', self::TABLE_NAME );
		$this->table_name_with_prefix = $wpdb->prefix . self::TABLE_NAME;
	}

	/**
	 * Get Forms
	 *
	 * @param int $offset The offset.
	 * @param int $number_of_records_per_page The posts per page.
	 *
	 * @return array
	 */
	public function forms( $offset, $number_of_records_per_page ) {
		$results = $this->form_model_helper->forms( $offset, $number_of_records_per_page );

		$forms = $this->prepare_data( $results );

		return $forms;
	}

	/**
	 * Get Form by id
	 *
	 * @param int $id The form ID.
	 *
	 * @return array
	 */
	public function form_by_id( $id ) {
		$results = $this->form_model_helper->form_by_id( $id );

		$forms = $this->prepare_data( $results );

		if ( count( $forms ) > 0 ) {
			return $forms[0];
		}

		return $forms;
	}

	/**
	 * Get number of Forms
	 *
	 * @param string $post_name The post name.
	 *
	 * @return int
	 */
	public function mumber_of_items_by_search( $post_name ) {
		global $wpdb;

		$query = "SELECT count(*)  as number_of_rows FROM {$this->table_name_with_prefix} WHERE title LIKE %s ";

		$post_name_esc_like = '%' . $wpdb->esc_like( $post_name ) . '%';

		$sql = $wpdb->prepare( $query, array( $post_name_esc_like ) ); // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared

		// phpcs:ignore
		$results = $wpdb->get_results( $sql, OBJECT );

		$number_of_rows = intval( $results[0]->number_of_rows );

		return $number_of_rows;
	}

	/**
	 * Format Forms
	 *
	 * @param array $results The forms.
	 *
	 * @return array
	 */
	public function prepare_data( $results ) {
		if ( ! class_exists( '\GFAPI' ) ) {
			return array();
		}

		$forms = array();

		foreach ( $results as $value ) {

			$form = array();

			$form['id']           = $value->id;
			$form['title']        = $value->title;
			$form['date_created'] = $value->date_created;
			$form['registers']    = \GFAPI::count_entries( $value->id );
			$form['user_created'] = null;
			$form['perma_links']  = parent::pages_links( $value->id, self::SHORTCODE );

			$forms[] = $form;
		}

		return $forms;
	}

	/**
	 * Search Forms
	 *
	 * @param string $post_name The post name.
	 * @param int    $offset The offset.
	 * @param int    $number_of_records_per_page The posts per page.
	 *
	 * @return array
	 */
	public function search_forms( $post_name, $offset, $number_of_records_per_page ) {

		global $wpdb;

		$query = "SELECT * FROM {$this->table_name_with_prefix} WHERE title LIKE %s ORDER BY id DESC LIMIT %d,%d";

		$post_name_esc_like = '%' . $wpdb->esc_like( $post_name ) . '%';

		$sql = $wpdb->prepare( $query, array( $post_name_esc_like, $offset, $number_of_records_per_page ) );// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared 

		// phpcs:ignore 
		$results = $wpdb->get_results( $sql, OBJECT );

		$forms = $this->prepare_data( $results );

		return $forms;
	}

	/**
	 * Count number of forms created by logged user
	 *
	 * @since 1.0.0
	 *
	 * @param int $user_id The user id.
	 *
	 * @return int
	 */
	public function user_form_count( $user_id ) {
		if ( ! class_exists( '\GFAPI' ) ) {
			return 0;
		}

		$args = array(
			'created_by' => $user_id,
			'status'     => 'active',
		);

		$forms = \GFAPI::get_forms( $args );
		$count = count( $forms );

		return $count;
	}


}
