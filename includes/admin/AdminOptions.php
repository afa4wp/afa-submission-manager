<?php

namespace Includes\Admin;

use Includes\Admin\Pages\UserListTable;
class AdminOptions {

	/**
	 * WO Options Name
	 *
	 * @var string
	 */
	protected $option_name = 'wo_options';

	/**
	 * WP OAuth Server Admin Setup
	 *
	 * @return [type] [description]
	 */
	public function init() {

		add_action( 'init', array( $this, 'wp_init' ), 1 );
		// add_action( 'admin_init', array( new self(), 'admin_init' ) );
		add_action( 'admin_menu', array( $this, 'add_page' ), 1 );
	}

	/**
	 * [admin_init description]
	 *
	 * @return [type] [description]
	 */
	public function admin_init() {
		// register_setting( 'wo-options-group', $this->option_name );

		// New Pages Layout
	}
	/**
	 * [add_page description]
	 */
	public function add_page() {
		add_menu_page( 'WP All Forms API', 'WP All Forms API', 'manage_options', 'wp_all_forms_api', array( new UserListTable(), 'render' ), 'dashicons-rest-api' );
	}

	private function add_role() {
		add_role(
			'wp_afa_staff',
			'WP All Forms API Staff',
			array( 'manage_wp_afa' => true )
		);

	}

	public function wp_init() {
		$this->add_role();
	}

}

