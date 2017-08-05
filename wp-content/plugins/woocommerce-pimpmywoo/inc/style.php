<?php header("Content-type: text/css");
$absolute_path = __FILE__;
$path_to_file = explode( 'wp-content', $absolute_path );
$path_to_wp = $path_to_file[0];

//Access WordPress
require_once( $path_to_wp.'/wp-load.php' );

$btn_list_bg = get_theme_mod( 'btn_list_bg');
$btn_list_bg_hover = get_theme_mod( 'btn_list_bg_hover');
$btn_list_color = get_theme_mod( 'btn_list_color');
$btn_list_color_hover = get_theme_mod( 'btn_list_color_hover');
$btn_list_border_width = get_theme_mod( 'btn_list_border_width');
$btn_list_border_color = get_theme_mod( 'btn_list_border_color');
$btn_list_border_color_hover = get_theme_mod( 'btn_list_border_color_hover');
$btn_list_border_style = get_theme_mod( 'btn_list_border_style');
$btn_list_border_radius = get_theme_mod( 'btn_list_border_radius');
$btn_list_font = get_theme_mod( 'btn_list_font');
$btn_list_font_size = get_theme_mod( 'btn_list_font_size');
$btn_list_font_style = get_theme_mod( 'btn_list_font_style');
$btn_list_font_weight = get_theme_mod( 'btn_list_font_weight');
$btn_list_font_transform = get_theme_mod( 'btn_list_text_transform');
$btn_list_line_height = get_theme_mod( 'btn_list_line_height');
$btn_list_letter_spacing = get_theme_mod( 'btn_list_letter_spacing');



$title_list_font = get_theme_mod( 'title_list_font');
$title_list_color = get_theme_mod( 'title_list_color');
$title_list_color_hover = get_theme_mod( 'title_list_color_hover');
$title_list_font_size = get_theme_mod( 'title_list_font_size');
$title_list_font_style = get_theme_mod( 'title_list_font_style');
$title_list_font_weight = get_theme_mod( 'title_list_font_weight');
$title_list_font_transform = get_theme_mod( 'title_list_text_transform');
$title_list_line_height = get_theme_mod( 'title_list_line_height');
$title_list_letter_spacing = get_theme_mod( 'title_list_letter_spacing');

$price_list_font = get_theme_mod( 'price_list_font');
$price_list_color = get_theme_mod( 'price_list_color');
$price_list_color_hover = get_theme_mod( 'price_list_color_hover');
$price_list_font_size = get_theme_mod( 'price_list_font_size');
$price_list_font_style = get_theme_mod( 'price_list_font_style');
$price_list_font_weight = get_theme_mod( 'price_list_font_weight');
$price_list_font_transform = get_theme_mod( 'price_list_text_transform');
$price_list_line_height = get_theme_mod( 'price_list_line_height');
$price_list_letter_spacing = get_theme_mod( 'price_list_letter_spacing');


$img_list_border_width = get_theme_mod( 'img_list_border_width');
$img_list_border_color = get_theme_mod( 'img_list_border_color');
$img_list_border_color_hover = get_theme_mod( 'img_list_border_color_hover');
$img_list_border_style = get_theme_mod( 'img_list_border_style');
$img_list_border_radius = get_theme_mod( 'img_list_border_radius');


$sbadge_list_bg = get_theme_mod( 'sbadge_list_bg');
$sbadge_list_bg_hover = get_theme_mod( 'sbadge_list_bg_hover');
$sbadge_list_color = get_theme_mod( 'sbadge_list_color');
$sbadge_list_color_hover = get_theme_mod( 'sbadge_list_color_hover');
$sbadge_list_border_width = get_theme_mod( 'sbadge_list_border_width');
$sbadge_list_border_color = get_theme_mod( 'sbadge_list_border_color');
$sbadge_list_border_color_hover = get_theme_mod( 'sbadge_list_border_color_hover');
$sbadge_list_border_style = get_theme_mod( 'sbadge_list_border_style');
$sbadge_list_border_radius = get_theme_mod( 'sbadge_list_border_radius');
$sbadge_list_font = get_theme_mod( 'sbadge_list_font');
$sbadge_list_font_size = get_theme_mod( 'sbadge_list_font_size');
$sbadge_list_font_style = get_theme_mod( 'sbadge_list_font_style');
$sbadge_list_font_weight = get_theme_mod( 'sbadge_list_font_weight');
$sbadge_list_font_transform = get_theme_mod( 'sbadge_list_text_transform');
$sbadge_list_line_height = get_theme_mod( 'sbadge_list_line_height');
$sbadge_list_letter_spacing = get_theme_mod( 'sbadge_list_letter_spacing');
$sbadge_list_padding = get_theme_mod( 'sbadge_list_padding');


if (isset($btn_list_font) && $btn_list_font!='') {
	$char_set = '';
	if (get_theme_mod( 'btn_list_font_latin') == '1') { $char_set .= 'latin,'; }
	if (get_theme_mod( 'btn_list_font_latinext') == '1') { $char_set .= 'latin-ext,'; }
	if (get_theme_mod( 'btn_list_font_greek') == '1') { $char_set .= 'greek,'; }
	if (get_theme_mod( 'btn_list_font_greekext') == '1') { $char_set .= 'greek-ext,'; }
	if (get_theme_mod( 'btn_list_font_vietnamese') == '1') { $char_set .= 'vietnamese,'; }
	if (get_theme_mod( 'btn_list_font_cyrillic') == '1') { $char_set .= 'cyrillic,'; }
	if (get_theme_mod( 'btn_list_font_cyrillicext') == '1') { $char_set .= 'cyrillic-ext,'; }
	if ($char_set == '') { $char_set = 'latin'; }
	$char_set = rtrim($char_set, ",");
	$btn_list_font_link = str_replace(' ', '+', $btn_list_font);
	echo '@import url(https://fonts.googleapis.com/css?family='.$btn_list_font_link.':400,700&subset='.$char_set.');', PHP_EOL;
	$btn_list_font = '"'.$btn_list_font.'"';
}
if (isset($title_list_font) && $title_list_font!='') {
	$char_set = '';
	if (get_theme_mod( 'title_list_font_latin') == '1') { $char_set .= 'latin,'; }
	if (get_theme_mod( 'title_list_font_latinext') == '1') { $char_set .= 'latin-ext,'; }
	if (get_theme_mod( 'title_list_font_greek') == '1') { $char_set .= 'greek,'; }
	if (get_theme_mod( 'title_list_font_greekext') == '1') { $char_set .= 'greek-ext,'; }
	if (get_theme_mod( 'title_list_font_vietnamese') == '1') { $char_set .= 'vietnamese,'; }
	if (get_theme_mod( 'title_list_font_cyrillic') == '1') { $char_set .= 'cyrillic,'; }
	if (get_theme_mod( 'title_list_font_cyrillicext') == '1') { $char_set .= 'cyrillic-ext,'; }
	if ($char_set == '') { $char_set = 'latin'; }
	$char_set = rtrim($char_set, ",");
	$title_list_font_link = str_replace(' ', '+', $title_list_font);
	echo '@import url(https://fonts.googleapis.com/css?family='.$title_list_font_link.':400,700&subset='.$char_set.');', PHP_EOL;
	$title_list_font = '"'.$title_list_font.'"';
}
if (isset($price_list_font) && $price_list_font!='') {
	$char_set = '';
	if (get_theme_mod( 'price_list_font_latin') == '1') { $char_set .= 'latin,'; }
	if (get_theme_mod( 'price_list_font_latinext') == '1') { $char_set .= 'latin-ext,'; }
	if (get_theme_mod( 'price_list_font_greek') == '1') { $char_set .= 'greek,'; }
	if (get_theme_mod( 'price_list_font_greekext') == '1') { $char_set .= 'greek-ext,'; }
	if (get_theme_mod( 'price_list_font_vietnamese') == '1') { $char_set .= 'vietnamese,'; }
	if (get_theme_mod( 'price_list_font_cyrillic') == '1') { $char_set .= 'cyrillic,'; }
	if (get_theme_mod( 'price_list_font_cyrillicext') == '1') { $char_set .= 'cyrillic-ext,'; }
	if ($char_set == '') { $char_set = 'latin'; }
	$char_set = rtrim($char_set, ",");
	$price_list_font_link = str_replace(' ', '+', $price_list_font);
	echo '@import url(https://fonts.googleapis.com/css?family='.$price_list_font_link.':400,700&subset='.$char_set.');', PHP_EOL;
	$price_list_font = '"'.$price_list_font.'"';
}




// SIDEBAR


$title_sidebar_font = get_theme_mod( 'title_sidebar_font');
$title_sidebar_color = get_theme_mod( 'title_sidebar_color');
$title_sidebar_color_hover = get_theme_mod( 'title_sidebar_color_hover');
$title_sidebar_font_size = get_theme_mod( 'title_sidebar_font_size');
$title_sidebar_font_style = get_theme_mod( 'title_sidebar_font_style');
$title_sidebar_font_weight = get_theme_mod( 'title_sidebar_font_weight');
$title_sidebar_font_transform = get_theme_mod( 'title_sidebar_text_transform');
$title_sidebar_line_height = get_theme_mod( 'title_sidebar_line_height');
$title_sidebar_letter_spacing = get_theme_mod( 'title_sidebar_letter_spacing');

$price_sidebar_font = get_theme_mod( 'price_sidebar_font');
$price_sidebar_color = get_theme_mod( 'price_sidebar_color');
$price_sidebar_font_size = get_theme_mod( 'price_sidebar_font_size');
$price_sidebar_font_style = get_theme_mod( 'price_sidebar_font_style');
$price_sidebar_font_weight = get_theme_mod( 'price_sidebar_font_weight');
$price_sidebar_font_transform = get_theme_mod( 'price_sidebar_text_transform');
$price_sidebar_line_height = get_theme_mod( 'price_sidebar_line_height');
$price_sidebar_letter_spacing = get_theme_mod( 'price_sidebar_letter_spacing');


$img_sidebar_border_width = get_theme_mod( 'img_sidebar_border_width');
$img_sidebar_border_color = get_theme_mod( 'img_sidebar_border_color');
$img_sidebar_border_color_hover = get_theme_mod( 'img_sidebar_border_color_hover');
$img_sidebar_border_style = get_theme_mod( 'img_sidebar_border_style');
$img_sidebar_border_radius = get_theme_mod( 'img_sidebar_border_radius');

if (isset($title_sidebar_font) && $title_sidebar_font!='') {
	$char_set = '';
	if (get_theme_mod( 'title_sidebar_font_latin') == '1') { $char_set .= 'latin,'; }
	if (get_theme_mod( 'title_sidebar_font_latinext') == '1') { $char_set .= 'latin-ext,'; }
	if (get_theme_mod( 'title_sidebar_font_greek') == '1') { $char_set .= 'greek,'; }
	if (get_theme_mod( 'title_sidebar_font_greekext') == '1') { $char_set .= 'greek-ext,'; }
	if (get_theme_mod( 'title_sidebar_font_vietnamese') == '1') { $char_set .= 'vietnamese,'; }
	if (get_theme_mod( 'title_sidebar_font_cyrillic') == '1') { $char_set .= 'cyrillic,'; }
	if (get_theme_mod( 'title_sidebar_font_cyrillicext') == '1') { $char_set .= 'cyrillic-ext,'; }
	if ($char_set == '') { $char_set = 'latin'; }
	$char_set = rtrim($char_set, ",");
	$title_sidebar_font_link = str_replace(' ', '+', $title_sidebar_font);
	echo '@import url(https://fonts.googleapis.com/css?family='.$title_sidebar_font_link.':400,700&subset='.$char_set.');', PHP_EOL;
	$title_sidebar_font = '"'.$title_sidebar_font.'"';
}
if (isset($price_sidebar_font) && $price_sidebar_font!='') {
	$char_set = '';
	if (get_theme_mod( 'price_sidebar_font_latin') == '1') { $char_set .= 'latin,'; }
	if (get_theme_mod( 'price_sidebar_font_latinext') == '1') { $char_set .= 'latin-ext,'; }
	if (get_theme_mod( 'price_sidebar_font_greek') == '1') { $char_set .= 'greek,'; }
	if (get_theme_mod( 'price_sidebar_font_greekext') == '1') { $char_set .= 'greek-ext,'; }
	if (get_theme_mod( 'price_sidebar_font_vietnamese') == '1') { $char_set .= 'vietnamese,'; }
	if (get_theme_mod( 'price_sidebar_font_cyrillic') == '1') { $char_set .= 'cyrillic,'; }
	if (get_theme_mod( 'price_sidebar_font_cyrillicext') == '1') { $char_set .= 'cyrillic-ext,'; }
	if ($char_set == '') { $char_set = 'latin'; }
	$char_set = rtrim($char_set, ",");
	$price_sidebar_font_link = str_replace(' ', '+', $price_sidebar_font);
	echo '@import url(https://fonts.googleapis.com/css?family='.$price_sidebar_font_link.':400,700&subset='.$char_set.');', PHP_EOL;
	$price_sidebar_font = '"'.$price_sidebar_font.'"';
}

// SINGLE

$btn_single_bg = get_theme_mod( 'btn_single_bg');
$btn_single_bg_hover = get_theme_mod( 'btn_single_bg_hover');
$btn_single_color = get_theme_mod( 'btn_single_color');
$btn_single_color_hover = get_theme_mod( 'btn_single_color_hover');
$btn_single_border_width = get_theme_mod( 'btn_single_border_width');
$btn_single_border_color = get_theme_mod( 'btn_single_border_color');
$btn_single_border_color_hover = get_theme_mod( 'btn_single_border_color_hover');
$btn_single_border_style = get_theme_mod( 'btn_single_border_style');
$btn_single_border_radius = get_theme_mod( 'btn_single_border_radius');
$btn_single_font = get_theme_mod( 'btn_single_font');
$btn_single_font_size = get_theme_mod( 'btn_single_font_size');
$btn_single_font_style = get_theme_mod( 'btn_single_font_style');
$btn_single_font_weight = get_theme_mod( 'btn_single_font_weight');
$btn_single_font_transform = get_theme_mod( 'btn_single_text_transform');
$btn_single_line_height = get_theme_mod( 'btn_single_line_height');
$btn_single_letter_spacing = get_theme_mod( 'btn_single_letter_spacing');



$title_single_font = get_theme_mod( 'title_single_font');
$title_single_color = get_theme_mod( 'title_single_color');
$title_single_font_size = get_theme_mod( 'title_single_font_size');
$title_single_font_style = get_theme_mod( 'title_single_font_style');
$title_single_font_weight = get_theme_mod( 'title_single_font_weight');
$title_single_font_transform = get_theme_mod( 'title_single_text_transform');
$title_single_line_height = get_theme_mod( 'title_single_line_height');
$title_single_letter_spacing = get_theme_mod( 'title_single_letter_spacing');

$price_single_font = get_theme_mod( 'price_single_font');
$price_single_color = get_theme_mod( 'price_single_color');
$price_single_font_size = get_theme_mod( 'price_single_font_size');
$price_single_font_style = get_theme_mod( 'price_single_font_style');
$price_single_font_weight = get_theme_mod( 'price_single_font_weight');
$price_single_font_transform = get_theme_mod( 'price_single_text_transform');
$price_single_line_height = get_theme_mod( 'price_single_line_height');
$price_single_letter_spacing = get_theme_mod( 'price_single_letter_spacing');


$img_single_border_width = get_theme_mod( 'img_single_border_width');
$img_single_border_color = get_theme_mod( 'img_single_border_color');
$img_single_border_color_hover = get_theme_mod( 'img_single_border_color_hover');
$img_single_border_style = get_theme_mod( 'img_single_border_style');
$img_single_border_radius = get_theme_mod( 'img_single_border_radius');


$sbadge_single_bg = get_theme_mod( 'sbadge_single_bg');
$sbadge_single_color = get_theme_mod( 'sbadge_single_color');
$sbadge_single_border_width = get_theme_mod( 'sbadge_single_border_width');
$sbadge_single_border_color = get_theme_mod( 'sbadge_single_border_color');
$sbadge_single_border_style = get_theme_mod( 'sbadge_single_border_style');
$sbadge_single_border_radius = get_theme_mod( 'sbadge_single_border_radius');
$sbadge_single_font = get_theme_mod( 'sbadge_single_font');
$sbadge_single_font_size = get_theme_mod( 'sbadge_single_font_size');
$sbadge_single_font_style = get_theme_mod( 'sbadge_single_font_style');
$sbadge_single_font_weight = get_theme_mod( 'sbadge_single_font_weight');
$sbadge_single_font_transform = get_theme_mod( 'sbadge_single_text_transform');
$sbadge_single_line_height = get_theme_mod( 'sbadge_single_line_height');
$sbadge_single_letter_spacing = get_theme_mod( 'sbadge_single_letter_spacing');
$sbadge_single_padding = get_theme_mod( 'sbadge_single_padding');


if (isset($btn_single_font) && $btn_single_font!='') {
	$char_set = '';
	if (get_theme_mod( 'btn_single_font_latin') == '1') { $char_set .= 'latin,'; }
	if (get_theme_mod( 'btn_single_font_latinext') == '1') { $char_set .= 'latin-ext,'; }
	if (get_theme_mod( 'btn_single_font_greek') == '1') { $char_set .= 'greek,'; }
	if (get_theme_mod( 'btn_single_font_greekext') == '1') { $char_set .= 'greek-ext,'; }
	if (get_theme_mod( 'btn_single_font_vietnamese') == '1') { $char_set .= 'vietnamese,'; }
	if (get_theme_mod( 'btn_single_font_cyrillic') == '1') { $char_set .= 'cyrillic,'; }
	if (get_theme_mod( 'btn_single_font_cyrillicext') == '1') { $char_set .= 'cyrillic-ext,'; }
	if ($char_set == '') { $char_set = 'latin'; }
	$char_set = rtrim($char_set, ",");
	$btn_single_font_link = str_replace(' ', '+', $btn_single_font);
	echo '@import url(https://fonts.googleapis.com/css?family='.$btn_single_font_link.':400,700&subset='.$char_set.');', PHP_EOL;
	$btn_single_font = '"'.$btn_single_font.'"';
}
if (isset($title_single_font) && $title_single_font!='') {
	$char_set = '';
	if (get_theme_mod( 'title_single_font_latin') == '1') { $char_set .= 'latin,'; }
	if (get_theme_mod( 'title_single_font_latinext') == '1') { $char_set .= 'latin-ext,'; }
	if (get_theme_mod( 'title_single_font_greek') == '1') { $char_set .= 'greek,'; }
	if (get_theme_mod( 'title_single_font_greekext') == '1') { $char_set .= 'greek-ext,'; }
	if (get_theme_mod( 'title_single_font_vietnamese') == '1') { $char_set .= 'vietnamese,'; }
	if (get_theme_mod( 'title_single_font_cyrillic') == '1') { $char_set .= 'cyrillic,'; }
	if (get_theme_mod( 'title_single_font_cyrillicext') == '1') { $char_set .= 'cyrillic-ext,'; }
	if ($char_set == '') { $char_set = 'latin'; }
	$char_set = rtrim($char_set, ",");
	$title_single_font_link = str_replace(' ', '+', $title_single_font);
	echo '@import url(https://fonts.googleapis.com/css?family='.$title_single_font_link.':400,700&subset='.$char_set.');', PHP_EOL;
	$title_single_font = '"'.$title_single_font.'"';
}
if (isset($price_single_font) && $price_single_font!='') {
	$char_set = '';
	if (get_theme_mod( 'price_single_font_latin') == '1') { $char_set .= 'latin,'; }
	if (get_theme_mod( 'price_single_font_latinext') == '1') { $char_set .= 'latin-ext,'; }
	if (get_theme_mod( 'price_single_font_greek') == '1') { $char_set .= 'greek,'; }
	if (get_theme_mod( 'price_single_font_greekext') == '1') { $char_set .= 'greek-ext,'; }
	if (get_theme_mod( 'price_single_font_vietnamese') == '1') { $char_set .= 'vietnamese,'; }
	if (get_theme_mod( 'price_single_font_cyrillic') == '1') { $char_set .= 'cyrillic,'; }
	if (get_theme_mod( 'price_single_font_cyrillicext') == '1') { $char_set .= 'cyrillic-ext,'; }
	if ($char_set == '') { $char_set = 'latin'; }
	$char_set = rtrim($char_set, ",");
	$price_single_font_link = str_replace(' ', '+', $price_single_font);
	echo '@import url(https://fonts.googleapis.com/css?family='.$price_single_font_link.':400,700&subset='.$char_set.');', PHP_EOL;
	$price_single_font = '"'.$price_single_font.'"';
}


/// CART

$btn_cart_bg = get_theme_mod( 'btn_cart_bg');
$btn_cart_bg_hover = get_theme_mod( 'btn_cart_bg_hover');
$btn_cart_color = get_theme_mod( 'btn_cart_color');
$btn_cart_color_hover = get_theme_mod( 'btn_cart_color_hover');
$btn_cart_border_width = get_theme_mod( 'btn_cart_border_width');
$btn_cart_border_color = get_theme_mod( 'btn_cart_border_color');
$btn_cart_border_color_hover = get_theme_mod( 'btn_cart_border_color_hover');
$btn_cart_border_style = get_theme_mod( 'btn_cart_border_style');
$btn_cart_border_radius = get_theme_mod( 'btn_cart_border_radius');
$btn_cart_font = get_theme_mod( 'btn_cart_font');
$btn_cart_font_size = get_theme_mod( 'btn_cart_font_size');
$btn_cart_font_style = get_theme_mod( 'btn_cart_font_style');
$btn_cart_font_weight = get_theme_mod( 'btn_cart_font_weight');
$btn_cart_font_transform = get_theme_mod( 'btn_cart_text_transform');
$btn_cart_line_height = get_theme_mod( 'btn_cart_line_height');
$btn_cart_letter_spacing = get_theme_mod( 'btn_cart_letter_spacing');

$btnC_cart_bg = get_theme_mod( 'btnC_cart_bg');
$btnC_cart_bg_hover = get_theme_mod( 'btnC_cart_bg_hover');
$btnC_cart_color = get_theme_mod( 'btnC_cart_color');
$btnC_cart_color_hover = get_theme_mod( 'btnC_cart_color_hover');
$btnC_cart_border_width = get_theme_mod( 'btnC_cart_border_width');
$btnC_cart_border_color = get_theme_mod( 'btnC_cart_border_color');
$btnC_cart_border_color_hover = get_theme_mod( 'btnC_cart_border_color_hover');
$btnC_cart_border_style = get_theme_mod( 'btnC_cart_border_style');
$btnC_cart_border_radius = get_theme_mod( 'btnC_cart_border_radius');
$btnC_cart_font = get_theme_mod( 'btnC_cart_font');
$btnC_cart_font_size = get_theme_mod( 'btnC_cart_font_size');
$btnC_cart_font_style = get_theme_mod( 'btnC_cart_font_style');
$btnC_cart_font_weight = get_theme_mod( 'btnC_cart_font_weight');
$btnC_cart_font_transform = get_theme_mod( 'btnC_cart_text_transform');
$btnC_cart_line_height = get_theme_mod( 'btnC_cart_line_height');
$btnC_cart_letter_spacing = get_theme_mod( 'btnC_cart_letter_spacing');

$btnX_cart_bg = get_theme_mod( 'btnX_cart_bg');
$btnX_cart_bg_hover = get_theme_mod( 'btnX_cart_bg_hover');
$btnX_cart_color = get_theme_mod( 'btnX_cart_color');
$btnX_cart_color_hover = get_theme_mod( 'btnX_cart_color_hover');
$btnX_cart_border_width = get_theme_mod( 'btnX_cart_border_width');
$btnX_cart_border_color = get_theme_mod( 'btnX_cart_border_color');
$btnX_cart_border_color_hover = get_theme_mod( 'btnX_cart_border_color_hover');
$btnX_cart_border_style = get_theme_mod( 'btnX_cart_border_style');
$btnX_cart_border_radius = get_theme_mod( 'btnX_cart_border_radius');
$btnX_cart_font = get_theme_mod( 'btnX_cart_font');
$btnX_cart_font_size = get_theme_mod( 'btnX_cart_font_size');
$btnX_cart_font_style = get_theme_mod( 'btnX_cart_font_style');
$btnX_cart_font_weight = get_theme_mod( 'btnX_cart_font_weight');
$btnX_cart_font_transform = get_theme_mod( 'btnX_cart_text_transform');
$btnX_cart_line_height = get_theme_mod( 'btnX_cart_line_height');
$btnX_cart_letter_spacing = get_theme_mod( 'btnX_cart_letter_spacing');

$title_cart_font = get_theme_mod( 'title_cart_font');
$title_cart_color = get_theme_mod( 'title_cart_color');
$title_cart_color_hover = get_theme_mod( 'title_cart_color_hover');
$title_cart_font_size = get_theme_mod( 'title_cart_font_size');
$title_cart_font_style = get_theme_mod( 'title_cart_font_style');
$title_cart_font_weight = get_theme_mod( 'title_cart_font_weight');
$title_cart_font_transform = get_theme_mod( 'title_cart_text_transform');
$title_cart_line_height = get_theme_mod( 'title_cart_line_height');
$title_cart_letter_spacing = get_theme_mod( 'title_cart_letter_spacing');

$price_cart_font = get_theme_mod( 'price_cart_font');
$price_cart_color = get_theme_mod( 'price_cart_color');
$price_cart_font_size = get_theme_mod( 'price_cart_font_size');
$price_cart_font_style = get_theme_mod( 'price_cart_font_style');
$price_cart_font_weight = get_theme_mod( 'price_cart_font_weight');
$price_cart_font_transform = get_theme_mod( 'price_cart_text_transform');
$price_cart_line_height = get_theme_mod( 'price_cart_line_height');
$price_cart_letter_spacing = get_theme_mod( 'price_cart_letter_spacing');

$img_cart_border_width = get_theme_mod( 'img_cart_border_width');
$img_cart_border_color = get_theme_mod( 'img_cart_border_color');
$img_cart_border_color_hover = get_theme_mod( 'img_cart_border_color_hover');
$img_cart_border_style = get_theme_mod( 'img_cart_border_style');
$img_cart_border_radius = get_theme_mod( 'img_cart_border_radius');


if (isset($btn_cart_font) && $btn_cart_font!='') {
	$char_set = '';
	if (get_theme_mod( 'btn_cart_font_latin') == '1') { $char_set .= 'latin,'; }
	if (get_theme_mod( 'btn_cart_font_latinext') == '1') { $char_set .= 'latin-ext,'; }
	if (get_theme_mod( 'btn_cart_font_greek') == '1') { $char_set .= 'greek,'; }
	if (get_theme_mod( 'btn_cart_font_greekext') == '1') { $char_set .= 'greek-ext,'; }
	if (get_theme_mod( 'btn_cart_font_vietnamese') == '1') { $char_set .= 'vietnamese,'; }
	if (get_theme_mod( 'btn_cart_font_cyrillic') == '1') { $char_set .= 'cyrillic,'; }
	if (get_theme_mod( 'btn_cart_font_cyrillicext') == '1') { $char_set .= 'cyrillic-ext,'; }
	if ($char_set == '') { $char_set = 'latin'; }
	$char_set = rtrim($char_set, ",");
	$btn_cart_font_link = str_replace(' ', '+', $btn_cart_font);
	echo '@import url(https://fonts.googleapis.com/css?family='.$btn_cart_font_link.':400,700&subset='.$char_set.');', PHP_EOL;
	$btn_cart_font = '"'.$btn_cart_font.'"';
}
if (isset($btnC_cart_font) && $btnC_cart_font!='') {
	$char_set = '';
	if (get_theme_mod( 'btnC_cart_font_latin') == '1') { $char_set .= 'latin,'; }
	if (get_theme_mod( 'btnC_cart_font_latinext') == '1') { $char_set .= 'latin-ext,'; }
	if (get_theme_mod( 'btnC_cart_font_greek') == '1') { $char_set .= 'greek,'; }
	if (get_theme_mod( 'btnC_cart_font_greekext') == '1') { $char_set .= 'greek-ext,'; }
	if (get_theme_mod( 'btnC_cart_font_vietnamese') == '1') { $char_set .= 'vietnamese,'; }
	if (get_theme_mod( 'btnC_cart_font_cyrillic') == '1') { $char_set .= 'cyrillic,'; }
	if (get_theme_mod( 'btnC_cart_font_cyrillicext') == '1') { $char_set .= 'cyrillic-ext,'; }
	if ($char_set == '') { $char_set = 'latin'; }
	$char_set = rtrim($char_set, ",");
	$btnC_cart_font_link = str_replace(' ', '+', $btnC_cart_font);
	echo '@import url(https://fonts.googleapis.com/css?family='.$btnC_cart_font_link.':400,700&subset='.$char_set.');', PHP_EOL;
	$btnC_cart_font = '"'.$btnC_cart_font.'"';
}
if (isset($btnX_cart_font) && $btnX_cart_font!='') {
	$char_set = '';
	if (get_theme_mod( 'btnX_cart_font_latin') == '1') { $char_set .= 'latin,'; }
	if (get_theme_mod( 'btnX_cart_font_latinext') == '1') { $char_set .= 'latin-ext,'; }
	if (get_theme_mod( 'btnX_cart_font_greek') == '1') { $char_set .= 'greek,'; }
	if (get_theme_mod( 'btnX_cart_font_greekext') == '1') { $char_set .= 'greek-ext,'; }
	if (get_theme_mod( 'btnX_cart_font_vietnamese') == '1') { $char_set .= 'vietnamese,'; }
	if (get_theme_mod( 'btnX_cart_font_cyrillic') == '1') { $char_set .= 'cyrillic,'; }
	if (get_theme_mod( 'btnX_cart_font_cyrillicext') == '1') { $char_set .= 'cyrillic-ext,'; }
	if ($char_set == '') { $char_set = 'latin'; }
	$char_set = rtrim($char_set, ",");
	$btnX_cart_font_link = str_replace(' ', '+', $btnX_cart_font);
	echo '@import url(https://fonts.googleapis.com/css?family='.$btnX_cart_font_link.':400,700&subset='.$char_set.');', PHP_EOL;
	$btnX_cart_font = '"'.$btnX_cart_font.'"';
}
if (isset($title_cart_font) && $title_cart_font!='') {
	$char_set = '';
	if (get_theme_mod( 'title_cart_font_latin') == '1') { $char_set .= 'latin,'; }
	if (get_theme_mod( 'title_cart_font_latinext') == '1') { $char_set .= 'latin-ext,'; }
	if (get_theme_mod( 'title_cart_font_greek') == '1') { $char_set .= 'greek,'; }
	if (get_theme_mod( 'title_cart_font_greekext') == '1') { $char_set .= 'greek-ext,'; }
	if (get_theme_mod( 'title_cart_font_vietnamese') == '1') { $char_set .= 'vietnamese,'; }
	if (get_theme_mod( 'title_cart_font_cyrillic') == '1') { $char_set .= 'cyrillic,'; }
	if (get_theme_mod( 'title_cart_font_cyrillicext') == '1') { $char_set .= 'cyrillic-ext,'; }
	if ($char_set == '') { $char_set = 'latin'; }
	$char_set = rtrim($char_set, ",");
	$title_cart_font_link = str_replace(' ', '+', $title_cart_font);
	echo '@import url(https://fonts.googleapis.com/css?family='.$title_cart_font_link.':400,700&subset='.$char_set.');', PHP_EOL;
	$title_cart_font = '"'.$title_cart_font.'"';
}
if (isset($price_cart_font) && $price_cart_font!='') {
	$char_set = '';
	if (get_theme_mod( 'price_cart_font_latin') == '1') { $char_set .= 'latin,'; }
	if (get_theme_mod( 'price_cart_font_latinext') == '1') { $char_set .= 'latin-ext,'; }
	if (get_theme_mod( 'price_cart_font_greek') == '1') { $char_set .= 'greek,'; }
	if (get_theme_mod( 'price_cart_font_greekext') == '1') { $char_set .= 'greek-ext,'; }
	if (get_theme_mod( 'price_cart_font_vietnamese') == '1') { $char_set .= 'vietnamese,'; }
	if (get_theme_mod( 'price_cart_font_cyrillic') == '1') { $char_set .= 'cyrillic,'; }
	if (get_theme_mod( 'price_cart_font_cyrillicext') == '1') { $char_set .= 'cyrillic-ext,'; }
	if ($char_set == '') { $char_set = 'latin'; }
	$char_set = rtrim($char_set, ",");
	$price_cart_font_link = str_replace(' ', '+', $price_cart_font);
	echo '@import url(https://fonts.googleapis.com/css?family='.$price_cart_font_link.':400,700&subset='.$char_set.');', PHP_EOL;
	$price_cart_font = '"'.$price_cart_font.'"';
}

$table_cart_bg = get_theme_mod( 'table_cart_bg');
$table_cart_border_width = get_theme_mod( 'table_cart_border_width');
$table_cart_border_color = get_theme_mod( 'table_cart_border_color');
$table_cart_border_style = get_theme_mod( 'table_cart_border_style');
$table_cart_border_radius = get_theme_mod( 'table_cart_border_radius');
$table_font_cart_font = get_theme_mod( 'table_font_cart_font');
$table_font_cart_color = get_theme_mod( 'table_font_cart_color');
$table_font_cart_font_size = get_theme_mod( 'table_font_cart_font_size');
$table_font_cart_font_style = get_theme_mod( 'table_font_cart_font_style');
$table_font_cart_font_weight = get_theme_mod( 'table_font_cart_font_weight');
$table_font_cart_font_transform = get_theme_mod( 'table_font_cart_text_transform');
$table_font_cart_line_height = get_theme_mod( 'table_font_cart_line_height');
$table_font_cart_letter_spacing = get_theme_mod( 'table_font_cart_letter_spacing');


if (isset($table_font_cart_font) && $table_font_cart_font!='') {
	$char_set = '';
	if (get_theme_mod( 'table_font_cart_font_latin') == '1') { $char_set .= 'latin,'; }
	if (get_theme_mod( 'table_font_cart_font_latinext') == '1') { $char_set .= 'latin-ext,'; }
	if (get_theme_mod( 'table_font_cart_font_greek') == '1') { $char_set .= 'greek,'; }
	if (get_theme_mod( 'table_font_cart_font_greekext') == '1') { $char_set .= 'greek-ext,'; }
	if (get_theme_mod( 'table_font_cart_font_vietnamese') == '1') { $char_set .= 'vietnamese,'; }
	if (get_theme_mod( 'table_font_cart_font_cyrillic') == '1') { $char_set .= 'cyrillic,'; }
	if (get_theme_mod( 'table_font_cart_font_cyrillicext') == '1') { $char_set .= 'cyrillic-ext,'; }
	if ($char_set == '') { $char_set = 'latin'; }
	$char_set = rtrim($char_set, ",");
	$table_font_cart_font_link = str_replace(' ', '+', $table_font_cart_font);
	echo '@import url(https://fonts.googleapis.com/css?family='.$table_font_cart_font_link.':400,700&subset='.$char_set.');', PHP_EOL;
	$table_font_cart_font = '"'.$table_font_cart_font.'"';
}


?>














body.woocommerce-page ul.product_list_widget .product-title {
<?php if (isset($title_sidebar_font) && $title_sidebar_font!='') { echo 'font-family: '.$title_sidebar_font.'; ', PHP_EOL; } ?>
<?php if (isset($title_sidebar_color) && $title_sidebar_color!='') { echo 'color: '.$title_sidebar_color.'; ', PHP_EOL; } ?>
<?php if (isset($title_sidebar_font_size) && $title_sidebar_font_size!='') { echo 'font-size: '.$title_sidebar_font_size.'px; ', PHP_EOL; } ?>
<?php if (isset($title_sidebar_font_style) && $title_sidebar_font_style!='') { echo 'font-style: '.$title_sidebar_font_style.'; ', PHP_EOL; } ?>
<?php if (isset($title_sidebar_font_weight) && $title_sidebar_font_weight!='') { echo 'font-weight: '.$title_sidebar_font_weight.'; ', PHP_EOL; } ?>
<?php if (isset($title_sidebar_font_transform) && $title_sidebar_font_transform!='') { echo 'text-transform: '.$title_sidebar_font_transform.'; ', PHP_EOL; } ?>
<?php if (isset($title_sidebar_line_height) && $title_sidebar_line_height!='') { echo 'line-height: '.$title_sidebar_line_height.'px; '; } ?>
<?php if (isset($title_sidebar_letter_spacing) && $title_sidebar_letter_spacing!='') { echo 'letter-spacing: '.$title_sidebar_letter_spacing.'px; ', PHP_EOL; } ?>

}
body.woocommerce-page ul.product_list_widget a:hover .product-title {
<?php if (isset($title_sidebar_color_hover) && $title_sidebar_color_hover!='') { echo 'color: '.$title_sidebar_color_hover.'; ', PHP_EOL; } ?>

}
body.woocommerce-page ul.product_list_widget .amount {
<?php if (isset($price_sidebar_font) && $price_sidebar_font!='') { echo 'font-family: '.$price_sidebar_font.'; ', PHP_EOL; } ?>
<?php if (isset($price_sidebar_color) && $price_sidebar_color!='') { echo 'color: '.$price_sidebar_color.'; ', PHP_EOL; } ?>
<?php if (isset($price_sidebar_font_size) && $price_sidebar_font_size!='') { echo 'font-size: '.$price_sidebar_font_size.'px; ', PHP_EOL; } ?>
<?php if (isset($price_sidebar_font_style) && $price_sidebar_font_style!='') { echo 'font-style: '.$price_sidebar_font_style.'; ', PHP_EOL; } ?>
<?php if (isset($price_sidebar_font_weight) && $price_sidebar_font_weight!='') { echo 'font-weight: '.$price_sidebar_font_weight.'; ', PHP_EOL; } ?>
<?php if (isset($price_sidebar_font_transform) && $price_sidebar_font_transform!='') { echo 'text-transform: '.$price_sidebar_font_transform.'; ', PHP_EOL; } ?>
<?php if (isset($price_sidebar_line_height) && $price_sidebar_line_height!='') { echo 'line-height: '.$price_sidebar_line_height.'px; '; } ?>
<?php if (isset($price_sidebar_letter_spacing) && $price_sidebar_letter_spacing!='') { echo 'letter-spacing: '.$price_sidebar_letter_spacing.'px; ', PHP_EOL; } ?>

}


body.woocommerce-page ul.product_list_widget a img.wp-post-image {
<?php if (isset($img_sidebar_border_width) && $img_sidebar_border_width!='') { echo 'border-width: '.$img_sidebar_border_width.'px; ', PHP_EOL; } ?>
<?php if (isset($img_sidebar_border_color) && $img_sidebar_border_color!='') { echo 'border-color: '.$img_sidebar_border_color.'; ', PHP_EOL; } ?>
<?php if (isset($img_sidebar_border_style) && $img_sidebar_border_style!='') { echo 'border-style: '.$img_sidebar_border_style.'; ', PHP_EOL; } ?>
<?php if (isset($img_sidebar_border_radius) && $img_sidebar_border_radius!='') { echo '-webkit-border-radius: '.$img_sidebar_border_radius.'px; ', PHP_EOL; echo '-moz-border-radius: '.$img_sidebar_border_radius.'px; ', PHP_EOL; echo 'border-radius: '.$img_sidebar_border_radius.'px; ', PHP_EOL; } ?>

}
body.woocommerce-page ul.product_list_widget a:hover img.wp-post-image {
<?php if (isset($img_sidebar_border_color_hover) && $img_sidebar_border_color_hover!='') { echo 'border-color: '.$img_sidebar_border_color_hover.'; ', PHP_EOL; } ?>

}



















body.woocommerce-page.single-product div.product form.cart .button {
<?php if (isset($btn_single_bg) && $btn_single_bg!='') { echo 'background: '.$btn_single_bg.'; ', PHP_EOL; } ?>
<?php if (isset($btn_single_color) && $btn_single_color!='') { echo 'color: '.$btn_single_color.'; ', PHP_EOL; } ?>
<?php if (isset($btn_single_border_width) && $btn_single_border_width!='') { echo 'border-width: '.$btn_single_border_width.'px; ', PHP_EOL; } ?>
<?php if (isset($btn_single_border_color) && $btn_single_border_color!='') { echo 'border-color: '.$btn_single_border_color.'; ', PHP_EOL; } ?>
<?php if (isset($btn_single_border_style) && $btn_single_border_style!='') { echo 'border-style: '.$btn_single_border_style.'; ', PHP_EOL; } ?>
<?php if (isset($btn_single_border_radius) && $btn_single_border_radius!='') { echo '-webkit-border-radius: '.$btn_single_border_radius.'px; ', PHP_EOL; echo '-moz-border-radius: '.$btn_single_border_radius.'px; ', PHP_EOL; echo 'border-radius: '.$btn_single_border_radius.'px; ', PHP_EOL; } ?>
<?php if (isset($btn_single_font) && $btn_single_font!='') { echo 'font-family: '.$btn_single_font.'; ', PHP_EOL; } ?>
<?php if (isset($btn_single_font_size) && $btn_single_font_size!='') { echo 'font-size: '.$btn_single_font_size.'px; ', PHP_EOL; } ?>
<?php if (isset($btn_single_font_style) && $btn_single_font_style!='') { echo 'font-style: '.$btn_single_font_style.'; ', PHP_EOL; } ?>
<?php if (isset($btn_single_font_weight) && $btn_single_font_weight!='') { echo 'font-weight: '.$btn_single_font_weight.'; ', PHP_EOL; } ?>
<?php if (isset($btn_single_font_transform) && $btn_single_font_transform!='') { echo 'text-transform: '.$btn_single_font_transform.'; ', PHP_EOL; } ?>
<?php if (isset($btn_single_line_height) && $btn_single_line_height!='') { echo 'line-height: '.$btn_single_line_height.'px; '; } ?>
<?php if (isset($btn_single_letter_spacing) && $btn_single_letter_spacing!='') { echo 'letter-spacing: '.$btn_single_letter_spacing.'px; ', PHP_EOL; } ?>
	
	
}

body.woocommerce-page.single-product div.product form.cart .button:hover {
<?php if (isset($btn_single_bg_hover) && $btn_single_bg_hover!='') { echo 'background: '.$btn_single_bg_hover.'; ', PHP_EOL; } ?>
<?php if (isset($btn_single_color_hover) && $btn_single_color_hover!='') { echo 'color: '.$btn_single_color_hover.'; ', PHP_EOL; } ?>
<?php if (isset($btn_single_border_color_hover) && $btn_single_border_color_hover!='') { echo 'border-color: '.$btn_single_border_color_hover.'; ', PHP_EOL; } ?>
}

body.woocommerce-page.single-product div.product .product_title {
<?php if (isset($title_single_font) && $title_single_font!='') { echo 'font-family: '.$title_single_font.'; ', PHP_EOL; } ?>
<?php if (isset($title_single_color) && $title_single_color!='') { echo 'color: '.$title_single_color.'; ', PHP_EOL; } ?>
<?php if (isset($title_single_font_size) && $title_single_font_size!='') { echo 'font-size: '.$title_single_font_size.'px; ', PHP_EOL; } ?>
<?php if (isset($title_single_font_style) && $title_single_font_style!='') { echo 'font-style: '.$title_single_font_style.'; ', PHP_EOL; } ?>
<?php if (isset($title_single_font_weight) && $title_single_font_weight!='') { echo 'font-weight: '.$title_single_font_weight.'; ', PHP_EOL; } ?>
<?php if (isset($title_single_font_transform) && $title_single_font_transform!='') { echo 'text-transform: '.$title_single_font_transform.'; ', PHP_EOL; } ?>
<?php if (isset($title_single_line_height) && $title_single_line_height!='') { echo 'line-height: '.$title_single_line_height.'px; '; } ?>
<?php if (isset($title_single_letter_spacing) && $title_single_letter_spacing!='') { echo 'letter-spacing: '.$title_single_letter_spacing.'px; ', PHP_EOL; } ?>

}
body.woocommerce-page.single-product div.product .price {
<?php if (isset($price_single_font) && $price_single_font!='') { echo 'font-family: '.$price_single_font.'; ', PHP_EOL; } ?>
<?php if (isset($price_single_color) && $price_single_color!='') { echo 'color: '.$price_single_color.'; ', PHP_EOL; } ?>
<?php if (isset($price_single_font_size) && $price_single_font_size!='') { echo 'font-size: '.$price_single_font_size.'px; ', PHP_EOL; } ?>
<?php if (isset($price_single_font_style) && $price_single_font_style!='') { echo 'font-style: '.$price_single_font_style.'; ', PHP_EOL; } ?>
<?php if (isset($price_single_font_weight) && $price_single_font_weight!='') { echo 'font-weight: '.$price_single_font_weight.'; ', PHP_EOL; } ?>
<?php if (isset($price_single_font_transform) && $price_single_font_transform!='') { echo 'text-transform: '.$price_single_font_transform.'; ', PHP_EOL; } ?>
<?php if (isset($price_single_line_height) && $price_single_line_height!='') { echo 'line-height: '.$price_single_line_height.'px; '; } ?>
<?php if (isset($price_single_letter_spacing) && $price_single_letter_spacing!='') { echo 'letter-spacing: '.$price_single_letter_spacing.'px; ', PHP_EOL; } ?>

}


body.woocommerce-page.single-product div.product div.images img {
<?php if (isset($img_single_border_width) && $img_single_border_width!='') { echo 'border-width: '.$img_single_border_width.'px; ', PHP_EOL; } ?>
<?php if (isset($img_single_border_color) && $img_single_border_color!='') { echo 'border-color: '.$img_single_border_color.'; ', PHP_EOL; } ?>
<?php if (isset($img_single_border_style) && $img_single_border_style!='') { echo 'border-style: '.$img_single_border_style.'; ', PHP_EOL; } ?>
<?php if (isset($img_single_border_radius) && $img_single_border_radius!='') { echo '-webkit-border-radius: '.$img_single_border_radius.'px; ', PHP_EOL; echo '-moz-border-radius: '.$img_single_border_radius.'px; ', PHP_EOL; echo 'border-radius: '.$img_single_border_radius.'px; ', PHP_EOL; } ?>

}
body.woocommerce-page.single-product div.product div.images a:hover img {
<?php if (isset($img_single_border_color_hover) && $img_single_border_color_hover!='') { echo 'border-color: '.$img_single_border_color_hover.'; ', PHP_EOL; } ?>

}


body.woocommerce-page.single-product div.product > .onsale {
<?php if (isset($sbadge_single_bg) && $sbadge_single_bg!='') { echo 'background: '.$sbadge_single_bg.'; ', PHP_EOL; } ?>
<?php if (isset($sbadge_single_color) && $sbadge_single_color!='') { echo 'color: '.$sbadge_single_color.'; ', PHP_EOL; } ?>
<?php if (isset($sbadge_single_border_width) && $sbadge_single_border_width!='') { echo 'border-width: '.$sbadge_single_border_width.'px; ', PHP_EOL; } ?>
<?php if (isset($sbadge_single_border_color) && $sbadge_single_border_color!='') { echo 'border-color: '.$sbadge_single_border_color.'; ', PHP_EOL; } ?>
<?php if (isset($sbadge_single_border_style) && $sbadge_single_border_style!='') { echo 'border-style: '.$sbadge_single_border_style.'; ', PHP_EOL; } ?>
<?php if (isset($sbadge_single_border_radius) && $sbadge_single_border_radius!='') { echo '-webkit-border-radius: '.$sbadge_single_border_radius.'px; ', PHP_EOL; echo '-moz-border-radius: '.$sbadge_single_border_radius.'px; ', PHP_EOL; echo 'border-radius: '.$sbadge_single_border_radius.'px; ', PHP_EOL; } ?>
<?php if (isset($sbadge_single_font) && $sbadge_single_font!='') { echo 'font-family: '.$sbadge_single_font.'; ', PHP_EOL; } ?>
<?php if (isset($sbadge_single_font_size) && $sbadge_single_font_size!='') { echo 'font-size: '.$sbadge_single_font_size.'px; ', PHP_EOL; } ?>
<?php if (isset($sbadge_single_font_style) && $sbadge_single_font_style!='') { echo 'font-style: '.$sbadge_single_font_style.'; ', PHP_EOL; } ?>
<?php if (isset($sbadge_single_font_weight) && $sbadge_single_font_weight!='') { echo 'font-weight: '.$sbadge_single_font_weight.'; ', PHP_EOL; } ?>
<?php if (isset($sbadge_single_font_transform) && $sbadge_single_font_transform!='') { echo 'text-transform: '.$sbadge_single_font_transform.'; ', PHP_EOL; } ?>
<?php if (isset($sbadge_single_line_height) && $sbadge_single_line_height!='') { echo 'line-height: '.$sbadge_single_line_height.'px; '; } ?>
<?php if (isset($sbadge_single_letter_spacing) && $sbadge_single_letter_spacing!='') { echo 'letter-spacing: '.$sbadge_single_letter_spacing.'px; ', PHP_EOL; } ?>
<?php if (isset($sbadge_single_padding) && $sbadge_single_padding!='') { echo 'padding: '.$sbadge_single_padding.'px; ', PHP_EOL; } ?>
	
	
}




















body.woocommerce-page ul.products a.button {
<?php if (isset($btn_list_bg) && $btn_list_bg!='') { echo 'background: '.$btn_list_bg.'; ', PHP_EOL; } ?>
<?php if (isset($btn_list_color) && $btn_list_color!='') { echo 'color: '.$btn_list_color.'; ', PHP_EOL; } ?>
<?php if (isset($btn_list_border_width) && $btn_list_border_width!='') { echo 'border-width: '.$btn_list_border_width.'px; ', PHP_EOL; } ?>
<?php if (isset($btn_list_border_color) && $btn_list_border_color!='') { echo 'border-color: '.$btn_list_border_color.'; ', PHP_EOL; } ?>
<?php if (isset($btn_list_border_style) && $btn_list_border_style!='') { echo 'border-style: '.$btn_list_border_style.'; ', PHP_EOL; } ?>
<?php if (isset($btn_list_border_radius) && $btn_list_border_radius!='') { echo '-webkit-border-radius: '.$btn_list_border_radius.'px; ', PHP_EOL; echo '-moz-border-radius: '.$btn_list_border_radius.'px; ', PHP_EOL; echo 'border-radius: '.$btn_list_border_radius.'px; ', PHP_EOL; } ?>
<?php if (isset($btn_list_font) && $btn_list_font!='') { echo 'font-family: '.$btn_list_font.'; ', PHP_EOL; } ?>
<?php if (isset($btn_list_font_size) && $btn_list_font_size!='') { echo 'font-size: '.$btn_list_font_size.'px; ', PHP_EOL; } ?>
<?php if (isset($btn_list_font_style) && $btn_list_font_style!='') { echo 'font-style: '.$btn_list_font_style.'; ', PHP_EOL; } ?>
<?php if (isset($btn_list_font_weight) && $btn_list_font_weight!='') { echo 'font-weight: '.$btn_list_font_weight.'; ', PHP_EOL; } ?>
<?php if (isset($btn_list_font_transform) && $btn_list_font_transform!='') { echo 'text-transform: '.$btn_list_font_transform.'; ', PHP_EOL; } ?>
<?php if (isset($btn_list_line_height) && $btn_list_line_height!='') { echo 'line-height: '.$btn_list_line_height.'px; '; } ?>
<?php if (isset($btn_list_letter_spacing) && $btn_list_letter_spacing!='') { echo 'letter-spacing: '.$btn_list_letter_spacing.'px; ', PHP_EOL; } ?>
	
	
}

body.woocommerce-page ul.products a.button:hover {
<?php if (isset($btn_list_bg_hover) && $btn_list_bg_hover!='') { echo 'background: '.$btn_list_bg_hover.'; ', PHP_EOL; } ?>
<?php if (isset($btn_list_color_hover) && $btn_list_color_hover!='') { echo 'color: '.$btn_list_color_hover.'; ', PHP_EOL; } ?>
<?php if (isset($btn_list_border_color_hover) && $btn_list_border_color_hover!='') { echo 'border-color: '.$btn_list_border_color_hover.'; ', PHP_EOL; } ?>
}

body.woocommerce-page ul.products h3 {
<?php if (isset($title_list_font) && $title_list_font!='') { echo 'font-family: '.$title_list_font.'; ', PHP_EOL; } ?>
<?php if (isset($title_list_color) && $title_list_color!='') { echo 'color: '.$title_list_color.'; ', PHP_EOL; } ?>
<?php if (isset($title_list_font_size) && $title_list_font_size!='') { echo 'font-size: '.$title_list_font_size.'px; ', PHP_EOL; } ?>
<?php if (isset($title_list_font_style) && $title_list_font_style!='') { echo 'font-style: '.$title_list_font_style.'; ', PHP_EOL; } ?>
<?php if (isset($title_list_font_weight) && $title_list_font_weight!='') { echo 'font-weight: '.$title_list_font_weight.'; ', PHP_EOL; } ?>
<?php if (isset($title_list_font_transform) && $title_list_font_transform!='') { echo 'text-transform: '.$title_list_font_transform.'; ', PHP_EOL; } ?>
<?php if (isset($title_list_line_height) && $title_list_line_height!='') { echo 'line-height: '.$title_list_line_height.'px; '; } ?>
<?php if (isset($title_list_letter_spacing) && $title_list_letter_spacing!='') { echo 'letter-spacing: '.$title_list_letter_spacing.'px; ', PHP_EOL; } ?>

}
body.woocommerce-page ul.products a:hover h3 {
<?php if (isset($title_list_color_hover) && $title_list_color_hover!='') { echo 'color: '.$title_list_color_hover.'; ', PHP_EOL; } ?>

}
body.woocommerce-page ul.products .price {
<?php if (isset($price_list_font) && $price_list_font!='') { echo 'font-family: '.$price_list_font.'; ', PHP_EOL; } ?>
<?php if (isset($price_list_color) && $price_list_color!='') { echo 'color: '.$price_list_color.'; ', PHP_EOL; } ?>
<?php if (isset($price_list_font_size) && $price_list_font_size!='') { echo 'font-size: '.$price_list_font_size.'px; ', PHP_EOL; } ?>
<?php if (isset($price_list_font_style) && $price_list_font_style!='') { echo 'font-style: '.$price_list_font_style.'; ', PHP_EOL; } ?>
<?php if (isset($price_list_font_weight) && $price_list_font_weight!='') { echo 'font-weight: '.$price_list_font_weight.'; ', PHP_EOL; } ?>
<?php if (isset($price_list_font_transform) && $price_list_font_transform!='') { echo 'text-transform: '.$price_list_font_transform.'; ', PHP_EOL; } ?>
<?php if (isset($price_list_line_height) && $price_list_line_height!='') { echo 'line-height: '.$price_list_line_height.'px; '; } ?>
<?php if (isset($price_list_letter_spacing) && $price_list_letter_spacing!='') { echo 'letter-spacing: '.$price_list_letter_spacing.'px; ', PHP_EOL; } ?>

}
body.woocommerce-page ul.products a:hover .price {
<?php if (isset($price_list_color_hover) && $price_list_color_hover!='') { echo 'color: '.$price_list_color_hover.'; ', PHP_EOL; } ?>

}


body.woocommerce-page ul.products a img.wp-post-image {
<?php if (isset($img_list_border_width) && $img_list_border_width!='') { echo 'border-width: '.$img_list_border_width.'px; ', PHP_EOL; } ?>
<?php if (isset($img_list_border_color) && $img_list_border_color!='') { echo 'border-color: '.$img_list_border_color.'; ', PHP_EOL; } ?>
<?php if (isset($img_list_border_style) && $img_list_border_style!='') { echo 'border-style: '.$img_list_border_style.'; ', PHP_EOL; } ?>
<?php if (isset($img_list_border_radius) && $img_list_border_radius!='') { echo '-webkit-border-radius: '.$img_list_border_radius.'px; ', PHP_EOL; echo '-moz-border-radius: '.$img_list_border_radius.'px; ', PHP_EOL; echo 'border-radius: '.$img_list_border_radius.'px; ', PHP_EOL; } ?>

}
body.woocommerce-page ul.products a:hover img.wp-post-image {
<?php if (isset($img_list_border_color_hover) && $img_list_border_color_hover!='') { echo 'border-color: '.$img_list_border_color_hover.'; ', PHP_EOL; } ?>

}


body.woocommerce-page ul.products a .onsale {
<?php if (isset($sbadge_list_bg) && $sbadge_list_bg!='') { echo 'background: '.$sbadge_list_bg.'; ', PHP_EOL; } ?>
<?php if (isset($sbadge_list_color) && $sbadge_list_color!='') { echo 'color: '.$sbadge_list_color.'; ', PHP_EOL; } ?>
<?php if (isset($sbadge_list_border_width) && $sbadge_list_border_width!='') { echo 'border-width: '.$sbadge_list_border_width.'px; ', PHP_EOL; } ?>
<?php if (isset($sbadge_list_border_color) && $sbadge_list_border_color!='') { echo 'border-color: '.$sbadge_list_border_color.'; ', PHP_EOL; } ?>
<?php if (isset($sbadge_list_border_style) && $sbadge_list_border_style!='') { echo 'border-style: '.$sbadge_list_border_style.'; ', PHP_EOL; } ?>
<?php if (isset($sbadge_list_border_radius) && $sbadge_list_border_radius!='') { echo '-webkit-border-radius: '.$sbadge_list_border_radius.'px; ', PHP_EOL; echo '-moz-border-radius: '.$sbadge_list_border_radius.'px; ', PHP_EOL; echo 'border-radius: '.$sbadge_list_border_radius.'px; ', PHP_EOL; } ?>
<?php if (isset($sbadge_list_font) && $sbadge_list_font!='') { echo 'font-family: '.$sbadge_list_font.'; ', PHP_EOL; } ?>
<?php if (isset($sbadge_list_font_size) && $sbadge_list_font_size!='') { echo 'font-size: '.$sbadge_list_font_size.'px; ', PHP_EOL; } ?>
<?php if (isset($sbadge_list_font_style) && $sbadge_list_font_style!='') { echo 'font-style: '.$sbadge_list_font_style.'; ', PHP_EOL; } ?>
<?php if (isset($sbadge_list_font_weight) && $sbadge_list_font_weight!='') { echo 'font-weight: '.$sbadge_list_font_weight.'; ', PHP_EOL; } ?>
<?php if (isset($sbadge_list_font_transform) && $sbadge_list_font_transform!='') { echo 'text-transform: '.$sbadge_list_font_transform.'; ', PHP_EOL; } ?>
<?php if (isset($sbadge_list_line_height) && $sbadge_list_line_height!='') { echo 'line-height: '.$sbadge_list_line_height.'px; '; } ?>
<?php if (isset($sbadge_list_letter_spacing) && $sbadge_list_letter_spacing!='') { echo 'letter-spacing: '.$sbadge_list_letter_spacing.'px; ', PHP_EOL; } ?>
<?php if (isset($sbadge_list_padding) && $sbadge_list_padding!='') { echo 'padding: '.$sbadge_list_padding.'px; ', PHP_EOL; } ?>
	
	
}
body.woocommerce-page ul.products a:hover .onsale {
<?php if (isset($sbadge_list_bg_hover) && $sbadge_list_bg_hover!='') { echo 'background: '.$sbadge_list_bg_hover.'; ', PHP_EOL; } ?>
<?php if (isset($sbadge_list_color_hover) && $sbadge_list_color_hover!='') { echo 'color: '.$sbadge_list_color_hover.'; ', PHP_EOL; } ?>
<?php if (isset($sbadge_list_border_color_hover) && $sbadge_list_border_color_hover!='') { echo 'border-color: '.$sbadge_list_border_color_hover.'; ', PHP_EOL; } ?>
}





















body.woocommerce-page .woocommerce table.shop_table.cart .actions input.button {
<?php if (isset($btn_cart_bg) && $btn_cart_bg!='') { echo 'background: '.$btn_cart_bg.'; ', PHP_EOL; } ?>
<?php if (isset($btn_cart_color) && $btn_cart_color!='') { echo 'color: '.$btn_cart_color.'; ', PHP_EOL; } ?>
<?php if (isset($btn_cart_border_width) && $btn_cart_border_width!='') { echo 'border-width: '.$btn_cart_border_width.'px; ', PHP_EOL; } ?>
<?php if (isset($btn_cart_border_color) && $btn_cart_border_color!='') { echo 'border-color: '.$btn_cart_border_color.'; ', PHP_EOL; } ?>
<?php if (isset($btn_cart_border_style) && $btn_cart_border_style!='') { echo 'border-style: '.$btn_cart_border_style.'; ', PHP_EOL; } ?>
<?php if (isset($btn_cart_border_radius) && $btn_cart_border_radius!='') { echo '-webkit-border-radius: '.$btn_cart_border_radius.'px; ', PHP_EOL; echo '-moz-border-radius: '.$btn_cart_border_radius.'px; ', PHP_EOL; echo 'border-radius: '.$btn_cart_border_radius.'px; ', PHP_EOL; } ?>
<?php if (isset($btn_cart_font) && $btn_cart_font!='') { echo 'font-family: '.$btn_cart_font.'; ', PHP_EOL; } ?>
<?php if (isset($btn_cart_font_size) && $btn_cart_font_size!='') { echo 'font-size: '.$btn_cart_font_size.'px; ', PHP_EOL; } ?>
<?php if (isset($btn_cart_font_style) && $btn_cart_font_style!='') { echo 'font-style: '.$btn_cart_font_style.'; ', PHP_EOL; } ?>
<?php if (isset($btn_cart_font_weight) && $btn_cart_font_weight!='') { echo 'font-weight: '.$btn_cart_font_weight.'; ', PHP_EOL; } ?>
<?php if (isset($btn_cart_font_transform) && $btn_cart_font_transform!='') { echo 'text-transform: '.$btn_cart_font_transform.'; ', PHP_EOL; } ?>
<?php if (isset($btn_cart_line_height) && $btn_cart_line_height!='') { echo 'line-height: '.$btn_cart_line_height.'px; '; } ?>
<?php if (isset($btn_cart_letter_spacing) && $btn_cart_letter_spacing!='') { echo 'letter-spacing: '.$btn_cart_letter_spacing.'px; ', PHP_EOL; } ?>
	
	
}

body.woocommerce-page .woocommerce table.shop_table.cart .actions input.button:hover {
<?php if (isset($btn_cart_bg_hover) && $btn_cart_bg_hover!='') { echo 'background: '.$btn_cart_bg_hover.'; ', PHP_EOL; } ?>
<?php if (isset($btn_cart_color_hover) && $btn_cart_color_hover!='') { echo 'color: '.$btn_cart_color_hover.'; ', PHP_EOL; } ?>
<?php if (isset($btn_cart_border_color_hover) && $btn_cart_border_color_hover!='') { echo 'border-color: '.$btn_cart_border_color_hover.'; ', PHP_EOL; } ?>
}

body.woocommerce-page .woocommerce table.shop_table.cart .actions .coupon input.button {
<?php if (isset($btnC_cart_bg) && $btnC_cart_bg!='') { echo 'background: '.$btnC_cart_bg.'; ', PHP_EOL; } ?>
<?php if (isset($btnC_cart_color) && $btnC_cart_color!='') { echo 'color: '.$btnC_cart_color.'; ', PHP_EOL; } ?>
<?php if (isset($btnC_cart_border_width) && $btnC_cart_border_width!='') { echo 'border-width: '.$btnC_cart_border_width.'px; ', PHP_EOL; } ?>
<?php if (isset($btnC_cart_border_color) && $btnC_cart_border_color!='') { echo 'border-color: '.$btnC_cart_border_color.'; ', PHP_EOL; } ?>
<?php if (isset($btnC_cart_border_style) && $btnC_cart_border_style!='') { echo 'border-style: '.$btnC_cart_border_style.'; ', PHP_EOL; } ?>
<?php if (isset($btnC_cart_border_radius) && $btnC_cart_border_radius!='') { echo '-webkit-border-radius: '.$btnC_cart_border_radius.'px; ', PHP_EOL; echo '-moz-border-radius: '.$btnC_cart_border_radius.'px; ', PHP_EOL; echo 'border-radius: '.$btnC_cart_border_radius.'px; ', PHP_EOL; } ?>
<?php if (isset($btnC_cart_font) && $btnC_cart_font!='') { echo 'font-family: '.$btnC_cart_font.'; ', PHP_EOL; } ?>
<?php if (isset($btnC_cart_font_size) && $btnC_cart_font_size!='') { echo 'font-size: '.$btnC_cart_font_size.'px; ', PHP_EOL; } ?>
<?php if (isset($btnC_cart_font_style) && $btnC_cart_font_style!='') { echo 'font-style: '.$btnC_cart_font_style.'; ', PHP_EOL; } ?>
<?php if (isset($btnC_cart_font_weight) && $btnC_cart_font_weight!='') { echo 'font-weight: '.$btnC_cart_font_weight.'; ', PHP_EOL; } ?>
<?php if (isset($btnC_cart_font_transform) && $btnC_cart_font_transform!='') { echo 'text-transform: '.$btnC_cart_font_transform.'; ', PHP_EOL; } ?>
<?php if (isset($btnC_cart_line_height) && $btnC_cart_line_height!='') { echo 'line-height: '.$btnC_cart_line_height.'px; '; } ?>
<?php if (isset($btnC_cart_letter_spacing) && $btnC_cart_letter_spacing!='') { echo 'letter-spacing: '.$btnC_cart_letter_spacing.'px; ', PHP_EOL; } ?>
	
	
}

body.woocommerce-page .woocommerce table.shop_table.cart .actions .coupon input.button:hover {
<?php if (isset($btnC_cart_bg_hover) && $btnC_cart_bg_hover!='') { echo 'background: '.$btnC_cart_bg_hover.'; ', PHP_EOL; } ?>
<?php if (isset($btnC_cart_color_hover) && $btnC_cart_color_hover!='') { echo 'color: '.$btnC_cart_color_hover.'; ', PHP_EOL; } ?>
<?php if (isset($btnC_cart_border_color_hover) && $btnC_cart_border_color_hover!='') { echo 'border-color: '.$btnC_cart_border_color_hover.'; ', PHP_EOL; } ?>
}

body.woocommerce-page .woocommerce a.checkout-button {
<?php if (isset($btnX_cart_bg) && $btnX_cart_bg!='') { echo 'background: '.$btnX_cart_bg.'; ', PHP_EOL; } ?>
<?php if (isset($btnX_cart_color) && $btnX_cart_color!='') { echo 'color: '.$btnX_cart_color.'; ', PHP_EOL; } ?>
<?php if (isset($btnX_cart_border_width) && $btnX_cart_border_width!='') { echo 'border-width: '.$btnX_cart_border_width.'px; ', PHP_EOL; } ?>
<?php if (isset($btnX_cart_border_color) && $btnX_cart_border_color!='') { echo 'border-color: '.$btnX_cart_border_color.'; ', PHP_EOL; } ?>
<?php if (isset($btnX_cart_border_style) && $btnX_cart_border_style!='') { echo 'border-style: '.$btnX_cart_border_style.'; ', PHP_EOL; } ?>
<?php if (isset($btnX_cart_border_radius) && $btnX_cart_border_radius!='') { echo '-webkit-border-radius: '.$btnX_cart_border_radius.'px; ', PHP_EOL; echo '-moz-border-radius: '.$btnX_cart_border_radius.'px; ', PHP_EOL; echo 'border-radius: '.$btnX_cart_border_radius.'px; ', PHP_EOL; } ?>
<?php if (isset($btnX_cart_font) && $btnX_cart_font!='') { echo 'font-family: '.$btnX_cart_font.'; ', PHP_EOL; } ?>
<?php if (isset($btnX_cart_font_size) && $btnX_cart_font_size!='') { echo 'font-size: '.$btnX_cart_font_size.'px; ', PHP_EOL; } ?>
<?php if (isset($btnX_cart_font_style) && $btnX_cart_font_style!='') { echo 'font-style: '.$btnX_cart_font_style.'; ', PHP_EOL; } ?>
<?php if (isset($btnX_cart_font_weight) && $btnX_cart_font_weight!='') { echo 'font-weight: '.$btnX_cart_font_weight.'; ', PHP_EOL; } ?>
<?php if (isset($btnX_cart_font_transform) && $btnX_cart_font_transform!='') { echo 'text-transform: '.$btnX_cart_font_transform.'; ', PHP_EOL; } ?>
<?php if (isset($btnX_cart_line_height) && $btnX_cart_line_height!='') { echo 'line-height: '.$btnX_cart_line_height.'px; '; } ?>
<?php if (isset($btnX_cart_letter_spacing) && $btnX_cart_letter_spacing!='') { echo 'letter-spacing: '.$btnX_cart_letter_spacing.'px; ', PHP_EOL; } ?>
	
	
}

body.woocommerce-page .woocommerce a.checkout-button:hover {
<?php if (isset($btnX_cart_bg_hover) && $btnX_cart_bg_hover!='') { echo 'background: '.$btnX_cart_bg_hover.'; ', PHP_EOL; } ?>
<?php if (isset($btnX_cart_color_hover) && $btnX_cart_color_hover!='') { echo 'color: '.$btnX_cart_color_hover.'; ', PHP_EOL; } ?>
<?php if (isset($btnX_cart_border_color_hover) && $btnX_cart_border_color_hover!='') { echo 'border-color: '.$btnX_cart_border_color_hover.'; ', PHP_EOL; } ?>
}


body.woocommerce-page .woocommerce table.shop_table.cart .product-name a {
<?php if (isset($title_cart_font) && $title_cart_font!='') { echo 'font-family: '.$title_cart_font.'; ', PHP_EOL; } ?>
<?php if (isset($title_cart_color) && $title_cart_color!='') { echo 'color: '.$title_cart_color.'; ', PHP_EOL; } ?>
<?php if (isset($title_cart_font_size) && $title_cart_font_size!='') { echo 'font-size: '.$title_cart_font_size.'px; ', PHP_EOL; } ?>
<?php if (isset($title_cart_font_style) && $title_cart_font_style!='') { echo 'font-style: '.$title_cart_font_style.'; ', PHP_EOL; } ?>
<?php if (isset($title_cart_font_weight) && $title_cart_font_weight!='') { echo 'font-weight: '.$title_cart_font_weight.'; ', PHP_EOL; } ?>
<?php if (isset($title_cart_font_transform) && $title_cart_font_transform!='') { echo 'text-transform: '.$title_cart_font_transform.'; ', PHP_EOL; } ?>
<?php if (isset($title_cart_line_height) && $title_cart_line_height!='') { echo 'line-height: '.$title_cart_line_height.'px; '; } ?>
<?php if (isset($title_cart_letter_spacing) && $title_cart_letter_spacing!='') { echo 'letter-spacing: '.$title_cart_letter_spacing.'px; ', PHP_EOL; } ?>

}
body.woocommerce-page .woocommerce table.shop_table.cart .product-name a:hover {
<?php if (isset($title_cart_color_hover) && $title_cart_color_hover!='') { echo 'color: '.$title_cart_color_hover.'; ', PHP_EOL; } ?>

}
body.woocommerce-page .woocommerce table.shop_table.cart .product-price .amount {
<?php if (isset($price_cart_font) && $price_cart_font!='') { echo 'font-family: '.$price_cart_font.'; ', PHP_EOL; } ?>
<?php if (isset($price_cart_color) && $price_cart_color!='') { echo 'color: '.$price_cart_color.'; ', PHP_EOL; } ?>
<?php if (isset($price_cart_font_size) && $price_cart_font_size!='') { echo 'font-size: '.$price_cart_font_size.'px; ', PHP_EOL; } ?>
<?php if (isset($price_cart_font_style) && $price_cart_font_style!='') { echo 'font-style: '.$price_cart_font_style.'; ', PHP_EOL; } ?>
<?php if (isset($price_cart_font_weight) && $price_cart_font_weight!='') { echo 'font-weight: '.$price_cart_font_weight.'; ', PHP_EOL; } ?>
<?php if (isset($price_cart_font_transform) && $price_cart_font_transform!='') { echo 'text-transform: '.$price_cart_font_transform.'; ', PHP_EOL; } ?>
<?php if (isset($price_cart_line_height) && $price_cart_line_height!='') { echo 'line-height: '.$price_cart_line_height.'px; '; } ?>
<?php if (isset($price_cart_letter_spacing) && $price_cart_letter_spacing!='') { echo 'letter-spacing: '.$price_cart_letter_spacing.'px; ', PHP_EOL; } ?>

}
body.woocommerce-page .woocommerce table.shop_table.cart .product-subtotal .amount {
<?php if (isset($price_cart_font) && $price_cart_font!='') { echo 'font-family: '.$price_cart_font.'; ', PHP_EOL; } ?>
<?php if (isset($price_cart_color) && $price_cart_color!='') { echo 'color: '.$price_cart_color.'; ', PHP_EOL; } ?>
<?php if (isset($price_cart_font_size) && $price_cart_font_size!='') { echo 'font-size: '.$price_cart_font_size.'px; ', PHP_EOL; } ?>
<?php if (isset($price_cart_font_style) && $price_cart_font_style!='') { echo 'font-style: '.$price_cart_font_style.'; ', PHP_EOL; } ?>
<?php if (isset($price_cart_font_weight) && $price_cart_font_weight!='') { echo 'font-weight: '.$price_cart_font_weight.'; ', PHP_EOL; } ?>
<?php if (isset($price_cart_font_transform) && $price_cart_font_transform!='') { echo 'text-transform: '.$price_cart_font_transform.'; ', PHP_EOL; } ?>
<?php if (isset($price_cart_line_height) && $price_cart_line_height!='') { echo 'line-height: '.$price_cart_line_height.'px; '; } ?>
<?php if (isset($price_cart_letter_spacing) && $price_cart_letter_spacing!='') { echo 'letter-spacing: '.$price_cart_letter_spacing.'px; ', PHP_EOL; } ?>

}
body.woocommerce-page .woocommerce table.shop_table.cart .product-quantity .qty {
<?php if (isset($price_cart_font) && $price_cart_font!='') { echo 'font-family: '.$price_cart_font.'; ', PHP_EOL; } ?>
<?php if (isset($price_cart_color) && $price_cart_color!='') { echo 'color: '.$price_cart_color.'; ', PHP_EOL; } ?>
<?php if (isset($price_cart_font_size) && $price_cart_font_size!='') { echo 'font-size: '.$price_cart_font_size.'px; ', PHP_EOL; } ?>
<?php if (isset($price_cart_font_style) && $price_cart_font_style!='') { echo 'font-style: '.$price_cart_font_style.'; ', PHP_EOL; } ?>
<?php if (isset($price_cart_font_weight) && $price_cart_font_weight!='') { echo 'font-weight: '.$price_cart_font_weight.'; ', PHP_EOL; } ?>
<?php if (isset($price_cart_font_transform) && $price_cart_font_transform!='') { echo 'text-transform: '.$price_cart_font_transform.'; ', PHP_EOL; } ?>
<?php if (isset($price_cart_line_height) && $price_cart_line_height!='') { echo 'line-height: '.$price_cart_line_height.'px; '; } ?>
<?php if (isset($price_cart_letter_spacing) && $price_cart_letter_spacing!='') { echo 'letter-spacing: '.$price_cart_letter_spacing.'px; ', PHP_EOL; } ?>

}


body.woocommerce-page .woocommerce table.shop_table.cart .product-thumbnail a img.wp-post-image {
<?php if (isset($img_cart_border_width) && $img_cart_border_width!='') { echo 'border-width: '.$img_cart_border_width.'px; ', PHP_EOL; } ?>
<?php if (isset($img_cart_border_color) && $img_cart_border_color!='') { echo 'border-color: '.$img_cart_border_color.'; ', PHP_EOL; } ?>
<?php if (isset($img_cart_border_style) && $img_cart_border_style!='') { echo 'border-style: '.$img_cart_border_style.'; ', PHP_EOL; } ?>
<?php if (isset($img_cart_border_radius) && $img_cart_border_radius!='') { echo '-webkit-border-radius: '.$img_cart_border_radius.'px; ', PHP_EOL; echo '-moz-border-radius: '.$img_cart_border_radius.'px; ', PHP_EOL; echo 'border-radius: '.$img_cart_border_radius.'px; ', PHP_EOL; } ?>

}
body.woocommerce-page .woocommerce table.shop_table.cart .product-thumbnail a:hover img.wp-post-image {
<?php if (isset($img_cart_border_color_hover) && $img_cart_border_color_hover!='') { echo 'border-color: '.$img_cart_border_color_hover.'; ', PHP_EOL; } ?>

}









body.woocommerce-page .woocommerce table.shop_table.cart {
<?php if (isset($table_cart_bg) && $table_cart_bg!='') { echo 'background: '.$table_cart_bg.'; ', PHP_EOL; } ?>

<?php if (isset($table_font_cart_font) && $table_font_cart_font!='') { echo 'font-family: '.$table_font_cart_font.'; ', PHP_EOL; } ?>
<?php if (isset($table_font_cart_color) && $table_font_cart_color!='') { echo 'color: '.$table_font_cart_color.'; ', PHP_EOL; } ?>
<?php if (isset($table_font_cart_font_size) && $table_font_cart_font_size!='') { echo 'font-size: '.$table_font_cart_font_size.'px; ', PHP_EOL; } ?>
<?php if (isset($table_font_cart_font_style) && $table_font_cart_font_style!='') { echo 'font-style: '.$table_font_cart_font_style.'; ', PHP_EOL; } ?>
<?php if (isset($table_font_cart_font_weight) && $table_font_cart_font_weight!='') { echo 'font-weight: '.$table_font_cart_font_weight.'; ', PHP_EOL; } ?>
<?php if (isset($table_font_cart_font_transform) && $table_font_cart_font_transform!='') { echo 'text-transform: '.$table_font_cart_font_transform.'; ', PHP_EOL; } ?>
<?php if (isset($table_font_cart_line_height) && $table_font_cart_line_height!='') { echo 'line-height: '.$table_font_cart_line_height.'px; '; } ?>
<?php if (isset($table_font_cart_letter_spacing) && $table_font_cart_letter_spacing!='') { echo 'letter-spacing: '.$table_font_cart_letter_spacing.'px; ', PHP_EOL; } ?>

<?php if (isset($table_cart_border_width) && $table_cart_border_width!='') { echo 'border-width: '.$table_cart_border_width.'px; ', PHP_EOL; } ?>
<?php if (isset($table_cart_border_color) && $table_cart_border_color!='') { echo 'border-color: '.$table_cart_border_color.'; ', PHP_EOL; } ?>
<?php if (isset($table_cart_border_style) && $table_cart_border_style!='') { echo 'border-style: '.$table_cart_border_style.'; ', PHP_EOL; } ?>
<?php if (isset($table_cart_border_radius) && $table_cart_border_radius!='') { echo '-webkit-border-radius: '.$table_cart_border_radius.'px; ', PHP_EOL; echo '-moz-border-radius: '.$table_cart_border_radius.'px; ', PHP_EOL; echo 'border-radius: '.$table_cart_border_radius.'px; ', PHP_EOL; } ?>
}
body.woocommerce-page .woocommerce table.shop_table.cart td, body.woocommerce-page .woocommerce table.shop_table.cart th {
<?php if (isset($table_cart_border_width) && $table_cart_border_width!='') { echo 'border-width: '.$table_cart_border_width.'px; ', PHP_EOL; } ?>
<?php if (isset($table_cart_border_color) && $table_cart_border_color!='') { echo 'border-color: '.$table_cart_border_color.'; ', PHP_EOL; } ?>
<?php if (isset($table_cart_border_style) && $table_cart_border_style!='') { echo 'border-style: '.$table_cart_border_style.'; ', PHP_EOL; } ?>
}
