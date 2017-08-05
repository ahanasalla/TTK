<?php
/*
Plugin Name: Woocommerce check pincode/zipcode for shipping and cod
Plugin URI: http://www.phoeniixx.com
Description: Woocommerce Product Pincode Check with Unlimited number length of input pincode.
Version: 1.8.2
Author: phoeniixx
Author URI: http://www.phoeniixx.com
*/
ob_start();

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**

 * Check if WooCommerce is active

 **/

if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) 
{

	if ( is_admin() ) {
	
		add_action( 'woocommerce_product_write_panel_tabs', 'pincode_check_admin_tab' );
		
		add_action( 'woocommerce_product_write_panels', 'pincode_check_admin_options' );
		
		add_action( 'woocommerce_process_product_meta', 'pincode_check_admin_meta_custom_tab' );

	}
	
	
	function pincode_check_admin_tab() {
				
		?>
		
		<script>
		jQuery( document ).ready( function($) {

			$("#product-type").change(function () {
				
				var value = this.value;
				
				if(value === 'grouped' || value === 'external')
				{
					
					$('.custom_pincode_check').hide();
					
				}
				else
				{
					
					$('.custom_pincode_check').show();
					
				}
				
			});
			
			var valuep  = $('#product-type :selected').val();
			
			if( valuep === 'grouped' || valuep === 'external' )
			{
				
				$('.custom_pincode_check').hide();
				
			}
			else
			{
				
				$('.custom_pincode_check').show();
				
			}
			
		});
		
		</script>

			<li class="custom_pincode_check"><a href="#custom_pincode_check_tab"><?php _e('Add Pincodes', 'disp-test'); ?></a></li>
		
		<?php

	}
	
	function pincode_check_admin_options() {
				
		global $post;

		?>
		
			<div id="custom_pincode_check_tab" class="panel woocommerce_options_panel wc-metaboxes-wrapper">
					
					<div id="custom_pincode_check_tab_data_options" class="wc-metaboxes">
					
						<table cellpadding="0" cellspacing="0" class="wc-metabox-content" style="width:100%;padding: 16px;">
							
							<tbody>
							
								<tr>
								
									<?php
									
									
										//print_r(get_post_meta( $post->ID,'phen_pincode_list' )[0]);
									
										$pincode_count =  count( get_post_meta( $post->ID,'phen_pincode_list' )[0] );
										
										if($pincode_count > 0)
										{
											
											//$pincode_count =  count( get_post_meta( $post->ID,'phen_pincode_list' ) [0] );
											
											$product_id = $post->ID;
											
											?>
										
												<td>
													
													<a id="pheo_view_pincodes" target="_blank" href="<?php echo admin_url("admin.php?page=list_pincodes&&product_id=$product_id"); ?>">View <?php echo $pincode_count; ?> pincodes</a> /
													
													<a id="pheo_delete_pincodes" onClick="javascript: return confirm('You want to delete all pincodes?');" target="_blank" href="<?php echo admin_url("admin.php?page=list_pincodes&&product_id=$product_id&action=delete-all"); ?>">Delete all</a>

												</td>
											
											<?php
									
										}
										
									?>
									
								</tr>
								
								<tr id="response_pincf">
								
								</tr>
								
								<tr>
								
									<td>
										
										<label for="product_pincode_file" style="float:none;margin:0 0 0 10px"><?php _e( 'Upload Product base pincode(csv file):', 'custom-options' ); ?></label>
										
										<input accept=".csv,text/csv" type="file" id="product_pincode_file" name="product_pincode_file" style="float:right" />
									
									</td>
									
									<td>
									
										<img alt="ajax-loader" id="loading_pin"  style="display:none" src="<?php echo esc_url(  plugin_dir_url( __FILE__ ) ); ?>assets/img/ajax-loader.gif"/>
										
										<a id="upload_pin_file" class="button">Upload</a>
									
									</td>
									
								</tr>
								
							</tbody>
							
						</table>

					</div>

			</div>
			
			<!-- <div class="pho-popup-body pho-popup-body-admin" style="display:none" >

				<div class="pho-popup">
					
					<div class="pho-close_btn pho-close_btn_admin"> &#10005; </div>
					
					<table class="wp-list-table widefat fixed striped zipcodes">
					
						<thead>
						
							<tr>
								
								<th class="manage-column column-pincode" id="pincode" scope="col"><a href="#"><span>Pincode</span></a></th>
								
								<th class="manage-column column-city" id="city" scope="col"><a href="#"><span>City</span></a></th>
								
								<th class="manage-column column-state" id="state" scope="col"><a href="#"><span>State</span></a></th>
								
								<th class="manage-column column-dod" id="dod" scope="col"><a href="#"><span>Delivery within days</span></a></th>
								
								<th class="manage-column column-cod" id="cod" scope="col"><a href="#"><span>Cash on delivery</span></a></th>	
								
							</tr>
							
						</thead>

						<tbody data-wp-lists="list:zipcode" id="the-list">
						
							<?php
							
								/* $phen_pincode_lists = get_post_meta( $post->ID,'phen_pincode_list' )[0];
								
								foreach($phen_pincode_lists as $phen_pincode_list) 
								{ */
				
									?>
									
										<tr>
									
											<td class="pincode column-pincode"><?php //echo $phen_pincode_list[0]; ?></td>
											
											<td class="city column-city"><?php //echo $phen_pincode_list[1]; ?></td>
											
											<td class="state column-state"><?php //echo $phen_pincode_list[2]; ?></td>
											
											<td class="dod column-dod"><?php //echo $phen_pincode_list[3]; ?></td>
											
											<td class="cod column-cod"><?php //echo $phen_pincode_list[4]; ?></td>
										
										</tr>
										
									<?php
									
								/* } */
							
							?>
							
						</tbody>

					</table>

				</div>

			</div>-->
			
			<style>
			
				/* stylesheet */

				.pho-popup {
					background-color: #fff;
					box-shadow: 0 0 10px rgba(0, 0, 0, 0.08);
					left: 50%;
					padding: 3px 10px;
					position: absolute;
					top: 50%;
					transform: translate(-50%, -50%);
					-webkit-transform: translate(-50%, -50%);
					width: 750px;
					height: 500px;
					overflow: auto;
					border:4px solid rgba(0, 0, 0, 0.7);
				}
				
							
				.pho-popup .pho-close_btn {text-align:right; cursor:pointer; color:#b5b5b5; font-size:18px; position:absolute; top:0; right:6px; font-family:'Roboto', sans-serif; font-weight:300;}
				.pho-popup .pho-icon img {width:135px;}
				.pho-popup .pho-icon {text-align:center; margin-top:15px;}
				.pho-popup .pho-para  p {text-align:center; font-family:'Roboto', sans-serif; font-size:13px; color:#6a7b84; margin:10 auto; }
				.pho-popup .pho-separator { border: 1px solid #a4aeb4; margin: 5px auto 15px; width: 25px;}
				.pho-popup .pho-pincode {margin:10px 0; text-align:center;}


				.pho-popup input {border: 1px solid #dbdbdb; box-shadow:0 none; font-size:12px; height:34px; max-width:238px; width: 100%; color: #363636;display: inline-block; vertical-align: middle; margin-left:0; margin-bottom:0;}
				.pho-popup .pho-submit_btn {background:#1bbc9b; width:auto; color:#ffffff; height:34px; font-size:12px; font-weight:400; letter-spacing:0.5; cursor:pointer; float:none; margin:1px 0 0 0; border: 0 none; border-radius:0; vertical-align:top; padding-top:8px;}
				.pho-popup form {padding-bottom:16px;}
				.pho-popup .pho-select_div { border: 1px solid #dbdbdb; box-shadow:0 none; font-size:12px; height:32px; max-width:260px; width: 100%;display: inline-block; padding:5px 10px; color:#929292;}
				.pho-popup .pho-option-form {width:366px; margin:0 auto;}

				.pho-modal-box-backdrop {
					background: rgba(238, 238, 238, 0.75);
					bottom: 0;
					left: 0;
					position: absolute;
					right: 0;
					top: 0;
				}

				.pho-popup-body{
					bottom: 0;
					display:block;
					left: 0;
					outline: 0 none;
					overflow-y: auto;
					position: fixed;
					right: 0;
					top: 0;
					z-index: 99999;
					background: rgba(0, 0, 0, 0.4) none repeat scroll 0 0;
				}
			
			</style>
			
			<script>
			
			jQuery(document).ready( function($) {
				
					$(document).on("click", ".pho-close_btn_admin", function() {
						
						$('.pho-popup-body-admin').fadeOut();
						
					});
					
					$(document).on("click", "#pheo_view_pincodes", function() {
						
						$('.pho-popup-body-admin').fadeIn();
						
					});
				
				    $(document).on("click", "#upload_pin_file", function() {
						
						var upload_pin_fileData = new FormData();
								
						upload_pin_fileData.append('action', 'upload_pin_fileData' );
						
						var pinfile = $('#product_pincode_file').prop('files')[0];
						
						if(typeof pinfile != "undefined") //no errors
						{
							
							upload_pin_fileData.append('product_pincode_file', pinfile );
							
								$('#loading_pin').show();

								$.ajax({
									
									  url: '<?php echo admin_url( 'admin-ajax.php' ); ?>',
									  
									  type: 'POST',
									  
									  processData: false, // important
									  
									  contentType: false, // important
									  
									  data : upload_pin_fileData,

									success : function( response ) 
									{							
										
										$('#response_pincf').html( response );
										
										$('#loading_pin').hide();
										
									},
									error: function ( jqXHR, exception ) {
										
										//$('#loading_pin').hide();
										
										var msg = '';
										
										if (jqXHR.status === 0) {
											
											msg = 'Not connect.\n Verify Network.';
											
										} else if (jqXHR.status == 404) {
											
											msg = 'Requested page not found. [404]';
											
										} else if (jqXHR.status == 500) {
											
											msg = 'Internal Server Error [500].';
											
										} else if (exception === 'parsererror') {
											
											msg = 'Requested JSON parse failed.';
											
										} else if (exception === 'timeout') {
											
											msg = 'Time out error.';
											
										} else if (exception === 'abort') {
											
											msg = 'Ajax request aborted.';
											
										} else {
											
											msg = 'Uncaught Error.\n' + jqXHR.responseText;
											
										}
										
										//$('#response_pincf').html( msg );
										console.log( msg );
										
									},
									
								});
							
							//}
							
						}
						else
						{
							
							$("#response_pincf").html("Please Select A valid File.Only csv file type allowed.");
								
							//$('#loading_pin').hide();
							
							return false;
							
						}
						
					});
				
			});
				
			</script>
	
		<?php
	}
	
		add_action( 'wp_ajax_nopriv_upload_pin_fileData', 'upload_pin_fileData' );
		
		add_action( 'wp_ajax_upload_pin_fileData', 'upload_pin_fileData' );
		
		function upload_pin_fileData()
		{
			
			$filename = $_FILES['product_pincode_file']['name'];

			$file_tmp = $_FILES['product_pincode_file']['tmp_name'];

			$filename = dirname(__FILE__) .'/assets/ufile/'.$filename;

			$move_uploaded_file = move_uploaded_file($file_tmp, $filename);
			
			if($move_uploaded_file == 1)
			{
				
				$response = 'FIle uploaded sucessfully';
				
			}
			else
			{
				
				$response = 'Something went wrong, please try again.';
				
			}

			
			die($response);
			
		}
	
	function pincode_check_admin_meta_custom_tab( $post_id ) {
		
		//echo $post_id;
		
		$filename = $_POST['product_pincode_file'];

		if( $filename != '' )
		{
			
			$filename = dirname(__FILE__) .'/assets/ufile/'.$filename;		
							
			if(file_exists($filename)) 
			{
				
				$file_handle = fopen("$filename","r");
				
				$pincode_array = array();
				
				while(! feof($file_handle))
				{

					$line_of_text = fgetcsv($file_handle, 1024);
					
					//print_r($line_of_text);
					
					$pincode = $line_of_text[0];

					$city = $line_of_text[1];

					$state = $line_of_text[2];

					$dod = $line_of_text[3];
					
					if($dod == '')
					{
						
						$dod = 1;
						
					}

					$codc = $line_of_text[4];
					
					if( $codc == 'y' || $codc == 'Y' )
					{
						
						$cod = 'yes';
						
					}
					elseif( $codc == 'n' || $codc == 'N' )
					{
						
						$cod = 'no';
						
					}
					else
					{
						
						$cod = 'no';
						
					}

					if( $pincode != '' )
					{
						
						$pincode_array[$pincode] = array( $pincode, $city, $state, $dod, $cod );
						//echo "'$pincode', '$city', '$state', $dod, '$cod'";

					}

				}
				
				/* echo "<pre>";
				print_r($pincode_array);
				echo "</pre>"; */

				update_post_meta( $post_id,'phen_pincode_list',$pincode_array );
				
				unlink($filename);
				
			}
		
		}
		//die;

	}
	
	function pincodes_settings_link($links) {
	
		  $settings_link = '<a href="admin.php?page=pincodes_setting">Settings</a>'; 
		  
		  array_unshift($links, $settings_link); 
		  
		  return $links; 
		  
	}
		 
	$plugin = plugin_basename(__FILE__);

	add_filter("plugin_action_links_$plugin", 'pincodes_settings_link' ); //for plugin setting link

	function pincodes_setting() {

		require_once(dirname(__FILE__).'/admin-setting.php');
		
	} 
	
	function phoen_adpanel_style3() {

        $plugin_dir_url =  plugin_dir_url( __FILE__ );
		
		$show_s_on_pro =  get_option( 'woo_pin_check_show_s_on_pro' );

		$show_c_on_pro =  get_option( 'woo_pin_check_show_c_on_pro' );
		
		$valpp = get_option('val_product_page');
		
		$show_d_est = get_option('show_deli_est');
		
		$pincode_length = get_option('pincode_length');
		
		if($valpp == '')
		{
			$valpp = 0;
		}
		
		?>
			<script>
				var blog_title = '<?php echo $plugin_dir_url; ?>';
				var usejs = 0;
				var show_s_on_pro = <?php echo $show_s_on_pro; ?>;
				var show_c_on_pro = <?php echo $show_c_on_pro; ?>;
				var val_pro_page = <?php echo $valpp; ?>;
				var show_d_est = <?php echo $show_d_est; ?>;
				var pincode_length = <?php echo $pincode_length; ?>;
				
				var pincode_success_msg = '<?php echo (get_option('woo_pin_checksuccess_msg_b') != '' )?get_option('woo_pin_checksuccess_msg_b'):'Congratulations! We can deliver to you'; ?>';
				
				var woocommerce_pincode_params = {
						
						entrance : "<?php echo get_option('phoen_pincode_ent_effct'); ?>",
						
						exit : "<?php echo get_option('phoen_pincode_ext_effct'); ?>",
						
						info : "<?php echo get_option('phoen_pincode_info_ent_effct'); ?>",
						
						info_exit : "<?php echo get_option('phoen_pincode_info_ext_effct'); ?>"
						
					}
			</script>
		<?php
		
		wp_enqueue_script( 'picodecheck-ajax-request', plugin_dir_url( __FILE__ ) . '/assets/js/custom.js', array( 'jquery' ) );
		
		wp_localize_script( 'picodecheck-ajax-request', 'MyAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
		
		wp_enqueue_style( 'pincode-style-name',$plugin_dir_url.'assets/css/style.css' );
		wp_enqueue_style( 'pinocde-mCustomScrollbar-style',$plugin_dir_url.'assets/css/jquery.mCustomScrollbar.css' );
		wp_enqueue_style( 'pinocde-check_pincode_animate-style',$plugin_dir_url.'assets/css/phoen_check_pincode_animate.css' );
		
		wp_enqueue_script( 'pinocde-mCustomScrollbar-script',$plugin_dir_url.'assets/js/jquery.mCustomScrollbar.js' );
		wp_enqueue_script( 'pinocde-mCustomScrollbar-script2',$plugin_dir_url.'assets/js/jquery.mCustomScrollbar.concat.min.js' );
		
	}

	add_action('wp_head', 'phoen_adpanel_style3'); //for adding /assets/js/css in wp head
	
	function phoen_adpanel_style4() {

        $plugin_dir_url =  plugin_dir_url( __FILE__ );

		?>
		
			<script>
			
				var usejs = 0;
				
			</script>
			
		<?php

	}

	add_action('admin_head', 'phoen_adpanel_style4'); //for adding assets/js/css in wp head
	
	/* if( !is_admin()  ) { */
		
		//wp_enqueue_script( 'picodecheck-ajax-request', plugin_dir_url( __FILE__ ) . '/assets/js/custom.js', array( 'jquery' ) );
		
		//wp_localize_script( 'picodecheck-ajax-request', 'MyAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
		
	/* } */
	
	//Activation Code of table in wordpress

	register_activation_hook(__FILE__, 'pincode_plugin_activation');
	
	function pincode_plugin_activation() {
		
		global $wpdb,$table_prefix;
		
		$active_pincode_check =  get_option( 'active_pincode_check' );
		
		$check_place_oder_show = get_option('woo_pin_checkplc_odr_div');
		
		$show_product_page =  get_option( 'show_product_page' );
		
		$val_product_page =  get_option( 'val_product_page' );
		
		$show_d_est =  get_option( 'show_d_est' );
		
		$show_cod_a =  get_option( 'show_cod_a' );
		
		$pincode_length =  get_option( 'pincode_length' );
		
		$error_msg_b =  get_option( 'woo_pin_check_error_msg_b' );
		
		$del_info_text = get_option('woo_pin_check_del_info_text');
		
		if($del_info_text == ''){
			
			update_option('woo_pin_check_del_info_text','Get item availability info & delivery time for your location.','yes');
		
		}
		
		$del_place_holder_text = get_option('del_place_holder_text');
		
		if($del_place_holder_text == ''){
			
			update_option('del_place_holder_text','Enter Pincode','yes');
		
		}
		
		
		$phoen_pincode_ent_effct =  get_option( 'phoen_pincode_ent_effct' );
		
		$phoen_pincode_ext_effct =  get_option( 'phoen_pincode_ext_effct' );
		
		$phoen_pincode_info_ent_effct =  get_option( 'phoen_pincode_info_ent_effct' );
		
		$phoen_pincode_info_ext_effct =  get_option( 'phoen_pincode_info_ext_effct' );
		
		if($phoen_pincode_ent_effct == ''){
			
			update_option('phoen_pincode_ent_effct','bounceInDown','yes');
		
		}
		if($phoen_pincode_ext_effct == ''){
			
			update_option('phoen_pincode_ext_effct','hinge','yes');
		
		}
		if($phoen_pincode_info_ent_effct == ''){
			
			update_option('phoen_pincode_info_ent_effct','bounceInDown','yes');
		
		}
		if($phoen_pincode_info_ext_effct == ''){
			
			update_option('phoen_pincode_info_ext_effct','hinge','yes');
		
		}
		if($check_place_oder_show == ''){
			
			update_option('woo_pin_checkplc_odr_div',1,'yes');
		
		}
		
		if($active_pincode_check == '')
		{
			
			update_option('active_pincode_check',1,'yes');
			
		}
		
		if($show_product_page == '')
		{
			
			update_option('show_product_page',1,'yes');
			
		}
		
		if($val_product_page == '')
		{
			
			update_option('val_product_page',1,'yes');
			
		}
		
		if($show_d_est == '')
		{
			
			update_option('show_d_est',1,'yes');
			
		}
		
		if($show_cod_a == '')
		{
			
			update_option('show_cod_a',1,'yes');
			
		}
		
		if($pincode_length == '')
		{
			
			update_option('pincode_length', '6');
			
		}
		
		if($error_msg_b == '')
		{
			
			update_option( 'woo_pin_check_error_msg_b', 'Pincode should not be blank.');
			
		}
		
		
		$show_s_on_pro =  get_option( 'woo_pin_check_show_s_on_pro' );
		
		if($show_s_on_pro == '')
		{
			
			update_option( 'woo_pin_check_show_s_on_pro', '1');
			
		}
		
		$show_c_on_pro =  get_option( 'woo_pin_check_show_c_on_pro' );
		
		if($show_c_on_pro == '')
		{
			
			update_option( 'woo_pin_check_show_c_on_pro', '1');
			
		}

		$show_d_d_on_pro =  get_option( 'woo_pin_check_show_d_d_on_pro' );
		
		if($show_d_d_on_pro == '')
		{
			
			update_option( 'woo_pin_check_show_d_d_on_pro', '1');
			
		}
		
		$auto_pch = get_option( 'auto_load_popup' );
		
		if($auto_pch == '')
		{
			
			update_option( 'auto_load_popup', '0');
			
		}
		
		$auto_pchs = get_option( 'auto_load_popup_shop_cat' );
		
		if($auto_pchs == '')
		{
			
			update_option( 'auto_load_popup_shop_cat', '1');
			
		}

		$auto_pch_v = get_option( 'auto_load_validate' );
	
		if($auto_pch_v == '')
		{
			
			update_option( 'auto_load_validate', '1');
			
		}

		$auto_pch_bu = get_option( 'auto_load_block' );
	
		if($auto_pch_bu == '')
		{
			
			update_option( 'auto_load_block', '0');
			
		}

			
		$qry22 = $wpdb->get_results( "SELECT * FROM `".$table_prefix."pincode_setting_p` ORDER BY `id` ASC  limit 1" ,ARRAY_A);	

		foreach($qry22 as $qry) {

		}
		

		if( $qry['s_s']  == '' )
		{
			
			$del_help_text = 'Delivery Date Help Text';
			
			$cod_help_text = 'COD Help Text';
			
			$cod_msg1 = 'Available';
			
			$cod_msg2 = 'Not Available';
			
			$error_msg = 'Please Enter Valid Pincode';
			
			$del_date = '1';
			
			$cod = '1';
						
			$s_s = '1';
			
			$s_s1 = '1';
			
			$cod_p = '1';
			
			$val_checkout = '0';
		
			$result = $wpdb->query( "UPDATE `".$table_prefix."pincode_setting_p`  SET `del_help_text` = '$del_help_text', `cod_help_text` = '$cod_help_text', `cod_msg1` = '$cod_msg1', `cod_msg2` = '$cod_msg2', `error_msg` = '$error_msg', `del_date` = '$del_date', `cod` = '$cod', `s_s` = '$s_s', `s_s1` = '$s_s1', `cod_p` = '$cod_p',  `val_checkout` = '$val_checkout',`date_time` = NOW() " );
	
		}
		
		
		//update_option('val_check_page',1,'yes');

		create_table();
		
	} 

	function create_table() {

		global $table_prefix, $wpdb;

		$tblname = 'check_pincode_p';

		$wp_track_members_table = $table_prefix . "$tblname";

		#Check to see if the table exists already, if not, then create it

		if($wpdb->get_var( "show tables like '$wp_track_members_table'") != $wp_track_members_table) 
		{

			$sql0  = "CREATE TABLE `". $wp_track_members_table . "` ( ";

			$sql0 .= "  `id`  int(11)   NOT NULL auto_increment, ";

			$sql0 .= "  `pincode`  varchar(250)   NOT NULL, ";

			$sql0 .= "  `city`  varchar(250)   NOT NULL, ";

			$sql0 .= "  `state`  varchar(250)   NOT NULL, ";

			$sql0 .= "  `dod`  int(11)   NOT NULL, ";

			$sql0 .= "  `cod`  varchar(250)   NOT NULL, ";
						
			$sql0 .= "  PRIMARY KEY `order_id` (`id`) "; 

			$sql0 .= ") ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ; ";

			#We need to include this file so we have access to the dbDelta function below (which is used to create the table)

			require_once(ABSPATH . '/wp-admin/upgrade-functions.php');

			dbDelta($sql0);

		}
	

		$table_name = $wpdb->prefix . 'pincode_setting_p';
		
		if($wpdb->get_var( "show tables like '$table_name'") != $table_name) 
		{
			
			$sql = "CREATE TABLE $table_name (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`del_help_text` text NOT NULL,
			`cod_help_text` text NOT NULL, 
			`cod_msg1` text NOT NULL, 
			`cod_msg2` text NOT NULL, 
			`error_msg` text NOT NULL,
			`del_date` int(11) NOT NULL, 
			`cod` int(11) NOT NULL,
			
			`s_s` int(11) NOT NULL, 
			`s_s1` int(11) NOT NULL, 
			`cod_p` int(11) NOT NULL,
			`delv_by_cart` int(11) NOT NULL,
			`val_checkout` int(11) NOT NULL,
			`bgcolor` varchar(250) NOT NULL, 
			`textcolor` varchar(250) NOT NULL, 
			`bordercolor` varchar(250) NOT NULL, 
			`buttoncolor` varchar(250) NOT NULL, 
			`buttontcolor` varchar(250) NOT NULL, 
			`ttbordercolor` varchar(250) NOT NULL, 
			`ttbagcolor` varchar(250) NOT NULL, 
			`tttextcolor` varchar(250) NOT NULL, 
			`devbytcolor` varchar(250) NOT NULL, 
			`codtcolor` varchar(250) NOT NULL, 
			`datecolor` varchar(250) NOT NULL, 
			`codmsgcolor` varchar(250) NOT NULL, 
			`errormsgcolor` varchar(250) NOT NULL, 
			`image_size` varchar(250) NOT NULL, 
			`image_size1` varchar(250) NOT NULL, 
			`tt_c_image_size` varchar(250) NOT NULL, 
			`tt_c_image_size1` varchar(250) NOT NULL, 
			`help_image` text NOT NULL, 
			`tt_c_image` text NOT NULL, 
			`date_time` DATETIME NULL,
			PRIMARY KEY id (id));";

			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			
			dbDelta( $sql );
			
			$rows_affected = $wpdb->insert( $table_name, array(
					
					'del_help_text' => 'Delivery Date Help Text',
					'cod_help_text' => 'COD Help Text',
					'cod_msg1' => 'Available',
					'cod_msg2' => 'Not Available',
					'error_msg' => 'Please Enter Valid Pincode',
					'del_date' => '1',
					'cod' => '1',
					
					's_s' => '1',
					's_s1' => '1',
					'cod_p' => '1',
					'delv_by_cart' => '1',
					'val_checkout' => '0',
					'bordercolor' => '#e5e1e1',
					'ttbagcolor' => '#444446',
					'del_help_text' => 'Delivery Date Help Text', 
					'bgcolor' => '#f6f6f8', 
					'textcolor' => '#737070', 
					'buttoncolor' => '#444446', 
					'buttontcolor' => '#ffffff', 
					'ttbordercolor' => '#444446', 
					'errormsgcolor' => '#d95252', 
					'tttextcolor' => '#ffffff')
			
			);

			dbDelta( $rows_affected );
			
		}else{
		
			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			
			$rows_affected = $wpdb->query( "UPDATE $table_name SET `bordercolor` = '#e5e1e1',`ttbagcolor` = '#444446', `bgcolor` = '#f6f6f8', `textcolor` = '#737070', `buttoncolor` = '#444446', `buttontcolor` = '#ffffff', `ttbordercolor` = '#444446', `errormsgcolor` = '#d95252','tttextcolor' = '#ffffff' WHERE id != '' " );
			
			dbDelta( $rows_affected );
		}
		
		dbDelta( $wpdb->query( "ALTER TABLE `$wp_track_members_table` MODIFY pincode varchar(255)") );
		
	}

	
	
	require_once(dirname(__FILE__).'/import_page.php');

	require_once(dirname(__FILE__).'/list_pincodes.php');

	require_once(dirname(__FILE__).'/add_pincode.php');
	
	require_once(dirname(__FILE__).'/pincode_shortcode.php');
	
	require_once(dirname(__FILE__).'/pincode_widget.php');
	
	add_action( 'admin_menu', 'register_my_custom_menu_page' ); //for admin menu


	function register_my_custom_menu_page() {
        
        $plugin_dir_url =  plugin_dir_url( __FILE__ );

		add_menu_page(__('Zip Codes','disp-test'), __('Zip Codes','disp-test'), 'manage_options' , 'import_page' , '' , "$plugin_dir_url/assets/img/page_white_zip.png" , '6');

		add_submenu_page('import_page', __('Import Zip Codes','displ-test'), __('Import Zip Codes','displ-test'), 'manage_options', 'import_page', 'import_page_f');

		add_submenu_page('import_page', __('Add Zip Code','displ-test'), __('Add Zip Code','displ-test'), 'manage_options', 'add_pincode', 'add_pincodes_f');

		add_submenu_page('import_page', __('Zip Code List','displ-test'), __('Zip Code List','displ-test'), 'manage_options', 'list_pincodes', 'list_pincodes_f');

		add_submenu_page('import_page', __('Setting','displ-test'), __('Settings','displ-test'), 'manage_options', 'pincodes_setting', 'pincodes_setting');

	}

	$active_pincode_check = get_option('active_pincode_check');
	
	$showpp = get_option('show_product_page');
	
	if($active_pincode_check == 1)
	{
		if($showpp == 1)
		{
			add_action( 'woocommerce_before_add_to_cart_button', 'pincode_field' ); //for pincode field on product page
		}
		
		function pincode_field( $product ) {
			
			global $table_prefix, $wpdb,$woocommerce;
			
			$customer = new WC_Customer();
			
			$pro_id = get_the_ID();
			
			$_pf = new WC_Product_Factory();  

			$_product = $_pf->get_product($pro_id);
			
			$product_type =  $_product->product_type;
			
			$blog_title = site_url();
			
			$del_label =  get_option( 'woo_pin_check_del_label' );

			$cod_label =  get_option( 'woo_pin_check_cod_label' );
			
			$show_s_on_pro =  get_option( 'woo_pin_check_show_s_on_pro' );

			$show_c_on_pro =  get_option( 'woo_pin_check_show_c_on_pro' );

			$show_d_d_on_pro =  get_option( 'woo_pin_check_show_d_d_on_pro' );
			
			$valpp = get_option('val_product_page');
			
			$show_d_est = get_option('show_deli_est');
			
			$show_cod_a = get_option('show_cod_a');
			
			$pincode_length = get_option('pincode_length');
			
			if($product_type != 'external' && $_product->is_downloadable('yes') != 1 && $_product->is_virtual ('yes') != 1) 
			{
				
				?>
					<script>
					
						var usejs = 1;
						
					</script>
				<?php	
				
				//echo "<script src=".plugin_dir_url( __FILE__ ) . '/assets/js/custom.js'."></script>";
				
				$plugin_dir_url =  plugin_dir_url( __FILE__ );

				$ship_pin = $customer->get_shipping_postcode();
				
				if(isset($_COOKIE['valid_pincode']))
				{
					
					$cookie_pin = $_COOKIE['valid_pincode'];
					
					$star_pincode = substr($cookie_pin, 0, 3).'*';
					
				}

				$qry22 = $wpdb->get_results("SELECT * FROM `".$table_prefix."pincode_setting_p` ORDER BY `id` ASC  limit 1",ARRAY_A);
				
				if( isset($_COOKIE['valid_pincode']) && $cookie_pin != '' )
				{
					
					$phen_pincodes_list = get_post_meta( $pro_id, 'phen_pincode_list' );
					
					//echo count($phen_pincodes_list[0]);
						
					if( count($phen_pincodes_list )	== 0 )
					{
						
						//$phen_pincode_list = array();
						
						//echo "else";
						
						if(!isset($cookie_pin) && $ship_pin != ''){
							
							$cookie_pin = $ship_pin;
						}
						
						$num_rows = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM `".$table_prefix."check_pincode_p` where `pincode` = %s" , $cookie_pin ) );
						
						$like = false;
						
						//echo 'count:'.$count;
						
						if( $num_rows == 0  )
						{
							
							$pincode = substr($cookie_pin, 0, 3);
							
							$num_rows = $wpdb->get_var( $wpdb->prepare( "select COUNT(*) from `".$table_prefix."check_pincode_p` where `pincode` LIKE %s ", $wpdb->esc_like($pincode) .'*%' ) );
							
							$like = true;
							
							//echo 'count1:'.$count;
							
						}
						
						if($num_rows == 0)
						{

							$cookie_pin = '';

						}
					
						if( $like )
						{
							
							$pincode = substr($cookie_pin, 0, 3);
								
							$query = " SELECT * FROM `".$table_prefix."check_pincode_p` where `pincode` LIKE '".$wpdb->esc_like($pincode) ."*%'";
							
						}
						else
						{
							
							$query = " SELECT * FROM `".$table_prefix."check_pincode_p` where `pincode` = '$cookie_pin' ";
							
						}
						
						$getdata = $wpdb->get_results($query);

						foreach($getdata as $data) {

							$dod =  $data->dod;

							$cod =  $data->cod;
							
							$state =  $data->state;

							$city =  $data->city;

						}
						
					}
					else
					{
						
						$phen_pincode_list = $phen_pincodes_list[0];

						//print_r( $phen_pincode_list );
						
						if ( array_key_exists( $wpdb->esc_like($cookie_pin),$phen_pincode_list ) )
						{
							
							//echo 'in';
							
							$safe_zipcode = $cookie_pin;
							
							$dod = $phen_pincode_list[$safe_zipcode][3];
								
							$state = $phen_pincode_list[$safe_zipcode][2];
							
							$city = $phen_pincode_list[$safe_zipcode][1];
							
							$cod = $phen_pincode_list[$safe_zipcode][4];
							
						}
						elseif( array_key_exists(  $star_pincode,$phen_pincode_list ) )
						{
							
							//echo "elseif";
							
							$safe_zipcode = $cookie_pin;
							
							$dod = $phen_pincode_list[$star_pincode][3];
							
							$state = $phen_pincode_list[$star_pincode][2];
							
							$city = $phen_pincode_list[$star_pincode][1];
							
							$cod = $phen_pincode_list[$star_pincode][4];
							
						}
						else
						{
							
							$cookie_pin = '';
							
						}
						
					}	
					
				}

				if(isset($cookie_pin) && $cookie_pin != '') {
				
						for($i=1; $i<=$dod; $i++) {

								$dd = date("D", strtotime("+ $i day"));
								
								if($qry22[0]['s_s'] == 0) {
													
									if($dd == 'Sat') {

										$dod++;

									}
									
								}
								
								if($qry22[0]['s_s1'] == 0) {
									
									if($dd == 'Sun') {

										$dod++;

									}
									
								}

						}

						$delivery_date = date("D, jS M", strtotime("+ $dod day"));

						$customer->set_shipping_postcode($cookie_pin);
						
						$user_ID = get_current_user_id();
						
						if(isset($user_ID) && $user_ID != 0) {
							
							update_user_meta($user_ID, 'shipping_postcode', $cookie_pin); //for setting shipping postcode
							
						}

					?>


					<div style="clear:both;font-size:14px;" class="wc-delivery-time-response">
						
						<span class='avlpin' id='avlpin'>
							<span class="phoe-green-location-icon">
								<img src="<?php echo esc_url( $plugin_dir_url ); ?>assets/img/phoeniixx_pin_location_icon1.jpg" />
							</span>
							<p id="avat"><span class="pincode_static_text">Available at <?php echo esc_html( $cookie_pin ); if( $show_s_on_pro == 1 || $show_c_on_pro == 1 ){ echo "</span><br /><span class='pincode_custom_text'>("; } if($show_c_on_pro == 1){ echo $city; } if( $show_s_on_pro == 1 && $show_c_on_pro == 1 ){ echo ", "; } if($show_s_on_pro == 1){ echo $state; } if( $show_s_on_pro == 1 || $show_c_on_pro == 1 ){ echo ")</span>"; } ?></p><a class="button" id='change_pin'><img src="<?php echo esc_url( $plugin_dir_url ); ?>assets/img/phoeniixx_pin_pencil_logo.jpg" /></a>
						</span>

						<div class="pin_div" id="my_custom_checkout_field2" style="display:none;">
							
							<p id="pincode_field_idp" class="form-row my-field-class form-row-wide">

								<label class="" for="pincode_field_id">Check Availability At</label>

								<span class="input-block">
									
									<span class="loader_div">
										
										<input type="text" <?php if($valpp == 1) { ?> required="required" <?php } ?> value="<?php echo esc_html( $cookie_pin ); ?>" placeholder="Enter Your Pincode" id="pincode_field_id" maxlength="<?php echo $pincode_length; ?>" name="pincode_field" class="input-text pincode_field_id_a" />
									
										<span id="chkpin_loader" style="display:none">
								
											<img alt="ajax-loader" src="<?php echo esc_url( $plugin_dir_url ); ?>assets/img/ajax-loader.gif"/>
											
										</span>
									</span>
								<a class="button" id="checkpin"></a>
								
								</span><!--input-block-->

								
								
							</p>
							
								<div class="error_pin" id="error_pin" style="display:none"><?php if($qry22[0]['error_msg'] != '' ){ echo esc_html( $qry22[0]['error_msg'] ); }else{ echo "Invalid pincode entered"; } ?></div>
									
										<?php
								
											$error_msg_b =  get_option( 'woo_pin_check_error_msg_b' );
										
										?>
									
									<div class="error_pin" id="error_pin_b" style="display:none"><?php echo $error_msg_b;  ?></div>
									
							
						</div>
					
						<div class="delivery-info-wrap">

							<div class="delivery-info animated">
							
							<?php 
							
								if($show_d_est == 1)
								{
									
									?>
									<div class="header">
										<div class="phoe-pincode-pro-tick-img">
											<img src="<?php echo esc_url( $plugin_dir_url ); ?>assets/img/Phoeniixx_Pin_green_tick.jpg" />
											<img src="<?php echo esc_url( $plugin_dir_url ); ?>assets/img/phoeniixx_pin_calander.jpg" />
										</div>
										<div class="phoe-pincode-pro-tick-img">
											<span><h6><?php if($del_label == '' ){ echo "Delivered By"; }else { echo $del_label; } ?></h6></span>
											
												<?php
												
												if($qry22[0]['del_date'] == 1)
												{
													
													?>
													
														<a id="delivery_help_a" class="delivery-help-icon"><?php if($qry22[0]['help_image'] != ''){ ?><img height="<?php echo esc_html( $qry22[0]['image_size'] ); ?>" width="<?php echo esc_html( $qry22[0]['image_size1'] ); ?>" class="help_icon_img" alt="?" src="<?php echo esc_url( $qry22[0]['help_image'] ); ?>"><?php } else { ?> <img class="help_icon_img" alt="?" src="<?php echo esc_url( $plugin_dir_url ); ?>assets/img/phoeniixx_pin_question_mark.jpg"> <?php } ?></a>
													
													<?php

												}
												
												?>								
														<div class="delivery">
								
															<ul class="ul-disc">
								
																<li>
								
																	<?php 
																	
																	if($show_d_d_on_pro == 1)
																	{
																		echo $delivery_date;
																	}
																	else
																	{
																		echo $data->dod." days";
																	}
																	
																	//echo esc_html( $delivery_date ); 
																	
																	?>
								
																</li>
								
															</ul>
								
														</div>
												<?php
												if($qry22[0]['del_date'] == 1)
												{
													?>		
													<div class="delivery_help_text_main width_class" style="display:none">
														
														<?php
														
															if($qry22[0]['tt_c_image'] != '')
															{
																?>
																	<img height="<?php echo esc_html( $qry22[0]['tt_c_image_size'] ); ?>" width="<?php echo esc_html( $qry22[0]['tt_c_image_size1'] ); ?>" id="delivery_help_x" alt="x" class="delivery-help-cross" src="<?php echo esc_url( $qry22[0]['tt_c_image'] ); ?>"/>
																<?php
															}
															else
															{	
																?>						
																	<a id="delivery_help_x" class="delivery-help-cross"> <img class="help_icon_img" alt="x" src="<?php echo esc_url( $plugin_dir_url ); ?>assets/img/cross.png"> </a>
																<?php
															}
														?>
														
														<div class="delivery_help_text width_class">
															
															<?php
															

																	echo esc_html( $qry22[0]['del_help_text'] );
																
															?>
															
														</div>
													</div>
												
												<?php
												}
										?>
										</div>
									</div>
								<?php
								}
								?>
								<div class="cash-on-delivery-info-wrap">

									<div class="cash-on-delivery-info">
										<?php
										if($show_cod_a == 1)
										{
										?>
											<div class="header">
											
											<div class="phoe-pincode-pro-tick-img">
												<span class="phoen_chk_avail">
													<?php 
											
												if($cod == 'yes')
												{?>

													<img src="<?php echo esc_url( $plugin_dir_url ); ?>assets/img/Phoeniixx_Pin_green_tick.jpg" />

												<?php }
												else
												{?>
												
													<img src="<?php echo esc_url( $plugin_dir_url ); ?>assets/img/phoeniixx_pin_cross.jpg" />

												<?php }
											
											?>
												</span>	
												<img src="<?php echo esc_url( $plugin_dir_url ); ?>assets/img/phoeniixx_pin_coins.jpg" />
											</div>
											
											<div class="phoe-pincode-pro-tick-img">
												<h6><?php if($cod_label == '' ){ echo "Cash On Delivery"; }else { echo $cod_label; } ?></h6>
												<?php
												if($qry22[0]['cod'] == 1)
												{
													?>
														<a id="cash_n_delivery_help_a" class="cash-on-delivery-help-icon"><?php if($qry22[0]['help_image'] != ''){ ?><img height="<?php echo esc_html( $qry22[0]['image_size'] ); ?>" width="<?php echo esc_html( $qry22[0]['image_size1'] ); ?>" class="help_icon_img" alt="?" src="<?php echo esc_url( $qry22[0]['help_image'] ); ?>"><?php } else { ?> <img class="help_icon_img" alt="?" src="<?php echo esc_url( $plugin_dir_url ); ?>assets/img/phoeniixx_pin_question_mark.jpg"> <?php } ?></a>
													<?php
												}
												?>
												<div class="cash-on-delivery">

													<?php
													if($cod == 'yes')
													{


															echo esc_html( $qry22[0]['cod_msg1'] );

													}
													else
													{
													

														echo esc_html( $qry22[0]['cod_msg2'] );

													}

													?>

												</div>
												<?php
												if($qry22[0]['cod'] == 1)
												{
												?>
													<div class="cash_on_delivery_help_text_main width_class" style="display:none;">
														<?php
															
															if($qry22[0]['tt_c_image'] != '')
															{
																?>
																	<img alt="?" height="<?php echo esc_html( $qry22[0]['tt_c_image_size'] ); ?>" width="<?php echo esc_html( $qry22[0]['tt_c_image_size1'] ); ?>" id="cash_n_delivery_help_x" class="delivery-help-cross" src="<?php echo esc_url( $qry22[0]['tt_c_image'] ); ?>"/>
																<?php
															}
															else
															{	
																?>						
																	<a id="cash_n_delivery_help_x" class="delivery-help-cross"> <img class="help_icon_img" alt="x" src="<?php echo esc_url( $plugin_dir_url ); ?>assets/img/cross.png"> </a>
																<?php
															}
															
														?>
														<div class="cash_on_delivery_help_text width_class">
																	
																<?php
																
																	echo esc_html( $qry22[0]['cod_help_text'] );
																
																?>
																
														</div>
													</div>
												
												<?php
											}
											?>
											</div>
											</div>
										<?php
										}
										?>										
									</div>

								</div>		

							</div>

						 </div>

					</div>

					<?php

				}
				else
				{

					?>
						<div style="clear:both;font-size:14px;" class="wc-delivery-time-response">
						
						<span class='avlpin' id='avlpin' style="display:none">
							<span class="phoe-green-location-icon">
								<img src="<?php echo esc_url( $plugin_dir_url ); ?>assets/img/phoeniixx_pin_location_icon1.jpg" />
							</span>
							<p id="avat"><span class="pincode_static_text">Available at <?php echo esc_html( $cookie_pin ); if( $show_s_on_pro == 1 || $show_c_on_pro == 1 ){ echo "</span><br /><span class='pincode_custom_text'>("; } if($show_c_on_pro == 1){ echo $city; } if( $show_s_on_pro == 1 && $show_c_on_pro == 1 ){ echo ", "; } if($show_s_on_pro == 1){ echo $state; } if( $show_s_on_pro == 1 || $show_c_on_pro == 1 ){ echo ")</span>"; } ?></p><a class="button" id='change_pin'><img src="<?php echo esc_url( $plugin_dir_url ); ?>assets/img/phoeniixx_pin_pencil_logo.jpg" /></a>
						</span>
						
							<div class="pin_div" id="my_custom_checkout_field2" >
							
								<p id="pincode_field_idp" class="form-row my-field-class form-row-wide">

									<label class="" for="pincode_field_id">Check Availability At</label>

									<span class="input-block">
										
										<span class="loader_div">
											
											<input type="text" <?php if($valpp == 1) { ?> required="required" <?php } ?> value="<?php echo esc_html( $cookie_pin ); ?>" placeholder="Enter Your Pincode" id="pincode_field_id" maxlength="<?php echo $pincode_length; ?>" name="pincode_field" class="input-text pincode_field_id_a" />
										
											<span id="chkpin_loader" style="display:none">
									
												<img alt="ajax-loader" src="<?php echo esc_url( $plugin_dir_url ); ?>assets/img/ajax-loader.gif"/>
												
											</span>
										</span>
									<a class="button" id="checkpin"></a>
									
									</span><!--input-block-->

									
									
								</p>
							
								<div class="error_pin" id="error_pin" style="display:none"><?php if($qry22[0]['error_msg'] != '' ){ echo esc_html( $qry22[0]['error_msg'] ); }else{ echo "Invalid pincode entered"; } ?></div>
									
										<?php
								
											$error_msg_b =  get_option( 'woo_pin_check_error_msg_b' );
										
										?>
									
								<div class="error_pin" id="error_pin_b" style="display:none"><?php echo $error_msg_b;  ?></div>
									
							
						</div>
							
							<div class="delivery-info-wrap delivery-info-wrap2" style="display:none">

								<div class="delivery-info animated">
							<?php 
								if($show_d_est == 1)
								{
									?>
										<div class="header">
										<div class="phoe-pincode-pro-tick-img">
											<img src="<?php echo esc_url( $plugin_dir_url ); ?>assets/img/Phoeniixx_Pin_green_tick.jpg" />
											<img src="<?php echo esc_url( $plugin_dir_url ); ?>assets/img/phoeniixx_pin_calander.jpg" />
										</div>
										<div class="phoe-pincode-pro-tick-img">
											<span><h6><?php if($del_label == '' ){ echo "Delivered By"; }else { echo $del_label; } ?></h6></span>
											
												<?php
												
												if($qry22[0]['del_date'] == 1)
												{
													
													?>
													
														<a id="delivery_help_a" class="delivery-help-icon"><?php if($qry22[0]['help_image'] != ''){ ?><img height="<?php echo esc_html( $qry22[0]['image_size'] ); ?>" width="<?php echo esc_html( $qry22[0]['image_size1'] ); ?>" class="help_icon_img" alt="?" src="<?php echo esc_url( $qry22[0]['help_image'] ); ?>"><?php } else { ?> <img class="help_icon_img" alt="?" src="<?php echo esc_url( $plugin_dir_url ); ?>assets/img/phoeniixx_pin_question_mark.jpg"> <?php } ?></a>
													
													<?php

												}
												
												?>								
														<div class="delivery">
								
															<ul class="ul-disc">
								
																<li>
								
																	<?php 
																	
																	if($show_d_d_on_pro == 1)
																	{
																		echo $delivery_date;
																	}
																	else
																	{
																		echo $data->dod." days";
																	}
																	
																	//echo esc_html( $delivery_date ); 
																	
																	?>
								
																</li>
								
															</ul>
								
														</div>
												<?php
												if($qry22[0]['del_date'] == 1)
												{
													?>		
													<div class="delivery_help_text_main width_class" style="display:none">
														
														<?php
														
															if($qry22[0]['tt_c_image'] != '')
															{
																?>
																	<img height="<?php echo esc_html( $qry22[0]['tt_c_image_size'] ); ?>" width="<?php echo esc_html( $qry22[0]['tt_c_image_size1'] ); ?>" id="delivery_help_x" alt="x" class="delivery-help-cross" src="<?php echo esc_url( $qry22[0]['tt_c_image'] ); ?>"/>
																<?php
															}
															else
															{	
																?>						
																	<a id="delivery_help_x" class="delivery-help-cross"> <img class="help_icon_img" alt="x" src="<?php echo esc_url( $plugin_dir_url ); ?>assets/img/cross.png"> </a>
																<?php
															}
														?>
														
														<div class="delivery_help_text width_class">
															
															<?php
															

																	echo esc_html( $qry22[0]['del_help_text'] );
																
															?>
															
														</div>
													</div>
												
												<?php
											}
										?>
										</div>
									</div>
								<?php
								}
								?>
									<div class="cash-on-delivery-info-wrap">

									<div class="cash-on-delivery-info">
										<?php
										if($show_cod_a == 1)
										{
										?>
											<div class="header">
											
											<div class="phoe-pincode-pro-tick-img">
												<span class="phoen_chk_avail">
													<?php 
											
												if($cod == 'yes')
												{?>

													<img src="<?php echo esc_url( $plugin_dir_url ); ?>assets/img/Phoeniixx_Pin_green_tick.jpg" />

												<?php }
												else
												{?>
												
													<img src="<?php echo esc_url( $plugin_dir_url ); ?>assets/img/phoeniixx_pin_cross.jpg" />

												<?php }
											
											?>
												</span>	
												<img src="<?php echo esc_url( $plugin_dir_url ); ?>assets/img/phoeniixx_pin_coins.jpg" />
											</div>
											
											<div class="phoe-pincode-pro-tick-img">
												<h6><?php if($cod_label == '' ){ echo "Cash On Delivery"; }else { echo $cod_label; } ?></h6>
												<?php
												if($qry22[0]['cod'] == 1)
												{
													?>
														<a id="cash_n_delivery_help_a" class="cash-on-delivery-help-icon"><?php if($qry22[0]['help_image'] != ''){ ?><img height="<?php echo esc_html( $qry22[0]['image_size'] ); ?>" width="<?php echo esc_html( $qry22[0]['image_size1'] ); ?>" class="help_icon_img" alt="?" src="<?php echo esc_url( $qry22[0]['help_image'] ); ?>"><?php } else { ?> <img class="help_icon_img" alt="?" src="<?php echo esc_url( $plugin_dir_url ); ?>assets/img/phoeniixx_pin_question_mark.jpg"> <?php } ?></a>
													<?php
												}
												?>
												<div class="cash-on-delivery">

													<?php
													if($cod == 'yes')
													{


															echo esc_html( $qry22[0]['cod_msg1'] );

													}
													else
													{
													

														echo esc_html( $qry22[0]['cod_msg2'] );

													}

													?>

												</div>
												<?php
												if($qry22[0]['cod'] == 1)
												{
												?>
													<div class="cash_on_delivery_help_text_main width_class" style="display:none;">
														<?php
															
															if($qry22[0]['tt_c_image'] != '')
															{
																?>
																	<img alt="?" height="<?php echo esc_html( $qry22[0]['tt_c_image_size'] ); ?>" width="<?php echo esc_html( $qry22[0]['tt_c_image_size1'] ); ?>" id="cash_n_delivery_help_x" class="delivery-help-cross" src="<?php echo esc_url( $qry22[0]['tt_c_image'] ); ?>"/>
																<?php
															}
															else
															{	
																?>						
																	<a id="cash_n_delivery_help_x" class="delivery-help-cross"> <img class="help_icon_img" alt="x" src="<?php echo esc_url( $plugin_dir_url ); ?>assets/img/cross.png"> </a>
																<?php
															}
															
														?>
														<div class="cash_on_delivery_help_text width_class">
																	
																<?php
																
																	echo esc_html( $qry22[0]['cod_help_text'] );
																
																?>
																
														</div>
													</div>
												
												<?php
											}
											?>
											</div>
											</div>
										<?php
										}
										?>										
									</div>

								</div>		

								</div>

							</div>
							
						</div>
					<?php

				}
			
			}
			else
			{
				?>
					<script>
						var usejs = 0;
					</script>
				<?php
			}
		}

		
		add_action( 'woocommerce_after_order_notes', 'checkout_page_function' ); //for checkout page functionality

		function checkout_page_function() {
			
			global $table_prefix, $wpdb, $woocommerce;
			
			$blog_title = site_url();
			
			$cookie_pin = $_COOKIE['valid_pincode'];
			 
			$show_error =  0;
			
			$qry22 = $wpdb->get_results("SELECT * FROM `".$table_prefix."pincode_setting_p` ORDER BY `id` ASC  limit 1",ARRAY_A);
			 
			if (isset( $cookie_pin ) )
			{		
		
				$customer = new WC_Customer();

				$customer->set_shipping_postcode($cookie_pin);
				
				$user_ID = get_current_user_id();
				
				$current_pcode = get_user_meta($user_ID, 'shipping_postcode');
				
				//$customer = new WC_Customer();
				
				if(isset($user_ID) && $user_ID != 0)
				{
					
					update_user_meta( $user_ID, 'shipping_postcode', $cookie_pin );
					
					if($current_pcode[0] != $cookie_pin)
					{
						
						header("Refresh:0");
						
					}
					
				}
				
				$items = $woocommerce->cart->get_cart();
				
				$star_pincode = substr($cookie_pin, 0, 3).'*';

				foreach($items as $item => $values) {
		
					$_product_id = $values['product_id'];
					
					$phen_pincodes_list = get_post_meta( $_product_id, 'phen_pincode_list' );
					
					if( count( $phen_pincodes_list )	== 0 )
					{
						
						$safe_zipcode = $cookie_pin;
				
						$pincode = substr($cookie_pin, 0, 3);
						
						$show_d_d_on_pro =  get_option( 'woo_pin_check_show_d_d_on_pro' );
						
						$table_pin_codes = $table_prefix."check_pincode_p";
						
						if( $safe_zipcode )
						{
							
							$count = $wpdb->get_var( $wpdb->prepare( "select COUNT(*) from $table_pin_codes where `pincode` = %s ", $safe_zipcode ) );
							
							$like = false;
							
							//echo 'count:'.$count;
							
							if( $count == 0  )
							{
								
								$count = $wpdb->get_var( $wpdb->prepare( "select COUNT(*) from $table_pin_codes where `pincode` LIKE %s ", $wpdb->esc_like($pincode) .'*%' ) );
								
								$like = true;
								
								//echo 'count1:'.$count;
								
							}
							
							if( $count == 0 )
							{

							   //echo "0";  
							   $show_error++;

							}
							else
							{
								
								if( $like )
								{
									
									$query = "SELECT * FROM `$table_pin_codes` where pincode LIKE '".$wpdb->esc_like($pincode) ."*%'";
									
								}
								else
								{
									
									$query = "SELECT * FROM `$table_pin_codes` where pincode='$safe_zipcode'"; 
									
								}
								
								//echo $query;
								
								$ftc_ary = $wpdb->get_results($query);
								
								$show_error =  count($ftc_ary);
								
								if($show_error == 0)
								{
									
									$show_error++;
									
								}

							}
							
						}
						
					}
					else
					{
						
						$phen_pincode_list = $phen_pincodes_list[0];
						
						if ( array_key_exists( $wpdb->esc_like($cookie_pin),$phen_pincode_list ) )
						{
							
							//echo 'in';
							
							$safe_zipcode = $cookie_pin;
							
							$dod = $phen_pincode_list[$safe_zipcode][3];
								
							$state = $phen_pincode_list[$safe_zipcode][2];
							
							$city = $phen_pincode_list[$safe_zipcode][1];
							
							//$show_error++;
							
						}
						elseif( array_key_exists(  $star_pincode,$phen_pincode_list ) )
						{
							
							//echo "elseif";
							
							$safe_zipcode = $cookie_pin;
							
							$dod = $phen_pincode_list[$star_pincode][3];
							
							$state = $phen_pincode_list[$star_pincode][2];
							
							$city = $phen_pincode_list[$star_pincode][1];
							
							//$show_error++;
							
						}
						else
						{
							
							$show_error++;
							
						}
						
					}

				}

			}
			else
			{
				
				$show_error++;
				
			}
			
			//echo $show_error;
			
			//$qry22 = $wpdb->get_results( "SELECT * FROM `".$table_prefix."pincode_setting_p` ORDER BY `id` ASC  limit 1",ARRAY_A);	
				
			?>
			
				<div id="remove_pro_popup_id" class="pho-popup-body" style="display:none" >
					
					<div class="phoen-popup-div phoen_chk_pncde_anmt_div animated">
					
						<div class="pho-popup ">
						
							<div class="pho-close_btn"> &#10005; </div>
						
								<div class="pho-icon">
								
										<div class="pho-para">
										
											<p>All of your products are not available on your selected pinocode(<span class="chng_pincode_checkout" ><?php echo $cookie_pin; ?></span>),</br> Please remove One or more product from your cart. </p>
											
										</div>
										
								</div>
							
						</div> <!-- popup class end -->
					
					</div>

				</div>
				
				<script>
				
				 var remove_cod = <?php echo $qry22[0]['cod_p']; ?>;
				 
				 var remove_place_order = <?php echo get_option('woo_pin_checkplc_odr_div'); ?>;
							 
				 var usejs = 0;
				
				</script>
		
				<p id="err_pin_text" style="display:none;"><?php if($qry22[0]['error_msg'] != '' ){ echo esc_html( $qry22[0]['error_msg'] ); }else{ echo "Invalid pincode entered"; } ?></p>
				
				<?php
				
					$error_msg_b =  get_option( 'woo_pin_check_error_msg_b' );
				
				?>
				
				<p id="err_pin_text_b" style="display:none;"><?php if($error_msg_b != '' ){ echo esc_html( $error_msg_b ); }else{ echo "Invalid pincode entered"; } ?></p>
				
			<?php
			
		}
		
		// if both logged in and not logged in users can send this AJAX request,
		// add both of these actions, otherwise add only the appropriate one
		add_action( 'wp_ajax_nopriv_picodecheck_ajax_submit_home', 'picodecheck_ajax_submit_home' );
		
		add_action( 'wp_ajax_picodecheck_ajax_submit_home', 'picodecheck_ajax_submit_home' );

		function picodecheck_ajax_submit_home() {
			
			global $table_prefix, $wpdb;
				
			$pincode = sanitize_text_field( $_POST['pin_code'] );
					
			//echo "else";
			//echo "Key does not exist!";
			$safe_zipcode = $pincode;
		
			$pincode = substr($pincode, 0, 3);
			
			$show_d_d_on_pro =  get_option( 'woo_pin_check_show_d_d_on_pro' );
			
			$table_pin_codes = $table_prefix."check_pincode_p";
			
			$qry22 = $wpdb->get_results("SELECT * FROM `".$table_prefix."pincode_setting_p` ORDER BY `id` ASC  limit 1",ARRAY_A);
			
			if($safe_zipcode)
			{
				
				$count = $wpdb->get_var( $wpdb->prepare( "select COUNT(*) from $table_pin_codes where `pincode` = %s ", $safe_zipcode ) );
				
				$like = false;
				
				//echo 'count:'.$count;
				
				if( $count == 0  )
				{
					
					$count = $wpdb->get_var( $wpdb->prepare( "select COUNT(*) from $table_pin_codes where `pincode` LIKE %s ", $wpdb->esc_like($pincode) .'*%' ) );
					
					$like = true;
					
					//echo 'count1:'.$count;
					
				}
				
				if( $count == 0 )
				{

				   echo "0";  

				}
				else
				{
					
					if( $like )
					{
						
						$query = "SELECT * FROM `$table_pin_codes` where pincode LIKE '".$wpdb->esc_like($pincode) ."*%'";
						
					}
					else
					{
						
						$query = "SELECT * FROM `$table_pin_codes` where pincode='$safe_zipcode'"; 
						
					}
					
					//echo $query;
					
					$ftc_ary = $wpdb->get_results($query);
					
					$dod = $ftc_ary[0]->dod;
					
					$state = $ftc_ary[0]->state;
					
					$city = $ftc_ary[0]->city;
					
					if($dod >= 1)
					{
						
						for($i=1; $i<=$dod; $i++)
						{
								$dd = date("D", strtotime("+ $i day"));
								
								if($qry22[0]['s_s'] == 0)
								{			
							
									if($dd == 'Sat')
									{	
								
										$dod++;	
									}
									
								}
								
								if($qry22[0]['s_s1'] == 0)
								{
									
									if($dd == 'Sun')
									{	
								
										$dod++;	
									}
									
								}
								
						}
						
						$delivery_date = date("D, jS M", strtotime("+ $dod day"));
						
					}
					else
					{
						
						$delivery_date = '';
						
					}
					
					
					if($ftc_ary[0]->cod == 'no')
					{
						echo "10";
						echo "####";
						if($show_d_d_on_pro == 1)
						{
							echo $delivery_date;
						}
						else
						{
							echo $ftc_ary[0]->dod." days";
						}
						echo "####";
						echo esc_html( $qry22[0]['cod_msg2'] );
						echo "####";
						echo $state;
						echo "####";
						echo $city;
									
					}
					elseif($ftc_ary[0]->cod == 'yes')
					{
						echo "11";
						echo "####";
						if($show_d_d_on_pro == 1)
						{
							echo $delivery_date;
						}
						else
						{
							echo $ftc_ary[0]->dod." days";
						}
						echo "####";
						echo esc_html( $qry22[0]['cod_msg1'] );
						echo "####";
						echo $state;
						echo "####";
						echo $city;
					}
					
					setcookie("valid_pincode",$safe_zipcode,time() + (10 * 365 * 24 * 60 * 60),"/");
					
					$customer = new WC_Customer();
					
					$customer->set_shipping_postcode($safe_zipcode);
						
					$user_ID = get_current_user_id();
					
					if(isset($user_ID) && $user_ID != 0) {
						
						update_user_meta($user_ID, 'shipping_postcode', $safe_zipcode); //for setting shipping postcode
						
					}
					//echo "1";
				}
				
			}
			else
			{
				
				echo "0";
				
			}
			
			exit;

		}
		
		
		
		add_action( 'wp_ajax_nopriv_picodecheck_ajax_submit_check', 'picodecheck_ajax_submit_check' );
		
		add_action( 'wp_ajax_picodecheck_ajax_submit_check', 'picodecheck_ajax_submit_check' );

		function picodecheck_ajax_submit_check() {
			
				global $table_prefix, $wpdb;

				$pincode = $_COOKIE['valid_pincode'];
				
				$qry22 = $wpdb->get_results("SELECT * FROM `".$table_prefix."pincode_setting_p` ORDER BY `id` ASC  limit 1",ARRAY_A);
				
				if( $pincode != '' )
				{
					
					//echo "in";
					
					$product_id = sanitize_text_field( $_POST['product_id'] );
			
					$phen_pincodes_list = get_post_meta( $product_id, 'phen_pincode_list' );
					
					//$phen_pincode_list = $phen_pincodes_list[0];
					
					//print_r( $phen_pincode_list );
					
					$star_pincode = substr($pincode, 0, 3).'*';
					
					//$phen_pincodes_list = get_post_meta( $pro_id, 'phen_pincode_list' );
							
					if( count($phen_pincodes_list)	== 0 )
					{
						
						//$phen_pincode_list = array();
						
						//echo "else";
						//echo "Key does not exist!";
						$safe_zipcode = $pincode;
					
						$pincode = substr($pincode, 0, 3);
						
						$show_d_d_on_pro =  get_option( 'woo_pin_check_show_d_d_on_pro' );
						
						$table_pin_codes = $table_prefix."check_pincode_p";
						
						if($safe_zipcode)
						{
							
							$count = $wpdb->get_var( $wpdb->prepare( "select COUNT(*) from $table_pin_codes where `pincode` = %s ", $safe_zipcode ) );
							
							$like = false;
							
							//echo 'count:'.$count;
							
							if( $count == 0  )
							{
								
								$count = $wpdb->get_var( $wpdb->prepare( "select COUNT(*) from $table_pin_codes where `pincode` LIKE %s ", $wpdb->esc_like($pincode) .'*%' ) );
								
								$like = true;
								
								//echo 'count1:'.$count;
								
							}
							
							if( $count == 0 )
							{

							   echo "0";  

							}
							else
							{
								
								if( $like )
								{
									
									$query = "SELECT * FROM `$table_pin_codes` where pincode LIKE '".$wpdb->esc_like($pincode) ."*%'";
									
								}
								else
								{
									
									$query = "SELECT * FROM `$table_pin_codes` where pincode='$safe_zipcode'"; 
									
								}
								
								//echo $query;
								
								$ftc_ary = $wpdb->get_results($query);
								
								$dod = $ftc_ary[0]->dod;
								
								$state = $ftc_ary[0]->state;
								
								$city = $ftc_ary[0]->city;

								if($dod >= 1)
								{
									
									for($i=1; $i<=$dod; $i++)
									{
											$dd = date("D", strtotime("+ $i day"));
											
											if($qry22[0]['s_s'] == 0)
											{			
										
												if($dd == 'Sat')
												{	
											
													$dod++;	
												}
												
											}
											
											if($qry22[0]['s_s1'] == 0)
											{
												
												if($dd == 'Sun')
												{	
											
													$dod++;	
												}
												
											}
											
									}
									
									$delivery_date = date("D, jS M", strtotime("+ $dod day"));
									
								}
								else
								{
									
									$delivery_date = '';
									
								}
								
								
								if($ftc_ary[0]->cod == 'no')
								{
									echo "10";
									echo "####";
									if($show_d_d_on_pro == 1)
									{
										echo $delivery_date;
									}
									else
									{
										echo $ftc_ary[0]->dod." days";
									}
									echo "####";
									echo esc_html( $qry22[0]['cod_msg2'] );
									echo "####";
									echo $state;
									echo "####";
									echo $city;
												
								}
								elseif($ftc_ary[0]->cod == 'yes')
								{
									echo "11";
									echo "####";
									if($show_d_d_on_pro == 1)
									{
										echo $delivery_date;
									}
									else
									{
										echo $ftc_ary[0]->dod." days";
									}
									echo "####";
									echo esc_html( $qry22[0]['cod_msg1'] );
									echo "####";
									echo $state;
									echo "####";
									echo $city;
								}
								setcookie("valid_pincode",$safe_zipcode,time() + (10 * 365 * 24 * 60 * 60),"/");
								
								$customer = new WC_Customer();
					
								$customer->set_shipping_postcode($safe_zipcode);
									
								$user_ID = get_current_user_id();
								
								if(isset($user_ID) && $user_ID != 0) {
									
									update_user_meta($user_ID, 'shipping_postcode', $safe_zipcode); //for setting shipping postcode
									
								}
								
								//echo "1";
							}
							
						}
						else
						{
							
							echo "0";
							
						}
						
					}
					else
					{
						
						$phen_pincode_list = $phen_pincodes_list[0];
						
						if ( array_key_exists( $wpdb->esc_like($pincode),$phen_pincode_list ) )
						{
							
							//echo "if";
							
							$safe_zipcode = $pincode;
						
							$dod = $phen_pincode_list[$safe_zipcode][3];
							
							$state = $phen_pincode_list[$safe_zipcode][2];
							
							$city = $phen_pincode_list[$safe_zipcode][1];
							
							$show_d_d_on_pro =  get_option( 'woo_pin_check_show_d_d_on_pro' );	
							
							if($dod >= 1)
							{
								
								for($i=1; $i<=$dod; $i++)
								{
										$dd = date("D", strtotime("+ $i day"));
										
										if($qry22[0]['s_s'] == 0)
										{			
									
											if($dd == 'Sat')
											{	
										
												$dod++;	
											}
											
										}
										
										if($qry22[0]['s_s1'] == 0)
										{
											
											if($dd == 'Sun')
											{	
										
												$dod++;	
											}
											
										}
										
								}
								
								$delivery_date = date("D, jS M", strtotime("+ $dod day"));
								
							}
							else
							{
								
								$delivery_date = '';
								
							}
							
							
							if($phen_pincode_list[$safe_zipcode][4] == 'no')
							{
								echo "10";
								echo "####";
								if($show_d_d_on_pro == 1)
								{
									echo $delivery_date;
								}
								else
								{
									echo $phen_pincode_list[$safe_zipcode][3]." days";
								}
								echo "####";
								echo esc_html( $qry22[0]['cod_msg2'] );
								echo "####";
								echo $state;
								echo "####";
								echo $city;
											
							}
							elseif($phen_pincode_list[$safe_zipcode][4] == 'yes')
							{
								echo "11";
								echo "####";
								if($show_d_d_on_pro == 1)
								{
									echo $delivery_date;
								}
								else
								{
									echo $phen_pincode_list[$safe_zipcode][3]." days";
								}
								echo "####";
								echo esc_html( $qry22[0]['cod_msg1'] );
								echo "####";
								echo $state;
								echo "####";
								echo $city;
							}
							
							setcookie("valid_pincode",$safe_zipcode,time() + (10 * 365 * 24 * 60 * 60),"/");
							
							$customer = new WC_Customer();
					
							$customer->set_shipping_postcode($safe_zipcode);
								
							$user_ID = get_current_user_id();
							
							if(isset($user_ID) && $user_ID != 0) {
								
								update_user_meta($user_ID, 'shipping_postcode', $safe_zipcode); //for setting shipping postcode
								
							}
							
						}
						elseif( array_key_exists(  $star_pincode,$phen_pincode_list ) )
						{
								
							//echo "elseif";
							
							$safe_zipcode = $pincode;
						
							$dod = $phen_pincode_list[$star_pincode][3];
							
							$state = $phen_pincode_list[$star_pincode][2];
							
							$city = $phen_pincode_list[$star_pincode][1];
							
							$show_d_d_on_pro =  get_option( 'woo_pin_check_show_d_d_on_pro' );

							if($dod >= 1)
							{
								
								for($i=1; $i<=$dod; $i++)
								{
										$dd = date("D", strtotime("+ $i day"));
										
										if($qry22[0]['s_s'] == 0)
										{			
									
											if($dd == 'Sat')
											{	
										
												$dod++;	
											}
											
										}
										
										if($qry22[0]['s_s1'] == 0)
										{
											
											if($dd == 'Sun')
											{	
										
												$dod++;	
											}
											
										}
										
								}
								
								$delivery_date = date("D, jS M", strtotime("+ $dod day"));
								
							}
							else
							{
								
								$delivery_date = '';
								
							}
							
							
							if($phen_pincode_list[$star_pincode][4] == 'no')
							{
								echo "10";
								echo "####";
								if($show_d_d_on_pro == 1)
								{
									echo $delivery_date;
								}
								else
								{
									echo $phen_pincode_list[$star_pincode][3]." days";
								}
								echo "####";
								echo esc_html( $qry22[0]['cod_msg2'] );
								echo "####";
								echo $state;
								echo "####";
								echo $city;
											
							}
							elseif($phen_pincode_list[$star_pincode][4] == 'yes')
							{
								echo "11";
								echo "####";
								if($show_d_d_on_pro == 1)
								{
									echo $delivery_date;
								}
								else
								{
									echo $phen_pincode_list[$star_pincode][3]." days";
								}
								echo "####";
								echo esc_html( $qry22[0]['cod_msg1'] );
								echo "####";
								echo $state;
								echo "####";
								echo $city;
							}
							
							setcookie("valid_pincode",$safe_zipcode,time() + (10 * 365 * 24 * 60 * 60),"/");
							
							$customer = new WC_Customer();
					
							$customer->set_shipping_postcode($safe_zipcode);
								
							$user_ID = get_current_user_id();
							
							if(isset($user_ID) && $user_ID != 0) {
								
								update_user_meta($user_ID, 'shipping_postcode', $safe_zipcode); //for setting shipping postcode
								
							}
						
						}
						else
						{
							
							echo "0";
							
						}
						
					}

				}
				else
				{
					
					echo "0";
					
				}
				
				exit;

		}
		
		
		
		add_action( 'wp_ajax_nopriv_picodecheck_ajax_submit', 'picodecheck_ajax_submit' );
		
		add_action( 'wp_ajax_picodecheck_ajax_submit', 'picodecheck_ajax_submit' );

		function picodecheck_ajax_submit() {
			
			// get the submitted parameters
			//$pin_code = $_POST['pin_code'];

			global $table_prefix, $wpdb;
			
			$pincode = sanitize_text_field( $_POST['pin_code'] );
			
			$product_id = sanitize_text_field( $_POST['product_id'] );
			
			$phen_pincodes_list = get_post_meta( $product_id, 'phen_pincode_list' );
			
			//print_r( $phen_pincodes_list );
			
			$phen_pincode_list = $phen_pincodes_list[0];
			
			//print_r( $phen_pincode_list );
			
			$star_pincode = substr($pincode, 0, 3).'*';
			
			//$phen_pincodes_list = get_post_meta( $pro_id, 'phen_pincode_list' );
			
			$qry22 = $wpdb->get_results("SELECT * FROM `".$table_prefix."pincode_setting_p` ORDER BY `id` ASC  limit 1",ARRAY_A);
					
			if( count($phen_pincode_list) == 0 )
			{
				
				//$phen_pincode_list = array();
				
				$safe_zipcode = $pincode;
			
				$pincode = substr($pincode, 0, 3);
				
				$show_d_d_on_pro =  get_option( 'woo_pin_check_show_d_d_on_pro' );
				
				$table_pin_codes = $table_prefix."check_pincode_p";
				
				//$qry22 = $wpdb->get_results("SELECT * FROM `".$table_prefix."pincode_setting_p` ORDER BY `id` ASC  limit 1",ARRAY_A);

				if($safe_zipcode)
				{
					
					$count = $wpdb->get_var( $wpdb->prepare( "select COUNT(*) from $table_pin_codes where `pincode` = %s ", $safe_zipcode ) );
					
					$like = false;
					
					//echo 'count:'.$count;
					
					if( $count == 0  )
					{
						
						$count = $wpdb->get_var( $wpdb->prepare( "select COUNT(*) from $table_pin_codes where `pincode` LIKE %s ", $wpdb->esc_like($pincode) .'*%' ) );
						
						$like = true;
						
						//echo 'count1:'.$count;
						
					}
					
					if( $count == 0 )
					{

					   echo "0";  

					}
					else
					{
						
						if( $like )
						{
							
							$query = "SELECT * FROM `$table_pin_codes` where pincode LIKE '".$wpdb->esc_like($pincode) ."*%'";
							
						}
						else
						{
							
							$query = "SELECT * FROM `$table_pin_codes` where pincode='$safe_zipcode'"; 
							
						}
						
						//echo $query;
						
						$ftc_ary = $wpdb->get_results($query);
						
						$dod = $ftc_ary[0]->dod;
						
						$state = $ftc_ary[0]->state;
						
						$city = $ftc_ary[0]->city;
							
						if($dod >= 1)
						{
							
							for($i=1; $i<=$dod; $i++)
							{
									$dd = date("D", strtotime("+ $i day"));
									
									if($qry22[0]['s_s'] == 0)
									{			
								
										if($dd == 'Sat')
										{	
									
											$dod++;	
										}
										
									}
									
									if($qry22[0]['s_s1'] == 0)
									{
										
										if($dd == 'Sun')
										{	
									
											$dod++;	
										}
										
									}
									
							}
							
							$delivery_date = date("D, jS M", strtotime("+ $dod day"));
							
						}
						else
						{
							
							$delivery_date = '';
							
						}
						
						
						if($ftc_ary[0]->cod == 'no')
						{
							echo "10";
							echo "####";
							if($show_d_d_on_pro == 1)
							{
								echo $delivery_date;
							}
							else
							{
								echo $ftc_ary[0]->dod." days";
							}
							echo "####";
							echo esc_html( $qry22[0]['cod_msg2'] );
							echo "####";
							echo $state;
							echo "####";
							echo $city;
										
						}
						elseif($ftc_ary[0]->cod == 'yes')
						{
							echo "11";
							echo "####";
							if($show_d_d_on_pro == 1)
							{
								echo $delivery_date;
							}
							else
							{
								echo $ftc_ary[0]->dod." days";
							}
							echo "####";
							echo esc_html( $qry22[0]['cod_msg1'] );
							echo "####";
							echo $state;
							echo "####";
							echo $city;
						}
						
						setcookie("valid_pincode",$safe_zipcode,time() + (10 * 365 * 24 * 60 * 60),"/");
						
						$customer = new WC_Customer();
				
						$customer->set_shipping_postcode($safe_zipcode);
							
						$user_ID = get_current_user_id();
						
						if(isset($user_ID) && $user_ID != 0) {
							
							update_user_meta($user_ID, 'shipping_postcode', $safe_zipcode); //for setting shipping postcode
							
						}
						//echo "1";
					}
					
				}
				else
				{
					
					echo "0";
					
				}
				
			}
			else
			{
				
				$phen_pincode_list = $phen_pincodes_list[0];
				
				if ( array_key_exists( $wpdb->esc_like($pincode),$phen_pincode_list ) )
				{
					
					//echo "if";
				
					$safe_zipcode = $pincode;
				
					$dod = $phen_pincode_list[$safe_zipcode][3];
					
					$state = $phen_pincode_list[$safe_zipcode][2];
					
					$city = $phen_pincode_list[$safe_zipcode][1];
					
					$show_d_d_on_pro =  get_option( 'woo_pin_check_show_d_d_on_pro' );
					
					if($dod >= 1)
					{
						
						for($i=1; $i<=$dod; $i++)
						{
								$dd = date("D", strtotime("+ $i day"));
								
								if($qry22[0]['s_s'] == 0)
								{			
							
									if($dd == 'Sat')
									{	
								
										$dod++;	
									}
									
								}
								
								if($qry22[0]['s_s1'] == 0)
								{
									
									if($dd == 'Sun')
									{	
								
										$dod++;	
									}
									
								}
								
						}
						
						$delivery_date = date("D, jS M", strtotime("+ $dod day"));
						
					}
					else
					{
						
						$delivery_date = '';
						
					}
					
					
					if($phen_pincode_list[$safe_zipcode][4] == 'no')
					{
						echo "10";
						echo "####";
						if($show_d_d_on_pro == 1)
						{
							echo $delivery_date;
						}
						else
						{
							echo $phen_pincode_list[$safe_zipcode][3]." days";
						}
						echo "####";
						echo esc_html( $qry22[0]['cod_msg2'] );
						echo "####";
						echo $state;
						echo "####";
						echo $city;
									
					}
					elseif($phen_pincode_list[$safe_zipcode][4] == 'yes')
					{
						echo "11";
						echo "####";
						if($show_d_d_on_pro == 1)
						{
							echo $delivery_date;
						}
						else
						{
							echo $phen_pincode_list[$safe_zipcode][3]." days";
						}
						echo "####";
						echo esc_html( $qry22[0]['cod_msg1'] );
						echo "####";
						echo $state;
						echo "####";
						echo $city;
					}
					
					setcookie("valid_pincode",$safe_zipcode,time() + (10 * 365 * 24 * 60 * 60),"/");
					
					$customer = new WC_Customer();
			
					$customer->set_shipping_postcode($safe_zipcode);
						
					$user_ID = get_current_user_id();
					
					if(isset($user_ID) && $user_ID != 0) {
						
						update_user_meta($user_ID, 'shipping_postcode', $safe_zipcode); //for setting shipping postcode
						
					}
					
				}
				elseif( array_key_exists(  $star_pincode,$phen_pincode_list ) )
				{
					
					//echo "elseif";
					
					$safe_zipcode = $pincode;
				
					$dod = $phen_pincode_list[$star_pincode][3];
					
					$state = $phen_pincode_list[$star_pincode][2];
					
					$city = $phen_pincode_list[$star_pincode][1];
					
					$show_d_d_on_pro =  get_option( 'woo_pin_check_show_d_d_on_pro' );
					
					if($dod >= 1)
					{
						
						for($i=1; $i<=$dod; $i++)
						{
								$dd = date("D", strtotime("+ $i day"));
								
								if($qry22[0]['s_s'] == 0)
								{			
							
									if($dd == 'Sat')
									{	
								
										$dod++;	
									}
									
								}
								
								if($qry22[0]['s_s1'] == 0)
								{
									
									if($dd == 'Sun')
									{	
								
										$dod++;	
									}
									
								}
								
						}
						
						$delivery_date = date("D, jS M", strtotime("+ $dod day"));
						
					}
					else
					{
						
						$delivery_date = '';
						
					}
					
					
					if($phen_pincode_list[$star_pincode][4] == 'no')
					{
						echo "10";
						echo "####";
						if($show_d_d_on_pro == 1)
						{
							echo $delivery_date;
						}
						else
						{
							echo $phen_pincode_list[$star_pincode][3]." days";
						}
						echo "####";
						echo esc_html( $qry22[0]['cod_msg2'] );
						echo "####";
						echo $state;
						echo "####";
						echo $city;
									
					}
					elseif($phen_pincode_list[$star_pincode][4] == 'yes')
					{
						echo "11";
						echo "####";
						if($show_d_d_on_pro == 1)
						{
							echo $delivery_date;
						}
						else
						{
							echo $phen_pincode_list[$star_pincode][3]." days";
						}
						echo "####";
						echo esc_html( $qry22[0]['cod_msg1'] );
						echo "####";
						echo $state;
						echo "####";
						echo $city;
					}
					
					setcookie("valid_pincode",$safe_zipcode,time() + (10 * 365 * 24 * 60 * 60),"/");
					
					$customer = new WC_Customer();
			
					$customer->set_shipping_postcode($safe_zipcode);
						
					$user_ID = get_current_user_id();
					
					if(isset($user_ID) && $user_ID != 0) {
						
						update_user_meta($user_ID, 'shipping_postcode', $safe_zipcode); //for setting shipping postcode
						
					}
				
				}
				else
				{
					
					echo "0";
					
				}
				
			}
				
			//print_r(array_key_exists($star_pincode,$phen_pincode_list));

			exit;

		}

		
		add_action( 'wp_ajax_nopriv_picodecheck_ajax_submit_out', 'picodecheck_ajax_submit_out' );
		
		add_action( 'wp_ajax_picodecheck_ajax_submit_out', 'picodecheck_ajax_submit_out' );
		
		function picodecheck_ajax_submit_out() {
			
			// get the submitted parameters
			
			global $table_prefix, $wpdb,$woocommerce;
			
			$cookie_pin = $_COOKIE['valid_pincode'];
			
			$pin_code = $_POST['pin_code'];
			
			if( $pin_code == '' )
			{
				
				$pin_code = $cookie_pin;
				
			}
			
			$show_error =  0;
			
			$cod_count = 0;
			
			$cod = '';
			
			$star_pincode = substr($pin_code, 0, 3).'*';
			 
			if(isset($pin_code))
			{
				
				$items = $woocommerce->cart->get_cart();

				$product_count = count($items);
				
				$phen_pincode_list = array();
				
				foreach($items as $item => $values) {
		
					$_product_id = $values['product_id'];
					
					$phen_pincodes_list = get_post_meta( $_product_id, 'phen_pincode_list' );
					
					$safe_zipcode = $pin_code;
					
					if( count($phen_pincodes_list)	== 0 )
					{
						
						//echo "else";
						$pincode = substr($pin_code, 0, 3);
						
						//$show_d_d_on_pro =  get_option( 'woo_pin_check_show_d_d_on_pro' );
						
						$table_pin_codes = $table_prefix."check_pincode_p";
						
						if($safe_zipcode)
						{
							
							$count = $wpdb->get_var( $wpdb->prepare( "select COUNT(*) from $table_pin_codes where `pincode` = %s ", $safe_zipcode ) );
							
							$like = false;
							
							//echo 'count:'.$count;
							
							if( $count == 0  )
							{
								
								$count = $wpdb->get_var( $wpdb->prepare( "select COUNT(*) from $table_pin_codes where `pincode` LIKE %s ", $wpdb->esc_like($pincode) .'*%' ) );
								
								$like = true;
								
								//echo 'count1:'.$count;
								
							}
							
							if( $count == 0 )
							{

							   //echo "0";  
							   $show_error++;

							}
							else
							{
								
								if( $like )
								{
									
									$query = "SELECT * FROM `$table_pin_codes` where pincode LIKE '".$wpdb->esc_like($pincode) ."*%'";
									
								}
								else
								{
									
									$query = "SELECT * FROM `$table_pin_codes` where pincode='$safe_zipcode'"; 
									
								}
								
								//echo $query;
								
								$ftc_ary = $wpdb->get_results($query);
								
								$show_errors =  count($ftc_ary);
								
								if($show_errors == 0)
								{
									
									$show_error++;
									
								}
								else
								{
									
									$cod = $ftc_ary[0]->cod;
									
									if($cod == 'yes')
									{
										
										$cod_count++;
										
									}
									
								}

							}

						}
						
					}
					else
					{
						
						$phen_pincode_list = $phen_pincodes_list[0];
				
						//print_r($phen_pincode_list);

						if ( array_key_exists( $wpdb->esc_like($pin_code),$phen_pincode_list ) )
						{
							
							//echo 'in';
							
							$cod = $phen_pincode_list[$safe_zipcode][4];

							//print_r($phen_pincode_list[$safe_zipcode]);
							
							//$show_error++;
							if($cod == 'yes')
							{
								
								$cod_count++;
								
							}
							
						}
						elseif( array_key_exists(  $star_pincode,$phen_pincode_list ) )
						{
							
							//echo "elseif";
		
							$cod = $phen_pincode_list[$star_pincode][4];
							//$show_error++;
							
							if($cod == 'yes')
							{
								
								$cod_count++;
								
							}
							
						}
						else
						{
							
							$show_error++;
							
						}
						
					}
					
				}

			}
			
			//$return["json"]['cod'] =  $cod;
			
			/* echo $product_count;
			
			echo $cod_count; */
			
			if( $product_count == $cod_count )
			{
				
				$return["json"]['cod'] =  'yes';
				
			}
			else
			{
				
				$return["json"]['cod'] =  'no';
				
			}
			
			$return["json"]['error'] =  $show_error;
							
			echo json_encode($return);	  
		
			exit;
		}
		
		add_shortcode("phoeniixx-pincode-check","phoe_pincode_check");

		add_filter( 'widget_text', 'shortcode_unautop');

		add_filter('widget_text', 'do_shortcode');

		add_action('wp_head','hook_css'); //for adding dynamic css in wp head
		
		function hook_css() {
			
			global $table_prefix, $wpdb, $woocommerce;
			
			$blog_title = site_url();
			
			$plugin_dir_url =  plugin_dir_url( __FILE__ );
			
			$qry22 = $wpdb->get_results( "SELECT * FROM `".$table_prefix."pincode_setting_p` ORDER BY `id` ASC  limit 1" ,ARRAY_A);	
			
			$bgcolor =  $qry22[0]['bgcolor'];
			
			$textcolor =  $qry22[0]['textcolor'];
			
			$bordercolor = $qry22[0]['bordercolor'];
			
			$buttoncolor = $qry22[0]['buttoncolor'];
			
			$buttontcolor = $qry22[0]['buttontcolor'];
			
			$ttbordercolor = $qry22[0]['ttbordercolor'];
			
			$ttbagcolor = $qry22[0]['ttbagcolor'];
			
			$tttextcolor = $qry22[0]['tttextcolor'];
			
			$devbytcolor = $qry22[0]['devbytcolor'];
			
			$codtcolor = $qry22[0]['codtcolor'];
			
			$datecolor = $qry22[0]['datecolor'];
			
			$codmsgcolor = $qry22[0]['codmsgcolor'];
			
			$errormsgcolor = $qry22[0]['errormsgcolor'];

			if(isset($_COOKIE['valid_pincode']))
			{
				
				$cookie_pin = $_COOKIE['valid_pincode'];
				
			}
		
			$auto_pch = get_option( 'auto_load_popup' );
			
			$auto_pchs = get_option( 'auto_load_popup_shop_cat' );

			$auto_pch_v = get_option( 'auto_load_validate' );

			$auto_pch_bu = get_option( 'auto_load_block' );
			
			$pincode_length = get_option('pincode_length');
			
			$del_info_text = get_option('woo_pin_check_del_info_text');
			
			$del_place_holder_text = get_option('woo_pin_check_place_holder_info_text');
			
			if( $auto_pch_bu == 1 && !isset($cookie_pin) && !is_front_page() )
			{
				
				header("Location: $blog_title");
				
			}
			
			if( $auto_pch == 1 ) {
				
				if( is_front_page() && !isset($cookie_pin) )
				{
					
					$sty_dis = "block";
					
				}
				else
				{
					
					$sty_dis = "none";
					
				}
			
			}
			else
			{
				
				$sty_dis = "none";
				
			}
			
			
			//echo $sty_dis;
			
			//if( !isset($cookie_pin) && $auto_pch == 1 ) {
			
			?>
			<script>
				
				jQuery(document).ready(function(){
					
					
					jQuery('.phoen-cod-html-div').html(jQuery('.payment_method_cod').html());
					
				});
			
			</script>
			
			<div class="phoen-cod-html-div" style="display:none;">
				<!--<input id="payment_method_cod" class="input-radio" name="payment_method" value="cod" data-order_button_text="" type="radio">

				<label for="payment_method_cod">Cash on Delivery 	</label>
				<div class="payment_box payment_method_cod" style="display:none;">
					<p>Pay with cash upon delivery.</p>
				</div>-->
			</div>
			<div class="phoen-place-order-html-div" style="display:none;">
				<input type="submit" data-value="Place order" value="Place order" id="place_order" name="woocommerce_checkout_place_order" class="button alt">
			</div>
			<script>
				
				var cod_msg1 = "<?php echo $qry22[0]['cod_msg1'];?>";
				
				var cod_msg2 = "<?php echo $qry22[0]['cod_msg2'];?>";
				
				var right_image = "<?php echo esc_url( $plugin_dir_url ).'assets/img/Phoeniixx_Pin_green_tick.jpg'; ?>";
				
				var not_avail = "<?php echo esc_url( $plugin_dir_url ).'assets/img/phoeniixx_pin_cross.jpg'; ?>";
				
				var show_pincode_popup = "<?php echo $sty_dis;?>";
				
				var valid_cookie_pin = "<?php echo $cookie_pin;?>";
				
				//console.log('hello'+valid_cookie_pin);
				
				jQuery(document).ready(function(){
					
					if( (show_pincode_popup != 'none') && (valid_cookie_pin === '')){
						
						jQuery('.pho-popup-body').fadeIn();
						
						jQuery('.phoen_chk_pncde_anmt_div').addClass(woocommerce_pincode_params.entrance);
						
						setTimeout(function(){
								
								jQuery('.phoen_chk_pncde_anmt_div').removeClass(woocommerce_pincode_params.entrance);
						
							}, 2500);
						
						
					}else{
						setTimeout(function(){
								
							jQuery('.pho-popup-body').hide();
						
						}, 100);
						
					}					
					
					
					jQuery(".pho-close_btn").click( function(e) {
						
						jQuery('.phoen_chk_pncde_anmt_div').addClass(woocommerce_pincode_params.exit);
												
							setTimeout(function(){
																	
								jQuery('.pho-popup-body').hide();
								
								jQuery('.phoen_chk_pncde_anmt_div').removeClass(woocommerce_pincode_params.exit);
						
							}, 2500);
							
						
					});
					
					
					jQuery(".pho-close_btn_shop").click( function(e) {
						
						jQuery('.phoen_chk_pncde_anmt_div').addClass(woocommerce_pincode_params.exit);
												
							setTimeout(function(){
																	
								jQuery('.pho-popup-body-shop').hide();
								
								jQuery('.phoen_chk_pncde_anmt_div').removeClass(woocommerce_pincode_params.exit);
						
							}, 2500);
							
						
					});
					
					jQuery("#pincode_field_idp #checkpin").click( function(e) {
						
						jQuery('.delivery-info').removeClass(woocommerce_pincode_params.info_exit);
						
						jQuery('.delivery-info').addClass(woocommerce_pincode_params.info);
							
					});
					
					jQuery("#change_pin").click( function(e) {
						
						jQuery('.delivery-info').removeClass(woocommerce_pincode_params.info);
						
						jQuery('.animated').addClass(woocommerce_pincode_params.info_exit);
							
					});
					
				});
				
			</script>
			
				<div class="pho-popup-body" style="display:none;" >
					
					<div class="phoen-popup-div phoen_chk_pncde_anmt_div animated">
					
						<div class="pho-popup ">
						
								<div class="pho-close_btn" style="display:<?php echo ($auto_pch_v == 1)?"block":'none';?>"> &#10005; </div>
									
								<div class="pho-icon">
								
									<img alt="icon" src="<?php echo $plugin_dir_url; ?>/assets/img/icon.jpg" />
										
										<div class="pho-para">
										
											<p><?php echo $del_info_text; ?> </p>
											
										</div>
										
								</div>
							
								<div class="pho-separator"></div>

								<form data-siteurl="<?php echo site_url(); ?>" id="pho_home_pck" action="<?php echo admin_url( 'admin-ajax.php' ); ?>" method="post" class="pho-option-form"> 
								
									<div class="pho-pincode">
									
										<input type="text" id="enter_pincode" name="enter_pincode" maxlength="<?php echo $pincode_length; ?>" placeholder="<?php echo $del_place_holder_text;?>" />
										
										<input type="hidden" id="cookie_pin" name="cookie_pin" value="<?php echo $cookie_pin; ?>" />
							
										<input type="submit" value="SUBMIT" class="pho-submit_btn">
										
										<span id="home_chkpin_loader" style="display:none">
							
											<img alt="ajax-loader" src="<?php echo esc_url( $plugin_dir_url ); ?>assets/img/ajax-loader.gif"/>
											
										</span>
										
									</div>
									
									<span id="chkpin_loaderr">
										
											<!--<img src="<?php echo esc_url( $plugin_dir_url ); ?>assets/img/ajax-loader.gif"/>-->
											
											<div class="error_pinn" id="error_pinn" style="display:none"><?php if($qry22[0]['error_msg'] != '' ){ echo esc_html( $qry22[0]['error_msg'] ); }else{ echo "Invalid pincode entered"; } ?></div>
											
												<?php
										
													$error_msg_b =  get_option( 'woo_pin_check_error_msg_b' );
												
												?>
											
											<div class="error_pin" id="error_pin_bn" style="display:none"><?php echo $error_msg_b;  ?></div>
											
									</span>
									
								</form>
							
						</div> <!-- popup class end -->
						
					</div>	

				</div>
				
				<?php
				
				if( is_shop() || is_product_category() )
				{
				
					?>			
					
					<div class="pho-popup-body pho-popup-body-shop" style="display:none" >
						
						<div class="phoen-popup-div phoen_chk_pncde_anmt_div animated">
						
							<div class="pho-popup ">
							
								<?php
								
								if($auto_pch_v ==  1)
								{
								
									?>
									
										<div  class="pho-close_btn pho-close_btn_shop"> &#10005; </div>
										
									<?php
								
								}
								
								?>	
									<div class="pho-icon">
									
										<img alt="icon" src="<?php echo $plugin_dir_url; ?>/assets/img/icon.jpg" />
											
											<div class="pho-para">
											
												<p> Get item availability info & delivery time for your location. </p>
												
											</div>
											
									</div>
								
									<div class="pho-separator"></div>

									<form id="pho_home_pck_shop" data-siteurl="<?php echo site_url(); ?>" action="<?php echo admin_url( 'admin-ajax.php' ); ?>" method="post" class="pho-option-form"> 
									
										<div class="pho-pincode">
										
											<input type="text" id="enter_pincode_shop" name="enter_pincode" maxlength="<?php echo $pincode_length; ?>" placeholder="Enter Pincode" />
											
											<input type="hidden" id="cookie_pin_shop" name="cookie_pin" value="<?php echo $cookie_pin; ?>" />
											
											<input type="hidden" id="popup_pro_id_shop" name="popup_pro_id" value="" />
								
											<input type="submit" value="SUBMIT" class="pho-submit_btn" id="pho-submit_btn_shop">
											
											<span id="shop_chkpin_loader" style="display:none">
							
												<img alt="ajax-loader" src="<?php echo esc_url( $plugin_dir_url ); ?>assets/img/ajax-loader.gif"/>
												
											</span>
											
										</div>
										
										<span id="chkpin_loader_shop">
											
												<!--<img src="<?php echo esc_url( $plugin_dir_url ); ?>assets/img/ajax-loader.gif"/>-->
												
												<div class="error_pin_shop" id="error_pin_shop" style="display:none"><?php if($qry22[0]['error_msg'] != '' ){ echo esc_html( $qry22[0]['error_msg'] ); }else{ echo "Invalid pincode entered"; } ?></div>
												
													<?php
											
														$error_msg_b =  get_option( 'woo_pin_check_error_msg_b' );
													
													?>
												
												<div class="error_pin" id="error_pin_b_shop" style="display:none"><?php echo $error_msg_b;  ?></div>
												
										</span>
										
										<input type="hidden" id="siteurl_shop" value="<?php echo site_url(); ?>" />

									</form>
								
							</div> <!-- popup class end -->
							
						</div>	

					</div>
					
					<?php
					
				}
			
			//	}
			
			if( $auto_pchs == 1 )
			{
				
				?>
				
				<script>
				
					jQuery(document).ready(function($){
							
						if( jQuery('.ajax_add_to_cart').length > 0 )
						{
					
							jQuery(".ajax_add_to_cart").click( function(e) {
								
								$this = jQuery(this);
								
								var is_purchasable =   $this.closest('li').hasClass( "purchasable" );
								
								var is_downloadable =   $this.closest('li').hasClass( "downloadable" );
								
								var is_virtual =   $this.closest('li').hasClass( "virtual" );
								
								var product_id = $this.data('product_id');
								
								if(is_purchasable == true && is_downloadable == false && is_virtual == false)
								{	
								
									jQuery.ajax({
										url : MyAjax.ajaxurl,
										type : 'post',
										data : {
										action :  'picodecheck_ajax_submit_check',
										product_id : product_id
										},
										success : function( response ) 
										{
											
											var result = response.split("####");
											
											console.log( result );
											
											if( result[0] == 11 || result[0] == 10 )
											{
												
												var data_cart = {
													
													product_sku: $this.attr( 'data-product_sku' ),
													
													product_id: $this.attr( 'data-product_id' ),
													
													quantity: $this.attr( 'data-quantity' ),
													
												};
												
												var this_page = window.location.toString();

												this_page = this_page.replace( 'add-to-cart', 'added-to-cart' );
							
												console.log( $this );
												
												$this.removeClass( 'added' );
						
												$this.addClass( 'loading' );

												jQuery.post( jQuery('#siteurl_shop').val()+'/shop/?wc-ajax=add_to_cart', data_cart, function( response ) {
													
													if ( response.error && response.product_url ) {
														
														window.location = response.product_url;
														
														return;
														
													}
													
													  // Redirect to cart option
														if ( wc_add_to_cart_params.cart_redirect_after_add === 'yes' ) {

															window.location = wc_add_to_cart_params.cart_url;
															
															return;

														} 
														else
														{

															$this.removeClass( 'loading' );

															fragments = response.fragments;
															
															cart_hash = response.cart_hash;

															// Block fragments class
															if ( fragments ) {
																
																$.each( fragments, function( key, value ) {
																	
																	$( key ).addClass( 'updating' );
																	
																});
																
															}

															// Block widgets and fragments
															$( '.shop_table.cart, .updating, .cart_totals' ).fadeTo( '400', '0.6' ).block({ message: null, overlayCSS: { background: 'transparent url(' + wc_add_to_cart_params.ajax_loader_url + ') no-repeat center', backgroundSize: '16px 16px', opacity: 0.6 } } );

															// Changes button classes
															$this.addClass( 'added' );

															// View cart text
															if ( ! wc_add_to_cart_params.is_cart && $this.parent().find( '.added_to_cart' ).size() === 0 ) {
																
																$this.after( ' <a class="added_to_cart wc-forward" title="' + wc_add_to_cart_params.i18n_view_cart + '" href="' + wc_add_to_cart_params.cart_url + '">' + wc_add_to_cart_params.i18n_view_cart + '</a>' );
															
															}

															// Replace fragments
															if ( fragments ) {
																
																$.each( fragments, function( key, value ) {
																	
																	$( key ).replaceWith( value );
																	
																});
																
															}

															// Unblock
															$( '.widget_shopping_cart, .updating' ).stop( true ).css( 'opacity', '1' ).unblock();

															// Cart page elements
															$( '.shop_table.cart' ).load( this_page + ' .shop_table.cart:eq(0) > *', function() {

																$( 'div.quantity:not(.buttons_added), td.quantity:not(.buttons_added)' ).addClass( 'buttons_added' ).append( '<input id="add1" class="plus" type="button" value="+" />' ).prepend( '<input id="minus1" class="minus" type="button" value="-" />' );

																$( '.shop_table.cart' ).stop( true ).css( 'opacity', '1' ).unblock();

																$( 'body' ).trigger( 'cart_page_refreshed' );
																
															});

															$( '.cart_totals' ).load( this_page + ' .cart_totals:eq(0) > *', function() {
																
																$( '.cart_totals' ).stop( true ).css( 'opacity', '1' ).unblock();
																
															});

															// Trigger event so themes can refresh other areas
															$( 'body' ).trigger( 'added_to_cart', [ fragments, cart_hash ] );
														}
													
												  //console.log( "Data Loaded: " + response );
												  
												});
																					
											}
											else
											{

												jQuery('#popup_pro_id_shop').val(product_id);
												
												jQuery('.pho-popup-body-shop').fadeIn();
												
												jQuery('.phoen_chk_pncde_anmt_div').addClass(woocommerce_pincode_params.entrance);
												
												setTimeout(function(){
													
													jQuery('.phoen_chk_pncde_anmt_div').removeClass(woocommerce_pincode_params.entrance);
											
												}, 2500);
												
												

											}
											
										},
										error: function (jqXHR, exception) {
											var msg = '';
											if (jqXHR.status === 0) {
												msg = 'Not connect.\n Verify Network.';
											} else if (jqXHR.status == 404) {
												msg = 'Requested page not found. [404]';
											} else if (jqXHR.status == 500) {
												msg = 'Internal Server Error [500].';
											} else if (exception === 'parsererror') {
												msg = 'Requested JSON parse failed.';
											} else if (exception === 'timeout') {
												msg = 'Time out error.';
											} else if (exception === 'abort') {
												msg = 'Ajax request aborted.';
											} else {
												msg = 'Uncaught Error.\n' + jqXHR.responseText;
											}
											
											console.log(msg);
											
										},
										
									});
								
									return false;
									
								}
							
							});
						
						}
						
					});
				
				</script>
				
				<?php
				
			}
			
			?>
			
			<style>
				
				form.cart{ width:100%;}
				
				form.cart #my_custom_checkout_field #pincode_field_idp label{ <?php if($textcolor == ''){ echo "color:#737070;"; } else { echo "color:$textcolor".';'; }  ?> }
				
				color:#fff;<?php if($buttoncolor == ''){ echo "background:#444446;"; } else { echo "background:$buttoncolor".';'; }  ?> padding: 6px 10px;text-transform: uppercase;  font-weight: normal;border:none;}
				
				.delivery_help_text p{font-size: 14px;<?php if($textcolor == ''){ echo "color:#737070;"; } else { echo "color:$textcolor".';'; }  ?>}
				
				.header .cash_on_delivery_help_text p{font-size: 14px;<?php if($textcolor == ''){ echo "color:#737070;"; } else { echo "color:$textcolor".';'; }  ?>}
				
				.shipping .wc-delivery-time-response .delivery-info-wrap .delivery-info{background: none repeat scroll 0 0 <?php echo $bgcolor; ?>; <?php if($bordercolor != '') { ?> border: 1px solid <?php echo $bordercolor; ?>; <?php }else { ?> border: 1px solid #e5e1e1; <?php } ?> padding:10px;text-align: center;}
				
				.woocommerce-cart .header .delivery_help_text{ <?php if($ttbagcolor == ''){ echo "background:#444446;"; } else { echo "background:$ttbagcolor".';'; }  ?> }
				
				.woocommerce-cart .header .delivery_help_text{ <?php if($ttbordercolor == ''){ echo "border:1px solid #444446;"; } else { echo "border:1px solid $buttoncolor".';'; }  ?> }
				
				.woocommerce-cart .header .delivery_help_text{ color:<?php echo $tttextcolor; ?>; }
				
				.cash_on_delivery_help_text p{font-size: 14px;<?php if($textcolor == ''){ echo "color:#737070;"; } else { echo "color:$textcolor".';'; }  ?>}
				
				.avlpin{ <?php if($bgcolor == ''){ echo "background:#f6f6f8;"; } else { echo "background:$bgcolor".';'; }  ?> }
				
				<!--.avlpin{ <?php //if($bordercolor == ''){ echo "border: 1px solid transparent;"; } else { echo "border: 1px solid $bordercolor".';'; }  ?> }-->
				
				.pin_div{ <?php if($bgcolor == ''){ echo "background:#f6f6f8;"; } else { echo "background:$bgcolor".';'; }  ?> }
				
				<!--.pin_div{ <?php //if($bordercolor == ''){ echo "border: 1px solid transparent;"; } else { echo "border: 1px solid $bordercolor".';'; }  ?> }-->
				
				.pin_div{ <?php if($errormsgcolor == ''){ echo "color:#d95252;"; } else { echo "color:$errormsgcolor".';'; }  ?> margin:24px 0 0; padding:20px; text-align:left; width:100%; display:inline-block; box-sizing:border-box;}
				
				.avlpin p{ <?php if($textcolor == ''){ echo "color:#676767;"; } else { echo "color:$textcolor".';'; }  ?> white-space: pre-wrap; display: inline-block; margin-bottom:0;}
				
				#pincode_field_idp label{<?php if($textcolor == ''){ echo "color:#666666;"; } else { echo "color:$textcolor".';'; }  ?> display: inline-block; margin-right: 5px; font-size:14px; font-weight:700; text-align:left;}
				
				#change_pin.button{ <?php if($buttoncolor == ''){ echo "background:transparent;"; } else { echo "background:$buttoncolor".';'; }  ?> }
				
				#change_pin.button{ <?php if($buttontcolor == ''){ echo "color:#ffffff;"; } else { echo "color:$buttontcolor".';'; }  ?> }
				
				#my_custom_checkout_field2 #pincode_field_idp .button{ <?php if($buttontcolor == ''){ echo "color:#ffffff;"; } else { echo "color:$buttontcolor".';'; }  ?> }
				
				#my_custom_checkout_field2 #pincode_field_idp .button{ <?php if($buttoncolor == ''){ echo "background:#444446;"; } else { echo "background:$buttoncolor".';'; }  ?> }

				.header .delivery_help_text{ <?php if($ttbagcolor == ''){ echo "background:#444446;"; } else { echo "background:$ttbagcolor".';'; }  ?> }
				
				.header .delivery_help_text{ <?php if($ttbordercolor == ''){ echo "border:1px solid #444446;"; } else { echo "border:1px solid $ttbordercolor".';'; }  ?> }
				
				.header .delivery_help_text{ <?php if($tttextcolor == ''){ echo "color:#ffffff;"; } else { echo "color:$tttextcolor".';'; }  ?> }
				
				.header .cash_on_delivery_help_text{ <?php if($ttbagcolor == ''){ echo "background:#444446;"; } else { echo "background:$ttbagcolor".';'; }  ?> }
				
				.header .cash_on_delivery_help_text{ <?php if($ttbordercolor == ''){ echo "border:1px solid #444446;"; } else { echo "border:1px solid $ttbordercolor".';'; }  ?> }
				
				.header .cash_on_delivery_help_text{ <?php if($tttextcolor == ''){ echo "color:#ffffff;"; } else { echo "color:$tttextcolor".';'; }  ?> }
				
				.delivery-info span h6{ color:<?php echo $devbytcolor;?>; }
				
				.cash-on-delivery-info h6{ color:<?php echo $codtcolor;?>; }
					
				.delivery .ul-disc li{ color:<?php echo $datecolor; ?>; }
				
				.cash-on-delivery-info .cash-on-delivery { color: <?php echo $codmsgcolor; ?>; }
				
				.err_pin{ <?php if($errormsgcolor == ''){ echo "color:#d95252;"; } else { echo "color:$errormsgcolor".';'; }  ?> }
				
				.div_pin2{ color:<?php echo $devbytcolor;?>; }
				
				/* stylesheet */

				.pho-popup {width:570px; background-color:#f6f6f8; box-shadow:0 0 10px rgba(0, 0, 0, 0.08); padding:3px 0; position:absolute; top:50%; left:50%; transform: translate(-50%, -50%); -webkit-transform: translate(-50%, -50%); }
				
				.pho-popup .pho-close_btn {text-align:right; cursor:pointer; color:#b5b5b5; font-size:18px; position:absolute; top:0; right:6px; font-family:'Roboto', sans-serif; font-weight:300;}
				
				.pho-popup .pho-icon img {width:135px; margin:0px auto 25px auto; padding:0; height:auto; max-width:100%;}
				
				.pho-popup .pho-icon {text-align:center; margin-top:15px;}
				
				.pho-popup .pho-para p {text-align:center; font-size:23px; font-style:normal; margin:0 0 30px 0; font-weight:700; padding:0 35px; line-height:28px; color:#343434; text-decoration:none; text-shadow:none;}
				
				.pho-popup .pho-separator { border-top: 1px dashed #acacac; margin: 5px auto 30px;}
				
				.pho-popup .pho-pincode {margin:10px 0; text-align:center; position:relative;}
				
				.pho-pincode span#chkpin_loader {position: absolute; right: 85px; top: 4px;}
				
				.pho-pincode span#shop_chkpin_loader {position: absolute; right: 85px; top: 4px;}
				
				.pho-pincode span#home_chkpin_loader {position: absolute; right: 85px; top: 4px;}

				.pho-popup input {vertical-align: top; box-shadow:none; outline:none; font-weight:400; box-sizing:border-box; border: 1px solid #dbd9da; border-radius:0; margin-right:-5px; box-shadow:0 none; font-size:12px; max-width:238px; width: 100%; color: #363636;display: inline-block; padding:5px 10px; margin-top:0; background:#fff url("<?php echo esc_url( $plugin_dir_url ); ?>assets/img/phoeniixx_pin_location_icon.jpg") no-repeat scroll 5px center;}
			
				.pho-popup input#enter_pincode:focus{ background-color:#fff;color: #363636; border-color:#1bbc9b;}
			
				.pho-pincode input#enter_pincode{ padding:5px 5px 5px 28px;height:35px;}
				
				.pho-pincode input#enter_pincode_shop{ padding:5px 5px 5px 28px;height:36px;}
				
				.pho-pincode input#enter_pincode_shop:focus{ background-color: #fff; border-color: #1bbc9b; color: #363636;}
			
				.pho-popup .pho-submit_btn {background:#1bbc9b; vertical-align:top; width:auto; color:#ffffff; height:35px; line-height:35px; font-size:12px; font-weight:400; font-style:normal; letter-spacing:0.5; cursor:pointer; padding:0 10px; float:none; border: #1bbc9b solid 1px;box-sizing:border-box; border-radius:0;margin-top:0;margin-bottom:0;margin-left:0;margin-right:0;}
				
				
				.pho-popup .pho-submit_btn:focus{ color:#ffffff; outline:none; box-shadow:none; border-color:#1bbc9b;padding:0 10px;}
				
				.pho-popup .pho-submit_btn:hover{ border:#1bbc9b solid 1px; box-shadow:none;}
				
				.pho-popup .pho-submit_btn:active {background:#1bbc9b; border:#1bbc9b solid 1px; color: #fff;padding: 0 10px;outline:none; box-shadow:none;}
				
				.pho-popup .pho-submit_btn:hover, 
				.pho-popup .pho-submit_btn:focus {background:#1bbc9b; color:#fff;}
				
				.pho-popup form {padding-bottom:16px;}
				
				.pho-popup .pho-select_div { border: 1px solid #dbdbdb; box-shadow:0 none; font-size:12px; height:32px; max-width:260px; width: 100%;display: inline-block; padding:5px 10px; color:#929292;}
				
				.pho-popup .pho-option-form {width:320px; margin:0 auto; box-sizing:border-box;}

				.pho-modal-box-backdrop {
					
					background: rgba(238, 238, 238, 0.75);
					
					bottom: 0;
					
					left: 0;
					
					position: absolute;
					
					right: 0;
					
					top: 0;
					
				}

				.pho-popup-body{
					
					bottom: 0;
					
					display:block;
					
					left: 0;
					
					outline: 0 none;
					
					overflow-y: auto;
					
					position: fixed;
					
					right: 0;
					
					top: 0;
					
					z-index: 99999;
					
					background-color:rgba(0, 0, 0, 0.6);
				}
				
				.phoen-popup-div {
					left: 50%;
					margin-left: -285px;
					position: absolute;
					top: 50%;
					width: 570px;
				}
				
				#my_custom_checkout_field2 #pincode_field_idp #pincode_field_id.input-text{ background:#fff url("<?php echo esc_url( $plugin_dir_url ); ?>assets/img/phoeniixx_pin_location_icon.jpg") 5px center no-repeat; background-size:auto;}
				
				#my_custom_checkout_field2 #pincode_field_idp #pincode_field_id.input-text {
					border-left: 1px solid #dadada;
					border-top: 1px solid #dadada;
					border-bottom: 1px solid #dadada;
					border-right: none;
					border-radius:0;
					box-shadow:none;
					overflow:hidden;
					text-shadow:none;
					text-decoration:none;
					box-sizing:border-box;
				}
				
				.wc-delivery-time-response .input-block{
					width:100%;
					padding-right:0;
				}
			
				#my_custom_checkout_field2 #pincode_field_idp .button {
					color:#000;
					border: 1px solid #dadada;
					height:46px;
					background:#fff url("<?php echo esc_url( $plugin_dir_url ); ?>assets/img/1467826915_ChevronRight.png") center center no-repeat;
					background-size:auto;
					padding-right:20px;
					padding-left:20px;
					padding-bottom:0;
					padding-top:0;
					border-radius:0;
					box-shadow:none;
					overflow:hidden;
					text-shadow:none;
					text-decoration:none;
					margin:0;
					box-sizing:border-box;
				}
				
				.wc-delivery-time-response .delivery-info-wrap .header {
					background-color:#fff;
					
					margin-bottom:0!important;
				}
				
				.wc-delivery-time-response .delivery-info .header .phoe-pincode-pro-tick-img {
					display:inline-block;
					vertical-align:middle;
				}
				
				.wc-delivery-time-response .delivery-info .header .phoe-pincode-pro-tick-img span{
					display:inline-block;
				}
				
				.wc-delivery-time-response {
					margin-bottom:20px;
				}
				
				.wc-delivery-time-response .delivery-info .header .phoe-pincode-pro-tick-img img {
					margin-right:10px;
					max-width:100%;
					height:auto;
					border:none;
					vertical-align:middle;
					display:inline;
					width:auto;
				}
				
				.delivery-info-wrap .header .delivery {
					line-height:14px;
				}
				
				.delivery-info-wrap .header .cash-on-delivery {
					line-height:14px;
				}
				
								
				.error_pin {
					background-color: red;
					border-radius: 5px;
					color: #fff;
					font-size: 12px;
					padding: 6px;
					position:relative;
				}
				
				.error_pin::after {
					border-color: transparent transparent red;
					border-style: solid;
					border-width: 8px;
					content: "";
					left: 8px;
					position: absolute;
					top: -15px;
				}
				
				.error_pin{animation: error 0.4s 1; }
								
				.error_pinn {
					background-color: red;
					border-radius: 5px;
					color: #fff;
					font-size: 12px;
					padding: 6px;
					position:relative;
				}
				
				.error_pinn::after {
					border-color: transparent transparent red;
					border-style: solid;
					border-width: 8px;
					content: "";
					left: 8px;
					position: absolute;
					top: -15px;
				}
				
				.error_pinn{animation: error 0.4s 1; }
				
				@keyframes error{
					0%{transform: translateX(5px); -webkit-transform: translateX(5px);}
					20%{transform: translateX(-5px); -webkit-transform: translateX(-5px);}
					40%{transform: translateX(5px); -webkit-transform: translateX(5px);}
					60%{transform: translateX(-5px); -webkit-transform: translateX(-5px);}
					80%{transform: translateX(5px); -webkit-transform: translateX(5px);}
					100%{transform: translateX(5px); -webkit-transform: translateX(5px);}

				}
				
				.pho-popup-body .error_pin {
					margin: 0 auto;
					width: 310px;
					box-sizing:border-box;
				}
				
				.error_pin_shop {
					background-color: red;
					border-radius: 5px;
					color: #fff;
					font-size: 12px;
					padding: 6px;
					position:relative;
				}
				
				.error_pin_shop::after {
					border-color: transparent transparent red;
					border-style: solid;
					border-width: 8px;
					content: "";
					left: 8px;
					position: absolute;
					top: -15px;
				}
				
				.error_pin_shop{animation: error 0.4s 1; }
				
				.wc-delivery-time-response .pincode_static_text {
					font-size:18px;
					padding:0;
					margin:0;
					text-shadow:none;
				}
				
				.wc-delivery-time-response .pincode_custom_text {
					font-weight:400;
					padding:0;
					margin:0;
				}
				
				@media only screen and (max-width:480px) {
					.pho-popup{ 
						width:320px;
					}
					
					.pho-pincode input#enter_pincode{ 
						max-width:200px; 
					}
					
					.pho-pincode input#enter_pincode_shop{ 
						max-width:200px; 
					}
					
					.pho-popup .pho-option-form {
						width:270px;
						margin-bottom:10px;
					}
									
					.pho-popup .pho-para p {
						margin-bottom:20px;
					}
					
					.pho-popup-body .error_pin {
						width:270px;
					}
					
					.pho-popup .pho-submit_btn {
						padding-left:7px;
						padding-right:7px;
					}
					
					.pho-popup .pho-icon img {
						margin-bottom:5px;
					}
					
					.pho-popup .pho-separator {
						margin-bottom:15px;
					}
					
					.pho-popup .pho-icon {
						margin-top:10px;
					}
				}
				
				@media only screen and (max-width:360px) {
					.pho-popup{ 
						width:320px;
					}
					
					.pho-pincode input#enter_pincode{ 
						max-width:200px; 
					}
					
					.pho-pincode input#enter_pincode_shop{ 
						max-width:200px; 
					}
					
					.pho-popup .pho-option-form {
						width:270px;
						margin-bottom:10px;
					}
									
					.pho-popup .pho-para p {
						margin-bottom:20px;
					}
					
					.pho-popup-body .error_pin {
						width:270px;
					}
					
					.pho-popup .pho-icon img {
						margin-bottom:25px;
					}
					
					.pho-popup .pho-separator {
						margin-bottom:30px;
					}
					
					.pho-popup .pho-icon {
						margin-top:15px;
					}
				}
				
				@media only screen and (max-width:320px) {
					.pho-popup{ 
						width:280px;
					}
					
					.pho-pincode input#enter_pincode{ 
						max-width:180px; 
					}
					
					.pho-pincode input#enter_pincode_shop{ 
						max-width:180px; 
					}
					
					.pho-popup .pho-option-form {
						width:250px;
						margin-bottom:10px;
					}
									
					.pho-popup .pho-para p {
						font-size:19px;
						line-height:25px;
					}
					
					.pho-popup-body .error_pin {
						width:250px;
					}
				}

				
			</style>
			
			<?php
		}
				
	}
	
}
?>