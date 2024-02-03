<?php
/**
 * The User Tokens Controller Class.
 *
 * @package  claud/afa-submission-manager
 * @since 1.0.0
 */

namespace AFASM\Includes\Controllers;

use AFASM\Includes\Models\AFASM_User_Tokens_Model;
use AFASM\Includes\Plugins\Helpers\AFASM_Pagination;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class UserController
 *
 * Manipulate User info
 *
 * @since 1.0.0
 */
class AFASM_User_Tokens_Controller {
	/**
	 * User Tokens Model
	 *
	 * @var AFASM_User_Tokens_Model
	 */
	private $user_tokens_model;

	/**
	 * Pagination Helper
	 *
	 * @var AFASM_Pagination
	 */
	private $pagination_helper;

	/**
	 * UserTokensController constructor.
	 */
	public function __construct() {
		$this->user_tokens_model = new AFASM_User_Tokens_Model();
		$this->pagination_helper = new AFASM_Pagination();
	}

	/**
	 * Get UserTokensController items by page.
	 *
	 * @param int $page The page.
	 *
	 * @return array $AFASM_User_Tokens_Model the items.
	 */
	public function paginate( $page = 1 ) {

		$count                      = $this->user_tokens_model->mumber_items();
		$number_of_records_per_page = $this->pagination_helper->get_number_of_records_per_page();
		$offset                     = $this->pagination_helper->get_offset( $page );
		$items                      = $this->user_tokens_model->users_tokens( $offset, $number_of_records_per_page );

		$results = $this->pagination_helper->prepare_data_for_rest_with_pagination( $count, $items );

		return $results;
	}

	/**
	 * Get UserTokensController items by display_name, user_login or user_email.
	 *
	 * @param string $user_info The user info.
	 * @param int    $page The page.
	 *
	 * @return array $AFASM_User_Tokens_Model the items.
	 */
	public function search( $user_info, $page = 1 ) {

		$count = $this->user_tokens_model->mumber_items_search( $user_info );

		$number_of_records_per_page = $this->pagination_helper->get_number_of_records_per_page();
		$offset                     = $this->pagination_helper->get_offset( $page );
		$items                      = $this->user_tokens_model->search_users_tokens( $user_info, $offset, $number_of_records_per_page );

		$results = $this->pagination_helper->prepare_data_for_rest_with_pagination( $count, $items );

		return $results;
	}

	/**
	 * Delete token register
	 *
	 * @param string $user_id The user ID.
	 *
	 * @return int|false
	 */
	public function delete_user_token_by_id( $user_id ) {
		return $this->user_tokens_model->delete_user_token_by_id( $user_id );
	}

}
