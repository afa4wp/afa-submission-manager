<?php
/**
 * The Config Class.
 *
 * @package  WP_All_Forms_API
 * @since 1.0.0
 */

namespace Includes\Plugins;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
/**
 * Class Route
 *
 * Create config info
 *
 * @since 1.0.0
 */
class Config {

	/**
	 * Add public route.
	 *
	 * @var array
	 */
	const PLUGINS = array(
		'cf7' => 'contact-form-7/wp-contact-form-7.php',
		'gf'  => 'gravityforms/gravityforms.php',
		'wef' => 'weforms/weforms.php',
		'wpf' => 'wpforms/wpforms.php',
	);

	/**
	 * Get all installed supported forms from plugin.
	 */
	public function installed_forms() {

		return $this->get_installed_plugins_from_array( self::PLUGINS );
	}

	/**
	 * Get installed plugin from array
	 *
	 * @param array $plugins_array The array of key and plugin directory.
	 *
	 * @return array Installed plugin
	 */
	private function get_installed_plugins_from_array( $plugins_array ) {
		$installed_plugins = array();

		foreach ( $plugins_array as $plugin_key => $plugin_path ) {
			if ( is_plugin_active( $plugin_path ) ) {
				$plugin_data = get_plugin_data( WP_PLUGIN_DIR . '/' . $plugin_path );
				$plugin_name = $plugin_data['Name'];

				$installed_plugins[ $plugin_key ] = $plugin_name;
			}
		}

		return $installed_plugins;
	}

}
