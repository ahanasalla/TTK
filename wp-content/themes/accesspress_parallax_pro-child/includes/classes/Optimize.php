<?php
namespace TtkAccessParallaxPro;

/**
 * Class Optimize
 * @package TtkAccessParallaxPro
 */
class Optimize
{
    /**
     * Triggers on request
     *
     * @var bool
     */
    public $doDynamicPhpCssRewrite = false;

    /**
     * Can be later set to `false`
     * Either from here or the Dashboard
     *
     * @var bool
     */
    public $checkifNewFileExists = true;

    /**
     * @var array
     */
    public $assets = array(
        'styles' => array(
            // From "AccessPress Parallax Pro" theme
            'accesspress_parallax-dynamic-style',

            // From "WooCommerce PimpMyWoo" plugin
            'pimpmywoo'
        )
    );

    /**
     *
     * @var array
     */
    public static $deferScripts = array(
        // Theme
        'accesspress_parallax-custom',
        'accesspress_parallax-wow',

        // Child Theme
        'ttk-child-custom',

        // Plugin: SO Page Builder Animate
        'spba-wow',

        // Plugin: Revolution Slider
        'tp-tools',
        'revmin'
    );

    /**
     * @var array
     */
    public static $asyncScripts = array();

    /**
     * @var CleanUp
     */
    private $_cleanup;

    /**
     * Optimize constructor.
     * @param CleanUp $cleanUp
     */
    public function __construct(CleanUp $cleanUp)
    {
        $this->_cleanup = $cleanUp;

        $this->canDoDynamicPhpCssRewrite();

        add_action('wp_enqueue_scripts', array($this, 'scripts'), PHP_INT_MAX);
        add_filter('script_loader_tag',  array($this, 'assetLoaderTag'), 10, 2);

        add_filter('style_loader_src',   array($this, 'assetLoaderSrc'), 9999);
        add_filter('script_loader_src',  array($this, 'assetLoaderSrc'), 9999);

        // Only do the action on Staging as it is not needed on DEV and LIVE
        if (strpos(get_bloginfo('siteurl'), '/townkitchen/') !== false) {
	        add_action('wp_print_styles', array($this, 'w3StylesFix'));
	        add_action('wp_print_footer_scripts', array($this, 'w3ScriptsFix'), 1);
        }

        // Update master.php from w3tc-config -> minify.js.groups
        // when specific scripts are enabled / disabled in `Theme Options`
        add_action('admin_init', function () {
            global $pagenow;

            if (function_exists('of_get_option')
                && class_exists('\W3TC\Dispatcher')
                && current_user_can('manage_options')
                && in_array($pagenow, array('themes.php', 'plugins.php'))
            ) {
                $config = $defaultConfig = \W3TC\Dispatcher::config();

                $js_files = $config->get_array('minify.js.groups');
                $css_files = $config->get_array('minify.css.groups');

                $uriAppend = (strpos($_SERVER['HTTP_HOST'], 'infuse.us') !== false) ? 'townkitchen/' : '';

                if (! empty($js_files)) {
                    $themeEnablePreloader = (of_get_option('enable_preloader') == '1');

                    // Re-create it from $js_files
                    $js_groups = array();

                    foreach ($js_files as $theme => $templates) {
                        foreach ($templates as $template => $locations) {
                            foreach ((array)$locations as $location => $types) {
                                foreach ((array)$types as $files) {
                                    foreach ((array)$files as $fileKey => $file) {
                                        if (! empty($file)) {
                                            // Do not add to the list; it will be added later if enabled in the theme
                                            if (Helpers::endsWith($file, 'pace.min.js')) {
                                                continue;
                                            }

                                            $js_groups[$theme][$template][$location]['files'][] = $uriAppend . \W3TC\Util_Environment::normalize_file_minify($file);
                                        }
                                    }
                                }

                                // Add it to the re-creation as it is enabled in the theme
                                if ($location === 'include-footer' && $themeEnablePreloader) {
                                    $js_groups[$theme][$template][$location]['files'][] = $uriAppend . \W3TC\Util_Environment::normalize_file_minify(
                                        get_template_directory_uri() . '/js/pace.min.js'
                                    );
                                }
                            }
                        }
                    }

                    $config->set('minify.js.groups', $js_groups);
                }

                if (! empty($css_files)) {
                    $css_groups = array();
                    $fileLocation = $fileTheme = $fileTemplate = false;

                    foreach ($css_files as $theme => $templates) {
                        foreach ($templates as $template => $locations) {
                            foreach ((array)$locations as $location => $types) {
                                foreach ((array)$types as $files) {
                                    foreach ((array)$files as $fileKey => $file) {
                                        if (! empty($file)) {
                                            $fileCond = Helpers::endsWith($file, 'so-page-builder-animate/css/animate.min.css');

                                            if ($fileKey === 0 || $fileCond) {
                                                $fileTheme = $theme;
                                                $fileLocation = $location;
                                                $fileTemplate = $template;

                                                // Do not add it to the re-creation, it will be added later if the plugin is enabled
                                                if ($fileCond) {
                                                    continue;
                                                }
                                            }

                                            $css_groups[$theme][$template][$location]['files'][] = $uriAppend . \W3TC\Util_Environment::normalize_file_minify($file);
                                        }
                                    }
                                }
                            }
                        }
                    }

                    // Add it to the re-creation as `SO Page Builder Animate` is active
                    if (function_exists('spba_init_wow')) {
                        $pluginUrl = plugins_url('', 'so-page-builder-animate/so-page-builder-animate.php');

                        $css_groups[$fileTheme][$fileTemplate][$fileLocation]['files'][] = $uriAppend . \W3TC\Util_Environment::normalize_file_minify(
                            $pluginUrl . '/css/animate.min.css'
                        );
                    }

                    $config->set('minify.css.groups', $css_groups);
                }

                if (! empty($js_files) || ! empty($css_files)) {
                    \W3TC\Util_Admin::config_save($defaultConfig, $config);

                    // Flush `W3 Total Cache`
                    $this->flushCache();
                }
            }
        }, PHP_INT_MAX);

        if (array_key_exists('flushCache', $_GET)) {
            $this->flushCache();
        }

        // /?removeHeadInlineCode - does not trigger the action
        $showHeadInlineCode = false;

        if ($showHeadInlineCode && (! array_key_exists('removeHeadInlineCode', $_GET))) {
            add_action('wp_head', array($this, 'headInlineCode'));
        }
    }

    /**
     *
     */
    public function scripts()
    {
        global $wp_styles;

        foreach ($this->assets['styles'] as $handleStyle) {
            if (isset($wp_styles->registered[$handleStyle]) && is_object($wp_styles->registered[$handleStyle])) {
                $src = $wp_styles->registered[$handleStyle]->src;

                // Common path (Local & URL)
                $relFilePath = '/css/'.$handleStyle.'.css';

                $newCssFilePath = get_stylesheet_directory() . $relFilePath;

                // Update contents from /themes/accesspress_parallax_pro-child/css/
                if ($this->doDynamicPhpCssRewrite) {
                    $this->doDynamicPhpCssRewrite($src, $newCssFilePath);
                }

                $loadReloaded = true; // default

                if ($this->checkifNewFileExists) {
                    $loadReloaded = file_exists($newCssFilePath);
                }

                if ($loadReloaded) {
                    $newCssFileUrl = get_stylesheet_directory_uri() . $relFilePath;

                    // Unload Existing Style
                    wp_dequeue_style($handleStyle);
                    wp_deregister_style($handleStyle);

                    // Enqueue the new one
                    wp_enqueue_style($handleStyle.'-reloaded', $newCssFileUrl);
                }
            }
        }

        if (isset($_GET['ttNoLoadStyles'])) {
            $noLoadStyles = trim(trim($_GET['ttNoLoadStyles'], ','));

            // Multiple, separated by comma
            if (strpos($noLoadStyles, ',') !== false) {
                $styles = explode(',', $noLoadStyles);
            } else {
                // One
                $styles = array($noLoadStyles);
            }

            foreach ($styles as $style) {
                wp_dequeue_style($style);
                wp_deregister_style($style);
            }
        }

        if (isset($_GET['ttNoLoadScripts'])) {
            $noLoadScripts = trim(trim($_GET['ttNoLoadScripts'], ','));

            // Multiple, separated by comma
            if (strpos($noLoadScripts, ',') !== false) {
                $scripts = explode(',', $noLoadScripts);
            } else {
                // One
                $scripts = array($noLoadScripts);
            }

            foreach ($scripts as $script) {
                wp_dequeue_script($script);
                wp_deregister_script($script);
            }
        }
    }

    /**
     * @param $tag
     * @param $handle
     * @return mixed
     */
    public function assetLoaderTag($tag, $handle)
    {
        if ($this->_cleanup->isHomePage()) {
            self::$deferScripts[] = 'accesspress_parallax-pace';
        }

        if (in_array($handle, self::$deferScripts)) {
            $tag = str_replace('src=', 'defer src=', $tag);
        }

        if (in_array($handle, self::$asyncScripts)) {
            $tag = str_replace('src=', 'async src=', $tag);
        }

        return $tag;
    }

    /**
     * Increase GTMetrix Score for "Remove query strings from static resources"
     *
     * @param $src
     * @return string
     */
    public function assetLoaderSrc($src)
    {
        if (strpos($src, 'ver=')) {
            $src = remove_query_arg('ver', $src);
        }

        // Remove `&#038;ver=1` query string
        if (strpos($src, '&#038;ver=1') !== false) {
            $parts = explode('&#038;ver=1', $src);
            return $parts[0];
        }

        return $src;
    }

    /**
     * Make sure that for both http:// and https:// calls, the styles are not loaded
     * as they are all combined and minified by W3 Total Cache
     */
    public function w3StylesFix()
    {
        // `W3 Total Cache` has to be activated
        if (! defined('W3TC')) {
            return false;
        }

        $GLOBALS['tt_w3_combined_css'] = array();

        $config = \W3TC\Dispatcher::config();

        // Minify has to be enabled
        if (! $config->get_boolean('minify.enabled')) {
            return false;
        }

        // CSS Minify Has to be Enabled
        if (! $config->get_boolean('minify.css.enable')) {
            return false;
        }

	    $w3CssGroups = $config->get_array('minify.css.groups');

        array_walk_recursive($w3CssGroups, function ($style) {
            $GLOBALS['tt_w3_combined_css'][] = $style;
        });

        global $wp_styles;

        foreach ($wp_styles->registered as $styleObj) {
            if (isset($styleObj->src) && $styleObj->src != 1) {
                foreach ($GLOBALS['tt_w3_combined_css'] as $w3UriStyle) {
                    if (Helpers::endsWith($styleObj->src, $w3UriStyle)) {
                        wp_dequeue_style($styleObj->handle);
                        wp_deregister_style($styleObj->handle);
                        break;
                    }
                }
            }
        }
    }

    /**
     * @param string $location
     */
    public function w3ScriptsFix()
    {
        // `W3 Total Cache` has to be activated
        if (! defined('W3TC')) {
            return false;
        }

        $GLOBALS['tt_w3_combined_scripts'] = array();

        $config = \W3TC\Dispatcher::config();

        // Minify has to be enabled
        if (! $config->get_boolean('minify.enabled')) {
            return false;
        }

	    // JS Minify Has to be Enabled
	    if (! $config->get_boolean('minify.js.enable')) {
		    return false;
	    }

	    $w3JsGroups = $config->get_array('minify.js.groups');

        array_walk_recursive($w3JsGroups, function ($script) {
            $GLOBALS['tt_w3_combined_scripts'][] = $script;
        });

        global $wp_scripts;

        foreach ($wp_scripts->registered as $scriptObj) {
            if (isset($scriptObj->src) && $scriptObj->src != 1) {
                foreach ($GLOBALS['tt_w3_combined_scripts'] as $w3UriScript) {
                    if (Helpers::endsWith($scriptObj->src, $w3UriScript)) {
                        wp_dequeue_script($scriptObj->handle);
                        wp_deregister_script($scriptObj->handle);
                        break;
                    }
                }
            }
        }
    }

    /**
     *
     */
    public function canDoDynamicPhpCssRewrite()
    {
        // For Refresh -> trigger via /?do_scripts_rewrite_bd295a70e46d57
        if (isset($_GET['do_scripts_rewrite_bd295a70e46d57'])) {
            $this->doDynamicPhpCssRewrite = true;
        }

        // On Theme Update
        if (is_admin()) {
            global $pagenow;

            if ($pagenow === 'themes.php' && array_key_exists('page', $_GET) && $_GET['page'] === 'theme-options') {
                add_action('admin_footer', function() {
                ?>
                    <script type="text/javascript">
                    jQuery(document).ready(function($) {
                        $.get('<?php echo get_site_url(); ?>?do_scripts_rewrite_bd295a70e46d57');
                    });
                    </script>
                    <?php
                });
            }
        }
    }

    /**
     * @param $oldSrcUrl
     * @param $newCssFilePath
     */
    public function doDynamicPhpCssRewrite($oldSrcUrl, $newCssFilePath)
    {
        $getRes = wp_remote_get($oldSrcUrl);

        $body = '';

        if (is_array($getRes) && isset($getRes['body']) && $getRes['body'] != '') {
            $body = trim($getRes['body']);
        } else {
            // Fallback in case the connection can't be made
            // e.g. sometimes on localhost it doesn't connect
            $path = str_replace(get_bloginfo('url').'/', '', $oldSrcUrl);

            if (is_file(ABSPATH . $path)) {
                ob_end_clean();
                ob_start();
                require_once ABSPATH . $path;
                $body = trim(ob_get_clean());
            }
        }

        // Put its contents in a .css file & load it
        // No more PHP rendering that would load the WP environment
        file_put_contents($newCssFilePath, $body);
    }

    /**
     *
     */
    public function headInlineCode()
    {
        ?>
        <style type="text/css">
            <?php
            $isWooCart = (function_exists('is_cart') && is_cart());

            if (! $isWooCart) {
            ?>
                /* Fix issues with jquery overlay blocking checkout button */
                .woocommerce .blockUI.blockOverlay {
                    position: relative!important;
                    display: none!important;
                }
            <?php
            }
            ?>
        </style>
        <?php
    }

    /**
     *
     */
    public function flushCache()
    {
        // Flush `W3 Total Cache`
        if (function_exists('w3tc_pgcache_flush')) {
            w3tc_pgcache_flush();
        }
    }
}
