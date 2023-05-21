<?php
/**
 * The Entry Route Class.
 *
 * @package  WP_All_Forms_API
 * @since 1.0.0
 */

namespace Includes\Routes\CF7;

use Includes\Controllers\CF7\EntryController;
use Includes\Routes\AbstractEntryRoute;
use Includes\Plugins\Config;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
/**
 * Class Entry
 *
 * Init all routes
 *
 * @since 1.0.0
 */
class Entry extends AbstractEntryRoute {

	/**
	 * Get all entries
	 */
	public function entries() {
		register_rest_route(
			$this->name,
			'/cf7/entries',
			array(
				array(
					'methods'             => 'GET',
					'callback'            => array( new EntryController(), 'entries' ),
					'permission_callback' => array( new Config(), 'wp_afa_check_authorization' ),
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
			'/cf7/entries/(?P<entry_id>[0-9]+)',
			array(
				array(
					'methods'             => 'GET',
					'callback'            => array( new EntryController(), 'entry_by_id' ),
					'permission_callback' => array( new Config(), 'wp_afa_check_authorization' ),
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
			'/cf7/entries/form_id/(?P<form_id>[0-9]+)/page/(?P<page_number>[0-9]+)',
			array(
				array(
					'methods'             => 'GET',
					'callback'            => array( new EntryController(), 'entries_by_form_id' ),
					'permission_callback' => array( new Config(), 'wp_afa_check_authorization' ),
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
			'/cf7/entries/user/search/(?P<user_info>\S+)',
			array(
				array(
					'methods'             => 'GET',
					'callback'            => array( new EntryController(), 'search_entries_by_user' ),
					'permission_callback' => array( new Config(), 'wp_afa_check_authorization' ),
				),
			)
		);
	}

}
