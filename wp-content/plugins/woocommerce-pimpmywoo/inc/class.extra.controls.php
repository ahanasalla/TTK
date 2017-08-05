<?php
if ( ! class_exists( 'WP_Customize_Control' ) )
    return NULL;
class Separator extends WP_Customize_Control {
    public $type = 'separator';
 
    public function render_content() {
        ?>
        <label>
        <span class="customize-control-title" style="border-bottom: 1px solid #cccccc; margin-top: 15px;"><?php echo esc_html( $this->label ); ?></span>
        <div style="margin-bottom: 15px; margin-top: 5px;"><?php echo esc_html( $this->description ); ?></div>
        </label>
        <?php
    }
}
class Google_Fonts extends WP_Customize_Control
{
	private $fonts = false;
	public function __construct($manager, $id, $args = array(), $options = array()) {
	    $this->fonts = $this->get_fonts();
	    parent::__construct( $manager, $id, $args );
	}
	public function render_content() {
	    if(!empty($this->fonts))
	    {
	        ?>
	            <label>
	                <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
	                <select <?php $this->link(); ?>>
	                    <?php
	                        foreach ( $this->fonts as $k => $v )
	                        {
	                            printf('<option value="%s" %s>%s</option>', $v->family, selected($this->value(), $k, false), $v->family);
	                        }
	                    ?>
	                </select>
	            </label>
	        <?php
	    }
	}
	public function get_fonts( $amount = 999999 ) {
	    $finalselectDirectory = plugin_dir_path(__FILE__);
	    $fontFile = $finalselectDirectory . 'cache/google-web-fonts.txt';
	    //Total time the file will be cached in seconds, set to a week
	    $cachetime = 86400 * 7;
	    if(file_exists($fontFile) && $cachetime < filemtime($fontFile))
	    {
	        $content = json_decode(file_get_contents($fontFile));
	    } else {
	        $googleApi = 'https://www.googleapis.com/webfonts/v1/webfonts?key=AIzaSyDiwOC2j-YVnA_doz64AgjKp66YC7vcxD8';
	        //$googleApi = 'https://www.googleapis.com/webfonts/v1/webfonts?sort=popularity&key=AIzaSyDiwOC2j-YVnA_doz64AgjKp66YC7vcxD8';
	        $fontContent = wp_remote_get( $googleApi, array('sslverify'   => false) );
	        $fp = fopen($fontFile, 'w');
	        fwrite($fp, $fontContent['body']);
	        fclose($fp);
	        $content = json_decode($fontContent['body']);
	    }
	    if($amount == 'all') {
	        return $content->items;
	    } else {
	        return array_slice($content->items, 0, $amount);
	    }
	}
}
function PimpMyWoo_sanitize_integer( $input ) {
	return absint( $input );
}
function PimpMyWoo_sanitize_checkbox( $checked ) {
	return ( ( isset( $checked ) && true == $checked ) ? true : false );
}
function PimpMyWoo_sanitize_select( $input, $setting ) {
	$input = sanitize_key( $input );
	$choices = $setting->manager->get_control( $setting->id )->choices;
	return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
}

?>