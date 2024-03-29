<?php
/**
 * The User Tokens Controller Class.
 *
 * @package  AFA_SUBMISSION_MANAGER
 * @since 1.0.0
 */

namespace Includes\Controllers;

use Includes\Models\UserTokensModel;
use Includes\Plugins\Helpers\Pagination;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Class UserController
 *
 * Manipulate User info
 *
 * @since 1.0.0
 */
class UserTokensController {
	/**
	 * User Tokens Model
	 *
	 * @var UserTokensModel
	 */
	private $user_tokens_model;

	/**
	 * Pagination Helper
	 *
	 * @var Pagination
	 */
	private $pagination_helper;

	/**
	 * UserTokensController constructor.
	 */
	public function __construct() {
		$this->user_tokens_model = new UserTokensModel();
		$this->pagination_helper = new Pagination();
	}

	/**
	 * Get UserTokensController items by page.
	 *
	 * @param int $page The page.
	 *
	 * @return array $UserTokensModel the items.
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
	 * @return array $UserTokensModel the items.
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
