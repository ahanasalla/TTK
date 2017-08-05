<?php
use WPO\WC\Menu_Cart_Pro\Compatibility\Product as WCX_Product;

if ( ! class_exists( 'WPMenuCart_WooCommerce_Pro' ) ) {
	class WPMenuCart_WooCommerce_Pro extends WPMenuCart_WooCommerce {     
	
		/**
		 * Construct.
		 */
		public function __construct() {
		}
	
		/**
		 * Add Menu Cart to menu
		 * 
		 * @return menu items including cart
		 */
		
		public function submenu_items() {
			global $woocommerce;
			// make sure cart and session loaded! https://wordpress.org/support/topic/activation-breaks-customise?replies=10#post-7908988
			if ( version_compare( WOOCOMMERCE_VERSION, '2.5', '>=' ) && empty( $woocommerce->session ) ) {
				$session_class = apply_filters( 'woocommerce_session_handler', 'WC_Session_Handler' );
				$woocommerce->session = new $session_class();
			}
			if (empty($woocommerce->cart)) {
				$woocommerce->cart = new WC_Cart();
			}

			$cart = $woocommerce->cart->get_cart();
			// die('<pre>'.print_r( $cart, true ).'</pre>');
			$submenu_items = array();

			if (count($cart) > 0) {
				foreach ( $cart as $cart_item_key => $cart_item ) {
					$_product = $cart_item['data'];

					// Product bundles visibility
					// taken from woocommerce-product-bundles/includes/class-wc-pb-display.php
					if ( function_exists('wc_pb_get_bundled_cart_item_container')) {
						if ( $bundle_container_item = wc_pb_get_bundled_cart_item_container( $cart_item ) ) {

							$bundle          = $bundle_container_item[ 'data' ];
							$bundled_item_id = $cart_item[ 'bundled_item_id' ];

							if ( $bundled_item = $bundle->get_bundled_item( $bundled_item_id ) ) {
								if ( $bundled_item->is_visible( 'cart' ) === false ) {
									continue;
								}
							}
						}
					} elseif ( ! empty( $cart_item[ 'bundled_by' ] ) && ! empty( $cart_item[ 'stamp' ] ) ) {
						// Old version of Product Bundles
						if ( ! empty( $cart_item[ 'bundled_item_id' ] ) ) {

							$bundled_item_id = $cart_item[ 'bundled_item_id' ];
							$hidden          = isset( $cart_item[ 'stamp' ][ $bundled_item_id ][ 'secret' ] ) ? $cart_item[ 'stamp' ][ $bundled_item_id ][ 'secret' ] : 'no';

							if ( $hidden === 'yes' ) {
								continue;
							}
						}
					}
					
					$product_id = method_exists($_product, 'get_id') ? $_product->get_id() : $_product->id;
					if ( $_product->exists() && $cart_item['quantity'] > 0 ) {
						$item_quantity = esc_attr( $cart_item['quantity'] );

						if ( version_compare( WOOCOMMERCE_VERSION, '2.1', '>=' ) ) {
							// version 2.1 & upwards
							$item_price = apply_filters( 'woocommerce_cart_item_price', $woocommerce->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
							$item_name = apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key );
							$item_thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
							$item_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
						} else {
							// pre 2.1
							$item_price = apply_filters('woocommerce_cart_item_price_html', wc_price( $item_price ), $cart_item, $cart_item_key );
							$item_name = apply_filters( 'woocommerce_in_cart_product_title', $_product->get_title(), $cart_item, $cart_item_key );
							$item_thumbnail = apply_filters( 'woocommerce_in_cart_product_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

							// Item permalink if product visible
							if ( version_compare( WOOCOMMERCE_VERSION, '2.0.12', '>=' ) ) {
								// version 2.0.12 & upwards
								if ( $_product->is_visible() )
									$item_permalink = esc_url( get_permalink( apply_filters('woocommerce_in_cart_product_id', $cart_item['product_id'] ) ) );
							} else {
								// pre version 2.0.12
								if ( $_product->is_visible() || ( empty( $_product->variation_id ) && $_product->parent_is_visible() ) )
									$item_permalink = esc_url( get_permalink( apply_filters('woocommerce_in_cart_product_id', $cart_item['product_id'] ) ) );
							}
						}

						$submenu_items[] = array(
							'item_thumbnail'	=> $item_thumbnail,
							'item_name'			=> $item_name,
							'item_quantity'		=> $item_quantity,
							'item_price'		=> $item_price,
							'item_permalink'	=> $item_permalink,
							'cart_item'			=> $cart_item,
						);
					
					}
				}
			} else {
				$submenu_items = '';
			}
	
			return $submenu_items;	
		}

		public function get_cart_url(){
			global $woocommerce;
			$cart_url = $woocommerce->cart->get_cart_url();
			return $cart_url;		
		}
	}
}