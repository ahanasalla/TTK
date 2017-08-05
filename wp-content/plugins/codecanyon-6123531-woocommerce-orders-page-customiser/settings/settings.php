<?php

if ( !class_exists('WooOrderCustomiser_Settings ') ):

/**
 * 
 * @version 1.0
 * @access public
 */
class WooOrderCustomiser_Settings {

  public static function init() {

    add_filter( 'woocommerce_settings_tabs_array', __CLASS__ . '::add_settings_tab', 70);
    add_action( 'woocommerce_settings_tabs_settings_orders_page', __CLASS__ . '::settings_tab' );
    add_action( 'woocommerce_update_options_settings_orders_page', __CLASS__ . '::update_settings' );

    add_action( 'woocommerce_admin_field_order_page_table_width', __CLASS__ . '::order_page_table_width' );
    add_action( 'woocommerce_admin_field_order_page_columns', __CLASS__ . '::order_page_columns' );
    add_action( 'woocommerce_admin_field_linen_order_cols_li', __CLASS__ . '::linen_order_cols_li' );

    add_action( 'woocommerce_update_option_order_page_table_width', __CLASS__ . '::save_order_page_table_width' );
    
  }

  /**
  * Add a new settings tab to the WooCommerce settings tabs array.
  */
  public static function add_settings_tab( $settings_tabs ) {
    $settings_tabs['settings_orders_page'] = __( 'Orders Page', 'linen' );
    return $settings_tabs;
  }
  /**
  * Uses the WooCommerce admin fields API to output settings via the @see woocommerce_admin_fields() function.
  *
  * @uses woocommerce_admin_fields()
  * @uses self::get_settings()
  */
  public static function settings_tab() {
    woocommerce_admin_fields( self::get_settings() );
  }

  function get_all_columns($cb = true)
  {
    $columns = apply_filters( "manage_shop_order_posts_columns", array('cb' => '<label class="screen-reader-text" for="cb-select-all-1">Select All</label><input id="cb-select-all-1" type="checkbox">') );
    $columns = apply_filters( "manage_shop_order_posts_columns", $columns );
    $columns = apply_filters( "manage_edit-shop_order_columns", $columns );
    $columns = apply_filters( "manage_edit-shop_order_columns", $columns );
    
    if(!$cb)
      $columns['cb'] = __('Checkbox: Select all');

    $columns = $columns + WCOC()->get_extra_columns();
    return $columns;
  }
  function get_default_columns($cb = true)
  {
    $columns = apply_filters( "manage_shop_order_posts_columns", array('cb' => '<label class="screen-reader-text" for="cb-select-all-1">Select All</label><input id="cb-select-all-1" type="checkbox">') );
    $columns = apply_filters( "manage_shop_order_posts_columns", $columns );
    $columns = apply_filters( "manage_edit-shop_order_columns", $columns );
    $columns = apply_filters( "manage_edit-shop_order_columns", $columns );
    
    if(!$cb)
      $columns['cb'] = __('Checkbox: Select all');
    return $columns;
  }
  
  /**
  * Get all the settings for this plugin for @see woocommerce_admin_fields() function.
  *
  * @return array Array of settings for @see woocommerce_admin_fields() function.
  */
  public static function get_settings() {

    $column_headers = self::get_all_columns();
    $settings[] = array( 'title' => __( 'Orders Page', 'linen' ), 'type' => 'title', 'desc' => '', 'id' => 'wc_order_customiser_orders_page' );

    $settings[] = array(
        'title'    => __( 'Sort By', 'linen' ),
        'id'       => 'wc_order_customiser_column_sort_by',
        'type'     => 'multiselect',
        'class'    => 'chosen_select',
        'options'  => array(
          'ID'             => __( 'Order No.', 'linen' ),
          'total'          => __( 'Total', 'linen' ),
          'total_discount' => __( 'Total discount', 'linen' ),
          'cart_discount'  => __( 'Cart discount', 'linen' ),
          'order_discount' => __( 'Order discount', 'linen' ),
          'shipping_costs' => __( 'Shipping costs', 'linen' ),
          )
      );
    $settings[] = array(
        'title'    => __( 'Columns', 'linen' ),
        'id'       => 'wc_order_customiser_available_columns',
        'type'     => 'multiselect',
        'class'    => 'chosen_select',
        'default'  => array_keys( self::get_default_columns(false) ),
        'options'  => self::get_all_columns(false)
      );

    $settings[] = array(
      'title'    => __( 'Table Type', 'linen' ),
      'id'       => 'wc_order_customiser_table_type',
      'default'  => 'static',
      'type'     => 'radio',
      'options'  => array(
        'static'  => __( 'Static', 'linen' ),
        'dynamic' => __( 'Dynamic', 'linen' ),
      ),
      'autoload' => true
    );
    $settings[] = array(
        'title'    => __( 'Input Method', 'linen' ),
        'id'       => 'wc_order_customiser_column_width_input_method',
        'default'  => 'draggable',
        'type'     => 'select',
        'options'  => array(
          'draggable'      => __( 'Draggable', 'linen' ),
          'defined_values' => __( 'Defined Values', 'linen' ),
          )
      );
    $settings[] = array(
        'title'    => __( 'Table width', 'linen' ),
        'id'       => 'wc_order_customiser_table_width',
        'default'  => count($column_headers)*150,
        'type'     => 'order_page_table_width',
      );
    $settings[] = array( 'type' => 'sectionend', 'id' => 'wc_order_customiser_orders_page' );

    /*****************************/

    $settings[] = array( 'title' => __( 'Position & Size', 'linen' ), 'type' => 'title', 'desc' => '', 'id' => 'wc_order_customiser_position_n_size' );

    $settings[] = array( 'type' => 'linen_order_cols_li' );

    $settings[] = array( 'type' => 'order_page_columns' );

    $settings[] = array( 'type' => 'sectionend', 'id' => 'wc_order_customiser_position_n_size' );

    return apply_filters( 'wc_settings_tab_orders_page', $settings );
  }
  function order_page_table_width($val){
    $val['value'] = get_option( $val['id'], '' );
    
    ?>
    <table class="form-table" id="table_<?php echo $val['id']; ?>">
      <tbody>
        <tr valign="top">
          <th class="titledesc" scope="row">
              <label for="<?php echo $val['id']; ?>"><?php echo $val['title']; ?></label>
          </th>
          <td class="forminp">
            <input type="number" id="<?php echo $val['id']; ?>" style="width: 80px;" value="<?php echo $val['value'] ? $val['value'] : $val['default']; ?>" name="<?php echo $val['id']; ?>">
            <?php _e( 'pixels', 'linen' ); ?>
          </td>
        </tr>
      </tbody>
    </table>
    <?php
  }
  function linen_order_cols_li(){
    $column_headers = self::get_all_columns();

    $hidden_columns = (array) get_user_option( 'manageedit-shop_ordercolumnshidden' );

    $cols = get_option( 'wc_order_customiser_available_columns');

    $available_columns = (array) ($cols ? $cols : array_keys( self::get_default_columns(false) ) );

    wp_nonce_field( 'screen-options-nonce', 'screenoptionnonce', false );
    $output = '<ul class="linen_sortable">';
    foreach( $column_headers as $slug => $label ) {

      # If the user sets a custom width, call the linen_set_col_width js function found in assets/custom.js
      $value = '';
      
      if($slug =='wc_order_rules_color' || $slug =='cb') continue;
      if( !in_array($slug, $available_columns) ) continue;
      if(empty($label))
        $label = str_replace('_', ' ', $slug);
      $output .= '<li name="' . $slug . '" class="linen_order_cols_li '.(in_array($slug, $hidden_columns) ? 'inactive' : '').'"><label>'. $label .' </label></li>';
    }
    $output .= '</ul>';
    echo $output;
  }

  /**
  *
  * @return table with all order page columns
  */
  function order_page_columns(){

    $column_headers    = self::get_all_columns();

    $cols = get_option( 'wc_order_customiser_available_columns');

    $available_columns = (array) ($cols ? $cols : array_keys( self::get_default_columns(false) ) );

    $cols_width_percent = get_option( '_linen_cols_width_percent');
    $cols_width_pixels  = get_option( '_linen_cols_width_pixels');


    $table_type   = get_option('wc_order_customiser_table_type') ?get_option('wc_order_customiser_table_type') : 'static';
    $input_method = get_option('wc_order_customiser_column_width_input_method') ? get_option('wc_order_customiser_column_width_input_method') : 'draggable';

    
    $width = array();
    if($table_type == 'static' && $input_method == 'defined_values'){
      $width = $cols_width_pixels;
      if( !is_array($width) ){
        $width = array();
      }
      $tw = array_sum($width) + (count($width)*20) . 'px';
      $px = 'px';
    }else {
      $tw = '';
      $width = $cols_width_percent;
      $px = '%';
    }
    ?>
    <tr valign="top">
      <td class="forminp" colspan="2" style="padding: 0;">
        <table cellspacing="0" id="wc_order_page_columns" class="wp-list-table widefat fixed resizablecolumns" style="width: <?php echo $tw; ?>">
          <thead>
            <tr>
              <?php
                foreach ( $column_headers as $column_key => $column_display_name ) {
                  if($column_key =='wc_order_rules_color') continue;
                  if( !in_array($column_key, $available_columns) ) continue;

                  $class = array( 'manage-column', "column-$column_key" );

                  if ( 'cb' == $column_key )
                    $class[] = 'check-column';
                  $id = "id='$column_key'";
                  $style = '';
                  
                  if ( isset($width[$column_key]) ) {
                    $style = "style=' width: ".$width[$column_key].$px."; '";
                  }
                  $class = "class='" . join( ' ', $class ) . "'";
                  echo "<th scope='col' $id $class $style >$column_display_name</th>";
                }
              ?>
            </tr>
            
          </thead>
          <tbody>
            <tr class="static_defined_values">
              <?php
                foreach ( $column_headers as $column_key => $column_display_name ) {
                  if($column_key =='wc_order_rules_color') continue;
                  if( !in_array($column_key, $available_columns) ) continue;
                  $class = array( 'manage-column', "column-$column_key" );
                  $class = "class='" . join( ' ', $class ) . "'";
                  $value = isset($cols_width_pixels[$column_key]) ? $cols_width_pixels[$column_key] : '100';
                  echo "<td scope='col' $class ><input type='number' step='1' min='0' data-headid='$column_key'  value='$value' name='cols_width_pixels[$column_key]'> px</td>";
                }
              ?>
            </tr>
            <tr class="dynamic_defined_values">
              <?php
                foreach ( $column_headers as $column_key => $column_display_name ) {
                  if($column_key =='wc_order_rules_color') continue;
                  if( !in_array($column_key, $available_columns) ) continue;
                  $class = array( 'manage-column', "column-$column_key" );
                  $class = "class='" . join( ' ', $class ) . "'";
                  $value = isset($cols_width_percent[$column_key]) ? $cols_width_percent[$column_key] : '5';
                  echo "<td scope='col' $class ><input type='number' step='0.01' min='0' data-headid='$column_key' value='$value' name='cols_width_percent[$column_key]'> %</td>";
                }
              ?>
            </tr>
            <tr>
              <?php
              global $wpdb;
                $id = $wpdb->get_var("SELECT ID FROM {$wpdb->posts} WHERE post_type='shop_order' AND post_status!='trash' ORDER BY ID DESC LIMIT 1");
                global $post;
                $post = get_post($id);
                foreach ( $column_headers as $column_name => $column_display_name ) {
                  if($column_name =='wc_order_rules_color') continue;
                  if( !in_array($column_name, $available_columns) ) continue;
                  $attributes = "class=\"$column_name column-$column_name\"";

                  ?>
                  <td <?php echo $attributes ?>>
                    <?php
                    do_action( "manage_shop_order_posts_custom_column", $column_name, $id );
                    ?>
                  </td>
                  <?php
                }
              ?>
            </tr>
          </tbody>
        </table>
        
      </td>
    </tr>
    <?php
  }

  function save_order_page_table_width($value){
    
    if(isset($_POST['cols_width_pixels']))
      update_option( '_linen_cols_width_pixels', $_POST['cols_width_pixels'] );

    if(isset($_POST['cols_width_percent']))
      update_option( '_linen_cols_width_percent', $_POST['cols_width_percent'] );

    $val = get_option( $value['id'], '' );
    update_option( $value['id'], $val );
  }


  /**
  * Uses the WooCommerce options API to save settings via the @see woocommerce_update_options() function.
  *
  * @uses woocommerce_update_options()
  * @uses self::get_settings()
  */
  public static function update_settings() {
    woocommerce_update_options( self::get_settings() );
  }

	
}
WooOrderCustomiser_Settings::init();
endif;
?>