<?php
namespace Includes\Admin\Pages;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WP_List_Table' ) ) {
	require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
};

use Includes\Models\UserTokensModel;

class UserListTable extends \WP_List_Table {

	/**
	 * Const to declare number of posts to show per page in the table.
	 */
	const POSTS_PER_PAGE = 10;

	private $userTokensModel;

	function __construct() {

		parent::__construct(
			array(
				'singular' => 'wp_all_forms_api_logged_user', // Singular label
				'plural'   => 'wp_all_forms_api_logged_users', // plural label, also this well be one of the table css class
				'ajax'     => false, // We won't support Ajax for this table
			)
		);

		$this->userTokensModel = new UserTokensModel();

	}

	// just the barebone implementation.
	public function get_columns() {
		$table_columns = array(
			'cb'           => '<input type="checkbox" />', // to display the checkbox.
			'user_login'   => 'User Login',
			'display_name' => 'Display Name',
			'user_id'      => 'User Id',
		);
		return $table_columns;
	}

	public function no_items() {
		_e( 'No users logged.', '' );
	}

	public function prepare_items() {

		$this->handle_table_actions();

		/** Process bulk action */
		$this->process_bulk_action();

		$table_data = $this->fetch_table_data();

		$this->set_pagination_args(
			array(
				'total_items' => 20,
				'per_page'    => 15,
			)
		);
		$this->items = $table_data;
	}

	public function fetch_table_data() {

		$query_results = $this->userTokensModel->usersTokens( 0, 20 );
		return $query_results;

	}

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

	protected function column_cb( $item ) {
		return sprintf(
			'<label class="screen-reader-text" for="user_token_' . $item['id'] . '">' . sprintf( __( 'Select %s' ), $item['user_login'] ) . '</label>'
			. "<input type='checkbox' name='users_tokens[]' id='user_token_{$item['id']}' value='{$item['id']}' />"
		);
	}

	protected function column_user_login( $item ) {
		$query_args_delete_user_token = array(
			'page'       => wp_unslash( $_REQUEST['page'] ),
			'action'     => 'delete',
			'user_token' => absint( $item['id'] ),
			'_wpnonce'   => wp_create_nonce( 'delete_user_token_nonce' ),
		);

		$delete_user_link         = esc_url( add_query_arg( $query_args_delete_user_token ) );
		$row_value                = '<strong>' . $item['user_login'] . '</strong>';
		$actions['view_usermeta'] = '<a class="submitdelete" href="' . $delete_user_link . '">' . __( 'Remover', 'Remover' ) . '</a>';
		return $row_value . $this->row_actions( $actions );
	}

	public function render() {
		$this->prepare_items();
		$this->view();
	}

	public function get_bulk_actions() {
		$actions = array(
			'delete' => 'Remover Usuario',
		);
		return $actions;
	}

	public function process_bulk_action() {

	}

	/**
	 * Process actions triggered by the user
	 *
	 * @since    1.0.0
	 */
	public function handle_table_actions() {

		if ( ( isset( $_GET['action'] ) && $_GET['action'] == 'delete' ) ) {

			if ( isset( $_REQUEST['_wpnonce'] ) && wp_verify_nonce( wp_unslash( $_REQUEST['_wpnonce'] ), 'delete_user_token_nonce' ) ) {

				// action to single delete

			} else {

				// die( __( 'Security check', 'textdomain' ) );

			}
		}

		if ( ( isset( $_POST['action'] ) && $_POST['action'] == 'delete' )
			 || ( isset( $_POST['action2'] ) && $_POST['action2'] == 'delete' )
		) {

			if ( isset( $_REQUEST['_wpnonce'] ) && wp_verify_nonce( wp_unslash( $_REQUEST['_wpnonce'] ), 'bulk-' . $this->_args['plural'] ) ) {

				$this->process_bulk_action();

			} else {

				// die( __( 'Security check', 'textdomain' ) );

			}
		}
	}

	public function view() {
		?>
		<div class="wrap">    
			<h2>WP All Forms API - Logged Users</h2>
				<div id="wp-forms-api-list-table">			
					<div id="nds-post-body">
						<form id="wp-forms-api-user-search" method="get">
							<input type="hidden" value="<?php echo wp_unslash( $_REQUEST['page'] ); ?>" name="page">
							<?php
								$this->search_box( 'Search User', 'search_user_logged' );
							?>
								 
						</form>		
						<form id="wp-forms-api-user-list-form" method="post">
							<input type="hidden" name="page" value="<?php echo wp_unslash( $_REQUEST['page'] ); ?>" />
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

