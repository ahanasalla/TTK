<?php

/**
 * Plugin Name: WooCommerce Click And Pick
 * Description: This plugin allow the user to choose local pickup shipping method for the item, and the admin can add branches and specify the working hours, days and vacations for the branch so the user can choose the best available branches.
 * Author: Osama Ahmed Attia
 * Author URI: http://twitter.com/oaattia
 * Version: 1.9.9
 * Text Domain: click-and-pick
 * Domain Path: /languages/
 *
 *
 */

namespace Click_And_Pick;

use Click_And_Pick\Branch\Click_And_Pick_Branch;
use Click_And_Pick\Emails\Email;
use Click_And_Pick\Front\Checkout\Checkout;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Click_And_Pick {

	/**
	 * Click and pick version
	 *
	 * @const VERSION
	 */
	const VERSION = '1.9.9';

	/**
	 * Click and pick name constant
	 */
	const NAME = 'Click And Pick';

	/**
	 * This is the text domain for the plugin
	 */
	const TEXTDOMAIN = 'click-and-pick';

	/**
	 * constructor
	 */
	public function __construct() {

		add_filter( 'os-pw-google-maps-api-key', function () {
            $setting = get_option('woocommerce_click-and-pick_shipping_method_settings');
            return isset($setting['map']) ? $setting['map'] : 'AIzaSyCYDj3xgjXZB1FaNi7pt3WOE5t7swp7HZs';
		} );

		$this->includes();
		$this->branches();
		$this->front();
		$this->email();

		add_action( 'admin_enqueue_scripts', array( $this, 'include_admin_scripts' ) );

		add_action( 'wp_enqueue_scripts', array( $this, 'include_front_end_scripts' ), 100 );

		add_action( 'plugins_loaded', array( $this, 'click_load_plugin_textdomain' ) );

       // add_action( 'wp_footer' , array($this, 'footer_scripts'), 200 );

	}

	/**
	 * Include the important files for the plugin
	 *
	 * @return void
	 */
	private function includes() {
		require_once plugin_dir_path( __FILE__ ) . 'classes/shipping/click.n.pick.shipping.class.php';
        if (file_exists(plugin_dir_path(__FILE__) . 'extras/cmb2/init.php')) {
            require_once plugin_dir_path(__FILE__) . 'extras/cmb2/init.php';
            require_once plugin_dir_path(__FILE__) . 'extras/cmb_google_map/cmb-field-map.php'; // map
        } elseif (file_exists(plugin_dir_path(__FILE__) . 'EXTRAS/CMB2/init.php')) {
            require_once plugin_dir_path(__FILE__) . 'EXTRAS/CMB2/init.php';
            require_once plugin_dir_path(__FILE__) . 'EXTRAS/CMB_GOOGLE_MAP/cmb-field-map.php'; // map
        }
		require_once plugin_dir_path( __FILE__ ) . 'classes/branches/branch.php';
		require_once plugin_dir_path( __FILE__ ) . 'classes/helper.class.php';
		require_once plugin_dir_path( __FILE__ ) . 'front/checkout.class.php';
		require_once plugin_dir_path( __FILE__ ) . 'emails/email.class.php';
	}

	/**
	 * Include the branches
	 */
	public function branches() {
		new Click_And_Pick_Branch();
	}


	/**
	 *
	 */
	public function front() {
		new Checkout();
	}


	/**
	 *
	 */
	public function email() {
		new Email();
	}

	/**
	 * Include scripts and styles for the admin page
	 */
	public function include_admin_scripts() {
		$screen = get_current_screen();
		if ( $screen->post_type === "branch" ) {
			wp_enqueue_script( 'wcp_admin_script', plugins_url( 'assets/js/admin.js', __FILE__ ), [
				'jquery',
				'jquery-ui-core',
				'jquery-ui-sortable',
			] );

			wp_enqueue_style( 'wcp_admin_css', plugins_url( 'assets/css/admin.css', __FILE__ ) );
		}
	}

	/**
	 * Include the front-end script in the checkout page
	 */
	public function include_front_end_scripts() {
		if ( is_checkout() ) {
			wp_enqueue_script( 'wcp_front_end_script', plugins_url( 'assets/js/custom.js', __FILE__ ), [ 'jquery' ],false, true );

			wp_enqueue_script( 'wp_lodash_script', plugins_url( 'assets/js/lodash.js', __FILE__ ), [],false, true );

			wp_localize_script('wcp_front_end_script', 'click_n_pick', array(
					'error' => __('Please, pick date\time first!', 'click-and-pick')
				)
			);

		}
	}

    /**
     * Footer scripts to be added here
     */
    public function footer_scripts() {
        $setting = get_option('woocommerce_click-and-pick_shipping_method_settings');
         echo '<script async defer src="https://maps.googleapis.com/maps/api/js?key=' . $setting['map'] . '"></script>';
    }


	/**
	 * Load Plugin textdomain
	 */
	public function click_load_plugin_textdomain() {
		load_plugin_textdomain(
			self::TEXTDOMAIN,
			false,
			dirname( plugin_basename( __FILE__ ) ) . '/languages/'
		);
	}
}

/**
 * Check if WooCommerce is active
 **/
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	new Click_And_Pick();
}
