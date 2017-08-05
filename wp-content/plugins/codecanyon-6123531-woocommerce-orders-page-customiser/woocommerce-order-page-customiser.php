<?php
/**
 * Plugin Name: WooCommerce Orders Page Customiser
 * Plugin URI: http://actualityextensions.com/
 * Description: Customize the view of the Orders page as per user preferences by selecting which columns to show/hide, the order of columns as well as additional columns.
 * Version: 1.3.1
 * Author: Actuality Extensions
 * Author URI: http://actualityextensions.com/
 * Tested up to: 4.2
 *
 * Copyright: (c) 2012-2013 Actuality Extensions
 *
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 *
 * @package     WC-Orders-Page-Customiser
 * @author      Actuality Extensions
 * @category    Plugin
 * @copyright   Copyright (c) 2012-2013, Actuality Extensions
 * @license     http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License v3.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Check if WooCommerce is active
 **/
if ( ! in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
    // WooCommerce is not active/installed
    function linen_order_custom_admin_notice() {
    ?>
	    <div class="updated">
	        <p>WooCommerce is <strong>NOT</strong> active/installed. <strong>WooCommerce Order page customizer is not working either</strong></p>
	    </div>
	    <?php
	}
	add_action( 'admin_notices', 'linen_order_custom_admin_notice' );
	return;
}

/**
* Plugin's class
*/
class WooOrderCustomiser
{

	/**
	 * holds the columns names and slug used to generate the sorting and width setting form
	 * @var array
	 */
	public $css_fields;

	/**
	 * Holds js function calls to set the width of different columns
	 * @var string
	 */
	public $css_js;

	/**
   * @var WooOrderCustomiser the single instance of the class
   * @since 1.3
   */
  protected static $_instance = null;
	

	/**
   * Main WooOrderCustomiser instance
   *
   * Ensures only one instance of WooOrderCustomiser is loaded or can be loaded.
   *
   * @since 1.3
   * @static
   * @see WCOC()
   * @return WooOrderCustomiser - Main instance
   */
  public static function instance() {
      if ( is_null( self::$_instance ) ) {
          self::$_instance = new self();
      }
      return self::$_instance;
  }

  /**
     * Cloning is forbidden.
     *
     * @since 1.3
     */
    public function __clone() {
        _doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'woocommerce' ), '1.9' );
    }

    /**
     * Unserializing instances of this class is forbidden.
     *
     * @since 1.3
     */
    public function __wakeup() {
        _doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'woocommerce' ), '1.9' );
    }

	/**
	 * Instantiates the plugin. Adds necessary actions and filters
	 */
	function __construct() {

		$this->css_js = '';

		// Include required files
		$this->includes();

		$this->install();

		# Add extra columns to the table
		
	    if ( defined('WC_VERSION') && version_compare( WC_VERSION, '2.3', '<=' ) ) {
			add_filter( 'manage_shop_order_posts_columns', array( $this, 'extra_columns' ), 9999 );
	    }else{
	      	add_filter( 'manage_edit-shop_order_columns', array( $this, 'extra_columns' ), 9999 );
	    }

		add_action( 'manage_edit-shop_order_sortable_columns', array( &$this, 'sortable_extra_columns' ) , 10 );
		add_action( 'pre_get_posts', array( &$this, 'extra_columns_order_by' ) );

		# Values of the columns per row
		add_action( 'manage_shop_order_posts_custom_column', array( &$this, 'extra_columns_data' ) , 10 );
		

		# Ajax ordering request
		add_action( 'wp_ajax_linen_cols_order', array( &$this, 'ajax_cols_order' ) );

		# Enqueue CSS and Javascript required by the plugin to work
		add_action( 'admin_enqueue_scripts', array( &$this, 'enqueue_assets' ) );

	}

	/**
	 * Include required core files used in admin and on the frontend.
	 */
	private function includes(){
		include_once( 'settings/settings.php' );
	}

	/**
	 * Install options.
	 */
	function install(){

		$first_time = get_user_meta( get_current_user_id(), '_linen_first_time', true );
		if( empty($first_time) ) {

			# Enqueue the javascript to untick the custom stuff
			add_action( 'admin_footer', array( &$this, 'untick_custom_cols' ), 99999 );

			# Create a record so that we avoid unticking next time the user logs in
			update_user_meta( get_current_user_id(), '_linen_first_time', 'done' );
		}
	}

	/**
	 * Enqueues CSS and Javascript only on the Orders page
	 * @return void
	 */
	function enqueue_assets() {

		if( isset( $_GET['page'] ) && $_GET['page'] == 'wc-settings' && isset( $_GET['tab'] ) && $_GET['tab'] == 'settings_orders_page' ){
			wp_enqueue_style( 'jquery-resizable-columns', plugin_dir_url(__FILE__) . 'assets/jquery-resizable-columns/jquery.resizableColumns.css' );	

			wp_enqueue_script( 'jquery-resizable-columns-store', plugin_dir_url(__FILE__) . 'assets/jquery-resizable-columns/store.min.js', array('jquery') );
			wp_enqueue_script( 'jquery-resizable-columns', plugin_dir_url(__FILE__) . 'assets/jquery-resizable-columns/jquery.resizableColumns.min.js', array('jquery', 'jquery-resizable-columns-store') );
			wp_enqueue_script( 'jquery-resizable-columns', plugin_dir_url(__FILE__) . 'assets/jquery-resizable-columns/jquery.resizableColumns.min.js', array('jquery', 'jquery-resizable-columns-store') );
			

			wp_enqueue_style( 'linen-custom-orders-settings', plugin_dir_url(__FILE__) . 'assets/css/settings.css' );	
			wp_enqueue_style( 'linen-custom-orders', plugin_dir_url(__FILE__) . 'assets/css/custom.css' );
			wp_enqueue_script( 'linen-custom-orders-settings', plugin_dir_url(__FILE__) . 'assets/js/settings.js', array('jquery', 'jquery-resizable-columns', 'jquery-ui-sortable', 'jquery-ui-slider') );


		}

		if( isset( $_GET['post_type'] ) && $_GET['post_type'] == 'shop_order') {
			wp_enqueue_style( 'jquery-resizable-columns', plugin_dir_url(__FILE__) . 'assets/jquery-resizable-columns/jquery.resizableColumns.css' );	

			wp_enqueue_script( 'jquery-resizable-columns-store', plugin_dir_url(__FILE__) . 'assets/jquery-resizable-columns/store.min.js', array('jquery') );
			wp_enqueue_script( 'jquery-resizable-columns', plugin_dir_url(__FILE__) . 'assets/jquery-resizable-columns/jquery.resizableColumns.min.js', array('jquery', 'jquery-resizable-columns-store') );
			wp_enqueue_script( 'jquery-resizable-columns', plugin_dir_url(__FILE__) . 'assets/jquery-resizable-columns/jquery.resizableColumns.min.js', array('jquery', 'jquery-resizable-columns-store') );

			wp_enqueue_script( 'linen-orders-sorting', plugin_dir_url(__FILE__) . 'assets/js/custom.js', array('jquery', 'jquery-resizable-columns') );

			$table_type         = get_option('wc_order_customiser_table_type');
			$input_method       = get_option('wc_order_customiser_column_width_input_method');
			$table_size         = get_option('wc_order_customiser_table_width');
			$column_headers     = apply_filters( "manage_edit-shop_order_columns", array() );
			$cols_width_percent = get_option( '_linen_cols_width_percent');
      $cols_width_pixels  = get_option( '_linen_cols_width_pixels');


    	if($table_type == 'static' && $input_method == 'defined_values'){
        if(!is_array($cols_width_pixels))
          $cols_width_pixels = array();
	      $table_size = array_sum($cols_width_pixels) + (count($cols_width_pixels)*20);
	    }

			$params = array(
              'table_type'   =>  $table_type ? $table_type : 'static',
              'input_method' =>  $input_method ? $input_method : 'draggable',
              'table_size'   =>  $table_size ? $table_size : count($column_headers)*150,
              'cols_width_percent'  =>  $cols_width_percent,
              'cols_width_pixels'  =>  $cols_width_pixels,
            );
			wp_localize_script( 'linen-orders-sorting', 'wc_opc_settings', $params );

			wp_enqueue_style( 'linen-custom-orders', plugin_dir_url(__FILE__) . 'assets/css/custom.css' );

		}
	}

	function get_extra_columns()
	{
		$columns['linen_order_total'] = __( 'Total', 'linen' );
		$columns['total_discount'] = __( 'Total Discount', 'linen' );
		$columns['customer_ip'] = __( 'Customer IP', 'linen' );
		$columns['linen_customer_name'] = __( 'Customer', 'linen' );
		$columns['shipping_costs'] = __( 'Shipping Costs', 'linen' );
		$columns['order_text_status'] = __( 'Status', 'linen' );
	    $columns['linen_email'] = __( 'Email', 'linen' );
	    $columns['linen_order_number'] = __( 'Order No.', 'linen' );
	    $columns['linen_phone_number'] = __( 'Phone', 'linen' );
	    $columns['linen_payment_option'] = __( 'Payment', 'linen' );
	    $columns['linen_shipping_option'] = __( 'Shipping ', 'linen' );
	    return $columns;
	}

	/**
	 * Defines the extra columns to appear in the orders page
	 * @param  [array] $columns [existing columns]
	 * @return void
	 */
	function extra_columns( $columns ) {
		$screen = get_current_screen();
		if( $screen->id == 'edit-shop_order'){ 
			$default_cols = $columns;
			$extra = $this->get_extra_columns();
			$columns = $columns + $extra;

			# Sort the columns order according to the user's preferences
			$columns = $this->sort_cols_according_to_order( $columns );

			$this->css_fields = $columns;

			$cols = get_option( 'wc_order_customiser_available_columns');

			$cols = (array) ($cols ? $cols : $default_cols );

			$new_cols = array();
			foreach ($columns as $key => $value) {
			  if( in_array($key, $cols))
			    $new_cols[$key] = $value;
			}
			$columns =  $new_cols;
		}

		return $columns;
	}

	public function sortable_extra_columns( $sortable_columns )
	{
		$sort_by = get_option('wc_order_customiser_column_sort_by');

		foreach ($sort_by as $value) {
			switch ($value) {
				case 'ID':
					$sortable_columns[ 'linen_order_number' ] = 'ID';
					break;
				case 'total':
					$sortable_columns[ 'linen_order_total' ] = 'order_total';
					break;
				case 'total_discount':
					$sortable_columns[ 'total_discount' ] = 'total_discount';
					break;
				case 'shipping_costs':
					$sortable_columns[ 'shipping_costs' ] = 'shipping_costs';
					break;
			}
		}

		return $sortable_columns;
	}

	public function extra_columns_order_by( $query )
	{
		if( ! is_admin() )
      return;

    $orderby = $query->get( 'orderby');
    switch ($orderby) {
  		case 'shipping_costs':
    		$query->set('meta_key','_order_shipping');
	      $query->set('orderby','meta_value_num');
    		break;
    	case 'total_discount':
    		$query->set('meta_key','_cart_discount');
    		$query->set('orderby','meta_value_num');
    		break;
    }
	}

	/**
	 * What data to appear for each custom column
	 * @param  [string] $c [column slug]
	 * @return void
	 */
	function extra_columns_data( $c ) {
		global $post, $woocommerce, $the_order;

		if ( empty( $the_order ) || $the_order->id != $post->ID )
			$the_order = new WC_Order( $post->ID );

		switch( $c ) {
			case 'total_discount':
				echo strip_tags(wc_price($the_order->get_total_discount()));
			break;

			case 'customer_ip':
				$ip_address = get_post_meta( $the_order->id, '_customer_ip_address', true );
				echo empty($ip_address)?__('N/A'):$ip_address;
			break;

			case 'linen_customer_name':
				if ( $the_order->user_id )
					$user_info = get_userdata( $the_order->user_id );

				if ( ! empty( $user_info ) ) {

	            	$user = '<a href="user-edit.php?user_id=' . absint( $user_info->ID ) . '">';

	            	if ( $user_info->first_name || $user_info->last_name )
	            		$user .= esc_html( $user_info->first_name . ' ' . $user_info->last_name );
	            	else
	            		$user .= esc_html( $user_info->display_name );

	            	$user .= '</a>';

	           	} else {
	           		$user = $the_order->billing_first_name . ' ' . $the_order->billing_last_name;
	           	}
	           	echo $user;
			break;

			case 'shipping_costs':
				echo strip_tags(wc_price($the_order->get_total_shipping()));
			break;

			case 'order_text_status':
				$colors = array(
					'pending' => '#ffba00',
					'failed' => '#e6db55',
					'processing' => '#73a724',
					'completed' => '#2ea2cc',
					'on-hold' => '#999',
					'cancelled' => '#a00',
					'refunded' => '#999'
				);
        if( is_plugin_active( 'woocommerce-status-actions/wc_custom_action_status.php' ) ) {
        	$this->load_custom_colors( $colors );
        }
        $order_status = false;
        if( function_exists('wc_get_custom_status')  ){
        	$order_status	= wc_get_custom_status($the_order->status);
        	if ($order_status){
	        	echo '<strong class="linen_custom_order_status status_orders_page status_text status_text_'.$order_status->status_slug.'">' . mb_strtolower($order_status->status_label) . '</strong>';
        	}
	        else{
	        	$slug = 'wc-'.$the_order->status;
	        	$modifed_def_st    = get_option( 'wc_custom_status_edit_existing_status', '' );
	        	$name = isset($modifed_def_st[$slug]) && !empty($modifed_def_st[$slug]['label']) ? $modifed_def_st[$slug]['label'] : $the_order->status;
	        	echo '<strong class="linen_custom_order_status status_orders_page status_text status_text_'.$the_order->status.'">' . $name . '</strong>';
	        }

        }else{
	        	echo '<span class="linen_custom_order_status" style="background:' . (isset($colors[$the_order->status]) ? $colors[$the_order->status] : '' ). '">' . $the_order->status . '</span>';
        }
			break;

	        case 'linen_email':
	        	if ( $the_order->billing_email )
       		 		echo '<small class="meta"> ' . '<a href="' . esc_url( 'mailto:' . $the_order->billing_email ) . '">' . esc_html( $the_order->billing_email ) . '</a></small>';
	        break;

	        case 'linen_order_number':
	        	echo '<a href="' . admin_url( 'post.php?post=' . absint( $post->ID ) . '&action=edit' ) . '"><strong>' . sprintf( __( '%s', 'woocommerce' ), esc_attr( $the_order->get_order_number() ) ) . '</strong></a> ';
	        break;

	        case 'linen_phone_number':
	        	if ( $the_order->billing_phone )
        			echo esc_html( $the_order->billing_phone );
	        break;

	        case 'linen_payment_option':
	        	if ( $the_order->payment_method_title )
        			echo esc_html( $the_order->payment_method_title );
	        break;

	        case 'linen_shipping_option':
	        	if ( $the_order->get_shipping_method() )
        			echo esc_html( $the_order->get_shipping_method() );
	        break;
	        
			case 'linen_order_total':
				echo $the_order->get_formatted_order_total();
			break;
			

		}
	}

	/**
	 * Callback for drag/drop sorting. This saves the new order and replies with a javascript
	 * object which tells the JS function where to place the moved element (like place the moved element BEFORE the related element)
	 * @return void
	 */
	function ajax_cols_order() {
		if( !empty( $_POST['items'] ) ) {
			
      $existing = get_option( '_linen_cols_order' );
      update_option( '_linen_cols_order', $_POST['items'] );

			# Determine which element is related to the new place of the changed element
			$destination_index = array_search( $_POST['item_name'], $_POST['items'] );

			if( $destination_index === false ) {
				die('0');
			}

			$obj = new stdClass;
			$obj->related_element = '';
			$obj->action = '';

			if( $destination_index == 0 ) {
				$obj->related_element = $existing[ $destination_index ];
				$obj->action = 'before';
			} else {
				$obj->related_element = $existing[ $destination_index - 1 ];
				$obj->action = 'after'; // place the element AFTER the related element
			}

			$obj->item_name = $_POST['item_name'];

			echo json_encode( $obj );
		} else {
			echo '0';
		}
		die();
	}

	/**
	 * Sorts the columns according to the user's submitted order
	 * @param  [array] $columns [columns slugs]
	 * @return [array] sorted columns
	 */
	function sort_cols_according_to_order( $columns ) {

		$ordered_list = get_option( '_linen_cols_order' );
		if( empty( $ordered_list ) ) {
			update_option( '_linen_cols_order', array_keys( $columns ) );
			return $columns;
		}
		$cols = array();
		
		if( isset($columns[ 'cb' ]) )
			$cols[ 'cb' ] = $columns[ 'cb' ];
		
		foreach( $ordered_list as $index => $slug ) {
			if($slug != 'cb'){
				if(isset($columns[ $slug ]))
					$cols[ $slug ] = $columns[ $slug ];
			}
			unset($columns[ $slug ]);
		}
		if(!empty($columns)){
			$cols = $cols + $columns;
		}
		return $cols;
	}

	/**
	 * Unticks and hides the custom columns when the user is logged in the first time
	 * @return void
	 */
	function untick_custom_cols() {
		$custom_columns = array( 'linen_order_total', 'total_discount', 'cart_discount', 'order_discount', 'customer_ip', 'linen_customer_name', 'shipping_costs', 'order_text_status', 'linen_email', 'linen_order_number', 'linen_phone_number', 'linen_payment_option', 'linen_shipping_option' );
		?>
		<script type="text/javascript">
		jQuery(document).ready(function(){
			linen_slugs = <?php echo json_encode( $custom_columns ); ?>;
			for( s in linen_slugs ) {
				jQuery('#'+linen_slugs[s]+'-hide').removeAttr('checked');
				jQuery('.column-'+linen_slugs[s]).hide();
				columns.saveManageColumnsState();
			}
		});
		</script>
		<?php
	}

	/**
	 * Loads the custom colors from the database if the custom status actions plugin is activated
	 * @param  array $colors array of colors key = status slug and value is color hex code
	 * @return void         
	 */
	function load_custom_colors( &$colors ) {
		
		global $wpdb;

        $table_name = $wpdb->prefix . "woocommerce_order_status_action";
        $query = "SELECT status_name,status_color FROM $table_name";
        $results = $wpdb->get_results($query,ARRAY_A);
        
        foreach($results as $result){
            $colors[$result['status_name']] = $result['status_color'];
        }
	}

	/**
	 * Echoes the variable to debug.txt used for debugging purposes
	 * @param  [mixed] $var [which variable to write to debug.txt]
	 * @return void
	 */
	function debug( $var ) {
		file_put_contents( plugin_dir_path(__FILE__) . '/debug.txt', '#######################################################' . PHP_EOL, FILE_APPEND );
		file_put_contents( plugin_dir_path(__FILE__) . '/debug.txt', var_export($var, true) . PHP_EOL, FILE_APPEND );
	}

}

/**
 * Initializes the plugin
 * @return class object
 */
function WCOC()
{
	return WooOrderCustomiser::instance();
}

add_action( 'plugins_loaded', 'WCOC', 9999 );

?>