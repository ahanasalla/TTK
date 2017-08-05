<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
exit;
}

$meatDialog = array(
    'message-sent' => array(
        'label' => __('Message Sent message', 'nm-wooconvo'),
        'desc' => __('This message will be shown when message is sent', 'nm-wooconvo'),
        'id' => $this->plugin_meta['shortname'] . '_message_sent',
        'type' => 'textarea',
        'default' => '',
        'help' => ''
    ),
    
    'email-message' => array(
        'label' => __('Email', 'nm-wooconvo'),
        'desc' => __('This will be sent as email text.', 'nm-wooconvo'),
        'id' => $this->plugin_meta['shortname'] . '_email_message',
        'type' => 'textarea',
        'default' => '',
        'help' => 'Shortcodes:<br>
		Sender Name: %sender_name%<br>
		Sender Email: %sender_email%'
    ),
);
$meat_pro_features = array(
    'file-meta'  => array(   
    'desc'      => '',
    'type'      => 'file',
    'id'        => 'pro-features.php',
    ),
);
$meat_more_plugins = array(
    'file-meta'  => array(   
    'desc'      => '',
    'type'      => 'file',
    'id'        => 'more-plugins.php',
    ),
);


$this->the_options = array(
    'email-template' => array(
        'name' => __('Dialog Messages', 'nm-wooconvo'),
        'type' => 'tab',
        'desc' => __('Set message as per your need', 'nm-wooconvo'),
        'meat' => $meatDialog
    ),
    'pro-features' => array(
        'name' => __('Pro Features', 'nm-wooconvo'),
        'type' => 'tab',
        'desc' => __('Following features will be available in pro version', 'nm-wooconvo'),
        'meat' => $meat_pro_features
    ),
    'other-plugins' => array(
        'name' => __('More WooCommerce Plugins for your Store', 'nm-wooconvo'),
        'type' => 'tab',
        'desc' => __('Try more plugins for your store', 'nm-wooconvo'),
        'meat' => $meat_more_plugins
    ),
);