<?php
/**
 * The Config Class.
 *
 * @package  claud/afa-submission-manager
 * @since 1.0.0
 */

namespace AFASM\Includes\Plugins;

use Includes\Models\CF7\FormModel as CF7FormModel;
use Includes\Models\GF\FormModel as GFFormModel;
use Includes\Models\WEF\FormModel as WEFFormModel;
use Includes\Models\WPF\FormModel as WPFFormModel;
use Includes\Models\EFB\FormModel as EFBFormModel;
use Includes\Models\CF7\EntryModel as CF7EntryModel;
use Includes\Models\GF\EntryModel as GFEntryModel;
use Includes\Models\WEF\EntryModel as WEFEntryModel;
use Includes\Models\WPF\EntryModel as WPFEntryModel;
use Includes\Models\EFB\EntryModel as EFBEntryModel;
use Includes\Models\UserModel;
use AFASM\Includes\Plugins\AFASM_Constant;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! function_exists( 'is_plugin_active' ) ) {
	include_once ABSPATH . 'wp-admin/includes/plugin.php';
}
/**
 * Class AFASM_Config
 *
 * Create config info
 *
 * @since 1.0.0
 */
class AFASM_Config {

	/**
	 * Plugins.
	 *
	 * @var array
	 */
	const PLUGINS = array(
		AFASM_Constant::FORM_SLUG_CF7 => 'contact-form-7/wp-contact-form-7.php',
		AFASM_Constant::FORM_SLUG_GF  => 'gravityforms/gravityforms.php',
		AFASM_Constant::FORM_SLUG_WEF => 'weforms/weforms.php',
		AFASM_Constant::FORM_SLUG_WPF => 'wpforms/wpforms.php',
		AFASM_Constant::FORM_SLUG_EFB => 'elementor-pro/elementor-pro.php',
	);

	/**
	 * Lite Plugins.
	 *
	 * @var array
	 */
	const PLUGINS_LITE = array(
		AFASM_Constant::FORM_SLUG_WPF => 'wpforms-lite/wpforms.php',
		AFASM_Constant::FORM_SLUG_EFB => 'elementor/elementor.php',
	);

	/**
	 * Get all installed supported forms from plugin.
	 */
	public function installed_forms() {
		$plugins = $this->get_installed_plugins_from_array( self::PLUGINS );
		$lite    = $this->get_installed_plugins_from_array( self::PLUGINS_LITE );

		if ( ! isset( $plugins[ AFASM_Constant::FORM_SLUG_WPF ] ) && ! isset( $lite[ AFASM_Constant::FORM_SLUG_WPF ] ) ) {
			unset( $plugins[ AFASM_Constant::FORM_SLUG_WPF ] );
		}
		if ( isset( $plugins[ AFASM_Constant::FORM_SLUG_CF7 ] ) && ! is_plugin_active( 'flamingo/flamingo.php' ) ) {
			unset( $plugins[ AFASM_Constant::FORM_SLUG_CF7 ] );
		}
		if ( isset( $plugins[ AFASM_Constant::FORM_SLUG_EFB ] ) && ! isset( $lite[ AFASM_Constant::FORM_SLUG_EFB ] ) ) {
			unset( $plugins[ AFASM_Constant::FORM_SLUG_EFB ] );
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
	public function afa_check_authorization( $request ) {

		if ( ! is_user_logged_in() ) {
			return false;
		}

		$user = wp_get_current_user();

		$user_can_manage_afa = ( new UserModel() )->user_can_manage_afa( $user->ID );

		if ( ! $user_can_manage_afa ) {
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
			AFASM_Constant::FORM_SLUG_CF7 => new CF7FormModel(),
			AFASM_Constant::FORM_SLUG_GF  => new GFFormModel(),
			AFASM_Constant::FORM_SLUG_WEF => new WEFFormModel(),
			AFASM_Constant::FORM_SLUG_WPF => new WPFFormModel(),
			AFASM_Constant::FORM_SLUG_EFB => new EFBFormModel(),
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
			AFASM_Constant::FORM_SLUG_CF7 => new CF7EntryModel(),
			AFASM_Constant::FORM_SLUG_GF  => new GFEntryModel(),
			AFASM_Constant::FORM_SLUG_WEF => new WEFEntryModel(),
			AFASM_Constant::FORM_SLUG_WPF => new WPFEntryModel(),
			AFASM_Constant::FORM_SLUG_EFB => new EFBEntryModel(),
		);

		if ( array_key_exists( $key, $forms ) ) {
			return $forms[ $key ];
		}

		return null;
	}

	/**
	 * Check if form is installed
	 *
	 * @since 1.0.0
	 *
	 * @param string $key The key of form type.
	 *
	 * @return boolean
	 */
	public function chek_plugin_form_is_installed_by_slug( $key ) {
		return array_key_exists( $key, $this->installed_forms() );
	}
}
