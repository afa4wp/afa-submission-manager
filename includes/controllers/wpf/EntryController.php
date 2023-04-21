<?php
/**
 * The Entry Controllers Class.
 *
 * @package  WP_All_Forms_API
 * @since 1.0.0
 */

namespace Includes\Controllers\WPF;

use Includes\Models\WPF\EntryModel;
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
	 * @var EntryModel
	 */
	private $entry_model;

	/**
	 * Entry Controllers constructor
	 */
	public function __construct() {
		parent::__construct();
		$this->entry_model = new EntryModel();
	}

	/**
	 * WPF forms entry.
	 *
	 * @return array $forms WPF forms.
	 */
	public function entries() {
		$count = $this->entry_model->mumberItems();

		$offset = 0;

		$entries = $this->entry_model->entries( $offset, $this->number_of_records_per_page );

		$entries_results = $this->pagination_helper->prepare_data_for_rest_with_pagination( $count, $entries );

		return rest_ensure_response( $entries_results );
	}

	/**
	 * WPF forms entry.
	 *
	 * @param WP_REST_Request $request The request.
	 *
	 * @return array $forms WPF forms.
	 */
	public function entry_by_id( $request ) {
		$entry_id = $request['entry_id'];
		$entry    = $this->entry_model->entryByID( $entry_id );
		return rest_ensure_response( $entry );

	}

	/**
	 * WPF forms entries by id.
	 *
	 * @param WP_REST_Request $request The request.
	 *
	 * @return array $forms WPF forms.
	 */
	public function entries_by_form_id( $request ) {
		$form_id = $request['form_id'];

		$page = $request['page_number'];

		$count = $this->entry_model->mumberItemsByFormID( $form_id );

		$offset = $this->pagination_helper->get_offset( $page, $count );

		$entries = $this->entry_model->entriesByFormID( $form_id, $offset, $this->number_of_records_per_page );

		$entries_results = $this->pagination_helper->prepare_data_for_rest_with_pagination( $count, $entries );

		return rest_ensure_response( $entries_results );
	}

	/**
	 * WPF forms entries by user info.
	 *
	 * @param WP_REST_Request $request The request.
	 *
	 * @return array $forms WPF forms.
	 */
	public function search_entries_by_user( $request ) {
		$user_info = $request['user_info'];

		$offset = 0;

		$entries = $this->entry_model->searchEntriesByUser( $user_info, $offset, $this->number_of_records_per_page );

		$count = $this->entry_model->mumberItemsByUserInfo( $user_info );

		$entries_results = $this->pagination_helper->prepare_data_for_rest_with_pagination( $count, $entries );

		return rest_ensure_response( $entries_results );
	}



}
