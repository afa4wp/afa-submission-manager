<?php
/**
 * The Form Model Helper Class.
 *
 * @package  WP_All_Forms_API
 * @since 1.0.0
 */

namespace Includes\Plugins\Helpers;

use WP_Query;
use Includes\Plugins\Helpers\Pagination;

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
	 * Table name with WP prefix
	 *
	 * @var string
	 */
	private $table_name_with_prefix;

	/**
	 * Form Controllers constructor
	 *
	 * @param string $post_type The post_type.
	 * @param array  $table_name The table_name.
	 */
	public function __construct( $post_type = '', $table_name = 'posts' ) {
		global $wpdb;
		$this->post_type              = $post_type;
		$this->table_name             = $table_name;
		$this->table_name_with_prefix = $wpdb->prefix . $table_name;
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
				'paged'          => ( new Pagination() )->get_page( $offset ),
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

		$sql     = "SELECT * FROM {$this->table_name_with_prefix} ORDER BY id DESC LIMIT %d,%d";
		$sql     = $wpdb->prepare( $sql, array( $offset, $number_of_records_per_page ) );// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared 
		$results = $wpdb->get_results( $sql, OBJECT ); // phpcs:ignore

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
				'paged'          => ( new Pagination() )->get_page( $offset ),
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

		$sql   = "SELECT * FROM {$this->table_name_with_prefix} WHERE post_name = %s ";
		$sql   = $wpdb->prepare( $sql, array( $channel ) ); // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
		$forms = $wpdb->get_results( $sql, OBJECT ); // phpcs:ignore

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

		$sql            = "SELECT count(*) as number_of_rows FROM {$this->table_name_with_prefix} WHERE post_type = %s AND post_status = %s ";
		$sql            = $wpdb->prepare( $sql, array( $this->post_type, 'publish' ) ); // phpcs:ignore
		$results        = $wpdb->get_results( $sql, OBJECT ); // phpcs:ignore
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

		// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
		$results = $wpdb->get_results( "SELECT count(*)  as number_of_rows FROM {$this->table_name_with_prefix} " ); // phpcs:ignore

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

		$sql     = "SELECT * FROM {$this->table_name_with_prefix} WHERE id = %d ";
		$sql     = $wpdb->prepare( $sql, array( $id ) );// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
		$results = $wpdb->get_results( $sql, OBJECT ); // phpcs:ignore

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

		$sql     = "SELECT * FROM {$this->table_name_with_prefix} WHERE id = %d ";
		$sql     = $wpdb->prepare( $sql, array( $id ) );// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
		$results = $wpdb->get_results( $sql, OBJECT ); // phpcs:ignore

		return $results;
	}

	/**
	 * Count number of forms created by logged user
	 *
	 * @since 1.0.0
	 *
	 * @param int $user_id The user id.
	 *
	 * @return int
	 */
	public function get_user_form_count_by_id( $user_id ) {

		$form_count = 0;

		$args = array(
			'post_type'      => $this->post_type,
			'posts_per_page' => -1,
			'author'         => $user_id,
		);

		$query = new WP_Query( $args );

		if ( $query->have_posts() ) {
			$form_count = $query->post_count;
		}

		wp_reset_postdata();

		return $form_count;
	}

}
