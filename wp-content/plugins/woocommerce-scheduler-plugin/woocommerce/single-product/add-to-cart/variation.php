<?php
/**
 * Single variation display
 *
 * This is a javascript-based template for single variations (see https://codex.wordpress.org/Javascript_Reference/wp.template).
 * The values will be dynamically replaced after selecting attributes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.5.0
 */
if (! defined('ABSPATH')) {
    exit;
}
?>
<script type="text/template" id="tmpl-variation-template">
    <div class="woocommerce-variation-description">
        {{{ data.variation.variation_description }}}
    </div>

    <div class="woocommerce-variation-price">
        {{{ data.variation.price_html }}}
    </div>

    <div class="woocommerce-variation-availability">
        {{{ data.variation.availability_html }}}
    </div>
</script>
<script type="text/template" id="tmpl-unavailable-variation-template">
    <p>
    <?php
    if (get_option('woocommerce_custom_product_expiration') != "") {
            echo  "<p class='wdm_message'>" . get_option('woocommerce_custom_product_expiration') . "</p>";
    } else if (current_user_can('manage_options')) {
        echo "<p class='wdm_message'>" . __('You can set a custom message in <br/>Woocommerce->Settings->General->Product Expiration Message', WDM_WOO_SCHED_TXT_DOMAIN) . "</p>";
    }
    // _e('Sorry, this product is unavailable. Please choose a different combination..................', 'woocommerce');
    ?>
    </p>
</script>
