<?php
/**
 * My Account page
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
global $post, $wp, $woocommerce;

wc_print_notices(); 

$row1 = get_option('myaccount_general_setting');

if(isset($_GET['temp'])):
	
	$active_button = $_GET['temp'];
	
else:

	$active_button = '';
	
endif;
	
 
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
            <a href="<?php echo wp_logout_url( get_permalink( wc_get_page_id( 'myaccount' ) ) ); ?> " class="pho-logout"><?php _e('Logout','woocommerce');?></a>
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
<li <? echo ($active_button!= '' && $active_button == $ep)?'class="active"':'';?>><a href="?temp=<?php echo $ep;?>"><i class="fa fa-<?php echo $row['icon'];?>"></i><span><?php echo $row['label'];?></span></a></li>
<?php
		}
	}
 ?>

</ul>
</div>
<div class="phoen-myaccount-content<?php if($row1['menu_style']!='sidebar'){?> pho-horizontal<?php } ?>">
<?php 
	
do_action( 'woocommerce_before_my_account');

if(isset($_GET['temp']))
{
	 $tab_type = $_GET['temp'];
	 
	 $row = get_option('phoen-endpoint-'.$tab_type.'');
	 
		 
	if($tab_type == 'edit-account' && $row['content']=='')
	{
		
		 wc_get_template( 'myaccount/form-edit-account.php', array( 'user' => get_user_by( 'id', get_current_user_id() ) ) );
		 
	}
	else if($tab_type == 'edit-address' && $row['content']=='')
	{
		wc_get_template( 'myaccount/my-address.php' ); 
	}
	else if($tab_type == 'dashboard' && $row['content']=='')
	{
	?>
		<p class="myaccount_user">
			<?php
			echo sprintf( esc_attr__( 'Hello %s%s%s (not %2$s? %sSign out%s)', 'woocommerce' ), '<strong>', esc_html( $current_user->display_name ), '</strong>', '<a href="' . esc_url( wc_get_endpoint_url( 'customer-logout', '', wc_get_page_permalink( 'myaccount' ) ) ) . '">', '</a>' );
				$edit_account = get_site_url().'/my-account/?temp=edit-account';
			echo sprintf( esc_attr__( 'From your account dashboard you can view your %1$srecent orders%2$s, manage your %3$sshipping and billing addresses%2$s and %4$sedit your password and account details%2$s.', 'woocommerce' ), '<a href="' . esc_url( wc_get_endpoint_url( 'orders' ) ) . '">', '</a>', '<a href="' . esc_url( wc_get_endpoint_url( 'edit-address' ) ) . '">', '<a href="' . esc_url( wc_get_endpoint_url( 'edit-account' ) ) . '">' );
			?>
		</p><br/>
	
<?php
wc_get_template( 'myaccount/my-orders.php', array( 'order_count' => 200 ) );	

echo "<br />";
wc_get_template( 'myaccount/my-address.php' );	
	}
	else 
	{

		 echo do_shortcode(stripslashes($row['content']));
	}
}
else
{
	
?>
	<p class="myaccount_user">
		
		<?php
		
			echo sprintf( esc_attr__( 'Hello %s%s%s (not %2$s? %sSign out%s)', 'woocommerce' ), '<strong>', esc_html( $current_user->display_name ), '</strong>', '<a href="' . esc_url( wc_get_endpoint_url( 'customer-logout', '', wc_get_page_permalink( 'myaccount' ) ) ) . '">', '</a>' );
			
			$edit_account = get_site_url().'/my-account/?temp=edit-account';

			echo sprintf( esc_attr__( 'From your account dashboard you can view your %1$srecent orders%2$s, manage your %3$sshipping and billing addresses%2$s and %4$sedit your password and account details%2$s.', 'woocommerce' ), '<a href="' . esc_url( wc_get_endpoint_url( 'orders' ) ) . '">', '</a>', '<a href="' . esc_url( wc_get_endpoint_url( 'edit-address' ) ) . '">', '<a href="' . esc_url( wc_get_endpoint_url( 'edit-account' ) ) . '">' );

		?>
	</p><br/>

<?php
wc_get_template( 'myaccount/my-orders.php', array( 'order_count' => 200 ) );	

echo "<br />";
wc_get_template( 'myaccount/my-address.php' );	
	
}

?>








<?php //wc_get_template( 'myaccount/form-edit-address.php' ); ?>


<?php do_action( 'woocommerce_after_my_account' ); ?>
</div>
</div>
</div>

