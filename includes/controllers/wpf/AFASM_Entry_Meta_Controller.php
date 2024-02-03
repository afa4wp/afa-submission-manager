<?php
/**
 * The Entry Meta Controllers Class.
 *
 * @package  claud/afa-submission-manager
 * @since 1.0.0
 */

namespace AFASM\Includes\Controllers\WPF;

use AFASM\Includes\Models\WPF\AFASM_Entry_Meta_Model;
use AFASM\Includes\Controllers\AFASM_Abstract_Entry_Meta_Controllers;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class EntryMetaController
 *
 * Init all routes
 *
 * @since 1.0.0
 */
class AFASM_Entry_Meta_Controller extends AFASM_Abstract_Entry_Meta_Controllers {

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
	 * Get all entry meta by entry id
	 *
	 * @param WP_REST_Request $request The request.
	 *
	 * @return array $entryMeta GF entries meta
	 */
	public function entry_meta_by_entry_id( $request ) {
		$entry_id = absint( $request['entry_id'] );

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
		$answer = sanitize_text_field( urldecode( $request['answer'] ) );

		$items = $this->entry_meta_model->search_entry_meta_answer( $answer, 0, 20 );

		return rest_ensure_response( $items );
	}

}
