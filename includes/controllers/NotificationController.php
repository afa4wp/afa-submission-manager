<?php
/**
 * The Notification Controller Class.
 *
 * @package  WP_All_Forms_API
 * @since 1.0.0
 */

namespace Includes\Controllers;

use Includes\Models\NotificationModel;
use Includes\Plugins\Helpers\Pagination;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Class NotificationController
 *
 * Hendler with notification
 *
 * @since 1.0.0
 */
class NotificationController {
	/**
	 * User Notification Model
	 *
	 * @var NotificationModel
	 */
	private $notification__model;

	/**
	 * The pagination helper
	 *
	 * @var Pagination
	 */
	protected $pagination_helper;

	/**
	 * NotificationController constructor.
	 */
	public function __construct() {
		$this->notification__model = new NotificationModel();
		$this->pagination_helper   = new Pagination();
	}

	/**
	 * Fetch notification.
	 *
	 * @param WP_REST_Request $request The request.
	 *
	 * @return array
	 */
	public function notifications( $request ) {

		$page = $request['page_number'];

		$count = $this->notification__model->mumber_of_items();

		$offset = $this->pagination_helper->get_offset( $page );

		$notifications = $this->notification__model->notifications( $offset, $this->pagination_helper->get_number_of_records_per_page() );

		$notifications_results = $this->pagination_helper->prepare_data_for_rest_with_pagination( $count, $notifications );

		return rest_ensure_response( $notifications_results );
	}

}
