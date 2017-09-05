<?php
require_once 'includes/classes/Helpers.php';
use TtkAccessParallaxPro\Helpers;

// Remove elements that are not used
require_once 'includes/classes/CleanUp.php';
$cleanUp = new \TtkAccessParallaxPro\CleanUp();
$cleanUp->init();

require_once 'includes/classes/Optimize.php';
new \TtkAccessParallaxPro\Optimize($cleanUp);

// Load assets from the child theme
require_once 'includes/classes/Scripts.php';
new \TtkAccessParallaxPro\Scripts;

// Global Options
require_once 'includes/classes/Options.php';
$options = new \TtkAccessParallaxPro\Options;
$options->init();

add_action('wp_head', function() {
	?>
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<?php
});

// Prevent automatic updates
add_filter('auto_update_core', '__return_false');
add_filter('auto_update_plugin', '__return_false');
add_filter('auto_update_theme', '__return_false');

// Display all the products within the same menu
// This function will be used by the parent theme "accesspress_parallax_pro"
// for "woocommerce_output_related_products_args" filter
function ap_related_products_args($args)
{
    $args['posts_per_page'] = 6;
    $args['columns'] = 3;

    return $args;
}

add_action('wp', function() {
    $isProductCat = function_exists('is_product_category') && is_product_category();
    $isShopPage = function_exists('is_shop') && is_shop();

    if ($isProductCat || $isShopPage) {
        // Remove navigation breadcrumb on menu page as it's irrelevant
        // and there's no need for duplicate content in the page
        add_filter('woocommerce_breadcrumb_defaults', '__return_false');
        remove_action('woocommerce_below_title', 'woocommerce_breadcrumb', 10);
    }
});

add_action('wp_loaded', function () {
    ob_start (function ($content) {
        if (is_admin()) {
            return $content;
        }

        global $post;

        $isParentShop = (function_exists('is_shop') && (is_shop() && !is_product_category()));
        $hasHeaderImage = (strpos($content, 'data-has-header-image') !== false);

        // Remove title as the same text is already shown on the menu
        if ('blog' === $post->post_name || $isParentShop || $hasHeaderImage) {
            $content = Helpers::replaceStringWithStartEnd(
                $content,
                '',
                '<h1 class="entry-title">',
                '</h1>'
            );
        }

        return $content;
    });
}, PHP_INT_MAX);

add_filter('woocommerce_short_description', function($content) {
    $pageId = false;

    // "ORDER" page
    if (function_exists('is_shop') && is_shop()) {
        $pageId = get_option('woocommerce_shop_page_id');
    }

    if (! $pageId) {
        return $content;
    }

    $single_header_image = get_post_meta($pageId, 'accesspress_parallax_page_header_image', true);

    $before = '';

    if ($single_header_image) {
        $title = get_the_title($pageId);

        $before = <<<HTML
<img data-has-header-image="true" class="ttk-hide-for-xs" src="{$single_header_image}" alt="" />
<h1 class="ttk-title">{$title}</h1>
HTML;
    }

    return $before . $content;
});


add_action('ttk_top_page_header', function($pageId) {
    $single_header_image = get_post_meta($pageId, 'accesspress_parallax_page_header_image', true);

    if ($single_header_image) {
    ?>
        <img data-has-header-image="true" class="ttk-hide-for-xs" src="<?php echo $single_header_image; ?>" alt="" />

        <?php
        $title = get_the_title($pageId);

        if ($title) {
        ?>
            <h1 class="ttk-title"><?php echo $title; ?></h1>
        <?php
        }
    }
});

add_action('woocommerce_cart_loaded_from_session', 'wh_checkAndUpdateCart');

function wh_checkAndUpdateCart()
{

    //if the cart is empty do nothing
    if (WC()->cart->get_cart_contents_count() == 0)
    {
        return;
    }

    foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item)
    {
        $product_id = $cart_item['product_id']; // Product ID
        $product_qty = $cart_item['quantity']; // Product quantity

        if (has_term('hot-lunch-med', 'product_tag', $product_id) && ($product_qty < 20))
        {
            WC()->cart->set_quantity($cart_item_key, 20);
        }
        else if (has_term('hot-lunch-sic', 'product_tag', $product_id) && ($product_qty < 20))
        {
            WC()->cart->set_quantity($cart_item_key, 20);
        }
        else if (has_term('hot-lunch-indian', 'product_tag', $product_id) && ($product_qty < 20))
        {
            WC()->cart->set_quantity($cart_item_key, 20);
        }
        else if (has_term('hot-lunch-korean', 'product_tag', $product_id) && ($product_qty < 20))
        {
            WC()->cart->set_quantity($cart_item_key, 20);
        }
        else if (has_term('hot-lunch-italian', 'product_tag', $product_id) && ($product_qty < 20))
        {
            WC()->cart->set_quantity($cart_item_key, 20);
        }
        else if (has_term('hot-lunch-irish', 'product_tag', $product_id) && ($product_qty < 20))
        {
            WC()->cart->set_quantity($cart_item_key, 20);
        }
    }
}



