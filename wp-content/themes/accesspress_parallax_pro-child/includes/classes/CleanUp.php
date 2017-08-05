<?php
namespace TtkAccessParallaxPro;

/**
 * Class CleanUp
 * @package TtkAccessParallaxPro
 */
class CleanUp
{
    /**
     * @var bool
     */
    public $isHomePage = false;

    /**
     * @var bool
     */
    public $isWooPage = false;

    /**
     *
     */
    public function init()
    {
        add_action('init',               array($this, 'onInit'));
        add_action('wp_head',            array($this, 'onHead'), 1);
        add_action('woocommerce_init',   array($this, 'onWooInit'));

        add_action('wp_enqueue_scripts', array($this, 'assets'), PHP_INT_MAX);

        add_action('wp_print_styles',    array($this, 'removeWooStyles'));
        add_action('wp_print_scripts',   array($this, 'removeWooScripts'));

        // Revolution Slider
        add_action('get_footer',         array($this, 'removeRsFooterScripts'));

        add_filter('revslider_meta_generator', '__return_false');

        // WordPress Core
        remove_action('wp_head', 'wp_generator');

        add_action('get_header', function () {
            if (isset($_GET['removeAccessPressHeadCode'])) {
                remove_action('wp_head', 'accesspress_header_styles_scripts');
            }

            if (! $this->isWooPage()) {
                // Source: "WooCommerce Delivery Slots"
                // Removes unused inline code from non-WooCommerce pages (e.g. home page)
                global $jckwds;
                remove_action('wp_head', array($jckwds, 'dynamic_css'));
            }
        });

        add_action('wp_loaded', function () {
            ob_start (function ($content) {
                if (is_admin()) {
                    return $content;
                }

                if ($this->isHomePage()) {
                    // Facebook Script not needed on home page
                    $start = '<div id="fb-root">';
                    $end = '</script>'; // first one after $start is found

                    $content = Helpers::replaceStringWithStartEnd($content, '', $start, $end);
                }

                // $processHtmlDom should be enabled on most pages if not all
                // To be further tested on checkout, cart and my account pages

                $processHtmlDom = true;

                /*
                // Enable it for home page and non-WooCommerce pages
                if ((is_home() || is_front_page()) || (! $this->isWooPage()) || array_key_exists('processHtmlDom', $_GET)) {
                    $processHtmlDom = true;
                }
                */

                if ($processHtmlDom) {
                    // $content will be replaced with specific information generated through $htmlDom
                    // For some reason, returning $htmlDom comes with issues on some servers / websites
                    $onlyAlterContent = true;

                    require_once get_stylesheet_directory() . '/includes/libs/simple_html_dom.php';
                    $htmlDom = str_get_html($content, true, false, DEFAULT_TARGET_CHARSET, false);

                    // For debugging
                    /*
                    if (array_key_exists('return_after_dom_set', $_GET)) {
                        $content = (string)$htmlDom;
                        return $content;
                    }
                    */

                    // Continue if there is a mention of `fonts.googleapis.com` within $content
                    if (strpos($content, 'fonts.googleapis.com') !== false) {
                        require_once 'GoogleFonts.php';
                        $googleFonts = new GoogleFonts;
                        $htmlHeadDom = $googleFonts->process($htmlDom);

                        $content = Helpers::replaceStringWithStartEnd(
                            $content,
                            (string)$htmlHeadDom,
                            '<head',
                            '</head>'
                        );
                    }

                    /*
                    if (! $onlyAlterContent) {
                        $wowInlineMoveToBody = false;

                        if ($wowInlineMoveToBody) {
                            foreach (array_keys($htmlDom->find('script')) as $scriptKey) {
                                if (strpos($htmlDom->find('script', $scriptKey)->innertext, 'new WOW(') !== false) {
                                    $wowInline = $htmlDom->find('script', $scriptKey)->outertext;

                                    $htmlDom->find('head', 0)->innertext = str_replace($wowInline, '', $htmlDom->find('head', 0)->innertext);

                                    // Put WOW inline script before </body>
                                    $htmlDom->find('body', 0)->innertext = $htmlDom->find('body', 0)->innertext . $wowInline;
                                    break;
                                }
                            }
                        }

                        return $htmlDom;
                    }
                    */

                    return $content;
                }

                return $content;
            });
        }, PHP_INT_MAX);
    }

    /**
     *
     */
    public function onHead()
    {
        include_once ABSPATH . 'wp-admin/includes/plugin.php';

        // `Woocommerce check pincode/zipcode for shipping and cod` clean up
        if (is_plugin_active('woocommerce-pincode-check-pro-unl-num/woocommerce-pincode-check.php') && $this->isHomePage()) {
            // These actions are not needed in the home page
            remove_action('wp_head', 'phoen_adpanel_style3');
            remove_action('wp_head', 'hook_css');
        }
    }

    /**
     *
     */
    public function onInit()
    {
        // all actions related to emojis
        remove_action('admin_print_styles', 'print_emoji_styles');
        remove_action('wp_head', 'print_emoji_detection_script', 7);
        remove_action('admin_print_scripts', 'print_emoji_detection_script');
        remove_action('wp_print_styles', 'print_emoji_styles');
        remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
        remove_filter('the_content_feed', 'wp_staticize_emoji');
        remove_filter('comment_text_rss', 'wp_staticize_emoji');

        // filter to remove TinyMCE emojis
        add_filter('tiny_mce_plugins', array($this, 'disableEmojiconsTinymce'));

        $siteComments = wp_count_comments();

        if ($siteComments->approved < 1) {
            add_filter('feed_links_show_comments_feed', '__return_false');
        }
    }

    /**
     *
     */
    public function onWooInit()
    {
        remove_action('get_the_generator_html', 'wc_generator_tag', 10);
        remove_action('get_the_generator_xhtml', 'wc_generator_tag', 10);
    }

    /**
     *
     */
    public function assets()
    {
        // Load the parent & child theme differently
        // to avoid using @import as it not the best practice for a low page speed
        wp_deregister_style('accesspress_parallax-style');
        wp_dequeue_style('accesspress_parallax-style');

        wp_enqueue_style('accesspress_parallax-style', get_template_directory_uri().'/style.css');
        wp_enqueue_style('accesspress_parallax-style-child', get_stylesheet_directory_uri().'/style.css');

        // Unload responsive.css add load it again as it should be loaded after style.css
	    wp_deregister_style('accesspress_parallax-responsive');
	    wp_dequeue_style('accesspress_parallax-responsive');
	    wp_enqueue_style('accesspress_parallax-responsive', get_template_directory_uri().'/css/responsive.css');

        if (! function_exists('is_plugin_active')) {
            include_once ABSPATH . 'wp-admin/includes/plugin.php';
        }

        $activePageBuilderAnimatePlugin = is_plugin_active(
            'so-page-builder-animate/so-page-builder-animate.php'
        );

        $themeHasAnimateHomePage = function_exists('of_get_option') && of_get_option('enable_animation') == '1' && is_front_page();

        // WOW & Animate loaded within plugin
        if ($activePageBuilderAnimatePlugin && (! $themeHasAnimateHomePage)) {
            wp_deregister_style('accesspress_parallax-animate-css');
            wp_dequeue_style('accesspress_parallax-animate-css');

            wp_deregister_script('accesspress_parallax-wow');
            wp_dequeue_script('accesspress_parallax-wow');
        } elseif (wp_script_is('accesspress_parallax-wow') && file_exists(get_template_directory() . '/js/wow.min.js')) {
            // Since WOW is loaded by the theme, choose wow.min.js for faster load
            wp_deregister_script('accesspress_parallax-wow');
            wp_dequeue_script('accesspress_parallax-wow');
            wp_enqueue_script('accesspress_parallax-wow', get_template_directory_uri() . '/js/wow.min.js', array('jquery'), '1.0', true);
        }

        if ($themeHasAnimateHomePage) {
            // We'll remove plugin's calls (if any as the plugin has to be enabled)
            // as the theme already has its own
            remove_action('spba_libraries', 'spba_libraries');
            remove_action('wp_footer', 'spba_init_wow');
        }

        // Do some clean up for Revolution Slider Plugin
        // As their code is not written according to the WordPress standards
        $tpToolsRel = 'public/assets/js/jquery.themepunch.tools.min.js';
        $revminRel = 'public/assets/js/jquery.themepunch.revolution.min.js';

        if (class_exists('\RevSliderGlobals')
            && file_exists(RS_PLUGIN_PATH . $tpToolsRel)
            && file_exists(RS_PLUGIN_PATH . $revminRel)
        ) {
            foreach (array('tp-tools', 'revmin') as $rsHandle) {
                // If they were loaded correctly in the first place
                // Only in HEAD they were enqueued the right way (10th of April, 2017)
                wp_deregister_script($rsHandle);
                wp_dequeue_script($rsHandle);

                $src = false;
                $deps = array();
                $revVer = apply_filters('revslider_remove_version', \RevSliderGlobals::SLIDER_REVISION);

                switch ($rsHandle) {
                    // Requires jQuery library
                    case 'tp-tools':
                        $src = RS_PLUGIN_URL . $tpToolsRel;
                        $deps = array('jquery');
                        break;

                    // Requires 'tp-tools'
                    case 'revmin':
                        $src = RS_PLUGIN_URL . $revminRel;
                        $deps = array('tp-tools');
                        break;
                }

                // Place the script in the footer
                wp_enqueue_script(
                    $rsHandle,
                    $src,
                    $deps,
                    $revVer,
                    true
                );
            }
        }
    }

    /**
     * Do not load WooCommerce Styles (.css) outside the Shop
     */
    public function removeWooStyles()
    {
        if (! $this->isWooPage()) {
            // Source: "WooCommerce" plugin
            wp_dequeue_style('woocommerce-layout');
            wp_dequeue_style('woocommerce-smallscreen');
            wp_dequeue_style('woocommerce-general');

            // Source: "WooCommerce PimpMyWoo" plugin
            wp_dequeue_style('pimpmywoo');

            // Source: "AccessPress Parallax Pro" Theme
            wp_dequeue_style('accesspress_parallax-woo-style');
        }
    }

    /**
     * Do not load WooCommerce Scripts (.js) outside the Shop
     */
    public function removeWooScripts()
    {
        if (! $this->isWooPage()) {
            // Source: "WooCommerce" plugin
            wp_dequeue_script('wc-add-to-cart');
            wp_dequeue_script('jquery-blockui');
            wp_dequeue_script('jquery-placeholder');
            wp_dequeue_script('woocommerce');
            wp_dequeue_script('jquery-cookie');
            wp_dequeue_script('wc-cart-fragments');
        }
    }

    /**
     * Not needed as it was loaded the wrong way
     * They are loaded via assets() the right way ;-)
     */
    public function removeRsFooterScripts()
    {
        global $wp_filter;

        foreach ($wp_filter['wp_footer'] as $priority => $actions) {
            foreach (array_keys($actions) as $action) {
                if ($action === 'RevSliderFront::putJavascript') {
                    unset($wp_filter['wp_footer']->callbacks[$priority][$action]);
                    return;
                }
            }
        }
    }

    /**
     * @param $plugins
     * @return array
     */
    public function disableEmojiconsTinymce($plugins)
    {
        if (is_array($plugins)) {
            return array_diff($plugins, array('wpemoji'));
        }

        return array();
    }

    /**
     * @return bool
     */
    public function isHomePage()
    {
        if (! $this->isHomePage) {
            $this->isHomePage = (is_home() || is_front_page());
        }

        return $this->isHomePage;
    }

    /**
     * @return bool
     */
    public function isWooPage()
    {
        if (! $this->isWooPage) {
            $this->isWooPage = (function_exists('is_woocommerce')
                && (is_woocommerce() || is_product_category() || is_cart() || is_checkout() || is_account_page()));
        }

        return $this->isWooPage;
    }
}
