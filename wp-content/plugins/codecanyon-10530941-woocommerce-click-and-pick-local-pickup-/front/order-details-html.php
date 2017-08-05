<?php
$branch_title = $this->helper->get_branch($order->id, 'post_title');
$branch_id = $this->helper->get_branch($order->id, 'ID');
$pickup_time = $this->helper->get_order_time($order->id, $branch_id);
list($pickupDateTime, $delayDateTime) = $this->helper->get_order_time($order->id, $branch_id);

?>
<div class="clicknpick-order-details">
	    <h4> <?php _e('Click and Pick Details', \Click_And_Pick\Click_And_Pick::TEXTDOMAIN)?> </h4>

	    <p>
	        <b><?php _e('Pickup Branch :', \Click_And_Pick\Click_And_Pick::TEXTDOMAIN)?></b>
	        <?php echo $branch_title ?>
	    </p>
	    <p>
	        <b><?php _e('Pickup time chosen by user:', \Click_And_Pick\Click_And_Pick::TEXTDOMAIN)?></b>
	        <?php echo $pickupDateTime ?>
	    </p>
	    <?php if(!empty($delayDateTime)): ?>
		    <p>
		        <b><?php _e('Actual pickup time for this order :', \Click_And_Pick\Click_And_Pick::TEXTDOMAIN)?></b>
		        <?php echo $delayDateTime ?>
		    </p>
		<?php endif; ?>
</div>