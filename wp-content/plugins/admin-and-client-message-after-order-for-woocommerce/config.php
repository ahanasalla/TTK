<?php
/*
 * this file contains pluing meta information and then shared
 * between pluging and admin classes
 * 
 * [1]
 * TODO: change this meta as plugin needs
 */


function wooconvo_get_plugin_meta(){
	
	$plugin_meta		= array('name'			=> 'Woo Convo',
							'shortname'		=> 'nm_wooconvo', //without nm_ will be shortname
							'path'			=> untrailingslashit(plugin_dir_path( __FILE__ )),
							'url'			=> untrailingslashit(plugin_dir_url( __FILE__ )),
							'db_version'	=> 2.0,
							'logo'			=> untrailingslashit(plugin_dir_url( __FILE__ )) . '/images/logo.png',
							'menu_position'	=> 999);
	
	//print_r($plugin_meta);
	
	return $plugin_meta;
}
?>