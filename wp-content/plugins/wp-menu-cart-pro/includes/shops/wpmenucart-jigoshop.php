<?php
if ( ! class_exists( 'WPMenuCart_Jigoshop' ) ) {
	class WPMenuCart_Jigoshop {     
	
	    /**
	     * Construct.
	     */
	    public function __construct() {
	    }
	
		public function menu_item() {
			$total = 0;
			if ( ! empty( jigoshop_cart::$cart_contents )) 
				foreach ( jigoshop_cart::$cart_contents as $cart_item_key => $values ) {
						$product = $values['data'];
						$total += $product->get_price() * $values['quantity'];
				}
				$total = jigoshop_price($total);

			$menu_item = array(
				'cart_url'				=> $this->cart_url(),
				'shop_page_url'			=> $this->shop_url(),
				'cart_contents_count'	=> jigoshop_cart::$cart_contents_count,
				'cart_total'	 		=> $total,
			);
		
			return $menu_item;		
		}
		
		public function cart_url() {
			return jigoshop_cart::get_cart_url();
		}

		public function shop_url() {
			return get_permalink( jigoshop_get_page_id( 'shop' ) );
		}
	}
}