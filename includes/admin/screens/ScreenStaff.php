<?php
/**
 * The staff tab item for configuration screen
 *
 * @package  WP_All_Forms_API
 * @since 1.0.0
 */

namespace Includes\Admin\Screens;

use Includes\Admin\Screens\Screen;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Class ScreenStaff
 *
 * Render Staff content
 *
 * @since 1.0.0
 */
class ScreenStaff extends Screen {

	/**
	 * Tab param
	 *
	 * @var string
	 */
	const ID = 'staff';

	/**
	 * ScreenStaff constructor.
	 */
	public function __construct() {
		$this->id    = self::ID;
		$this->label = 'Staff';
		add_action( 'admin_init', array( $this, 'settings' ) );
	}

	/**
	 * Show staff content
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function render() {
		$this->save_settings();
		$nonce = wp_create_nonce( 'sreen-staff' );

		?>	
			<div>
				Lorem, ipsum dolor sit amet consectetur adipisicing elit.
			</div>
			<form action="<?php echo esc_html( admin_url( 'admin.php?page=wp_all_forms_api_settings&tab=staff' ) ); ?>" method="POST">
				<table class="form-table">
					<?php do_settings_fields( 'wp_all_forms_api_settings', 'wp_all_forms_api_settings_staff_section' ); ?>
				</table>
				<div >
					<p>
						<button name="save" class="button-primary" type="submit" value="Salvar alterações">Salvar alterações</button>
						<input type="hidden" id="_wpnonce" name="_wpnonce" value="<?php echo esc_html( $nonce ); ?>">
					</p>
				</div>
			</form>
		<?php
	}

	/**
	 * Add seetings fields
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function settings() {
		$all_options = get_option( 'wp_all_forms_api_settings_staff_options', false );

		if ( empty( $all_options ) ) {
			$all_options = array();
		}

		add_settings_field(
			'wp_all_forms_api_add_user',
			'Adicionar usuarios',
			array( $this, 'input_add_user_render' ),
			'wp_all_forms_api_settings',
			'wp_all_forms_api_settings_staff_section',
			$all_options
		);
	}

	/**
	 * Render check field
	 *
	 * @since 1.0.0
	 *
	 * @param array $args The setting value.
	 *
	 * @return void
	 */
	public function input_add_user_render( array $args ) {

		$checked = '';
		if ( array_key_exists( 'add_user', $args ) ) {
			$value = $args['add_user'];
			if ( 'on' === $value ) {
				$checked = 'checked';
			}
		}

		?>
			<fieldset>
				<label for="wp_all_forms_api_add_user">
					<input name="wp_all_forms_api_add_user" id="wp_all_forms_api_add_user" type="checkbox" class="" value="on" <?php echo esc_html( $checked ); ?>> 
					Adiciona novo usarios.	
				</label> 
				<p class="description">Lorem ipsum dolor sit amet consectetur adipisicing elit. Vero fuga maxime.</p>
			</fieldset>
		<?php
	}

	/**
	 * Save settings
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function save_settings() {
		$all_options = array();
		if ( isset( $_REQUEST['_wpnonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_REQUEST['_wpnonce'] ) ), 'sreen-staff' ) ) {

			if ( ! empty( $_POST['wp_all_forms_api_add_user'] ) ) {
				$add_user                = sanitize_text_field( wp_unslash( $_POST['wp_all_forms_api_add_user'] ) );
				$all_options['add_user'] = $add_user;
			}

			update_option( 'wp_all_forms_api_settings_staff_options', $all_options );

			if ( wp_safe_redirect( admin_url( 'admin.php?page=wp_all_forms_api_settings&tab=staff' ) ) ) {
				exit;
			}
		}

	}
}

