<?php
function pimpmywoo_preview_archive() {
    ?>
    <script type="text/javascript">
		( function( $ ) {

/* PAGE */

		    wp.customize('btn_list_bg',function( value ) { value.bind(function(to) { $('body.woocommerce-page ul.products a.button').css('background', to ); }); });
		    wp.customize('btn_list_bg_hover',function( value ) { value.bind(function(to) { $('body.woocommerce-page ul.products a.button:hover').css('background', to ); }); });
		    wp.customize('btn_list_color',function( value ) { value.bind(function(to) { $('body.woocommerce-page ul.products a.button').css('color', to ); }); });
		    wp.customize('btn_list_color_hover',function( value ) { value.bind(function(to) { $('body.woocommerce-page ul.products a.button:hover').css('color', to ); }); });
		    wp.customize('btn_list_border_width',function( value ) { value.bind(function(to) { $('body.woocommerce-page ul.products a.button').css('border-width', to+'px' ); }); });
		    wp.customize('btn_list_border_color',function( value ) { value.bind(function(to) { $('body.woocommerce-page ul.products a.button').css('border-color', to ); }); });
		    wp.customize('btn_list_border_color_hover',function( value ) { value.bind(function(to) { $('body.woocommerce-page ul.products a.button:hover').css('border-color', to ); }); });
		    wp.customize('btn_list_border_style',function( value ) { value.bind(function(to) {  $('body.woocommerce-page ul.products a.button').css('border-style', to ); }); });
		    wp.customize('btn_list_border_radius',function( value ) { value.bind(function(to) { $('body.woocommerce-page ul.products a.button').css('-webkit-border-radius', to+'px' ); $('body.woocommerce-page ul.products a.button').css('-moz-border-radius', to+'px' ); $('body.woocommerce-page ul.products a.button').css('border-radius', to+'px' ); }); });
		    wp.customize('btn_list_font',function( value ) { value.bind(function(to) { $('body.woocommerce-page ul.products a.button').css('font-family', '"'+to+'"' ); }); });
		    wp.customize('btn_list_font_size',function( value ) { value.bind(function(to) { $('body.woocommerce-page ul.products a.button').css('font-size', to+'px' ); }); });
		    wp.customize('btn_list_font_weight',function( value ) { value.bind(function(to) { $('body.woocommerce-page ul.products a.button').css('font-weight', to ); }); });
		    wp.customize('btn_list_font_style',function( value ) { value.bind(function(to) { $('body.woocommerce-page ul.products a.button').css('font-style', to ); }); });
		    wp.customize('btn_list_line_height',function( value ) { value.bind(function(to) { $('body.woocommerce-page ul.products a.button').css('line-height', to+'px' ); }); });
		    wp.customize('btn_list_letter_spacing',function( value ) { value.bind(function(to) { $('body.woocommerce-page ul.products a.button').css('letter-spacing', to+'px' ); }); });
		    wp.customize('btn_list_text_transform',function( value ) { value.bind(function(to) { $('body.woocommerce-page ul.products a.button').css('text-transform', to ); }); });


		    wp.customize('title_list_font',function( value ) { value.bind(function(to) { $('body.woocommerce-page ul.products a h3').css('font-family', '"'+to+'"' ); }); });
		    wp.customize('title_list_color',function( value ) { value.bind(function(to) { $('body.woocommerce-page ul.products a h3').css('color', to ); }); });
		    wp.customize('title_list_color_hover',function( value ) { value.bind(function(to) { $('body.woocommerce-page ul.products a:hover h3').css('color', to ); }); });
		    wp.customize('title_list_font_size',function( value ) { value.bind(function(to) { $('body.woocommerce-page ul.products h3').css('font-size', to+'px' ); }); });
		    wp.customize('title_list_font_weight',function( value ) { value.bind(function(to) { $('body.woocommerce-page ul.products h3').css('font-weight', to ); }); });
		    wp.customize('title_list_font_style',function( value ) { value.bind(function(to) { $('body.woocommerce-page ul.products h3').css('font-style', to ); }); });
		    wp.customize('title_list_line_height',function( value ) { value.bind(function(to) { $('body.woocommerce-page ul.products h3').css('line-height', to+'px' ); }); });
		    wp.customize('title_list_letter_spacing',function( value ) { value.bind(function(to) { $('body.woocommerce-page ul.products h3').css('letter-spacing', to+'px' ); }); });
		    wp.customize('title_list_text_transform',function( value ) { value.bind(function(to) { $('body.woocommerce-page ul.products h3').css('text-transform', to ); }); });


		    wp.customize('price_list_font',function( value ) { value.bind(function(to) { $('body.woocommerce-page ul.products .price').css('font-family', '"'+to+'"' ); }); });
		    wp.customize('price_list_color',function( value ) { value.bind(function(to) { $('body.woocommerce-page ul.products .price').css('color', to ); }); });
		    wp.customize('price_list_color_hover',function( value ) { value.bind(function(to) { $('body.woocommerce-page ul.products a:hover .price').css('color', to ); }); });
		    wp.customize('price_list_font_size',function( value ) { value.bind(function(to) { $('body.woocommerce-page ul.products .price').css('font-size', to+'px' ); }); });
		    wp.customize('price_list_font_weight',function( value ) { value.bind(function(to) { $('body.woocommerce-page ul.products .price').css('font-weight', to ); }); });
		    wp.customize('price_list_font_style',function( value ) { value.bind(function(to) { $('body.woocommerce-page ul.products .price').css('font-style', to ); }); });
		    wp.customize('price_list_line_height',function( value ) { value.bind(function(to) { $('body.woocommerce-page ul.products .price').css('line-height', to+'px' ); }); });
		    wp.customize('price_list_letter_spacing',function( value ) { value.bind(function(to) { $('body.woocommerce-page ul.products .price').css('letter-spacing', to+'px' ); }); });
		    wp.customize('price_list_text_transform',function( value ) { value.bind(function(to) { $('body.woocommerce-page ul.products .price').css('text-transform', to ); }); });

		    wp.customize('img_list_border_width',function( value ) { value.bind(function(to) { $('body.woocommerce-page ul.products a img.wp-post-image').css('border-width', to+'px' ); }); });
		    wp.customize('img_list_border_color',function( value ) { value.bind(function(to) { $('body.woocommerce-page ul.products a img.wp-post-image').css('border-color', to ); }); });
		    wp.customize('img_list_border_color_hover',function( value ) { value.bind(function(to) { $('body.woocommerce-page ul.products a:hover img.wp-post-image').css('border-color', to ); }); });
		    wp.customize('img_list_border_style',function( value ) { value.bind(function(to) {  $('body.woocommerce-page ul.products a img.wp-post-image').css('border-style', to ); }); });
		    wp.customize('img_list_border_radius',function( value ) { value.bind(function(to) { $('body.woocommerce-page ul.products a img.wp-post-image').css('-webkit-border-radius', to+'px' ); $('body.woocommerce-page ul.products a img.wp-post-image').css('-moz-border-radius', to+'px' ); $('body.woocommerce-page ul.products a img.wp-post-image').css('border-radius', to+'px' ); }); });

		    wp.customize('sbadge_list_bg',function( value ) { value.bind(function(to) { $('body.woocommerce-page ul.products a .onsale').css('background', to ); }); });
		    wp.customize('sbadge_list_bg_hover',function( value ) { value.bind(function(to) { $('body.woocommerce-page ul.products a:hover .onsale').css('background', to ); }); });
		    wp.customize('sbadge_list_color',function( value ) { value.bind(function(to) { $('body.woocommerce-page ul.products a .onsale').css('color', to ); }); });
		    wp.customize('sbadge_list_color_hover',function( value ) { value.bind(function(to) { $('body.woocommerce-page ul.products a:hover .onsale').css('color', to ); }); });
		    wp.customize('sbadge_list_border_width',function( value ) { value.bind(function(to) { $('body.woocommerce-page ul.products a .onsale').css('border-width', to+'px' ); }); });
		    wp.customize('sbadge_list_border_color',function( value ) { value.bind(function(to) { $('body.woocommerce-page ul.products a .onsale').css('border-color', to ); }); });
		    wp.customize('sbadge_list_border_color_hover',function( value ) { value.bind(function(to) { $('body.woocommerce-page ul.products a:hover .onsale').css('border-color', to ); }); });
		    wp.customize('sbadge_list_border_style',function( value ) { value.bind(function(to) {  $('body.woocommerce-page ul.products a .onsale').css('border-style', to ); }); });
		    wp.customize('sbadge_list_border_radius',function( value ) { value.bind(function(to) { $('body.woocommerce-page ul.products a .onsale').css('-webkit-border-radius', to+'px' ); $('body.woocommerce-page ul.products a.button').css('-moz-border-radius', to+'px' ); $('body.woocommerce-page ul.products a .onsale').css('border-radius', to+'px' ); }); });
		    wp.customize('sbadge_list_font',function( value ) { value.bind(function(to) { $('body.woocommerce-page ul.products a .onsale').css('font-family', '"'+to+'"' ); }); });
		    wp.customize('sbadge_list_font_size',function( value ) { value.bind(function(to) { $('body.woocommerce-page ul.products a .onsale').css('font-size', to+'px' ); }); });
		    wp.customize('sbadge_list_font_weight',function( value ) { value.bind(function(to) { $('body.woocommerce-page ul.products a .onsale').css('font-weight', to ); }); });
		    wp.customize('sbadge_list_font_style',function( value ) { value.bind(function(to) { $('body.woocommerce-page ul.products a .onsale').css('font-style', to ); }); });
		    wp.customize('sbadge_list_line_height',function( value ) { value.bind(function(to) { $('body.woocommerce-page ul.products a .onsale').css('line-height', to+'px' ); }); });
		    wp.customize('sbadge_list_letter_spacing',function( value ) { value.bind(function(to) { $('body.woocommerce-page ul.products a .onsale').css('letter-spacing', to+'px' ); }); });
		    wp.customize('sbadge_list_text_transform',function( value ) { value.bind(function(to) { $('body.woocommerce-page ul.products a .onsale').css('text-transform', to ); }); });
		    wp.customize('sbadge_list_padding',function( value ) { value.bind(function(to) { $('body.woocommerce-page ul.products a .onsale').css('padding', to ); }); });


/* SIDEBAR */
		    wp.customize('title_sidebar_font',function( value ) { value.bind(function(to) { $('body.woocommerce-page.archive ul.product_list_widget a .product-title').css('font-family', '"'+to+'"' ); }); });
		    wp.customize('title_sidebar_color',function( value ) { value.bind(function(to) { $('body.woocommerce-page.archive ul.product_list_widget a .product-title').css('color', to ); }); });
		    wp.customize('title_sidebar_color_hover',function( value ) { value.bind(function(to) { $('body.woocommerce-page.archive ul.product_list_widget a:hover .product-title').css('color', to ); }); });
		    wp.customize('title_sidebar_font_size',function( value ) { value.bind(function(to) { $('body.woocommerce-page.archive ul.product_list_widget .product-title').css('font-size', to+'px' ); }); });
		    wp.customize('title_sidebar_font_weight',function( value ) { value.bind(function(to) { $('body.woocommerce-page.archive ul.product_list_widget .product-title').css('font-weight', to ); }); });
		    wp.customize('title_sidebar_font_style',function( value ) { value.bind(function(to) { $('body.woocommerce-page.archive ul.product_list_widget .product-title').css('font-style', to ); }); });
		    wp.customize('title_sidebar_line_height',function( value ) { value.bind(function(to) { $('body.woocommerce-page.archive ul.product_list_widget .product-title').css('line-height', to+'px' ); }); });
		    wp.customize('title_sidebar_letter_spacing',function( value ) { value.bind(function(to) { $('body.woocommerce-page.archive ul.product_list_widget .product-title').css('letter-spacing', to+'px' ); }); });
		    wp.customize('title_sidebar_text_transform',function( value ) { value.bind(function(to) { $('body.woocommerce-page.archive ul.product_list_widget .product-title').css('text-transform', to ); }); });


		    wp.customize('price_sidebar_font',function( value ) { value.bind(function(to) { $('body.woocommerce-page.archive ul.product_list_widget .amount').css('font-family', '"'+to+'"' ); }); });
		    wp.customize('price_sidebar_color',function( value ) { value.bind(function(to) { $('body.woocommerce-page.archive ul.product_list_widget .amount').css('color', to ); }); });
		    wp.customize('price_sidebar_font_size',function( value ) { value.bind(function(to) { $('body.woocommerce-page.archive ul.product_list_widget .amount').css('font-size', to+'px' ); }); });
		    wp.customize('price_sidebar_font_weight',function( value ) { value.bind(function(to) { $('body.woocommerce-page.archive ul.product_list_widget .amount').css('font-weight', to ); }); });
		    wp.customize('price_sidebar_font_style',function( value ) { value.bind(function(to) { $('body.woocommerce-page.archive ul.product_list_widget .amount').css('font-style', to ); }); });
		    wp.customize('price_sidebar_line_height',function( value ) { value.bind(function(to) { $('body.woocommerce-page.archive ul.product_list_widget .amount').css('line-height', to+'px' ); }); });
		    wp.customize('price_sidebar_letter_spacing',function( value ) { value.bind(function(to) { $('body.woocommerce-page.archive ul.product_list_widget .amount').css('letter-spacing', to+'px' ); }); });
		    wp.customize('price_sidebar_text_transform',function( value ) { value.bind(function(to) { $('body.woocommerce-page.archive ul.product_list_widget .amount').css('text-transform', to ); }); });

		    wp.customize('img_sidebar_border_width',function( value ) { value.bind(function(to) { $('body.woocommerce-page.archive ul.product_list_widget a img.wp-post-image').css('border-width', to+'px' ); }); });
		    wp.customize('img_sidebar_border_color',function( value ) { value.bind(function(to) { $('body.woocommerce-page.archive ul.product_list_widget a img.wp-post-image').css('border-color', to ); }); });
		    wp.customize('img_sidebar_border_color_hover',function( value ) { value.bind(function(to) { $('body.woocommerce-page.archive ul.product_list_widget a:hover img.wp-post-image').css('border-color', to ); }); });
		    wp.customize('img_sidebar_border_style',function( value ) { value.bind(function(to) {  $('body.woocommerce-page.archive ul.product_list_widget a img.wp-post-image').css('border-style', to ); }); });
		    wp.customize('img_sidebar_border_radius',function( value ) { value.bind(function(to) { $('body.woocommerce-page.archive ul.product_list_widget a img.wp-post-image').css('-webkit-border-radius', to+'px' ); $('body.woocommerce-page.archive ul.product_list_widget a img.wp-post-image').css('-moz-border-radius', to+'px' ); $('body.woocommerce-page.archive ul.product_list_widget a img.wp-post-image').css('border-radius', to+'px' ); }); });

/* SINGLE */
		    wp.customize('btn_single_bg',function( value ) { value.bind(function(to) { $('body.woocommerce-page.single-product div.product form.cart .button').css('background', to ); }); });
		    wp.customize('btn_single_bg_hover',function( value ) { value.bind(function(to) { $('body.woocommerce-page.single-product div.product form.cart .button:hover').css('background', to ); }); });
		    wp.customize('btn_single_color',function( value ) { value.bind(function(to) { $('body.woocommerce-page.single-product div.product form.cart .button').css('color', to ); }); });
		    wp.customize('btn_single_color_hover',function( value ) { value.bind(function(to) { $('body.woocommerce-page.single-product div.product form.cart .button:hover').css('color', to ); }); });
		    wp.customize('btn_single_border_width',function( value ) { value.bind(function(to) { $('body.woocommerce-page.single-product div.product form.cart .button').css('border-width', to+'px' ); }); });
		    wp.customize('btn_single_border_color',function( value ) { value.bind(function(to) { $('body.woocommerce-page.single-product div.product form.cart .button').css('border-color', to ); }); });
		    wp.customize('btn_single_border_color_hover',function( value ) { value.bind(function(to) { $('body.woocommerce-page.single-product div.product form.cart .button:hover').css('border-color', to ); }); });
		    wp.customize('btn_single_border_style',function( value ) { value.bind(function(to) {  $('body.woocommerce-page.single-product div.product form.cart .button').css('border-style', to ); }); });
		    wp.customize('btn_single_border_radius',function( value ) { value.bind(function(to) { $('body.woocommerce-page.single-product div.product form.cart .button').css('-webkit-border-radius', to+'px' ); $('body.woocommerce-page.single-product div.product form.cart .button').css('-moz-border-radius', to+'px' ); $('body.woocommerce-page.single-product div.product form.cart .button').css('border-radius', to+'px' ); }); });
		    wp.customize('btn_single_font',function( value ) { value.bind(function(to) { $('body.woocommerce-page.single-product div.product form.cart .button').css('font-family', '"'+to+'"' ); }); });
		    wp.customize('btn_single_font_size',function( value ) { value.bind(function(to) { $('body.woocommerce-page.single-product div.product form.cart .button').css('font-size', to+'px' ); }); });
		    wp.customize('btn_single_font_weight',function( value ) { value.bind(function(to) { $('body.woocommerce-page.single-product div.product form.cart .button').css('font-weight', to ); }); });
		    wp.customize('btn_single_font_style',function( value ) { value.bind(function(to) { $('body.woocommerce-page.single-product div.product form.cart .button').css('font-style', to ); }); });
		    wp.customize('btn_single_line_height',function( value ) { value.bind(function(to) { $('body.woocommerce-page.single-product div.product form.cart .button').css('line-height', to+'px' ); }); });
		    wp.customize('btn_single_letter_spacing',function( value ) { value.bind(function(to) { $('body.woocommerce-page.single-product div.product form.cart .button').css('letter-spacing', to+'px' ); }); });
		    wp.customize('btn_single_text_transform',function( value ) { value.bind(function(to) { $('body.woocommerce-page.single-product div.product form.cart .button').css('text-transform', to ); }); });


		    wp.customize('title_single_font',function( value ) { value.bind(function(to) { $('body.woocommerce-page.single-product div.product .product_title').css('font-family', '"'+to+'"' ); }); });
		    wp.customize('title_single_color',function( value ) { value.bind(function(to) { $('body.woocommerce-page.single-product div.product .product_title').css('color', to ); }); });
		    wp.customize('title_single_font_size',function( value ) { value.bind(function(to) { $('body.woocommerce-page.single-product div.product .product_title').css('font-size', to+'px' ); }); });
		    wp.customize('title_single_font_weight',function( value ) { value.bind(function(to) { $('body.woocommerce-page.single-product div.product .product_title').css('font-weight', to ); }); });
		    wp.customize('title_single_font_style',function( value ) { value.bind(function(to) { $('body.woocommerce-page.single-product div.product .product_title').css('font-style', to ); }); });
		    wp.customize('title_single_line_height',function( value ) { value.bind(function(to) { $('body.woocommerce-page.single-product div.product .product_title').css('line-height', to+'px' ); }); });
		    wp.customize('title_single_letter_spacing',function( value ) { value.bind(function(to) { $('body.woocommerce-page.single-product div.product .product_title').css('letter-spacing', to+'px' ); }); });
		    wp.customize('title_single_text_transform',function( value ) { value.bind(function(to) { $('body.woocommerce-page.single-product div.product .product_title').css('text-transform', to ); }); });


		    wp.customize('price_single_font',function( value ) { value.bind(function(to) { $('body.woocommerce-page.single-product div.product .price').css('font-family', '"'+to+'"' ); }); });
		    wp.customize('price_single_color',function( value ) { value.bind(function(to) { $('body.woocommerce-page.single-product div.product .price').css('color', to ); }); });
		    wp.customize('price_single_font_size',function( value ) { value.bind(function(to) { $('body.woocommerce-page.single-product div.product .price').css('font-size', to+'px' ); }); });
		    wp.customize('price_single_font_weight',function( value ) { value.bind(function(to) { $('body.woocommerce-page.single-product div.product .price').css('font-weight', to ); }); });
		    wp.customize('price_single_font_style',function( value ) { value.bind(function(to) { $('body.woocommerce-page.single-product div.product .price').css('font-style', to ); }); });
		    wp.customize('price_single_line_height',function( value ) { value.bind(function(to) { $('body.woocommerce-page.single-product div.product .price').css('line-height', to+'px' ); }); });
		    wp.customize('price_single_letter_spacing',function( value ) { value.bind(function(to) { $('body.woocommerce-page.single-product div.product .price').css('letter-spacing', to+'px' ); }); });
		    wp.customize('price_single_text_transform',function( value ) { value.bind(function(to) { $('body.woocommerce-page.single-product div.product .price').css('text-transform', to ); }); });

		    wp.customize('img_single_border_width',function( value ) { value.bind(function(to) { $('body.woocommerce-page.single-product div.product img.woocommerce-main-image').css('border-width', to+'px' ); }); });
		    wp.customize('img_single_border_color',function( value ) { value.bind(function(to) { $('body.woocommerce-page.single-product div.product img.woocommerce-main-image').css('border-color', to ); }); });
		    wp.customize('img_single_border_color_hover',function( value ) { value.bind(function(to) { $('body.woocommerce-page.single-product div.product a:hover img.woocommerce-main-image').css('border-color', to ); }); });
		    wp.customize('img_single_border_style',function( value ) { value.bind(function(to) {  $('body.woocommerce-page.single-product div.product img.woocommerce-main-image').css('border-style', to ); }); });
		    wp.customize('img_single_border_radius',function( value ) { value.bind(function(to) { $('body.woocommerce-page.single-product div.product img.woocommerce-main-image').css('-webkit-border-radius', to+'px' ); $('body.woocommerce-page.single-product div.product img.woocommerce-main-image').css('-moz-border-radius', to+'px' ); $('body.woocommerce-page.single-product div.product img.woocommerce-main-image').css('border-radius', to+'px' ); }); });

		    wp.customize('sbadge_single_bg',function( value ) { value.bind(function(to) { $('body.woocommerce-page.single-product div.product .onsale').css('background', to ); }); });
		    wp.customize('sbadge_single_color',function( value ) { value.bind(function(to) { $('body.woocommerce-page.single-product div.product .onsale').css('color', to ); }); });
		    wp.customize('sbadge_single_border_width',function( value ) { value.bind(function(to) { $('body.woocommerce-page.single-product div.product .onsale').css('border-width', to+'px' ); }); });
		    wp.customize('sbadge_single_border_color',function( value ) { value.bind(function(to) { $('body.woocommerce-page.single-product div.product .onsale').css('border-color', to ); }); });
		    wp.customize('sbadge_single_border_style',function( value ) { value.bind(function(to) {  $('body.woocommerce-page.single-product div.product .onsale').css('border-style', to ); }); });
		    wp.customize('sbadge_single_border_radius',function( value ) { value.bind(function(to) { $('body.woocommerce-page.single-product div.product .onsale').css('-webkit-border-radius', to+'px' ); $('body.woocommerce-page.single-product div.product form.cart .button').css('-moz-border-radius', to+'px' ); $('body.woocommerce-page.single-product div.product .onsale').css('border-radius', to+'px' ); }); });
		    wp.customize('sbadge_single_font',function( value ) { value.bind(function(to) { $('body.woocommerce-page.single-product div.product .onsale').css('font-family', '"'+to+'"' ); }); });
		    wp.customize('sbadge_single_font_size',function( value ) { value.bind(function(to) { $('body.woocommerce-page.single-product div.product .onsale').css('font-size', to+'px' ); }); });
		    wp.customize('sbadge_single_font_weight',function( value ) { value.bind(function(to) { $('body.woocommerce-page.single-product div.product .onsale').css('font-weight', to ); }); });
		    wp.customize('sbadge_single_font_style',function( value ) { value.bind(function(to) { $('body.woocommerce-page.single-product div.product .onsale').css('font-style', to ); }); });
		    wp.customize('sbadge_single_line_height',function( value ) { value.bind(function(to) { $('body.woocommerce-page.single-product div.product .onsale').css('line-height', to+'px' ); }); });
		    wp.customize('sbadge_single_letter_spacing',function( value ) { value.bind(function(to) { $('body.woocommerce-page.single-product div.product .onsale').css('letter-spacing', to+'px' ); }); });
		    wp.customize('sbadge_single_text_transform',function( value ) { value.bind(function(to) { $('body.woocommerce-page.single-product div.product .onsale').css('text-transform', to ); }); });
		    wp.customize('sbadge_single_padding',function( value ) { value.bind(function(to) { $('body.woocommerce-page.single-product div.product .onsale').css('padding', to ); }); });




















		    wp.customize('table_cart_bg',function( value ) { value.bind(function(to) { $('body.woocommerce-cart .woocommerce .shop_table').css('background', to ); }); });
		    wp.customize('table_cart_border_width',function( value ) { value.bind(function(to) { $('body.woocommerce-cart .woocommerce .shop_table').css('border-width', to+'px' ); }); });
		    wp.customize('table_cart_border_color',function( value ) { value.bind(function(to) { $('body.woocommerce-cart .woocommerce .shop_table').css('border-color', to ); }); });
		    wp.customize('table_cart_border_style',function( value ) { value.bind(function(to) {  $('body.woocommerce-cart .woocommerce .shop_table').css('border-style', to ); }); });
		    wp.customize('table_cart_border_radius',function( value ) { value.bind(function(to) { $('body.woocommerce-cart .woocommerce .shop_table').css('-webkit-border-radius', to+'px' ); $('body.woocommerce-cart .woocommerce .shop_table').css('-moz-border-radius', to+'px' ); $('body.woocommerce-cart .woocommerce .shop_table').css('border-radius', to+'px' ); }); });
		    
		    wp.customize('table_cart_border_width',function( value ) { value.bind(function(to) { $('body.woocommerce-cart .woocommerce .shop_table td').css('border-width', to+'px' ); }); });
		    wp.customize('table_cart_border_color',function( value ) { value.bind(function(to) { $('body.woocommerce-cart .woocommerce .shop_table td').css('border-color', to ); }); });
		    wp.customize('table_cart_border_style',function( value ) { value.bind(function(to) {  $('body.woocommerce-cart .woocommerce .shop_table td').css('border-style', to ); }); });
		    wp.customize('table_cart_border_radius',function( value ) { value.bind(function(to) { $('body.woocommerce-cart .woocommerce .shop_table td').css('-webkit-border-radius', to+'px' ); $('body.woocommerce-cart .woocommerce .shop_table td').css('-moz-border-radius', to+'px' ); $('body.woocommerce-cart .woocommerce .shop_table td').css('border-radius', to+'px' ); }); });
		    
		    wp.customize('table_cart_border_width',function( value ) { value.bind(function(to) { $('body.woocommerce-cart .woocommerce .shop_table th').css('border-width', to+'px' ); }); });
		    wp.customize('table_cart_border_color',function( value ) { value.bind(function(to) { $('body.woocommerce-cart .woocommerce .shop_table th').css('border-color', to ); }); });
		    wp.customize('table_cart_border_style',function( value ) { value.bind(function(to) {  $('body.woocommerce-cart .woocommerce .shop_table th').css('border-style', to ); }); });
		    wp.customize('table_cart_border_radius',function( value ) { value.bind(function(to) { $('body.woocommerce-cart .woocommerce .shop_table th').css('-webkit-border-radius', to+'px' ); $('body.woocommerce-cart .woocommerce .shop_table th').css('-moz-border-radius', to+'px' ); $('body.woocommerce-cart .woocommerce .shop_table th').css('border-radius', to+'px' ); }); });
		    
		    wp.customize('table_font_cart_color',function( value ) { value.bind(function(to) { $('body.woocommerce-cart .woocommerce .shop_table').css('color', to ); }); });
		    wp.customize('table_font_cart_font',function( value ) { value.bind(function(to) { $('body.woocommerce-cart .woocommerce .shop_table').css('font-family', '"'+to+'"' ); }); });
		    wp.customize('table_font_cart_font_size',function( value ) { value.bind(function(to) { $('body.woocommerce-cart .woocommerce .shop_table').css('font-size', to+'px' ); }); });
		    wp.customize('table_font_cart_font_weight',function( value ) { value.bind(function(to) { $('body.woocommerce-cart .woocommerce .shop_table').css('font-weight', to ); }); });
		    wp.customize('table_font_cart_font_style',function( value ) { value.bind(function(to) { $('body.woocommerce-cart .woocommerce .shop_table').css('font-style', to ); }); });
		    wp.customize('table_font_cart_text_transform',function( value ) { value.bind(function(to) { $('body.woocommerce-cart .woocommerce .shop_table').css('text-transform', to ); }); });
		    wp.customize('table_font_cart_line_height',function( value ) { value.bind(function(to) { $('body.woocommerce-cart .woocommerce .shop_table').css('line-height', to+'px' ); }); });
		    wp.customize('table_font_cart_letter_spacing',function( value ) { value.bind(function(to) { $('body.woocommerce-cart .woocommerce .shop_table').css('letter-spacing', to+'px' ); }); });


		    wp.customize('btn_cart_bg',function( value ) { value.bind(function(to) { $('body.woocommerce-page .woocommerce table.shop_table.cart .actions input.button').css('background', to ); }); });
		    wp.customize('btn_cart_bg_hover',function( value ) { value.bind(function(to) { $('body.woocommerce-page .woocommerce table.shop_table.cart .actions input.button:hover').css('background', to ); }); });
		    wp.customize('btn_cart_color',function( value ) { value.bind(function(to) { $('body.woocommerce-page .woocommerce table.shop_table.cart .actions input.button').css('color', to ); }); });
		    wp.customize('btn_cart_color_hover',function( value ) { value.bind(function(to) { $('body.woocommerce-page .woocommerce table.shop_table.cart .actions input.button:hover').css('color', to ); }); });
		    wp.customize('btn_cart_border_width',function( value ) { value.bind(function(to) { $('body.woocommerce-page .woocommerce table.shop_table.cart .actions input.button').css('border-width', to+'px' ); }); });
		    wp.customize('btn_cart_border_color',function( value ) { value.bind(function(to) { $('body.woocommerce-page .woocommerce table.shop_table.cart .actions input.button').css('border-color', to ); }); });
		    wp.customize('btn_cart_border_color_hover',function( value ) { value.bind(function(to) { $('body.woocommerce-page .woocommerce table.shop_table.cart .actions input.button:hover').css('border-color', to ); }); });
		    wp.customize('btn_cart_border_style',function( value ) { value.bind(function(to) {  $('body.woocommerce-page .woocommerce table.shop_table.cart .actions input.button').css('border-style', to ); }); });
		    wp.customize('btn_cart_border_radius',function( value ) { value.bind(function(to) { $('body.woocommerce-page .woocommerce table.shop_table.cart .actions input.button').css('-webkit-border-radius', to+'px' ); $('body.woocommerce-page .woocommerce table.shop_table.cart .actions input.button').css('-moz-border-radius', to+'px' ); $('body.woocommerce-page .woocommerce table.shop_table.cart .actions .actions input.button').css('border-radius', to+'px' ); }); });
		    wp.customize('btn_cart_font',function( value ) { value.bind(function(to) { $('body.woocommerce-page .woocommerce table.shop_table.cart .actions input.button').css('font-family', '"'+to+'"' ); }); });
		    wp.customize('btn_cart_font_size',function( value ) { value.bind(function(to) { $('body.woocommerce-page .woocommerce table.shop_table.cart .actions input.button').css('font-size', to+'px' ); }); });
		    wp.customize('btn_cart_font_weight',function( value ) { value.bind(function(to) { $('body.woocommerce-page .woocommerce table.shop_table.cart .actions input.button').css('font-weight', to ); }); });
		    wp.customize('btn_cart_font_style',function( value ) { value.bind(function(to) { $('body.woocommerce-page .woocommerce table.shop_table.cart .actions input.button').css('font-style', to ); }); });
		    wp.customize('btn_cart_line_height',function( value ) { value.bind(function(to) { $('body.woocommerce-page .woocommerce table.shop_table.cart .actions input.button').css('line-height', to+'px' ); }); });
		    wp.customize('btn_cart_letter_spacing',function( value ) { value.bind(function(to) { $('body.woocommerce-page .woocommerce table.shop_table.cart .actions input.button').css('letter-spacing', to+'px' ); }); });
		    wp.customize('btn_cart_text_transform',function( value ) { value.bind(function(to) { $('body.woocommerce-page .woocommerce table.shop_table.cart .actions input.button').css('text-transform', to ); }); });



		    wp.customize('btnC_cart_bg',function( value ) { value.bind(function(to) { $('body.woocommerce-page .woocommerce table.shop_table.cart .actions .coupon input.button').css('background', to ); }); });
		    wp.customize('btnC_cart_bg_hover',function( value ) { value.bind(function(to) { $('body.woocommerce-page .woocommerce table.shop_table.cart .actions .coupon input.button:hover').css('background', to ); }); });
		    wp.customize('btnC_cart_color',function( value ) { value.bind(function(to) { $('body.woocommerce-page .woocommerce table.shop_table.cart .actions .coupon input.button').css('color', to ); }); });
		    wp.customize('btnC_cart_color_hover',function( value ) { value.bind(function(to) { $('body.woocommerce-page .woocommerce table.shop_table.cart .actions .coupon input.button:hover').css('color', to ); }); });
		    wp.customize('btnC_cart_border_width',function( value ) { value.bind(function(to) { $('body.woocommerce-page .woocommerce table.shop_table.cart .actions .coupon input.button').css('border-width', to+'px' ); }); });
		    wp.customize('btnC_cart_border_color',function( value ) { value.bind(function(to) { $('body.woocommerce-page .woocommerce table.shop_table.cart .actions .coupon input.button').css('border-color', to ); }); });
		    wp.customize('btnC_cart_border_color_hover',function( value ) { value.bind(function(to) { $('body.woocommerce-page .woocommerce table.shop_table.cart .actions .coupon input.button:hover').css('border-color', to ); }); });
		    wp.customize('btnC_cart_border_style',function( value ) { value.bind(function(to) {  $('body.woocommerce-page .woocommerce table.shop_table.cart .actions .coupon input.button').css('border-style', to ); }); });
		    wp.customize('btnC_cart_border_radius',function( value ) { value.bind(function(to) { $('body.woocommerce-page .woocommerce table.shop_table.cart .actions .coupon input.button').css('-webkit-border-radius', to+'px' ); $('body.woocommerce-page .woocommerce table.shop_table.cart .actions .coupon input.button').css('-moz-border-radius', to+'px' ); $('body.woocommerce-page .woocommerce table.shop_table.cart .actions .coupon input.button').css('border-radius', to+'px' ); }); });
		    wp.customize('btnC_cart_font',function( value ) { value.bind(function(to) { $('body.woocommerce-page .woocommerce table.shop_table.cart .actions .coupon input.button').css('font-family', '"'+to+'"' ); }); });
		    wp.customize('btnC_cart_font_size',function( value ) { value.bind(function(to) { $('body.woocommerce-page .woocommerce table.shop_table.cart .actions .coupon input.button').css('font-size', to+'px' ); }); });
		    wp.customize('btnC_cart_font_weight',function( value ) { value.bind(function(to) { $('body.woocommerce-page .woocommerce table.shop_table.cart .actions .coupon input.button').css('font-weight', to ); }); });
		    wp.customize('btnC_cart_font_style',function( value ) { value.bind(function(to) { $('body.woocommerce-page .woocommerce table.shop_table.cart .actions .coupon input.button').css('font-style', to ); }); });
		    wp.customize('btnC_cart_line_height',function( value ) { value.bind(function(to) { $('body.woocommerce-page .woocommerce table.shop_table.cart .actions .coupon input.button').css('line-height', to+'px' ); }); });
		    wp.customize('btnC_cart_letter_spacing',function( value ) { value.bind(function(to) { $('body.woocommerce-page .woocommerce table.shop_table.cart .actions .coupon input.button').css('letter-spacing', to+'px' ); }); });
		    wp.customize('btnC_cart_text_transform',function( value ) { value.bind(function(to) { $('body.woocommerce-page .woocommerce table.shop_table.cart .actions .coupon input.button').css('text-transform', to ); }); });





		    wp.customize('btnX_cart_bg',function( value ) { value.bind(function(to) { $('body.woocommerce-page .woocommerce .checkout-button').css('background', to ); }); });
		    wp.customize('btnX_cart_bg_hover',function( value ) { value.bind(function(to) { $('body.woocommerce-page .woocommerce   .checkout-button:hover').css('background', to ); }); });
		    wp.customize('btnX_cart_color',function( value ) { value.bind(function(to) { $('body.woocommerce-page .woocommerce   .checkout-button').css('color', to ); }); });
		    wp.customize('btnX_cart_color_hover',function( value ) { value.bind(function(to) { $('body.woocommerce-page .woocommerce   .checkout-button:hover').css('color', to ); }); });
		    wp.customize('btnX_cart_border_width',function( value ) { value.bind(function(to) { $('body.woocommerce-page .woocommerce   .checkout-button').css('border-width', to+'px' ); }); });
		    wp.customize('btnX_cart_border_color',function( value ) { value.bind(function(to) { $('body.woocommerce-page  .woocommerce  .checkout-button').css('border-color', to ); }); });
		    wp.customize('btnX_cart_border_color_hover',function( value ) { value.bind(function(to) { $('body.woocommerce-page .woocommerce   .checkout-button:hover').css('border-color', to ); }); });
		    wp.customize('btnX_cart_border_style',function( value ) { value.bind(function(to) {  $('body.woocommerce-page .woocommerce   .checkout-button').css('border-style', to ); }); });
		    wp.customize('btnX_cart_border_radius',function( value ) { value.bind(function(to) { $('body.woocommerce-page .woocommerce   .checkout-button').css('-webkit-border-radius', to+'px' ); $('body.woocommerce-page  .woocommerce  .checkout-button').css('-moz-border-radius', to+'px' ); $('body.woocommerce-page  .woocommerce  .checkout-button').css('border-radius', to+'px' ); }); });
		    wp.customize('btnX_cart_font',function( value ) { value.bind(function(to) { $('body.woocommerce-page   .woocommerce .checkout-button').css('font-family', '"'+to+'"' ); }); });
		    wp.customize('btnX_cart_font_size',function( value ) { value.bind(function(to) { $('body.woocommerce-page   .woocommerce .checkout-button').css('font-size', to+'px' ); }); });
		    wp.customize('btnX_cart_font_weight',function( value ) { value.bind(function(to) { $('body.woocommerce-page .woocommerce   .checkout-button').css('font-weight', to ); }); });
		    wp.customize('btnX_cart_font_style',function( value ) { value.bind(function(to) { $('body.woocommerce-page   .woocommerce .checkout-button').css('font-style', to ); }); });
		    wp.customize('btnX_cart_line_height',function( value ) { value.bind(function(to) { $('body.woocommerce-page   .woocommerce .checkout-button').css('line-height', to+'px' ); }); });
		    wp.customize('btnX_cart_letter_spacing',function( value ) { value.bind(function(to) { $('body.woocommerce-page  .woocommerce  .checkout-button').css('letter-spacing', to+'px' ); }); });
		    wp.customize('btnX_cart_text_transform',function( value ) { value.bind(function(to) { $('body.woocommerce-page   .woocommerce .checkout-button').css('text-transform', to ); }); });






		    wp.customize('title_cart_font',function( value ) { value.bind(function(to) { $('body.woocommerce-page .woocommerce table.shop_table.cart .product-name a').css('font-family', '"'+to+'"' ); }); });
		    wp.customize('title_cart_color',function( value ) { value.bind(function(to) { $('body.woocommerce-page .woocommerce table.shop_table.cart .product-name a').css('color', to ); }); });
		    wp.customize('title_cart_color_hover',function( value ) { value.bind(function(to) { $('body.woocommerce-page .woocommerce table.shop_table.cart .product-name a:hover h3').css('color', to ); }); });
		    wp.customize('title_cart_font_size',function( value ) { value.bind(function(to) { $('body.woocommerce-page .woocommerce table.shop_table.cart  .product-name a').css('font-size', to+'px' ); }); });
		    wp.customize('title_cart_font_weight',function( value ) { value.bind(function(to) { $('body.woocommerce-page .woocommerce table.shop_table.cart  .product-name a').css('font-weight', to ); }); });
		    wp.customize('title_cart_font_style',function( value ) { value.bind(function(to) { $('body.woocommerce-page .woocommerce table.shop_table.cart  .product-name a').css('font-style', to ); }); });
		    wp.customize('title_cart_line_height',function( value ) { value.bind(function(to) { $('body.woocommerce-page .woocommerce table.shop_table.cart  .product-name a').css('line-height', to+'px' ); }); });
		    wp.customize('title_cart_letter_spacing',function( value ) { value.bind(function(to) { $('body.woocommerce-page .woocommerce table.shop_table.cart  .product-name a').css('letter-spacing', to+'px' ); }); });
		    wp.customize('title_cart_text_transform',function( value ) { value.bind(function(to) { $('body.woocommerce-page .woocommerce table.shop_table.cart  .product-name a').css('text-transform', to ); }); });





		    wp.customize('price_cart_font',function( value ) { value.bind(function(to) { $('body.woocommerce-page .woocommerce table.shop_table.cart .product-price .amount').css('font-family', '"'+to+'"' ); }); });
		    wp.customize('price_cart_color',function( value ) { value.bind(function(to) { $('body.woocommerce-page .woocommerce table.shop_table.cart .product-price .amount').css('color', to ); }); });
		    wp.customize('price_cart_font_size',function( value ) { value.bind(function(to) { $('body.woocommerce-page .woocommerce table.shop_table.cart .product-price .amount').css('font-size', to+'px' ); }); });
		    wp.customize('price_cart_font_weight',function( value ) { value.bind(function(to) { $('body.woocommerce-page .woocommerce table.shop_table.cart .product-price .amount').css('font-weight', to ); }); });
		    wp.customize('price_cart_font_style',function( value ) { value.bind(function(to) { $('body.woocommerce-page .woocommerce table.shop_table.cart .product-price .amount').css('font-style', to ); }); });
		    wp.customize('price_cart_line_height',function( value ) { value.bind(function(to) { $('body.woocommerce-page .woocommerce table.shop_table.cart .product-price .amount').css('line-height', to+'px' ); }); });
		    wp.customize('price_cart_letter_spacing',function( value ) { value.bind(function(to) { $('body.woocommerce-page .woocommerce table.shop_table.cart .product-price .amount').css('letter-spacing', to+'px' ); }); });
		    wp.customize('price_cart_text_transform',function( value ) { value.bind(function(to) { $('body.woocommerce-page .woocommerce table.shop_table.cart .product-price .amount').css('text-transform', to ); }); });
// subtotal
		    wp.customize('price_cart_font',function( value ) { value.bind(function(to) { $('body.woocommerce-page .woocommerce table.shop_table.cart .product-subtotal .amount').css('font-family', '"'+to+'"' ); }); });
		    wp.customize('price_cart_color',function( value ) { value.bind(function(to) { $('body.woocommerce-page .woocommerce table.shop_table.cart .product-subtotal .amount').css('color', to ); }); });
		    wp.customize('price_cart_font_size',function( value ) { value.bind(function(to) { $('body.woocommerce-page .woocommerce table.shop_table.cart .product-subtotal .amount').css('font-size', to+'px' ); }); });
		    wp.customize('price_cart_font_weight',function( value ) { value.bind(function(to) { $('body.woocommerce-page .woocommerce table.shop_table.cart .product-subtotal .amount').css('font-weight', to ); }); });
		    wp.customize('price_cart_font_style',function( value ) { value.bind(function(to) { $('body.woocommerce-page .woocommerce table.shop_table.cart .product-subtotal .amount').css('font-style', to ); }); });
		    wp.customize('price_cart_line_height',function( value ) { value.bind(function(to) { $('body.woocommerce-page .woocommerce table.shop_table.cart .product-subtotal .amount').css('line-height', to+'px' ); }); });
		    wp.customize('price_cart_letter_spacing',function( value ) { value.bind(function(to) { $('body.woocommerce-page .woocommerce table.shop_table.cart .product-subtotal .amount').css('letter-spacing', to+'px' ); }); });
		    wp.customize('price_cart_text_transform',function( value ) { value.bind(function(to) { $('body.woocommerce-page .woocommerce table.shop_table.cart .product-subtotal .amount').css('text-transform', to ); }); });
// quantity
		    wp.customize('price_cart_font',function( value ) { value.bind(function(to) { $('body.woocommerce-page .woocommerce table.shop_table.cart .product-quantity .qty').css('font-family', '"'+to+'"' ); }); });
		    wp.customize('price_cart_color',function( value ) { value.bind(function(to) { $('body.woocommerce-page .woocommerce table.shop_table.cart .product-quantity .qty').css('color', to ); }); });
		    wp.customize('price_cart_font_size',function( value ) { value.bind(function(to) { $('body.woocommerce-page .woocommerce table.shop_table.cart .product-quantity .qty').css('font-size', to+'px' ); }); });
		    wp.customize('price_cart_font_weight',function( value ) { value.bind(function(to) { $('body.woocommerce-page .woocommerce table.shop_table.cart .product-quantity .qty').css('font-weight', to ); }); });
		    wp.customize('price_cart_font_style',function( value ) { value.bind(function(to) { $('body.woocommerce-page .woocommerce table.shop_table.cart .product-quantity .qty').css('font-style', to ); }); });
		    wp.customize('price_cart_line_height',function( value ) { value.bind(function(to) { $('body.woocommerce-page .woocommerce table.shop_table.cart .product-quantity .qty').css('line-height', to+'px' ); }); });
		    wp.customize('price_cart_letter_spacing',function( value ) { value.bind(function(to) { $('body.woocommerce-page .woocommerce table.shop_table.cart .product-quantity .qty').css('letter-spacing', to+'px' ); }); });
		    wp.customize('price_cart_text_transform',function( value ) { value.bind(function(to) { $('body.woocommerce-page .woocommerce table.shop_table.cart .product-quantity .qty').css('text-transform', to ); }); });





		    wp.customize('img_cart_border_width',function( value ) { value.bind(function(to) { $('body.woocommerce-page .woocommerce table.shop_table.cart .product-thumbnail a img.wp-post-image').css('border-width', to+'px' ); }); });
		    wp.customize('img_cart_border_color',function( value ) { value.bind(function(to) { $('body.woocommerce-page .woocommerce table.shop_table.cart .product-thumbnail a img.wp-post-image').css('border-color', to ); }); });
		    wp.customize('img_cart_border_color_hover',function( value ) { value.bind(function(to) { $('body.woocommerce-page .woocommerce table.shop_table.cart .product-thumbnail a:hover img.wp-post-image').css('border-color', to ); }); });
		    wp.customize('img_cart_border_style',function( value ) { value.bind(function(to) {  $('body.woocommerce-page .woocommerce table.shop_table.cart .product-thumbnail a img.wp-post-image').css('border-style', to ); }); });
		    wp.customize('img_cart_border_radius',function( value ) { value.bind(function(to) { $('body.woocommerce-page .woocommerce table.shop_table.cart .product-thumbnail a img.wp-post-image').css('-webkit-border-radius', to+'px' ); $('body.woocommerce-page .woocommerce table.shop_table.cart .product-thumbnail a img.wp-post-image').css('-moz-border-radius', to+'px' ); $('body.woocommerce-page .woocommerce table.shop_table.cart .product-thumbnail a img.wp-post-image').css('border-radius', to+'px' ); }); });



		} )( jQuery )
    </script>
    <?php
}
?>