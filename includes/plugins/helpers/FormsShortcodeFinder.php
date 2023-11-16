<?php
/**
 * The  FormsShortcodeFinder Class.
 *
 * @package  AFA_SUBMISSION_MANAGER
 * @since 1.0.0
 */

namespace Includes\Plugins\Helpers;

/**
 * Class Pagination
 *
 * Finds pages that contain a particular Gravity Form.
 *
 * @since 1.0.0
 */
class FormsShortcodeFinder {
	/**
	 * ID of the Gravity Form to search for.
	 *
	 * @var int
	 */
	private $form_id;

	/**
	 * The shortcode name.
	 *
	 * @var string
	 */
	private $shortcode_name;

	/**
	 * Represents a Form entry searcher.
	 *
	 * @param int    $form_id ID of the Form to search for.
	 * @param string $shortcode_name Optional name of the shortcode associated with the form.
	 */
	public function __construct( $form_id, $shortcode_name = '' ) {
		$this->form_id        = (int) $form_id;
		$this->shortcode_name = $shortcode_name;
	}

	/**
	 * Find shortcode.
	 *
	 * @return array Pages that contain the form. Array is in this format: $post_id => $post_title
	 */
	public function find() {
		return array_reduce(
			$this->get_all_page_ids(),
			function( $pages, $page_id ) {
				if ( in_array( $this->form_id, $this->get_form_ids_in_post_content( $page_id, $this->shortcode_name ), true ) ) {
					$pages[ $page_id ] = get_the_title( $page_id );
				}

				return $pages;
			},
			array()
		);
	}

	/**
	 * Retrieves an array of Post IDs for all pages.
	 *
	 * @return array An array of Post IDs for all pages.
	 */
	private function get_all_page_ids() {
		return ( new \WP_Query(
			array(
				'post_type'              => 'page',
				'posts_per_page'         => -1,
				'no_found_rows'          => true,
				'fields'                 => 'ids',
				'update_post_meta_cache' => false,
				'update_post_term_cache' => false,
			)
		) )->get_posts();
	}

	/**
	 * Retrieves an array of Form IDs from the content of a specific page.
	 *
	 * @param int    $page_id        Page ID.
	 * @param string $shortcode_name The name of the shortcode to search for in the content.
	 *
	 * @return array An array of  Form IDs found in the page content.
	 */
	private function get_form_ids_in_post_content( $page_id, $shortcode_name ) {
		$content = get_post_field( 'post_content', $page_id );

		return $this->get_shortcode_ids( $this->get_shortcodes_from_content( $content, $shortcode_name ) );
	}

	/**
	 * Retrieves an array of shortcodes of a specific type from the given post content.
	 *
	 * @param  string $content   Post content.
	 * @param  string $shortcode The shortcode to search for.
	 *
	 * @return array  The shortcodes found or empty array if none.
	 */
	private function get_shortcodes_from_content( $content, $shortcode ) {
		$matches_found = preg_match_all( '/' . get_shortcode_regex() . '/s', $content, $matches );

		if ( ! $matches_found || empty( $matches[2] ) || ! in_array( $shortcode, $matches[2], true ) ) {
			return array();
		}

		return $matches[0];
	}

	/**
	 * Extracts IDs from shortcodes.
	 *
	 * @param array $shortcodes The shortcodes to get the IDs from.
	 *
	 * @return array $ids        The shortcode IDs.
	 */
	private function get_shortcode_ids( array $shortcodes ) {
		return array_reduce(
			$shortcodes,
			function( $ids, $shortcode ) {
				$id = $this->get_shortcode_id( $shortcode );

				if ( $id ) {
					$ids[] = $id;
				}

				return $ids;
			},
			array()
		);
	}

	/**
	 * Extract the 'id' parameter from a shortcode.
	 *
	 * @param  string $shortcode The shortcode.
	 *
	 * @return int The ID, or 0 if none found.
	 */
	private function get_shortcode_id( $shortcode ) {
		$match_found = preg_match( '~id=[\"\']?([^\"\'\s]+)[\"\']?~i', $shortcode, $form_id );

		return $match_found ? (int) $form_id[1] : 0;
	}
}
