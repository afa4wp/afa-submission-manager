<?php
/**
 * The Form Route Class.
 *
 * @package  AFA_SUBMISSION_MANAGER
 * @since 1.0.0
 */

namespace Includes\Routes\GF;

use Includes\Controllers\GF\EntryMetaController;
use Includes\Routes\AbstractEntryMetaRoute;
use AFASM\Includes\Plugins\AFASM_Config;

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
			'/gf/entrymeta/entry_id/(?P<entry_id>[0-9]+)',
			array(
				array(
					'methods'             => 'GET',
					'callback'            => array( new EntryMetaController(), 'entry_meta_by_entry_id' ),
					'permission_callback' => array( new AFASM_Config(), 'afa_check_authorization' ),
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
			'/gf/entrymeta/search/(?P<answer>\S+)',
			array(
				array(
					'methods'             => 'GET',
					'callback'            => array( new EntryMetaController(), 'search_entry_meta_answer' ),
					'permission_callback' => array( new AFASM_Config(), 'afa_check_authorization' ),
				),
			)
		);
	}

}
