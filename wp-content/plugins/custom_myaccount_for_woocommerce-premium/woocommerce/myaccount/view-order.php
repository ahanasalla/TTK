<?php
/**
 * View Order
 *
 * Shows the details of a particular order on the account page
 *
 * @author    WooThemes
 * @package   WooCommerce/Templates
 * @version   2.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<?php 
 $row1 = get_option('myaccount_general_setting');

?>

<div id="phoen-wcmap-wrap" class="phoen-wcmap woocommerce">
<div class="phoen-wcmap-row">
<div class="phoen-myaccount-menu <?php if($row1['menu_style']!='sidebar'){?> pho-horizontal<?php } ?>">

<?php
if($row1['custom_profile']=='enable')
{
?>
    <div class="pho-user-profile">
        <div class="pho-user-image">
		<?php
        $current_user = wp_get_current_user();
        $user_id = $current_user->ID;
        echo phoen_get_avatar($user_id, '',120, '', '', '');	
        ?>
		</div>       
        <div class="pho-user-info">
            <p class="pho-username"> <?php echo $current_user->display_name;?> </p>
            <a href="<?php echo wp_logout_url( get_permalink( wc_get_page_id( 'myaccount' ) ) ); ?> " class="pho-logout">Logout</a>
        </div>
    </div>
<?php } ?>

<ul class="myaccount-menu<?php if($row1['menu_style']!='sidebar'){?> pho-ph-horizontal<?php } ?>">
<?php 

$data = get_option('phoen-endpoint');

$endpoint = explode(',',$data);

	foreach($endpoint as $ep)
	{
		$row = get_option('phoen-endpoint-'.$ep.'');
		
		if($row['active']==1)
		{
	
?>
<li><a href="<?php get_permalink( wc_get_page_id( 'myaccount' ) );?>?temp=<?php echo $ep;?>"><i class="fa fa-<?php echo $row['icon'];?>"></i><span><?php echo $row['label'];?></span></a></li>
<?php
		}
	}
 ?>

</ul>
</div>
<div class="phoen-myaccount-content<?php if($row1['menu_style']!='sidebar'){?> pho-horizontal<?php } ?>">

<p><?php
	printf(
		__( 'Order #%1$s was placed on %2$s and is currently %3$s.', 'woocommerce' ),
		'<mark class="order-number">' . $order->get_order_number() . '</mark>',
		'<mark class="order-date">' . date_i18n( get_option( 'date_format' ), strtotime( $order->order_date ) ) . '</mark>',
		'<mark class="order-status">' . wc_get_order_status_name( $order->get_status() ) . '</mark>'
	);
?></p>

<?php if ( $notes = $order->get_customer_order_notes() ) :
	?>
	<h2><?php _e( 'Order Updates', 'woocommerce' ); ?></h2>
	<ol class="commentlist notes">
		<?php foreach ( $notes as $note ) : ?>
		<li class="comment note">
			<div class="comment_container">
				<div class="comment-text">
					<p class="meta"><?php echo date_i18n( __( 'l jS \o\f F Y, h:ia', 'woocommerce' ), strtotime( $note->comment_date ) ); ?></p>
					<div class="description">
						<?php echo wpautop( wptexturize( $note->comment_content ) ); ?>
					</div>
	  				<div class="clear"></div>
	  			</div>
				<div class="clear"></div>
			</div>
		</li>
		<?php endforeach; ?>
	</ol>
	<?php
endif;

do_action('woocommerce_view_order', $order_id);
?>
</div>
</div>
</div>


