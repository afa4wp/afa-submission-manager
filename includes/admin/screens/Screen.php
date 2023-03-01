<?php
/**
 * The tab screen.
 *
 * @package  WP_All_Forms_API
 * @since 1.0.0
 */

namespace Includes\Admin\Screens;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Class WP_AFA_Screen
 *
 * Render Staff content
 *
 * @since 1.0.0
 */
abstract class Screen {

	/**
	 * Screen ID
	 *
	 * @var string
	 */
	protected $id;

	/**
	 * Screen label, for display
	 *
	 * @var string
	 */
	protected $label;

	/**
	 * Gets the screen ID.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function get_id() {

		return $this->id;
	}


	/**
	 * Gets the screen ID.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function get_label() {

		return $this->label;
	}

	/**
	 * Render the screen.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	abstract public function render();
}
