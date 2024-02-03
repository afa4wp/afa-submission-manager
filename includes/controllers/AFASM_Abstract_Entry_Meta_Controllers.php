<?php
/**
 * The Abstarct Entry Meta Controllers Class.
 *
 * @package  claud/afa-submission-manager
 * @since 1.0.0
 */

namespace AFASM\Includes\Controllers;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class AbstractEntryMetaControllers
 *
 * Init all routes
 *
 * @since 1.0.0
 */
abstract class AFASM_Abstract_Entry_Meta_Controllers {

	/**
	 * Get all entry meta by entry id
	 *
	 * @since 1.0.0
	 *
	 * @param \WP_REST_Request $request The request.
	 *
	 * @return array $entryMeta AFA entries meta
	 */
	abstract public function entry_meta_by_entry_id( \WP_REST_Request $request);

	/**
	 * Search entry meta answer
	 *
	 * @since 1.0.0
	 *
	 * @param \WP_REST_Request $request The request.
	 *
	 * @return array $entryMeta AFA entries meta
	 */
	abstract public function search_entry_meta_answer( \WP_REST_Request $request);

}
