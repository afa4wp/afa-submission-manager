<?php
/**
 * The Abstarct Form Model Class.
 *
 * @package  WP_All_Forms_API
 * @since 1.0.0
 */

namespace Includes\Models;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Class AbstractFormModel
 *
 * Init all routes
 *
 * @since 1.0.0
 */
abstract class AbstractFormModel {

	/**
	 * The route name space
	 *
	 * @var string
	 */
	protected $name;

	/**
	 * Route constructor
	 *
	 * @param string $name The route name space.
	 */
	public function __construct( $name ) {
		$this->name = $name;
	}

	/**
	 * Get forms by id
	 *
	 * @since 1.0.0
	 *
	 * @param int $id The form id.
	 *
	 * @return object|array $form WPAFA form
	 */
	abstract public function form_by_id( $id );

	/**
	 * Get all forms
	 *
	 * @since 1.0.0
	 *
	 * @param int $offset The offset.
	 * @param int $number_of_records_per_page The posts per page.
	 *
	 * @return array $forms WPAFA forms
	 */
	abstract public function forms( $offset, $number_of_records_per_page );

	/**
	 * Search forms by name.
	 *
	 * @since 1.0.0
	 *
	 * @param string $post_name The post name.
	 * @param int    $offset The offset.
	 * @param int    $number_of_records_per_page The posts per page.
	 *
	 * @return array $forms WPAFA forms
	 */
	abstract public function search_forms( $post_name, $offset, $number_of_records_per_page );

	/**
	 * Farmat data
	 *
	 * @since 1.0.0
	 *
	 * @param array $data The forms data.
	 *
	 * @return array $forms WPAFA forms
	 */
	abstract public function prepare_data( $data );

}
