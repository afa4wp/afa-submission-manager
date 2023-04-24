<?php
/**
 * The Form Model Helper Class.
 *
 * @package  WP_All_Forms_API
 * @since 1.0.0
 */

namespace Includes\Plugins\Helpers;

use WP_Query;

/**
 * Class FormModelHelper
 *
 * Handler with pagination info.
 *
 * @since 1.0.0
 */
class FormModelHelper {

	/**
	 * The post_type
	 *
	 * @var string
	 */
	protected $post_type;

	/**
	 * The name of the table
	 *
	 * @var string
	 */
	protected $table_name;

	/**
	 * Form Controllers constructor
	 *
	 * @param int   $post_type The post_type.
	 * @param array $table_name The table_name.
	 */
	public function __construct( $post_type = '', $table_name = 'posts' ) {

		$this->post_type  = $post_type;
		$this->table_name = $table_name;
	}

	/**
	 * Get Forms
	 *
	 * @param int $offset The offset.
	 * @param int $number_of_records_per_page The posts per page.
	 *
	 * @return array $forms WPAFA forms
	 */
	public function forms( $offset, $number_of_records_per_page ) {
		if ( 'posts' !== $this->table_name ) {
			return $this->forms_from_custom_table( $offset, $number_of_records_per_page );
		}

		$posts = new WP_Query(
			array(
				'post_type'      => $this->post_type,
				'posts_per_page' => $number_of_records_per_page,
				'paged'          => $offset,
				'post_status'    => array( 'publish' ),
			)
		);

		return $posts;
	}

	/**
	 * Get Forms
	 *
	 * @param int $offset The offset.
	 * @param int $number_of_records_per_page The posts per page.
	 *
	 * @return object
	 */
	public function forms_from_custom_table( $offset, $number_of_records_per_page ) {
		global $wpdb;

		$results = $wpdb->get_results( 'SELECT * FROM ' . $wpdb->prefix . $this->table_name . ' ORDER BY id DESC LIMIT ' . $offset . ',' . $number_of_records_per_page, OBJECT );

		return $results;
	}

	/**
	 * Get Forms
	 *
	 * @param string $post_title The post title.
	 * @param int    $offset The offset.
	 * @param int    $number_of_records_per_page The posts per page.
	 *
	 * @return array
	 */

	public function search_forms( $post_title, $offset, $number_of_records_per_page ) {
		$posts = new WP_Query(
			array(
				'post_type'      => $this->post_type,
				'posts_per_page' => $number_of_records_per_page,
				'paged'          => $offset,
				'post_status'    => array( 'publish' ),
				's'              => $post_title,
			)
		);

		return $posts;
	}

	/**
	 * Get Form chanel by id
	 *
	 * @param string $channel The post name.
	 *
	 * @return object
	 */
	public function form_by_channel( $channel ) {
		global $wpdb;
		$forms = $wpdb->get_results( 'SELECT * FROM ' . $wpdb->prefix . $this->table_name . " WHERE post_name = '$channel' ", OBJECT );

		if ( count( $forms ) > 0 ) {
			return $forms[0];
		}

		return $forms;
	}

	/**
	 * Get number of Forms
	 *
	 * @return int
	 */
	public function mumber_of_items() {
		if ( 'posts' !== $this->table_name ) {
			return $this->mumber_of_items_from_custom_table();
		}

		global $wpdb;

		$results = $wpdb->get_results( 'SELECT count(*) as number_of_rows FROM ' . $wpdb->prefix . $this->table_name . " WHERE post_type = '$this->post_type' AND post_status = 'publish' " );

		$number_of_rows = intval( $results[0]->number_of_rows );

		return $number_of_rows;
	}
	/**
	 * Get number of Forms
	 *
	 * @return int
	 */
	public function mumber_of_items_from_custom_table() {
		global $wpdb;

		$results = $wpdb->get_results( 'SELECT count(*)  as number_of_rows FROM ' . $wpdb->prefix . $this->table_name . '' );

		$number_of_rows = intval( $results[0]->number_of_rows );

		return $number_of_rows;
	}

	/**
	 * Get Forms
	 *
	 * @param string $post_title The post title.
	 *
	 * @return int
	 */
	public function mumber_of_items_by_post_title( $post_title ) {
		$posts = new WP_Query(
			array(
				'post_type'   => $this->post_type,
				'post_status' => array( 'publish' ),
				's'           => $post_title,
			)
		);

		return $posts->found_posts;
	}

	/**
	 * Get Form chanel by id
	 *
	 * @param string $id The post id.
	 *
	 * @return string
	 */
	public function form_chanel_by_id( $id ) {
		 global $wpdb;

		$results = $wpdb->get_results( 'SELECT * FROM ' . $wpdb->prefix . $this->table_name . " WHERE id = $id ", OBJECT );

		if ( count( $results ) > 0 ) {
			return $results[0]->post_name;
		}
		return '';
	}

	/**
	 * Get Form by id
	 *
	 * @param int $id The form ID.
	 *
	 * @return array
	 */
	public function form_by_id( $id ) {
		global $wpdb;

		$results = $wpdb->get_results( 'SELECT * FROM ' . $wpdb->prefix . $this->table_name . " WHERE id = $id ", OBJECT );

		return $results;
	}

}
