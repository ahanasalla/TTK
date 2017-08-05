<?php
        $wp_manager->add_section( 'pimpmywoo_single_section', array(
            'title'          => 'WooCommerce Product Page',
            'priority'       => 1,
		    'panel' => 'pimpmywoo_panel',
		    'description' => 'DESCRIPTION',
        ) );

			///  PRODUCT BUTTON ///

	        $wp_manager->add_setting( 'pimpmywoo_single_section1', array(
	            'default'        => '',
	        ) );
	        $wp_manager->add_control( new Separator( $wp_manager, 'pimpmywoo_single_section1', array(
	            'label'   => 'Button Styling Settings',
	            'description'   => 'Use the the settings below to pimp your WooCommerce button on product page.',
	            'section' => 'pimpmywoo_single_section',
	            'priority' => 1
	        ) ) );
	        // Button BG Color
	        $wp_manager->add_setting( 'btn_single_bg', array(
	            'default'        => '',
		        'sanitize_callback' => 'sanitize_hex_color',
				'transport' => 'postMessage',
	        ) );
	        $wp_manager->add_control( new WP_Customize_Color_Control( $wp_manager, 'btn_single_bg', array(
	            'label'   => 'Button BG Color',
	            'section' => 'pimpmywoo_single_section',
	            'settings'   => 'btn_single_bg',
	            'priority' => 1
	        ) ) );
	        // Button BG Color on Hover
	        $wp_manager->add_setting( 'btn_single_bg_hover', array(
	            'default'        => '',
		        'sanitize_callback' => 'sanitize_hex_color',
				'transport' => 'postMessage',
	        ) );
	        $wp_manager->add_control( new WP_Customize_Color_Control( $wp_manager, 'btn_single_bg_hover', array(
	            'label'   => 'Button BG Color on Hover',
	            'section' => 'pimpmywoo_single_section',
	            'settings'   => 'btn_single_bg_hover',
	            'priority' => 1
	        ) ) );
	        // Button Font Color
	        $wp_manager->add_setting( 'btn_single_color', array(
	            'default'        => '',
		        'sanitize_callback' => 'sanitize_hex_color',
				'transport' => 'postMessage',
	        ) );
	        $wp_manager->add_control( new WP_Customize_Color_Control( $wp_manager, 'btn_single_color', array(
	            'label'   => 'Button Color',
	            'section' => 'pimpmywoo_single_section',
	            'settings'   => 'btn_single_color',
	            'priority' => 1
	        ) ) );
	        // Button Font Color on Hover
	        $wp_manager->add_setting( 'btn_single_color_hover', array(
	            'default'        => '',
		        'sanitize_callback' => 'sanitize_hex_color',
				'transport' => 'postMessage',
	        ) );
	        $wp_manager->add_control( new WP_Customize_Color_Control( $wp_manager, 'btn_single_color_hover', array(
	            'label'   => 'Button Color on Hover',
	            'section' => 'pimpmywoo_single_section',
	            'settings'   => 'btn_single_color_hover',
	            'priority' => 1
	        ) ) );
	        // Button Border Size
	        $wp_manager->add_setting( 'btn_single_border_width', array(
				'transport' => 'postMessage',
		        'sanitize_callback' => 'PimpMyWoo_sanitize_integer',
	            'default'        => '',
	        ) );
	        $wp_manager->add_control( 'btn_single_border_width', array(
	            'label'   => 'Button Border Width (px)',
	            'section' => 'pimpmywoo_single_section',
	            'type'    => 'text',
	            'priority' => 1
	        ) );
	        // Button Border Color 
	        $wp_manager->add_setting( 'btn_single_border_color', array(
	            'default'        => '',
		        'sanitize_callback' => 'sanitize_hex_color',
				'transport' => 'postMessage',
	        ) );
	        $wp_manager->add_control( new WP_Customize_Color_Control( $wp_manager, 'btn_single_border_color', array(
	            'label'   => 'Button Border Color',
	            'section' => 'pimpmywoo_single_section',
	            'settings'   => 'btn_single_border_color',
	            'priority' => 1
	        ) ) );
	        // Button Border Color on Hover
	        $wp_manager->add_setting( 'btn_single_border_color_hover', array(
	            'default'        => '',
		        'sanitize_callback' => 'sanitize_hex_color',
				'transport' => 'postMessage',
	        ) );
	        $wp_manager->add_control( new WP_Customize_Color_Control( $wp_manager, 'btn_single_border_color_hover', array(
	            'label'   => 'Button Border Color on Hover',
	            'section' => 'pimpmywoo_single_section',
	            'priority' => 1
	        ) ) );
	        // Button Border Style
	        $wp_manager->add_setting( 'btn_single_border_style', array(		
				'transport' => 'postMessage',
		        'sanitize_callback' => 'PimpMyWoo_sanitize_select',
	            'default'        => '',
	        ) );
	        $wp_manager->add_control( 'btn_single_border_style', array(
	            'label'   => 'Button Border Style',
	            'section' => 'pimpmywoo_single_section',
	            'type'    => 'select',
	            'choices' => array("none" => "none", "hidden" => "hidden", "dotted" => "dotted", "dashed" => "dashed", "solid" => "solid", "double" => "double", "groove" => "groove", "ridge" => "ridge", "inset" => "inset", "outset" => "outset", "initial" => "initial", "inherit" => "inherit"),
	            'priority' => 1
	        ) );
	        // Button Border Radius
	        $wp_manager->add_setting( 'btn_single_border_radius', array(
				'transport' => 'postMessage',
		        'sanitize_callback' => 'PimpMyWoo_sanitize_integer',
	            'default'        => '',
	        ) );
	        $wp_manager->add_control( 'btn_single_border_radius', array(
	            'label'   => 'Button Border Radius (px)',
	            'section' => 'pimpmywoo_single_section',
	            'type'    => 'text',
	            'priority' => 1
	        ) );
	        // Button Font Family
	        $wp_manager->add_setting( 'btn_single_font', array(
				'transport' => 'postMessage',
	            'default'        => '',
	        ) );
	        $wp_manager->add_control( new Google_Fonts( $wp_manager, 'btn_single_font', array(
	            'label'   => 'Button Font Family',
	            'section' => 'pimpmywoo_single_section',
	            'settings'   => 'btn_single_font',
	            'priority' => 1
	        ) ) );								
	        // Title Font Character Sets
	        $wp_manager->add_setting( 'btn_single_font_latin', array('sanitize_callback' => 'PimpMyWoo_sanitize_checkbox','default' => '1','transport' => 'postMessage') );
	        $wp_manager->add_control( 'btn_single_font_latin', array('label'   => 'Load Latin','section' => 'pimpmywoo_single_section','type' => 'checkbox','priority' => 1) );
	        $wp_manager->add_setting( 'btn_single_font_latinext', array('sanitize_callback' => 'PimpMyWoo_sanitize_checkbox','default' => '','transport' => 'postMessage') );
	        $wp_manager->add_control( 'btn_single_font_latinext', array('label'   => 'Load Latin Extended','section' => 'pimpmywoo_single_section','type' => 'checkbox','priority' => 1) );
	        $wp_manager->add_setting( 'btn_single_font_greek', array('sanitize_callback' => 'PimpMyWoo_sanitize_checkbox','default' => '','transport' => 'postMessage') );
	        $wp_manager->add_control( 'btn_single_font_greek', array('label'   => 'Load Greek','section' => 'pimpmywoo_single_section','type' => 'checkbox','priority' => 1) );
	        $wp_manager->add_setting( 'btn_single_font_greekext', array('sanitize_callback' => 'PimpMyWoo_sanitize_checkbox','default' => '','transport' => 'postMessage') );
	        $wp_manager->add_control( 'btn_single_font_greekext', array('label'   => 'Load Greek Extended','section' => 'pimpmywoo_single_section','type' => 'checkbox','priority' => 1) );
	        $wp_manager->add_setting( 'btn_single_font_vietnamese', array('sanitize_callback' => 'PimpMyWoo_sanitize_checkbox','default' => '','transport' => 'postMessage') );
	        $wp_manager->add_control( 'btn_single_font_vietnamese', array('label'   => 'Load Vietnamese','section' => 'pimpmywoo_single_section','type' => 'checkbox','priority' => 1) );
	        $wp_manager->add_setting( 'btn_single_font_cyrillic', array('sanitize_callback' => 'PimpMyWoo_sanitize_checkbox','default' => '','transport' => 'postMessage') );
	        $wp_manager->add_control( 'btn_single_font_cyrillic', array('label'   => 'Load Cyrillic','section' => 'pimpmywoo_single_section','type' => 'checkbox','priority' => 1) );
	        $wp_manager->add_setting( 'btn_single_font_cyrillicext', array('sanitize_callback' => 'PimpMyWoo_sanitize_checkbox','default' => '','transport' => 'postMessage') );
	        $wp_manager->add_control( 'btn_single_font_cyrillicext', array('label'   => 'Load Cyrillic Extended','section' => 'pimpmywoo_single_section','type' => 'checkbox','priority' => 1) );
	        // Button Font Size
	        $wp_manager->add_setting( 'btn_single_font_size', array(
				'transport' => 'postMessage',
		        'sanitize_callback' => 'PimpMyWoo_sanitize_integer',
	            'default'        => '',
	        ) );
	        $wp_manager->add_control( 'btn_single_font_size', array(
	            'label'   => 'Button Font Size (px)',
	            'section' => 'pimpmywoo_single_section',
	            'type'    => 'text',
	            'priority' => 1
	        ) );
	        // Button Font Weight
	        $wp_manager->add_setting( 'btn_single_font_weight', array(
				'transport' => 'postMessage',
		        'sanitize_callback' => 'PimpMyWoo_sanitize_select',
	            'default'        => '',
	        ) );
	        $wp_manager->add_control( 'btn_single_font_weight', array(
	            'label'   => 'Button Font Weight',
	            'section' => 'pimpmywoo_single_section',
	            'type'    => 'select',
	            'choices' => array("normal" => "normal", "bold" => "bold", "bolder" => "bolder", "lighter" => "lighter", "100" => "100", "200" => "200", "300" => "300", "400" => "400", "500" => "500", "600" => "600", "700" => "700", "800" => "800", "900" => "900", "initial" => "initial", "inherit" => "inherit"),
	            'priority' => 1
	        ) );
	        // Button Font Style
	        $wp_manager->add_setting( 'btn_single_font_style', array(
				'transport' => 'postMessage',
		        'sanitize_callback' => 'PimpMyWoo_sanitize_select',
	            'default'        => '',
	        ) );
	        $wp_manager->add_control( 'btn_single_font_style', array(
	            'label'   => 'Button Font Style',
	            'section' => 'pimpmywoo_single_section',
	            'type'    => 'select',
	            'choices' => array("inherit" => "inherit", "normal" => "normal", "italic" => "italic", "oblique" => "oblique"),
	            'priority' => 1
	        ) );
	        // Button Font Transform
	        $wp_manager->add_setting( 'btn_single_text_transform', array(
				'transport' => 'postMessage',
		        'sanitize_callback' => 'PimpMyWoo_sanitize_select',
	            'default'        => '',
	        ) );
	        $wp_manager->add_control( 'btn_single_text_transform', array(
	            'label'   => 'Button Text Transform',
	            'section' => 'pimpmywoo_single_section',
	            'type'    => 'select',
	            'choices' => array("none" => "none", "capitalize" => "capitalize", "uppercase" => "uppercase", "lowercase" => "lowercase", "initial" => "initial", "inherit" => "inherit"),
	            'priority' => 1
	        ) );
	        // Button Line Height
	        $wp_manager->add_setting( 'btn_single_line_height', array(
				'transport' => 'postMessage',
		        'sanitize_callback' => 'PimpMyWoo_sanitize_integer',
	            'default'        => '',
	        ) );
	        $wp_manager->add_control( 'btn_single_line_height', array(
	            'label'   => 'Button Line Height (px)',
	            'section' => 'pimpmywoo_single_section',
	            'type'    => 'text',
	            'priority' => 1
	        ) );
	        // Button Letter Spacing
	        $wp_manager->add_setting( 'btn_single_letter_spacing', array(
				'transport' => 'postMessage',
		        'sanitize_callback' => 'PimpMyWoo_sanitize_integer',
	            'default'        => '',
	        ) );
	        $wp_manager->add_control( 'btn_single_letter_spacing', array(
	            'label'   => 'Button Letter Spacing (px)',
	            'section' => 'pimpmywoo_single_section',
	            'type'    => 'text',
	            'priority' => 1
	        ) );

			///  PRODUCT TITLE ///   

	        $wp_manager->add_setting( 'pimpmywoo_single_section2', array(
	            'default'        => '',
	        ) );
	        $wp_manager->add_control( new Separator( $wp_manager, 'pimpmywoo_single_section2', array(
	            'label'   => 'Product Title Styling Settings',
	            'description'   => 'Use the the settings below to pimp your WooCommerce product titles on product page.',
	            'section' => 'pimpmywoo_single_section',
	            'priority' => 1
	        ) ) );
	        // Title Font Family
	        $wp_manager->add_setting( 'title_single_font', array(
				'transport' => 'postMessage',
	            'default'        => '',
	        ) );
	        $wp_manager->add_control( new Google_Fonts( $wp_manager, 'title_single_font', array(
	            'label'   => 'Title Font Family',
	            'section' => 'pimpmywoo_single_section',
	            'settings'   => 'title_single_font',
	            'priority' => 1
	        ) ) );
	        // Title Font Character Sets
	        $wp_manager->add_setting( 'title_single_font_latin', array('sanitize_callback' => 'PimpMyWoo_sanitize_checkbox','default' => '1','transport' => 'postMessage') );
	        $wp_manager->add_control( 'title_single_font_latin', array('label'   => 'Load Latin','section' => 'pimpmywoo_single_section','type' => 'checkbox','priority' => 1) );
	        $wp_manager->add_setting( 'title_single_font_latinext', array('sanitize_callback' => 'PimpMyWoo_sanitize_checkbox','default' => '','transport' => 'postMessage') );
	        $wp_manager->add_control( 'title_single_font_latinext', array('label'   => 'Load Latin Extended','section' => 'pimpmywoo_single_section','type' => 'checkbox','priority' => 1) );
	        $wp_manager->add_setting( 'title_single_font_greek', array('sanitize_callback' => 'PimpMyWoo_sanitize_checkbox','default' => '','transport' => 'postMessage') );
	        $wp_manager->add_control( 'title_single_font_greek', array('label'   => 'Load Greek','section' => 'pimpmywoo_single_section','type' => 'checkbox','priority' => 1) );
	        $wp_manager->add_setting( 'title_single_font_greekext', array('sanitize_callback' => 'PimpMyWoo_sanitize_checkbox','default' => '','transport' => 'postMessage') );
	        $wp_manager->add_control( 'title_single_font_greekext', array('label'   => 'Load Greek Extended','section' => 'pimpmywoo_single_section','type' => 'checkbox','priority' => 1) );
	        $wp_manager->add_setting( 'title_single_font_vietnamese', array('sanitize_callback' => 'PimpMyWoo_sanitize_checkbox','default' => '','transport' => 'postMessage') );
	        $wp_manager->add_control( 'title_single_font_vietnamese', array('label'   => 'Load Vietnamese','section' => 'pimpmywoo_single_section','type' => 'checkbox','priority' => 1) );
	        $wp_manager->add_setting( 'title_single_font_cyrillic', array('sanitize_callback' => 'PimpMyWoo_sanitize_checkbox','default' => '','transport' => 'postMessage') );
	        $wp_manager->add_control( 'title_single_font_cyrillic', array('label'   => 'Load Cyrillic','section' => 'pimpmywoo_single_section','type' => 'checkbox','priority' => 1) );
	        $wp_manager->add_setting( 'title_single_font_cyrillicext', array('sanitize_callback' => 'PimpMyWoo_sanitize_checkbox','default' => '','transport' => 'postMessage') );
	        $wp_manager->add_control( 'title_single_font_cyrillicext', array('label'   => 'Load Cyrillic Extended','section' => 'pimpmywoo_single_section','type' => 'checkbox','priority' => 1) );
	        // Title Font Color
	        $wp_manager->add_setting( 'title_single_color', array(
	            'default'        => '',
		        'sanitize_callback' => 'sanitize_hex_color',
				'transport' => 'postMessage',
	        ) );
	        $wp_manager->add_control( new WP_Customize_Color_Control( $wp_manager, 'title_single_color', array(
	            'label'   => 'Title Font Color',
	            'section' => 'pimpmywoo_single_section',
	            'settings'   => 'title_single_color',
	            'priority' => 1
	        ) ) );
	        // Title Font Size
	        $wp_manager->add_setting( 'title_single_font_size', array(
				'transport' => 'postMessage',
		        'sanitize_callback' => 'PimpMyWoo_sanitize_integer',
	            'default'        => '',
	        ) );
	        $wp_manager->add_control( 'title_single_font_size', array(
	            'label'   => 'Title Font Size (px)',
	            'section' => 'pimpmywoo_single_section',
	            'type'    => 'text',
	            'priority' => 1
	        ) );
	        // Title Font Weight
	        $wp_manager->add_setting( 'title_single_font_weight', array(
				'transport' => 'postMessage',
		        'sanitize_callback' => 'PimpMyWoo_sanitize_select',
	            'default'        => '',
	        ) );
	        $wp_manager->add_control( 'title_single_font_weight', array(
	            'label'   => 'Title Font Weight',
	            'section' => 'pimpmywoo_single_section',
	            'type'    => 'select',
	            'choices' => array("normal" => "normal", "bold" => "bold", "bolder" => "bolder", "lighter" => "lighter", "100" => "100", "200" => "200", "300" => "300", "400" => "400", "500" => "500", "600" => "600", "700" => "700", "800" => "800", "900" => "900", "initial" => "initial", "inherit" => "inherit"),
	            'priority' => 1
	        ) );
	        // Title Font Style
	        $wp_manager->add_setting( 'title_single_font_style', array(
				'transport' => 'postMessage',
		        'sanitize_callback' => 'PimpMyWoo_sanitize_select',
	            'default'        => '',
	        ) );
	        $wp_manager->add_control( 'title_single_font_style', array(
	            'label'   => 'Title Font Style',
	            'section' => 'pimpmywoo_single_section',
	            'type'    => 'select',
	            'choices' => array("inherit" => "inherit", "normal" => "normal", "italic" => "italic", "oblique" => "oblique"),
	            'priority' => 1
	        ) );
	        // Title Font Transform
	        $wp_manager->add_setting( 'title_single_text_transform', array(
				'transport' => 'postMessage',
		        'sanitize_callback' => 'PimpMyWoo_sanitize_select',
	            'default'        => '',
	        ) );
	        $wp_manager->add_control( 'title_single_text_transform', array(
	            'label'   => 'Title Text Transform',
	            'section' => 'pimpmywoo_single_section',
	            'type'    => 'select',
	            'choices' => array("none" => "none", "capitalize" => "capitalize", "uppercase" => "uppercase", "lowercase" => "lowercase", "initial" => "initial", "inherit" => "inherit"),
	            'priority' => 1
	        ) );
	        // Title Line Height
	        $wp_manager->add_setting( 'title_single_line_height', array(
				'transport' => 'postMessage',
		        'sanitize_callback' => 'PimpMyWoo_sanitize_integer',
	            'default'        => '',
	        ) );
	        $wp_manager->add_control( 'title_single_line_height', array(
	            'label'   => 'Title Line Height (px)',
	            'section' => 'pimpmywoo_single_section',
	            'type'    => 'text',
	            'priority' => 1
	        ) );
	        // Title Letter Spacing
	        $wp_manager->add_setting( 'title_single_letter_spacing', array(
				'transport' => 'postMessage',
		        'sanitize_callback' => 'PimpMyWoo_sanitize_integer',
	            'default'        => '',
	        ) );
	        $wp_manager->add_control( 'title_single_letter_spacing', array(
	            'label'   => 'Title Letter Spacing (px)',
	            'section' => 'pimpmywoo_single_section',
	            'type'    => 'text',
	            'priority' => 1
	        ) );
			
			///  PRODUCT PRICE(S) ///   

	        $wp_manager->add_setting( 'pimpmywoo_single_section3', array(
	            'default'        => '',
	        ) );
	        $wp_manager->add_control( new Separator( $wp_manager, 'pimpmywoo_single_section3', array(
	            'label'   => 'Product Price(s) Styling Settings',
	            'description'   => 'Use the the settings below to pimp your WooCommerce product price(s) on product page.',
	            'section' => 'pimpmywoo_single_section',
	            'priority' => 1
	        ) ) );
	        // Price Font Family
	        $wp_manager->add_setting( 'price_single_font', array(
				'transport' => 'postMessage',
	            'default'        => '',
	        ) );
	        $wp_manager->add_control( new Google_Fonts( $wp_manager, 'price_single_font', array(
	            'label'   => 'Price Font Family',
	            'section' => 'pimpmywoo_single_section',
	            'settings'   => 'price_single_font',
	            'priority' => 1
	        ) ) );
	        // Price Font Character Sets
	        $wp_manager->add_setting( 'price_single_font_latin', array('sanitize_callback' => 'PimpMyWoo_sanitize_checkbox','default' => '1','transport' => 'postMessage') );
	        $wp_manager->add_control( 'price_single_font_latin', array('label'   => 'Load Latin','section' => 'pimpmywoo_single_section','type' => 'checkbox','priority' => 1) );
	        $wp_manager->add_setting( 'price_single_font_latinext', array('sanitize_callback' => 'PimpMyWoo_sanitize_checkbox','default' => '','transport' => 'postMessage') );
	        $wp_manager->add_control( 'price_single_font_latinext', array('label'   => 'Load Latin Extended','section' => 'pimpmywoo_single_section','type' => 'checkbox','priority' => 1) );
	        $wp_manager->add_setting( 'price_single_font_greek', array('sanitize_callback' => 'PimpMyWoo_sanitize_checkbox','default' => '','transport' => 'postMessage') );
	        $wp_manager->add_control( 'price_single_font_greek', array('label'   => 'Load Greek','section' => 'pimpmywoo_single_section','type' => 'checkbox','priority' => 1) );
	        $wp_manager->add_setting( 'price_single_font_greekext', array('sanitize_callback' => 'PimpMyWoo_sanitize_checkbox','default' => '','transport' => 'postMessage') );
	        $wp_manager->add_control( 'price_single_font_greekext', array('label'   => 'Load Greek Extended','section' => 'pimpmywoo_single_section','type' => 'checkbox','priority' => 1) );
	        $wp_manager->add_setting( 'price_single_font_vietnamese', array('sanitize_callback' => 'PimpMyWoo_sanitize_checkbox','default' => '','transport' => 'postMessage') );
	        $wp_manager->add_control( 'price_single_font_vietnamese', array('label'   => 'Load Vietnamese','section' => 'pimpmywoo_single_section','type' => 'checkbox','priority' => 1) );
	        $wp_manager->add_setting( 'price_single_font_cyrillic', array('sanitize_callback' => 'PimpMyWoo_sanitize_checkbox','default' => '','transport' => 'postMessage') );
	        $wp_manager->add_control( 'price_single_font_cyrillic', array('label'   => 'Load Cyrillic','section' => 'pimpmywoo_single_section','type' => 'checkbox','priority' => 1) );
	        $wp_manager->add_setting( 'price_single_font_cyrillicext', array('sanitize_callback' => 'PimpMyWoo_sanitize_checkbox','default' => '','transport' => 'postMessage') );
	        $wp_manager->add_control( 'price_single_font_cyrillicext', array('label'   => 'Load Cyrillic Extended','section' => 'pimpmywoo_single_section','type' => 'checkbox','priority' => 1) );
	        // Price Font Color
	        $wp_manager->add_setting( 'price_single_color', array(
	            'default'        => '',
		        'sanitize_callback' => 'sanitize_hex_color',
				'transport' => 'postMessage',
	        ) );
	        $wp_manager->add_control( new WP_Customize_Color_Control( $wp_manager, 'price_single_color', array(
	            'label'   => 'Price Font Color',
	            'section' => 'pimpmywoo_single_section',
	            'settings'   => 'price_single_color',
	            'priority' => 1
	        ) ) );
	        // Price Font Size
	        $wp_manager->add_setting( 'price_single_font_size', array(
				'transport' => 'postMessage',
		        'sanitize_callback' => 'PimpMyWoo_sanitize_integer',
	            'default'        => '',
	        ) );
	        $wp_manager->add_control( 'price_single_font_size', array(
	            'label'   => 'Price Font Size (px)',
	            'section' => 'pimpmywoo_single_section',
	            'type'    => 'text',
	            'priority' => 1
	        ) );
	        // Price Font Weight
	        $wp_manager->add_setting( 'price_single_font_weight', array(
				'transport' => 'postMessage',
		        'sanitize_callback' => 'PimpMyWoo_sanitize_select',
	            'default'        => '',
	        ) );
	        $wp_manager->add_control( 'price_single_font_weight', array(
	            'label'   => 'Price Font Weight',
	            'section' => 'pimpmywoo_single_section',
	            'type'    => 'select',
	            'choices' => array("normal" => "normal", "bold" => "bold", "bolder" => "bolder", "lighter" => "lighter", "100" => "100", "200" => "200", "300" => "300", "400" => "400", "500" => "500", "600" => "600", "700" => "700", "800" => "800", "900" => "900", "initial" => "initial", "inherit" => "inherit"),
	            'priority' => 1
	        ) );
	        // Price Font Style
	        $wp_manager->add_setting( 'price_single_font_style', array(
				'transport' => 'postMessage',
		        'sanitize_callback' => 'PimpMyWoo_sanitize_select',
	            'default'        => '',
	        ) );
	        $wp_manager->add_control( 'price_single_font_style', array(
	            'label'   => 'Price Font Style',
	            'section' => 'pimpmywoo_single_section',
	            'type'    => 'select',
	            'choices' => array("inherit" => "inherit", "normal" => "normal", "italic" => "italic", "oblique" => "oblique"),
	            'priority' => 1
	        ) );
	        // Price Font Transform
	        $wp_manager->add_setting( 'price_single_text_transform', array(
				'transport' => 'postMessage',
		        'sanitize_callback' => 'PimpMyWoo_sanitize_select',
	            'default'        => '',
	        ) );
	        $wp_manager->add_control( 'price_single_text_transform', array(
	            'label'   => 'Price Text Transform',
	            'section' => 'pimpmywoo_single_section',
	            'type'    => 'select',
	            'choices' => array("none" => "none", "capitalize" => "capitalize", "uppercase" => "uppercase", "lowercase" => "lowercase", "initial" => "initial", "inherit" => "inherit"),
	            'priority' => 1
	        ) );
	        // Price Line Height
	        $wp_manager->add_setting( 'price_single_line_height', array(
				'transport' => 'postMessage',
		        'sanitize_callback' => 'PimpMyWoo_sanitize_integer',
	            'default'        => '',
	        ) );
	        $wp_manager->add_control( 'price_single_line_height', array(
	            'label'   => 'Price Line Height (px)',
	            'section' => 'pimpmywoo_single_section',
	            'type'    => 'text',
	            'priority' => 1
	        ) );
	        // Price Letter Spacing
	        $wp_manager->add_setting( 'price_single_letter_spacing', array(
				'transport' => 'postMessage',
		        'sanitize_callback' => 'PimpMyWoo_sanitize_integer',
	            'default'        => '',
	        ) );
	        $wp_manager->add_control( 'price_single_letter_spacing', array(
	            'label'   => 'Price Letter Spacing (px)',
	            'section' => 'pimpmywoo_single_section',
	            'type'    => 'text',
	            'priority' => 1
	        ) );


			///  PRODUCT FEATURED IMAGE ///   

	        $wp_manager->add_setting( 'pimpmywoo_single_section4', array(
	            'default'        => '',
	        ) );
	        $wp_manager->add_control( new Separator( $wp_manager, 'pimpmywoo_single_section4', array(
	            'label'   => 'Image Image Styling Settings',
	            'description'   => 'Use the the settings below to pimp your WooCommerce product featured image on product page.',
	            'section' => 'pimpmywoo_single_section',
	            'priority' => 1
	        ) ) );
	        // Image Border Size
	        $wp_manager->add_setting( 'img_single_border_width', array(
				'transport' => 'postMessage',
		        'sanitize_callback' => 'PimpMyWoo_sanitize_integer',
	            'default'        => '',
	        ) );
	        $wp_manager->add_control( 'img_single_border_width', array(
	            'label'   => 'Image Border Width (px)',
	            'section' => 'pimpmywoo_single_section',
	            'type'    => 'text',
	            'priority' => 1
	        ) );
	        // Image Border Color 
	        $wp_manager->add_setting( 'img_single_border_color', array(
	            'default'        => '',
		        'sanitize_callback' => 'sanitize_hex_color',
				'transport' => 'postMessage',
	        ) );
	        $wp_manager->add_control( new WP_Customize_Color_Control( $wp_manager, 'img_single_border_color', array(
	            'label'   => 'Image Border Color',
	            'section' => 'pimpmywoo_single_section',
	            'priority' => 1
	        ) ) );
	        // Image Border Color on Hover
	        $wp_manager->add_setting( 'img_single_border_color_hover', array(
	            'default'        => '',
		        'sanitize_callback' => 'sanitize_hex_color',
				'transport' => 'postMessage',
	        ) );
	        $wp_manager->add_control( new WP_Customize_Color_Control( $wp_manager, 'img_single_border_color_hover', array(
	            'label'   => 'Image Border Color on Hover',
	            'section' => 'pimpmywoo_single_section',
	            'priority' => 1
	        ) ) );
	        // Image Border Style
	        $wp_manager->add_setting( 'img_single_border_style', array(
				'transport' => 'postMessage',
		        'sanitize_callback' => 'PimpMyWoo_sanitize_select',
	            'default'        => '',
	        ) );
	        $wp_manager->add_control( 'img_single_border_style', array(
	            'label'   => 'Image Border Style',
	            'section' => 'pimpmywoo_single_section',
	            'type'    => 'select',
	            'choices' => array("none" => "none", "hidden" => "hidden", "dotted" => "dotted", "dashed" => "dashed", "solid" => "solid", "double" => "double", "groove" => "groove", "ridge" => "ridge", "inset" => "inset", "outset" => "outset", "initial" => "initial", "inherit" => "inherit"),
	            'priority' => 1
	        ) );
	        // Image Border Radius
	        $wp_manager->add_setting( 'img_single_border_radius', array(
				'transport' => 'postMessage',
		        'sanitize_callback' => 'PimpMyWoo_sanitize_integer',
	            'default'        => '',
	        ) );
	        $wp_manager->add_control( 'img_single_border_radius', array(
	            'label'   => 'Image Border Radius (px)',
	            'section' => 'pimpmywoo_single_section',
	            'type'    => 'text',
	            'priority' => 1
	        ) );


			///  PRODUCT ON SALE BADGE ///   

	        $wp_manager->add_setting( 'pimpmywoo_single_section5', array(
	            'default'        => '',
	        ) );
	        $wp_manager->add_control( new Separator( $wp_manager, 'pimpmywoo_single_section5', array(
	            'label'   => 'Sale Badge Styling Settings',
	            'description'   => 'Use the the settings below to pimp your WooCommerce product sale badge on product page.',
	            'section' => 'pimpmywoo_single_section',
	            'priority' => 1
	        ) ) );
	        // Sale Badge BG Color
	        $wp_manager->add_setting( 'sbadge_single_bg', array(
	            'default'        => '',
		        'sanitize_callback' => 'sanitize_hex_color',
				'transport' => 'postMessage',
	        ) );
	        $wp_manager->add_control( new WP_Customize_Color_Control( $wp_manager, 'sbadge_single_bg', array(
	            'label'   => 'Sale Badge BG Color',
	            'section' => 'pimpmywoo_single_section',
	            'priority' => 1
	        ) ) );
	        // Sale Badge Font Color
	        $wp_manager->add_setting( 'sbadge_single_color', array(
	            'default'        => '',
		        'sanitize_callback' => 'sanitize_hex_color',
				'transport' => 'postMessage',
	        ) );
	        $wp_manager->add_control( new WP_Customize_Color_Control( $wp_manager, 'sbadge_single_color', array(
	            'label'   => 'Sale Badge Color',
	            'section' => 'pimpmywoo_single_section',
	            'priority' => 1
	        ) ) );
	        // Sale Badge Border Size
	        $wp_manager->add_setting( 'sbadge_single_border_width', array(
				'transport' => 'postMessage',
		        'sanitize_callback' => 'PimpMyWoo_sanitize_integer',
	            'default'        => '',
	        ) );
	        $wp_manager->add_control( 'sbadge_single_border_width', array(
	            'label'   => 'Sale Badge Border Width (px)',
	            'section' => 'pimpmywoo_single_section',
	            'type'    => 'text',
	            'priority' => 1
	        ) );
	        // Sale Badge Border Color 
	        $wp_manager->add_setting( 'sbadge_single_border_color', array(
	            'default'        => '',
		        'sanitize_callback' => 'sanitize_hex_color',
				'transport' => 'postMessage',
	        ) );
	        $wp_manager->add_control( new WP_Customize_Color_Control( $wp_manager, 'sbadge_single_border_color', array(
	            'label'   => 'Sale Badge Border Color',
	            'section' => 'pimpmywoo_single_section',
	            'priority' => 1
	        ) ) );
	        // Sale Badge Border Style
	        $wp_manager->add_setting( 'sbadge_single_border_style', array(
				'transport' => 'postMessage',
		        'sanitize_callback' => 'PimpMyWoo_sanitize_select',
	            'default'        => '',
	        ) );
	        $wp_manager->add_control( 'sbadge_single_border_style', array(
	            'label'   => 'Sale Badge Border Style',
	            'section' => 'pimpmywoo_single_section',
	            'type'    => 'select',
	            'choices' => array("none" => "none", "hidden" => "hidden", "dotted" => "dotted", "dashed" => "dashed", "solid" => "solid", "double" => "double", "groove" => "groove", "ridge" => "ridge", "inset" => "inset", "outset" => "outset", "initial" => "initial", "inherit" => "inherit"),
	            'priority' => 1
	        ) );
	        // Sale Badge Border Radius
	        $wp_manager->add_setting( 'sbadge_single_border_radius', array(
				'transport' => 'postMessage',
		        'sanitize_callback' => 'PimpMyWoo_sanitize_integer',
	            'default'        => '',
	        ) );
	        $wp_manager->add_control( 'sbadge_single_border_radius', array(
	            'label'   => 'Sale Badge Border Radius (px)',
	            'section' => 'pimpmywoo_single_section',
	            'type'    => 'text',
	            'priority' => 1
	        ) );
	        // Sale Badge Font Family
	        $wp_manager->add_setting( 'sbadge_single_font', array(
				'transport' => 'postMessage',
	            'default'        => '',
	        ) );
	        $wp_manager->add_control( new Google_Fonts( $wp_manager, 'sbadge_single_font', array(
	            'label'   => 'Sale Badge Font Family',
	            'section' => 'pimpmywoo_single_section',
	            'priority' => 1
	        ) ) );
	        // Sale Badge Font Character Sets
	        $wp_manager->add_setting( 'sbadge_single_font_latin', array('sanitize_callback' => 'PimpMyWoo_sanitize_checkbox','transport' => 'postMessage','default' => '1') );
	        $wp_manager->add_control( 'sbadge_single_font_latin', array('label'   => 'Load Latin','section' => 'pimpmywoo_single_section','type' => 'checkbox','priority' => 1) );
	        $wp_manager->add_setting( 'sbadge_single_font_latinext', array('sanitize_callback' => 'PimpMyWoo_sanitize_checkbox','transport' => 'postMessage','default' => '') );
	        $wp_manager->add_control( 'sbadge_single_font_latinext', array('label'   => 'Load Latin Extended','section' => 'pimpmywoo_single_section','type' => 'checkbox','priority' => 1) );
	        $wp_manager->add_setting( 'sbadge_single_font_greek', array('sanitize_callback' => 'PimpMyWoo_sanitize_checkbox','transport' => 'postMessage','default' => '') );
	        $wp_manager->add_control( 'sbadge_single_font_greek', array('label'   => 'Load Greek','section' => 'pimpmywoo_single_section','type' => 'checkbox','priority' => 1) );
	        $wp_manager->add_setting( 'sbadge_single_font_greekext', array('sanitize_callback' => 'PimpMyWoo_sanitize_checkbox','transport' => 'postMessage','default' => '') );
	        $wp_manager->add_control( 'sbadge_single_font_greekext', array('label'   => 'Load Greek Extended','section' => 'pimpmywoo_single_section','type' => 'checkbox','priority' => 1) );
	        $wp_manager->add_setting( 'sbadge_single_font_vietnamese', array('sanitize_callback' => 'PimpMyWoo_sanitize_checkbox','transport' => 'postMessage','default' => '') );
	        $wp_manager->add_control( 'sbadge_single_font_vietnamese', array('label'   => 'Load Vietnamese','section' => 'pimpmywoo_single_section','type' => 'checkbox','priority' => 1) );
	        $wp_manager->add_setting( 'sbadge_single_font_cyrillic', array('sanitize_callback' => 'PimpMyWoo_sanitize_checkbox','transport' => 'postMessage','default' => '') );
	        $wp_manager->add_control( 'sbadge_single_font_cyrillic', array('label'   => 'Load Cyrillic','section' => 'pimpmywoo_single_section','type' => 'checkbox','priority' => 1) );
	        $wp_manager->add_setting( 'sbadge_single_font_cyrillicext', array('sanitize_callback' => 'PimpMyWoo_sanitize_checkbox','transport' => 'postMessage','default' => '') );
	        $wp_manager->add_control( 'sbadge_single_font_cyrillicext', array('label'   => 'Load Cyrillic Extended','section' => 'pimpmywoo_single_section','type' => 'checkbox','priority' => 1) );
	        // Sale Badge Font Size
	        $wp_manager->add_setting( 'sbadge_single_font_size', array(
				'transport' => 'postMessage',
		        'sanitize_callback' => 'PimpMyWoo_sanitize_integer',
	            'default'        => '',
	        ) );
	        $wp_manager->add_control( 'sbadge_single_font_size', array(
	            'label'   => 'Sale Badge Font Size (px)',
	            'section' => 'pimpmywoo_single_section',
	            'type'    => 'text',
	            'priority' => 1
	        ) );
	        // Sale Badge Font Weight
	        $wp_manager->add_setting( 'sbadge_single_font_weight', array(
				'transport' => 'postMessage',
		        'sanitize_callback' => 'PimpMyWoo_sanitize_select',
	            'default'        => '',
	        ) );
	        $wp_manager->add_control( 'sbadge_single_font_weight', array(
	            'label'   => 'Sale Badge Font Weight',
	            'section' => 'pimpmywoo_single_section',
	            'type'    => 'select',
	            'choices' => array("normal" => "normal", "bold" => "bold", "bolder" => "bolder", "lighter" => "lighter", "100" => "100", "200" => "200", "300" => "300", "400" => "400", "500" => "500", "600" => "600", "700" => "700", "800" => "800", "900" => "900", "initial" => "initial", "inherit" => "inherit"),
	            'priority' => 1
	        ) );
	        // Sale Badge Font Style
	        $wp_manager->add_setting( 'sbadge_single_font_style', array(
				'transport' => 'postMessage',
		        'sanitize_callback' => 'PimpMyWoo_sanitize_select',
	            'default'        => '',
	        ) );
	        $wp_manager->add_control( 'sbadge_single_font_style', array(
	            'label'   => 'Sale Badge Font Style',
	            'section' => 'pimpmywoo_single_section',
	            'type'    => 'select',
	            'choices' => array("inherit" => "inherit", "normal" => "normal", "italic" => "italic", "oblique" => "oblique"),
	            'priority' => 1
	        ) );
	        // Sale Badge Font Transform
	        $wp_manager->add_setting( 'sbadge_single_text_transform', array(
				'transport' => 'postMessage',
		        'sanitize_callback' => 'PimpMyWoo_sanitize_select',
	            'default'        => '',
	        ) );
	        $wp_manager->add_control( 'sbadge_single_text_transform', array(
	            'label'   => 'Sale Badge Text Transform',
	            'section' => 'pimpmywoo_single_section',
	            'type'    => 'select',
	            'choices' => array("none" => "none", "capitalize" => "capitalize", "uppercase" => "uppercase", "lowercase" => "lowercase", "initial" => "initial", "inherit" => "inherit"),
	            'priority' => 1
	        ) );
	        // Sale Badge Line Height
	        $wp_manager->add_setting( 'sbadge_single_line_height', array(
				'transport' => 'postMessage',
		        'sanitize_callback' => 'PimpMyWoo_sanitize_integer',
	            'default'        => '',
	        ) );
	        $wp_manager->add_control( 'sbadge_single_line_height', array(
	            'label'   => 'Sale Badge Line Height (px)',
	            'section' => 'pimpmywoo_single_section',
	            'type'    => 'text',
	            'priority' => 1
	        ) );
	        // Sale Badge Letter Spacing
	        $wp_manager->add_setting( 'sbadge_single_letter_spacing', array(
				'transport' => 'postMessage',
		        'sanitize_callback' => 'PimpMyWoo_sanitize_integer',
	            'default'        => '',
	        ) );
	        $wp_manager->add_control( 'sbadge_single_letter_spacing', array(
	            'label'   => 'Sale Badge Letter Spacing (px)',
	            'section' => 'pimpmywoo_single_section',
	            'type'    => 'text',
	            'priority' => 1
	        ) );
	        // Sale Badge Padding
	        $wp_manager->add_setting( 'sbadge_single_padding', array(
				'transport' => 'postMessage',
		        'sanitize_callback' => 'PimpMyWoo_sanitize_integer',
	            'default'        => '',
	        ) );
	        $wp_manager->add_control( 'sbadge_single_padding', array(
	            'label'   => 'Sale Badge Padding (px)',
	            'section' => 'pimpmywoo_single_section',
	            'type'    => 'text',
	            'priority' => 1
	        ) );
	        
	        
	        
	        
			if ( $wp_manager->is_preview() ) {
			    add_action( 'wp_footer', 'pimpmywoo_preview_archive', 21);
			}	
?>