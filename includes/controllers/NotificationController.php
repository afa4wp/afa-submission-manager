<?php
/**
 * The Notification Controller Class.
 *
 * @package  AFA_SUBMISSION_MANAGER
 * @since 1.0.0
 */

namespace Includes\Controllers;

use AFASM\Includes\Models\AFASM_Notification_Model;
use AFASM\Includes\Plugins\Helpers\AFASM_Pagination;
use AFASM\Includes\Models\AFASM_Supported_Plugins_Model;

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
	 * @var AFASM_Notification_Model
	 */
	private $notification_model;

	/**
	 * The pagination helper
	 *
	 * @var AFASM_Pagination
	 */
	protected $pagination_helper;

	/**
	 * NotificationController constructor.
	 */
	public function __construct() {
		$this->notification_model = new AFASM_Notification_Model();
		$this->pagination_helper  = new AFASM_Pagination();
	}

	/**
	 * Fetch notification.
	 *
	 * @param WP_REST_Request $request The request.
	 *
	 * @return array
	 */
	public function notifications( $request ) {

		$page             = absint( $request['page_number'] );
		$device_language  = sanitize_text_field( $request['device_language'] );
		$supported_plugin = sanitize_text_field( $request['supported_plugin'] );

		$supported_plugins_model_register = ( new AFASM_Supported_Plugins_Model() )->get_supported_plugin_by_slug( $supported_plugin );
		$supported_plugin_id              = 0;
		if ( ! empty( $supported_plugins_model_register ) ) {
			$supported_plugin_id = $supported_plugins_model_register->id;
		}

		$count = $this->notification_model->mumber_of_items( $supported_plugin_id );

		$offset = $this->pagination_helper->get_offset( $page );

		$notifications = $this->notification_model->notifications( $supported_plugin_id, $offset, $this->pagination_helper->get_number_of_records_per_page() );

		$notifications_results = $this->pagination_helper->prepare_data_for_rest_with_pagination( $count, $notifications );

		return rest_ensure_response( $notifications_results );
	}

}
