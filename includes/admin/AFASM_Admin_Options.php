<?php
/**
 * The Admin Options class
 *
 * @package  claud/afa-submission-manager
 * @since 1.0.0
 */

namespace AFASM\Includes\Admin;

use AFASM\Includes\Admin\Pages\AFASM_User_List_Table;
use AFASM\Includes\Admin\Pages\AFASM_Settings;
use AFASM\Includes\Admin\AFASM_Admin_Staff;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Class AdminOptions
 *
 * Render Staff content
 *
 * @since 1.0.0
 */
class AFASM_Admin_Options {

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
		new AFASM_Admin_Staff();
	}

	/**
	 * Add page for plugin
	 */
	public function add_page() {
		add_menu_page( 'AFA', 'AFA', 'manage_options', 'afa_submission_manager', array( new AFASM_User_List_Table(), 'render' ), 'dashicons-rest-api' );
		add_submenu_page( 'afa_submission_manager', __( 'AFA - Connected Users', 'afa-submission-manager' ), __( 'Connected Users', 'afa-submission-manager' ), 'manage_options', 'afa_submission_manager' );
		add_submenu_page( 'afa_submission_manager', __( 'AFA - Settings', 'afa-submission-manager' ), __( 'Settings', 'afa-submission-manager' ), 'manage_options', 'afa_submission_manager_settings', array( new AFASM_Settings(), 'render' ) );
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

