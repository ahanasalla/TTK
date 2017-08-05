<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( !class_exists( 'WPO_Menu_Cart_Pro_Main' ) ) :

class WPO_Menu_Cart_Pro_Main {
	function __construct()	{
		// add filters to selected menus to add cart item <li>
		// add_action( 'init', array( $this, 'filter_nav_menus' ) );
		$this->filter_nav_menus();
		add_shortcode( 'wpmenucart', array( $this, 'shortcode' ) );

		// Enable shortcodes in text widgets
		if (!has_filter('widget_text','do_shortcode')) {
			add_filter('widget_text','do_shortcode');
		}

		// AJAX
		add_action( 'wp_ajax_wpmenucart_ajax', array( $this, 'built_in_ajax' ) );
		add_action( 'wp_ajax_nopriv_wpmenucart_ajax', array( $this, 'built_in_ajax' ) );
		if ( !isset(WPO_Menu_Cart_Pro()->main_settings['builtin_ajax']) && in_array( WPO_Menu_Cart_Pro()->main_settings['shop_plugin'], array( 'WooCommerce', 'Jigoshop') ) ) {
			if ( defined('WOOCOMMERCE_VERSION') && version_compare( WOOCOMMERCE_VERSION, '2.7', '>=' ) ) {
				add_filter( 'woocommerce_add_to_cart_fragments', array( $this, 'woocommerce_ajax_fragments' ) );
			} else {
				add_filter( 'add_to_cart_fragments', array( $this, 'woocommerce_ajax_fragments' ) );
			}
		}
	}

	/**
	 * Add filters to selected menus to add cart item <li>
	 */
	public function filter_nav_menus() {
		// exit if no menus set
		if ( !isset( WPO_Menu_Cart_Pro()->main_settings['menu_slugs'] ) || empty( WPO_Menu_Cart_Pro()->main_settings['menu_slugs'] ) ) {
			return;
		}

		//grab menu slugs
		$menu_slugs = apply_filters( 'wpmenucart_menu_slugs', WPO_Menu_Cart_Pro()->main_settings['menu_slugs'] );

		// Loop through $menu_slugs array and add cart <li> item to each menu
		foreach ($menu_slugs as $menu_slug) {
			if ( $menu_slug != '0' ) {
				add_filter( 'wp_nav_menu_' . $menu_slug . '_items', array( $this, 'add_nav_menu_item' ) , 10, 2 );
			}
		}
	}

	/**
	 * Add Menu Cart to menu
	 * 
	 * @return menu items + Menu Cart item
	 */
	public function add_nav_menu_item( $nav_menu_items, $args ) {
		$menu_slug = ( isset($args->menu) && isset($args->menu->slug) ) ? $args->menu->slug : '';
		$menu_item_html = $this->get_menucart_item( $nav_menu_items, array('menu_slug' => $menu_slug) );
		if ( apply_filters('wpmenucart_prepend_menu_item', false) ) {
			$nav_menu_items = apply_filters( 'wpmenucart_menu_item_wrapper', $menu_item_html ) . $nav_menu_items;
		} else {
			$nav_menu_items .= apply_filters( 'wpmenucart_menu_item_wrapper', $menu_item_html );
		}

		return $nav_menu_items;
	}

	/**
	 * Create HTML for shortcode
	 * @param  array $atts shortcode attributes
	 * @return string      'menucart' html
	 */
	public function shortcode($atts) {
		extract(shortcode_atts( array('style' => '', 'flyout' => 'hover', 'before' => '', 'after' => '') , $atts));

		$item_data = WPO_Menu_Cart_Pro()->shop->menu_item();
	
		$classes = $flyout;

		// Hide when empty
		if ( $item_data['cart_contents_count'] == 0 && !isset(WPO_Menu_Cart_Pro()->main_settings['always_display']) ) {
			$classes .= ' empty-wpmenucart';
		}

		$menu_item_html = $this->get_menucart_item( '', array( 'part' => 'main_li_content') );

		$menu = $before . '<span class="reload_shortcode">'.$menu_item_html. '</span>' . $after;
		$html = '<div class="wpmenucart-shortcode '.$classes.'" style="'.$style.'">'.$menu.'</div>';
		return $html;
	}

	public function get_menucart_item( $nav_menu_items = '', $args = array() ) {
		$menucart_item = new WPO_Menu_Cart_Pro_Template( 'menucart-item', $nav_menu_items, $args );
		$menucart_item = $menucart_item->get_output();

		return $menucart_item;
	}

	/**
	 * WooCommerce Ajax
	 * 
	 * @return ajax fragments
	 */
	public function woocommerce_ajax_fragments( $fragments ) {
		if ( ! defined('WOOCOMMERCE_CART') ) {
			define( 'WOOCOMMERCE_CART', true );
		}
		
		$fragments['a.wpmenucart-contents'] = $this->get_menucart_item( '', array( 'part' => 'main_a', 'wc_fragments' => true ) );
		$fragments['.sub-menu.wpmenucart'] = $this->get_menucart_item( '', array( 'part' => 'submenu', 'wc_fragments' => true ) );

		return $fragments;
	}

	public function built_in_ajax() {
		if ( ! defined('WOOCOMMERCE_CART') ) {
			define( 'WOOCOMMERCE_CART', true );
		}
		
		echo $this->get_menucart_item( '', array( 'part' => 'main_li_content' ) );
		die();
	}
}


endif; // class_exists

return new WPO_Menu_Cart_Pro_Main();