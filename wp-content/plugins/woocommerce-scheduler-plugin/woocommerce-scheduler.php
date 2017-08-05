<?php
/**
 * Plugin Name: WooCommerce Scheduler
 * Plugin URI: http://wisdmlabs.com/woocommerce-scheduler-plugin-for-product-availability
 * Description: This extension plugin allows you to schedule product purchase availability in your WooCommerce store.
 * Author: WisdmLabs
 * Version: 2.0.3
 * Author URI: http://wisdmlabs.com
 * License: GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       woocommerce_scheduler
 * Domain Path:       /languages
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Set the plugin slug as default text domain.
 */
define('WDM_WOO_SCHED_TXT_DOMAIN', 'woocommerce_scheduler');

add_action('plugins_loaded', 'wdmwooschedLoadTextDomain');

/**
 * Function wdmldgroupLoadTextDomain() to load plugins text domain.
 */
function wdmwooschedLoadTextDomain()
{
    load_plugin_textdomain(WDM_WOO_SCHED_TXT_DOMAIN, false, plugin_basename(dirname(__FILE__)).'/languages');
}

global $wdm_plugin_data;

$wdm_plugin_data = array(
    'plugin_short_name' => __('WooCommerce Scheduler', WDM_WOO_SCHED_TXT_DOMAIN),
    'plugin_slug' => 'woocommerce_scheduler',
    'plugin_version' => '2.0.3',
    'plugin_name' => __('WooCommerce Scheduler', WDM_WOO_SCHED_TXT_DOMAIN),
    'store_url' => 'https://wisdmlabs.com/check-update',
    'author_name' => __('WisdmLabs', WDM_WOO_SCHED_TXT_DOMAIN),
);


/*
 * Check woocommerce plugin is active or not
 */
if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
    include_once('includes/class-wdm-wusp-add-data-in-db.php');
    new WdmWuspAddData\WdmWuspAddDataInDB($wdm_plugin_data);


    include_once 'includes/class-wdm-scheduler-install.php';
    $scheduler_install = new SchedulerInstall();
    register_activation_hook(__FILE__, array($scheduler_install, 'wdmProductExpiration'));
    register_activation_hook(__FILE__, array($scheduler_install, 'wooScheduleCreateTables'));

    include_once('includes/class-wdm-wusp-get-data.php');
    $getDataFromDB = WdmWooSchedulerWuspGetData\WdmWuspGetData::getDataFromDB($wdm_plugin_data);

    if ($getDataFromDB == 'available') {
        //include single view

            include_once 'includes/woo-schedule-single-view.php';

        $woo_single_view = new WooScheduleSingleView\WooScheduleSingleView($wdm_plugin_data['plugin_slug'], $wdm_plugin_data['plugin_version']);

        add_action('admin_menu', array($woo_single_view, 'registerSingleViewSubmenuPage'));

        include_once 'includes/woo-schedule-ajax.php';

        $WooScheduleAjax = new WooScheduleAjax\WooScheduleAjax($wdm_plugin_data['plugin_slug'], $wdm_plugin_data['plugin_version']);

        include_once 'includes/woo-schedule-functions.php';
        include_once 'includes/class-scheduler-admin.php';
        include_once 'includes/woo-expiration-setting.php';


            /**
         * Check date validation.
         *
         * @param [type] $product_id   product ID
         * @param string $product_type Product type
         *
         * @return [type] [description]
         */
        function wdmCheckDateValidation($product_id, $product_type = 'simple')
        {
            $curr_time = current_time('H:i:s');
            $curr_date = date('m/d/Y');
            $curr_day = date('l');
            $wdm_start_date = get_post_meta($product_id, 'wdm_start_date', true);
            $wdm_end_date = get_post_meta($product_id, 'wdm_end_date', true);
            $subtype = get_option('woocommerce_custom_product_expiration_type');
            if (empty($subtype)) {
                $subtype = 'per_day';
            }
            if (empty($wdm_start_date) || empty($wdm_end_date)) {
                if ($product_type == 'simple') {
                    return woo_schedule_check_category_availability($product_id);
                } else {
                    $parent_id = wp_get_post_parent_id($product_id);

                    return woo_schedule_check_category_availability($parent_id);
                }
            } else {
                //For Start time and End time
                $wdm_start_time_hr = get_post_meta($product_id, 'wdm_start_time_hr', true);
                $wdm_end_time_hr = get_post_meta($product_id, 'wdm_end_time_hr', true);
                $wdm_start_time_min = get_post_meta($product_id, 'wdm_start_time_min', true);
                $wdm_end_time_min = get_post_meta($product_id, 'wdm_end_time_min', true);

                if (!empty($wdm_start_time_hr) && !empty($wdm_start_time_min)) {
                    $wdm_start_time = $wdm_start_time_hr.':'.$wdm_start_time_min;
                } else {
                    $wdm_start_time = '00:00';
                }

                if (!empty($wdm_end_time_hr) && !empty($wdm_end_time_min)) {
                    $wdm_end_time = $wdm_end_time_hr.':'.$wdm_end_time_min;
                } else {
                    $wdm_end_time = '23:59';
                }

                if ($subtype == 'per_day') {
                    $options = get_post_meta($product_id, 'wdm_days_selected', true);
                    if (((strtotime($curr_date) >= strtotime($wdm_start_date)) && (strtotime($curr_date) <= strtotime($wdm_end_date)))  &&
                     ((strtotime($curr_time) >= strtotime($wdm_start_time)) && (strtotime($curr_time) <= strtotime($wdm_end_time))) &&
                     (isset($options) && isset($options[$curr_day]))) {
                        return true;
                    } else {
                        return false;
                    }
                } else {
                    if ((strtotime($curr_date.' '.$curr_time) >= strtotime($wdm_start_date." $wdm_start_time")) && (strtotime($curr_date.' '.$curr_time) <= strtotime($wdm_end_date." $wdm_end_time"))) {
                        return true;
                    } else {
                        return false;
                    }
                }
            }
        }

            /**
         * clear scheduled cron event on plugin deactivation.
         *
         * @return [type] [description]
         */
        function wdmCronDecaller()
        {
            wp_clear_scheduled_hook('update_product_status');
        }

        register_deactivation_hook(__FILE__, 'wdmCronDecaller');

            /**
         * enqueue admin side scripts.
         *
         * @return [type] [description]
         */
        function wdmEnqueueScripts($hook)
        {
            if ('post.php' == $hook || 'product_page_woo-schedule-single-view' == $hook || 'post-new.php' == $hook) {
                wp_register_script('wdm_moment_js_handler', plugins_url('/js/moment.js', __FILE__), array('jquery'));
                wp_enqueue_script('wdm_moment_js_handler');

                wp_register_script('wdm_datepicker', plugins_url('/js/bootstrap-datetimepicker.js', __FILE__), array('wdm_moment_js_handler'));
                wp_enqueue_script('wdm_datepicker');

                $url = plugins_url('/js/wdm_chk_date_time.js', __FILE__);
                wp_enqueue_script('chk-date-time', $url, array('wdm_datepicker'), true);
                $subtype = get_option('woocommerce_custom_product_expiration_type');
                wp_localize_script(
                    'chk-date-time',
                    'scheduler_option',
                    array(
                        'option'=>$subtype,
                        'err_start_date_limit' => __('End date must be greater than start date', WDM_WOO_SCHED_TXT_DOMAIN),
                        'err_start_time_limit' => __('End time must be greater than start time', WDM_WOO_SCHED_TXT_DOMAIN),
                        'err_time_limit' => __('Start time must be greater than current time', WDM_WOO_SCHED_TXT_DOMAIN),
                    )
                );


                wp_register_style('wdm_bootstrap_css', plugins_url('/css/wdm_bootstrap.css', __FILE__));
                wp_enqueue_style('wdm_bootstrap_css');

                wp_register_style('wdm_datepicker_css', plugins_url('/css/bootstrap-datetimepicker.min.css', __FILE__));
                wp_enqueue_style('wdm_datepicker_css');
            } else {
                wp_dequeue_script('wdm_moment_js_handler');
                wp_dequeue_script('wdm_datepicker');
                wp_dequeue_script('chk-date-time');
                wp_dequeue_style('wdm_bootstrap_css');
                wp_dequeue_style('wdm_datepicker_css');
                return;
            }
        }

        add_action('admin_enqueue_scripts', 'wdmEnqueueScripts', 10, 1);
    }
} else {
    add_action('admin_notices', 'schedularBasePluginInactiveNotice');
}

/**
 * Display Error message if woocommered plugin is not active.
 *
 * @return [type] [description]
 */
function schedularBasePluginInactiveNotice()
{
    global $wdm_plugin_data;
    ?>
     <div id="message" class="error">
       <p><?php printf(__('%s %s is inactive. %s Install and activate %sWoocommerce%s for %s to work.', WDM_WOO_SCHED_TXT_DOMAIN), '<strong>', $wdm_plugin_data['plugin_name'], '</strong>', '<a href="https://wordpress.org/plugins/woocommerce/">', '</a>', $wdm_plugin_data['plugin_name']);
    ?></p>
    </div>
    <?php
}


/**
 * This code checks if new version is available
*/
if (!class_exists('WdmWooSchedulerWuspPluginUpdater\WdmWuspPluginUpdater')) {
    include('includes/class-wdm-wusp-plugin-updater.php');
}

$l_key = trim(get_option('edd_' . $wdm_plugin_data['plugin_slug'] . '_license_key'));

    // setup the updater
    new WdmWooSchedulerWuspPluginUpdater\WdmWuspPluginUpdater($wdm_plugin_data['store_url'], __FILE__, array(
        'version' => $wdm_plugin_data['plugin_version'], // current version number
        'license' => $l_key, // license key (used get_option above to retrieve from DB)
        'item_name' => $wdm_plugin_data['plugin_name'], // name of this plugin
        'author' => $wdm_plugin_data['author_name'], //author of the plugin
    ));
