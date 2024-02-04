<?php
/**
 * The tab screen.
 *
 * @package  claud/afa-submission-manager
 * @since 1.0.0
 */

namespace AFASM\Includes\Admin\Screens;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class AFA_Screen
 *
 * Render Staff content
 *
 * @since 1.0.0
 */
abstract class AFASM_Screen {

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
