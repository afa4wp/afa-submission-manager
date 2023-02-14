<?php

namespace Includes\Controllers\WEF;

use Includes\Models\WEF\EntryModel;
use Includes\Plugins\Helpers\Pagination;
use WP_Error;

class EntryController {

	private $entryModel;
	private $number_of_records_per_page;
	public function __construct() {
		 $this->entryModel                = new EntryModel();
		$this->paginationHelper           = new Pagination();
		$this->number_of_records_per_page = $this->paginationHelper->getNumberofRecordsPerPage();
	}

	/**
	 * WEF forms entry.
	 *
	 * @return array $forms WEF forms.
	 */
	public function entries() {
		 $count = $this->entryModel->mumberItems();

		$offset = 0;

		$entries = $this->entryModel->entries( $offset, $this->number_of_records_per_page );

		$entries_results = $this->paginationHelper->prepareDataForRestWithPagination( $count, $entries );

		return rest_ensure_response( $entries_results );
	}

	/**
	 * WEF forms entry.
	 *
	 * @return array $forms WEF forms.
	 */
	public function entryByID( $request ) {
		 $entry_id = $request['entry_id'];
		$entry     = $this->entryModel->entryByID( $entry_id );
		return rest_ensure_response( $entry );

	}

	/**
	 * WEF forms entries by id.
	 *
	 * @return array $forms CF7 forms.
	 */
	public function entriesByFormID( $request ) {
		$form_id = $request['form_id'];

		$page = $request['page_number'];

		$count = $this->entryModel->mumberItemsByFormID( $form_id );

		$offset = $this->paginationHelper->getOffset( $page, $count );

		$entries = $this->entryModel->entriesByFormID( $form_id, $offset, $this->number_of_records_per_page );

		$entries_results = $this->paginationHelper->prepareDataForRestWithPagination( $count, $entries );

		return rest_ensure_response( $entries_results );
	}

	/**
	 * WEF forms entries by user info.
	 *
	 * @return array $forms WEF forms.
	 */
	public function searchEntriesByUser( $request ) {
		$user_info = $request['user_info'];

		$offset = 0;

		$entries = $this->entryModel->searchEntriesByUser( $user_info, $offset, $this->number_of_records_per_page );

		$count = $this->entryModel->mumberItemsByUserInfo( $user_info );

		$entries_results = $this->paginationHelper->prepareDataForRestWithPagination( $count, $entries );

		return rest_ensure_response( $entries_results );
	}
}
