<?php

namespace Includes\Controllers\WEF;

use Includes\Models\WEF\EntryMetaModel;

class EntryMetaController {

	private $entryMetaModel;
	public function __construct() {
		 $this->entryMetaModel = new EntryMetaModel();

	}

	/**
	 * WEF forms entry.
	 *
	 * @param WP_REST_Request $request The request.
	 *
	 * @return array $forms WEF forms.
	 */
	public function entryMetaByEntryID( $request ) {
		$entry_id = $request['entry_id'];

		$items = $this->entryMetaModel->entryMetaByEntryID( $entry_id );

		return rest_ensure_response( $items );
	}

	/**
	 * WEF forms entry.
	 *
	 * @param WP_REST_Request $request The request.
	 *
	 * @return array $forms WEF forms.
	 */
	public function searchEntryMetaAnswer( $request ) {
		 $answer = urldecode( $request['answer'] );

		$items = $this->entryMetaModel->searchEntryMetaAnswer( $answer, 0, 20 );

		return rest_ensure_response( $items );
	}


}
