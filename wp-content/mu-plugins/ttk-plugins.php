<?php
/*
Plugin Name: TTK: Do not load plugins on request
Plugin URI: http://thetownkitchen.com/
Description: Prevent plugins from loading on pages (for page speed testing purposes)
Version: 1
Author: Gabriel Livan
Author URI: https://profiles.wordpress.org/gabelivan
*/
namespace TtkAccessParallaxPro;

/**
 * Class Plugins
 * @package TtkAccessParallaxPro
 */
class Plugins
{
    /**
     * Plugins constructor.
     */
    public function __construct()
    {
        add_filter('option_active_plugins', array($this, 'disableOnRequest'), 1);
        add_filter('option_active_plugins', array($this, 'manageOnHomePage'), 1);
    }

    /**
     * @param $plugins
     * @return mixed
     */
    public function disableOnRequest($plugins)
    {
        if (! isset($_GET['ttNoLoadPlugins'])) {
            return $plugins;
        }

        $ttNoLoadPlugins = trim(trim($_GET['ttNoLoadPlugins'], ','));

        if ($ttNoLoadPlugins === 'all') {
            return array();
        }

        // Multiple, separated by comma
        if (strpos($ttNoLoadPlugins, ',') !== false) {
            $noLoadPlugins = explode(',', $ttNoLoadPlugins);
        } else {
            // One
            $noLoadPlugins = array($ttNoLoadPlugins);
        }

        foreach ($noLoadPlugins as $noLoadPlugin) {
            $key = array_search($noLoadPlugin, $plugins);

            if (false !== $key) {
                unset($plugins[$key]);
            }
        }

        return $plugins;
    }

    /**
     * @param $plugins
     * @return array
     */
    public function manageOnHomePage($plugins)
    {
        $rUri = $_SERVER['REQUEST_URI'];

        $homeUriPaths = array('/', '/townkitchen/');

        $isHome = (in_array($rUri, $homeUriPaths));

        if (! $isHome) {
            $uriPath = parse_url($rUri, PHP_URL_PATH);
            $isHome = (in_array($uriPath, $homeUriPaths) && (! array_key_exists('p', $_GET)));
        }

        if ($isHome) {
            $olarkPlugin = 'olark-for-wp/olark-for-wp.php';
            $revSliderPlugin = 'revslider/revslider.php';

            $PO_disabled_plugins = get_option('PO_disabled_plugins');

            if (! empty($PO_disabled_plugins)) {
                foreach ($PO_disabled_plugins as $PO_disabled_plugin) {
                    if ($PO_disabled_plugin != $olarkPlugin) {
                        // Keep Olark for WP active
                        $disabledPluginKey = array_search($PO_disabled_plugin, $plugins);
                        unset($plugins[$disabledPluginKey]);
                    }
                }
            }

            // Do not load "Revolution Slider" on home page
            $revSliderKey = array_search($revSliderPlugin, $plugins);

            if ($revSliderKey !== false) {
                unset($plugins[$revSliderKey]);
            }

            $GLOBALS['PO_CACHED_PLUGIN_LIST'] = $plugins;
        }

        return $plugins;
    }
}

new Plugins();

/*
 * For reference only
 * Plugins loaded: 10th of April, 2017 - DEV
 *
 * Array
(
    [0] => better-search-replace/better-search-replace.php
    [1] => black-studio-tinymce-widget/black-studio-tinymce-widget.php
    [2] => codecanyon-6123531-woocommerce-orders-page-customiser/woocommerce-order-page-customiser.php
    [3] => contact-form-7/wp-contact-form-7.php
    [4] => flow-flow/flow-flow.php
    [5] => imagify/imagify.php
    [6] => jck_woo_deliveryslots/jck_woo_deliveryslots.php
    [7] => olark-for-wp/olark-for-wp.php
    [8] => plugin-organizer/plugin-organizer.php
    [9] => png-to-jpg/png-to-jpg.php
    [10] => pt-content-views-pro/content-views.php
    [11] => revslider/revslider.php
    [12] => rp-woo-donation/index.php
    [13] => siteorigin-panels/siteorigin-panels.php
    [14] => so-widgets-bundle/so-widgets-bundle.php
    [15] => updraftplus/updraftplus.php
    [16] => w3-total-cache/w3-total-cache.php
    [17] => widgets-for-siteorigin/widgets-for-siteorigin.php
    [18] => woocommerce-auto-category-thumbnails/woocommerce-auto-cat-thumbnails.php
    [19] => woocommerce-customizer/woocommerce-customizer.php
    [20] => woocommerce-gateway-stripe/woocommerce-gateway-stripe.php
    [21] => woocommerce-menu-bar-cart/wp-menu-cart.php
    [22] => woocommerce-menu-extension/woocommerce-menu-extension.php
    [23] => woocommerce-minima-and-maxima/woocommerce-minima-and-maxima.php
    [24] => woocommerce-pimpmywoo/pimpmywoo.php
    [25] => woocommerce-pincode-check-pro-unl-num/woocommerce-pincode-check.php
    [26] => woocommerce-status-actions/woocommerce-status-actions.php
    [27] => woocommerce/woocommerce.php
    [28] => woothemes-updater/woothemes-updater.php
    [29] => wp-asset-clean-up/wpacu.php
    [30] => wp-gallery-custom-links/wp-gallery-custom-links.php
    [31] => wp-sync-db/wp-sync-db.php
)
*/
