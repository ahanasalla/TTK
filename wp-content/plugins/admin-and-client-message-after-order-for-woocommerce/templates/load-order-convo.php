<?php
/*
 * This template is loading order's convo
 * if user/customer is logged
 * used when shortcode is used
 */
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
exit;
}

global $wooconvo;

if (!isset($_REQUEST['order']) || !$wooconvo -> order_valid):

if(!$wooconvo -> order_valid)
	echo '<span class="wooconvo-error">'.__('No messages found or you provided wrong information', 'nm_wooconvo').'</span>';

?>
<div id="wooconvo-load-order">
	<form method="get">
	<label><?php _e('Type Your Order Number', 'nm_wooconvo')?>
		<input type="text" name="order" value="" />
	</label>
	<label><?php _e('Type Your Email', 'nm_wooconvo')?>
		<input type="email" name="email" value="" />
	</label>
	
	<br>		
	<input type="submit" value="<?php _e('Load detail', 'nm_wooconvo')?>">
	</form>
</div>
<?php else:

	$wooconvo -> render_wooconvo_frontend();

endif;
?>
