<?php
/**
 * The Form Controller Class.
 *
 * @package  AFA_SUBMISSION_MANAGER
 * @since 1.0.0
 */

namespace Includes\Controllers\WPF;

use AFASM\Includes\Models\WPF\AFASM_Form_Model;
use Includes\Controllers\AbstractFormControllers;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Class FormController
 *
 * Create control functions
 *
 * @since 1.0.0
 */
class FormController extends AbstractFormControllers {

	/**
	 * The form model
	 *
	 * @var AFASM_Form_Model
	 */
	private $form_model;

	/**
	 * Form Controllers constructor
	 */
	public function __construct() {
		parent::__construct();
		$this->form_model = new AFASM_Form_Model();
	}

	/**
	 * WPF forms.
	 *
	 * @return array $forms GF forms.
	 */
	public function forms() {
		$count = $this->form_model->mumber_of_items();

		$offset = 0;

		$forms = $this->form_model->forms( $offset, $this->number_of_records_per_page );

		$forms_results = $this->pagination_helper->prepare_data_for_rest_with_pagination( $count, $forms );

		return rest_ensure_response( $forms_results );
	}

	/**
	 * WPF forms.
	 *
	 * @param WP_REST_Request $request The request.
	 *
	 * @return aobject $form WPF form.
	 */
	public function form_by_id( $request ) {
		$id = absint( $request['id'] );

		$form = $this->form_model->form_by_id( $id );

		return rest_ensure_response( $form );
	}

	/**
	 * WPF forms.
	 *
	 * @param WP_REST_Request $request The request.
	 *
	 * @return array $forms GF forms.
	 */
	public function forms_pagination( $request ) {
		$page = absint( $request['page_number'] );

		$count = $this->form_model->mumber_of_items();

		$offset = $this->pagination_helper->get_offset( $page );

		$forms = $this->form_model->forms( $offset, $this->number_of_records_per_page );

		$forms_results = $this->pagination_helper->prepare_data_for_rest_with_pagination( $count, $forms );

		return rest_ensure_response( $forms_results );
	}

	/**
	 * WEF forms.
	 *
	 * @param WP_REST_Request $request The request.
	 *
	 * @return array $forms WPF forms.
	 */
	public function search_forms( $request ) {
		$post_name = sanitize_text_field( urldecode( $request['post_name'] ) );

		$count = $this->form_model->form_model_helper->mumber_of_items_by_post_title( $post_name );

		$page = 1;

		$offset = $this->pagination_helper->get_offset( $page );

		$forms = $this->form_model->search_forms( $post_name, $offset, $this->number_of_records_per_page );

		$forms_results = $this->pagination_helper->prepare_data_for_rest_with_pagination( $count, $forms );

		return rest_ensure_response( $forms_results );

	}

}
