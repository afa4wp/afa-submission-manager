<?php
/**
 * The SupportedPlugins Class.
 *
 * @package  WP_All_Forms_API
 * @since 1.0.0
 */

namespace Includes\Database;

use Includes\Plugins\Constant;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Class SupportedPlugins
 *
 * Create table supported_plugins
 *
 * @since 1.0.0
 */
class SupportedPlugins {

	/**
	 * Table name
	 *
	 * @var string
	 */
	private $table_name;

	/**
	 * SupportedPlugins constructor.
	 */
	public function __construct() {
		global $wpdb;
		$this->table_name = $wpdb->prefix . Constant::TABLE_SUPPORTED_PLUGINS;
	}

	/**
	 * Create user_device table.
	 */
	public function create_table() {

		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		global $wpdb;

		$sql = 'CREATE TABLE IF NOT EXISTS ' . $this->table_name . ' (
        id BIGINT(20) NOT NULL AUTO_INCREMENT,
        slug VARCHAR(255),
		name VARCHAR(255),
		plugin_path VARCHAR(255),
		created_at DATETIME NOT NULL,
        PRIMARY KEY(id),
        UNIQUE(slug)
      	)' . $wpdb->get_charset_collate();

		dbDelta( $sql );

		$this->insert_default_values();
	}

	/**
	 * Get supported plugins
	 *
	 * @return array Supported pluginns
	 */
	public function get_default_values() {
		$values = array(
			array(
				'slug'        => 'cf7',
				'name'        => 'Contact Form 7',
				'plugin_path' => 'contact-form-7/wp-contact-form-7.php',
			),
			array(
				'slug'        => 'gf',
				'name'        => 'Gravity Forms',
				'plugin_path' => 'gravityforms/gravityforms.php',
			),
			array(
				'slug'        => 'wef',
				'name'        => 'weForms',
				'plugin_path' => 'weforms/weforms.php',
			),
			array(
				'slug'        => 'wpf',
				'name'        => 'WPForms',
				'plugin_path' => 'wpforms/wpforms.php',
			),
		);

		return $values;
	}

	/**
	 * Insert supported plugins items
	 *
	 * @return void
	 */
	private function insert_default_values() {
		global $wpdb;

		$table_name = $this->table_name;
		$values     = $this->get_default_values();

		foreach ( $values as $key => $value ) {
			$value['created_at'] = gmdate( 'Y-m-d H:i:s' );
			// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
			$wpdb->insert(
				$table_name,
				$value
			);
		}

	}
}
