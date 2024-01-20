<?php
/**
 * The Form Model Class.
 *
 * @package  claud/afa-submission-manager
 * @since 1.0.0
 */

namespace AFASM\Includes\Models\WPF;

use AFASM\Includes\Plugins\Helpers\AFASM_Form_Model_Helper;
use AFASM\Includes\Models\AFASM_Abstract_Form_Model;
use AFASM\Includes\Models\AFASM_User_Model;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class AbstractFormModel
 *
 * Create model functions
 *
 * @since 1.0.0
 */
class AFASM_Form_Model extends AFASM_Abstract_Form_Model {

	/**
	 * Const to declare shortcode.
	 */
	const SHORTCODE = 'wpforms';

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
		$this->form_model_helper = new AFASM_Form_Model_Helper( self::SHORTCODE );
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
		$posts = $this->form_model_helper->forms( $offset, $number_of_records_per_page );

		$forms = $this->prepare_data( $posts );

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

		$forms = $this->prepare_data_array( $results );

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
	public function mumber_of_items() {
		return wp_count_posts( 'wpforms' )->publish;
	}

	/**
	 * Get Forms
	 *
	 * @param string $post_name The post name.
	 * @param int    $offset The offset.
	 * @param int    $number_of_records_per_page The posts per page.
	 *
	 * @return array
	 */
	public function search_forms( $post_name, $offset, $number_of_records_per_page ) {
		$posts = $this->form_model_helper->search_forms( $post_name, $offset, $number_of_records_per_page );

		$forms = $this->prepare_data( $posts );

		return $forms;
	}

	/**
	 * Format Forms
	 *
	 * @param object $posts The forms.
	 *
	 * @return array
	 */
	public function prepare_data( $posts ) {
		if ( ! function_exists( 'wpforms' ) ) {
			return array();
		}

		$forms      = array();
		$user_model = new AFASM_User_Model();

		while ( $posts->have_posts() ) {

			$posts->the_post();

			$form['id']           = $posts->post->ID;
			$form['title']        = $posts->post->post_title;
			$form['date_created'] = $posts->post->post_date;

			$form['registers'] = wpforms()->entry->get_entries(
				array(
					'form_id' => $posts->post->ID,
				),
				true
			);

			$form['user_created'] = $user_model->user_info_by_id( $posts->post->post_author );
			$form['perma_links']  = parent::pages_links( $posts->post->ID, self::SHORTCODE );

			$forms[] = $form;
		}

		return $forms;
	}

	/**
	 * Format Forms for array from sql
	 *
	 * @param array $results The forms.
	 *
	 * @return array
	 */
	private function prepare_data_array( $results ) {
		if ( ! function_exists( 'wpforms' ) ) {
			return array();
		}

		$forms      = array();
		$user_model = new AFASM_User_Model();

		foreach ( $results as $value ) {

			$form = array();

			$form['id']           = $value->ID;
			$form['title']        = $value->post_title;
			$form['date_created'] = $value->post_date;

			$form['registers'] = wpforms()->entry->get_entries(
				array(
					'form_id' => $value->ID,
				),
				true
			);

			$form['user_created'] = $user_model->user_info_by_id( $value->post_author );
			$form['perma_links']  = parent::pages_links( $value->ID, self::SHORTCODE );
			$forms[]              = $form;
		}

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
		return $this->form_model_helper->get_user_form_count_by_id( $user_id );
	}

}
