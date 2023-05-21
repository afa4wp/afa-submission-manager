<?php
/**
 * The Form Route Class.
 *
 * @package  WP_All_Forms_API
 * @since 1.0.0
 */

namespace Includes\Routes\WEF;

use Includes\Controllers\WEF\EntryMetaController;
use Includes\Routes\AbstractEntryMetaRoute;
use Includes\Plugins\Config;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Class EntryMeta
 *
 * Init all routes
 *
 * @since 1.0.0
 */
class EntryMeta extends AbstractEntryMetaRoute {

	/**
	 * Get entry_meta by entry id
	 */
	public function entry_meta_by_entry_id() {
		register_rest_route(
			$this->name,
			'/wef/entrymeta/entry_id/(?P<entry_id>[0-9]+)',
			array(
				array(
					'methods'             => 'GET',
					'callback'            => array( new EntryMetaController(), 'entry_meta_by_entry_id' ),
					'permission_callback' => array( new Config(), 'wp_afa_check_authorization' ),
				),
			)
		);
	}

	/**
	 * Get entry meta by search
	 */
	public function search_entry_meta_answer() {
		register_rest_route(
			$this->name,
			'/wef/entrymeta/search/(?P<answer>\S+)',
			array(
				array(
					'methods'             => 'GET',
					'callback'            => array( new EntryMetaController(), 'search_entry_meta_answer' ),
					'permission_callback' => array( new Config(), 'wp_afa_check_authorization' ),
				),
			)
		);
	}

}
