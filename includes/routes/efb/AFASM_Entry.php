<?php
/**
 * The Entry Route Class.
 *
 * @package  claud/afa-submission-manager
 * @since 1.0.0
 */

namespace AFASM\Includes\Routes\EFB;

use AFASM\Includes\Controllers\EFB\AFASM_Entry_Controller;
use AFASM\Includes\Routes\AFASM_Abstract_Entry_Route;
use AFASM\Includes\Plugins\AFASM_Config;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class Entry
 *
 * Init all routes
 *
 * @since 1.0.0
 */
class AFASM_Entry extends AFASM_Abstract_Entry_Route {

	/**
	 * Get all entries
	 */
	public function entries() {
		register_rest_route(
			$this->name,
			'/efb/entries',
			array(
				array(
					'methods'             => 'GET',
					'callback'            => array( new AFASM_Entry_Controller(), 'entries' ),
					'permission_callback' => array( new AFASM_Config(), 'afa_check_authorization' ),
				),
			)
		);
	}

	/**
	 * Get entry by id
	 */
	public function entry_by_id() {
		register_rest_route(
			$this->name,
			'/efb/entries/(?P<entry_id>[0-9]+)',
			array(
				array(
					'methods'             => 'GET',
					'callback'            => array( new AFASM_Entry_Controller(), 'entry_by_id' ),
					'permission_callback' => array( new AFASM_Config(), 'afa_check_authorization' ),
				),
			)
		);
	}

	/**
	 * Get entries by form id
	 */
	public function entries_by_form_id() {
		register_rest_route(
			$this->name,
			'/efb/entries/form_id/(?P<form_id>[0-9]+)/page/(?P<page_number>[0-9]+)',
			array(
				array(
					'methods'             => 'GET',
					'callback'            => array( new AFASM_Entry_Controller(), 'entries_by_form_id' ),
					'permission_callback' => array( new AFASM_Config(), 'afa_check_authorization' ),
				),
			)
		);
	}

	/**
	 * Search entries by user info
	 */
	public function search_entries_by_user() {
		register_rest_route(
			$this->name,
			'/efb/entries/user/search/(?P<user_info>\S+)',
			array(
				array(
					'methods'             => 'GET',
					'callback'            => array( new AFASM_Entry_Controller(), 'search_entries_by_user' ),
					'permission_callback' => array( new AFASM_Config(), 'afa_check_authorization' ),
				),
			)
		);
	}

}
