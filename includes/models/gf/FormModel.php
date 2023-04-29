<?php
/**
 * The Form Model Class.
 *
 * @package  WP_All_Forms_API
 * @since 1.0.0
 */

namespace Includes\Models\GF;

use Includes\Plugins\Helpers\FormsShortcodeFinder;
use Includes\Plugins\Helpers\FormModelHelper;
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
	 * The FormModelHelper
	 *
	 * @var FormModelHelper
	 */
	public $form_model_helper;

	/**
	 * Form model constructor
	 */
	public function __construct() {
		$this->form_model_helper = new FormModelHelper( SELF::TABLE_NAME );
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
	 * Get Forms
	 *
	 * @return int
	 */
	public function mumberItemsOnSerach( $post_name ) {
		 global $wpdb;

		$results = $wpdb->get_results( 'SELECT count(*)  as number_of_rows FROM ' . $wpdb->prefix . self::TABLE_NAME . "  WHERE title LIKE '%$post_name%' " );

		$number_of_rows = intval( $results[0]->number_of_rows );

		return $number_of_rows;
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

		$results = $wpdb->get_results( 'SELECT * FROM ' . $wpdb->prefix . self::TABLE_NAME . " WHERE title LIKE '%$post_name%' ORDER BY id DESC LIMIT " . $offset . ',' . $number_of_records_per_page, OBJECT );

		$forms = $this->prepare_data( $results );

		return $forms;
	}

	/**
	 * Format Forms
	 *
	 * @param object $posts The forms.
	 *
	 * @return array
	 */
	public function prepare_data( $results ) {
		$forms = array();

		foreach ( $results as $key => $value ) {

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

}
