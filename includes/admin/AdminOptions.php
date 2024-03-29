<?php
/**
 * The Admin Options class
 *
 * @package  AFA_SUBMISSION_MANAGER
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
		add_menu_page( 'AFA', 'AFA', 'manage_options', 'afa_submission_manager', array( new UserListTable(), 'render' ), 'dashicons-rest-api' );
		add_submenu_page( 'afa_submission_manager', __( 'AFA - Connected Users', 'afa-submission-manager' ), __( 'Connected Users', 'afa-submission-manager' ), 'manage_options', 'afa_submission_manager' );
		add_submenu_page( 'afa_submission_manager', __( 'AFA - Settings', 'afa-submission-manager' ), __( 'Settings', 'afa-submission-manager' ), 'manage_options', 'afa_submission_manager_settings', array( new Settings(), 'render' ) );
	}

	/**
	 * Adds a role, if it does not exist
	 */
	private function add_role() {
		add_role(
			'afa_staff',
			'AFA SUBMISSION MANAGER Staff',
			array( 'manage_afa' => true )
		);

	}

	/**
	 * Fires after WordPress has finished loading
	 */
	public function wp_init() {
		$this->add_role();
	}

}

