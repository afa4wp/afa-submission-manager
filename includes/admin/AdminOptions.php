<?php
/**
 * The Admin Options class
 *
 * @package  WP_All_Forms_API
 * @since 1.0.0
 */

namespace Includes\Admin;

use Includes\Admin\Pages\UserListTable;
use Includes\Admin\Pages\Settings;
use Includes\Admin\AdminStaff;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Class AdminOptions
 *
 * Render Staff content
 *
 * @since 1.0.0
 */
class AdminOptions {

	/**
	 * Init options
	 */
	public function init() {

		add_action( 'init', array( $this, 'wp_init' ), 1 );
		add_action( 'admin_init', array( $this, 'admin_init' ) );
		add_action( 'admin_menu', array( $this, 'add_page' ), 1 );
	}

	/**
	 * Execute on admin_init hook
	 */
	public function admin_init() {
		new AdminStaff();
	}

	/**
	 * Add page for plugin
	 */
	public function add_page() {
		add_menu_page( 'WP All Forms API', 'WP All Forms API', 'manage_options', 'wp_all_forms_api', array( new UserListTable(), 'render' ), 'dashicons-rest-api' );
		add_submenu_page( 'wp_all_forms_api', __( 'WP All Forms API - Connected Users', 'wp-all-forms-api' ), __( 'Connected Users', 'wp-all-forms-api' ), 'manage_options', 'wp_all_forms_api' );
		add_submenu_page( 'wp_all_forms_api', __( 'WP All Forms API - Settings', 'wp-all-forms-api' ), __( 'Settings', 'wp-all-forms-api' ), 'manage_options', 'wp_all_forms_api_settings', array( new Settings(), 'render' ) );
	}

	/**
	 * Adds a role, if it does not exist
	 */
	private function add_role() {
		add_role(
			'wp_afa_staff',
			'WP All Forms API Staff',
			array( 'manage_wp_afa' => true )
		);

	}

	/**
	 * Fires after WordPress has finished loading
	 */
	public function wp_init() {
		$this->add_role();
	}

}

