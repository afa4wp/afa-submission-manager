<?php
/**
 * The Entry Meta Controllers Class.
 *
 * @package  WP_All_Forms_API
 * @since 1.0.0
 */

namespace Includes\Controllers\WPF;

use Includes\Models\WPF\EntryMetaModel;
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
	 * Get all entry meta by entry id
	 *
	 * @param WP_REST_Request $request The request.
	 *
	 * @return array $entryMeta GF entries meta
	 */
	public function entry_meta_by_entry_id( $request ) {
		$entry_id = $request['entry_id'];

		$items = $this->entry_meta_model->entry_meta_by_entry_id( $entry_id );

		return rest_ensure_response( $items );
	}

	/**
	 * Search entry meta answer
	 *
	 * @param WP_REST_Request $request The request.
	 *
	 * @return array $entryMeta GF entries meta
	 */
	public function search_entry_meta_answer( $request ) {
		$answer = urldecode( $request['answer'] );

		$items = $this->entry_meta_model->search_entry_meta_answer( $answer, 0, 20 );

		return rest_ensure_response( $items );
	}

}
