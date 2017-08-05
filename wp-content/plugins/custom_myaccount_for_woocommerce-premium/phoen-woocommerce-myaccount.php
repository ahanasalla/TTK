<?php 
/**
Plugin Name: Custom My Account for Woocommerce Premium
Plugin URI: http://www.phoeniixx.com
Description: Woocommerce custom my account template plugin by phoeniixx designs
Author: phoeniixx
Version: 1.3.1
Text Domain:custom-my-account
Domain Path: /languages
Author URI: http://www.phoeniixx.com
**/


include(dirname(__FILE__).'/myaccount_settings.php');
 
add_action( 'init', 'init' );
 
function init(){
	
	! defined( 'PHOEN_CUSTOM_TEMPLATE_PATH' )   && define( 'PHOEN_CUSTOM_TEMPLATE_PATH', plugin_dir_path( __FILE__ ) . 'woocommerce/' );
	 
	add_filter( 'woocommerce_locate_template', 'phoen_custom_my_account_template', 10, 3 ); 
	 
 }
 
function phoen_custom_my_account_template( $template, $template_name, $template_path ){
	
	if('myaccount/my-account.php' == $template_name ){
		
		$template = PHOEN_CUSTOM_TEMPLATE_PATH . 'myaccount/my-account.php';
	
	}
	
	return $template;
}

add_action('admin_enqueue_scripts','phoen_my_account');

//ajax add endpoint
add_action( 'wp_ajax_nopriv_phoen_myaccount_check', 'phoen_myaccount_check' );
add_action( 'wp_ajax_phoen_myaccount_check', 'phoen_myaccount_check' );
//ajax remove endpoint
add_action( 'wp_ajax_nopriv_phoen_remove_endpoint', 'phoen_remove_endpoint' );
add_action( 'wp_ajax_phoen_remove_endpoint', 'phoen_remove_endpoint' );

add_shortcode( 'my_downloads_content', 'my_downloads_content'  );
add_shortcode( 'view_order_content',  'view_order_content'  );

function my_downloads_content()
{
	wc_get_template( 'myaccount/my-downloads.php' );
}

function view_order_content()
{
wc_get_template( 'myaccount/my-orders.php', array( 'order_count' => 10 ) );	
}


function phoen_my_account(){
	
	wp_enqueue_style( 'font-awesome', plugin_dir_url(__FILE__).'/css/font-awesome.min.css');
	wp_enqueue_style( 'phoen-wcmap3',  plugin_dir_url(__FILE__).'/css/phoen-wcmap.css');
	wp_enqueue_style( 'phoen-wcmap4',  '//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css');
	//wp_enqueue_script( 'phoen-wcmap5',  '//code.jquery.com/jquery-1.10.2.js');
	//wp_enqueue_script( 'phoen-wcmap6',  '//code.jquery.com/ui/1.11.4/jquery-ui.js');
	
	wp_enqueue_script( 'script_myaccount_request', plugin_dir_url( __FILE__ ).'/js/my_account.js', array( 'jquery' ));
	wp_localize_script( 'script_myaccount_request', 'phoen_myaccount_Ajax', array( 'ajax_url' => admin_url( 'admin-ajax.php' )) );
	wp_enqueue_script( 'jquery-ui' );
	wp_enqueue_script( 'jquery-ui-sortable' );
	wp_enqueue_style( 'font-awesome' );
	wp_enqueue_style( 'wp-color-picker');
	wp_enqueue_script( 'wp-color-picker');
	?>
	<script>
	var plugin_url= '<?php echo plugin_dir_url(__FILE__);?>';
	</script>
<?php	 
}
add_action( 'wp_ajax_phoen_wp_handle_upload', 'phoen_wp_handle_upload');
add_action( 'wp_ajax_nopriv_phoen_wp_handle_upload' ,'phoen_wp_handle_upload');

function phoen_wcmap_add_scripts() {
	wp_enqueue_script( 'script_myaccount_front_request', plugin_dir_url( __FILE__ ).'/js/my_account_font.js', array( 'jquery' ));
	wp_enqueue_style( 'phoen-wcmap',  plugins_url('css/phoen-wcmap.css', __FILE__) );
	//wp_enqueue_script( 'script-name', get_template_directory_uri() . '/js/example.js', array(), '1.0.0', true );
	wp_enqueue_style( 'font-awesome', plugin_dir_url(__FILE__).'/css/font-awesome.min.css');
	wp_enqueue_script('media-upload');
	wp_enqueue_style('thickbox');
	wp_enqueue_script('thickbox');
	
	wp_localize_script( 'script_myaccount_front_request', 'phoen_myaccount_Ajax', array( 'ajax_url' => admin_url( 'admin-ajax.php' )) );
	
	?>
	<div class="pho-myaccount-popup-body" style="display:none;">

<div class="pho-modal-box-backdrop"></div>

	<div class="pho-popup-myaccount">
	
		<div class="pho-close_btn"> &#10005; </div>
		
		<h3>Upload Your Profile<h3>
		<form method="post" enctype="multipart/form-data">
			<p><input type="file" name="profile" id="profile"></p>
			<p><input type="submit" name="submit" value="Upload"></p>
			<input type="hidden" name="action" value="phoen_wp_handle_upload">
            <input type="hidden" name="_nonce" value="<?php echo wp_create_nonce('wp_handle_upload') ?>">
		</form>
	</div> <!-- popup class end -->

</div> <!-- pho-popup-body class end -->
	<?php
	

	
}


add_action( 'init', 'phoen_wp_handle_upload');

function phoen_wp_handle_upload()
{
if( ! isset( $_FILES['profile'] ) || ! wp_verify_nonce( $_POST['_nonce'], 'wp_handle_upload' ) )
				return;
		//$current_user = wp_get_current_user(); 
	
		//$user_id = $current_user->ID;
			
			
			if ( ! function_exists( 'media_handle_upload' )  ) {
				require_once( ABSPATH . 'wp-admin/includes/file.php' );
				require_once( ABSPATH . 'wp-admin/includes/image.php' );
				require_once( ABSPATH . 'wp-admin/includes/media.php' );
			}

			$media_id = media_handle_upload( 'profile', 0 );

			if( is_wp_error( $media_id ) ) {
				return;
			}

			// save media id for filter query in media library
			$medias = get_option('phoen-wcmap-users-avatar-ids', array() );
			
			$medias[] = $media_id;
			// then save
			update_option( 'phoen-wcmap-users-avatar-ids', $medias );


			// save user meta
			$user = get_current_user_id();
			
			update_user_meta( $user, 'phoen-wcmap-avatar', $media_id );	
}


add_action( 'wp_enqueue_scripts', 'phoen_wcmap_add_scripts' );

function phoen_myaccount_check()
{
	$title =  $_POST['title'];
	
	
	$data = get_option('phoen-endpoint');
			 
			 
	$endpoint = explode(',',$data);
	
	 

foreach($endpoint as $p)
{
	if($p==$title)
	{

		echo 1;
		break;
	}
	else
	{
		echo 0;
	}
}


die;
}

function phoen_remove_endpoint()
{
	$all_point = array();
	$endpoint = $_POST['endpoint'];
	$all_point = explode(',', get_option('phoen-endpoint'));

	
	$value = array_search($endpoint, $all_point);
	
	unset($all_point[$value]);
	
	$data = implode(',', $all_point);
	
	update_option('phoen-endpoint', $data);
	die;
}


register_activation_hook( __FILE__, 'phoen_wc_myaccount_registration' );

function phoen_wc_myaccount_registration()
{
	$arg ='dashboard,my-downloads,view-orders,edit-account,edit-address';
	
	$dashbord =array(
		'active'=>'1',
		'label'=>'Dashboard',
		'icon'=>'tachometer',
		'content'=>''
	); 
	
	$my_downloads =array(
		'active'=>'1',
		'slug'=>'my-downloads',
		'label'=>'My Downloads',
		'icon'=>'download',
		'content'=>'[my_downloads_content]'
	); 
	
	$view_orders =array(
		'active'=>'1',
		'slug'=>'view-orders',
		'label'=>'My Orders',
		'icon'=>'file-text-o',
		'content'=>'[view_order_content]'
	); 
	
	$edit_account =array(
		'active'=>'1',
		'slug'=>'edit-account',
		'label'=>'Edit Account',
		'icon'=>'pencil-square-o',
		'content'=>''
	); 
	
	$edit_address =array(
		'active'=>'1',
		'slug'=>'edit-address',
		'label'=>'Edit Address',
		'icon'=>'pencil-square-o',
		'content'=>''
	); 
	
	$general_setting = array(
					'custom_profile'=>'enable',
					'menu_style'=>'sidebar',					
					'menu_item_color'=>'#777777',
					'menu_item_hover_color'=>'#000000',
					'logout_color'=>'#ffffff',
					'logout_hover_color'=>'#ffffff',
					'logout_bg_color'=>'#c0c0c0',
					'logout_hover_bg_color'=>'#333333'
					
	);
	
	if(!get_option('phoen-endpoint'))
	{
		update_option('myaccount_general_setting', $general_setting);
		update_option('phoen-endpoint', $arg);
		update_option('phoen-endpoint-dashboard', $dashbord);
		update_option('phoen-endpoint-my-downloads', $my_downloads);
		update_option('phoen-endpoint-view-orders', $view_orders);
		update_option('phoen-endpoint-edit-account', $edit_account);
		update_option('phoen-endpoint-edit-address', $edit_address);
	}
	
}


add_filter( 'get_avatar', 'phoen_get_avatar',1,10);



 function phoen_get_avatar($avatar, $user, $size, $default, $alt, $args ) {

			
			$current_user = wp_get_current_user();
            $user_id = $current_user->ID;

			// get custom avatar
			$custom_avatar = get_user_meta( $user_id, 'phoen-wcmap-avatar', true );

			if( ! $custom_avatar ){
				
				$avatars = get_avatar_url($current_user->user_email);
				
				
				if($avatars)
				{
					$avatar = sprintf("<img alt='' src='".$avatars."'>");
				}
				else
				{
				$url = plugin_dir_url(__FILE__).'/images/default_avatar.png';
				$avatar = sprintf("<img alt='' src='".$url."'>");
				}
				
				return $avatar;
			}

			// maybe resize img
			$resized = phoen_wcmap_resize_avatar_url( $custom_avatar, $size );
			// if error occurred return
			if( ! $resized ) {
				return $avatar;
			}

		$src = phoen_wcmap_generate_avatar_url( $custom_avatar, $size );
			 $class = array( 'avatar', 'avatar-' . (int) 120, 'photo' );
			
			$avatar = sprintf(
				"<img  src='%s' class='%s' />",
				esc_url( $src ),
				esc_attr( join( ' ', $class ) )
			);  
			 return $avatar;
			
			
			
		}

		
		
		
/*#####################################
 AVATAR FUNCTION
#####################################*/

if( ! function_exists( 'phoen_wcmap_generate_avatar_path' ) ){
	/**
	 * Generate avatar path
	 *
	 * @param $attachment_id
	 * @param $size
	 * @return string
	 */
	function  phoen_wcmap_generate_avatar_path( $attachment_id, $size ) {
		// Retrieves attached file path based on attachment ID.
		$filename = get_attached_file( $attachment_id );

		$pathinfo  = pathinfo( $filename );
		$dirname   = $pathinfo['dirname'];
		$extension = $pathinfo['extension'];

		// i18n friendly version of basename().
		$basename = wp_basename( $filename, '.' . $extension );

		$suffix    = $size . 'x' . $size;
		$dest_path = $dirname . '/' . $basename . '-' . $suffix . '.' . $extension;

		return $dest_path;
	}
}

if( ! function_exists( 'phoen_wcmap_generate_avatar_url' ) ) {
	/**
	 * Generate avatar url
	 *
	 * @param $attachment_id
	 * @param $size
	 * @return mixed
	 */
	function phoen_wcmap_generate_avatar_url( $attachment_id, $size ) {
		// Retrieves path information on the currently configured uploads directory.
		
		$upload_dir = wp_upload_dir();

		// Generates a file path of an avatar image based on attachment ID and size.
		$path = phoen_wcmap_generate_avatar_path( $attachment_id, $size );

		return str_replace( $upload_dir['basedir'], $upload_dir['baseurl'], $path );
	}
}

if( ! function_exists( 'phoen_wcmap_resize_avatar_url' ) ) {
	/**
	 * Resize avatar
	 *
	 * @param $attachment_id
	 * @param $size
	 * @return boolean
	 */
	function phoen_wcmap_resize_avatar_url( $attachment_id, $size ){
    
		$dest_path = phoen_wcmap_generate_avatar_path( $attachment_id, $size );
		
		//echo $dest_path."sadhfjkhaskdfhkjasdhfjkhsdjkf";

		if ( file_exists( $dest_path ) ) {
			$resize = true;
		} else {
			// Retrieves attached file path based on attachment ID.
			$path = get_attached_file( $attachment_id );

			// Retrieves a WP_Image_Editor instance and loads a file into it.
			$image = wp_get_image_editor( $path );

			if ( ! is_wp_error( $image ) ) {

				// Resizes current image.
				$image->resize( $size, $size, true );

				// Saves current image to file.
				$image->save( $dest_path );

				$resize = true;

			}
			else {
				$resize = false;
			}
		}

		return $resize;
	}
}
add_action('wp_footer','phoen_footer_file');

function phoen_footer_file(){
	
	?>
 <script>
	jQuery(document).ready(function(){
		jQuery('.woocommerce-account .entry-title').text('My Account');
	});
</script>
<?php
}


add_action('wp_head','my_account_dynamic_css');
		
	function my_account_dynamic_css()
	{
		 $row = get_option('myaccount_general_setting');
	//include(dirname(__FILE__).'dynamic_css.php');

	?>
	<style>	
 .myaccount-menu a{color:<?php echo $row['menu_item_color'].'!important';?>;}
 .myaccount-menu a:hover{color:<?php echo $row['menu_item_hover_color'].'!important';?>;}
 
 
 .phoen-myaccount-menu .pho-logout{color:<?php echo $row['logout_color'].'!important';?>;}
 .phoen-myaccount-menu .pho-logout:hover{color:<?php echo $row['logout_hover_color'].'!important';?>;}
 .phoen-myaccount-menu .pho-logout{background-color:<?php echo $row['logout_bg_color'].'!important';?>;}
 .phoen-myaccount-menu .pho-logout:hover{background-color:<?php echo $row['logout_hover_bgcolor'].'!important';?>;}
 </style>
 	
 <?php
	}
	
	