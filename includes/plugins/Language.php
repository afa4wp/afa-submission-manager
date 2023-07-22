<?php
/**
 * The Language Class.
 *
 * @package  WP_All_Forms_API
 * @since 1.0.0
 */

namespace Includes\Plugins;

use Includes\Plugins\Constant;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Class Language
 *
 * Setup plugin language
 *
 * @since 1.0.0
 */
class Language {

	/**
	 * Add supported language.
	 *
	 * @var array
	 */
	const LANGUAGES = array(
		'de' => Constant::PLUGIN_LANGUAGE_DOMAIN . '-de',
		'en' => Constant::PLUGIN_LANGUAGE_DOMAIN . '-en',
		'es' => Constant::PLUGIN_LANGUAGE_DOMAIN . '-es',
		'it' => Constant::PLUGIN_LANGUAGE_DOMAIN . '-it',
		'pt' => Constant::PLUGIN_LANGUAGE_DOMAIN . '-pt',
		'fr' => Constant::PLUGIN_LANGUAGE_DOMAIN . '-fr',
	);

	/**
	 * Get language by key
	 *
	 * @since 1.0.0
	 *
	 * @param string $key The key language.
	 *
	 * @return string|null
	 */
	private function get_language_by_key( $key ) {

		if ( array_key_exists( $key, self::LANGUAGES ) ) {
			return self::LANGUAGES[ $key ];
		}

		return null;
	}

	/**
	 * Load text domaain by language key
	 *
	 * @since 1.0.0
	 *
	 * @param string $key The key language.
	 *
	 * @return boolean
	 */
	public function load_textdomain_by_language_key( $key ) {

		$textdomanin = $this->get_language_by_key( $key );

		if ( empty( $textdomanin ) ) {
			return false;
		}

		$result = load_textdomain( 'wp-all-forms-api', WP_ALL_FORMS_API_PLUGIN_PATH . 'languages/' . $textdomanin . '.mo' );

		return $result;
	}

}
