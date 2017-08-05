<?php

/*
  Plugin Name:WooCommerce Donation Or Tip On Cart And Checkout
  Plugin URI: http://www.magerips.com
  Description: A WooCommerce plugin that Accept donations on the cart and checkout page with amount specified by the client. 
  Author: Magerips
  Version: 1.2
  Author URI: http://www.magerips.com
 */

/* plugin global variable */
global $rpdo_plugin_url, $rpdo_plugin_dir;

$rpdo_plugin_dir = dirname(__FILE__) . "/";
$rpdo_plugin_url = plugins_url()."/" . basename($rpdo_plugin_dir) . "/";
include_once $rpdo_plugin_dir.'lib/main.php';

