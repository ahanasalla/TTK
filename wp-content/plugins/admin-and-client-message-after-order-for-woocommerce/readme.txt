=== Client Admin Message After Purchase for WooCommerce ===
Contributors: nmedia
Tags: woocommerce, client messages, private message, woocommerce private message, woocommerce file upload, woocommerce order complete, woocommerce order message
Donate link: https://najeebmedia.com/donate/
Requires at least: 3.5
Tested up to: 4.7.4
Stable tag: 1.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This enable conversation between admin and client when order is completed.  

== Description ==
This plugin allow admin and client to communicate when WooCommerce order is completed. A button/link is added against each Order in My Account page to start/see
messages. [See screenshot-1].

A nice and clean UI allow client and amdin to send messages to each other. Email is also sent on every message sent to both users. [See screenshot-2 & 3]

= PRO Features =
* File Attachments
* Images Attachments
* Filetype, size control
* Images thumb display
* Pro Support for Pro Client
* [Get PRO] (https://najeebmedia.com/wordpress-plugin/woocommerce-file-upload-plugin-after-checkout/)

= Hooks/Filters =
Following filters can be used to personalized/overrirde plugin design.

<pre>(wooconvo_message_receivers, $receivers)</pre>
Email notification receivers
<pre>(wooconvo_message_subject, $subject, $order_id)</pre>
Subject of Email notification sent to both users.
<pre>(wooconvo_shop_admin_name, 'Shop Admin')</pre>
Title for admin shown for Admin to user
<pre>(wooconvo_render_attachments, $html, $files)</pre>
Render attachments sent with message. This is a pro feature

== Installation ==
1. Upload plugin directory to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. After activation, you can set options from `Woo Convo` menu

== Frequently Asked Questions ==
= Where admin will see messages? =
Admin can see messages in each order inside a Meta Box

= Can user or admin files/images with messages? =
Yes, but it's a PRO feature

== Screenshots ==
1. My Account Messages Button
2. Frontend Messages UI
3. Admin Messages UI
4. Admin Settings

== Changelog ==
= 1.1 May 15, 2017 =
* Bug fixed: Plupload script removed
* Bug fixed: some function renamed
* Bug fixed: Sanitized all input field
* Bug fixed: use current_user_can() function for ajax requests
* Bug fixed: Removed unnecessary functions
* Bug fixed: EasyTabs replaced with WordPress core jquery-ui script

= 1.0 March 20, 2017 =
* Initial Release

== Upgrade Notice ==
= !! Love For All Hatred For None !! =