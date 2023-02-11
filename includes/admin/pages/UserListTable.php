<?php

namespace Includes\Admin\Pages;

use Includes\Models\UserTokensModel;

class UserListTable extends \WP_List_Table
{   
    private $userTokensModel;
    
    function __construct() {
        parent::__construct( array(
       'singular'=> 'wp_list_text_link', //Singular label
       'plural' => 'wp_list_test_links', //plural label, also this well be one of the table css class
       'ajax'   => false //We won't support Ajax for this table
       ) );
       $this->userTokensModel = new UserTokensModel();
     }
    // just the barebone implementation.
    public function get_columns() {
        $table_columns = array(
            'cb'		=> '<input type="checkbox" />', // to display the checkbox.			 
            'user_login'	=> 'User Login',
            'display_name'	=> 'Display Name',			
            'user_id'		=> 'User Id'
        );		
        return $table_columns;	
    }

    public function no_items() {
        _e( 'No users avaliable.', "" );
    }
    
    public function prepare_items() {
        $table_data = $this->fetch_table_data();
        $this->items = $table_data;	
    }


    public function fetch_table_data() {
        /*global $wpdb;
        $wpdb_table = $wpdb->prefix . 'users';		
        $orderby = ( isset( $_GET['orderby'] ) ) ? esc_sql( $_GET['orderby'] ) : 'user_registered';
        $order = ( isset( $_GET['order'] ) ) ? esc_sql( $_GET['order'] ) : 'ASC';
  
        $user_query = "SELECT 
                          user_login, display_name, user_registered, ID
                        FROM 
                          $wpdb_table 
                        ORDER BY $orderby $order";
  
        // query output_type will be an associative array with ARRAY_A.
        $query_results = $wpdb->get_results( $user_query, ARRAY_A  ); */
        
        // return result array to prepare_items.

        $serTokensModel = new UserTokensModel();

        $query_results = $serTokensModel->usersTokens(0, 20);

        return $query_results;		
    }

    public function column_default( $item, $column_name ) {		
        switch ( $column_name ) {			
            case 'display_name':
            case 'user_id':
            case 'user_login':
                return $item[$column_name];
            default:
              return $item[$column_name];
        }
    }

    protected function column_cb( $item ) {
        return sprintf(		
        '<label class="screen-reader-text" for="user_' . $item['id'] . '">' . sprintf( __( 'Select %s' ), $item['user_login'] ) . '</label>'
        . "<input type='checkbox' name='users[]' id='user_{$item['id']}' value='{$item['id']}' />"					
        );
    }

    public function render(){
        $this->prepare_items();
        $this->view();
    }


    public function view(){
        ?>
        <div class="wrap">    
            <h2>WP All Forms API</h2>
                <div id="wp-forms-api-list-table">			
                    <div id="nds-post-body">		
                        <form id="wp-forms-api-user-list-form" method="get">
                            <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
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

