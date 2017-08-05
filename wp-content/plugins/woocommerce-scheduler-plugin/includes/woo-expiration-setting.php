<?php

/*
     * Add Setting in woocommerce --> General Tab
     */

if (!function_exists('wooScheduleAddExpirationSetting')) :
    add_filter('woocommerce_general_settings', 'wooScheduleAddExpirationSetting');

    function wooScheduleAddExpirationSetting($settings)
    {
        $updated_settings = array();

        foreach ($settings as $section) {
            // at the bottom of the General Options section

            if (isset($section[ 'id' ]) && 'general_options' == $section[ 'id' ] &&
            isset($section[ 'type' ]) && 'sectionend' == $section[ 'type' ] ) {
                $updated_settings[] = array(
                'name' => __('Scheduler Setting', WDM_WOO_SCHED_TXT_DOMAIN),
                'desc'      => __('Schedule product on a per day basis or the entire duration from start date to end date', WDM_WOO_SCHED_TXT_DOMAIN),
                'id'         => 'woocommerce_custom_product_expiration_type',
                'default'    => 'per_day',
                'type'       => 'radio',
                'options'    => array(
                'per_day'    => __('Per Day', WDM_WOO_SCHED_TXT_DOMAIN),
                'entire_day' => __('Entire Duration', WDM_WOO_SCHED_TXT_DOMAIN)
                ),
                'desc_tip' =>  true,
                );

                $updated_settings[] = array(
                'name' => __('Single Product Expiration Message', WDM_WOO_SCHED_TXT_DOMAIN),
                'desc'      => __('Error Message to be shown on the Single Product page when product is unavailable.', WDM_WOO_SCHED_TXT_DOMAIN),
                'id' => 'woocommerce_custom_product_expiration',
                'type' => 'text',
                'css' => 'min-width:300px;',
                'std' => '1', // WC < 2.0
                'default' => 'Currently Unavailable', // WC >= 2.0
                'desc_tip' =>  true,
                );
                
                $updated_settings[] = array(
                'name' => __('Shop Page Expiration Message', WDM_WOO_SCHED_TXT_DOMAIN),
                'desc'      => __('Error Message to be shown on the shop page when product is unavailable. Keep short to fit into limited space. Can also be kept blank to show no error', WDM_WOO_SCHED_TXT_DOMAIN),
                'id' => 'woocommerce_custom_product_shop_expiration',
                'type' => 'text',
                'css' => 'min-width:300px;',
                'std' => '1', // WC < 2.0
                'default' => 'Unavailable', // WC >= 2.0
                'desc_tip' =>  true,
                );
            }

            $updated_settings[] = $section;
        }

        return $updated_settings;
        // }

        return $settings;
    }

endif;
