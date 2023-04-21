<?php
/**
 * The Entry Meta Controllers Class.
 *
 * @package  WP_All_Forms_API
 * @since 1.0.0
 */

namespace Includes\Controllers\CF7;

use Includes\Models\CF7\EntryMetaModel;
use Includes\Controllers\AbstractEntryMetaControllers;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Class EntryMetaController
 *
 * Init all routes
 *
 * @since 1.0.0
 */
class EntryMetaController extends AbstractEntryMetaControllers {

	/**
	 * The entry meta model
	 *
	 * @var EntryMetaModel
	 */
	private $entry_meta_model;

	/**
	 * Entry Controllers constructor
	 */
	public function __construct() {
		$this->entry_meta_model = new EntryMetaModel();

	}

	/**
	 * CF7 forms entry.
	 *
	 * @param WP_REST_Request $request The request.
	 *
	 * @return array $entryMeta CF7 entries meta
	 */
	public function entry_meta_by_entry_id( $request ) {
		$entry_id = $request['entry_id'];

		$items = $this->entry_meta_model->entryMetaByEntryID( $entry_id );

		return rest_ensure_response( $items );
	}

	/**
	 * Get all entry meta by entry id
	 *
	 * @param WP_REST_Request $request The request.
	 *
	 * @return array $entryMeta CF7 entries meta
	 */
	public function search_entry_meta_answer( $request ) {
		$answer = urldecode( $request['answer'] );

		$items = $this->entry_meta_model->searchEntryMetaAnswer( $answer );

		return rest_ensure_response( $items );
	}

}
