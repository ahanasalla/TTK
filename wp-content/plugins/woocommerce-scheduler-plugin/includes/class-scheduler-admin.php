<?php
namespace{
    
    if (!class_exists('SchedulerAdmin')) {
        class SchedulerAdmin
        {
            public function __construct()
            {
                add_filter('product_type_options', array($this, 'wdmAddHideProductOption'));
                add_action('save_post_product', array($this, 'wdmProductExpirationSave'));
                add_filter('woocommerce_available_variation', array($this, 'wdmAvailableVariation'), 10, 1);
                //Cron action
                add_action('update_product_status', array($this, 'wdmChangePostStatus'));
                add_filter('cron_schedules', array($this, 'wdmWsAddCronSchedule'));
                add_action('woocommerce_product_after_variable_attributes', array($this, 'wdmVariationSettingsFields'), 10, 3);
                add_action('woocommerce_ajax_save_product_variations', array($this, 'wdmWoocommerceAjaxSaveProductVariations'), 10, 1);
                add_action('woocommerce_product_options_pricing', array($this, 'wdmStartEndDate'));
            }



            public function wdmAddHideProductOption($product_type_options)
            {
                global $post;
                $value=get_post_meta($post->ID, 'check_avalibility', true);
                $product_type_options['check_avalibility'] =  array(
                'id'            => 'check_avalibility',
                'wrapper_class' => 'show_if_simple show_if_variable',
                'label'         => __('Hide Product When Unavailable', WDM_WOO_SCHED_TXT_DOMAIN),
                'description'   => __('Display product only in scheduled time', WDM_WOO_SCHED_TXT_DOMAIN),
                'default'       => $value
                );
                return $product_type_options;
            }

            /**
 * Add fieds on edit product page
 * @param  string $post [description]
 * @return [type]       [description]
 */
            public function wdmStartEndDate($post = '')
            {
                if (empty($post)) {
                    global $post;
                    $curr_post_id=0;
                    $is_simple = "wdm_simple_schedule";
                    $curr_post_id=$post->ID;
                    $product = wc_get_product($curr_post_id);
                    if ($product->is_type('variable')) {
                        return false;
                       // a variable product
                    }
                } else {
                    $curr_post_id=$post;
                    $is_simple = "";
                }
        
                $wdm_start_date  = get_post_meta($curr_post_id, 'wdm_start_date', true);
                $wdm_end_date    = get_post_meta($curr_post_id, 'wdm_end_date', true);
                    //For Start time and End time
                $wdm_start_time_hr  = get_post_meta($curr_post_id, 'wdm_start_time_hr', true);
                $wdm_end_time_hr    = get_post_meta($curr_post_id, 'wdm_end_time_hr', true);
                $wdm_start_time_min = get_post_meta($curr_post_id, 'wdm_start_time_min', true);
                $wdm_end_time_min   = get_post_meta($curr_post_id, 'wdm_end_time_min', true);

                $wdm_start_time='';
                if (!empty($wdm_start_time_hr) && !empty($wdm_start_time_min)) {
                    $wdm_start_time =  $wdm_start_time_hr . ':' . $wdm_start_time_min;
                }
            
                $wdm_end_time='';
                if (!empty($wdm_end_time_hr) && !empty($wdm_end_time_min)) {
                    $wdm_end_time =  $wdm_end_time_hr . ':' . $wdm_end_time_min;
                }

                echo "<div class='wdm-start-date-end-data-cont {$is_simple}'><p><label for='wdm_lat_field' class='wdm_lat_field'>";
                _e('Start Date:', WDM_WOO_SCHED_TXT_DOMAIN);
                echo '</label>';
            
                
                echo "<input type='text' name='wdm_start_date[{$curr_post_id}]' data-variation_id = '{$curr_post_id}' class='wdm_start_date' value= '{$wdm_start_date}'>";
                
            
                echo '</p><p><label for="wdm_lat_field" class="wdm_lat_field">';
                _e('End Date:', WDM_WOO_SCHED_TXT_DOMAIN);
                echo '</label>';
            
                echo "<input type='text' name='wdm_end_date[".$curr_post_id."]' data-variation_id = '{$curr_post_id}' class='wdm_end_date' value= '{$wdm_end_date}'> ";
            
                echo "<br/></p></div>";
            
                echo "<div class='wdm-start-time-end-data-cont {$is_simple}'><p><label for='wdm_lat_field' class='wdm_lat_field'>";
                _e('Start Time:', WDM_WOO_SCHED_TXT_DOMAIN);
                echo '</label>';
            
                echo "<input type='text' name='wdm_start_time[{$curr_post_id}]' data-variation_id = '{$curr_post_id}' class='wdm_start_time' value= '{$wdm_start_time}'>";
            
                echo '</p><p><label for="wdm_lat_field" class="wdm_lat_field">';
                _e('End Time:', WDM_WOO_SCHED_TXT_DOMAIN);
                echo '</label>';
            
                echo "<input type='text' name='wdm_end_time[".$curr_post_id."]' data-variation_id = '{$curr_post_id}' class='wdm_end_time' value= '{$wdm_end_time}'>";
            
                echo "<br/></p></div>";
            
                $product_exp_type=get_option('woocommerce_custom_product_expiration_type');

                if ($product_exp_type == 'per_day') {
                    echo '<p class="wdm-select-days-cont"><label for="wdm_lat_field" class="wdm_lat_field">';
                    _e('Days of Week:', WDM_WOO_SCHED_TXT_DOMAIN);
                    echo '</label>';
                    $options = get_post_meta($curr_post_id, 'wdm_days_selected', true);
                    ?>
                    <input type='checkbox' id="monday_<?php echo $curr_post_id; ?>" name="days_of_week[<?php echo $curr_post_id;
                    ?>][Monday]" class='wdm_day_of_week'  <?php echo $this->wdmChecked($options, 'Monday');
                    ?> /><label for="monday_<?php echo $curr_post_id; ?>"><?php _e('Monday', WDM_WOO_SCHED_TXT_DOMAIN);
                    ?></label>
                    <input type='checkbox' id="tuesday_<?php echo $curr_post_id; ?>" name="days_of_week[<?php echo $curr_post_id;
                    ?>][Tuesday]" class='wdm_day_of_week'  <?php echo $this->wdmChecked($options, 'Tuesday');
                    ?> /><label for="tuesday_<?php echo $curr_post_id; ?>"><?php _e('Tuesday', WDM_WOO_SCHED_TXT_DOMAIN);
                    ?></label>
                    <input type='checkbox' id="wednesday_<?php echo $curr_post_id; ?>" name="days_of_week[<?php echo $curr_post_id;
                    ?>][Wednesday]" class='wdm_day_of_week'  <?php echo $this->wdmChecked($options, 'Wednesday');
                    ?> /><label for="wednesday_<?php echo $curr_post_id; ?>"><?php _e('Wednesday', WDM_WOO_SCHED_TXT_DOMAIN);
                    ?></label>
                    <input type='checkbox' id="thursday_<?php echo $curr_post_id; ?>" name="days_of_week[<?php echo $curr_post_id;
                    ?>][Thursday]" class='wdm_day_of_week'  <?php echo $this->wdmChecked($options, 'Thursday');
                    ?> /><label for="thursday_<?php echo $curr_post_id; ?>"><?php _e('Thursday', WDM_WOO_SCHED_TXT_DOMAIN);
                    ?></label>
                    <input type='checkbox' id="friday_<?php echo $curr_post_id; ?>" name="days_of_week[<?php echo $curr_post_id;
                    ?>][Friday]" class='wdm_day_of_week'  <?php echo $this->wdmChecked($options, 'Friday');
                    ?> /><label for="friday_<?php echo $curr_post_id; ?>"><?php _e('Friday', WDM_WOO_SCHED_TXT_DOMAIN);
                    ?></label>
                    <input type='checkbox' id="saturday_<?php echo $curr_post_id; ?>" name="days_of_week[<?php echo $curr_post_id;
                    ?>][Saturday]" class='wdm_day_of_week'  <?php echo $this->wdmChecked($options, 'Saturday');
                    ?> /><label for="saturday_<?php echo $curr_post_id; ?>"><?php _e('Saturday', WDM_WOO_SCHED_TXT_DOMAIN);
                    ?></label>
                    <input type='checkbox' id="sunday_<?php echo $curr_post_id; ?>" name="days_of_week[<?php echo $curr_post_id;
                    ?>][Sunday]" class='wdm_day_of_week'  <?php echo $this->wdmChecked($options, 'Sunday');
                    ?> /><label for="sunday_<?php echo $curr_post_id; ?>"><?php _e('Sunday', WDM_WOO_SCHED_TXT_DOMAIN);
                    ?></label>

                    <?php

                };

                //echo '<input type="button" class="wdm_enable_fields button button-small" value="Edit Schedule">';
            }

/**
 * update the schedular meta data
 * @param  [type] $post_id [description]
 * @return [type]          [description]
 */
            public function wdmProductExpirationSave($post_id = '')
            {
                //save dates
                $this->wdmExpiration($_POST);

                if (!empty($post_id)) {
                    remove_action('save_post_product', array($this, 'wdmProductExpirationSave'));

                    $curr_prod = wc_get_product($post_id);
                    if ($curr_prod->is_type('simple')) {
                        $avaliable_products = get_option('wdm_avaliable_products');
                        if (! $avaliable_products) {
                            $avaliable_products = array();
                        }

                        if (isset($_POST['check_avalibility'])) {
                            update_post_meta($post_id, 'check_avalibility', 'yes');
                            if (! in_array($post_id, $avaliable_products)) {
                                array_push($avaliable_products, $post_id);
                            }
                            $this->wdmSingleChangePostStatus($post_id);
                        } else {
                            $avaliable_products = array_diff($avaliable_products, array( $post_id ));
                            update_post_meta($post_id, 'check_avalibility', 'no');
                            $this->wdmPublishProduct($post_id);
                        }
                        update_option('wdm_avaliable_products', $avaliable_products);
                    } else {
                        $args = array(
                        'post_parent' => $post_id,
                        'post_type'   => 'product_variation',
                        'numberposts' => -1,
                        'post_status' => 'any'
                        );

                        $variants = get_children($args, ARRAY_A);

                        $variants = array_keys($variants);
                        $hide_variants = get_option('wdm_hide_variants');
                        if (!isset($hide_variants) ||  empty($hide_variants)) {
                            $hide_variants = array();
                        }

                        
                        $prnt_vrbl = get_option('wdm_parent_variable_prods');
                        if (!isset($prnt_vrbl) || empty($prnt_vrbl)) {
                            $prnt_vrbl = array();
                        }

                        if (isset($_POST['check_avalibility'])) {
                            update_post_meta($post_id, 'check_avalibility', 'yes');
                            if (! in_array($post_id, $prnt_vrbl)) {
                                array_push($prnt_vrbl, $post_id);
                                update_option('wdm_parent_variable_prods', $prnt_vrbl);
                            }

                            foreach ($variants as $vid) {
                                if (! in_array($vid, $hide_variants)) {
                                    array_push($hide_variants, $vid);
                                }
                            }

                            $this->wdmSingleChangePostStatus($post_id);
                        } else {
                            $prnt_vrbl = array_diff($prnt_vrbl, array( $post_id ));
                            update_option('wdm_parent_variable_prods', $prnt_vrbl);
                            update_post_meta($post_id, 'check_avalibility', 'no');

                            $unhide_variants = array();

                            foreach ($variants as $vid) {
                                $unhide_variants[] = $vid;

                                $current_post = get_post($vid, 'ARRAY_A');
                                $current_post['post_status'] = 'publish';
                                wp_update_post($current_post);
                            }

                            $hide_variants = array_diff($hide_variants, $unhide_variants);

                            $this->wdmPublishProduct($post_id);
                        }

                        update_option('wdm_hide_variants', $hide_variants);
                    }

                    add_action('save_post_product', array($this, 'wdmProductExpirationSave'));
                }
            }

            /*
             * Publish the given Product 
             */

            public function wdmPublishProduct($pid)
            {
                $current_post = get_post($pid, 'ARRAY_A');
                if (!empty($current_post)) {
                    if ($current_post['post_status'] != 'publish' && $current_post['post_status'] != 'trash' && $current_post['post_status'] != 'private' && $current_post['post_status'] != 'draft') {
                        $current_post['post_status'] = 'publish';
                        wp_update_post($current_post);
                    }
                }
            }

        /*
         * WooCommerce Add to cart validation
         */

 
            public function wdmAvailableVariation($args)
            {
                $args['variation_is_visible'] = wdmCheckDateValidation($args['variation_id'], 'variant');
    
                return $args;
            }

            /**
 * Changes Single Post Status on Save
 * @return [type] [description]
 */
            public function wdmSingleChangePostStatus($pid)
            {
                $curr_prod = wc_get_product($pid);
                if ($curr_prod->is_type('simple')) {
                    $current_post = get_post($pid, 'ARRAY_A');
                    if (!empty($current_post)) {
                        if (wdmCheckDateValidation($pid, 'simple')) {
                            if ($current_post['post_status'] != 'publish') {
                                $current_post['post_status'] = 'publish';
                                wp_update_post($current_post);
                            }
                        } else {
                            $current_post['post_status'] = 'draft';
                            wp_update_post($current_post);
                        }
                    }
                } else {
                    $args = array(
                                'post_parent' => $pid,
                                'post_type'   => 'product_variation',
                                'numberposts' => -1,
                                'post_status' => 'any'
                            );

                    $variants = get_children($args, ARRAY_A);
                    $variants = array_keys($variants);
                           
                    if (isset($variants)&& !empty($variants)) {
                        $total_variants = count($variants);

                        $private_variants = 0;

                        foreach ($variants as $vid) {
                            $current_post = get_post($vid, 'ARRAY_A');
                            if (wdmCheckDateValidation($vid, 'variant')) {
                                if ($current_post['post_status'] != 'publish') {
                                    $current_post['post_status'] = 'publish';
                                    wp_update_post($current_post);
                                }
                            } else {
                                $private_variants++;
                                $current_post['post_status'] = 'private';
                                wp_update_post($current_post);
                            }
                        }

                        if ($total_variants == $private_variants) {
                            $parent_variable = get_post($pid, 'ARRAY_A');
                            $parent_variable['post_status'] = 'draft';
                            wp_update_post($parent_variable);
                        } else {
                            update_post_meta($pid, '_stock_status', 'instock');
                            $parent_variable = get_post($pid, 'ARRAY_A');
                            $parent_variable['post_status'] = 'publish';
                            wp_update_post($parent_variable);
                        }
                    }
                }
            }

/**
 * Cron callback function
 * @return [type] [description]
 */
            public function wdmChangePostStatus()
            {
                remove_action('save_post_product', array($this, 'wdmProductExpirationSave'));

                $avaliable_products = get_option('wdm_avaliable_products');
    
                foreach ($avaliable_products as $pid) {
                    $current_post = get_post($pid, 'ARRAY_A');
                    if (!empty($current_post)) {
                        if (wdmCheckDateValidation($pid, 'simple')) {
                            if ($current_post['post_status'] != 'publish') {
                                $current_post['post_status'] = 'publish';
                                wp_update_post($current_post);
                            }
                        } else {
                            $current_post['post_status'] = 'draft';
                            wp_update_post($current_post);
                        }
                    }
                }

                $hide_variants = get_option('wdm_hide_variants');
                if (isset($hide_variants)&& !empty($hide_variants)) {
                    foreach ($hide_variants as $vid) {
                        $current_post = get_post($vid, 'ARRAY_A');
        
                        if (wdmCheckDateValidation($vid, 'variant')) {
                            if ($current_post['post_status'] != 'publish') {
                                $current_post['post_status'] = 'publish';
                                wp_update_post($current_post);
                            }
                        } else {
                            $current_post['post_status'] = 'private';
                            wp_update_post($current_post);
                        }
                    }
                }
                $this->changeParentVariableStatus();
            }

/**
 * Change status of variable product and its variations
 * @return [type] [description]
 */
            public function changeParentVariableStatus()
            {
                $prnt_vrbl = get_option('wdm_parent_variable_prods');
                if (isset($prnt_vrbl)&& !empty($prnt_vrbl)) {
                    foreach ($prnt_vrbl as $vid) {
                        $args = array(
                           'post_parent' => $vid,
                           'post_type'   => 'product_variation',
                           'numberposts' => -1,
                           'post_status' => 'any'
                           );

                        $variants = get_children($args, ARRAY_A);

                        $total_variants = count($variants);

                        $private_variants = 0;

                        $args = array(
                        'post_parent' => $vid,
                        'post_type'   => 'product_variation',
                        'numberposts' => -1,
                        'post_status' => 'private'
                        );
                        $variants = get_children($args, ARRAY_A);
                        $private_variants = count($variants);

                        if ($total_variants == $private_variants) {
                            $parent_variable = get_post($vid, 'ARRAY_A');
                            $parent_variable['post_status'] = 'draft';
                            wp_update_post($parent_variable);
                        } else {
                            update_post_meta($vid, '_stock_status', 'instock');
                            $parent_variable = get_post($vid, 'ARRAY_A');
                            $parent_variable['post_status'] = 'publish';
                            wp_update_post($parent_variable);
                        }
                    }
                }
                add_action('save_post_product', array($this, 'wdmProductExpirationSave'));
            }


    /**
 * Set per minute cron
 * @param  [type] $schedules [description]
 * @return [type]            [description]
 */
            public function wdmWsAddCronSchedule($schedules)
            {
                $schedules['wdm_per_minute'] = array(
                'interval' => 60,
                'display'  => 'wdm_per_minute',
                );
                return $schedules;
            }



    //Add Variation Settings
/**
 * display meta in all variations
 * @param  [type] $loop           [description]
 * @param  [type] $variation_data [description]
 * @param  [type] $variation      [description]
 * @return [type]                 [description]
 */
            public function wdmVariationSettingsFields($loop, $variation_data, $variation)
            {
                unset($loop);
                unset($variation_data);
                if (isset($variation) && !empty($variation)) {
                    $this->wdmStartEndDate($variation->ID);
                }
            }


        /**
         * Call function for variable product save
         * @param  [type] $pid [description]
         * @return [type]      [description]
         */
            public function wdmWoocommerceAjaxSaveProductVariations($pid)
            {
                $pid;
                $this->wdmProductExpirationSave();
            }


        /**
         * Check expiration date of product
         * @param  [type] $wdm_start_date_array [description]
         * @param  [type] $wdm_end_date_array   [description]
         * @param  [type] $days_of_week_array   [description]
         * @param  [type] $wdm_start_time_array [description]
         * @param  [type] $wdm_end_time_array   [description]
         * @return [type]                       [description]
         */
            public function wdmExpiration($post_data)
            {
                $type = get_option('woocommerce_custom_product_expiration_type');
                if (isset($post_data['wdm_start_date']) && !empty($post_data['wdm_start_date'])) {
                    $wdm_start_date_array =$post_data['wdm_start_date'];
                    $wdm_end_date_array = $post_data['wdm_end_date'];
                    $wdm_start_time_array = $post_data['wdm_start_time'];
                    $wdm_end_time_array = $post_data['wdm_end_time'];

                    $wdm_week_array  = array();
                    if (isset($post_data['days_of_week'])) {
                        $wdm_week_array = $post_data['days_of_week'];
                    }

                    foreach ($wdm_start_date_array as $post_id => $start_date) {
                        if (isset($wdm_start_date_array[$post_id]) && $wdm_start_date_array[$post_id]!= "" && isset($wdm_end_date_array[$post_id]) && $wdm_end_date_array[$post_id] != "") {
                            $wdm_start_date = trim($wdm_start_date_array[$post_id]);
                            $wdm_end_date = trim($wdm_end_date_array[$post_id]);
               
                            $wdm_start_time = trim($wdm_start_time_array[$post_id]);
                            $wdm_end_time = trim($wdm_end_time_array[$post_id]);
                
                            if (!empty($wdm_start_time) && !empty($wdm_end_time)) {
                                $start_time  =  $wdm_start_time . ":00";
                                $end_time    = $wdm_end_time . ":59";
                    
                                $str_start_time  = strtotime($start_time);
                                $str_end_time    = strtotime($end_time);
                    
                                //Checking whether Start Time is greater than End Time. If true, both of them are set the same value.
                                if ($type == 'per_day') {
                                    if ($str_start_time > $str_end_time) {
                                        $wdm_end_time = $wdm_start_time;
                                    }
                                }
                                $wdm_start_time_split = explode(":", $wdm_start_time);
                                $wdm_end_time_split = explode(":", $wdm_end_time);
            
                    
                                $wdm_start_time_hr = $wdm_start_time_split[0];
                                $wdm_start_time_min = $wdm_start_time_split[1];
                                $wdm_end_time_hr = $wdm_end_time_split[0];
                                $wdm_end_time_min = $wdm_end_time_split[1];

                                update_post_meta($post_id, 'wdm_start_time_hr', $wdm_start_time_hr);
                                update_post_meta($post_id, 'wdm_start_time_min', $wdm_start_time_min);
                                update_post_meta($post_id, 'wdm_end_time_hr', $wdm_end_time_hr);
                                update_post_meta($post_id, 'wdm_end_time_min', $wdm_end_time_min);
                            } else {
                                delete_post_meta($post_id, 'wdm_start_time_hr');
                                delete_post_meta($post_id, 'wdm_start_time_min');
                                delete_post_meta($post_id, 'wdm_end_time_hr');
                                delete_post_meta($post_id, 'wdm_end_time_min');
                            }
                
                            $start_date = strtotime($wdm_start_date);
                            $end_date = strtotime($wdm_end_date);

                            if ($end_date < $start_date) {
                                $wdm_end_date = $wdm_start_date;
                            }

                            update_post_meta($post_id, 'wdm_start_date', $wdm_start_date);
                            update_post_meta($post_id, 'wdm_end_date', $wdm_end_date);

                            $days_selected='';
                            if (isset($wdm_week_array[$post_id]) && !empty($wdm_week_array[$post_id])) {
                                $days_selected=$wdm_week_array[$post_id];
                            }
                             

                            if ($days_selected!='') {
                                update_post_meta($post_id, 'wdm_days_selected', $days_selected);
                            } else {
                                delete_post_meta($post_id, 'wdm_days_selected');
                            }
                        } else {
                            delete_post_meta($post_id, 'wdm_start_date');
                            delete_post_meta($post_id, 'wdm_end_date');
                            delete_post_meta($post_id, 'wdm_start_time_hr');
                            delete_post_meta($post_id, 'wdm_start_time_min');
                            delete_post_meta($post_id, 'wdm_end_time_hr');
                            delete_post_meta($post_id, 'wdm_end_time_min');
                            delete_post_meta($post_id, 'wdm_days_selected');
                            delete_post_meta($post_id, 'check_avalibility');
                        }
                    }
                }
            }

        /**
         * echo value checked or not for days
         * @param  [type] $options [description]
         * @param  [type] $day     [description]
         * @return [type]          [description]
         */
            public function wdmChecked($options, $day)
            {
                if (isset($options[$day])) {
                    return 'checked';
                } else {
                    return '';
                }
            }
        }
        new SchedulerAdmin();
    }
}
