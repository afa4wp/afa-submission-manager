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

	/**
	 * Tries to validate if user can manage data
	 *
	 * @since 1.7.4
	 * @param \WP_REST_Request $request WP Request Object.
	 * @return boolean
	 */
	public function wp_afa_check_authorization( $request ) {

		if ( ! is_user_logged_in() ) {
			return false;
		}

		return true;
	} // end check_authorization;

	/**
	 * Check if form is supported
	 *
	 * @since 1.0.0
	 * @param string $key The key of form type.
	 * @return boolean
	 */
	public function is_plugin_key_exists( $key ) {
		return array_key_exists( $key, self::PLUGINS );
	}
}
