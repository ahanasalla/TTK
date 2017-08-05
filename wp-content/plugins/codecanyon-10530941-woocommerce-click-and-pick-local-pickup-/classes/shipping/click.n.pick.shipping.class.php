<?php

if (!defined('ABSPATH')) {
    exit;
}

use Click_And_Pick\Helpers\Helper;
use \Click_And_Pick\Click_And_Pick;

/**
 * Click and pick shipping method
 */
function click_n_pick_shipping_method_init()
{
    if (!class_exists('WC_Click_And_Pick')) {

        class WC_Click_And_Pick extends WC_Shipping_Method
        {

            public function __construct()
            {
                $this->option = new Helper();

                $this->id = Click_And_Pick::TEXTDOMAIN . "_shipping_method";
                $this->method_title = __('Click And Pick', Click_And_Pick::TEXTDOMAIN);
                $this->enabled = $this->option->getClickAndPickOptions('enabled');
//                $this->title        = __( 'Click And Pick', Click_And_Pick::TEXTDOMAIN ); // the title of the plugin
                $this->title = is_null($this->option->getClickAndPickOptions('title')) ? __('Click And Pick', Click_And_Pick::TEXTDOMAIN) : $this->option->getClickAndPickOptions('title');
                $this->init();

            }

            function init()
            {
                $this->init_form_fields();
                $this->init_settings();

                add_action('woocommerce_update_options_shipping_' . $this->id, array(
                    $this,
                    'process_admin_options',
                ));
            }

            public function calculate_shipping($package = array())
            {
                $rate = array(
                    'id' => $this->id,
                    'label' => $this->title,
                    'cost' => $this->option->getClickAndPickOptions('cost') ? $this->option->getClickAndPickOptions('cost') : '0',
                    'calc_tax' => 'per_item',
                );

                // Register the rate
                $this->add_rate($rate);
            }

            public function init_form_fields()
            {

                $this->form_fields = array(
                    'enabled' => array(
                        'title' => __('Enable', Click_And_Pick::TEXTDOMAIN),
                        'type' => 'checkbox',
                        'label' => __('Enable Click And Pick', Click_And_Pick::TEXTDOMAIN),
                        'default' => 'no',
                    ),
                    'allow_next_year' => array(
                        'title' => __('Enable', Click_And_Pick::TEXTDOMAIN),
                        'type' => 'checkbox',
                        'label' => __('Allow datepicker range to next year', Click_And_Pick::TEXTDOMAIN),
                        'default' => 'no',
                    ),
                    'theme' => array(
                        'title' => __('Theme', Click_And_Pick::TEXTDOMAIN),
                        'type' => 'select',
                        'description' => __('Select the color theme of the date time picker in the checkout', Click_And_Pick::TEXTDOMAIN),
                        'default' => 'default',
                        'options' => array(
                            'default' => 'Light Theme',
                            'dark' => 'Dark Theme',
                        ),
                    ),
                     'datetime_picker_language' => array(
                        'title' => __('Date\Time picker language', Click_And_Pick::TEXTDOMAIN),
                        'type' => 'select',
                        'description' => __('Select the datetime picker language from the dropdown', Click_And_Pick::TEXTDOMAIN),
                        'options' => array(
                            ""   => "Please choose",
                            "ar" => "Arabic",
                            "az" => "Azerbaijanian",
                            "bg" => "Bulgarian",
                            "bs" => "Bosanski",
                            "ca" => "Català",
                            "ch" => "Simplified Chinese",
                            "cs" => "Čeština",
                            "da" => "Dansk",
                            "de" => "German",
                            "el" => "Ελληνικά",
                            "en" => "English",
                            "en-GB" => "English (British)",
                            "es" => "Spanish",
                            "et" => "Eesti",
                            "eu" => "Euskara",
                            "fa" => "Persian",
                            "fi" => "Finnish (Suomi)",
                            "fr" => "French",
                            "gl" => "Galego",
                            "he" => "Hebrew (עברית)",
                            "hr" => "Hrvatski",
                            "hu" => "Hungarian",
                            "id" => "Indonesian",
                            "it" => "Italian",
                            "ja" => "Japanese",
                            "ko" => "Korean (한국어)",
                            "kr" => "Korean",
                            "lt" => "Lithuanian (lietuvių)",
                            "lv" => "Latvian (Latviešu)",
                            "mk" => "Macedonian (Македонски)",
                            "mn" => "Mongolian (Монгол)",
                            "nl" => "Dutch",
                            "no" => "Norwegian",
                            "pl" => "Polish",
                            "pt" => "Portuguese",
                            "pt-BR" => "Português(Brasil)",
                            "ro" => "Romanian",
                            "ru" => "Russian",
                            "se" => "Swedish",
                            "sk" => "Slovenčina",
                            "sl" => "Slovenščina",
                            "sq" => "Albanian (Shqip)",
                            "sr" => "Serbian Cyrillic (Српски)",
                            "sr-YU" => "Serbian (Srpski)",
                            "sv" => "Svenska",
                            "th" => "Thai",
                            "tr" => "Turkish",
                            "uk" => "Ukrainian",
                            "vi" => "Vietnamese",
                            "zh" => "Simplified Chinese (简体中文)",
                            "zh-TW" => "Traditional Chinese (繁體中文)",
                        ),
                    ),
                    'time_format' => array(
                        'title' => __('Time Format', Click_And_Pick::TEXTDOMAIN),
                        'type' => 'select',
                        'description' => __('Select the time format (12 hours format or 24 hours format)', Click_And_Pick::TEXTDOMAIN),
                        'default' => 'g:i A',
                        'options' => array(
                            'H:i' => '24 hours',
                            'g:i A' => '12 hours',
                        ),
                    ),
                    'title' => array(
                        'title' => __('Title', Click_And_Pick::TEXTDOMAIN),
                        'type' => 'text',
                        'default' => __('Click and pick', Click_And_Pick::TEXTDOMAIN),
                        'description' => __('You can add your title here', Click_And_Pick::TEXTDOMAIN),
                    ),
                    'map' => array(
                        'title'   => __('Google map api\'s key', Click_And_Pick::TEXTDOMAIN),
                        'type'    => 'text',
                        'description' => __('Please make sure you include a valid API key as a key parameter. You can generate a new API key on the <a href="https://developers.google.com/maps/documentation/javascript/get-api-key" target="_blank">Google API</a>.'), Click_And_Pick::TEXTDOMAIN),
                    'cost' => array(
                        'title' => __('Cost', Click_And_Pick::TEXTDOMAIN),
                        'type' => 'text',
                        'default' => '0',
                        'description' => __('You can add your cost here, leave empty if it\'s free', Click_And_Pick::TEXTDOMAIN),
                    ),

                );
            }

        }
    }
}

add_action('woocommerce_shipping_init', 'click_n_pick_shipping_method_init');

/**
 * @param $methods
 *
 * @return array
 */
function add_click_n_pick($methods)
{
    $methods[] = 'WC_Click_And_Pick';

    return $methods;
}

add_filter('woocommerce_shipping_methods', 'add_click_n_pick');
