<?php
        $wp_manager->add_section( 'pimpmywoo_cart_section', array(
            'title'          => 'WooCommerce Cart Page',
            'priority'       => 1,
		    'panel' => 'pimpmywoo_panel',
		    'description' => 'DESCRIPTION',
        ) );

			///  CART TABLE ///   
	        $wp_manager->add_setting( 'pimpmywoo_cart_section7', array(
	            'default'        => '',
	        ) );
	        $wp_manager->add_control( new Separator( $wp_manager, 'pimpmywoo_cart_section7', array(
	            'label'   => 'Cart Table Styling Settings',
	            'description'   => 'Use the the settings below to pimp your WooCommerce cart table.',
	            'section' => 'pimpmywoo_cart_section',
	            'priority' => 1
	        ) ) );
	        // TABLE BG Color
	        $wp_manager->add_setting( 'table_cart_bg', array(
	            'default'        => '',
		        'sanitize_callback' => 'sanitize_hex_color',
				'transport' => 'postMessage',
	        ) );
	        $wp_manager->add_control( new WP_Customize_Color_Control( $wp_manager, 'table_cart_bg', array(
	            'label'   => 'Table BG Color',
	            'section' => 'pimpmywoo_cart_section',
	            'priority' => 1
	        ) ) );
	        // TABLE Border Size
	        $wp_manager->add_setting( 'table_cart_border_width', array(
				'transport' => 'postMessage',
		        'sanitize_callback' => 'PimpMyWoo_sanitize_integer',
	            'default'        => '',
	        ) );
	        $wp_manager->add_control( 'table_cart_border_width', array(
	            'label'   => 'Table Border Width (px)',
	            'section' => 'pimpmywoo_cart_section',
	            'type'    => 'text',
	            'priority' => 1
	        ) );
	        // TABLE Border Color 
	        $wp_manager->add_setting( 'table_cart_border_color', array(
	            'default'        => '',
		        'sanitize_callback' => 'sanitize_hex_color',
				'transport' => 'postMessage',
	        ) );
	        $wp_manager->add_control( new WP_Customize_Color_Control( $wp_manager, 'table_cart_border_color', array(
	            'label'   => 'Table Border Color',
	            'section' => 'pimpmywoo_cart_section',
	            'priority' => 1
	        ) ) );
	        // TABLE Border Style
	        $wp_manager->add_setting( 'table_cart_border_style', array(
				'transport' => 'postMessage',
		        'sanitize_callback' => 'PimpMyWoo_sanitize_select',
	            'default'        => '',
	        ) );
	        $wp_manager->add_control( 'table_cart_border_style', array(
	            'label'   => 'Table Border Style',
	            'section' => 'pimpmywoo_cart_section',
	            'type'    => 'select',
	            'choices' => array("none" => "none", "hidden" => "hidden", "dotted" => "dotted", "dashed" => "dashed", "solid" => "solid", "double" => "double", "groove" => "groove", "ridge" => "ridge", "inset" => "inset", "outset" => "outset", "initial" => "initial", "inherit" => "inherit"),
	            'priority' => 1
	        ) );
	        // TABLE Border Radius
	        $wp_manager->add_setting( 'table_cart_border_radius', array(
				'transport' => 'postMessage',
		        'sanitize_callback' => 'PimpMyWoo_sanitize_integer',
	            'default'        => '',
	        ) );
	        $wp_manager->add_control( 'table_cart_border_radius', array(
	            'label'   => 'Table Border Radius (px)',
	            'section' => 'pimpmywoo_cart_section',
	            'type'    => 'text',
	            'priority' => 1
	        ) );
	        // TABLE Font Color
	        $wp_manager->add_setting( 'table_font_cart_color', array(
	            'default'        => '',
		        'sanitize_callback' => 'sanitize_hex_color',
				'transport' => 'postMessage',
	        ) );
	        $wp_manager->add_control( new WP_Customize_Color_Control( $wp_manager, 'table_font_cart_color', array(
	            'label'   => 'Table Font Color',
	            'section' => 'pimpmywoo_cart_section',
	            'priority' => 1
	        ) ) );
	        // TABLE Font Family
	        $wp_manager->add_setting( 'table_font_cart_font', array(
				'transport' => 'postMessage',
	            'default'        => '',
	        ) );
	        $wp_manager->add_control( new Google_Fonts( $wp_manager, 'table_font_cart_font', array(
	            'label'   => 'Table Font Font Family',
	            'section' => 'pimpmywoo_cart_section',
	            'priority' => 1
	        ) ) );								
	        // TABLE Font Character Sets
	        $wp_manager->add_setting( 'table_font_cart_font_latin', array('sanitize_callback' => 'PimpMyWoo_sanitize_checkbox','default' => '1','transport' => 'postMessage') );
	        $wp_manager->add_control( 'table_font_cart_font_latin', array('label'   => 'Load Latin','section' => 'pimpmywoo_cart_section','type' => 'checkbox','priority' => 1) );
	        $wp_manager->add_setting( 'table_font_cart_font_latinext', array('sanitize_callback' => 'PimpMyWoo_sanitize_checkbox','default' => '','transport' => 'postMessage') );
	        $wp_manager->add_control( 'table_font_cart_font_latinext', array('label'   => 'Load Latin Extended','section' => 'pimpmywoo_cart_section','type' => 'checkbox','priority' => 1) );
	        $wp_manager->add_setting( 'table_font_cart_font_greek', array('sanitize_callback' => 'PimpMyWoo_sanitize_checkbox','default' => '','transport' => 'postMessage') );
	        $wp_manager->add_control( 'table_font_cart_font_greek', array('label'   => 'Load Greek','section' => 'pimpmywoo_cart_section','type' => 'checkbox','priority' => 1) );
	        $wp_manager->add_setting( 'table_font_cart_font_greekext', array('sanitize_callback' => 'PimpMyWoo_sanitize_checkbox','default' => '','transport' => 'postMessage') );
	        $wp_manager->add_control( 'table_font_cart_font_greekext', array('label'   => 'Load Greek Extended','section' => 'pimpmywoo_cart_section','type' => 'checkbox','priority' => 1) );
	        $wp_manager->add_setting( 'table_font_cart_font_vietnamese', array('sanitize_callback' => 'PimpMyWoo_sanitize_checkbox','default' => '','transport' => 'postMessage') );
	        $wp_manager->add_control( 'table_font_cart_font_vietnamese', array('label'   => 'Load Vietnamese','section' => 'pimpmywoo_cart_section','type' => 'checkbox','priority' => 1) );
	        $wp_manager->add_setting( 'table_font_cart_font_cyrillic', array('sanitize_callback' => 'PimpMyWoo_sanitize_checkbox','default' => '','transport' => 'postMessage') );
	        $wp_manager->add_control( 'table_font_cart_font_cyrillic', array('label'   => 'Load Cyrillic','section' => 'pimpmywoo_cart_section','type' => 'checkbox','priority' => 1) );
	        $wp_manager->add_setting( 'table_font_cart_font_cyrillicext', array('sanitize_callback' => 'PimpMyWoo_sanitize_checkbox','default' => '','transport' => 'postMessage') );
	        $wp_manager->add_control( 'table_font_cart_font_cyrillicext', array('label'   => 'Load Cyrillic Extended','section' => 'pimpmywoo_cart_section','type' => 'checkbox','priority' => 1) );
	        // TABLE Font Size
	        $wp_manager->add_setting( 'table_font_cart_font_size', array(
				'transport' => 'postMessage',
		        'sanitize_callback' => 'PimpMyWoo_sanitize_integer',
	            'default'        => '',
	        ) );
	        $wp_manager->add_control( 'table_font_cart_font_size', array(
	            'label'   => 'Table Font Font Size (px)',
	            'section' => 'pimpmywoo_cart_section',
	            'type'    => 'text',
	            'priority' => 1
	        ) );
	        // TABLE Font Weight
	        $wp_manager->add_setting( 'table_font_cart_font_weight', array(
				'transport' => 'postMessage',
		        'sanitize_callback' => 'PimpMyWoo_sanitize_select',
	            'default'        => '',
	        ) );
	        $wp_manager->add_control( 'table_font_cart_font_weight', array(
	            'label'   => 'Table Font Font Weight',
	            'section' => 'pimpmywoo_cart_section',
	            'type'    => 'select',
	            'choices' => array("normal" => "normal", "bold" => "bold", "bolder" => "bolder", "lighter" => "lighter", "100" => "100", "200" => "200", "300" => "300", "400" => "400", "500" => "500", "600" => "600", "700" => "700", "800" => "800", "900" => "900", "initial" => "initial", "inherit" => "inherit"),
	            'priority' => 1
	        ) );
	        // TABLE Font Style
	        $wp_manager->add_setting( 'table_font_cart_font_style', array(
				'transport' => 'postMessage',
		        'sanitize_callback' => 'PimpMyWoo_sanitize_select',
	            'default'        => '',
	        ) );
	        $wp_manager->add_control( 'table_font_cart_font_style', array(
	            'label'   => 'Table Font Font Style',
	            'section' => 'pimpmywoo_cart_section',
	            'type'    => 'select',
	            'choices' => array("inherit" => "inherit", "normal" => "normal", "italic" => "italic", "oblique" => "oblique"),
	            'priority' => 1
	        ) );
	        // TABLE Font Transform
	        $wp_manager->add_setting( 'table_font_cart_text_transform', array(
				'transport' => 'postMessage',
		        'sanitize_callback' => 'PimpMyWoo_sanitize_select',
	            'default'        => '',
	        ) );
	        $wp_manager->add_control( 'table_font_cart_text_transform', array(
	            'label'   => 'Table Font Text Transform',
	            'section' => 'pimpmywoo_cart_section',
	            'type'    => 'select',
	            'choices' => array("none" => "none", "capitalize" => "capitalize", "uppercase" => "uppercase", "lowercase" => "lowercase", "initial" => "initial", "inherit" => "inherit"),
	            'priority' => 1
	        ) );
	        // TABLE Line Height
	        $wp_manager->add_setting( 'table_font_cart_line_height', array(
				'transport' => 'postMessage',
		        'sanitize_callback' => 'PimpMyWoo_sanitize_integer',
	            'default'        => '',
	        ) );
	        $wp_manager->add_control( 'table_font_cart_line_height', array(
	            'label'   => 'Table Font Line Height (px)',
	            'section' => 'pimpmywoo_cart_section',
	            'type'    => 'text',
	            'priority' => 1
	        ) );
	        // TABLE Letter Spacing
	        $wp_manager->add_setting( 'table_font_cart_letter_spacing', array(
				'transport' => 'postMessage',
		        'sanitize_callback' => 'PimpMyWoo_sanitize_integer',
	            'default'        => '',
	        ) );
	        $wp_manager->add_control( 'table_font_cart_letter_spacing', array(
	            'label'   => 'Table Font Letter Spacing (px)',
	            'section' => 'pimpmywoo_cart_section',
	            'type'    => 'text',
	            'priority' => 1
	        ) );


			///  Refresh BUTTON ///

	        $wp_manager->add_setting( 'pimpmywoo_cart_section1', array(
	            'default'        => '',
	        ) );
	        $wp_manager->add_control( new Separator( $wp_manager, 'pimpmywoo_cart_section1', array(
	            'label'   => 'Refresh Button Styling Settings',
	            'description'   => 'Use the the settings below to pimp your WooCommerce refresh button on the cart page.',
	            'section' => 'pimpmywoo_cart_section',
	            'priority' => 1
	        ) ) );
	        // Button BG Color
	        $wp_manager->add_setting( 'btn_cart_bg', array(
	            'default'        => '',
		        'sanitize_callback' => 'sanitize_hex_color',
				'transport' => 'postMessage',
	        ) );
	        $wp_manager->add_control( new WP_Customize_Color_Control( $wp_manager, 'btn_cart_bg', array(
	            'label'   => 'Refresh Button BG Color',
	            'section' => 'pimpmywoo_cart_section',
	            'settings'   => 'btn_cart_bg',
	            'priority' => 1
	        ) ) );
	        // Button BG Color on Hover
	        $wp_manager->add_setting( 'btn_cart_bg_hover', array(
	            'default'        => '',
		        'sanitize_callback' => 'sanitize_hex_color',
				'transport' => 'postMessage',
	        ) );
	        $wp_manager->add_control( new WP_Customize_Color_Control( $wp_manager, 'btn_cart_bg_hover', array(
	            'label'   => 'Refresh Button BG Color on Hover',
	            'section' => 'pimpmywoo_cart_section',
	            'settings'   => 'btn_cart_bg_hover',
	            'priority' => 1
	        ) ) );
	        // Button Font Color
	        $wp_manager->add_setting( 'btn_cart_color', array(
	            'default'        => '',
		        'sanitize_callback' => 'sanitize_hex_color',
				'transport' => 'postMessage',
	        ) );
	        $wp_manager->add_control( new WP_Customize_Color_Control( $wp_manager, 'btn_cart_color', array(
	            'label'   => 'Refresh Button Color',
	            'section' => 'pimpmywoo_cart_section',
	            'settings'   => 'btn_cart_color',
	            'priority' => 1
	        ) ) );
	        // Button Font Color on Hover
	        $wp_manager->add_setting( 'btn_cart_color_hover', array(
	            'default'        => '',
		        'sanitize_callback' => 'sanitize_hex_color',
				'transport' => 'postMessage',
	        ) );
	        $wp_manager->add_control( new WP_Customize_Color_Control( $wp_manager, 'btn_cart_color_hover', array(
	            'label'   => 'Refresh Button Color on Hover',
	            'section' => 'pimpmywoo_cart_section',
	            'settings'   => 'btn_cart_color_hover',
	            'priority' => 1
	        ) ) );
	        // Button Border Size
	        $wp_manager->add_setting( 'btn_cart_border_width', array(
				'transport' => 'postMessage',
		        'sanitize_callback' => 'PimpMyWoo_sanitize_integer',
	            'default'        => '',
	        ) );
	        $wp_manager->add_control( 'btn_cart_border_width', array(
	            'label'   => 'Refresh Button Border Width (px)',
	            'section' => 'pimpmywoo_cart_section',
	            'type'    => 'text',
	            'priority' => 1
	        ) );
	        // Button Border Color 
	        $wp_manager->add_setting( 'btn_cart_border_color', array(
	            'default'        => '',
		        'sanitize_callback' => 'sanitize_hex_color',
				'transport' => 'postMessage',
	        ) );
	        $wp_manager->add_control( new WP_Customize_Color_Control( $wp_manager, 'btn_cart_border_color', array(
	            'label'   => 'Refresh Button Border Color',
	            'section' => 'pimpmywoo_cart_section',
	            'settings'   => 'btn_cart_border_color',
	            'priority' => 1
	        ) ) );
	        // Button Border Color on Hover
	        $wp_manager->add_setting( 'btn_cart_border_color_hover', array(
	            'default'        => '',
		        'sanitize_callback' => 'sanitize_hex_color',
				'transport' => 'postMessage',
	        ) );
	        $wp_manager->add_control( new WP_Customize_Color_Control( $wp_manager, 'btn_cart_border_color_hover', array(
	            'label'   => 'Refresh Button Border Color on Hover',
	            'section' => 'pimpmywoo_cart_section',
	            'priority' => 1
	        ) ) );
	        // Button Border Style
	        $wp_manager->add_setting( 'btn_cart_border_style', array(		
				'transport' => 'postMessage',
		        'sanitize_callback' => 'PimpMyWoo_sanitize_select',
	            'default'        => '',
	        ) );
	        $wp_manager->add_control( 'btn_cart_border_style', array(
	            'label'   => 'Refresh Button Border Style',
	            'section' => 'pimpmywoo_cart_section',
	            'type'    => 'select',
	            'choices' => array("none" => "none", "hidden" => "hidden", "dotted" => "dotted", "dashed" => "dashed", "solid" => "solid", "double" => "double", "groove" => "groove", "ridge" => "ridge", "inset" => "inset", "outset" => "outset", "initial" => "initial", "inherit" => "inherit"),
	            'priority' => 1
	        ) );
	        // Button Border Radius
	        $wp_manager->add_setting( 'btn_cart_border_radius', array(
				'transport' => 'postMessage',
		        'sanitize_callback' => 'PimpMyWoo_sanitize_integer',
	            'default'        => '',
	        ) );
	        $wp_manager->add_control( 'btn_cart_border_radius', array(
	            'label'   => 'Refresh Button Border Radius (px)',
	            'section' => 'pimpmywoo_cart_section',
	            'type'    => 'text',
	            'priority' => 1
	        ) );
	        // Button Font Family
	        $wp_manager->add_setting( 'btn_cart_font', array(
				'transport' => 'postMessage',
	            'default'        => '',
	        ) );
	        $wp_manager->add_control( new Google_Fonts( $wp_manager, 'btn_cart_font', array(
	            'label'   => 'Refresh Button Font Family',
	            'section' => 'pimpmywoo_cart_section',
	            'settings'   => 'btn_cart_font',
	            'priority' => 1
	        ) ) );								
	        // Title Font Character Sets
	        $wp_manager->add_setting( 'btn_cart_font_latin', array('sanitize_callback' => 'PimpMyWoo_sanitize_checkbox','default' => '1','transport' => 'postMessage') );
	        $wp_manager->add_control( 'btn_cart_font_latin', array('label'   => 'Load Latin','section' => 'pimpmywoo_cart_section','type' => 'checkbox','priority' => 1) );
	        $wp_manager->add_setting( 'btn_cart_font_latinext', array('sanitize_callback' => 'PimpMyWoo_sanitize_checkbox','default' => '','transport' => 'postMessage') );
	        $wp_manager->add_control( 'btn_cart_font_latinext', array('label'   => 'Load Latin Extended','section' => 'pimpmywoo_cart_section','type' => 'checkbox','priority' => 1) );
	        $wp_manager->add_setting( 'btn_cart_font_greek', array('sanitize_callback' => 'PimpMyWoo_sanitize_checkbox','default' => '','transport' => 'postMessage') );
	        $wp_manager->add_control( 'btn_cart_font_greek', array('label'   => 'Load Greek','section' => 'pimpmywoo_cart_section','type' => 'checkbox','priority' => 1) );
	        $wp_manager->add_setting( 'btn_cart_font_greekext', array('sanitize_callback' => 'PimpMyWoo_sanitize_checkbox','default' => '','transport' => 'postMessage') );
	        $wp_manager->add_control( 'btn_cart_font_greekext', array('label'   => 'Load Greek Extended','section' => 'pimpmywoo_cart_section','type' => 'checkbox','priority' => 1) );
	        $wp_manager->add_setting( 'btn_cart_font_vietnamese', array('sanitize_callback' => 'PimpMyWoo_sanitize_checkbox','default' => '','transport' => 'postMessage') );
	        $wp_manager->add_control( 'btn_cart_font_vietnamese', array('label'   => 'Load Vietnamese','section' => 'pimpmywoo_cart_section','type' => 'checkbox','priority' => 1) );
	        $wp_manager->add_setting( 'btn_cart_font_cyrillic', array('sanitize_callback' => 'PimpMyWoo_sanitize_checkbox','default' => '','transport' => 'postMessage') );
	        $wp_manager->add_control( 'btn_cart_font_cyrillic', array('label'   => 'Load Cyrillic','section' => 'pimpmywoo_cart_section','type' => 'checkbox','priority' => 1) );
	        $wp_manager->add_setting( 'btn_cart_font_cyrillicext', array('sanitize_callback' => 'PimpMyWoo_sanitize_checkbox','default' => '','transport' => 'postMessage') );
	        $wp_manager->add_control( 'btn_cart_font_cyrillicext', array('label'   => 'Load Cyrillic Extended','section' => 'pimpmywoo_cart_section','type' => 'checkbox','priority' => 1) );
	        // Button Font Size
	        $wp_manager->add_setting( 'btn_cart_font_size', array(
				'transport' => 'postMessage',
		        'sanitize_callback' => 'PimpMyWoo_sanitize_integer',
	            'default'        => '',
	        ) );
	        $wp_manager->add_control( 'btn_cart_font_size', array(
	            'label'   => 'Refresh Button Font Size (px)',
	            'section' => 'pimpmywoo_cart_section',
	            'type'    => 'text',
	            'priority' => 1
	        ) );
	        // Button Font Weight
	        $wp_manager->add_setting( 'btn_cart_font_weight', array(
				'transport' => 'postMessage',
		        'sanitize_callback' => 'PimpMyWoo_sanitize_select',
	            'default'        => '',
	        ) );
	        $wp_manager->add_control( 'btn_cart_font_weight', array(
	            'label'   => 'Refresh Button Font Weight',
	            'section' => 'pimpmywoo_cart_section',
	            'type'    => 'select',
	            'choices' => array("normal" => "normal", "bold" => "bold", "bolder" => "bolder", "lighter" => "lighter", "100" => "100", "200" => "200", "300" => "300", "400" => "400", "500" => "500", "600" => "600", "700" => "700", "800" => "800", "900" => "900", "initial" => "initial", "inherit" => "inherit"),
	            'priority' => 1
	        ) );
	        // Button Font Style
	        $wp_manager->add_setting( 'btn_cart_font_style', array(
				'transport' => 'postMessage',
		        'sanitize_callback' => 'PimpMyWoo_sanitize_select',
	            'default'        => '',
	        ) );
	        $wp_manager->add_control( 'btn_cart_font_style', array(
	            'label'   => 'Refresh Button Font Style',
	            'section' => 'pimpmywoo_cart_section',
	            'type'    => 'select',
	            'choices' => array("inherit" => "inherit", "normal" => "normal", "italic" => "italic", "oblique" => "oblique"),
	            'priority' => 1
	        ) );
	        // Button Font Transform
	        $wp_manager->add_setting( 'btn_cart_text_transform', array(
				'transport' => 'postMessage',
		        'sanitize_callback' => 'PimpMyWoo_sanitize_select',
	            'default'        => '',
	        ) );
	        $wp_manager->add_control( 'btn_cart_text_transform', array(
	            'label'   => 'Refresh Button Text Transform',
	            'section' => 'pimpmywoo_cart_section',
	            'type'    => 'select',
	            'choices' => array("none" => "none", "capitalize" => "capitalize", "uppercase" => "uppercase", "lowercase" => "lowercase", "initial" => "initial", "inherit" => "inherit"),
	            'priority' => 1
	        ) );
	        // Button Line Height
	        $wp_manager->add_setting( 'btn_cart_line_height', array(
				'transport' => 'postMessage',
		        'sanitize_callback' => 'PimpMyWoo_sanitize_integer',
	            'default'        => '',
	        ) );
	        $wp_manager->add_control( 'btn_cart_line_height', array(
	            'label'   => 'Refresh Button Line Height (px)',
	            'section' => 'pimpmywoo_cart_section',
	            'type'    => 'text',
	            'priority' => 1
	        ) );
	        // Button Letter Spacing
	        $wp_manager->add_setting( 'btn_cart_letter_spacing', array(
				'transport' => 'postMessage',
		        'sanitize_callback' => 'PimpMyWoo_sanitize_integer',
	            'default'        => '',
	        ) );
	        $wp_manager->add_control( 'btn_cart_letter_spacing', array(
	            'label'   => 'Refresh Button Letter Spacing (px)',
	            'section' => 'pimpmywoo_cart_section',
	            'type'    => 'text',
	            'priority' => 1
	        ) );

			///  Coupon BUTTON ///

	        $wp_manager->add_setting( 'pimpmywoo_cart_section2', array(
	            'default'        => '',
	        ) );
	        $wp_manager->add_control( new Separator( $wp_manager, 'pimpmywoo_cart_section2', array(
	            'label'   => 'Coupon Button Styling Settings',
	            'description'   => 'Use the the settings below to pimp your WooCommerce button on the cart page.',
	            'section' => 'pimpmywoo_cart_section',
	            'priority' => 1
	        ) ) );
	        // Button BG Color
	        $wp_manager->add_setting( 'btnC_cart_bg', array(
	            'default'        => '',
		        'sanitize_callback' => 'sanitize_hex_color',
				'transport' => 'postMessage',
	        ) );
	        $wp_manager->add_control( new WP_Customize_Color_Control( $wp_manager, 'btnC_cart_bg', array(
	            'label'   => 'Coupon Button BG Color',
	            'section' => 'pimpmywoo_cart_section',
	            'settings'   => 'btnC_cart_bg',
	            'priority' => 1
	        ) ) );
	        // Button BG Color on Hover
	        $wp_manager->add_setting( 'btnC_cart_bg_hover', array(
	            'default'        => '',
		        'sanitize_callback' => 'sanitize_hex_color',
				'transport' => 'postMessage',
	        ) );
	        $wp_manager->add_control( new WP_Customize_Color_Control( $wp_manager, 'btnC_cart_bg_hover', array(
	            'label'   => 'Coupon Button BG Color on Hover',
	            'section' => 'pimpmywoo_cart_section',
	            'settings'   => 'btnC_cart_bg_hover',
	            'priority' => 1
	        ) ) );
	        // Button Font Color
	        $wp_manager->add_setting( 'btnC_cart_color', array(
	            'default'        => '',
		        'sanitize_callback' => 'sanitize_hex_color',
				'transport' => 'postMessage',
	        ) );
	        $wp_manager->add_control( new WP_Customize_Color_Control( $wp_manager, 'btnC_cart_color', array(
	            'label'   => 'Coupon Button Color',
	            'section' => 'pimpmywoo_cart_section',
	            'settings'   => 'btnC_cart_color',
	            'priority' => 1
	        ) ) );
	        // Button Font Color on Hover
	        $wp_manager->add_setting( 'btnC_cart_color_hover', array(
	            'default'        => '',
		        'sanitize_callback' => 'sanitize_hex_color',
				'transport' => 'postMessage',
	        ) );
	        $wp_manager->add_control( new WP_Customize_Color_Control( $wp_manager, 'btnC_cart_color_hover', array(
	            'label'   => 'Coupon Button Color on Hover',
	            'section' => 'pimpmywoo_cart_section',
	            'settings'   => 'btnC_cart_color_hover',
	            'priority' => 1
	        ) ) );
	        // Button Border Size
	        $wp_manager->add_setting( 'btnC_cart_border_width', array(
				'transport' => 'postMessage',
		        'sanitize_callback' => 'PimpMyWoo_sanitize_integer',
	            'default'        => '',
	        ) );
	        $wp_manager->add_control( 'btnC_cart_border_width', array(
	            'label'   => 'Coupon Button Border Width (px)',
	            'section' => 'pimpmywoo_cart_section',
	            'type'    => 'text',
	            'priority' => 1
	        ) );
	        // Button Border Color 
	        $wp_manager->add_setting( 'btnC_cart_border_color', array(
	            'default'        => '',
		        'sanitize_callback' => 'sanitize_hex_color',
				'transport' => 'postMessage',
	        ) );
	        $wp_manager->add_control( new WP_Customize_Color_Control( $wp_manager, 'btnC_cart_border_color', array(
	            'label'   => 'Coupon Button Border Color',
	            'section' => 'pimpmywoo_cart_section',
	            'settings'   => 'btnC_cart_border_color',
	            'priority' => 1
	        ) ) );
	        // Button Border Color on Hover
	        $wp_manager->add_setting( 'btnC_cart_border_color_hover', array(
	            'default'        => '',
		        'sanitize_callback' => 'sanitize_hex_color',
				'transport' => 'postMessage',
	        ) );
	        $wp_manager->add_control( new WP_Customize_Color_Control( $wp_manager, 'btnC_cart_border_color_hover', array(
	            'label'   => 'Coupon Button Border Color on Hover',
	            'section' => 'pimpmywoo_cart_section',
	            'priority' => 1
	        ) ) );
	        // Button Border Style
	        $wp_manager->add_setting( 'btnC_cart_border_style', array(		
				'transport' => 'postMessage',
		        'sanitize_callback' => 'PimpMyWoo_sanitize_select',
	            'default'        => '',
	        ) );
	        $wp_manager->add_control( 'btnC_cart_border_style', array(
	            'label'   => 'Coupon Button Border Style',
	            'section' => 'pimpmywoo_cart_section',
	            'type'    => 'select',
	            'choices' => array("none" => "none", "hidden" => "hidden", "dotted" => "dotted", "dashed" => "dashed", "solid" => "solid", "double" => "double", "groove" => "groove", "ridge" => "ridge", "inset" => "inset", "outset" => "outset", "initial" => "initial", "inherit" => "inherit"),
	            'priority' => 1
	        ) );
	        // Button Border Radius
	        $wp_manager->add_setting( 'btnC_cart_border_radius', array(
				'transport' => 'postMessage',
		        'sanitize_callback' => 'PimpMyWoo_sanitize_integer',
	            'default'        => '',
	        ) );
	        $wp_manager->add_control( 'btnC_cart_border_radius', array(
	            'label'   => 'Coupon Button Border Radius (px)',
	            'section' => 'pimpmywoo_cart_section',
	            'type'    => 'text',
	            'priority' => 1
	        ) );
	        // Button Font Family
	        $wp_manager->add_setting( 'btnC_cart_font', array(
				'transport' => 'postMessage',
	            'default'        => '',
	        ) );
	        $wp_manager->add_control( new Google_Fonts( $wp_manager, 'btnC_cart_font', array(
	            'label'   => 'Coupon Button Font Family',
	            'section' => 'pimpmywoo_cart_section',
	            'settings'   => 'btnC_cart_font',
	            'priority' => 1
	        ) ) );								
	        // Title Font Character Sets
	        $wp_manager->add_setting( 'btnC_cart_font_latin', array('sanitize_callback' => 'PimpMyWoo_sanitize_checkbox','default' => '1','transport' => 'postMessage') );
	        $wp_manager->add_control( 'btnC_cart_font_latin', array('label'   => 'Load Latin','section' => 'pimpmywoo_cart_section','type' => 'checkbox','priority' => 1) );
	        $wp_manager->add_setting( 'btnC_cart_font_latinext', array('sanitize_callback' => 'PimpMyWoo_sanitize_checkbox','default' => '','transport' => 'postMessage') );
	        $wp_manager->add_control( 'btnC_cart_font_latinext', array('label'   => 'Load Latin Extended','section' => 'pimpmywoo_cart_section','type' => 'checkbox','priority' => 1) );
	        $wp_manager->add_setting( 'btnC_cart_font_greek', array('sanitize_callback' => 'PimpMyWoo_sanitize_checkbox','default' => '','transport' => 'postMessage') );
	        $wp_manager->add_control( 'btnC_cart_font_greek', array('label'   => 'Load Greek','section' => 'pimpmywoo_cart_section','type' => 'checkbox','priority' => 1) );
	        $wp_manager->add_setting( 'btnC_cart_font_greekext', array('sanitize_callback' => 'PimpMyWoo_sanitize_checkbox','default' => '','transport' => 'postMessage') );
	        $wp_manager->add_control( 'btnC_cart_font_greekext', array('label'   => 'Load Greek Extended','section' => 'pimpmywoo_cart_section','type' => 'checkbox','priority' => 1) );
	        $wp_manager->add_setting( 'btnC_cart_font_vietnamese', array('sanitize_callback' => 'PimpMyWoo_sanitize_checkbox','default' => '','transport' => 'postMessage') );
	        $wp_manager->add_control( 'btnC_cart_font_vietnamese', array('label'   => 'Load Vietnamese','section' => 'pimpmywoo_cart_section','type' => 'checkbox','priority' => 1) );
	        $wp_manager->add_setting( 'btnC_cart_font_cyrillic', array('sanitize_callback' => 'PimpMyWoo_sanitize_checkbox','default' => '','transport' => 'postMessage') );
	        $wp_manager->add_control( 'btnC_cart_font_cyrillic', array('label'   => 'Load Cyrillic','section' => 'pimpmywoo_cart_section','type' => 'checkbox','priority' => 1) );
	        $wp_manager->add_setting( 'btnC_cart_font_cyrillicext', array('sanitize_callback' => 'PimpMyWoo_sanitize_checkbox','default' => '','transport' => 'postMessage') );
	        $wp_manager->add_control( 'btnC_cart_font_cyrillicext', array('label'   => 'Load Cyrillic Extended','section' => 'pimpmywoo_cart_section','type' => 'checkbox','priority' => 1) );
	        // Button Font Size
	        $wp_manager->add_setting( 'btnC_cart_font_size', array(
				'transport' => 'postMessage',
		        'sanitize_callback' => 'PimpMyWoo_sanitize_integer',
	            'default'        => '',
	        ) );
	        $wp_manager->add_control( 'btnC_cart_font_size', array(
	            'label'   => 'Coupon Button Font Size (px)',
	            'section' => 'pimpmywoo_cart_section',
	            'type'    => 'text',
	            'priority' => 1
	        ) );
	        // Button Font Weight
	        $wp_manager->add_setting( 'btnC_cart_font_weight', array(
				'transport' => 'postMessage',
		        'sanitize_callback' => 'PimpMyWoo_sanitize_select',
	            'default'        => '',
	        ) );
	        $wp_manager->add_control( 'btnC_cart_font_weight', array(
	            'label'   => 'Coupon Button Font Weight',
	            'section' => 'pimpmywoo_cart_section',
	            'type'    => 'select',
	            'choices' => array("normal" => "normal", "bold" => "bold", "bolder" => "bolder", "lighter" => "lighter", "100" => "100", "200" => "200", "300" => "300", "400" => "400", "500" => "500", "600" => "600", "700" => "700", "800" => "800", "900" => "900", "initial" => "initial", "inherit" => "inherit"),
	            'priority' => 1
	        ) );
	        // Button Font Style
	        $wp_manager->add_setting( 'btnC_cart_font_style', array(
				'transport' => 'postMessage',
		        'sanitize_callback' => 'PimpMyWoo_sanitize_select',
	            'default'        => '',
	        ) );
	        $wp_manager->add_control( 'btnC_cart_font_style', array(
	            'label'   => 'Coupon Button Font Style',
	            'section' => 'pimpmywoo_cart_section',
	            'type'    => 'select',
	            'choices' => array("inherit" => "inherit", "normal" => "normal", "italic" => "italic", "oblique" => "oblique"),
	            'priority' => 1
	        ) );
	        // Button Font Transform
	        $wp_manager->add_setting( 'btnC_cart_text_transform', array(
				'transport' => 'postMessage',
		        'sanitize_callback' => 'PimpMyWoo_sanitize_select',
	            'default'        => '',
	        ) );
	        $wp_manager->add_control( 'btnC_cart_text_transform', array(
	            'label'   => 'Coupon Button Text Transform',
	            'section' => 'pimpmywoo_cart_section',
	            'type'    => 'select',
	            'choices' => array("none" => "none", "capitalize" => "capitalize", "uppercase" => "uppercase", "lowercase" => "lowercase", "initial" => "initial", "inherit" => "inherit"),
	            'priority' => 1
	        ) );
	        // Button Line Height
	        $wp_manager->add_setting( 'btnC_cart_line_height', array(
				'transport' => 'postMessage',
		        'sanitize_callback' => 'PimpMyWoo_sanitize_integer',
	            'default'        => '',
	        ) );
	        $wp_manager->add_control( 'btnC_cart_line_height', array(
	            'label'   => 'Coupon Button Line Height (px)',
	            'section' => 'pimpmywoo_cart_section',
	            'type'    => 'text',
	            'priority' => 1
	        ) );
	        // Button Letter Spacing
	        $wp_manager->add_setting( 'btnC_cart_letter_spacing', array(
				'transport' => 'postMessage',
		        'sanitize_callback' => 'PimpMyWoo_sanitize_integer',
	            'default'        => '',
	        ) );
	        $wp_manager->add_control( 'btnC_cart_letter_spacing', array(
	            'label'   => 'Coupon Button Letter Spacing (px)',
	            'section' => 'pimpmywoo_cart_section',
	            'type'    => 'text',
	            'priority' => 1
	        ) );
			///  Checkout BUTTON ///

	        $wp_manager->add_setting( 'pimpmywoo_cart_section3', array(
	            'default'        => '',
	        ) );
	        $wp_manager->add_control( new Separator( $wp_manager, 'pimpmywoo_cart_section3', array(
	            'label'   => 'Checkout Button Styling Settings',
	            'description'   => 'Use the the settings below to pimp your WooCommerce button on the cart page.',
	            'section' => 'pimpmywoo_cart_section',
	            'priority' => 1
	        ) ) );
	        // Button BG Color
	        $wp_manager->add_setting( 'btnX_cart_bg', array(
	            'default'        => '',
		        'sanitize_callback' => 'sanitize_hex_color',
				'transport' => 'postMessage',
	        ) );
	        $wp_manager->add_control( new WP_Customize_Color_Control( $wp_manager, 'btnX_cart_bg', array(
	            'label'   => 'Checkout Button BG Color',
	            'section' => 'pimpmywoo_cart_section',
	            'settings'   => 'btnX_cart_bg',
	            'priority' => 1
	        ) ) );
	        // Button BG Color on Hover
	        $wp_manager->add_setting( 'btnX_cart_bg_hover', array(
	            'default'        => '',
		        'sanitize_callback' => 'sanitize_hex_color',
				'transport' => 'postMessage',
	        ) );
	        $wp_manager->add_control( new WP_Customize_Color_Control( $wp_manager, 'btnX_cart_bg_hover', array(
	            'label'   => 'Checkout Button BG Color on Hover',
	            'section' => 'pimpmywoo_cart_section',
	            'settings'   => 'btnX_cart_bg_hover',
	            'priority' => 1
	        ) ) );
	        // Button Font Color
	        $wp_manager->add_setting( 'btnX_cart_color', array(
	            'default'        => '',
		        'sanitize_callback' => 'sanitize_hex_color',
				'transport' => 'postMessage',
	        ) );
	        $wp_manager->add_control( new WP_Customize_Color_Control( $wp_manager, 'btnX_cart_color', array(
	            'label'   => 'Checkout Button Color',
	            'section' => 'pimpmywoo_cart_section',
	            'settings'   => 'btnX_cart_color',
	            'priority' => 1
	        ) ) );
	        // Button Font Color on Hover
	        $wp_manager->add_setting( 'btnX_cart_color_hover', array(
	            'default'        => '',
		        'sanitize_callback' => 'sanitize_hex_color',
				'transport' => 'postMessage',
	        ) );
	        $wp_manager->add_control( new WP_Customize_Color_Control( $wp_manager, 'btnX_cart_color_hover', array(
	            'label'   => 'Checkout Button Color on Hover',
	            'section' => 'pimpmywoo_cart_section',
	            'settings'   => 'btnX_cart_color_hover',
	            'priority' => 1
	        ) ) );
	        // Button Border Size
	        $wp_manager->add_setting( 'btnX_cart_border_width', array(
				'transport' => 'postMessage',
		        'sanitize_callback' => 'PimpMyWoo_sanitize_integer',
	            'default'        => '',
	        ) );
	        $wp_manager->add_control( 'btnX_cart_border_width', array(
	            'label'   => 'Checkout Button Border Width (px)',
	            'section' => 'pimpmywoo_cart_section',
	            'type'    => 'text',
	            'priority' => 1
	        ) );
	        // Button Border Color 
	        $wp_manager->add_setting( 'btnX_cart_border_color', array(
	            'default'        => '',
		        'sanitize_callback' => 'sanitize_hex_color',
				'transport' => 'postMessage',
	        ) );
	        $wp_manager->add_control( new WP_Customize_Color_Control( $wp_manager, 'btnX_cart_border_color', array(
	            'label'   => 'Checkout Button Border Color',
	            'section' => 'pimpmywoo_cart_section',
	            'settings'   => 'btnX_cart_border_color',
	            'priority' => 1
	        ) ) );
	        // Button Border Color on Hover
	        $wp_manager->add_setting( 'btnX_cart_border_color_hover', array(
	            'default'        => '',
		        'sanitize_callback' => 'sanitize_hex_color',
				'transport' => 'postMessage',
	        ) );
	        $wp_manager->add_control( new WP_Customize_Color_Control( $wp_manager, 'btnX_cart_border_color_hover', array(
	            'label'   => 'Checkout Button Border Color on Hover',
	            'section' => 'pimpmywoo_cart_section',
	            'priority' => 1
	        ) ) );
	        // Button Border Style
	        $wp_manager->add_setting( 'btnX_cart_border_style', array(		
				'transport' => 'postMessage',
		        'sanitize_callback' => 'PimpMyWoo_sanitize_select',
	            'default'        => '',
	        ) );
	        $wp_manager->add_control( 'btnX_cart_border_style', array(
	            'label'   => 'Checkout Button Border Style',
	            'section' => 'pimpmywoo_cart_section',
	            'type'    => 'select',
	            'choices' => array("none" => "none", "hidden" => "hidden", "dotted" => "dotted", "dashed" => "dashed", "solid" => "solid", "double" => "double", "groove" => "groove", "ridge" => "ridge", "inset" => "inset", "outset" => "outset", "initial" => "initial", "inherit" => "inherit"),
	            'priority' => 1
	        ) );
	        // Button Border Radius
	        $wp_manager->add_setting( 'btnX_cart_border_radius', array(
				'transport' => 'postMessage',
		        'sanitize_callback' => 'PimpMyWoo_sanitize_integer',
	            'default'        => '',
	        ) );
	        $wp_manager->add_control( 'btnX_cart_border_radius', array(
	            'label'   => 'Checkout Button Border Radius (px)',
	            'section' => 'pimpmywoo_cart_section',
	            'type'    => 'text',
	            'priority' => 1
	        ) );
	        // Button Font Family
	        $wp_manager->add_setting( 'btnX_cart_font', array(
				'transport' => 'postMessage',
	            'default'        => '',
	        ) );
	        $wp_manager->add_control( new Google_Fonts( $wp_manager, 'btnX_cart_font', array(
	            'label'   => 'Checkout Button Font Family',
	            'section' => 'pimpmywoo_cart_section',
	            'settings'   => 'btnX_cart_font',
	            'priority' => 1
	        ) ) );								
	        // Title Font Character Sets
	        $wp_manager->add_setting( 'btnX_cart_font_latin', array('sanitize_callback' => 'PimpMyWoo_sanitize_checkbox','default' => '1','transport' => 'postMessage') );
	        $wp_manager->add_control( 'btnX_cart_font_latin', array('label'   => 'Load Latin','section' => 'pimpmywoo_cart_section','type' => 'checkbox','priority' => 1) );
	        $wp_manager->add_setting( 'btnX_cart_font_latinext', array('sanitize_callback' => 'PimpMyWoo_sanitize_checkbox','default' => '','transport' => 'postMessage') );
	        $wp_manager->add_control( 'btnX_cart_font_latinext', array('label'   => 'Load Latin Extended','section' => 'pimpmywoo_cart_section','type' => 'checkbox','priority' => 1) );
	        $wp_manager->add_setting( 'btnX_cart_font_greek', array('sanitize_callback' => 'PimpMyWoo_sanitize_checkbox','default' => '','transport' => 'postMessage') );
	        $wp_manager->add_control( 'btnX_cart_font_greek', array('label'   => 'Load Greek','section' => 'pimpmywoo_cart_section','type' => 'checkbox','priority' => 1) );
	        $wp_manager->add_setting( 'btnX_cart_font_greekext', array('sanitize_callback' => 'PimpMyWoo_sanitize_checkbox','default' => '','transport' => 'postMessage') );
	        $wp_manager->add_control( 'btnX_cart_font_greekext', array('label'   => 'Load Greek Extended','section' => 'pimpmywoo_cart_section','type' => 'checkbox','priority' => 1) );
	        $wp_manager->add_setting( 'btnX_cart_font_vietnamese', array('sanitize_callback' => 'PimpMyWoo_sanitize_checkbox','default' => '','transport' => 'postMessage') );
	        $wp_manager->add_control( 'btnX_cart_font_vietnamese', array('label'   => 'Load Vietnamese','section' => 'pimpmywoo_cart_section','type' => 'checkbox','priority' => 1) );
	        $wp_manager->add_setting( 'btnX_cart_font_cyrillic', array('sanitize_callback' => 'PimpMyWoo_sanitize_checkbox','default' => '','transport' => 'postMessage') );
	        $wp_manager->add_control( 'btnX_cart_font_cyrillic', array('label'   => 'Load Cyrillic','section' => 'pimpmywoo_cart_section','type' => 'checkbox','priority' => 1) );
	        $wp_manager->add_setting( 'btnX_cart_font_cyrillicext', array('sanitize_callback' => 'PimpMyWoo_sanitize_checkbox','default' => '','transport' => 'postMessage') );
	        $wp_manager->add_control( 'btnX_cart_font_cyrillicext', array('label'   => 'Load Cyrillic Extended','section' => 'pimpmywoo_cart_section','type' => 'checkbox','priority' => 1) );
	        // Button Font Size
	        $wp_manager->add_setting( 'btnX_cart_font_size', array(
				'transport' => 'postMessage',
		        'sanitize_callback' => 'PimpMyWoo_sanitize_integer',
	            'default'        => '',
	        ) );
	        $wp_manager->add_control( 'btnX_cart_font_size', array(
	            'label'   => 'Checkout Button Font Size (px)',
	            'section' => 'pimpmywoo_cart_section',
	            'type'    => 'text',
	            'priority' => 1
	        ) );
	        // Button Font Weight
	        $wp_manager->add_setting( 'btnX_cart_font_weight', array(
				'transport' => 'postMessage',
		        'sanitize_callback' => 'PimpMyWoo_sanitize_select',
	            'default'        => '',
	        ) );
	        $wp_manager->add_control( 'btnX_cart_font_weight', array(
	            'label'   => 'Checkout Button Font Weight',
	            'section' => 'pimpmywoo_cart_section',
	            'type'    => 'select',
	            'choices' => array("normal" => "normal", "bold" => "bold", "bolder" => "bolder", "lighter" => "lighter", "100" => "100", "200" => "200", "300" => "300", "400" => "400", "500" => "500", "600" => "600", "700" => "700", "800" => "800", "900" => "900", "initial" => "initial", "inherit" => "inherit"),
	            'priority' => 1
	        ) );
	        // Button Font Style
	        $wp_manager->add_setting( 'btnX_cart_font_style', array(
				'transport' => 'postMessage',
		        'sanitize_callback' => 'PimpMyWoo_sanitize_select',
	            'default'        => '',
	        ) );
	        $wp_manager->add_control( 'btnX_cart_font_style', array(
	            'label'   => 'Checkout Button Font Style',
	            'section' => 'pimpmywoo_cart_section',
	            'type'    => 'select',
	            'choices' => array("inherit" => "inherit", "normal" => "normal", "italic" => "italic", "oblique" => "oblique"),
	            'priority' => 1
	        ) );
	        // Button Font Transform
	        $wp_manager->add_setting( 'btnX_cart_text_transform', array(
				'transport' => 'postMessage',
		        'sanitize_callback' => 'PimpMyWoo_sanitize_select',
	            'default'        => '',
	        ) );
	        $wp_manager->add_control( 'btnX_cart_text_transform', array(
	            'label'   => 'Checkout Button Text Transform',
	            'section' => 'pimpmywoo_cart_section',
	            'type'    => 'select',
	            'choices' => array("none" => "none", "capitalize" => "capitalize", "uppercase" => "uppercase", "lowercase" => "lowercase", "initial" => "initial", "inherit" => "inherit"),
	            'priority' => 1
	        ) );
	        // Button Line Height
	        $wp_manager->add_setting( 'btnX_cart_line_height', array(
				'transport' => 'postMessage',
		        'sanitize_callback' => 'PimpMyWoo_sanitize_integer',
	            'default'        => '',
	        ) );
	        $wp_manager->add_control( 'btnX_cart_line_height', array(
	            'label'   => 'Checkout Button Line Height (px)',
	            'section' => 'pimpmywoo_cart_section',
	            'type'    => 'text',
	            'priority' => 1
	        ) );
	        // Button Letter Spacing
	        $wp_manager->add_setting( 'btnX_cart_letter_spacing', array(
				'transport' => 'postMessage',
		        'sanitize_callback' => 'PimpMyWoo_sanitize_integer',
	            'default'        => '',
	        ) );
	        $wp_manager->add_control( 'btnX_cart_letter_spacing', array(
	            'label'   => 'Checkout Button Letter Spacing (px)',
	            'section' => 'pimpmywoo_cart_section',
	            'type'    => 'text',
	            'priority' => 1
	        ) );

			///  PRODUCT TITLE ///   

	        $wp_manager->add_setting( 'pimpmywoo_cart_section4', array(
	            'default'        => '',
	        ) );
	        $wp_manager->add_control( new Separator( $wp_manager, 'pimpmywoo_cart_section4', array(
	            'label'   => 'Product Title Styling Settings',
	            'description'   => 'Use the the settings below to pimp your WooCommerce product titles on the cart page.',
	            'section' => 'pimpmywoo_cart_section',
	            'priority' => 1
	        ) ) );
	        // Title Font Family
	        $wp_manager->add_setting( 'title_cart_font', array(
				'transport' => 'postMessage',
	            'default'        => '',
	        ) );
	        $wp_manager->add_control( new Google_Fonts( $wp_manager, 'title_cart_font', array(
	            'label'   => 'Title Font Family',
	            'section' => 'pimpmywoo_cart_section',
	            'settings'   => 'title_cart_font',
	            'priority' => 1
	        ) ) );
	        // Title Font Character Sets
	        $wp_manager->add_setting( 'title_cart_font_latin', array('sanitize_callback' => 'PimpMyWoo_sanitize_checkbox','default' => '1','transport' => 'postMessage') );
	        $wp_manager->add_control( 'title_cart_font_latin', array('label'   => 'Load Latin','section' => 'pimpmywoo_cart_section','type' => 'checkbox','priority' => 1) );
	        $wp_manager->add_setting( 'title_cart_font_latinext', array('sanitize_callback' => 'PimpMyWoo_sanitize_checkbox','default' => '','transport' => 'postMessage') );
	        $wp_manager->add_control( 'title_cart_font_latinext', array('label'   => 'Load Latin Extended','section' => 'pimpmywoo_cart_section','type' => 'checkbox','priority' => 1) );
	        $wp_manager->add_setting( 'title_cart_font_greek', array('sanitize_callback' => 'PimpMyWoo_sanitize_checkbox','default' => '','transport' => 'postMessage') );
	        $wp_manager->add_control( 'title_cart_font_greek', array('label'   => 'Load Greek','section' => 'pimpmywoo_cart_section','type' => 'checkbox','priority' => 1) );
	        $wp_manager->add_setting( 'title_cart_font_greekext', array('sanitize_callback' => 'PimpMyWoo_sanitize_checkbox','default' => '','transport' => 'postMessage') );
	        $wp_manager->add_control( 'title_cart_font_greekext', array('label'   => 'Load Greek Extended','section' => 'pimpmywoo_cart_section','type' => 'checkbox','priority' => 1) );
	        $wp_manager->add_setting( 'title_cart_font_vietnamese', array('sanitize_callback' => 'PimpMyWoo_sanitize_checkbox','default' => '','transport' => 'postMessage') );
	        $wp_manager->add_control( 'title_cart_font_vietnamese', array('label'   => 'Load Vietnamese','section' => 'pimpmywoo_cart_section','type' => 'checkbox','priority' => 1) );
	        $wp_manager->add_setting( 'title_cart_font_cyrillic', array('sanitize_callback' => 'PimpMyWoo_sanitize_checkbox','default' => '','transport' => 'postMessage') );
	        $wp_manager->add_control( 'title_cart_font_cyrillic', array('label'   => 'Load Cyrillic','section' => 'pimpmywoo_cart_section','type' => 'checkbox','priority' => 1) );
	        $wp_manager->add_setting( 'title_cart_font_cyrillicext', array('sanitize_callback' => 'PimpMyWoo_sanitize_checkbox','default' => '','transport' => 'postMessage') );
	        $wp_manager->add_control( 'title_cart_font_cyrillicext', array('label'   => 'Load Cyrillic Extended','section' => 'pimpmywoo_cart_section','type' => 'checkbox','priority' => 1) );
	        // Title Font Color
	        $wp_manager->add_setting( 'title_cart_color', array(
	            'default'        => '',
		        'sanitize_callback' => 'sanitize_hex_color',
				'transport' => 'postMessage',
	        ) );
	        $wp_manager->add_control( new WP_Customize_Color_Control( $wp_manager, 'title_cart_color', array(
	            'label'   => 'Title Font Color',
	            'section' => 'pimpmywoo_cart_section',
	            'settings'   => 'title_cart_color',
	            'priority' => 1
	        ) ) );
	        // Title Font Color on Hover
	        $wp_manager->add_setting( 'title_cart_color_hover', array(
	            'default'        => '',
		        'sanitize_callback' => 'sanitize_hex_color',
				'transport' => 'postMessage',
	        ) );
	        $wp_manager->add_control( new WP_Customize_Color_Control( $wp_manager, 'title_cart_color_hover', array(
	            'label'   => 'Title Font Color on Hover',
	            'section' => 'pimpmywoo_cart_section',
	            'settings'   => 'title_cart_color_hover',
	            'priority' => 1
	        ) ) );
	        // Title Font Size
	        $wp_manager->add_setting( 'title_cart_font_size', array(
				'transport' => 'postMessage',
		        'sanitize_callback' => 'PimpMyWoo_sanitize_integer',
	            'default'        => '',
	        ) );
	        $wp_manager->add_control( 'title_cart_font_size', array(
	            'label'   => 'Title Font Size (px)',
	            'section' => 'pimpmywoo_cart_section',
	            'type'    => 'text',
	            'priority' => 1
	        ) );
	        // Title Font Weight
	        $wp_manager->add_setting( 'title_cart_font_weight', array(
				'transport' => 'postMessage',
		        'sanitize_callback' => 'PimpMyWoo_sanitize_select',
	            'default'        => '',
	        ) );
	        $wp_manager->add_control( 'title_cart_font_weight', array(
	            'label'   => 'Title Font Weight',
	            'section' => 'pimpmywoo_cart_section',
	            'type'    => 'select',
	            'choices' => array("normal" => "normal", "bold" => "bold", "bolder" => "bolder", "lighter" => "lighter", "100" => "100", "200" => "200", "300" => "300", "400" => "400", "500" => "500", "600" => "600", "700" => "700", "800" => "800", "900" => "900", "initial" => "initial", "inherit" => "inherit"),
	            'priority' => 1
	        ) );
	        // Title Font Style
	        $wp_manager->add_setting( 'title_cart_font_style', array(
				'transport' => 'postMessage',
		        'sanitize_callback' => 'PimpMyWoo_sanitize_select',
	            'default'        => '',
	        ) );
	        $wp_manager->add_control( 'title_cart_font_style', array(
	            'label'   => 'Title Font Style',
	            'section' => 'pimpmywoo_cart_section',
	            'type'    => 'select',
	            'choices' => array("inherit" => "inherit", "normal" => "normal", "italic" => "italic", "oblique" => "oblique"),
	            'priority' => 1
	        ) );
	        // Title Font Transform
	        $wp_manager->add_setting( 'title_cart_text_transform', array(
				'transport' => 'postMessage',
		        'sanitize_callback' => 'PimpMyWoo_sanitize_select',
	            'default'        => '',
	        ) );
	        $wp_manager->add_control( 'title_cart_text_transform', array(
	            'label'   => 'Title Text Transform',
	            'section' => 'pimpmywoo_cart_section',
	            'type'    => 'select',
	            'choices' => array("none" => "none", "capitalize" => "capitalize", "uppercase" => "uppercase", "lowercase" => "lowercase", "initial" => "initial", "inherit" => "inherit"),
	            'priority' => 1
	        ) );
	        // Title Line Height
	        $wp_manager->add_setting( 'title_cart_line_height', array(
				'transport' => 'postMessage',
		        'sanitize_callback' => 'PimpMyWoo_sanitize_integer',
	            'default'        => '',
	        ) );
	        $wp_manager->add_control( 'title_cart_line_height', array(
	            'label'   => 'Title Line Height (px)',
	            'section' => 'pimpmywoo_cart_section',
	            'type'    => 'text',
	            'priority' => 1
	        ) );
	        // Title Letter Spacing
	        $wp_manager->add_setting( 'title_cart_letter_spacing', array(
				'transport' => 'postMessage',
		        'sanitize_callback' => 'PimpMyWoo_sanitize_integer',
	            'default'        => '',
	        ) );
	        $wp_manager->add_control( 'title_cart_letter_spacing', array(
	            'label'   => 'Title Letter Spacing (px)',
	            'section' => 'pimpmywoo_cart_section',
	            'type'    => 'text',
	            'priority' => 1
	        ) );
			
			///  PRODUCT PRICE(S) ///   

	        $wp_manager->add_setting( 'pimpmywoo_cart_section5', array(
	            'default'        => '',
	        ) );
	        $wp_manager->add_control( new Separator( $wp_manager, 'pimpmywoo_cart_section5', array(
	            'label'   => 'Product Price(s) and Quantity Styling Settings',
	            'description'   => 'Use the the settings below to pimp your WooCommerce product price(s) on the cart page.',
	            'section' => 'pimpmywoo_cart_section',
	            'priority' => 1
	        ) ) );
	        // Price Font Family
	        $wp_manager->add_setting( 'price_cart_font', array(
				'transport' => 'postMessage',
	            'default'        => '',
	        ) );
	        $wp_manager->add_control( new Google_Fonts( $wp_manager, 'price_cart_font', array(
	            'label'   => 'Price & Qty Font Family',
	            'section' => 'pimpmywoo_cart_section',
	            'settings'   => 'price_cart_font',
	            'priority' => 1
	        ) ) );
	        // Price Font Character Sets
	        $wp_manager->add_setting( 'price_cart_font_latin', array('sanitize_callback' => 'PimpMyWoo_sanitize_checkbox','default' => '1','transport' => 'postMessage') );
	        $wp_manager->add_control( 'price_cart_font_latin', array('label'   => 'Load Latin','section' => 'pimpmywoo_cart_section','type' => 'checkbox','priority' => 1) );
	        $wp_manager->add_setting( 'price_cart_font_latinext', array('sanitize_callback' => 'PimpMyWoo_sanitize_checkbox','default' => '','transport' => 'postMessage') );
	        $wp_manager->add_control( 'price_cart_font_latinext', array('label'   => 'Load Latin Extended','section' => 'pimpmywoo_cart_section','type' => 'checkbox','priority' => 1) );
	        $wp_manager->add_setting( 'price_cart_font_greek', array('sanitize_callback' => 'PimpMyWoo_sanitize_checkbox','default' => '','transport' => 'postMessage') );
	        $wp_manager->add_control( 'price_cart_font_greek', array('label'   => 'Load Greek','section' => 'pimpmywoo_cart_section','type' => 'checkbox','priority' => 1) );
	        $wp_manager->add_setting( 'price_cart_font_greekext', array('sanitize_callback' => 'PimpMyWoo_sanitize_checkbox','default' => '','transport' => 'postMessage') );
	        $wp_manager->add_control( 'price_cart_font_greekext', array('label'   => 'Load Greek Extended','section' => 'pimpmywoo_cart_section','type' => 'checkbox','priority' => 1) );
	        $wp_manager->add_setting( 'price_cart_font_vietnamese', array('sanitize_callback' => 'PimpMyWoo_sanitize_checkbox','default' => '','transport' => 'postMessage') );
	        $wp_manager->add_control( 'price_cart_font_vietnamese', array('label'   => 'Load Vietnamese','section' => 'pimpmywoo_cart_section','type' => 'checkbox','priority' => 1) );
	        $wp_manager->add_setting( 'price_cart_font_cyrillic', array('sanitize_callback' => 'PimpMyWoo_sanitize_checkbox','default' => '','transport' => 'postMessage') );
	        $wp_manager->add_control( 'price_cart_font_cyrillic', array('label'   => 'Load Cyrillic','section' => 'pimpmywoo_cart_section','type' => 'checkbox','priority' => 1) );
	        $wp_manager->add_setting( 'price_cart_font_cyrillicext', array('sanitize_callback' => 'PimpMyWoo_sanitize_checkbox','default' => '','transport' => 'postMessage') );
	        $wp_manager->add_control( 'price_cart_font_cyrillicext', array('label'   => 'Load Cyrillic Extended','section' => 'pimpmywoo_cart_section','type' => 'checkbox','priority' => 1) );
	        // Price Font Color
	        $wp_manager->add_setting( 'price_cart_color', array(
	            'default'        => '',
		        'sanitize_callback' => 'sanitize_hex_color',
				'transport' => 'postMessage',
	        ) );
	        $wp_manager->add_control( new WP_Customize_Color_Control( $wp_manager, 'price_cart_color', array(
	            'label'   => 'Price & Qty Font Color',
	            'section' => 'pimpmywoo_cart_section',
	            'settings'   => 'price_cart_color',
	            'priority' => 1
	        ) ) );
	        // Price Font Size
	        $wp_manager->add_setting( 'price_cart_font_size', array(
				'transport' => 'postMessage',
		        'sanitize_callback' => 'PimpMyWoo_sanitize_integer',
	            'default'        => '',
	        ) );
	        $wp_manager->add_control( 'price_cart_font_size', array(
	            'label'   => 'Price & Qty Font Size (px)',
	            'section' => 'pimpmywoo_cart_section',
	            'type'    => 'text',
	            'priority' => 1
	        ) );
	        // Price Font Weight
	        $wp_manager->add_setting( 'price_cart_font_weight', array(
				'transport' => 'postMessage',
		        'sanitize_callback' => 'PimpMyWoo_sanitize_select',
	            'default'        => '',
	        ) );
	        $wp_manager->add_control( 'price_cart_font_weight', array(
	            'label'   => 'Price & Qty Font Weight',
	            'section' => 'pimpmywoo_cart_section',
	            'type'    => 'select',
	            'choices' => array("normal" => "normal", "bold" => "bold", "bolder" => "bolder", "lighter" => "lighter", "100" => "100", "200" => "200", "300" => "300", "400" => "400", "500" => "500", "600" => "600", "700" => "700", "800" => "800", "900" => "900", "initial" => "initial", "inherit" => "inherit"),
	            'priority' => 1
	        ) );
	        // Price Font Style
	        $wp_manager->add_setting( 'price_cart_font_style', array(
				'transport' => 'postMessage',
		        'sanitize_callback' => 'PimpMyWoo_sanitize_select',
	            'default'        => '',
	        ) );
	        $wp_manager->add_control( 'price_cart_font_style', array(
	            'label'   => 'Price & Qty Font Style',
	            'section' => 'pimpmywoo_cart_section',
	            'type'    => 'select',
	            'choices' => array("inherit" => "inherit", "normal" => "normal", "italic" => "italic", "oblique" => "oblique"),
	            'priority' => 1
	        ) );
	        // Price Font Transform
	        $wp_manager->add_setting( 'price_cart_text_transform', array(
				'transport' => 'postMessage',
		        'sanitize_callback' => 'PimpMyWoo_sanitize_select',
	            'default'        => '',
	        ) );
	        $wp_manager->add_control( 'price_cart_text_transform', array(
	            'label'   => 'Price & Qty Text Transform',
	            'section' => 'pimpmywoo_cart_section',
	            'type'    => 'select',
	            'choices' => array("none" => "none", "capitalize" => "capitalize", "uppercase" => "uppercase", "lowercase" => "lowercase", "initial" => "initial", "inherit" => "inherit"),
	            'priority' => 1
	        ) );
	        // Price Line Height
	        $wp_manager->add_setting( 'price_cart_line_height', array(
				'transport' => 'postMessage',
		        'sanitize_callback' => 'PimpMyWoo_sanitize_integer',
	            'default'        => '',
	        ) );
	        $wp_manager->add_control( 'price_cart_line_height', array(
	            'label'   => 'Price & Qty Line Height (px)',
	            'section' => 'pimpmywoo_cart_section',
	            'type'    => 'text',
	            'priority' => 1
	        ) );
	        // Price Letter Spacing
	        $wp_manager->add_setting( 'price_cart_letter_spacing', array(
				'transport' => 'postMessage',
		        'sanitize_callback' => 'PimpMyWoo_sanitize_integer',
	            'default'        => '',
	        ) );
	        $wp_manager->add_control( 'price_cart_letter_spacing', array(
	            'label'   => 'Price & Qty Letter Spacing (px)',
	            'section' => 'pimpmywoo_cart_section',
	            'type'    => 'text',
	            'priority' => 1
	        ) );


			///  PRODUCT FEATURED IMAGE ///   

	        $wp_manager->add_setting( 'pimpmywoo_cart_section6', array(
	            'default'        => '',
	        ) );
	        $wp_manager->add_control( new Separator( $wp_manager, 'pimpmywoo_cart_section6', array(
	            'label'   => 'Image Image Styling Settings',
	            'description'   => 'Use the the settings below to pimp your WooCommerce product featured image on the cart page.',
	            'section' => 'pimpmywoo_cart_section',
	            'priority' => 1
	        ) ) );
	        // Image Border Size
	        $wp_manager->add_setting( 'img_cart_border_width', array(
				'transport' => 'postMessage',
		        'sanitize_callback' => 'PimpMyWoo_sanitize_integer',
	            'default'        => '',
	        ) );
	        $wp_manager->add_control( 'img_cart_border_width', array(
	            'label'   => 'Image Border Width (px)',
	            'section' => 'pimpmywoo_cart_section',
	            'type'    => 'text',
	            'priority' => 1
	        ) );
	        // Image Border Color 
	        $wp_manager->add_setting( 'img_cart_border_color', array(
	            'default'        => '',
		        'sanitize_callback' => 'sanitize_hex_color',
				'transport' => 'postMessage',
	        ) );
	        $wp_manager->add_control( new WP_Customize_Color_Control( $wp_manager, 'img_cart_border_color', array(
	            'label'   => 'Image Border Color',
	            'section' => 'pimpmywoo_cart_section',
	            'priority' => 1
	        ) ) );
	        // Image Border Color on Hover
	        $wp_manager->add_setting( 'img_cart_border_color_hover', array(
	            'default'        => '',
		        'sanitize_callback' => 'sanitize_hex_color',
				'transport' => 'postMessage',
	        ) );
	        $wp_manager->add_control( new WP_Customize_Color_Control( $wp_manager, 'img_cart_border_color_hover', array(
	            'label'   => 'Image Border Color on Hover',
	            'section' => 'pimpmywoo_cart_section',
	            'priority' => 1
	        ) ) );
	        // Image Border Style
	        $wp_manager->add_setting( 'img_cart_border_style', array(
				'transport' => 'postMessage',
		        'sanitize_callback' => 'PimpMyWoo_sanitize_select',
	            'default'        => '',
	        ) );
	        $wp_manager->add_control( 'img_cart_border_style', array(
	            'label'   => 'Image Border Style',
	            'section' => 'pimpmywoo_cart_section',
	            'type'    => 'select',
	            'choices' => array("none" => "none", "hidden" => "hidden", "dotted" => "dotted", "dashed" => "dashed", "solid" => "solid", "double" => "double", "groove" => "groove", "ridge" => "ridge", "inset" => "inset", "outset" => "outset", "initial" => "initial", "inherit" => "inherit"),
	            'priority' => 1
	        ) );
	        // Image Border Radius
	        $wp_manager->add_setting( 'img_cart_border_radius', array(
				'transport' => 'postMessage',
		        'sanitize_callback' => 'PimpMyWoo_sanitize_integer',
	            'default'        => '',
	        ) );
	        $wp_manager->add_control( 'img_cart_border_radius', array(
	            'label'   => 'Image Border Radius (px)',
	            'section' => 'pimpmywoo_cart_section',
	            'type'    => 'text',
	            'priority' => 1
	        ) );
	        
	        
	        
	        
	        	        
	        
			if ( $wp_manager->is_preview() ) {
			    add_action( 'wp_footer', 'pimpmywoo_preview_archive', 21);
			}	
?>