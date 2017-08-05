<?php
/**
 * Plugin Name:       WooCommerce PimpMyWoo
 * Plugin URI:        http://www.pimpmywoo.com/
 * Description:       PimpMyWoo helps you customize the way your WooCommerce shop looks without writing a single line of code!
 * Version:           1.1.0
 * Author:            Southern Cross Global Consulting Pty. Ltd.
 * Author URI:        http://www.scglobal.com.au
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       pimpmywoo
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
defined( 'ABSPATH' ) or die( 'Plugin file cannot be accessed directly.' );
include_once( 'inc/class.pimpmywoo.php' );
require_once( ABSPATH . 'wp-admin/includes/plugin.php' );



register_activation_hook(__FILE__, 'activate_PimpMyWoo');
function activate_PimpMyWoo( $network_wide ) {
    if ( !in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	    exit(sprintf(__('Sorry, but PimpMyWoo requires the WooCommerce plugin to be installed and activated.'), 'pimpmywoo'));
    } else {
	    $PimpMyWoo = new PimpMyWoo();
    }
}
if (in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) )) {
	    $PimpMyWoo = new PimpMyWoo();
} else {
	deactivate_plugins( plugin_basename(__FILE__) );
	add_action( 'admin_notices', 'PimpMyWoo_admin_error_notice' );
}

function PimpMyWoo_admin_error_notice() {
	$message = __("PimpMyWoo was deactivated. You need WooCommerce installed and activated to properly run PimpMyWoo.", 'pimpmywoo');
        echo"<div id=\"message\" class=\"updated notice is-dismissible\"> <p>$message</p></div>"; 
}



add_action('wp_enqueue_scripts', 'oenology_enqueue_varietal_style', 999999 );
function oenology_enqueue_varietal_style() {
	wp_enqueue_style( 'pimpmywoo', plugins_url('inc/style.php', __FILE__) );
}
// Enqueue Varietal Stylesheet at wp_print_styles




