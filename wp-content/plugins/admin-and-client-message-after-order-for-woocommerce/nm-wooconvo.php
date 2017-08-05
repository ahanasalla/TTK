<?php 
/*
 Plugin Name: WooCommerce File Upload after Checkout
Plugin URI: http://www.najeebmedia.com
Description: This plugin allow users chat with shop manager after checkout. Admin can also reply.
Version: 1.1
Author: Najeeb Ahmad
Author URI: http://www.najeebmedia.com/
*/

/*
 * loading plugin config file
 */
$_config = dirname(__FILE__).'/config.php';
if( file_exists($_config))
	include_once($_config);
else
	die('Reen, Reen, BUMP! not found '.$_config);


/* ======= the plugin main class =========== */
$_plugin = dirname(__FILE__).'/classes/plugin.class.php';
if( file_exists($_plugin))
	include_once($_plugin);
else
	die('Reen, Reen, BUMP! not found '.$_plugin);

/*
 * [1]
 * TODO: just replace class name with your plugin
 */
 // here object name will be shortname with out nm_
$wooconvo = new NM_PLUGIN_WooConvo();//class name NM_PLUGIN_ShortName


if( is_admin() ){

	$_admin = dirname(__FILE__).'/classes/admin.class.php';
	if( file_exists($_admin))
		include_once($_admin );
	else
		die('file not found! '.$_admin);
// for admin. rest same
	$wooconvo_admin = new NM_PLUGIN_WooConvo_Admin();// for admin. rest same.
}

/*
 * activation/install the plugin data
*/
register_activation_hook( __FILE__, array('NM_PLUGIN_WooConvo', 'activate_plugin'));
register_deactivation_hook( __FILE__, array('NM_PLUGIN_WooConvo', 'deactivate_plugin'));
?>