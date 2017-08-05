<?php

namespace Click_And_Pick\Front\Checkout;

use Click_And_Pick\Click_And_Pick;
use Click_And_Pick\Helpers\Helper;

/**
 * Class Checkout
 * @package Click_And_Pick\Front\Checkout
 */
class Checkout
{

    /**
     * @var Helper
     */
    private $helper;

    /**
     * Construction
     */
    public function __construct()
    {
        $this->helper = new Helper();
        add_action('wp_enqueue_scripts', [$this, 'include_scripts']);
        // Used to add an action for the shipping review order area
        add_action('woocommerce_after_template_part', [$this, 'add_click_and_pick_html'], 10, 4);
        add_action('woocommerce_add_shipping_order_item', [$this, 'save_click_and_pick_fields'], 13, 3);
        add_action('woocommerce_admin_order_data_after_shipping_address', [
            $this,
            'adding_click_and_pick_details',
        ]);


    }


    /**
     * @param $template_name
     * @param $template_path
     * @param $located
     * @param $args
     */
    public function add_click_and_pick_html($template_name, $template_path, $located, $args)
    {

        if ('cart/cart-shipping.php' == $template_name && Click_And_Pick::TEXTDOMAIN . "_shipping_method" == $args['chosen_method'] && (is_checkout() || (defined('DOING_AJAX') && isset($_REQUEST['action']) && 'woocommerce_update_order_review' == $_REQUEST['action']))
        ) {
            require_once plugin_dir_path(__FILE__) . 'html.php';
        }
    }


    /**
     * include the scripts
     */
    public function include_scripts()
    {
        // Scripts
        wp_enqueue_script('datetime-picker-js', plugins_url('../assets/js/jquery.datetimepicker.js', __FILE__), [
            'jquery',
            'jquery-ui-core',
            'jquery-ui-dialog',
            'jquery-ui-sortable',
        ]);
        wp_enqueue_script('google-map', 'https://maps.google.com/maps/api/js?sensor=true', [], null);
        wp_enqueue_script('gmaps-script', plugins_url('../assets/js/gmaps.js', __FILE__));
        //wp_enqueue_script( 'custom_style_checkout', plugins_url( '../assets/js/custom.js', __FILE__ ) );


        // Styling
        wp_enqueue_style('datetime_picker_css', plugins_url('../assets/css/jquery.datetimepicker.css', __FILE__));
        wp_enqueue_style('jquery-ui-css', '//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css');
        wp_enqueue_style('custom_style_checkout', plugins_url('../assets/css/custom.css', __FILE__));
    }


    /**
     * @param $order_id
     * @param $shipping_item_id
     * @param $package_index
     * Save the selected branch and time for picking
     */
    public function save_click_and_pick_fields($order_id, $shipping_item_id, $package_index)
    {
	    $textInput = sanitize_text_field($_POST['click_n_pick_branch']);

	    if (isset($textInput)) {
            $branch_id = $textInput;
            if ( ! empty($textInput) && ! empty($_POST["click_n_pick_picked_time_$branch_id"])) {
                update_post_meta($order_id, 'click_n_pick_branch', $textInput);
                update_post_meta($order_id, 'click_n_pick_picked_time', $_POST["click_n_pick_picked_time_$branch_id"]);
            }
        }

    }

    /**
     * Include the click and pick details in the order page
     *
     * @param $order
     */
    public function adding_click_and_pick_details($order)
    {
        /** @var object $order */
        if ($this->helper->check_for_click_and_pick($order->id)) {
            require_once plugin_dir_path(__FILE__) . 'order-details-html.php';
        }
    }


}
