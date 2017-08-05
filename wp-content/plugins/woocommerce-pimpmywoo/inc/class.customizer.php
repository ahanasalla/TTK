<?php
new PimpMyWoo_Customizer();

class PimpMyWoo_Customizer
{
    public function __construct() {
        add_action( 'customize_register', array(&$this, 'customize_PimpMyWoo' ));
    }
    public function customize_PimpMyWoo( $wp_manager ) {
		require_once dirname(__FILE__) . '/class.extra.controls.php';
		$wp_manager->add_panel( 'pimpmywoo_panel', array(
		    'priority' => 10,
		    'capability' => 'edit_theme_options',
		    'theme_supports' => '',
		    'title' => 'PimpMyWoo',
		) );
        $this->listing_section( $wp_manager );
        $this->sidebar_section( $wp_manager );
        $this->single_section( $wp_manager );
        $this->cart_section( $wp_manager );
    }
    private function listing_section( $wp_manager ) {
	    include_once( 'class.customizer.listing.php' );
    }
    private function sidebar_section( $wp_manager ) {
	    include_once( 'class.customizer.sidebar.php' );
	}
    private function single_section( $wp_manager ) {
	    include_once( 'class.customizer.single.php' );
	}
    private function cart_section( $wp_manager ) {
	    include_once( 'class.customizer.cart.php' );
	}
}
include_once( 'class.customizer.preview.php' );
?>