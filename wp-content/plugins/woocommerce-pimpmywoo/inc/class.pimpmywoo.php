<?php
if ( ! class_exists( 'PimpMyWoo' ) ) {
	class PimpMyWoo {
		protected $plugin_tag = 'pimpmywoo';
		protected $plugin_folder = 'woocommerce-pimpmywoo';
		protected $plugin_base = 'woocommerce-pimpmywoo/pimpmywoo.php';
		protected $plugin_id = '14344102';
		protected $plugin_name = 'PimpMyWoo';
		protected $plugin_version = '1.1.0';	
	    public function __construct() {
		    add_action('admin_init', array( &$this, 'options_update'));
			add_filter('plugin_row_meta',  array( &$this, 'register_plugin_links'), 10, 2);
			add_filter('plugin_action_links_' . $this->plugin_base, array( &$this, 'register_plugin_links_actions') );
			add_action('admin_menu', array( &$this, 'register_settings_page'));
			add_action( 'plugins_loaded', array( &$this, 'load_textdomain') );
			$options = get_option($this->plugin_tag);
			$status = isset($options['status'])?$options['status']:"unknown";
			if ($status != 'valid') {
				add_action( 'admin_notices', array( &$this, 'no_license') ); 
			}
			include_once( 'class.customizer.php' );
	    }
		public function register_plugin_links ($links, $file) {
			$base = plugin_basename(__FILE__);
			$base = $this->plugin_base;
			if ($file == $base) {
				$links[] = '<a href="https://web.facebook.com/scglobal.com.au/">' . 'SCGC\'s Facebook Page' . '</a>';
			}
			return $links;
		}
		public function register_plugin_links_actions ( $links ) {
			if ( array_key_exists( 'edit', $links ) )
				unset( $links['edit'] );
			array_unshift($links, '<a href="' . admin_url( '/customize.php' ) . '">' . __( 'Customize') . '</a>');
			array_unshift($links, '<a href="' . admin_url( '/admin.php?page=' ) .$this->plugin_tag. '">' . __( 'Settings') . '</a>');
			return $links;
		}
		public function register_settings_page() {
		    add_submenu_page( 'woocommerce', 'PimpMyWoo Settings', 'PimpMyWoo', 'manage_options', $this->plugin_tag, array( &$this, 'register_settings_page_callback') ); 
		}
		
		public function register_settings_page_callback() {
			include_once( plugin_dir_path(__FILE__).'../partials/settings-page.php' );
		}
		public function validate($input) {
			$valid = array();
			$license = preg_replace('/[^\w-]/', '', !empty($input['license'])?$input['license']:"");
			
			$o = PimpMyWooV::verifyPurchase( $license, $this->plugin_id );
			
			//if (!empty($o->item_id) && $o->item_id == $this->plugin_id) {
			if (!empty($o->item_id)) {
				$status = 'valid';
				$buyer = $o->buyer;
			} else {
				$status = 'invalid';
				$buyer = 'unknown';
			}
			if (isset($input['rollback'])) {
				remove_theme_mod( 'btn_list_bg');
				remove_theme_mod( 'btn_list_bg_hover');
				remove_theme_mod( 'btn_list_color');
				remove_theme_mod( 'btn_list_color_hover');
				remove_theme_mod( 'btn_list_border_width');
				remove_theme_mod( 'btn_list_border_color');
				remove_theme_mod( 'btn_list_border_color_hover');
				remove_theme_mod( 'btn_list_border_style');
				remove_theme_mod( 'btn_list_border_radius');
				remove_theme_mod( 'btn_list_font');
				remove_theme_mod( 'btn_list_font_latin');
				remove_theme_mod( 'btn_list_font_latinext');
				remove_theme_mod( 'btn_list_font_greek');
				remove_theme_mod( 'btn_list_font_greekext');
				remove_theme_mod( 'btn_list_font_vietnamese');
				remove_theme_mod( 'btn_list_font_cyrillic');
				remove_theme_mod( 'btn_list_font_cyrillicext');
				remove_theme_mod( 'btn_list_font_size');
				remove_theme_mod( 'btn_list_font_weight');
				remove_theme_mod( 'btn_list_font_style');
				remove_theme_mod( 'btn_list_text_transform');
				remove_theme_mod( 'btn_list_line_height');
				remove_theme_mod( 'btn_list_letter_spacing');
				remove_theme_mod( 'title_list_font');
				remove_theme_mod( 'title_list_font_latin');
				remove_theme_mod( 'title_list_font_latinext');
				remove_theme_mod( 'title_list_font_greek');
				remove_theme_mod( 'title_list_font_greekext');
				remove_theme_mod( 'title_list_font_vietnamese');
				remove_theme_mod( 'title_list_font_cyrillic');
				remove_theme_mod( 'title_list_font_cyrillicext');
				remove_theme_mod( 'title_list_color');
				remove_theme_mod( 'title_list_color_hover');
				remove_theme_mod( 'title_list_font_size');
				remove_theme_mod( 'title_list_font_weight');
				remove_theme_mod( 'title_list_font_style');
				remove_theme_mod( 'title_list_text_transform');
				remove_theme_mod( 'title_list_line_height');
				remove_theme_mod( 'title_list_letter_spacing');
				remove_theme_mod( 'price_list_font');
				remove_theme_mod( 'price_list_font_latin');
				remove_theme_mod( 'price_list_font_latinext');
				remove_theme_mod( 'price_list_font_greek');
				remove_theme_mod( 'price_list_font_greekext');
				remove_theme_mod( 'price_list_font_vietnamese');
				remove_theme_mod( 'price_list_font_cyrillic');
				remove_theme_mod( 'price_list_font_cyrillicext');
				remove_theme_mod( 'price_list_color');
				remove_theme_mod( 'price_list_color_hover');
				remove_theme_mod( 'price_list_font_size');
				remove_theme_mod( 'price_list_font_weight');
				remove_theme_mod( 'price_list_font_style');
				remove_theme_mod( 'price_list_text_transform');
				remove_theme_mod( 'price_list_line_height');
				remove_theme_mod( 'price_list_letter_spacing');
				remove_theme_mod( 'img_list_border_width');
				remove_theme_mod( 'img_list_border_color');
				remove_theme_mod( 'img_list_border_color_hover');
				remove_theme_mod( 'img_list_border_style');
				remove_theme_mod( 'img_list_border_radius');
				remove_theme_mod( 'sbadge_list_bg');
				remove_theme_mod( 'sbadge_list_bg_hover');
				remove_theme_mod( 'sbadge_list_color');
				remove_theme_mod( 'sbadge_list_color_hover');
				remove_theme_mod( 'sbadge_list_border_width');
				remove_theme_mod( 'sbadge_list_border_color');
				remove_theme_mod( 'sbadge_list_border_color_hover');
				remove_theme_mod( 'sbadge_list_border_style');
				remove_theme_mod( 'sbadge_list_border_radius');
				remove_theme_mod( 'sbadge_list_font');
				remove_theme_mod( 'sbadge_list_font_latin');
				remove_theme_mod( 'sbadge_list_font_latinext');
				remove_theme_mod( 'sbadge_list_font_greek');
				remove_theme_mod( 'sbadge_list_font_greekext');
				remove_theme_mod( 'sbadge_list_font_vietnamese');
				remove_theme_mod( 'sbadge_list_font_cyrillic');
				remove_theme_mod( 'sbadge_list_font_cyrillicext');
				remove_theme_mod( 'sbadge_list_font_size');
				remove_theme_mod( 'sbadge_list_font_weight');
				remove_theme_mod( 'sbadge_list_font_style');
				remove_theme_mod( 'sbadge_list_text_transform');
				remove_theme_mod( 'sbadge_list_line_height');
				remove_theme_mod( 'sbadge_list_letter_spacing');
				remove_theme_mod( 'sbadge_list_padding');
				remove_theme_mod( 'btn_single_bg');
				remove_theme_mod( 'btn_single_bg_hover');
				remove_theme_mod( 'btn_single_color');
				remove_theme_mod( 'btn_single_color_hover');
				remove_theme_mod( 'btn_single_border_width');
				remove_theme_mod( 'btn_single_border_color');
				remove_theme_mod( 'btn_single_border_color_hover');
				remove_theme_mod( 'btn_single_border_style');
				remove_theme_mod( 'btn_single_border_radius');
				remove_theme_mod( 'btn_single_font');
				remove_theme_mod( 'btn_single_font_latin');
				remove_theme_mod( 'btn_single_font_latinext');
				remove_theme_mod( 'btn_single_font_greek');
				remove_theme_mod( 'btn_single_font_greekext');
				remove_theme_mod( 'btn_single_font_vietnamese');
				remove_theme_mod( 'btn_single_font_cyrillic');
				remove_theme_mod( 'btn_single_font_cyrillicext');
				remove_theme_mod( 'btn_single_font_size');
				remove_theme_mod( 'btn_single_font_weight');
				remove_theme_mod( 'btn_single_font_style');
				remove_theme_mod( 'btn_single_text_transform');
				remove_theme_mod( 'btn_single_line_height');
				remove_theme_mod( 'btn_single_letter_spacing');
				remove_theme_mod( 'title_single_font');
				remove_theme_mod( 'title_single_font_latin');
				remove_theme_mod( 'title_single_font_latinext');
				remove_theme_mod( 'title_single_font_greek');
				remove_theme_mod( 'title_single_font_greekext');
				remove_theme_mod( 'title_single_font_vietnamese');
				remove_theme_mod( 'title_single_font_cyrillic');
				remove_theme_mod( 'title_single_font_cyrillicext');
				remove_theme_mod( 'title_single_color');
				remove_theme_mod( 'title_single_font_size');
				remove_theme_mod( 'title_single_font_weight');
				remove_theme_mod( 'title_single_font_style');
				remove_theme_mod( 'title_single_text_transform');
				remove_theme_mod( 'title_single_line_height');
				remove_theme_mod( 'title_single_letter_spacing');
				remove_theme_mod( 'price_single_font');
				remove_theme_mod( 'price_single_font_latin');
				remove_theme_mod( 'price_single_font_latinext');
				remove_theme_mod( 'price_single_font_greek');
				remove_theme_mod( 'price_single_font_greekext');
				remove_theme_mod( 'price_single_font_vietnamese');
				remove_theme_mod( 'price_single_font_cyrillic');
				remove_theme_mod( 'price_single_font_cyrillicext');
				remove_theme_mod( 'price_single_color');
				remove_theme_mod( 'price_single_font_size');
				remove_theme_mod( 'price_single_font_weight');
				remove_theme_mod( 'price_single_font_style');
				remove_theme_mod( 'price_single_text_transform');
				remove_theme_mod( 'price_single_line_height');
				remove_theme_mod( 'price_single_letter_spacing');
				remove_theme_mod( 'img_single_border_width');
				remove_theme_mod( 'img_single_border_color');
				remove_theme_mod( 'img_single_border_color_hover');
				remove_theme_mod( 'img_single_border_style');
				remove_theme_mod( 'img_single_border_radius');
				remove_theme_mod( 'sbadge_single_bg');
				remove_theme_mod( 'sbadge_single_color');
				remove_theme_mod( 'sbadge_single_border_width');
				remove_theme_mod( 'sbadge_single_border_color');
				remove_theme_mod( 'sbadge_single_border_style');
				remove_theme_mod( 'sbadge_single_border_radius');
				remove_theme_mod( 'sbadge_single_font');
				remove_theme_mod( 'sbadge_single_font_latin');
				remove_theme_mod( 'sbadge_single_font_latinext');
				remove_theme_mod( 'sbadge_single_font_greek');
				remove_theme_mod( 'sbadge_single_font_greekext');
				remove_theme_mod( 'sbadge_single_font_vietnamese');
				remove_theme_mod( 'sbadge_single_font_cyrillic');
				remove_theme_mod( 'sbadge_single_font_cyrillicext');
				remove_theme_mod( 'sbadge_single_font_size');
				remove_theme_mod( 'sbadge_single_font_weight');
				remove_theme_mod( 'sbadge_single_font_style');
				remove_theme_mod( 'sbadge_single_text_transform');
				remove_theme_mod( 'sbadge_single_line_height');
				remove_theme_mod( 'sbadge_single_letter_spacing');
				remove_theme_mod( 'sbadge_single_padding');
				remove_theme_mod( 'title_sidebar_font');
				remove_theme_mod( 'title_sidebar_font_latin');
				remove_theme_mod( 'title_sidebar_font_latinext');
				remove_theme_mod( 'title_sidebar_font_greek');
				remove_theme_mod( 'title_sidebar_font_greekext');
				remove_theme_mod( 'title_sidebar_font_vietnamese');
				remove_theme_mod( 'title_sidebar_font_cyrillic');
				remove_theme_mod( 'title_sidebar_font_cyrillicext');
				remove_theme_mod( 'title_sidebar_color');
				remove_theme_mod( 'title_sidebar_color_hover');
				remove_theme_mod( 'title_sidebar_font_size');
				remove_theme_mod( 'title_sidebar_font_weight');
				remove_theme_mod( 'title_sidebar_font_style');
				remove_theme_mod( 'title_sidebar_text_transform');
				remove_theme_mod( 'title_sidebar_line_height');
				remove_theme_mod( 'title_sidebar_letter_spacing');
				remove_theme_mod( 'price_sidebar_font');
				remove_theme_mod( 'price_sidebar_font_latin');
				remove_theme_mod( 'price_sidebar_font_latinext');
				remove_theme_mod( 'price_sidebar_font_greek');
				remove_theme_mod( 'price_sidebar_font_greekext');
				remove_theme_mod( 'price_sidebar_font_vietnamese');
				remove_theme_mod( 'price_sidebar_font_cyrillic');
				remove_theme_mod( 'price_sidebar_font_cyrillicext');
				remove_theme_mod( 'price_sidebar_color');
				remove_theme_mod( 'price_sidebar_font_size');
				remove_theme_mod( 'price_sidebar_font_weight');
				remove_theme_mod( 'price_sidebar_font_style');
				remove_theme_mod( 'price_sidebar_text_transform');
				remove_theme_mod( 'price_sidebar_line_height');
				remove_theme_mod( 'price_sidebar_letter_spacing');
				remove_theme_mod( 'img_sidebar_border_width');
				remove_theme_mod( 'img_sidebar_border_color');
				remove_theme_mod( 'img_sidebar_border_color_hover');
				remove_theme_mod( 'img_sidebar_border_style');
				remove_theme_mod( 'img_sidebar_border_radius');

				remove_theme_mod( 'btn_cart_bg');
				remove_theme_mod( 'btn_cart_bg_hover');
				remove_theme_mod( 'btn_cart_color');
				remove_theme_mod( 'btn_cart_color_hover');
				remove_theme_mod( 'btn_cart_border_width');
				remove_theme_mod( 'btn_cart_border_color');
				remove_theme_mod( 'btn_cart_border_color_hover');
				remove_theme_mod( 'btn_cart_border_style');
				remove_theme_mod( 'btn_cart_border_radius');
				remove_theme_mod( 'btn_cart_font');
				remove_theme_mod( 'btn_cart_font_latin');
				remove_theme_mod( 'btn_cart_font_latinext');
				remove_theme_mod( 'btn_cart_font_greek');
				remove_theme_mod( 'btn_cart_font_greekext');
				remove_theme_mod( 'btn_cart_font_vietnamese');
				remove_theme_mod( 'btn_cart_font_cyrillic');
				remove_theme_mod( 'btn_cart_font_cyrillicext');
				remove_theme_mod( 'btn_cart_font_size');
				remove_theme_mod( 'btn_cart_font_weight');
				remove_theme_mod( 'btn_cart_font_style');
				remove_theme_mod( 'btn_cart_text_transform');
				remove_theme_mod( 'btn_cart_line_height');
				remove_theme_mod( 'btn_cart_letter_spacing');
				remove_theme_mod( 'btnC_cart_bg');
				remove_theme_mod( 'btnC_cart_bg_hover');
				remove_theme_mod( 'btnC_cart_color');
				remove_theme_mod( 'btnC_cart_color_hover');
				remove_theme_mod( 'btnC_cart_border_width');
				remove_theme_mod( 'btnC_cart_border_color');
				remove_theme_mod( 'btnC_cart_border_color_hover');
				remove_theme_mod( 'btnC_cart_border_style');
				remove_theme_mod( 'btnC_cart_border_radius');
				remove_theme_mod( 'btnC_cart_font');
				remove_theme_mod( 'btnC_cart_font_latin');
				remove_theme_mod( 'btnC_cart_font_latinext');
				remove_theme_mod( 'btnC_cart_font_greek');
				remove_theme_mod( 'btnC_cart_font_greekext');
				remove_theme_mod( 'btnC_cart_font_vietnamese');
				remove_theme_mod( 'btnC_cart_font_cyrillic');
				remove_theme_mod( 'btnC_cart_font_cyrillicext');
				remove_theme_mod( 'btnC_cart_font_size');
				remove_theme_mod( 'btnC_cart_font_weight');
				remove_theme_mod( 'btnC_cart_font_style');
				remove_theme_mod( 'btnC_cart_text_transform');
				remove_theme_mod( 'btnC_cart_line_height');
				remove_theme_mod( 'btnC_cart_letter_spacing');
				remove_theme_mod( 'btnX_cart_bg');
				remove_theme_mod( 'btnX_cart_bg_hover');
				remove_theme_mod( 'btnX_cart_color');
				remove_theme_mod( 'btnX_cart_color_hover');
				remove_theme_mod( 'btnX_cart_border_width');
				remove_theme_mod( 'btnX_cart_border_color');
				remove_theme_mod( 'btnX_cart_border_color_hover');
				remove_theme_mod( 'btnX_cart_border_style');
				remove_theme_mod( 'btnX_cart_border_radius');
				remove_theme_mod( 'btnX_cart_font');
				remove_theme_mod( 'btnX_cart_font_latin');
				remove_theme_mod( 'btnX_cart_font_latinext');
				remove_theme_mod( 'btnX_cart_font_greek');
				remove_theme_mod( 'btnX_cart_font_greekext');
				remove_theme_mod( 'btnX_cart_font_vietnamese');
				remove_theme_mod( 'btnX_cart_font_cyrillic');
				remove_theme_mod( 'btnX_cart_font_cyrillicext');
				remove_theme_mod( 'btnX_cart_font_size');
				remove_theme_mod( 'btnX_cart_font_weight');
				remove_theme_mod( 'btnX_cart_font_style');
				remove_theme_mod( 'btnX_cart_text_transform');
				remove_theme_mod( 'btnX_cart_line_height');
				remove_theme_mod( 'btnX_cart_letter_spacing');
				remove_theme_mod( 'title_cart_font');
				remove_theme_mod( 'title_cart_font_latin');
				remove_theme_mod( 'title_cart_font_latinext');
				remove_theme_mod( 'title_cart_font_greek');
				remove_theme_mod( 'title_cart_font_greekext');
				remove_theme_mod( 'title_cart_font_vietnamese');
				remove_theme_mod( 'title_cart_font_cyrillic');
				remove_theme_mod( 'title_cart_font_cyrillicext');
				remove_theme_mod( 'title_cart_color');
				remove_theme_mod( 'title_cart_color_hover');
				remove_theme_mod( 'title_cart_font_size');
				remove_theme_mod( 'title_cart_font_weight');
				remove_theme_mod( 'title_cart_font_style');
				remove_theme_mod( 'title_cart_text_transform');
				remove_theme_mod( 'title_cart_line_height');
				remove_theme_mod( 'title_cart_letter_spacing');
				remove_theme_mod( 'price_cart_font');
				remove_theme_mod( 'price_cart_font_latin');
				remove_theme_mod( 'price_cart_font_latinext');
				remove_theme_mod( 'price_cart_font_greek');
				remove_theme_mod( 'price_cart_font_greekext');
				remove_theme_mod( 'price_cart_font_vietnamese');
				remove_theme_mod( 'price_cart_font_cyrillic');
				remove_theme_mod( 'price_cart_font_cyrillicext');
				remove_theme_mod( 'price_cart_color');
				remove_theme_mod( 'price_cart_font_size');
				remove_theme_mod( 'price_cart_font_weight');
				remove_theme_mod( 'price_cart_font_style');
				remove_theme_mod( 'price_cart_text_transform');
				remove_theme_mod( 'price_cart_line_height');
				remove_theme_mod( 'price_cart_letter_spacing');
				remove_theme_mod( 'img_cart_border_width');
				remove_theme_mod( 'img_cart_border_color');
				remove_theme_mod( 'img_cart_border_color_hover');
				remove_theme_mod( 'img_cart_border_style');
				remove_theme_mod( 'img_cart_border_radius');
				remove_theme_mod( 'table_cart_bg');
				remove_theme_mod( 'table_cart_border_width');
				remove_theme_mod( 'table_cart_border_color');
				remove_theme_mod( 'table_cart_border_style');
				remove_theme_mod( 'table_cart_border_radius');
				remove_theme_mod( 'table_font_cart_color');
				remove_theme_mod( 'table_font_cart_font');
				remove_theme_mod( 'table_font_cart_font_latin');
				remove_theme_mod( 'table_font_cart_font_latinext');
				remove_theme_mod( 'table_font_cart_font_greek');
				remove_theme_mod( 'table_font_cart_font_greekext');
				remove_theme_mod( 'table_font_cart_font_vietnamese');
				remove_theme_mod( 'table_font_cart_font_cyrillic');
				remove_theme_mod( 'table_font_cart_font_cyrillicext');
				remove_theme_mod( 'table_font_cart_font_size');
				remove_theme_mod( 'table_font_cart_font_weight');
				remove_theme_mod( 'table_font_cart_font_style');
				remove_theme_mod( 'table_font_cart_text_transform');
				remove_theme_mod( 'table_font_cart_line_height');
				remove_theme_mod( 'table_font_cart_letter_spacing');



			}
			$valid['license'] = $license;			
			$valid['status'] = $status;			
			$valid['buyer'] = $buyer;			
			$valid['rollback'] = 0;			
			return $valid;
		}
		
		public function options_update() {
			register_setting($this->plugin_tag, $this->plugin_tag, array($this, 'validate'));
			
		}
		function load_textdomain() {
			load_plugin_textdomain( $this->plugin_tag, false, $this->plugin_folder . '/languages' ); 
		}
		function no_license() {
			$class = "error";
			$message = '<strong>'.__('PimpMyWoo is not activated!', $this->plugin_tag).'</strong> <a href="' . admin_url( '/admin.php?page=' ) .$this->plugin_tag. '">'.__('Click here to activate PimpMyWoo and get future updates notifications!', $this->plugin_tag).'</a>';
		        echo"<div class=\"$class\"> <p>$message</p></div>"; 
		}		
	}
}
if ( ! class_exists( 'PimpMyWooV' ) ) {
	class PimpMyWooV {
	  private static $bearer = "Pz5al2SHnxiD2iZs3hy4yYP1fvKlkxo0";
	  static function getPurchaseData( $code ) {
	    $bearer   = 'bearer ' . self::$bearer;
	    $header   = array();
	    $header[] = 'Content-length: 0';
	    $header[] = 'Content-type: application/json; charset=utf-8';
	    $header[] = 'Authorization: ' . $bearer;
	    
	    $verify_url = 'https://api.envato.com/v1/market/private/user/verify-purchase:'.$code.'.json';
	    $ch_verify = curl_init( $verify_url . '?code=' . $code );
	    
	    curl_setopt( $ch_verify, CURLOPT_HTTPHEADER, $header );
	    curl_setopt( $ch_verify, CURLOPT_SSL_VERIFYPEER, false );
	    curl_setopt( $ch_verify, CURLOPT_RETURNTRANSFER, 1 );
	    curl_setopt( $ch_verify, CURLOPT_CONNECTTIMEOUT, 5 );
	    curl_setopt( $ch_verify, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
	    
	    $cinit_verify_data = curl_exec( $ch_verify );
	    curl_close( $ch_verify );
	    
	    if ($cinit_verify_data != "")    
	      return json_decode($cinit_verify_data);  
	    else
	      return false;
	      
	  }
	  
	  static function verifyPurchase( $code, $id ) {
	    $verify_obj = self::getPurchaseData($code); 
	    // Check for correct verify code
	    if ( 
	        (false === $verify_obj) || 
	        !is_object($verify_obj) ||
	        !isset($verify_obj->{"verify-purchase"}) ||
	        !isset($verify_obj->{"verify-purchase"}->item_id) ||
	        $verify_obj->{"verify-purchase"}->item_id != $id
	    )
	      return -1;
	    // If empty or date present, then it's valid
	    if (
	      $verify_obj->{"verify-purchase"}->supported_until == "" ||
	      $verify_obj->{"verify-purchase"}->supported_until != null
	    )
	      return $verify_obj->{"verify-purchase"};  
	    
	    // Null or something non-string value, thus support period over
	    return 0;
	    
	  }
	}
}
?>