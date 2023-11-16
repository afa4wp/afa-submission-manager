<?php
/**
 * The UserListTable Class.
 *
 * @package  WP_All_Forms_API
 * @since 1.0.0
 */

namespace Includes\Admin\Pages;

use Includes\Models\UserModel;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WP_List_Table' ) ) {
	require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
};

use Includes\Controllers\UserTokensController;

/**
 * Class UserListTable
 *
 * Render logged user
 *
 * @since 1.0.0
 */
class UserListTable extends \WP_List_Table {

	/**
	 * Const to declare page.
	 */
	const PAGE = 'wp_all_forms_api';

	/**
	 * Const to declare number of posts to show per page in the table.
	 */
	const POSTS_PER_PAGE = 10;

	/**
	 * User Tokens Controller
	 *
	 * @var UserTokensController
	 */
	private $user_tokens_controller;

	/**
	 * User User Model
	 *
	 * @var UserModel;
	 */
	private $user_model;

	/**
	 * UserListTable constructor.
	 */
	public function __construct() {

		parent::__construct(
			array(
				'singular' => 'wp_all_forms_api_logged_user', // Singular label.
				'plural'   => 'wp_all_forms_api_logged_users', // plural label, also this well be one of the table css class.
				'ajax'     => false, // We won't support Ajax for this table.
			)
		);

		$this->user_tokens_controller = new UserTokensController();
		$this->user_model             = new UserModel();
	}

	/**
	 * Gets a list of columns
	 *
	 * @return array
	 */
	public function get_columns() {
		$table_columns = array(
			'cb'           => '<input type="checkbox" />', // to display the checkbox.
			'user_login'   => esc_html__( 'User Login', 'afa-submission-manager' ),
			'display_name' => esc_html__( 'Display Name', 'afa-submission-manager' ),
			'user_id'      => esc_html__( 'User Id', 'afa-submission-manager' ),
		);
		return $table_columns;
	}

	/**
	 * Message to be displayed when there are no items
	 *
	 * @return void
	 */
	public function no_items() {
		esc_html_e( 'No users Connected.', 'afa-submission-manager' );
	}

	/**
	 * Prepares the list of items for displaying
	 *
	 * @return void
	 */
	public function prepare_items() {

		$this->handle_table_actions();

		$table_data = $this->fetch_table_data();

		$table_data_info = $table_data['info'];

		$this->set_pagination_args(
			array(
				'total_items' => $table_data_info ['count'],
				'per_page'    => self::POSTS_PER_PAGE,
				'total_pages' => $table_data_info ['pages'],
			)
		);
		$this->items = $table_data['results'];
	}

	/**
	 * Get list of items for displaying
	 *
	 * @return array
	 */
	public function fetch_table_data() {
		$search_query = ( ! empty( $_GET['s'] ) ) ? sanitize_text_field( wp_unslash( $_GET['s'] ) ) : ''; //phpcs:ignore WordPress.Security.NonceVerification.Recommended

		// phpcs:ignore
		$page = isset( $_GET['paged'] ) && $_GET['paged'] > 0 ? intval( $_GET['paged'] ) : 1;

		if ( ! empty( $search_query ) ) {
			$query_results = $this->user_tokens_controller->search( $search_query, $page );
			return $query_results;
		}

		$query_results = $this->user_tokens_controller->paginate();
		return $query_results;
	}

	/**
	 * Generates the columns
	 *
	 * @param object|array $item The item.
	 * @param string       $column_name The column name.
	 *
	 * @return object|array
	 */
	public function column_default( $item, $column_name ) {
		switch ( $column_name ) {
			case 'display_name':
			case 'user_id':
			case 'user_login':
				return $item[ $column_name ];
			default:
				return $item[ $column_name ];
		}
	}

	/**
	 * Generates the table rows
	 *
	 * @param object|array $item The item data from DB.
	 *
	 * @return string
	 */
	protected function column_cb( $item ) {
		return sprintf(
			'<label class="screen-reader-text" for="user_token_' . $item['id'] . '">' . sprintf( esc_html__( 'Select', 'afa-submission-manager' ) . ' %s', esc_attr( $item['user_login'] ) ) . '</label>'
			. "<input type='checkbox' name='users_tokens[]' id='user_token_{$item['id']}' value='{$item['id']}' />"
		);
	}

	/**
	 * The Column User Login
	 *
	 * @param object|array $item The item data from DB.
	 *
	 * @return string
	 */
	protected function column_user_login( $item ) {
		$query_args_delete_user_token = array(
			'page'       => self::PAGE,
			'action'     => 'delete',
			'user_token' => absint( $item['id'] ),
			'_wpnonce'   => wp_create_nonce( 'delete_user_token_nonce' ),
		);

		$delete_user_link         = esc_url( add_query_arg( $query_args_delete_user_token ) );
		$row_value                = '<strong>' . $item['user_login'] . '</strong>';
		$actions['view_usermeta'] = '<a class="submitdelete" href="' . $delete_user_link . '">' . __( 'Remover', 'Remover' ) . '</a>';
		return $row_value . $this->row_actions( $actions );
	}

	/**
	 * Render table
	 *
	 * @return void
	 */
	public function render() {
		$this->prepare_items();
		$this->view();
	}

	/**
	 * Retrieves the list of bulk actions available for this table
	 *
	 * @return array
	 */
	public function get_bulk_actions() {
		$actions = array(
			'delete' => __( 'Remove Users', 'wp-ultimo' ),
		);
		return $actions;
	}

	/**
	 * Process bulk actions available for this table
	 *
	 * @param array $ids Users ids.
	 *
	 * @return void
	 */
	public function process_bulk_action( $ids ) {

		foreach ( $ids as $id ) {
			$this->user_tokens_controller->delete_user_token_by_id( $id );
			$this->user_model->remove_staff( $id );
		}
		if ( wp_safe_redirect( admin_url( 'admin.php?page=' . esc_html( self::PAGE ) ) ) ) {
			exit;
		}
	}

	/**
	 * Process single actions delete for this table
	 *
	 * @param string $user_id The user ID.
	 *
	 * @return void
	 */
	public function process_delete_action( $user_id ) {
		$this->user_tokens_controller->delete_user_token_by_id( $user_id );
		$this->user_model->remove_staff( $user_id );
		if ( wp_safe_redirect( admin_url( 'admin.php?page=' . esc_html( self::PAGE ) ) ) ) {
			exit;
		}
	}

	/**
	 * Process actions triggered by the user
	 *
	 * @return void
	 */
	public function handle_table_actions() {

		if ( ! isset( $_REQUEST['page'] ) || 'wp_all_forms_api' !== $_REQUEST['page'] ) {
			return;
		}

		if ( ( isset( $_GET['action'] ) && 'delete' === $_GET['action'] ) ) {

			if ( isset( $_REQUEST['_wpnonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_REQUEST['_wpnonce'] ) ), 'delete_user_token_nonce' ) ) {

				$user_token_id = isset( $_GET['user_token'] ) && $_GET['user_token'] > 0 ? intval( $_GET['user_token'] ) : null;
				if ( ! empty( $user_token_id ) ) {
					$this->process_delete_action( $user_token_id );
				}
			} else {

				die( esc_html_e( 'Security check', 'afa-submission-manager' ) );

			}
		}

		if ( ( isset( $_POST['action'] ) && 'delete' === $_POST['action'] )
			|| ( isset( $_POST['action2'] ) && 'delete' === $_POST['action2'] )
		) {

			if ( isset( $_REQUEST['_wpnonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_REQUEST['_wpnonce'] ) ), 'bulk-' . $this->_args['plural'] ) ) {
				$ids = array();

				$users_tokens = ! empty( $_POST['users_tokens'] ) ? map_deep( (array) wp_unslash( $_POST['users_tokens'] ), 'sanitize_text_field' ) : array();

				foreach ( $users_tokens as $key => $value ) {
					$id = isset( $value ) && $value > 0 ? intval( $value ) : null;
					if ( null !== $id ) {
						$ids[] = $id;
					}
				}

				$this->process_bulk_action( $ids );

			} else {

				die( esc_html_e( 'Security check', 'afa-submission-manager' ) );

			}
		}
	}

	/**
	 * Render all items
	 *
	 * @return void
	 */
	public function view() {
		?>
		<div class="wrap">    
		<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
				<div id="wp-forms-api-list-table">			
					<div id="nds-post-body">
						<form id="wp-forms-api-user-search" method="get">
							<input type="hidden" value="<?php echo esc_html( self::PAGE ); ?>" name="page">
							<?php
								$this->search_box( esc_html__( 'Search User', 'afa-submission-manager' ), 'search_user_logged' );
							?>
						</form>		
						<form id="wp-forms-api-user-list-form" method="post">
							<input type="hidden" name="page" value="<?php echo esc_html( self::PAGE ); ?>" />
							<?php
								$this->display();
							?>
						</form>
					</div>			
				</div>
		</div>
		<?php
	}
}

