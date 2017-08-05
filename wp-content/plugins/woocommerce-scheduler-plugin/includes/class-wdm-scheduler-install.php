<?php
namespace {

    if (!class_exists('SchedulerInstall')) {
        class SchedulerInstall
        {
            public function __construct()
            {
                add_action('plugins_loaded', array($this, 'wooScheduleUpdateCheck'));
            }

    /*
         * Check for Plugin updatation
         * @since 1.2.4
         */
            // add_action('plugins_loaded', 'wooScheduleUpdateCheck');

            public function wooScheduleCreateTables()
            {
                //create table
                global $wpdb;
                $charset_collate       = $wpdb->get_charset_collate();
                $woo_product_cate_tbl = $wpdb->prefix . 'woo_schedule_category';
                $table_present_result = $wpdb->get_var("SHOW TABLES LIKE '{$woo_product_cate_tbl}'");
                if ($table_present_result === null || $table_present_result != $woo_product_cate_tbl) {
                    $woo_sche_cate_tbl = "CREATE TABLE IF NOT EXISTS $woo_product_cate_tbl (
		    meta_id  bigint(20) AUTO_INCREMENT,
		    term_id bigint(20),
		    start_date datetime,
		    end_date datetime,
		    selected_days longtext,
		    PRIMARY KEY id (meta_id)
		) $charset_collate;";
        
                    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        
                    dbDelta($woo_sche_cate_tbl);
                }
            }


            public function wdmProductExpiration()
            {
                if (!get_option('woocommerce_custom_product_expiration')) {
                    update_option('woocommerce_custom_product_expiration', "Currently Unavailable");
                }
                if (!get_option('woocommerce_custom_product_shop_expiration')) {
                    update_option('woocommerce_custom_product_shop_expiration', "Currently Unavailable");
                }
                if (!get_option('woocommerce_custom_product_expiration_type')) {
                    update_option('woocommerce_custom_product_expiration_type', 'per_day');
                }

                $time=current_time('timestamp');
                add_option('today', $time);
                wp_schedule_event(time(), 'wdm_per_minute', 'update_product_status');
                $this->wdmBackwardCompatibility();
            }

            public function wooScheduleUpdateCheck()
            {
                global $wdm_plugin_data;
                $get_plugin_version = get_option($wdm_plugin_data['plugin_slug'] . '_version', false);
                if ($get_plugin_version === false || $get_plugin_version  != $wdm_plugin_data['plugin_version']) {
                    $this->wooScheduleCreateTables();
                    update_option($wdm_plugin_data['plugin_slug'] . '_version', $wdm_plugin_data['plugin_version']);
                }
            }


            /**
 * wdmBackwardCompatibility Apply schedule of already exsiting variable product to its variations.
 * @return [type] [description]
 */
            public function wdmBackwardCompatibility()
            {
                global $wpdb;
    
                $parent_variable = "SELECT distinct post_parent  FROM `{$wpdb->prefix}posts` WHERE `post_type` = 'product_variation' ";
    
                $variable_products = $wpdb->get_col($parent_variable);
    
                foreach ($variable_products as $vid) {
                    $wdm_start_date = get_post_meta($vid, 'wdm_start_date', true);
                    $wdm_end_date = get_post_meta($vid, 'wdm_end_date', true);
                    $wdm_start_time_hr = get_post_meta($vid, 'wdm_start_time_hr', true);
                    $wdm_start_time_min = get_post_meta($vid, 'wdm_start_time_min', true);
                    $wdm_end_time_hr = get_post_meta($vid, 'wdm_end_time_hr', true);
                    $wdm_end_time_min = get_post_meta($vid, 'wdm_end_time_min', true);
                    $wdm_days_selected = get_post_meta($vid, 'wdm_days_selected', true);
    
        
                    if (!empty($wdm_start_date) && !empty($wdm_end_date)) {
                        $args = array(
                        'post_parent' => $vid,
                        'post_type'   => 'product_variation',
                        'numberposts' => -1,
                        'post_status' => 'any'
                        );
                
                        $variants = get_children($args);
                
                        if (is_array($variants)) {
                            $variants = array_keys($variants);
                        } else {
                            continue;
                        }
                
                        foreach ($variants as $variant) {
                            update_post_meta($variant, 'wdm_start_date', $wdm_start_date);
                            update_post_meta($variant, 'wdm_end_date', $wdm_end_date);
                    
                            if (!empty($wdm_start_time_hr)) {
                                update_post_meta($variant, 'wdm_start_time_hr', $wdm_start_time_hr);
                            }
                            if (!empty($wdm_start_time_min)) {
                                update_post_meta($variant, 'wdm_start_time_min', $wdm_start_time_min);
                            }
                            if (!empty($wdm_end_time_hr)) {
                                update_post_meta($variant, 'wdm_end_time_hr', $wdm_end_time_hr);
                            }
                            if (!empty($wdm_end_time_min)) {
                                update_post_meta($variant, 'wdm_end_time_min', $wdm_end_time_min);
                            }
                            if (!empty($wdm_days_selected)) {
                                update_post_meta($variant, 'wdm_days_selected', $wdm_days_selected);
                            }
                        }
                    }
        
                    delete_post_meta($vid, 'wdm_start_date');
                    delete_post_meta($vid, 'wdm_end_date');
                    delete_post_meta($vid, 'wdm_start_time_hr');
                    delete_post_meta($vid, 'wdm_start_time_min');
                    delete_post_meta($vid, 'wdm_end_time_hr');
                    delete_post_meta($vid, 'wdm_end_time_min');
                    delete_post_meta($vid, 'wdm_days_selected');
                }
            }
        }
    }
}
