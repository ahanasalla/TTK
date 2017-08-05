<?php
/**
 * Shop breadcrumb
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/breadcrumb.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.0
 * @see         woocommerce_breadcrumb()
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$show_breadcrumb = false;

if ( ! empty( $breadcrumb ) && $show_breadcrumb ) {
    echo $wrap_before;

    // If we are on the single product page, remove the product title as we already have it in the headline
    // and make sure that all links from the breadcrumb are click-able
    if (is_product()) {
        end($breadcrumb);
        $lastKey = key($breadcrumb);

        // Remove last item which is the title
        if (isset($breadcrumb[$lastKey][1]) && (! $breadcrumb[$lastKey][1])) {
            unset($breadcrumb[$lastKey]);
        }
    }

    foreach ( $breadcrumb as $key => $crumb ) {
        echo $before;

        // Remove "Home" breadcrumb
        if (strtolower($crumb[0]) === 'home') {
            continue;
        }

        if ( ! empty( $crumb[1] ) ) {
            echo '<a href="' . esc_url( $crumb[1] ) . '">' . esc_html( $crumb[0] ) . '</a>';
        } else {
            echo esc_html( $crumb[0] );
        }

        echo $after;

        if ( sizeof( $breadcrumb ) !== $key + 1 ) {
            echo $delimiter;
        }
    }

    echo $wrap_after;
}
