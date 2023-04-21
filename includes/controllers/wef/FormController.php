<?php
/**
 * The Form Controller Class.
 *
 * @package  WP_All_Forms_API
 * @since 1.0.0
 */

namespace Includes\Controllers\WEF;

use Includes\Models\WEF\FormModel;
use Includes\Controllers\AbstractFormControllers;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Class FormController
 *
 * Init all routes
 *
 * @since 1.0.0
 */
class FormController extends AbstractFormControllers {

	/**
	 * The form model
	 *
	 * @var FormModel
	 */
	private $form_model;

	/**
	 * Form Controllers constructor
	 */
	public function __construct() {
		parent::__construct();
		$this->form_model = new FormModel();
	}

	/**
	 * WEF forms.
	 *
	 * @return array $forms WEF forms.
	 */
	public function forms() {
		$count = $this->form_model->mumberItems();

		$offset = 0;

		$forms = $this->form_model->forms( $offset, $this->number_of_records_per_page );

		$forms_results = $this->pagination_helper->prepare_data_for_rest_with_pagination( $count, $forms );

		return rest_ensure_response( $forms_results );
	}

	/**
	 * WEF forms.
	 *
	 * @param WP_REST_Request $request The request.
	 *
	 * @return object $form WEF form.
	 */
	public function form_by_id( $request ) {
		$id = $request['id'];

		$form = $this->form_model->formByID( $id );

		return rest_ensure_response( $form );
	}

	/**
	 * WEF forms.
	 *
	 * @param WP_REST_Request $request The request.
	 *
	 * @return array $forms WEF forms.
	 */
	public function forms_pagination( $request ) {
		$page = $request['page_number'];

		$count = $this->form_model->mumberItems();

		$offset = $this->pagination_helper->get_offset( $page, $count );

		$forms = $this->form_model->forms( $offset, $this->number_of_records_per_page );

		$forms_results = $this->pagination_helper->prepare_data_for_rest_with_pagination( $count, $forms );

		return rest_ensure_response( $forms_results );
	}

	/**
	 * WEF forms.
	 *
	 * @param WP_REST_Request $request The request.
	 *
	 * @return array $forms WEF forms.
	 */
	public function search_forms( $request ) {
		$page = 1;

		$post_name = urldecode( $request['post_name'] );

		$count = $this->form_model->mumberItemsByPostTitle( $post_name );

		$offset = $this->pagination_helper->get_offset( $page, $count );

		$forms = $this->form_model->searchForms( $post_name, $offset, $this->number_of_records_per_page );

		$forms_results = $this->pagination_helper->prepare_data_for_rest_with_pagination( $count, $forms );

		return rest_ensure_response( $forms_results );

	}

}
