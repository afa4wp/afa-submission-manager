<?php
/**
 * The Pagination Class.
 *
 * @package  WP_All_Forms_API
 * @since 1.0.0
 */

namespace Includes\Plugins\Helpers;

/**
 * Class Pagination
 *
 * Handler with pagination info.
 *
 * @since 1.0.0
 */
class Pagination {

	/**
	 * The number of items per page
	 *
	 * @var int
	 */
	private $number_of_records_per_page = 20;

	/**
	 * Count number of items
	 *
	 * @var int
	 */
	private $count = 0;

	/**
	 * Number of item per page.
	 *
	 * @return int $number_of_records_per_page.
	 */
	public function get_number_of_records_per_page() {
		return $this->number_of_records_per_page;
	}

	/**
	 * Prepare content with pagination before return
	 *
	 * @param int   $count The number of items.
	 * @param array $data The data content.
	 *
	 * @return array $data
	 */
	public function prepare_data_for_rest_with_pagination( $count, $data ) {

		if ( ! empty( $count ) ) {
			$this->count = intval( $count );
		}

		$info          = array();
		$info['count'] = $this->count;
		$info['pages'] = $this->get_pages();

		$data_results = array();

		$data_results['info']    = $info;
		$data_results['results'] = $data;

		return $data_results;
	}

	/**
	 * Number of pages.
	 *
	 * @return int
	 */
	private function get_pages() {
		return ceil( $this->count / $this->number_of_records_per_page );
	}

	/**
	 * Calculate offset.
	 *
	 * @param int $page The page.
	 * @param int $count The number od items.
	 *
	 * @return int
	 */
	public function get_offset( $page ) {

		$offset = ( $page - 1 ) * $this->number_of_records_per_page;

		return $offset;

	}

}
