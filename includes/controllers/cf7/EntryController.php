<?php
/**
 * The Entry Controllers Class.
 *
 * @package  AFA_SUBMISSION_MANAGER
 * @since 1.0.0
 */

namespace Includes\Controllers\CF7;

use AFASM\Includes\Models\CF7\AFASM_Entry_Model;
use AFASM\Includes\Models\CF7\AFASM_Form_Model;
use Includes\Controllers\AbstractEntryControllers;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Class EntryController
 *
 * Init all routes
 *
 * @since 1.0.0
 */
class EntryController extends AbstractEntryControllers {

	/**
	 * The form model
	 *
	 * @var AFASM_Entry_Model
	 */
	private $entry_model;

	/**
	 * Entry Controllers constructor
	 */
	public function __construct() {
		parent::__construct();
		$this->entry_model = new AFASM_Entry_Model();
	}

	/**
	 * CF7 forms entry.
	 *
	 * @return array $forms CF7 forms.
	 */
	public function entries() {
		$count = $this->entry_model->mumber_of_items();

		$offset = 0;

		$entries = $this->entry_model->entries( $offset, $this->number_of_records_per_page );

		$entries_results = $this->pagination_helper->prepare_data_for_rest_with_pagination( $count, $entries );

		return rest_ensure_response( $entries_results );
	}

	/**
	 * CF7 forms entry.
	 *
	 * @param WP_REST_Request $request The request.
	 *
	 * @return array $forms CF7 forms.
	 */
	public function entry_by_id( $request ) {
		$entry_id = absint( $request['entry_id'] );

		$entry = $this->entry_model->entry_by_id( $entry_id );

		return rest_ensure_response( $entry );

	}

	/**
	 * CF7 forms entries by id.
	 *
	 * @param WP_REST_Request $request The request.
	 *
	 * @return array $forms CF7 forms.
	 */
	public function entries_by_form_id( $request ) {
		$form_id = absint( $request['form_id'] );

		$page = absint( $request['page_number'] );

		$form_model = new AFASM_Form_Model();

		$channel = $form_model->form_chanel_by_id( $form_id );

		$count = $this->entry_model->mumber_of_items_by_Channel( $channel );

		$offset = $this->pagination_helper->get_offset( $page );

		$entries = $this->entry_model->entries_by_form_id( $form_id, $offset, $this->number_of_records_per_page );

		$entries_results = $this->pagination_helper->prepare_data_for_rest_with_pagination( $count, $entries );

		return rest_ensure_response( $entries_results );
	}

	/**
	 * CF7 forms entries by user info.
	 *
	 * @param WP_REST_Request $request The request.
	 *
	 * @return array $forms CF7 forms.
	 */
	public function search_entries_by_user( $request ) {
		$user_info = sanitize_text_field( $request['user_info'] );

		$offset = 0;

		$entries = $this->entry_model->search_entries_by_user( $user_info, $offset, $this->number_of_records_per_page );

		$count = $this->entry_model->mumber_of_items_by_user_info( $user_info );

		$entries_results = $this->pagination_helper->prepare_data_for_rest_with_pagination( $count, $entries );

		return rest_ensure_response( $entries_results );
	}


}
