<?php
/*
 * This template is use to send/reply convo
 */
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
exit;
}

global $wooconvo;

//echo 'the pass var is '.$user_name
wp_nonce_field('doing_wooconvo','nm_wooconvo_nonce');
wp_enqueue_style( 'dashicons' );
?>
<div id="wooconvo-send" class="wooconvo-send">
<input type="hidden" name="order_id" value="<?php echo esc_attr($wooconvo->order_id); ?>" />

<?php if (is_admin()):?>
<input type="hidden" name="is_admin" value="yes" />
<?php endif;?>
        <div class="bottom-bottons">
            <input class="textarea" type="text" name="message" placeholder="<?php _e( 'Type here!', 'nm_wooconvo' ); ?>"/>
            <input type="submit" name="nm-wooconvo-send"
                class="nm-wooconvo-send button primary"
                value="<?php _e('Send', 'nm_wooconvo')?>"
                onclick="return send_order_message()">
            <input type="hidden" id="_order_file_name" name="_order_file_name">
            
            <span id="sending-order-message"></span>
        </div>
</div>