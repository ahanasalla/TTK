<?php

namespace Click_And_Pick\Emails;

/**
 * Class Email
 * @package Click_And_Pick\Emails
 */
use Click_And_Pick\Click_And_Pick;
use Click_And_Pick\Helpers\Helper;

/**
 * Class Email
 * @package Click_And_Pick\Emails
 */
class Email
{

    protected $helper;

    /**
     *
     */
    public function __construct()
    {
        $this->helper = new Helper();
        add_action('woocommerce_email_order_meta', array($this, 'click_and_pick_order_email'), 1);
    }

    /**
     * @param $order
     * @internal param $sent_to_admin
     * @internal param $plain_text
     */
    public function click_and_pick_order_email($order)
    {
        // check first if we are on the frontend only, because we check with the session
        if ( is_admin() ) return;

        $branch_title = $this->helper->get_branch($order->id, 'post_title');
        $branch_id = $this->helper->get_branch($order->id, 'ID');
        $pickup_time = $this->helper->get_order_time($order->id, $branch_id);
        list($pickupDateTime, $delayDateTime) = $this->helper->get_order_time($order->id, $branch_id);

        // check for the current shipping method is click and picl shipping method
        $chosen_methods = WC()->session->get( 'chosen_shipping_methods' );

        if (!empty($branch_title) && !empty($pickup_time) && is_array($chosen_methods) && in_array("click-and-pick_shipping_method", $chosen_methods)):
            echo '<h2>' . __('Click and Pick Details', Click_And_Pick::TEXTDOMAIN) . '</h2>';
            echo '<ul class="order_notes">';
            ?>
				<li class="">
                    <p class="meta-branch-<?php echo $branch_id ?>">
                        <b><?php _e('Pickup Branch :', \Click_And_Pick\Click_And_Pick::TEXTDOMAIN)?></b>
                        <?php echo $branch_title ?>
                    </p>
                </li>

                <li class="">
                     <p>
                        <b><?php _e('Pickup time chosen by user:', \Click_And_Pick\Click_And_Pick::TEXTDOMAIN)?></b>
                        <?php echo $pickupDateTime ?>
                    </p>
                </li>

                <?php if(!empty($delayDateTime)): ?>
                    <li class="">
                        <p>
                            <b><?php _e('Actual pickup time for this order :', \Click_And_Pick\Click_And_Pick::TEXTDOMAIN)?></b>
                            <?php echo $delayDateTime ?>
                        </p>
                    </li>
                <?php endif; ?>
				<?php
        echo '</ul>';
        endif;

    }

}