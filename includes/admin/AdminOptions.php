<?php

namespace Includes\Admin;

use Includes\Admin\Pages\UserListTable;
use Includes\Admin\Pages\Settings;
use Includes\Admin\AdminStaff;

class AdminOptions {

	/**
	 * WP OAuth Server Admin Setup
	 *
	 * @return [type] [description]
	 */
	public function init() {

		add_action( 'init', array( $this, 'wp_init' ), 1 );
		add_action( 'admin_init', array( $this, 'admin_init' ) );
		add_action( 'admin_menu', array( $this, 'add_page' ), 1 );
	}

	/**
	 * [admin_init description]
	 *
	 * @return [type] [description]
	 */
	public function admin_init() {
		new AdminStaff();
	}
	/**
	 * [add_page description]
	 */
	public function add_page() {
		add_menu_page( 'WP All Forms API', 'WP All Forms API', 'manage_options', 'wp_all_forms_api', array( new UserListTable(), 'render' ), 'dashicons-rest-api' );
		add_submenu_page( 'wp_all_forms_api', 'Usuarios logados', 'Usuarios logados', 'manage_options', 'wp_all_forms_api');
		add_submenu_page( 'wp_all_forms_api', 'WP All Forms API Settings', 'Configurações', 'manage_options', 'wp_all_forms_api_settings', array( new Settings(), 'render' ));
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

