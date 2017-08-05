<?php
remove_action('woocommerce_sidebar','woocommerce_get_sidebar',10);
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);
add_filter( 'woocommerce_show_page_title', '__return_false');
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
remove_action( 'woocommerce_archive_description', 'woocommerce_taxonomy_archive_description', 10);
remove_action( 'woocommerce_archive_description', 'woocommerce_product_archive_description', 10);

add_action('woocommerce_below_title','woocommerce_breadcrumb',10);
add_action('woocommerce_below_title','woocommerce_taxonomy_archive_description',20);
add_action('woocommerce_below_title','woocommerce_product_archive_description',20);
add_action('woocommerce_before_main_content','archive_page_start',5);
add_action('woocommerce_after_main_content','archive_page_end',5);
remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );


function archive_page_start(){ 
    $header_image = of_get_option('archive_title_bg');
    $header_bg_color = of_get_option('archive_title_bg_color');
    $header_image_option = of_get_option('archive_title_bg_option');
    $header_image_bg = "";

    if (!empty($header_image) && $header_image_option == '1'):
        $header_image_bg = 'background-image:url(' . $header_image . ');'; 
    endif;
    if (!empty($header_bg_color) && $header_image_option == '1'):
        $header_image_bg .= 'background-color:' . $header_bg_color ; 
    endif;
    ?>

    <div id="main-wrap">
    <div id="header-wrap" style="<?php echo $header_image_bg; ?>">
        <header class="entry-header">
            <div class="entry-header-inner">
                <div class="title-breadcrumb-wrap">
                    <h1 class="entry-title"><?php woocommerce_page_title(); ?></h1>
                    <?php do_action('woocommerce_below_title'); ?>
                </div>
            </div>
        </header><!-- .entry-header -->
    </div>
    <div class="mid-content clearfix">
    <div id="primary" class="content-area">
    <?php
}

function archive_page_end(){ 
    ?>
    </div>
    <?php get_sidebar('shop'); ?>
    </div>
    </div>
    <?php
}

// Change number or products per row to 3
add_filter('loop_shop_columns', 'ap_loop_columns');
if (!function_exists('ap_loop_columns')) {
	function ap_loop_columns() {
		return 3; // 3 products per row
	}
}

//Change number of related products on product page
add_filter( 'woocommerce_output_related_products_args', 'ap_related_products_args' );
if (!function_exists('ap_related_products_args')) {
	function ap_related_products_args( $args ) {
        $args['posts_per_page'] = 3; // 3 related products
        $args['columns'] = 3; // arranged in 3 columns
        return $args;
	}
}

add_action( 'body_class', 'ap_woo_body_class');
if (!function_exists('ap_woo_body_class')) {
	function ap_woo_body_class( $class ) {
        $class[] = 'columns-'.ap_loop_columns();
        return $class;
	}
}