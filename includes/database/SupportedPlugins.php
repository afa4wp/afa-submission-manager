<?php
/**
 * The SupportedPlugins Class.
 *
 * @package  AFA_SUBMISSION_MANAGER
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
			array(
				'slug'        => 'efb',
				'name'        => 'Elementor Form Builder',
				'plugin_path' => 'elementor-pro/elementor-pro.php',
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

	/**
	 * Check if a specific slug exists in the default values array.
	 *
	 * @param string $slug The slug to check.
	 *
	 * @return bool True if the slug exists, false otherwise.
	 */
	public function is_default_slug_exist( $slug ) {
		$default_values = $this->get_default_values();
		$slugs          = array_column( $default_values, 'slug' );
		return in_array( $slug, $slugs, true );
	}

	/**
	 * Get the name from default values based on the provided slug.
	 *
	 * @param string $slug The slug of the form builder.
	 *
	 * @return string The corresponding name or an empty string if not found.
	 */
	public function get_plugin_name_by_slug( $slug ) {
		$default_values = $this->get_default_values();

		foreach ( $default_values as $value ) {
			if ( $value['slug'] === $slug ) {
				return $value['name'];
			}
		}

		return '';
	}

	/**
	 * Get supported plugins in the desired format.
	 *
	 * @return array Supported plugins with keys as slugs and values as plugin paths.
	 */
	public function get_supported_plugins() {
		$default_values    = $this->get_default_values();
		$supported_plugins = array();

		foreach ( $default_values as $value ) {
			$supported_plugins[ $value['slug'] ] = $value['plugin_path'];
		}

		return $supported_plugins;
	}

	/**
	 * Get a list of plugin names from the default values.
	 *
	 * @return array List of plugin names.
	 */
	public function get_supported_plugins_name_list() {
		$default_values = $this->get_default_values();
		$names_list     = array();

		foreach ( $default_values as $value ) {
			$names_list[] = $value['name'];
		}

		return $names_list;
	}
}
