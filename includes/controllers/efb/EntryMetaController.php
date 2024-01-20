<?php
/**
 * The Entry Meta Controllers Class.
 *
 * @package  AFA_SUBMISSION_MANAGER
 * @since 1.0.0
 */

namespace Includes\Controllers\EFB;

use AFASM\Includes\Models\EFB\AFASM_Entry_Meta_Model;
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
	 * @var AFASM_Entry_Meta_Model
	 */
	private $entry_meta_model;

	/**
	 * Entry Controllers constructor
	 */
	public function __construct() {
		$this->entry_meta_model = new AFASM_Entry_Meta_Model();

	}

	/**
	 * GF forms entry.
	 *
	 * @param WP_REST_Request $request The request.
	 *
	 * @return array $entryMeta WPF entries meta
	 */
	public function entry_meta_by_entry_id( $request ) {
		$entry_id = absint( $request['entry_id'] );

		$items = $this->entry_meta_model->entry_meta_by_entry_id( $entry_id );

		return rest_ensure_response( $items );
	}

	/**
	 * GF forms entry.
	 *
	 * @param WP_REST_Request $request The request.
	 *
	 * @return array $entryMeta WPF entries meta
	 */
	public function search_entry_meta_answer( $request ) {
		$number_of_records_per_page = 20;
		$answer                     = sanitize_text_field( urldecode( $request['answer'] ) );

		$offset = 0;

		$items = $this->entry_meta_model->search_entry_meta_answer( $answer, $offset, $number_of_records_per_page );

		return rest_ensure_response( $items );
	}
}
