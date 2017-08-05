<?php
/*
Plugin Name: WooCommerce Minima and Maxima
Plugin URI: https://www.simbahosting.co.uk/s3/product/woocommerce-minima-and-maxima/
Description: Allows shop owners to apply rules on minimum/maximum purchases
Version: 1.6.6
Text Domain: woocommerce-minima-and-maxima
Domain Path: /languages
Author: David Anderson
Author URI: https://www.simbahosting.co.uk/s3/shop/
Requires at least: 3.5
Tested up to: 4.8
License: GNU General Public License v3.0+
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Copyright: 2015- David Anderson
*/

/*
Possible future enhancements:
- Exclude specific products
- Min/max rules on specific products
*/

if (!defined('ABSPATH')) die('Access denied.');

define('WC_MINMAX_DIR', dirname(__FILE__));
define('WC_MINMAX_URL', plugins_url('', __FILE__));

class WC_Minima_And_Maxima {

	private $ourdir;
	private $oururl;
	private $shipping_methods;
	private $shipping_method_ids;
	private $shipping_zone_labels;
	private $shipping_methods_and_zones;

	private $debug = false;
	
	private $wc_compat;

	const OPTION_NAME = 'wcminmax_options';
	const OUR_VERSION = '1.6.6';
	const TEXT_DOMAIN = 'wc_minima_and_maxima';

	public function __construct() {
		add_action('plugins_loaded', array($this, 'plugins_loaded'));
		add_action('admin_menu', array($this, 'admin_menu'));
		add_filter('network_admin_plugin_action_links', array($this, 'plugin_action_links'), 10, 2);
		add_filter('plugin_action_links', array($this, 'plugin_action_links'), 10, 2);
		add_action('wp_ajax_wc_minima_and_maxima', array($this, 'ajax_backend'));
		
		add_action('all_admin_notices', array($this, 'admin_notices'));
		
		// These two are not used
// 		add_action('wp_ajax_wc_minima_and_maxima_frontend', array($this, 'ajax_frontend'));
// 		add_action('wp_ajax_nopriv_wc_minima_and_maxima_frontend', array($this, 'ajax_frontend'));
		
		add_filter('woocommerce_screen_ids', array($this, 'woocommerce_screen_ids'));
		add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
		add_action('woocommerce_check_cart_items', array($this, 'woocommerce_check_cart_items'));
		add_action('woocommerce_checkout_process', array($this, 'woocommerce_check_cart_items'));

		// Per-category settings
		add_action( 'product_cat_add_form_fields', array( $this, 'product_cat_add_form_fields' ) );
		add_action( 'product_cat_edit_form_fields', array( $this, 'product_cat_edit_form_fields' ), 10 );
		add_action( 'created_term', array( $this, 'edit_term' ), 10 );
		add_action( 'edit_term', array( $this, 'edit_term' ), 10 );

		// Coupons - allow the rules to be over-ridden
		add_action('woocommerce_coupon_options', array($this, 'woocommerce_coupon_options'));
		add_action('woocommerce_process_shop_coupon_meta', array($this, 'woocommerce_process_shop_coupon_meta'), 10, 2);

		if (!class_exists('WooCommerce_Compat_0_3')) require_once(WC_MINMAX_DIR.'/vendor/davidanderson684/woocommerce-compat/woocommerce-compat.php');
		$this->wc_compat = new WooCommerce_Compat_0_3;
		
		$this->ourdir = dirname(__FILE__);
		$this->oururl = plugins_url('', __FILE__);

		if (@constant('WOOCOMMERCE_MINMAX_DEBUG_MODE')) $this->debug = true;

		// Updater
		add_action('plugins_loaded', array($this, 'load_updater'), 0);
	}

	public function load_updater() {
		if (file_exists(WC_MINMAX_DIR.'/wpo_update.php')) {
			require(WC_MINMAX_DIR.'/wpo_update.php');
		} elseif (file_exists(WC_MINMAX_DIR.'/updater.php')) {
			require(WC_MINMAX_DIR.'/updater.php');
		}
	}
	
	public function admin_notices() {
		if (!function_exists('WC')) return;
		
		$woocommerce = WC();
		if (version_compare($woocommerce->version, '2.6', '>=')) {
			$settings = get_option(self::OPTION_NAME);
			
			if (is_array($settings)) {
			
				if (empty($settings['last_wc_saved_on']) || version_compare($settings['last_wc_saved_on'], '2.6', '<')) {
			
					$this->show_admin_warning('<span style="font-size:125%;"><strong>'.__('Important upgrade notice', 'wc_minima_and_maxima').'</strong></span><br>'.sprintf(__('You have updated WooCommerce to version %s, which includes significant changes to shipping functionality.', 'wc_minima_and_maxima'), '2.6').' <a href="'.esc_attr($this->our_page()).'">'.__('After setting up your shipping zones (if any), please then immediately visit and save your WooCommerce minimum/maximum order settings, in order to remain compatible.', 'wc_minima_and_maxima').'</a>'.' '.__('This message will disappear when you have done so.', 'wc_minima_and_maxima'), 'error');
			
				} elseif (version_compare($settings['last_saved_on'], '1.5.4', '<')) {
				
					$this->show_admin_warning('<span style="font-size:125%;"><strong>'.__('Important upgrade notice', 'wc_minima_and_maxima').'</strong></span><br>'.sprintf(__('You have updated WooCommerce Minima / Maxima to version %s or later, which includes significant changes to its handling of WooCommerce 2.6 shipping zones.', 'wc_minima_and_maxima'), '1.5.4').' <a href="'.esc_attr($this->our_page()).'">'.__('Please then immediately visit and save your WooCommerce minimum/maximum order settings, in order to remain compatible.', 'wc_minima_and_maxima').'</a>'.' '.__('This message will disappear when you have done so.', 'wc_minima_and_maxima'), 'error');
				
				}
			
			}
			
		}
	}
	
	private function show_admin_warning($message, $class = "updated") {
		echo '<div class="wcminmaxmessage '.$class.'">'."<p>$message</p></div>";
	}
	
	public function enqueue_scripts() {

		if (!function_exists('is_cart') || !function_exists('is_checkout')) return;

		if (is_cart() || is_checkout()) {
		
			$enqueue_version = @constant('WP_DEBUG') ? self::OUR_VERSION.'.'.time() : self::OUR_VERSION;
		
			wp_enqueue_script('wcminmax-js', $this->oururl.'/js/cart-or-checkout.js', array('jquery'), $enqueue_version);

			$shipping_methods_and_zones = $this->get_shipping_methods_and_zones();
			
			$shipping_method_ids = $this->get_shipping_method_ids();

			$shipping_method_labels = array();

			foreach ($shipping_methods_and_zones as $method_id => $data) {
				if (empty($data['instances'])) {
					$shipping_method_labels[$method_id] = $this->get_shipping_method_title_from_id($method_id);
				} else {
					foreach ($data['instances'] as $instance_id) {
						$full_method_id = $method_id.$instance_id;
						$shipping_method_labels[$method_id] = $this->get_shipping_method_title_from_id($method_id, $instance_id);
					}
				}
			}

			$settings = $this->get_reversed_settings(true);

			/*
			if (version_compare(WC()->version, '2.6', '>=')) {
				global $wpdb, $table_prefix;
				$zone_results = $wpdb->get_results("SELECT zone_id, zone_name FROM ${table_prefix}woocommerce_shipping_zones ORDER BY zone_order ASC");
			
				foreach ($zone_results as $zone) {
					$shipping_zone_labels[$zone->zone_id] = $zone->zone_name;
				}
			}
			*/

			$localize = array(
				'debug' => $this->debug,
				'settings' => $settings,
				'shipping_method_labels' => $shipping_method_labels
			);

			wp_localize_script( 'wcminmax-js', 'wcminmaxlion', $localize);

		}
	}

	public function admin_menu() {
		add_submenu_page(
			'woocommerce',
			__('Min/Max Rules', 'wc_minima_and_maxima'),
			__('Min/Max Rules', 'wc_minima_and_maxima'),
			'manage_woocommerce',
			'wc_minima_and_maxima',
			array($this, 'settings_page')
		);
	}

	public function woocommerce_screen_ids($screen_ids) {
		if (!in_array('woocommerce_page_wc_minima_and_maxima', $screen_ids)) $screen_ids[] = 'woocommerce_page_wc_minima_and_maxima';
		return $screen_ids;
	}

	public function plugins_loaded() {
		load_plugin_textdomain(self::TEXT_DOMAIN, false, basename($this->ourdir).'/languages');
	}

	public function woocommerce_coupon_options() {

		global $post;

		$coupon_exempts = (bool)get_post_meta($post->ID, 'wcminmax_exempts', true);

		?><p class="form-field wcminmax_exempts_coupon_field"><label for="wc_minmax_exempts_coupon"><?php _e('Min/max rules exemption', 'wc_minima_and_maxima');?></label>

		<input type="checkbox" <?php if ($coupon_exempts) echo 'checked="checked" ';?>class="checkbox" name="wc_minmax_exempts_coupon" id="wc_minmax_exempts_coupon" value="yes"> <span class="description"><?php echo __('Exempt the customer from minimum/maximum purchase requirements when using this coupon.','wc_minima_and_maxima');?></span></p>

		<?php

	}

	public function woocommerce_process_shop_coupon_meta($post_id, $post) {
		$coupon_exempts = !empty($_POST['wc_minmax_exempts_coupon']) ? true : false;
		update_post_meta($post_id, 'wcminmax_exempts', $coupon_exempts);
	}

	// WC 2.6 notes that get_woocommerce_term_meta and update_woocommerce_term_meta will be deprecated in future; so, we've funnelled all ours through this single point, to be ready for that.
	private function get_woocommerce_term_meta($term_id, $key, $single = true) {
		return get_woocommerce_term_meta($term_id, $key, $single);
	}
	
	private function update_woocommerce_term_meta( $term_id, $meta_key, $meta_value, $prev_value = '' ) {
		return update_woocommerce_term_meta($term_id, $meta_key, $meta_value, $prev_value);
	}
	
	public function product_cat_edit_form_fields( $term ) {

		$ignore_in_this_category = (bool)$this->get_woocommerce_term_meta($term->term_id, 'wcminmax_ignoreinthiscategory', true );
		$this->render_min_max_category_field($ignore_in_this_category);

	}

	private function render_min_max_category_field($ignore_in_this_category) {
		?>
		<tr class="form-field">
			<th scope="row" valign="top"><label for="wcminmax_ignore_in_this_category"><?php _e( 'Ignore for min/max purchase calculations', 'wc_minima_and_maxima'); ?></label></th>
				<td>
					<input type="checkbox" id="wcminmax_ignore_in_this_category" name="wcminmax_ignore_in_this_category" <?php if ($ignore_in_this_category) echo 'checked="checked" ';?>>
					<p class="description"><?php echo __("Select this option, in order to ignore items from this category in the customer's cart when applying rules about minimum/maximum purchases.", 'wc_minima_and_maxima'); ?></p>
			</td>
		</tr>

		<?php
	}

	public function product_cat_add_form_fields() {
		$this->render_min_max_category_field(false);
	}

	// Save category times
	public function edit_term( $term_id ) {
		if (!is_admin() || !current_user_can('manage_woocommerce')) return;
		$ignore_in_this_category = empty($_POST['wcminmax_ignore_in_this_category']) ? false : true;
		$this->update_woocommerce_term_meta( $term_id, 'wcminmax_ignoreinthiscategory', $ignore_in_this_category );
	}

	// Multi-purpose function: both for advisories (action woocommerce_check_cart_items) and for errors (woocommerce_checkout_process)
	public function woocommerce_check_cart_items() {

		// WooCommerce 3.0 runs both woocommerce_check_cart_items and woocommerce_checkout_process, which results in duplicate notices.
		static $we_already_did_this = false;
		if ($we_already_did_this) return;
		$we_already_did_this = true;

		$woocommerce = WC();

		// If there are shipping classes settings, then check that we have items in the cart that match the selected classes - otherwise, we have no objection
		$opts = $this->get_settings(true);
		$opts_reversed = $this->get_reversed_settings(true);

		if (apply_filters('wcminandmax_is_cart_exempt', false)) return;

		$category_cache = array();

		$cart = $woocommerce->cart;

		$exempted_via_coupon = false;
		$current_filter = current_filter();

		$is_checkout = ('woocommerce_check_cart_items' != $current_filter || (defined('WOOCOMMERCE_CHECKOUT') && WOOCOMMERCE_CHECKOUT)) ? true : false;

		$allow_all_excluded = !empty($opts['allowallexcluded']);

		// Any coupons that exempt from the checks?
		$coupons = $cart->get_coupons();
		foreach ($coupons as $coupon) {
			$coupon_exempts = (bool)$this->wc_compat->get_meta($coupon, 'wcminmax_exempts', true);
			if ($coupon_exempts) $exempted_via_coupon=true;
		}

// 		// When not checking out, we continue, because we want the admin notices to be able to appear 
// 		if ($exempted_via_coupon && $is_checkout) return;
		if ($exempted_via_coupon) return;

		$cart = $cart->get_cart();
		$shipping_classes = $opts['shippingclasses'];
		if (is_array($shipping_classes)) {
			foreach ($shipping_classes as $k => $v) {
				if (!$v) unset($shipping_classes[$k]);
			}
		}

		// Prune items that are not in a relevant shipping class, if the user has used this option
		if (!empty($shipping_classes) && is_array($shipping_classes)) {

			$relevant_cart = array();

			foreach ($cart as $item) {
				$product = $item['data'];

				$shipping_class = $product->get_shipping_class_id();
				if ($this->debug) error_log("shipping_class=$shipping_class, looking in ".serialize($shipping_classes));
				if (!empty($shipping_class) && in_array($shipping_class, $shipping_classes)) {
					$relevant_cart[] = $item;
				}
			}
// 			if (!$relevant_products_found) return;
		} else {
			// If no shipping classes specified, then we carry on with the current cart
			$relevant_cart = $cart;
		}

		// $relevant_cart is now those cart items which passed the shipping method requirement. Now we loop again to check the category requirement

		foreach ($relevant_cart as $k => $item) {

			$product = $item['data'];

			if (is_a($product, 'WC_Product_Variation')) {
				// On WC 3.0, get_id() returns the variation ID, whereas the 'id' property (for which direct access is deprecated) is/was the parent. 
				$product_id = 
				is_callable(array($product, 'get_parent_id')) ? $product->get_parent_id() : $product->id;
			} else {
				$product_id = $this->wc_compat->get_id($product);
			}
			
			$categories_unindexed = get_the_terms( $product_id, 'product_cat' );
			if (!is_array($categories_unindexed)) $categories_unindexed = array();
			$categories = array();
			// Reindex based on term ID
			foreach ($categories_unindexed as $cat) {
				$categories[$cat->term_id] = $cat;
			}

			foreach ($categories as $cat) {
				if (!isset($cat->term_id)) continue;
				$ignore = (isset($category_cache[$cat->term_id])) ? $category_cache[$cat->term_id] : $this->get_woocommerce_term_meta($cat->term_id, 'wcminmax_ignoreinthiscategory', true);
				$category_cache[$cat->term_id] = $ignore;
				if ($ignore) {
					if ($this->debug) error_log("Ignoring item because of category (id=".$cat->term_id.") setting");
					unset($relevant_cart[$k]);
				}
			}

		}

		if (empty($relevant_cart) && $allow_all_excluded) return;

		$shipping_methods_and_zones = $this->get_shipping_methods_and_zones();
		
		if (!isset($shipping_methods_and_zones['default'])) {
			$shipping_methods_and_zones['default'] = array();
		}
		
		$shipping_method_ids = $this->get_shipping_method_ids();

		$current_instance_id = null;
		
		if (!empty($_POST['shipping_method'])) {
			$posted_shipping_method = $_POST['shipping_method'];
			$current_shipping_method = is_array($posted_shipping_method) ? array_shift($posted_shipping_method) : $posted_shipping_method;
			
			// WC 2.6 beta 2 onwards adds a colon
			if (version_compare($woocommerce->version, '2.6', '>=') && preg_match('/^(.*):(\S+)$/', $current_shipping_method, $matches)) {
				$current_shipping_method = $matches[1];
				$current_instance_id = $matches[2];
			}
			
		} else {
			$current_shipping_method = 'default';
		}

		foreach ($shipping_methods_and_zones as $shipping_method_id => $method) {

			$instances = isset($method['instances']) ? $method['instances'] : array();
			
			if (empty($instances)) $instances = array('NOINSTANCE' => null);

			foreach ($instances as $instance_id) { 

				if ('NOINSTANCE' === $instance_id) {
					$instance_id = null;
				}
				
				// Reset the variable
				unset($msg);

				$methods_match = ($shipping_method_id != $current_shipping_method || $instance_id != $current_instance_id) ? false : true;

				// Special case seen in the wild
				// This occurred when the actual shipping method and ID was wbs/4
				// current_shipping_method: wbs_0dd3bc79_weight_based_shipping
				// instance_id: 
				if (!$methods_match && 1 == count($instances) && preg_match('/^([a-z]+)_([0-9a-f]+)_(.*)$/', $current_shipping_method, $matches) && $matches[1] == $shipping_method_id && empty($current_instance_id)) {
					$methods_match = true;
					file_put_contents(__DIR__.'/log.txt', "SCRAGIT: $shipping_method_id:$instance_id:$current_shipping_method:$current_instance_id\n", FILE_APPEND);

				}
				
				if ($is_checkout && !apply_filters('wcminandmax_methods_match', $methods_match, $shipping_method_id, $current_shipping_method, $instance_id, $current_instance_id)) continue;

				$is_quantity_ok = $this->check_cart_quantity($relevant_cart, $shipping_method_id, $instance_id);
				$is_amount_ok = $this->check_cart_amount($relevant_cart, $shipping_method_id, $instance_id);

				// "Currently", because things can change on the page (change of shipping method)
				$is_currently_ok = (true === $is_quantity_ok && true === $is_amount_ok) ? true : false;

				if ($is_currently_ok) continue;

				if (true !== $is_quantity_ok) {
					$msg = $is_quantity_ok['message'];
				}
				if (true !== $is_amount_ok) {
					$msg = (isset($msg) && $msg != $is_amount_ok['message']) ? $msg."<br>".$is_amount_ok['message'] : $is_amount_ok['message'];
				}

				if ($is_checkout) {
					wc_add_notice($msg, 'error');
				} else {

					// Cart

					$display_or_not = (!$is_currently_ok && $shipping_method_id == $current_shipping_method && $instance_id == $current_instance_id) ? 'block' : 'none';
					echo "<p style=\"display: $display_or_not;\" class=\"woocommerce-message woocommerce-info woocommerce-info-minmaxinfo woocommerce-info-minmaxinfo-${shipping_method_id} woocommerce-info-minmaxinfo-${shipping_method_id}-${instance_id}\" id=\"wcminmax_minmaxinfo-${shipping_method_id}-${instance_id}\">\n\t".$msg."\n</p>\n";
				}
			}
		}

	}

	private function supply_error_message($msg, $code, $type = 'amount', $howmany, $compare_with = 'items_total', $tax_total = 0) {
		if ('quantity' == $type) {
			if ('toofew' == $code) {
				$message = $msg ? $msg : sprintf(apply_filters('wcminandmax_default_toofew_message', __('Your shopping cart has too few items in it - you must have at least %s qualifying items'), 'wc_minima_and_maxima'), $howmany);
			} else {
				// toomany
				$message = $msg ? $msg : sprintf(apply_filters('wcminandmax_default_toomany_message', __('Your shopping cart has too many items in it - you must have no more than %s qualifying items', 'wc_minima_and_maxima')), $howmany);
			}
		} else {

			// Values for $compare_with: items_total, items_total_t, items_total_dt, items_total_d
			switch ($compare_with) {
			case 'items_total_t':
				$describe = $tax_total ? ' '.__('(after taxes)', 'wc_minima_and_maxima') : '';
				break;
				case 'items_total_dt':
				$describe = $tax_total ? ' '.__('(after taxes)', 'wc_minima_and_maxima') : '';
				break;
				case 'items_total_d':
				$describe = $tax_total ? ' '.__('(before taxes)', 'wc_minima_and_maxima') : '';
				break;
				case 'items_total':
				default:
				$describe = $tax_total ? ' '.__('(before taxes)', 'wc_minima_and_maxima') : '';
				break;
			}

			if ('toomuch' == $code) {
				$message = $msg ? $msg : sprintf(apply_filters('wcminandmax_default_toomuch_message', __('Qualifying items in your shopping cart total%s more than the allowed maximum purchase, which is %s', 'wc_minima_and_maxima')), $describe, $this->format_price($howmany));
			} else {
				// toolittle
				$message = $msg ? $msg : sprintf(apply_filters('wcminandmax_default_toolittle_message', __('Qualifying items in your shopping cart total%s less than the allowed minimum purchase, which is %s', 'wc_minima_and_maxima')), $describe, $this->format_price($howmany));
			}
		}
		return apply_filters('wcminandmax_supply_error_message', $message, $msg, $code, $type, $howmany, $compare_with);
	}

	// Returns true or an array with keys code, message
	private function check_cart_quantity($cart, $shipping_method = 'default', $instance_id = null) {

		$reversed = $this->get_reversed_settings(true);

		$shipping_method_key = is_null($instance_id) ? $shipping_method : $shipping_method.'__I-'.$instance_id;
		
		if (!is_null($instance_id) && !isset($reversed[$shipping_method_key])) $shipping_method_key = $shipping_method;
		
		$rules = isset($reversed[$shipping_method_key]) ? $reversed[$shipping_method_key] : array();
		// Keys: minamount, maxamount, minitems, maxitems, message

		$total_quantity = 0;
		$msg = isset($rules['message']) ? $rules['message'] : '';
		foreach ($cart as $item) {
			$quantity = $item['quantity'];
			$total_quantity += $quantity;
		}

		$result = true;
		
		if (isset($rules['minitems']) && is_numeric($rules['minitems']) && $total_quantity < $rules['minitems']) {
			$result = array('code' => 'toofew', 'message' => $this->supply_error_message($msg, 'toofew', 'quantity', $rules['minitems']));
		} elseif (isset($rules['maxitems']) && is_numeric($rules['maxitems']) && $total_quantity > $rules['maxitems']) {
			$result = array('code' => 'toomany', 'message' => $this->supply_error_message($msg, 'toomany', 'quantity', $rules['maxitems']));
		}
		
		return apply_filters('woocommerce_minima_maxima_check_cart_quantity', $result, $rules, $total_quantity, $cart, $shipping_method, $instance_id);
	}

	private function check_cart_amount($cart, $shipping_method = 'default', $instance_id = null) {

		$settings = $this->get_settings(true);
		$reversed = $this->get_reversed_settings(true);
		
		$shipping_method_key = is_null($instance_id) ? $shipping_method : $shipping_method.'__I-'.$instance_id;
		
		if (!is_null($instance_id) && !isset($reversed[$shipping_method_key])) $shipping_method_key = $shipping_method;

		$rules = isset($reversed[$shipping_method_key]) ? $reversed[$shipping_method_key] : array();
		// Keys: minamount, maxamount, minitems, maxitems, message
		$msg = isset($rules['message']) ? $rules['message'] : '';

		$compare_with = isset($settings['comparewith'][$shipping_method_key]) ? $settings['comparewith'][$shipping_method_key] : 'items_total';

		$cart_contents_total = 0;
		$cart_contents_total_net_of_discounts = 0;
		$tax_total = 0;
		$tax_total_net_of_discounts = 0;

		foreach ($cart as $item) {
			$cart_contents_total += $item['line_subtotal'];
			$cart_contents_total_net_of_discounts += $item['line_total'];
			if (isset($item['line_subtotal_tax'])) $tax_total += $item['line_subtotal_tax'];
			if (isset($item['line_tax'])) $tax_total_net_of_discounts += $item['line_tax'];
		}

		switch ($compare_with) {
			case 'items_total_t':
			$compare_amount = $cart_contents_total + $tax_total;
			break;
			case 'items_total_dt':
			$compare_amount = $cart_contents_total_net_of_discounts + $tax_total_net_of_discounts;
			break;
			case 'items_total_d':
			$compare_amount = $cart_contents_total_net_of_discounts;
			break;
			case 'items_total':
			default:
			$compare_amount = $cart_contents_total;
			break;
		}
		
		if ($this->debug) error_log("Comparing amount with ($compare_with): $compare_amount");

		$result = true;
		
		if (isset($rules['minamount']) && is_numeric($rules['minamount']) && $compare_amount < $rules['minamount']) {
			if ($this->debug) error_log("toolittle ($shipping_method): $compare_amount ($compare_with) < ".$rules['minamount']);
			$result = array('code' => 'toolittle', 'message' => $this->supply_error_message($msg, 'toolittle', 'amount', $rules['minamount'], $compare_with, $tax_total));
		} elseif (isset($rules['maxamount']) && is_numeric($rules['maxamount']) && $compare_amount > $rules['maxamount']) {
			if ($this->debug) error_log("toomuch ($shipping_method): $compare_amount ($compare_with) > ".$rules['maxamount']);
			$result = array('code' => 'toomuch', 'message' => $this->supply_error_message($msg, 'toomuch', 'amount', $rules['maxamount'], $compare_with, $tax_total));
		}

		return apply_filters('woocommerce_minima_maxima_check_cart_amount', $result, $rules, $compare_amount, $cart, $shipping_method, $instance_id);
	}

	private function our_page() {
		$page = 'wc_minima_and_maxima';
		return admin_url('admin.php').'?page='.$page;
	}
	
	public function plugin_action_links($links, $file) {
		if (is_array($links) && strpos($file, basename($this->ourdir).'/woocommerce-minima-and-maxima') !== false) {
			
			$settings_link = '<a href="'.$this->our_page().'">'.__("Min/Max Rules", "wc_minima_and_maxima").'</a>';
			array_unshift($links, $settings_link);
		}
		return $links;
	}

	// An array, keyed by zone_id, giving the zone names
	private function get_shipping_zone_labels() {
	
		if (is_array($this->shipping_zone_labels)) return $this->shipping_zone_labels;
	
		$shipping_zone_labels = array();
	
		if (version_compare(WC()->version, '2.6', '>=')) {
			global $wpdb, $table_prefix;
			$zone_results = $wpdb->get_results("SELECT zone_id, zone_name FROM ${table_prefix}woocommerce_shipping_zones ORDER BY zone_order ASC");
		
			foreach ($zone_results as $zone) {
				$shipping_zone_labels[$zone->zone_id] = $zone->zone_name;
			}
			
			// This is hard-coded in the code of WooCommerce. We could get a new WC_Shipping_Zone(0), but that seems like overkill - it seems exceedingly unlikely to change.
			$shipping_zone_labels[0] = __('Rest of the World', 'woocommerce');
		}
	
		$this->shipping_zone_labels = $shipping_zone_labels;
	
		return $shipping_zone_labels;
	
	}
	
	// Returns an array, keyed by shipping method ID, in which each entry is an array with keys method_object (the shipping method object) and zones (a list of shipping zone IDs that the shipping method is active in)
	private function get_shipping_methods_and_zones() {
	
		if (is_array($this->shipping_methods_and_zones)) return $this->shipping_methods_and_zones;
	
		$woocommerce = WC();
		$methods_and_zones = array();
		
		$shipping_methods = $this->get_shipping_methods();
		foreach ($shipping_methods as $method_id => $method_object) {
			$methods_and_zones[$method_id] = array(
				'method_object' => $method_object,
				'zones' => array(),
				'instances' => array()
			);
		}
		
		if (version_compare($woocommerce->version, '2.6', '>=')) {
			global $wpdb, $table_prefix;
			$zones = $wpdb->get_results("SELECT DISTINCT zone_id, method_id, instance_id FROM ${table_prefix}woocommerce_shipping_zone_methods WHERE is_enabled=1");
		
			foreach ($zones as $zone) {
				$zone_id = $zone->zone_id;
				$method_id = $zone->method_id;
				$instance_id = $zone->instance_id;
				if (isset($methods_and_zones[$method_id])) {
					if (!isset($methods_and_zones[$method_id]['zones'][$zone_id])) $methods_and_zones[$method_id]['zones'][$zone_id] = array();
					if (!in_array($instance_id, $methods_and_zones[$method_id]['zones'][$zone_id])) $methods_and_zones[$method_id]['zones'][$zone_id][] = $instance_id;
					if (!in_array($instance_id, $methods_and_zones[$method_id]['instances'])) $methods_and_zones[$method_id]['instances'][] = $instance_id;
				}
			}
		
		}
		
		$this->shipping_methods_and_zones = $methods_and_zones;

		return $methods_and_zones;
		
	}
	
	private function get_shipping_methods() {
		$woocommerce = WC();
		$shipping_methods = is_object($woocommerce->shipping) ? $woocommerce->shipping->load_shipping_methods() : array();
		return $shipping_methods;
	}
	
	private function get_shipping_method_ids() {

		$shipping_methods_and_zones = $this->get_shipping_methods_and_zones();
		$method_ids = array_merge(array('default'), array_keys($shipping_methods_and_zones));
		return $method_ids;
		
	}

	private function get_shipping_instances_to_zones() {
	
		$shipping_instances_to_zones = array();
	
		$shipping_methods_and_zones = $this->get_shipping_methods_and_zones();

		foreach ($shipping_methods_and_zones as $method_id => $method) {
			if (is_array($method['zones'])) {
				foreach ($method['zones'] as $zone_id => $instance_ids) {
					foreach ($instance_ids as $instance_id) {
						$shipping_instances_to_zones[$instance_id] = $zone_id;
					}
				}
			}
		}
		
		return $shipping_instances_to_zones;
	}
	
	private function get_shipping_method_title_from_id($shipping_method_id, $instance_id = false) {
		$shipping_methods_and_zones = $this->get_shipping_methods_and_zones();
		$woocommerce = WC();
		$instances_to_zones = $this->get_shipping_instances_to_zones();
		
		$title = isset($shipping_methods_and_zones[$shipping_method_id]) ? $shipping_methods_and_zones[$shipping_method_id]['method_object']->title : false;
		
		if (!$instance_id || version_compare($woocommerce->version, '2.6', '<') || empty($instances_to_zones[$instance_id])) {
			return $title;
		}
		
		if (!class_exists('WC_Shipping_Zone')) {
			if ($this->debug_mode) error_log("Opening hours: WC_Shipping_Zone class needed loading");
			require_once($woocommerce->plugin_path() . '/includes/class-wc-shipping-zone.php');
		}
		
		$zone = new WC_Shipping_Zone($instances_to_zones[$instance_id]);
		$methods = $zone->get_shipping_methods(false);

		if (!isset($methods[$instance_id])) return $title;

		$title = $methods[$instance_id]->title;
		if ('' == $title && isset($methods[$instance_id]->method_title)) $title = $methods[$instance_id]->method_title;
		return $title;

	}

	public function ajax_backend() {

		if (empty($_POST) || empty($_POST['subaction']) || !isset($_POST['_wpnonce']) || !wp_verify_nonce($_POST['_wpnonce'], 'wc_minmax_nonce')) die('Security check');

		if ('savesettings' == $_POST['subaction']) {

			if (empty($_POST['settings']) || !is_string($_POST['settings'])) die;

			parse_str($_POST['settings'], $posted_settings);

			$any_found = false;
			$parsed_settings = array();

			// Save settings
			if (!is_array($posted_settings)) $posted_settings = array();

			foreach ($posted_settings as $key => $setting) {

				if (0 !== strpos($key, 'wcminmax_')) continue;

				$value = null;

				$type = 'text';
				if ($key == 'wcminmax_message') $type = 'textarea';

				switch ($type) {
					case 'text';
					case 'radio';
					case 'select';
					$value = $setting;
					break;
					case 'textarea';
						if (is_string($setting)) {
							$value = wp_kses_post( trim( $setting ) );
						} elseif (is_array($setting)) {
							$value = array();
							foreach ($setting as $k => $v) {
								$value[$k] = stripslashes(wp_kses_post( trim( $v ) ));
							}
						}
					break;
					case 'checkbox';
					$value = empty($setting) ? 'no' : 'yes';
					break;
				}

				if (!is_null($value)) {
					$any_found = true;
					// Remove wcminmax_
					$save_key = substr($key, 9);
					$parsed_settings[$save_key] = $value;
				}

			}

			if (!$any_found) {
				echo json_encode(array('result' => 'no options found'));
				die;
			}

			$parsed_settings['last_saved_on'] = self::OUR_VERSION;
			$parsed_settings['last_wc_saved_on'] = WC()->version;
			
			update_option(self::OPTION_NAME, $parsed_settings);

			echo json_encode(array('result' => 'ok'));
		}

		die;

	}

	// When doing this for the front-end, we remove inactive settings
	private function get_settings($for_frontend = true) {
		$settings = get_option(self::OPTION_NAME, array());
		if (isset($settings['activate']) && $for_frontend) {
			$replace_keys = array('minamount', 'maxamount', 'comparewith', 'minitems', 'maxitems', 'message');
			foreach ($settings['activate'] as $shipping_method => $status) {
				if ($status || 'default' == $shipping_method) continue;
				foreach ($replace_keys as $key) {
					$settings[$key][$shipping_method] = $settings[$key]['default'];
				}
			}
		}
		return apply_filters('woocommerce_minima_maxima_settings', $settings, $for_frontend);
	}

	private function get_reversed_settings($for_frontend = true) {
		$settings = $this->get_settings($for_frontend);
		if (!is_array($settings)) $settings = array();
		$reversed = array();
		foreach ($settings as $key => $value) {
			if (is_array($value)) {
				foreach ($value as $k => $v) {
					$reversed[$k][$key] = $v;
				}
			}
		}
		return apply_filters('woocommerce_minima_maxima_reversed_settings', $reversed, $for_frontend);
	}

	public function settings_page() {

		$settings = $this->get_settings(false);

		if (!is_array($settings)) $settings = array();

		?>

		<h1><?php echo __('Minimum / Maximum Purchase Rules', 'wc_minima_and_maxima').' '.__('for WooCommerce', 'wc_minima_and_maxima');?></h1>
		<a href="<?php echo apply_filters('wcminandmax_support_url', 'https://www.simbahosting.co.uk/s3/support/tickets/');?>"><?php _e('Support', 'wc_minima_and_maxima');?></a> | 
		<a href="https://www.simbahosting.co.uk/s3/shop/"><?php _e('More plugins', 'wc_minima_and_maxima');?></a> |
		<a href="https://updraftplus.com">UpdraftPlus WordPress Backups</a> | 
		<a href="http://david.dw-perspective.org.uk"><?php _e("Lead developer's homepage",'wc_minima_and_maxima');?></a>
		- <?php _e('Version','wc_minima_and_maxima');?>: <?php echo self::OUR_VERSION; ?>
		<br>

		<div id="wcminandmax_settings_contents" style="margin: 14px 0px; max-width: 1000px;">

		<h3><?php _e('Global settings', 'wc_minima_and_maxima');?></h3>

		<table>
			<tr valign="top">
				<th scope="row" class="titledesc" style="width: 180px; text-align:left;">
					<?php _e('Relevant shipping classes', 'wc_minima_and_maxima');?>
				</th>
				<td class="forminp">
				<?php

					$woocommerce = WC();
					$wc_shipping = $woocommerce->shipping();
					$classes = $wc_shipping->get_shipping_classes();
					$relevant_classes = (!empty($settings['shippingclasses'])) ? $settings['shippingclasses'] : array();
					if (empty($classes) || !is_array($classes)) {
						echo '<em>'.__('There are no shipping classes; so there is nothing to set here.', 'wc_minima_and_maxima').'</em>';
					} else {
						foreach ($classes as $class) {
							if (!is_object($class) || empty($class->term_id) || empty($class->name)) continue;
							echo '<input'.((in_array($class->term_id, $relevant_classes)) ? ' checked="checked"' : '').' type="checkbox" name="wcminmax_shippingclasses[]" id="wcminmax_shippingclass_'.$class->term_id.'" value="'.$class->term_id.'"><span class="wcminmax_shippingclass" title="'.esc_attr($class->description).'"><label for="wcminmax_shippingclass_'.$class->term_id.'">'.htmlspecialchars($class->name).'</label></span> ';
						}
					}
				?>
				<br>
				<em><?php
					echo '<p>'.htmlspecialchars(__("If you select any shipping classes here then only items in those shipping classes will be counted when comparing the customer's cart with your chosen limits.", 'wc_minima_and_maxima')).' '.__("If you do not choose any, then there will not be any restrictions on what is counted based upon the shipping class.", 'wc_minima_and_maxima').' <a href="'.admin_url('edit-tags.php?taxonomy=product_cat&post_type=product').'">'.__('You can also exclude items from specific categories by editing those categories.', 'wc_minima_and_maxima').'</a></p>';
				?></em>
				</td>
			</tr>

			<tr valign="top">
				<th scope="row" class="titledesc" style="width: 180px; text-align:left;">
					<?php _e('Allow carts entirely of excluded items', 'wc_minima_and_maxima');?>
				</th>
				<td class="forminp">
					<input type="checkbox" value="1" name="wcminmax_allowallexcluded" id="wcminmax_allowallexcluded" <?php if (!empty($settings['allow_all_excluded'])) echo ' checked="checked"';?>>
				<?php
				?>
				<br>
				<em><?php
					echo '<p>'.htmlspecialchars(__("Check this to allow customers to check out if they have carts that are entirely comprised of items excluded (whether because of a category exclusion, or a shipping class exclusion).", 'wc_minima_and_maxima').' '.__('Otherwise, any minimum purchase criteria will still apply.', 'wc_minima_and_maxima')).'</a></p>';
				?></em>
				</td>
			</tr>

		</table>

		<h3><?php _e('Minimum and maximum quantities and amounts', 'wc_minima_and_maxima');?></h3>
		
		<em><?php _e('You can set a default set of rules, and over-ride those rules for individual shipping methods (e.g. different minimum order when delivering).', 'wc_minima_and_maxima');?></em>

		<div id="wcminmax-rules">

			<?php
			echo '<h2 class="nav-tab-wrapper" id="wcminmax-shipping-methods" style="margin: 14px 0px;">';
			$on_first = true;
			?>
				<a class="nav-tab <?php if ($on_first) { echo 'nav-tab-active'; $on_first = false; } ?>" href="#wcminmax-shipping-methods-navtab-default-content" id="wcminmax-shipping-methods-navtab-default"><?php echo htmlspecialchars(__('Default', 'wc_minima_and_maxima'));?></a>
			<?php
			
			$shipping_methods = $this->get_shipping_methods_and_zones();
			
			if (!empty($shipping_methods)) {
			
				foreach ($shipping_methods as $method_id => $method) {
				
					if (empty($method['zones'])) {
				
						// Do not show tab	s for instance-supporting shipping methods which have no instances
							if (!isset($method['method_object']) || !is_object($method['method_object']) || !isset($method['method_object']->supports) || !is_array($method['method_object']->supports) || !in_array('instance-settings', $method['method_object']->supports)) {
				
						?>
							<a class="nav-tab <?php if ($on_first) { echo 'nav-tab-active'; $on_first = false; } ?>" href="#wcminmax-shipping-methods-navtab-<?php echo $method_id;?>-content" id="wcminmax-shipping-methods-navtab-<?php echo $method_id;?>"><?php echo htmlspecialchars($method['method_object']->title);?></a>
						<?php
					
						}
					
					
					} else {
					
						$shipping_zone_labels = $this->get_shipping_zone_labels();

						foreach ($method['zones'] as $zone_id => $instance_ids) {
						
							foreach ($instance_ids as $instance_id) {
						
								$full_method_id = $method_id.'__I-'.$instance_id;
								$method_title = $method['method_object']->title;
								if ('' == $method_title && isset($method['method_object']->method_title) && '' != $method['method_object']->method_title) $method_title = $method['method_object']->method_title;
							
								?>
								<a class="nav-tab <?php if ($on_first) { echo 'nav-tab-active'; $on_first = false; } ?>" href="#wcminmax-shipping-methods-navtab-<?php echo $full_method_id;?>-content" id="wcminmax-shipping-methods-navtab-<?php echo $full_method_id;?>"><?php echo htmlspecialchars($this->get_shipping_method_title_from_id($method_id, $instance_id).' ('.$shipping_zone_labels[$zone_id].', '.$method_title.')');?></a>
								<?php
								
							}
						
						}
					
					}
				}
			}
			echo '</h2>';

			$on_first = true;

			echo "<div class=\"wcminmax-shipping-methods-navtab-content\" id=\"wcminmax-shipping-methods-navtab-default-content\"";
			if (!$on_first) { echo ' style="display:none;"'; } else { $on_first = false; }
			echo ">";

			$this->print_rules_section('default', $settings);
			echo "</div>";

			if (!empty($shipping_methods)) {
				$on_first = false;
				foreach ($shipping_methods as $method_id => $method) {

					$method_title = $method['method_object']->title;
				
					if (empty($method['zones'])) {
				
						echo "<div class=\"wcminmax-shipping-methods-navtab-content\" id=\"wcminmax-shipping-methods-navtab-".$method_id."-content\"";
						if (!$on_first) { echo ' style="display:none;"'; } else { $on_first = false; }
						echo ">";

						echo "<p>".sprintf(__('These settings will be used when this shipping method (%s) is selected.', 'wc_minima_and_maxima'), htmlspecialchars($method_title))."</p>";

						$this->print_rules_section($method_id, $settings);

						echo "</div>";
					} else {
					
						foreach ($method['zones'] as $zone_id => $instance_ids) {
						
							foreach ($instance_ids as $instance_id) {
								$full_method_id = $method_id.'__I-'.$instance_id;
								
								echo "<div class=\"wcminmax-shipping-methods-navtab-content\" id=\"wcminmax-shipping-methods-navtab-".$full_method_id."-content\"";
								if (!$on_first) { echo ' style="display:none;"'; } else { $on_first = false; }
								echo ">";

								echo "<p>".sprintf(__('These settings will be used when this shipping method (%s) is selected.', 'wc_minima_and_maxima'), htmlspecialchars($this->get_shipping_method_title_from_id($method_id, $instance_id).' ('.$shipping_zone_labels[$zone_id].', '.$method_title.')'))."</p>";

								$this->print_rules_section($method_id, $settings, $instance_id);
								
								echo "</div>";
							}
						}
					
					}
				}

			}
			?>
		</div>

		<?php

		echo '<button style="margin-top: 20px;" id="wc_minmax_settings_save" class="button button-primary">'.__('Save Settings', 'woocommerce-minima-and-maxima').'</button>';

		echo '</div>';

		$this->admin_javascript();

	}

	private function format_price($price, $decimals = false, $currency_symbol = false) {
		if (false === $decimals) $decimals = function_exists('wc_get_price_decimals') ? wc_get_price_decimals() : absint( get_option( 'woocommerce_price_num_decimals', 2 ) );
		if (false === $currency_symbol) $currency_symbol = get_woocommerce_currency_symbol();
		return ($decimals > 0) ? $currency_symbol.' '.sprintf("%0.".$decimals."f", $price) : $currency_symbol.' '.$price;
	}

	private function print_rules_section($method_id, $settings, $instance_id = null) {

		if ('default' == $method_id) echo '<p>'.__('These rules will be used when no shipping method is selected (including on stores which do not have shipping).', 'woocommerce-minima-and-maxima').'</p>';

		$decimals = function_exists('wc_get_price_decimals') ? wc_get_price_decimals() : absint( get_option( 'woocommerce_price_num_decimals', 2 ) );
/*
		$step = ($decimals > 0) ? 1/(pow(10, $decimals)) : 1;

		$pattern = ($decimals > 0 ) ? "^\d+(\.)\d{".$decimals.'}$' : '^\d+$';*/

		$currency_symbol = get_woocommerce_currency_symbol();

		$this->print_rules_section_engine($method_id, $settings, $decimals, $currency_symbol, $instance_id);
	}

	// This is abstracted to help handle the transition to zones
	private function get_setting_for_key($shipping_method_id, $instance_id, $setting_key, $settings, $default = '') {
	
		if (is_null($instance_id)) {
			// No instance: return the default
			return isset($settings[$setting_key][$shipping_method_id]) ? $settings[$setting_key][$shipping_method_id] : $default;
		}
		
		$full_method_id = $shipping_method_id.'__I-'.$instance_id;
		if (!isset($settings[$setting_key][$full_method_id])) {
			// No instance key: return the default
			return isset($settings[$setting_key][$shipping_method_id]) ? $settings[$setting_key][$shipping_method_id] : $default;
		}
		
		// Zone key exists: return the value
		return $settings[$setting_key][$full_method_id];
		
	}
	
	public function print_rules_section_engine($shipping_method_id, $settings, $decimals, $currency_prefix, $instance_id = null) {
	
		if (!is_array($settings)) $settings = array();

		$min_amount = $this->get_setting_for_key($shipping_method_id, $instance_id, 'minamount', $settings);
		$min_items = $this->get_setting_for_key($shipping_method_id, $instance_id, 'minitems', $settings);
		$max_amount = $this->get_setting_for_key($shipping_method_id, $instance_id, 'maxamount', $settings);
		$max_items = $this->get_setting_for_key($shipping_method_id, $instance_id, 'maxitems', $settings);
		$error_text = $this->get_setting_for_key($shipping_method_id, $instance_id, 'message', $settings);
		$activate = ('default' !== $shipping_method_id) ? $this->get_setting_for_key($shipping_method_id, $instance_id, 'activate', $settings) : '';

		$amounts_comparewith = $this->get_setting_for_key($shipping_method_id, $instance_id, 'comparewith', $settings, 'items_total');

		$full_method_id = is_null($instance_id) ? $shipping_method_id : $shipping_method_id.'__I-'.$instance_id;
		
		?>
		<div id="wcminmax-rules-<?php echo $full_method_id;?>" class="wcminmax-rules">

			<?php do_action('wcminmax_print_rules_section_before', $shipping_method_id, $instance_id); ?>

			<table>

				<tr valign="top">
<!-- 					<th scope="row" class="titledesc"></th> -->
					<td class="wc_minmax_extrainfo" style="color:red; font-weight:bold;" colspan="2">
					<div style="float:left;clear:left;" class="wc_minmax_extrainfo1"></div>
					<div style="float:left;clear:left;" class="wc_minmax_extrainfo2"></div>
					</td>
				</tr>

				<?php if ('default' != $shipping_method_id) { ?>
				<tr valign="top">
					<th scope="row" class="titledesc" style="text-align:right;">
						<label for="wcminmax_activate_<?php echo $full_method_id;?>"><?php _e('Activate rules', 'wc_minima_and_maxima');?></label>
					</th>
					<td class="forminp forminp-number">
						<input name="wcminmax_activate[<?php echo $full_method_id;?>]" id="wcminmax_activate_<?php echo $full_method_id;?>" type="checkbox" value="1" <?php if ($activate) echo ' checked="checked"';?> class="wcminmax_activate"> <span style="margin-top: 2px;"></span>
						<br>
						<em><?php
							echo htmlspecialchars(__('Tick this checkbox for these rules to take effect - otherwise, default rules will be used.', 'wc_minima_and_maxima'));
						?></em>
					</td>
				</tr>
				<?php } ?>

				<tr valign="top">
					<th scope="row" class="titledesc" style="text-align:right;">
						<label for="wcminmax_minamount_<?php echo $full_method_id;?>"><?php _e('Minimum order', 'wc_minima_and_maxima');?></label>
					</th>
					<td class="forminp forminp-number">
						<?php echo $currency_prefix; ?> <input name="wcminmax_minamount[<?php echo $full_method_id;?>]" id="wcminmax_minamount_<?php echo $full_method_id;?>" type="text" style="width:64px;" value="<?php echo esc_attr($min_amount); ?>" class="wcminmax_minamount"> <span style="margin-top: 2px;"></span>
						<br>
						<em><?php
							echo htmlspecialchars(__('Enter the minimum order amount for a customer to be allowed to check-out. Leave blank for no minimum.', 'wc_minima_and_maxima'));
						?></em>
					</td>
				</tr>

				<tr valign="top">
					<th scope="row" class="titledesc" style="text-align:right;">
						<label for="wcminmax_maxamount_<?php echo $full_method_id;?>"><?php _e('Maximum order', 'wc_minima_and_maxima');?></label>
					</th>
					<td class="forminp forminp-number">
						<?php echo $currency_prefix; ?> <input name="wcminmax_maxamount[<?php echo $full_method_id;?>]" id="wcminmax_maxamount_<?php echo $full_method_id;?>" type="text" style="width:64px;" value="<?php echo esc_attr($max_amount); ?>" class="wcminmax_maxamount"> <span style="margin-top: 2px;"></span>
						<br>
						<em><?php
							echo htmlspecialchars(__('Enter the maximum order amount for a customer to be allowed to check-out. Leave blank for no maximum.', 'wc_minima_and_maxima'));
						?></em>
					</td>
				</tr>

				<tr valign="top">
					<th scope="row" class="titledesc" style="text-align:right;">
						<label for="wcminmax_comparewith_<?php echo $full_method_id;?>"><?php _e('Compare with', 'wc_minima_and_maxima');?></label>
					</th>
					<td class="forminp">
						<select name="wcminmax_comparewith[<?php echo $full_method_id;?>]" id="wcminmax_comparewith_<?php echo $full_method_id;?>" class="wcminmax_comparewith">
							<?php
								$options = array(
									'items_total' => __('Total of line items (before taxes and discounts)', 'wc_minima_and_maxima'),
									'items_total_d' => __('Total of line items (excluding taxes, including line item discounts)', 'wc_minima_and_maxima'),
									'items_total_t' => __('Total of line items (including taxes, excluding line item discounts)', 'wc_minima_and_maxima'),
									'items_total_dt' => __('Total of line items (including taxes, including line item discounts)', 'wc_minima_and_maxima'),
								);
								// If we allow the cart total to be compared, then this renders the settings for excluding specific items void.
// 									'cart_total' => __('Final cart total (including taxes, shipping, discounts)', 'wc_minima_and_maxima'),
								foreach ($options as $opt_k => $text) {
									echo '<option value="'.$opt_k.'"';
									if ($amounts_comparewith == $opt_k) echo ' selected="selected"';
									echo '>'.htmlspecialchars($text).'</option>';
								}
							?>
						</select>
						<br>
						<em><?php
							echo htmlspecialchars(__('Decide whether tax should be included in the total when comparing it with your chosen min/max order amounts.', 'wc_minima_and_maxima'));
						?></em>
					</td>
				</tr>

				<tr valign="top">
					<th scope="row" class="titledesc" style="text-align:right;">
						<label for="wcminmax_minitems_<?php echo $full_method_id;?>"><?php _e('Minimum items', 'wc_minima_and_maxima');?></label>
					</th>
					<td class="forminp forminp-number">
						<input name="wcminmax_minitems[<?php echo $full_method_id;?>]" id="wcminmax_minitems_<?php echo $full_method_id;?>" type="number" min="0" step="1" style="width:64px;" value="<?php echo esc_attr($min_items); ?>" class="wcminmax_minitems"> <span style="margin-top: 2px;"></span>
						<br>
						<em><?php
							echo htmlspecialchars(__('Enter the minimum order items for a customer to be allowed to check-out. Leave blank for no minimum.', 'wc_minima_and_maxima'));
						?></em>
					</td>
				</tr>

				<tr valign="top">
					<th scope="row" class="titledesc" style="text-align:right;">
						<label for="wcminmax_maxitems_<?php echo $full_method_id;?>"><?php _e('Maximum items', 'wc_minima_and_maxima');?></label>
					</th>
					<td class="forminp forminp-number">
						<input name="wcminmax_maxitems[<?php echo $full_method_id;?>]" id="wcminmax_maxitems_<?php echo $full_method_id;?>" type="number" min="0" step="1" style="width:64px;" value="<?php echo esc_attr($max_items); ?>" class="wcminmax_maxitems"> <span style="margin-top: 2px;"></span>
						<br>
						<em><?php
							echo htmlspecialchars(__('Enter the maximum order items for a customer to be allowed to check-out. Leave blank for no maximum.', 'wc_minima_and_maxima'));
						?></em>
					</td>
				</tr>

				<tr valign="top">
					<th scope="row" class="titledesc" style="text-align:right;">
						<label for="wcminmax_message_<?php echo $full_method_id;?>"><?php _e('Customer message', 'wc_minima_and_maxima');?></label>
					</th>
					<td class="input-text">
						<textarea style="width:100%;" name="wcminmax_message[<?php echo $full_method_id;?>]"><?php echo htmlspecialchars($error_text); ?></textarea>
						<br>
						<em><?php
							echo htmlspecialchars(__('Message to display if the shopper does not meet the criteria.', 'wc_minima_and_maxima', 'wc_minima_and_maxima').' '.__('If none is entered, then a default will be used.', 'wc_minima_and_maxima'));
						?></em>
					</td>
				</tr>

			</table>

			<?php do_action('wcminmax_print_rules_section_after', $shipping_method_id, $full_method_id); ?>

		</div>
		<?php
	}

	private function admin_javascript() {

		$enqueue_version = @constant('WP_DEBUG') ? self::OUR_VERSION.'.'.time() : self::OUR_VERSION;
	
		wp_enqueue_script('wcminmax-admin-js', $this->oururl.'/js/admin.js', array('jquery'), $enqueue_version);

		$localize = array(
			'nonce' => wp_create_nonce("wc_minmax_nonce"),
			'response' => __('Response:', 'woocommerce-minima-and-maxima'),
			'unsavedsettings' => __('You have unsaved settings.', 'woocommerce-minima-and-maxima'),
			'minamountgreaterthanmax' => __('Your chosen minimum order amount is greater than your maximum.', 'woocommerce-minima-and-maxima'),
			'minitemsgreaterthanmax' => __('Your chosen minimum order items is greater than your maximum.', 'woocommerce-minima-and-maxima'),
			'saving' => __('Saving...', 'woocommerce-minima-and-maxima'),
		);

		wp_localize_script( 'wcminmax-admin-js', 'wcminmaxadminlion', $localize);

	}

}

$wc_minima_and_maxima = new WC_Minima_And_Maxima();
