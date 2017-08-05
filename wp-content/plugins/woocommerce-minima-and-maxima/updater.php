<?php

if (!defined('ABSPATH')) die('No direct access.');

if (!class_exists('Updraft_Manager_Updater_1_4')) require_once(dirname(__FILE__).'/vendor/davidanderson684/simba-plugin-manager-updater/class-udm-updater.php');

try {
	$wcminmax_updater = new Updraft_Manager_Updater_1_4('https://www.simbahosting.co.uk/s3', 1, 'woocommerce-minima-and-maxima/woocommerce-minima-and-maxima.php');
} catch (Exception $e) {
	error_log($e->getMessage());
}

#$wcminmax_updater->updater->debug = true;
