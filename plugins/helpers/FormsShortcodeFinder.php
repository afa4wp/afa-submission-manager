<?php
namespace Plugins\Helpers;
/**
 * Finds pages that contain a particular Gravity Form.
 */
class FormsShortcodeFinder {
	/**
	 * ID of the Gravity Form to search for.
	 *
	 * @var int
	 */
	private $form_id;

	/**
	 * @param int $form_id ID of the Gravity Form to search for.
	 */
	public function __construct( $form_id ) {
		$this->form_id = (int) $form_id;
	}

	/**
	 * @return array Pages that contain the form. Array is in this format: $post_id => $post_title
	 */
	public function find() {
		return array_reduce( $this->get_all_page_ids(), function( $pages, $page_id ) {
			if ( in_array( $this->form_id, $this->get_form_ids_in_post_content( $page_id, "contact-form-7"), true ) ) {
				$pages[ $page_id ] = get_the_title( $page_id );
			}
	
			return $pages;
		}, [] );
	}

	/**
	 * @return array Post IDs for all pages.
	 */
	private function get_all_page_ids() {
		return ( new \WP_Query( [
			'post_type'              => 'page',
			'posts_per_page'         => 1000,
			'no_found_rows'          => true,
			'fields'                 => 'ids',
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false,
		] ) )->get_posts();
	}

	/**
	 * @param  int $page_id Page ID.
	 *
	 * @return array Gravity Form IDs.
	 */
	private function get_form_ids_in_post_content( $page_id, $shortcode_name) {
		$content = get_post_field( 'post_content', $page_id );

		return $this->get_shortcode_ids( $this->get_shortcodes_from_content( $content, $shortcode_name ) );
	}

	/**
	 * @param  string $content   Post content.
	 * @param  string $shortcode The shortcode to search for.
	 *
	 * @return array  The shortcodes found or empty array if none.
	 */
	private function get_shortcodes_from_content( $content, $shortcode ) {
		$matches_found = preg_match_all( '/' . get_shortcode_regex() . '/s', $content, $matches );

		if ( ! $matches_found || empty( $matches[2] ) || ! in_array( $shortcode, $matches[2], true ) ) {
			return [];
		}

		return $matches[0];
	}

	/**
	 * Extracts IDs from shortcodes.
	 *
	 * @param string $shortcodes The shortcodes to get the IDs from.
	 *
	 * @return array $ids        The shortcode IDs.
	 */
	private function get_shortcode_ids( array $shortcodes ) {
		return array_reduce( $shortcodes, function( $ids, $shortcode ) {
			$id = $this->get_shortcode_id( $shortcode );

			if ( $id ) {
				$ids[] = $id;
			}

			return $ids;
		}, [] );
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