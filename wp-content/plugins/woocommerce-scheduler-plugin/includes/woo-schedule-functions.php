<?php

if (!function_exists('woo_schedule_update_term_details')) :
/*
* This update product category details
* @param $term_id  integer  Product category term id
* @param $start_date string   start date of schedule
* @param $end_date string end date of schedule
* @param $selected_days string serialized array/empty string of selected days
*
* @return $result integer/boolean returns no. of rows affected / false on failure
*/
    function woo_schedule_update_term_details($term_id, $start_date, $end_date, $selected_days)
    {
        global $wpdb;

        $table = $wpdb->prefix . 'woo_schedule_category';

        $result = '';

        if (woo_schedule_check_row_exists($term_id)) {
            $data = array('start_date' => $start_date, 'end_date' => $end_date, 'selected_days' => $selected_days);

            $where = array('term_id' => $term_id);

            $result = $wpdb->update($table, $data, $where);
        } else {
            $result = woo_schedule_insert_term_details($term_id, $start_date, $end_date, $selected_days);
        }

        return $result;
    }

endif;

if (!function_exists('woo_schedule_insert_term_details')) :
/*
* This inserts product category metas
* @param $term_id  integer  Product category term id
* @param $start_date string   start date of schedule
* @param $end_date string end date of schedule
* @param $selected_days string serialized array/empty string of selected days
*
* @return $result integer/boolean returns no. of rows affected / false on failure
*/

    function woo_schedule_insert_term_details($term_id, $start_date, $end_date, $selected_days)
    {
        global $wpdb;

        $table = $wpdb->prefix . 'woo_schedule_category';

        $data = array('term_id' => $term_id,'start_date' => $start_date, 'end_date' => $end_date, 'selected_days' => $selected_days);

        $result = $wpdb->insert($table, $data);

        return $result;
    }

endif;

if (!function_exists('woo_schedule_delete_term_details')) :
/*
* This delete all product category metas
* @param $term_id  integer/array  Product category term id
*
* @return $result integer/boolean returns no. of rows affected / false on failure
*/

    function woo_schedule_delete_term_details($term_id)
    {
        global $wpdb;

        if (empty($term_id)) {
            return false;
        }

        $table = $wpdb->prefix . 'woo_schedule_category';

        if (is_array($term_id)) {
            $term_id = implode(',', $term_id);
        }

        $where = array('term_id' => $term_id);

        $result = $wpdb->delete($table, $where);

        return $result;
    }

endif;

if (!function_exists('woo_schedule_check_row_exists')) :
/*
* This function checks whether $meta_key exists or not
* 
* @param $term_id  integer  Product category term id
*
* @return boolean 
*/
    function woo_schedule_check_row_exists($term_id)
    {
        global $wpdb;

        $table = $wpdb->prefix . 'woo_schedule_category';

        $query = "SELECT `term_id` FROM " . $table . " WHERE `term_id` = '{$term_id}'";

        $result = $wpdb->get_results($query);

        if (!empty($result)) {
            return true;
        } else {
            return false;
        }
    }

endif;

if (!function_exists('woo_schedule_check_category_availability')) :
/*
* It checks whether Product category has any schedule set
* and if setting is set then product available in that time period.
*
* @param $product_id integer Product ID
* @return boolean returns True - if product purchase is available otherwise false
*/
    function woo_schedule_check_category_availability($product_id)
    {
        global $wpdb;

        if (empty($product_id)) {
            return true;
        }

        $product_terms = wp_get_object_terms($product_id, 'product_cat', array('fields' => 'ids'));

        if (! empty($product_terms)) {
            if (! is_wp_error($product_terms)) {
                $current_date_time        = current_time('Y-m-d H:i:s');

                $query_term_exist = "SELECT COUNT( `term_id` ) as `count_term_id` FROM `" . $wpdb->prefix . "woo_schedule_category`
            WHERE `term_id` IN (" . implode(',', $product_terms) . ")";

                $check_term_exist = $wpdb->get_results($query_term_exist, ARRAY_A);

                if (!empty($check_term_exist) && isset($check_term_exist[0]['count_term_id']) && intval($check_term_exist[0]['count_term_id']) > 0) {
    /* Term record present
    * Need to check for product term setting
    */

                    $type            = get_option('woocommerce_custom_product_expiration_type');

                    if ($type == 'per_day') {
                        $availability_query = "SELECT COUNT( * ) AS  `total_record` 
                        FROM  `". $wpdb->prefix . "woo_schedule_category` 
                        WHERE STR_TO_DATE('" . $current_date_time . "', '%Y-%m-%d')
                        BETWEEN STR_TO_DATE( `start_date` , '%Y-%m-%d' ) 
                        AND STR_TO_DATE( `end_date` , '%Y-%m-%d' )
                        AND TIME('" . $current_date_time . "')
                        BETWEEN TIME(`start_date`)
                        AND TIME(`end_date`)
                        AND `term_id` IN (" . implode(',', $product_terms) . ") AND `selected_days` like '%" . date('l') . "%'";
                    } else {
                         $availability_query = "SELECT COUNT( * ) AS  `total_record` 
                            FROM  `". $wpdb->prefix . "woo_schedule_category` 
                            WHERE  '" . $current_date_time . "' 
                            BETWEEN DATE_FORMAT(  `start_date` ,  '%Y-%m-%d %H:%i:%s' ) 
                            AND DATE_FORMAT(  `end_date` ,  '%Y-%m-%d %H:%i:%s' )
                            AND `term_id` IN (" . implode(',', $product_terms) . ")";
                    }

                    //echo $availability_query;

                    $check_availability = $wpdb->get_results($availability_query, ARRAY_A);

                    if (!empty($check_availability) && isset($check_availability[0]['total_record']) && intval($check_availability[0]['total_record']) > 0) {
                    //Product is available

                        return true;
                    } else {
                    //Product is unavailable

                        return false;
                    }
                } else {
                //Term not present , therefore available by default

                    return true;
                }
            }
        }

        return true;
    }

endif;


add_filter('woocommerce_loop_add_to_cart_link', 'customWoocommerceProductAddToCartText', 10, 2);

/**
* Display Avalibility text
* @param  [type] $link    Add to cart link
* @param  [type] $product product data
* @return [type]          [description]
*/
function customWoocommerceProductAddToCartText($link, $product)
{
    $availability=true;
    $curr_prod = wc_get_product($product->id);

    if ($curr_prod->is_type('simple')) {
        $availability=wdmCheckDateValidation($product->id);
    }

    if (!$availability) {
        if (get_option('woocommerce_custom_product_shop_expiration') != "") {
            return "<p class='wdm_message'>" . apply_filters('wdm_expiration_message', get_option('woocommerce_custom_product_shop_expiration'), $curr_prod) . "</p>";
        } else {
            return "";
        }
    }
    return $link;
}

add_filter('woocommerce_locate_template', 'wdmChangeWooTemplatePath', 10, 3);
function wdmWooSchedulerPath()
{
    // gets the absolute path to this plugin directory
    return untrailingslashit(plugin_dir_path(dirname(__FILE__)));
}

function wdmChangeWooTemplatePath($template, $template_name, $template_path)
{
    global $woocommerce;
    $coreTemplate = $template;
    if (! $template_path) {
        $template_path = $woocommerce->template_url;
    }
    $plugin_path  = wdmWooSchedulerPath() . '/woocommerce/';

    // Look within passed path within the theme - this is priority
    $template = locate_template(
        array(
            $template_path . $template_name,
            $template_name
        )
    );
    // Modification: Get the template from this plugin, if it exists
    if (!$template && file_exists($plugin_path . $template_name)) {
        $template = $plugin_path . $template_name;
    }
    // Use default template
    if (!$template) {
        $template = $coreTemplate;
    }

    // Return what we found
    return $template;
}
/*
* Remove add to cart & show Product expired message on single product page
*/

add_action('woocommerce_single_product_summary', 'wdmProductPageSummary', 30);

function wdmProductPageSummary()
{
    global $product;

    $url             = plugins_url('/css/message.css', dirname(__FILE__));
    wp_enqueue_style('wdm-message-css', $url);

    $availability=true;

    $curr_prod = wc_get_product($product->id);

    if ($curr_prod->is_type('simple')) {
        $availability=wdmCheckDateValidation($product->id);
    }



    if (!$availability) {
        add_filter('woocommerce_is_purchasable', 'wooSchedulerDisableAddToCart', 500);

        if (get_option('woocommerce_custom_product_expiration') != "") {
            echo "<p class='wdm_message'>" . apply_filters('wdm_expiration_message', get_option('woocommerce_custom_product_expiration'), $product->id) . "</p>";
        } else if (current_user_can('manage_options')) {
            echo "<p class='wdm_message'>" . __('You can set a custom message in Woocommerce->Settings->General->Product Expiration Message', WDM_WOO_SCHED_TXT_DOMAIN) . "</p>";
        }
    }
}

function wooSchedulerDisableAddToCart()
{
    return false;
}
