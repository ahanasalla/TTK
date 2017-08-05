<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package accesspress_parallax
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo('charset'); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
        <title><?php wp_title('|', true, 'right'); ?></title>
        <link rel="profile" href="http://gmpg.org/xfn/11">
        <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">

        <?php wp_head(); ?>
    </head>

    <body <?php body_class(); ?>>
        <?php if (of_get_option('enable_preloader') == '1') : ?>
            <div id="page-overlay"></div>
        <?php endif; ?>

        <?php
        $accesspress_show_slider = of_get_option('show_slider');
        $rev_short_code = of_get_option('rev_short_code');
        if (empty($accesspress_show_slider) || $accesspress_show_slider == '0'):
            $page_class = "no-slider";
        else:
            $page_class = "";
        endif;
        ?>
        <div id="page" class="hfeed site <?php echo $page_class; ?>">

            <?php if (of_get_option('header_position') == 'pos-bottom' && of_get_option('show_slider') == '1' && is_front_page()): ?>
                <section id="main-slider-wrap">
                    <?php
                    if (of_get_option('slider_type') == 'rev_slider' && !empty($rev_short_code)) {
                        echo do_shortcode(of_get_option('rev_short_code'));
                    } else {
                        do_action('accesspresslite_bxslider');
                    }
                    ?>
                </section>
            <?php endif; ?>

            <?php
            if (is_front_page()) {
                $header_class = of_get_option('header_position');
            } else {
                $header_class = "";
            }

            if(of_get_option('sticky_header') == '1'){
                $sticky_header = "sticky-header";
            }else{
                $sticky_header = "";
            }
            ?>

            <header id="masthead" class="clearfix <?php echo of_get_option('header_layout') . " ".$sticky_header." ". $header_class; ?>">
                <?php
                if (of_get_option('show_top_menu') == '1'):
                    ?>
                    <div id="top-header">
                        <div class="mid-content clearfix">
                            <div class="header-text">
                                <?php 
                                $header_text = of_get_option('header_text');
                                _e($header_text,'accesspress_parallax'); ?>
                            </div>

                            <?php
                            if (has_nav_menu('topmenu')): ?>
                            <div class="top-menu-toggle"><i class="fa fa-navicon"></i></div>
                            <div class="top-menu">
                                <?php
                                    wp_nav_menu(array(
                                        'theme_location' => 'topmenu',
                                        'fallback_cb' => false
                                    ));
                                ?>
                            </div>
                            <?php 
                            endif; ?>
                        </div>
                    </div>
                    <?php
                endif;
                ?>

                <div id="main-header">
                    <?php
                    if (of_get_option('alternative_menu') == '1') {
                        $menu_style = 'slide-left-menu';
                    } else {
                        $menu_style = "";
                    }
                    ?>
                    <div class="mid-content clearfix <?php echo $menu_style; ?>">
                        <div id="site-logo">
                            <?php if (of_get_option('logo')) : ?>
                                <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                                    <img src="<?php echo of_get_option('logo'); ?>" alt="<?php bloginfo('name'); ?>">
                                </a>
                            <?php else: ?>
                                <h1 class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>" rel="home"><?php bloginfo('name'); ?></a></h1>
                                <h2 class="site-description"><?php bloginfo('description'); ?></h2>
                            <?php endif; ?>
                        </div>

                        <div class="menu-toggle"><span><?php _e('Menu', 'accesspress_parallax'); ?></span></div>

                        <nav id="site-navigation" class="<?php if (of_get_option('alternative_menu') == '0') echo 'main-navigation'; ?>">
                            <?php
                            $sections = of_get_option('parallax_section');
                            if (of_get_option('enable_parallax') == '1' && of_get_option('parallax_menu') == '1'):
                                ?>
                                <ul class="nav parallax-nav">
                                    
                                    <?php 
                                        $home_text = of_get_option('home_text');
                                        if (of_get_option('show_slider') == "1" && !empty($home_text)) : ?>
                                        <li class="current"><a href="<?php echo esc_url(home_url('/')); ?>#main-slider-wrap"><?php _e(of_get_option('home_text'),'accesspress_parallax'); ?></a></li>
                                        <?php
                                    endif;

                                    if(!empty($sections)):
                                    foreach ($sections as $single_sections):
                                        if ($single_sections['show_in_menu'] == '1') :
                                            if(function_exists('pll_get_post')){
                                                $title_id = pll_get_post($single_sections['page']);
                                                $title = empty($title_id) ? get_the_title($single_sections['page']) : get_the_title($title_id);
                                            }else{
                                                $title = get_the_title($single_sections['page']); 
                                            }    
                                            ?>
                                                <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>#section-<?php echo $single_sections['page']; ?>"><?php echo $title; ?></a></li>
                                            <?php
                                        endif;
                                    endforeach;
                                    endif;
                                    ?>
                                </ul>

                                <script type="text/javascript">
                                    jQuery(document).ready(function($) {
                                        var headerHeight = $('#main-header').outerHeight();
                                        $('.parallax-on.home .nav').onePageNav({
                                            currentClass: 'current',
                                            changeHash: false,
                                            scrollSpeed: <?php echo of_get_option('scroll_speed'); ?>,
                                            scrollOffset: headerHeight,
                                            scrollThreshold: 0.5,
                                            easing: '<?php echo of_get_option('scroll_effect'); ?>'
                                        });
                                    });
                                </script>

                                <?php
                            else:
                                wp_nav_menu(array(
                                    'theme_location' => 'primary',
                                    'container' => '',
                                    'menu_class' => 'nav normal-nav',
                                    'fallback_cb' => 'wp_page_menu',
                                ));
                            endif;
                            ?>
                        </nav><!-- #site-navigation -->
                    </div>
                </div>

                <?php
                if (of_get_option('show_social') == '1'):
                    $social_icon_position = of_get_option('social_icon_position');
                    ?>
                    <div class="social-icons <?php echo "appear-" . $social_icon_position; ?>">
                        <?php do_action('accesspress_social'); ?>
                    </div>
                    <?php
                endif;
                ?>
            </header><!-- #masthead -->

            <?php if ((of_get_option('header_position') == 'pos-top' || of_get_option('header_position') == 'pos-top-overlap') && of_get_option('show_slider') == '1' && is_front_page()): ?>
                <section id="main-slider-wrap">
                    <?php
                    if (of_get_option('slider_type') == 'rev_slider' && !empty($rev_short_code)) {
                        echo do_shortcode(of_get_option('rev_short_code'));
                    } else {
                        do_action('accesspresslite_bxslider');
                    }
                    ?>
                </section>
            <?php endif; ?>

            <div id="content" class="site-content ">