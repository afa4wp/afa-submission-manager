<?php
/**
 * The Admin staff class for users table
 *
 * @package  WP_All_Forms_API
 * @since 1.0.0
 */
namespace Includes\Admin;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Class AdminStaff
 *
 * Render Staff content
 *
 * @since 1.0.0
 */
class AdminStaff {

	/**
	 * AdminStaff constructor.
	 */
	public function __construct() {

		add_filter( 'manage_users_columns', array( $this, 'add_user_staff_column' ) );
		// add_filter( 'manage_product_posts_custom_column', array( $this, 'addProductListTableColumnsContent' ), 10, 2 );
		// add_action('admin_head', array($this, 'add_column_css'));
	}

	/**
	 * Add WP AFA Staff column to users table
	 *
	 * @since 1.0.0
	 *
	 * @param array $columns The columns to users list table.
	 *
	 * @return array
	 */
	public function add_user_staff_column( $columns ) {
		$all_options = get_option( 'wp_all_forms_api_settings_staff_options', false );
		if ( ! empty( $all_options ) && array_key_exists( 'add_user', $all_options ) ) {
			if ( 'on' === $all_options['add_user'] ) {
				$columns['wp_all_forms_api_user_staff_column'] = __( 'WP AFA Staff' );
			}
		}
		return $columns;
	}



}

