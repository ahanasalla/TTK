<?php
/*
 * this template is loading all conversations
 * against one order
 * used for: Front-end & Admin
 */
 
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
exit;
}

global $wooconvo;

$convos = $wooconvo -> get_order_convos();

if($convos):

echo '<input type="hidden" name="existing_convo_id" value="'.esc_attr($wooconvo->order_id).'" />';


$thread = json_decode($convos -> convo_thread);

// $wooconvo -> pa($thread);
?>

<div class="wooconvo-send">
    <div class="chat-container">
        <ol class="chat">
        <?php foreach ($thread as $msg) {
        		if (is_admin()) {
        			$css_class = ($msg->sent_by == 'Shop Manager') ? 'self' : 'other' ;
        		} else {
        			$css_class = ($msg->sent_by == 'Shop Manager') ? 'other' : 'self' ;
        		}
        	?>
            <li class="<?php echo $css_class; ?>">
                <div class="avatar">
					<?php
						if ($msg->user == 'admin') {
							echo get_avatar( get_bloginfo( 'admin_email' ), 128 );
						} else {
							echo get_avatar( $msg->user, 128 );
						}
					?>
                </div>
                <div class="msg">
                    <p><strong><?php echo $msg->sent_by; ?></strong></p>
                    <p>
                        <?php echo stripslashes($msg->message); ?>
						<?php if ($msg->files != '') {
							$wooconvo -> render_attachments($msg->files);
						} ?>                        
                    </p>
                    <time><span class="dashicons dashicons-clock"></span> <?php echo $wooconvo->time_difference($msg->senton); ?></time>
                </div>
            </li>        	
        <?php } ?>
        </ol>
    </div>	
</div>
<?php endif; ?>



