<?php
/**
 * The Supported Plugins Model Class.
 *
 * @package  claud/afa-submission-manager
 * @since 1.0.0
 */

namespace AFASM\Includes\Models;

use AFASM\Includes\Plugins\AFASM_Constant;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class SupportedPluginsModel
 *
 * Hendler with table supported_plugins
 *
 * @since 1.0.0
 */
class AFASM_Supported_Plugins_Model {

	/**
	 * Table name
	 *
	 * @var string
	 */
	private $table_name;

	/**
	 * SupportedPluginsModel constructor.
	 */
	public function __construct() {
		global $wpdb;
		$this->table_name = $wpdb->prefix . AFASM_Constant::TABLE_SUPPORTED_PLUGINS;
	}

	/**
	 * Get supported plugins list
	 *
	 * @return array
	 */
	public function get_all_supported_plugins() {
		global $wpdb;
		$sql     = 'SELECT * FROM %i';
		$sql     = $wpdb->prepare( $sql, array( $this->table_name ) );// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
		$results = $wpdb->get_results( $sql, OBJECT ); // phpcs:ignore

		return $results;
	}

	/**
	 * Get supported plugin by id
	 *
	 * @param int $id The supported plugin id.
	 *
	 * @return object
	 */
	public function get_supported_plugin_by_id( $id ) {

		global $wpdb;

		$sql = 'SELECT * FROM %i WHERE id=%d';

		$sql = $wpdb->prepare( $sql, array( $this->table_name, $id ) );// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared

		// phpcs:ignore
		$results = $wpdb->get_results( $sql, OBJECT );

		if ( count( $results ) > 0 ) {
			return $results[0];
		}

		return null;
	}

	/**
	 * Get  supported plugin by slug
	 *
	 * @param string $slug The notification type.
	 *
	 * @return object
	 */
	public function get_supported_plugin_by_slug( $slug ) {

		global $wpdb;

		$sql = 'SELECT * FROM %i WHERE `slug`=%s';

		$sql = $wpdb->prepare( $sql, array( $this->table_name, $slug ) );// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared

		// phpcs:ignore
		$results = $wpdb->get_results( $sql, OBJECT );

		if ( count( $results ) > 0 ) {
			return $results[0];
		}

		return null;
	}

}
