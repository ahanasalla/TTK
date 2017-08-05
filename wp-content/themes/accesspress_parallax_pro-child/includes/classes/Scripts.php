<?php
namespace TtkAccessParallaxPro;

/**
 * Class Scripts
 * @package TtkAccessParallaxPro
 */
class Scripts
{
	/**
	 * Scripts constructor.
	 */
	public function __construct()
	{
	    add_action('wp_enqueue_scripts', array($this, 'scripts'));
	}

    /**
     *
     */
    public function scripts()
    {
        $handleChildJs = 'ttk-child-custom';

        wp_register_script(
            $handleChildJs,
            get_stylesheet_directory_uri().'/js/custom.js',
            array('jquery'),
            1,
            true
        );

        include_once ABSPATH.'wp-admin/includes/plugin.php';

        wp_localize_script(
            $handleChildJs,
            'ttk_custom',
            array(
                'olark_for_wp' => (in_array('olark-for-wp/olark-for-wp.php', $GLOBALS['PO_CACHED_PLUGIN_LIST']) ?: 0)
            )
        );

        wp_enqueue_script($handleChildJs);
    }
}
