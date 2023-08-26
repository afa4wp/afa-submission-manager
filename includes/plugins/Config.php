<?php
/**
 * The Config Class.
 *
 * @package  WP_All_Forms_API
 * @since 1.0.0
 */

namespace Includes\Plugins;

use Includes\Models\CF7\FormModel as CF7FormModel;
use Includes\Models\GF\FormModel as GFFormModel;
use Includes\Models\WEF\FormModel as WEFFormModel;
use Includes\Models\WPF\FormModel as WPFFormModel;
use Includes\Models\CF7\EntryModel as CF7EntryModel;
use Includes\Models\GF\EntryModel as GFEntryModel;
use Includes\Models\WEF\EntryModel as WEFEntryModel;
use Includes\Models\WPF\EntryModel as WPFEntryModel;
use Includes\Models\UserModel;
use Includes\Plugins\Constant;

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
	 * Plugins.
	 *
	 * @var array
	 */
	const PLUGINS = array(
		Constant::FORM_SLUG_CF7 => 'contact-form-7/wp-contact-form-7.php',
		Constant::FORM_SLUG_GF  => 'gravityforms/gravityforms.php',
		Constant::FORM_SLUG_WEF => 'weforms/weforms.php',
		Constant::FORM_SLUG_WPF => 'wpforms/wpforms.php',
	);

	/**
	 * Lite Plugins.
	 *
	 * @var array
	 */
	const PLUGINS_LITE = array(
		Constant::FORM_SLUG_WPF => 'wpforms-lite/wpforms.php',
	);

	/**
	 * Get all installed supported forms from plugin.
	 */
	public function installed_forms() {
		$plugins = $this->get_installed_plugins_from_array( self::PLUGINS );
		$lite    = $this->get_installed_plugins_from_array( self::PLUGINS_LITE );

		// Combine plugins and lite plugins, excluding duplicates.
		foreach ( $lite as $plugin_key => $plugin_name ) {
			if ( ! array_key_exists( $plugin_key, $plugins ) ) {
				$plugins[ $plugin_key ] = $plugin_name;
			}
		}

		return $plugins;
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
	 *
	 * @param \WP_REST_Request $request WP Request Object.
	 *
	 * @return boolean
	 */
	public function wp_afa_check_authorization( $request ) {

		if ( ! is_user_logged_in() ) {
			return false;
		}

		$user = wp_get_current_user();

		$user_can_manage_wp_afa = ( new UserModel() )->user_can_manage_wp_afa( $user->ID );

		if ( ! $user_can_manage_wp_afa ) {
			return false;
		}

		return true;
	} // end check_authorization;

	/**
	 * Check if form is supported
	 *
	 * @since 1.0.0
	 *
	 * @param string $key The key of form type.
	 *
	 * @return boolean
	 */
	public function is_plugin_key_exists( $key ) {
		return array_key_exists( $key, self::PLUGINS );
	}

	/**
	 * Get form model
	 *
	 * @since 1.0.0
	 *
	 * @param string $key The key of form type.
	 *
	 * @return object|null
	 */
	public function form_model( $key ) {
		$forms = array(
			Constant::FORM_SLUG_CF7 => new CF7FormModel(),
			Constant::FORM_SLUG_GF  => new GFFormModel(),
			Constant::FORM_SLUG_WEF => new WEFFormModel(),
			Constant::FORM_SLUG_WPF => new WPFFormModel(),
		);

		if ( array_key_exists( $key, $forms ) ) {
			return $forms[ $key ];
		}

		return null;
	}

	/**
	 * Get entry model
	 *
	 * @since 1.0.0
	 *
	 * @param string $key The key of form type.
	 *
	 * @return object|null
	 */
	public function entry_model( $key ) {
		$forms = array(
			Constant::FORM_SLUG_CF7 => new CF7EntryModel(),
			Constant::FORM_SLUG_GF  => new GFEntryModel(),
			Constant::FORM_SLUG_WEF => new WEFEntryModel(),
			Constant::FORM_SLUG_WPF => new WPFEntryModel(),
		);

		if ( array_key_exists( $key, $forms ) ) {
			return $forms[ $key ];
		}

		return null;
	}
}
