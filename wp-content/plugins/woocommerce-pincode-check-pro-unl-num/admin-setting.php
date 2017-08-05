<?php
global $wpdb,$table_prefix;

if( isset($_GET['action']) && sanitize_text_field( $_GET['action'] ) == 'delete-all' )
{
		
		$delete_all =  $wpdb->query(  "truncate table `".$table_prefix."check_pincode_p` "  );
		
		if($delete_all == 1)
		{
			
			?>
			
				<div id="message" class="updated">

					<p><strong>Successfully Deleted All Pincodes.</strong></p>

				</div>
				
			<?php
			
		}
		
}

wp_enqueue_script('wp-color-picker'); //for color picker scripts

wp_enqueue_style( 'wp-color-picker' );

wp_enqueue_media();  //for upload media scripts

/* Form Post Data */

if( isset($_POST['submit']) && sanitize_text_field( $_POST['submit'] ) == 'Save') {

	$del_help_text =  sanitize_text_field( $_POST['del_help_text'] );

	$cod_help_text =  sanitize_text_field( $_POST['cod_help_text'] );

	$cod_msg1 =  sanitize_text_field( $_POST['cod_msg1'] );

	$cod_msg2 =  sanitize_text_field( $_POST['cod_msg2'] );

	$error_msg =  sanitize_text_field( $_POST['error_msg'] );
	
	$success_msg_b =  sanitize_text_field( $_POST['success_msg_b'] );
	
	$error_msg_b = sanitize_text_field( $_POST['error_msg_b'] );

	$del_date =  sanitize_text_field( $_POST['del_date'] );

	$cod =  sanitize_text_field( $_POST['cod'] );
	
	$s_s =  sanitize_text_field( $_POST['s_s'] );

	$s_s1 =  sanitize_text_field( $_POST['s_s1'] );

	$cod_p =  sanitize_text_field( $_POST['cod_p'] );

	$delv_by_cart =  sanitize_text_field( $_POST['delv_by_cart'] );

	$val_checkout =  sanitize_text_field( $_POST['val_checkout'] );

	$bgcolor =  sanitize_text_field( $_POST['bgcolor'] );

	$textcolor =  sanitize_text_field( $_POST['textcolor'] );

	$bordercolor =  sanitize_text_field( $_POST['bordercolor'] );

	$buttoncolor =  sanitize_text_field( $_POST['buttoncolor'] );

	$buttontcolor =  sanitize_text_field( $_POST['buttontcolor'] );

	$ttbordercolor =  sanitize_text_field( $_POST['ttbordercolor'] );

	$ttbagcolor =  sanitize_text_field( $_POST['ttbagcolor'] );

	$tttextcolor =  sanitize_text_field( $_POST['tttextcolor'] );

	$devbytcolor =  sanitize_text_field( $_POST['devbytcolor'] );

	$codtcolor =  sanitize_text_field( $_POST['codtcolor'] );

	$datecolor =  sanitize_text_field( $_POST['datecolor'] );

	$codmsgcolor =  sanitize_text_field( $_POST['codmsgcolor'] );

	$errormsgcolor =  sanitize_text_field( $_POST['errormsgcolor'] );

	$image_size =  sanitize_text_field( $_POST['image_size'] );
	
	$image_size1 =  sanitize_text_field( $_POST['image_size1'] );

	$tt_c_image_size =  sanitize_text_field( $_POST['tt_c_image_size'] );
	
	$tt_c_image_size1 =  sanitize_text_field( $_POST['tt_c_image_size1'] );

	$help_image =  sanitize_text_field( $_POST['help_image'] );

	$tt_c_image =  sanitize_text_field( $_POST['tt_c_image'] );
	
	update_option( 'woo_pin_checksuccess_msg_b', $success_msg_b );
	
	update_option( 'woo_pin_checkplc_odr_div', $_POST['plc_odr']  );
	
	update_option( 'woo_pin_check_del_label', $_POST['del_label'] );
	
	update_option( 'woo_pin_check_del_info_text', $_POST['del_info_text'] );
	
	update_option( 'woo_pin_check_place_holder_info_text', $_POST['del_place_holder_text'] );
	
	update_option( 'woo_pin_check_cod_label', $_POST['cod_label'] );
	
	update_option( 'woo_pin_check_show_s_on_pro', $_POST['show_s_on_pro'] );

	update_option( 'woo_pin_check_show_c_on_pro', $_POST['show_c_on_pro'] );
	
	update_option( 'woo_pin_check_error_msg_b', $_POST['error_msg_b'] );
	
	update_option( 'woo_pin_check_show_d_d_on_pro', $_POST['show_d_d_on_pro'] );
	
	update_option('active_pincode_check', $_POST['checkpc']);
	
	//update_option('val_check_page', $_POST['valcp']);
	
	update_option('show_product_page', $_POST['showpp']);
	
	update_option('val_product_page', $_POST['valpp']);
	
	update_option('show_deli_est', $_POST['show_d_est']);
	
	update_option('show_cod_a', $_POST['show_cod_a']);
	
	update_option('auto_load_popup', $_POST['auto_pch']);
	
	update_option('auto_load_popup_shop_cat', $_POST['auto_pchs']);

	update_option('auto_load_validate', $_POST['auto_pch_v']);
	
	update_option('auto_load_block', $_POST['auto_pch_bu']);
	
	update_option('phoen_pincode_ent_effct', $_POST['popup_ent_effct']);
	
	update_option('phoen_pincode_ext_effct', $_POST['popup_ext_effct']);
	
	update_option('phoen_pincode_info_ent_effct', $_POST['info_ent_effct']);
	
	update_option('phoen_pincode_info_ext_effct', $_POST['info_ext_effct']);
		
	update_option('pincode_length', $_POST['pincode_len']);
	
	
	$adddate = date('Y-m-d H:i:s');

	/* Database Queries */
	
	$num_rows = $wpdb->get_var( "SELECT COUNT(*) FROM `".$table_prefix."pincode_setting_p` " );

	if($num_rows == 0)
	{
	
		$result = $wpdb->query( "INSERT INTO `".$table_prefix."pincode_setting_p` (`del_help_text`, `cod_help_text`, `cod_msg1`, `cod_msg2`, `error_msg`, `del_date`, `cod`, `s_s`, `s_s1`, `cod_p`, `delv_by_cart`, `val_checkout`, `bgcolor`, `textcolor`, `bordercolor`, `buttoncolor`, `buttontcolor`, `ttbordercolor`, `ttbagcolor`, `tttextcolor`, `devbytcolor`, `codtcolor`, `datecolor`, `codmsgcolor`, `errormsgcolor` , `image_size`, `image_size1`, `tt_c_image_size`, `tt_c_image_size1`,`help_image`, `tt_c_image`,`date_time`) VALUES ('$del_help_text', '$cod_help_text', '$cod_msg1', '$cod_msg2', '$error_msg', '$del_date', '$cod','$s_s', '$s_s1', '$cod_p', '$delv_by_cart', '$val_checkout', '$bgcolor', '$textcolor', '$bordercolor', '$buttoncolor', '$buttontcolor', '$ttbordercolor', '$ttbagcolor', '$tttextcolor', '$devbytcolor', '$codtcolor', '$datecolor', '$codmsgcolor', '$errormsgcolor' , '$image_size', '$image_size1', '$tt_c_image_size', '$tt_c_image_size1', '$help_image', '$tt_c_image',NOW())" );
	
	}
	else
	{
		
		$result = $wpdb->query( "UPDATE `".$table_prefix."pincode_setting_p`  SET `del_help_text` = '$del_help_text', `cod_help_text` = '$cod_help_text', `cod_msg1` = '$cod_msg1', `cod_msg2` = '$cod_msg2', `error_msg` = '$error_msg', `del_date` = '$del_date', `cod` = '$cod', `s_s` = '$s_s', `s_s1` = '$s_s1', `cod_p` = '$cod_p', `delv_by_cart` = '$delv_by_cart', `val_checkout` = '$val_checkout', `bgcolor` = '$bgcolor', `textcolor` = '$textcolor', `bordercolor` = '$bordercolor', `buttoncolor` = '$buttoncolor', `buttontcolor` = '$buttontcolor', `ttbordercolor` = '$ttbordercolor', `ttbagcolor` = '$ttbagcolor', `tttextcolor` = '$tttextcolor', `devbytcolor` = '$devbytcolor', `codtcolor` = '$codtcolor', `datecolor` = '$datecolor', `codmsgcolor` = '$codmsgcolor', `errormsgcolor` = '$errormsgcolor', `image_size` = '$image_size', `image_size1` = '$image_size1', `tt_c_image_size` = '$tt_c_image_size', `tt_c_image_size1` = '$tt_c_image_size1',`help_image` = '$help_image', `tt_c_image` = '$tt_c_image',`date_time` = NOW() " );
	
	}
	
	/* $wpdb->query("truncate `".$table_prefix."pincode_setting_p`");
    
	$wpdb->query("INSERT INTO `".$table_prefix."pincode_setting_p` (`del_help_text`, `cod_help_text`, `cod_msg1`, `cod_msg2`, `error_msg`, `del_date`, `cod`, `s_s`, `s_s1`, `cod_p`, `delv_by_cart`, `val_checkout`, `bgcolor`, `textcolor`, `bordercolor`, `buttoncolor`, `buttontcolor`, `ttbordercolor`, `ttbagcolor`, `tttextcolor`, `devbytcolor`, `codtcolor`, `datecolor`, `codmsgcolor`, `errormsgcolor` , `image_size`, `image_size1`, `tt_c_image_size`, `tt_c_image_size1`,`help_image`, `tt_c_image`,`date_time`) VALUES ('$del_help_text', '$cod_help_text', '$cod_msg1', '$cod_msg2', '$error_msg', '$del_date', '$cod','$s_s', '$s_s1', '$cod_p', '$delv_by_cart', '$val_checkout', '$bgcolor', '$textcolor', '$bordercolor', '$buttoncolor', '$buttontcolor', '$ttbordercolor', '$ttbagcolor', '$tttextcolor', '$devbytcolor', '$codtcolor', '$datecolor', '$codmsgcolor', '$errormsgcolor' , '$image_size', '$image_size1', '$tt_c_image_size', '$tt_c_image_size1', '$help_image', '$tt_c_image',NOW())");
	*/
	
	if($result == 1)
	{
	?>

		<div class="updated" id="message">

			<p><strong>Setting updated.</strong></p>

		</div>

	<?php
	}
	else
	{
		?>
			<div class="error below-h2" id="message"><p> Something Went Wrong Please Try Again With Valid Data.</p></div>
		<?php
	}

}

$success_msg_b = get_option('woo_pin_checksuccess_msg_b');

$active_pincode_check = get_option('active_pincode_check');

/* Fetching Data From DB */
$del_label =  get_option( 'woo_pin_check_del_label' );

$del_info_text = get_option('woo_pin_check_del_info_text');

$del_place_holder_text = get_option('woo_pin_check_place_holder_info_text');

$cod_label =  get_option( 'woo_pin_check_cod_label' );

$show_s_on_pro =  get_option( 'woo_pin_check_show_s_on_pro' );

$show_c_on_pro =  get_option( 'woo_pin_check_show_c_on_pro' );

$error_msg_b =  get_option( 'woo_pin_check_error_msg_b' );

$show_d_d_on_pro =  get_option( 'woo_pin_check_show_d_d_on_pro' );

//$valcp = get_option('val_check_page');

$showpp = get_option('show_product_page');

$valpp = get_option('val_product_page');

$show_d_est = get_option('show_deli_est');

$show_cod_a = get_option('show_cod_a');

$auto_pch = get_option( 'auto_load_popup' );

$auto_pchs = get_option( 'auto_load_popup_shop_cat' );

$auto_pch_v = get_option( 'auto_load_validate' );

$auto_pch_bu = get_option( 'auto_load_block' );

$popup_ent_effct = get_option( 'phoen_pincode_ent_effct' );

$popup_ext_effct = get_option( 'phoen_pincode_ext_effct' );

$info_ent_effct = get_option( 'phoen_pincode_info_ent_effct' );

$info_ext_effct =  get_option( 'phoen_pincode_info_ext_effct' );

$_plc_odr_div =  get_option( 'woo_pin_checkplc_odr_div' );

$pincode_length = get_option('pincode_length');

$qry22 = $wpdb->get_results( "SELECT * FROM `".$table_prefix."pincode_setting_p` ORDER BY `id` ASC  limit 1" ,ARRAY_A);	

foreach($qry22 as $qry) {

}

?>

<div id="profile-page" class="wrap">

<h2>

WooCommerce Pincode Check - Plugin Options</h2>

<form method="post" action="">

<h3>Manual Settings</h3>

<table class="form-table">

	<tbody>
	
		<tr class="user-user-login-wrap">

			<th><label for="checkpc">Enable Pincode Check </label></th>
			
			<td><input type="checkbox" value="1" <?php if($active_pincode_check == 1){ echo "checked"; } ?> id="checkpc" name="checkpc" ></td>

		</tr>
		
		<tr class="user-user-login-wrap">

			<th><label for="pincode_len">Pincode length</label></th>
			
			<td><input type="number" value="<?php echo $pincode_length; ?>" id="pincode_len" name="pincode_len" min="1" /></td>

		</tr>
		
		<tr class="user-user-login-wrap">

			<th><label for="showpp">Show on product page </label></th>
			
			<td><input type="checkbox" value="1" <?php if($showpp == 1){ echo "checked"; } ?> id="showpp" name="showpp" ></td>

		</tr>	
		
		<tr class="v-d-p-p">

			<th><label for="valpp">Validation on product page </label></th>
			
			<td><input type="checkbox" value="1" <?php if($valpp == 1){ echo "checked"; } ?> id="valpp" name="valpp" ></td>

		</tr>
				
		<tr class="user-user-login-wrap">

			<th><label for="del_label">Delivery Date Label</label></th>
			
			<td><textarea class="regular-text" id="del_label" name="del_label"><?php echo $del_label; ?></textarea></td>

		</tr>
		
		<tr class="user-user-login-wrap">

			<th><label for="del_help_text">Delivery Date Help Text</label></th>
			
			<td><textarea class="regular-text" id="del_help_text" name="del_help_text"><?php echo $qry['del_help_text']; ?></textarea></td>

		</tr>
		
		<tr class="user-user-login-wrap">

			<th><label for="cod_label">COD Label</label></th>
			
			<td><textarea class="regular-text" id="cod_label" name="cod_label"><?php echo $cod_label; ?></textarea></td>

		</tr>

		<tr class="user-first-name-wrap">

			<th><label for="cod_help_text">COD Help Text</label></th>

			<td><textarea class="regular-text" id="cod_help_text" name="cod_help_text"><?php echo $qry['cod_help_text']; ?></textarea></td>

		</tr>

		<tr class="user-last-name-wrap">

			<th><label for="cod_msg1">COD Message(Available)</label></th>

			<td><textarea class="regular-text" id="cod_msg1" name="cod_msg1"><?php echo $qry['cod_msg1']; ?></textarea></td>

		</tr>

		<tr class="user-last-name-wrap">

			<th><label for="cod_msg2">COD Message(Not Available)</label></th>

			<td><textarea class="regular-text" id="cod_msg2" name="cod_msg2"><?php echo $qry['cod_msg2']; ?></textarea></td>

		</tr>
		
		<tr class="user-nickname-wrap">

			<th><label for="error_msg_b">Error Message on blank & less than Pincode length</label></th>

			<td><textarea class="regular-text" id="error_msg_b" name="error_msg_b"><?php echo $error_msg_b; ?></textarea></td>

		</tr>

		<tr class="user-nickname-wrap">

			<th><label for="error_msg">Error Message After Checking Pincode</label></th>

			<td><textarea class="regular-text" id="error_msg" name="error_msg"><?php echo $qry['error_msg']; ?></textarea></td>

		</tr>
		
		<tr class="user-nickname-wrap">

			<th><label for="s_s">Delivery on Saturday</label></th>

			<td><label for="s_s"><input type="radio" name="s_s" <?php if($qry['s_s'] == 1) { ?> checked <?php } ?> value="1">ON</label>

			<label for="s_s"><input type="radio" name="s_s" <?php if($qry['s_s'] == 0) { ?> checked <?php } ?> value="0">OFF</label></td>

		</tr>
		
		<tr class="user-nickname-wrap">

			<th><label for="s_s1">Delivery on Sunday</label></th>

			<td><label for="s_s1"><input type="radio" name="s_s1" <?php if($qry['s_s1'] == 1) { ?> checked <?php } ?> value="1">ON</label>

			<label for="s_s1"><input type="radio" name="s_s1" <?php if($qry['s_s1'] == 0) { ?> checked <?php } ?> value="0">OFF</label></td>

		</tr>

		
		<tr class="user-nickname-wrap">

			<th><label for="cod_p">Enable Check Pincode Based COD on Checkout Page</label></th>

			<td><label for="cod_p"><input type="radio" name="cod_p" <?php if($qry['cod_p'] == 1) { ?> checked <?php } ?> value="1">ON</label>

			<label for="cod_p"><input type="radio" name="cod_p" <?php if($qry['cod_p'] == 0) { ?> checked <?php } ?> value="0">OFF</label></td>

		</tr>
		
		<tr class="user-nickname-wrap">

			<th><label for="plc_odr_show">Enable Check Pincode Based Place Order on Checkout Page</label></th>

			<td><label for="plc_odr_show"><input type="radio" <?php if($_plc_odr_div == 1) { ?> checked <?php } ?> name="plc_odr" value="1">ON</label>

			<label for="plc_odr_show"><input type="radio" <?php if($_plc_odr_div == 0) { ?> checked <?php } ?> name="plc_odr" value="0">OFF</label></td>

		</tr>
				
		<tr class="user-nickname-wrap">

			<th><label for="delv_by_cart">Show State on Product Page</label></th>

			<td><label for="delv_by_cart"><input type="radio" name="show_s_on_pro" <?php if($show_s_on_pro == 1) { ?> checked <?php } ?> value="1">ON</label>

			<label for="delv_by_cart"><input type="radio" name="show_s_on_pro" <?php if($show_s_on_pro == 0) { ?> checked <?php } ?> value="0">OFF</label></td>

		</tr>

		<tr class="user-nickname-wrap">

			<th><label for="delv_by_cart">Show City on Product Page</label></th>

			<td><label for="delv_by_cart"><input type="radio" name="show_c_on_pro" <?php if($show_c_on_pro == 1) { ?> checked <?php } ?> value="1">ON</label>

			<label for="delv_by_cart"><input type="radio" name="show_c_on_pro" <?php if($show_c_on_pro == 0) { ?> checked <?php } ?> value="0">OFF</label></td>

		</tr>
		
		<tr class="user-nickname-wrap">

			<th><label for="delv_estimation">Show Delivery Estimation</label></th>

			<td><label for="delv_estimation"><input type="radio" name="show_d_est" <?php if($show_d_est == 1) { ?> checked <?php } ?> value="1">ON</label>

			<label for="delv_estimation"><input type="radio" name="show_d_est" <?php if($show_d_est == 0) { ?> checked <?php } ?> value="0">OFF</label></td>

		</tr>
		
		<tr class="user-nickname-wrap">

			<th><label for="delv_estimation">Show COD Area</label></th>

			<td><label for="delv_estimation"><input type="radio" name="show_cod_a" <?php if($show_cod_a == 1) { ?> checked <?php } ?> value="1">ON</label>

			<label for="delv_estimation"><input type="radio" name="show_cod_a" <?php if($show_cod_a == 0) { ?> checked <?php } ?> value="0">OFF</label></td>

		</tr>
		
		<tr class="s-d-d">

			<th><label for="delv_by_cart">Show Date or Days</label></th>

			<td><label for="delv_by_cart"><input type="radio" name="show_d_d_on_pro" <?php if($show_d_d_on_pro == 1) { ?> checked <?php } ?> value="1">Date</label>

			<label for="delv_by_cart"><input type="radio" name="show_d_d_on_pro" <?php if($show_d_d_on_pro == 0) { ?> checked <?php } ?> value="0">Days</label></td>

		</tr>
		
		<tr class="user-nickname-wrap" style="display:none">

			<th><label for="val_checkout">Validate (on checkout page)</label></th>

			<td><label for="val_checkout"><input type="radio" name="val_checkout" <?php if($qry['val_checkout'] == 1) { ?> checked <?php } ?> value="1">ON</label>

			<label for="val_checkout"><input type="radio" name="val_checkout" <?php if($qry['val_checkout'] == 0) { ?> checked <?php } ?> value="0">OFF</label></td>

		</tr>

</tbody>

</table>

<table class="form-table">

	<tbody>
	
		<h3>Pincode check popup</h3>
		
			<tr class="user-user-login-wrap">

				<th><label for="auto_pch">Autoload popup Home</label></th>

					<td>
					
						<label for="auto_pch"><input type="radio" name="auto_pch" <?php if($auto_pch == 1) { ?> checked <?php }   ?> value="1">ON</label>

						<label for="auto_pch"><input type="radio" name="auto_pch" <?php if($auto_pch == 0) { ?> checked <?php } ?> value="0">OFF</label>
						
					</td>

			</tr>
			
			<tr class="user-user-login-wrap">

				<th><label for="auto_pchs">Popup on click of 'add to cart' button on shop/category page</label></th>

					<td>
					
						<label for="auto_pchs"><input type="radio" name="auto_pchs" <?php if($auto_pchs == 1) { ?> checked <?php }   ?> value="1">ON</label>

						<label for="auto_pchs"><input type="radio" name="auto_pchs" <?php if($auto_pchs == 0) { ?> checked <?php } ?> value="0">OFF</label>
						
					</td>

			</tr>
			
			<tr class="user-user-login-wrap">

				<th><label for="auto_pch_v">Let user close popup if not validate</label></th>
				
					<td>
					
						<label for="auto_pch_v"><input type="radio" name="auto_pch_v" <?php  if($auto_pch_v == 0) { ?> checked <?php }  ?> value="0">NO</label>

						<label for="auto_pch_v"><input type="radio" name="auto_pch_v" <?php  if($auto_pch_v == 1) { ?> checked <?php }  ?> value="1">YES</label>
						
					</td>

			</tr>
			
			<tr class="user-user-login-wrap">

				<th><label for="auto_pch">Block user to access website if not validate</label></th>
				
				<td>
				
					<label for="auto_pch_bu"><input type="radio" name="auto_pch_bu" <?php if($auto_pch_bu == 0) { ?> checked <?php } ?> value="0">NO</label>

					<label for="auto_pch_bu"><input type="radio" name="auto_pch_bu" <?php  if($auto_pch_bu == 1) { ?> checked <?php } ?> value="1">YES</label>
					
				</td>

			</tr>
			
			
			<tr class="user-user-login-wrap">

				<th><label for="del_label">Popup Info Text. </label></th>
				
				<td><textarea class="regular-text" id="del_info_text" name="del_info_text"><?php echo $del_info_text; ?></textarea></td>

			</tr>
			
			<tr class="user-user-login-wrap">

				<th><label for="del_label">Popup Pincode Text Field Placeholder text. </label></th>
				
				<td><textarea class="regular-text" id="del_place_holder_text" name="del_place_holder_text"><?php echo $del_place_holder_text; ?></textarea></td>

			</tr>
			
			
			<tr class="user-nickname-wrap">

				<th><label for="success_msg_b">Message For valid Pincode.</label></th>

				<td><textarea class="regular-text" id="success_msg_b" name="success_msg_b"><?php echo $success_msg_b; ?></textarea></td>

			</tr>
			
			
			
			<tr class="user-nickname-wrap">
								
				<th><label for="popup_ent_effct"> <?php _e('Popup Entrance Effect','phoen_login_signup'); ?>:</label></th>
				
				<td>
				
					<select id="popup_ent_effct" name="popup_ent_effct">
					
						<option value="bounceIn" <?php if( $popup_ent_effct == 'bounceIn' ){ echo "selected"; } ?>>bounceIn</option>
						
						<option value="bounceInDown" <?php if( $popup_ent_effct == 'bounceInDown' ){ echo "selected"; } ?>>bounceInDown</option>
						
						<option value="bounceInLeft" <?php if( $popup_ent_effct == 'bounceInLeft' ){ echo "selected"; } ?>>bounceInLeft</option>
						
						<option value="bounceInRight" <?php if( $popup_ent_effct == 'bounceInRight' ){ echo "selected"; } ?>>bounceInRight</option>
						
						<option value="bounceInUp" <?php if( $popup_ent_effct == 'bounceInUp' ){ echo "selected"; } ?>>bounceInUp</option>
						
						<option value="fadeIn" <?php if( $popup_ent_effct == 'fadeIn' ){ echo "selected"; } ?>>fadeIn</option>
						
						<option value="fadeInDown" <?php if( $popup_ent_effct == 'fadeInDown' ){ echo "selected"; } ?>>fadeInDown</option>
						
						<option value="fadeInDownBig" <?php if( $popup_ent_effct == 'fadeInDownBig' ){ echo "selected"; } ?>>fadeInDownBig</option>
						
						<option value="fadeInLeft" <?php if( $popup_ent_effct == 'fadeInLeft' ){ echo "selected"; } ?>>fadeInLeft</option>
						
						<option value="fadeInLeftBig" <?php if( $popup_ent_effct == 'fadeInLeftBig' ){ echo "selected"; } ?>>fadeInLeftBig</option>
						
						<option value="fadeInRight" <?php if( $popup_ent_effct == 'fadeInRight' ){ echo "selected"; } ?>>fadeInRight</option>
						
						<option value="fadeInRightBig" <?php if( $popup_ent_effct == 'fadeInRightBig' ){ echo "selected"; } ?>>fadeInRightBig</option>
						
						<option value="fadeInUp" <?php if( $popup_ent_effct == 'fadeInUp' ){ echo "selected"; } ?>>fadeInUp</option>
						
						<option value="fadeInUpBig" <?php if( $popup_ent_effct == 'fadeInUpBig' ){ echo "selected"; } ?>>fadeInUpBig</option>
						
						<option value="rotateIn" <?php if( $popup_ent_effct == 'rotateIn' ){ echo "selected"; } ?>>rotateIn</option>
						
						<option value="rotateInDownLeft" <?php if( $popup_ent_effct == 'rotateInDownLeft' ){ echo "selected"; } ?>>rotateInDownLeft</option>
						
						<option value="rotateInDownRight" <?php if( $popup_ent_effct == 'rotateInDownRight' ){ echo "selected"; } ?>>rotateInDownRight</option>
						
						<option value="rotateInUpLeft" <?php if( $popup_ent_effct == 'rotateInUpLeft' ){ echo "selected"; } ?>>rotateInUpLeft</option>
						
						<option value="rotateInUpRight" <?php if( $popup_ent_effct == 'rotateInUpRight' ){ echo "selected"; } ?>>rotateInUpRight</option>
						
						<option value="slideInUp" <?php if( $popup_ent_effct == 'slideInUp' ){ echo "selected"; } ?>>slideInUp</option>
						
						<option value="slideInDown" <?php if( $popup_ent_effct == 'slideInDown' ){ echo "selected"; } ?>>slideInDown</option>
						
						<option value="slideInLeft" <?php if( $popup_ent_effct == 'slideInLeft' ){ echo "selected"; } ?>>slideInLeft</option>
						
						<option value="slideInRight" <?php if( $popup_ent_effct == 'slideInRight' ){ echo "selected"; } ?>>slideInRight</option>
						
						<option value="zoomIn" <?php if( $popup_ent_effct == 'zoomIn' ){ echo "selected"; } ?>>zoomIn</option>
						
						<option value="zoomInDown" <?php if( $popup_ent_effct == 'zoomInDown' ){ echo "selected"; } ?>>zoomInDown</option>
						
						<option value="zoomInLeft" <?php if( $popup_ent_effct == 'zoomInLeft' ){ echo "selected"; } ?>>zoomInLeft</option>
						
						<option value="zoomInRight" <?php if( $popup_ent_effct == 'zoomInRight' ){ echo "selected"; } ?>>zoomInRight</option>
						
						<option value="zoomInUp" <?php if( $popup_ent_effct == 'zoomInUp' ){ echo "selected"; } ?>>zoomInUp</option>
						
						<option value="rollIn" <?php if( $popup_ent_effct == 'rollIn' ){ echo "selected"; } ?>>rollIn</option>

					</select>
					
				</td>
				
			</tr>
			
			<tr class="user-nickname-wrap">
					
				<th><label for="popup_ext_effct"> <?php _e('Popup Exits Effect','phoen_login_signup'); ?>:</label></th>
				
				<td>
				
					<select id="popup_ext_effct" name="popup_ext_effct">
					
						<option value="bounceOut" <?php if( $popup_ext_effct == 'bounceOut' ){ echo "selected"; } ?>>bounceOut</option>
						
						<option value="bounceOutDown" <?php if( $popup_ext_effct == 'bounceOutDown' ){ echo "selected"; } ?>>bounceOutDown</option>
						
						<option value="bounceOutLeft" <?php if( $popup_ext_effct == 'bounceOutLeft' ){ echo "selected"; } ?>>bounceOutLeft</option>
						
						<option value="bounceOutRight" <?php if( $popup_ext_effct == 'bounceOutRight' ){ echo "selected"; } ?>>bounceOutRight</option>
						
						<option value="bounceOutUp" <?php if( $popup_ext_effct == 'bounceOutUp' ){ echo "selected"; } ?>>bounceOutUp</option>
						
						<option value="fadeOut" <?php if( $popup_ext_effct == 'fadeOut' ){ echo "selected"; } ?>>fadeOut</option>
						
						<option value="fadeOutDown" <?php if( $popup_ext_effct == 'fadeOutDown' ){ echo "selected"; } ?>>fadeOutDown</option>
						
						<option value="fadeOutDownBig" <?php if( $popup_ext_effct == 'fadeOutDownBig' ){ echo "selected"; } ?>>fadeOutDownBig</option>
						
						<option value="fadeOutLeft" <?php if( $popup_ext_effct == 'fadeOutLeft' ){ echo "selected"; } ?>>fadeOutLeft</option>
						
						<option value="fadeOutLeftBig" <?php if( $popup_ext_effct == 'fadeOutLeftBig' ){ echo "selected"; } ?>>fadeOutLeftBig</option>
						
						<option value="fadeOutRight" <?php if( $popup_ext_effct == 'fadeOutRight' ){ echo "selected"; } ?>>fadeOutRight</option>
						
						<option value="fadeOutRightBig" <?php if( $popup_ext_effct == 'fadeOutRightBig' ){ echo "selected"; } ?>>fadeOutRightBig</option>
						
						<option value="fadeOutUp" <?php if( $popup_ext_effct == 'fadeOutUp' ){ echo "selected"; } ?>>fadeOutUp</option>
						
						<option value="fadeOutUpBig" <?php if( $popup_ext_effct == 'fadeOutUpBig' ){ echo "selected"; } ?>>fadeOutUpBig</option>
						
						<option value="rotateOut" <?php if( $popup_ext_effct == 'rotateOut' ){ echo "selected"; } ?>>rotateOut</option>
						
						<option value="rotateOutDownLeft" <?php if( $popup_ext_effct == 'rotateOutDownLeft' ){ echo "selected"; } ?>>rotateOutDownLeft</option>
						
						<option value="rotateOutDownRight" <?php if( $popup_ext_effct == 'rotateOutDownRight' ){ echo "selected"; } ?>>rotateOutDownRight</option>
						
						<option value="rotateOutUpLeft" <?php if( $popup_ext_effct == 'rotateOutUpLeft' ){ echo "selected"; } ?>>rotateOutUpLeft</option>
						
						<option value="rotateOutUpRight" <?php if( $popup_ext_effct == 'rotateOutUpRight' ){ echo "selected"; } ?>>rotateOutUpRight</option>
						
						<option value="slideOutUp" <?php if( $popup_ext_effct == 'slideOutUp' ){ echo "selected"; } ?>>slideOutUp</option>
						
						<option value="slideOutDown" <?php if( $popup_ext_effct == 'slideOutDown' ){ echo "selected"; } ?>>slideOutDown</option>
						
						<option value="slideOutLeft" <?php if( $popup_ext_effct == 'slideOutLeft' ){ echo "selected"; } ?>>slideOutLeft</option>
						
						<option value="slideOutRight" <?php if( $popup_ext_effct == 'slideOutRight' ){ echo "selected"; } ?>>slideOutRight</option>
						
						<option value="zoomOut" <?php if( $popup_ext_effct == 'zoomOut' ){ echo "selected"; } ?>>zoomOut</option>
						
						<option value="zoomOutDown" <?php if( $popup_ext_effct == 'zoomOutDown' ){ echo "selected"; } ?>>zoomOutDown</option>
						
						<option value="zoomOutLeft" <?php if( $popup_ext_effct == 'zoomOutLeft' ){ echo "selected"; } ?>>zoomOutLeft</option>
						
						<option value="zoomOutRight" <?php if( $popup_ext_effct == 'zoomOutRight' ){ echo "selected"; } ?>>zoomOutRight</option>
						
						<option value="zoomOutUp" <?php if( $popup_ext_effct == 'zoomOutUp' ){ echo "selected"; } ?>>zoomOutUp</option>
						
						<option value="hinge" <?php if( $popup_ext_effct == 'hinge' ){ echo "selected"; } ?>>hinge</option>
						
						<option value="rollOut" <?php if( $popup_ext_effct == 'rollOut' ){ echo "selected"; } ?>>rollOut</option>
						
					</select>
					
				</td>
				
			</tr>
		
	</tbody>

</table>

<table class="form-table">

	<tbody>

		<h3>Enable Help Text</h3>

		<tr class="user-nickname-wrap">

			<th><label for="del_date">Delivery Date</label></th>

			<td><label for="del_date"><input type="radio" <?php if($qry['del_date'] == 1) { ?> checked <?php } ?> name="del_date" value="1">ON</label>

			<label for="del_date"><input type="radio" <?php if($qry['del_date'] == 0) { ?> checked <?php } ?> name="del_date" value="0">OFF</label></td>

		</tr>

		

		<tr class="user-nickname-wrap">

			<th><label for="cod">COD</label></th>

			<td><label for="cod"><input type="radio" <?php if($qry['cod'] == 1) { ?> checked <?php } ?> name="cod" value="1">ON</label>

			<label for="cod"><input type="radio" <?php if($qry['cod'] == 0) { ?> checked <?php } ?> name="cod" value="0">OFF</label></td>

		</tr>
		
	</tbody>

</table>

<table class="form-table">

	<tbody>

		<h3><?php _e('Animation on COD and Delivered By Result','phoen_login_signup'); ?></h3>

		<tr class="user-nickname-wrap">
								
				<th><label for="info_ent_effct"> <?php _e('Animation on COD and Delivered Info Entrance Result','phoen_login_signup'); ?>:</label></th>
				
				<td>
				
					<select id="info_ent_effct" name="info_ent_effct">
					
						<option value="bounceIn" <?php if( $info_ent_effct == 'bounceIn' ){ echo "selected"; } ?>>bounceIn</option>
						
						<option value="bounceInDown" <?php if( $info_ent_effct == 'bounceInDown' ){ echo "selected"; } ?>>bounceInDown</option>
						
						<option value="bounceInLeft" <?php if( $info_ent_effct == 'bounceInLeft' ){ echo "selected"; } ?>>bounceInLeft</option>
						
						<option value="bounceInRight" <?php if( $info_ent_effct == 'bounceInRight' ){ echo "selected"; } ?>>bounceInRight</option>
						
						<option value="bounceInUp" <?php if( $info_ent_effct == 'bounceInUp' ){ echo "selected"; } ?>>bounceInUp</option>
						
						<option value="fadeIn" <?php if( $info_ent_effct == 'fadeIn' ){ echo "selected"; } ?>>fadeIn</option>
						
						<option value="fadeInDown" <?php if( $info_ent_effct == 'fadeInDown' ){ echo "selected"; } ?>>fadeInDown</option>
						
						<option value="fadeInDownBig" <?php if( $info_ent_effct == 'fadeInDownBig' ){ echo "selected"; } ?>>fadeInDownBig</option>
						
						<option value="fadeInLeft" <?php if( $info_ent_effct == 'fadeInLeft' ){ echo "selected"; } ?>>fadeInLeft</option>
						
						<option value="fadeInLeftBig" <?php if( $info_ent_effct == 'fadeInLeftBig' ){ echo "selected"; } ?>>fadeInLeftBig</option>
						
						<option value="fadeInRight" <?php if( $info_ent_effct == 'fadeInRight' ){ echo "selected"; } ?>>fadeInRight</option>
						
						<option value="fadeInRightBig" <?php if( $info_ent_effct == 'fadeInRightBig' ){ echo "selected"; } ?>>fadeInRightBig</option>
						
						<option value="fadeInUp" <?php if( $info_ent_effct == 'fadeInUp' ){ echo "selected"; } ?>>fadeInUp</option>
						
						<option value="fadeInUpBig" <?php if( $info_ent_effct == 'fadeInUpBig' ){ echo "selected"; } ?>>fadeInUpBig</option>
						
						<option value="rotateIn" <?php if( $info_ent_effct == 'rotateIn' ){ echo "selected"; } ?>>rotateIn</option>
						
						<option value="rotateInDownLeft" <?php if( $info_ent_effct == 'rotateInDownLeft' ){ echo "selected"; } ?>>rotateInDownLeft</option>
						
						<option value="rotateInDownRight" <?php if( $info_ent_effct == 'rotateInDownRight' ){ echo "selected"; } ?>>rotateInDownRight</option>
						
						<option value="rotateInUpLeft" <?php if( $info_ent_effct == 'rotateInUpLeft' ){ echo "selected"; } ?>>rotateInUpLeft</option>
						
						<option value="rotateInUpRight" <?php if( $info_ent_effct == 'rotateInUpRight' ){ echo "selected"; } ?>>rotateInUpRight</option>
						
						<option value="slideInUp" <?php if( $info_ent_effct == 'slideInUp' ){ echo "selected"; } ?>>slideInUp</option>
						
						<option value="slideInDown" <?php if( $info_ent_effct == 'slideInDown' ){ echo "selected"; } ?>>slideInDown</option>
						
						<option value="slideInLeft" <?php if( $info_ent_effct == 'slideInLeft' ){ echo "selected"; } ?>>slideInLeft</option>
						
						<option value="slideInRight" <?php if( $info_ent_effct == 'slideInRight' ){ echo "selected"; } ?>>slideInRight</option>
						
						<option value="zoomIn" <?php if( $info_ent_effct == 'zoomIn' ){ echo "selected"; } ?>>zoomIn</option>
						
						<option value="zoomInDown" <?php if( $info_ent_effct == 'zoomInDown' ){ echo "selected"; } ?>>zoomInDown</option>
						
						<option value="zoomInLeft" <?php if( $info_ent_effct == 'zoomInLeft' ){ echo "selected"; } ?>>zoomInLeft</option>
						
						<option value="zoomInRight" <?php if( $info_ent_effct == 'zoomInRight' ){ echo "selected"; } ?>>zoomInRight</option>
						
						<option value="zoomInUp" <?php if( $info_ent_effct == 'zoomInUp' ){ echo "selected"; } ?>>zoomInUp</option>
						
						<option value="rollIn" <?php if( $info_ent_effct == 'rollIn' ){ echo "selected"; } ?>>rollIn</option>

					</select>
					
				</td>
				
			</tr>
			<tr class="user-nickname-wrap">
					
				<th><label for="info_ext_effct"> <?php _e('Animation on COD and Delivered Info Exit Result','phoen_login_signup'); ?>:</label></th>
				
				<td>
				
					<select id="info_ext_effct" name="info_ext_effct">
					
						<option value="bounceOut" <?php if( $info_ext_effct == 'bounceOut' ){ echo "selected"; } ?>>bounceOut</option>
						
						<option value="bounceOutDown" <?php if( $info_ext_effct == 'bounceOutDown' ){ echo "selected"; } ?>>bounceOutDown</option>
						
						<option value="bounceOutLeft" <?php if( $info_ext_effct == 'bounceOutLeft' ){ echo "selected"; } ?>>bounceOutLeft</option>
						
						<option value="bounceOutRight" <?php if( $info_ext_effct == 'bounceOutRight' ){ echo "selected"; } ?>>bounceOutRight</option>
						
						<option value="bounceOutUp" <?php if( $info_ext_effct == 'bounceOutUp' ){ echo "selected"; } ?>>bounceOutUp</option>
						
						<option value="fadeOut" <?php if( $info_ext_effct == 'fadeOut' ){ echo "selected"; } ?>>fadeOut</option>
						
						<option value="fadeOutDown" <?php if( $info_ext_effct == 'fadeOutDown' ){ echo "selected"; } ?>>fadeOutDown</option>
						
						<option value="fadeOutDownBig" <?php if( $info_ext_effct == 'fadeOutDownBig' ){ echo "selected"; } ?>>fadeOutDownBig</option>
						
						<option value="fadeOutLeft" <?php if( $info_ext_effct == 'fadeOutLeft' ){ echo "selected"; } ?>>fadeOutLeft</option>
						
						<option value="fadeOutLeftBig" <?php if( $info_ext_effct == 'fadeOutLeftBig' ){ echo "selected"; } ?>>fadeOutLeftBig</option>
						
						<option value="fadeOutRight" <?php if( $info_ext_effct == 'fadeOutRight' ){ echo "selected"; } ?>>fadeOutRight</option>
						
						<option value="fadeOutRightBig" <?php if( $info_ext_effct == 'fadeOutRightBig' ){ echo "selected"; } ?>>fadeOutRightBig</option>
						
						<option value="fadeOutUp" <?php if( $info_ext_effct == 'fadeOutUp' ){ echo "selected"; } ?>>fadeOutUp</option>
						
						<option value="fadeOutUpBig" <?php if( $info_ext_effct == 'fadeOutUpBig' ){ echo "selected"; } ?>>fadeOutUpBig</option>
						
						<option value="rotateOut" <?php if( $info_ext_effct == 'rotateOut' ){ echo "selected"; } ?>>rotateOut</option>
						
						<option value="rotateOutDownLeft" <?php if( $info_ext_effct == 'rotateOutDownLeft' ){ echo "selected"; } ?>>rotateOutDownLeft</option>
						
						<option value="rotateOutDownRight" <?php if( $info_ext_effct == 'rotateOutDownRight' ){ echo "selected"; } ?>>rotateOutDownRight</option>
						
						<option value="rotateOutUpLeft" <?php if( $info_ext_effct == 'rotateOutUpLeft' ){ echo "selected"; } ?>>rotateOutUpLeft</option>
						
						<option value="rotateOutUpRight" <?php if( $info_ext_effct == 'rotateOutUpRight' ){ echo "selected"; } ?>>rotateOutUpRight</option>
						
						<option value="slideOutUp" <?php if( $info_ext_effct == 'slideOutUp' ){ echo "selected"; } ?>>slideOutUp</option>
						
						<option value="slideOutDown" <?php if( $info_ext_effct == 'slideOutDown' ){ echo "selected"; } ?>>slideOutDown</option>
						
						<option value="slideOutLeft" <?php if( $info_ext_effct == 'slideOutLeft' ){ echo "selected"; } ?>>slideOutLeft</option>
						
						<option value="slideOutRight" <?php if( $info_ext_effct == 'slideOutRight' ){ echo "selected"; } ?>>slideOutRight</option>
						
						<option value="zoomOut" <?php if( $info_ext_effct == 'zoomOut' ){ echo "selected"; } ?>>zoomOut</option>
						
						<option value="zoomOutDown" <?php if( $info_ext_effct == 'zoomOutDown' ){ echo "selected"; } ?>>zoomOutDown</option>
						
						<option value="zoomOutLeft" <?php if( $info_ext_effct == 'zoomOutLeft' ){ echo "selected"; } ?>>zoomOutLeft</option>
						
						<option value="zoomOutRight" <?php if( $info_ext_effct == 'zoomOutRight' ){ echo "selected"; } ?>>zoomOutRight</option>
						
						<option value="zoomOutUp" <?php if( $info_ext_effct == 'zoomOutUp' ){ echo "selected"; } ?>>zoomOutUp</option>
						
						<option value="hinge" <?php if( $info_ext_effct == 'hinge' ){ echo "selected"; } ?>>hinge</option>
						
						<option value="rollOut" <?php if( $info_ext_effct == 'rollOut' ){ echo "selected"; } ?>>rollOut</option>
						
					</select>
					
				</td>
				
			</tr>

	</tbody>

</table>

<table class="form-table">

<tbody>

<h3>Styling of Check Pincode Functionality on Product Page</h3>


	<tr class="user-user-login-wrap">

			<th><label for="bgcolor">Box Background color</label></th>

			<td><input type="text" class="regular-text" value="<?php echo $qry['bgcolor']; ?>" id="bgcolor" name="bgcolor"></td>

		</tr>


		<tr class="user-first-name-wrap">

			<th><label for="textcolor">Check Pincode Label Text Color</label></th>

			<td><input type="text" class="regular-text" value="<?php echo $qry['textcolor']; ?>" id="textcolor" name="textcolor"></td>

		</tr>



		<tr class="user-last-name-wrap">

			<th><label for="bordercolor">Box Border Color</label></th>

			<td><input type="text" class="regular-text" value="<?php echo $qry['bordercolor']; ?>" id="bordercolor" name="bordercolor"></td>

		</tr>
		
		
		<tr class="user-last-name-wrap">

			<th><label for="buttoncolor">"Check/Change" Button Color</label></th>

			<td><input type="text" class="regular-text" value="<?php echo $qry['buttoncolor']; ?>" id="buttoncolor" name="buttoncolor"></td>

		</tr>
		
		
		<tr class="user-last-name-wrap">

			<th><label for="buttontcolor">"Check/Change" Button Text Color</label></th>

			<td><input type="text" class="regular-text" value="<?php echo $qry['buttontcolor']; ?>" id="buttontcolor" name="buttontcolor"></td>

		</tr>
		
		
		<tr class="user-last-name-wrap">

			<th><label for="ttbordercolor">Tooltip Border Color</label></th>

			<td><input type="text" class="regular-text" value="<?php echo $qry['ttbordercolor']; ?>" id="ttbordercolor" name="ttbordercolor"></td>

		</tr>
		
		<tr class="user-last-name-wrap">

			<th><label for="ttbagcolor">Tooltip Background Color</label></th>

			<td><input type="text" class="regular-text" value="<?php echo $qry['ttbagcolor']; ?>" id="ttbagcolor" name="ttbagcolor"></td>

		</tr>
		
		<tr class="user-last-name-wrap">

			<th><label for="tttextcolor">Tooltip Text Color</label></th>

			<td><input type="text" class="regular-text" value="<?php echo $qry['tttextcolor']; ?>" id="tttextcolor" name="tttextcolor"></td>

		</tr>
		
		<tr class="user-last-name-wrap">

			<th><label for="devbytcolor">Delivered By Text Color</label></th>

			<td><input type="text" class="regular-text" value="<?php echo $qry['devbytcolor']; ?>" id="devbytcolor" name="devbytcolor"></td>

		</tr>
		
		<tr class="user-last-name-wrap">

			<th><label for="codtcolor">Cash On Delivery Text Color</label></th>

			<td><input type="text" class="regular-text" value="<?php echo $qry['codtcolor']; ?>" id="codtcolor" name="codtcolor"></td>

		</tr>
		
		<tr class="user-last-name-wrap">

			<th><label for="datecolor">Date/Days Color</label></th>

			<td><input type="text" class="regular-text" value="<?php echo $qry['datecolor']; ?>" id="datecolor" name="datecolor"></td>

		</tr>
		
		
		<tr class="user-last-name-wrap">

			<th><label for="codmsgcolor">COD Message Color</label></th>

			<td><input type="text" class="regular-text" value="<?php echo $qry['codmsgcolor']; ?>" id="codmsgcolor" name="codmsgcolor"></td>

		</tr>
		
		
		<tr class="user-last-name-wrap">

			<th><label for="errormsgcolor">Error Message Color</label></th>

			<td><input type="text" class="regular-text" value="<?php echo $qry['errormsgcolor']; ?>" id="errormsgcolor" name="errormsgcolor"></td>

		</tr>



</tbody>

</table>		

<table class="form-table">

<tbody>

<h3>Image Options</h3>

		<tr class="user-nickname-wrap">

			<th><label for="image_size">Help Text Icon Image Size</label></th>

			<td><span class="long"><label class="up grey">Height(px)<input style="width:100px" type="number" max="20" min="0" class="regular-text up " value="<?php echo $qry['image_size']; ?>" id="image_size" name="image_size"></label></span><span class="px-multiply">&nbsp; X &nbsp;  </span>
			
			<span class="wid"><label class="up grey">Width(px)<input style="width:100px" type="number" max="20" min="0" class="regular-text up" value="<?php echo $qry['image_size1']; ?>" id="image_size1" name="image_size1"></label></span><span class="px-multiply"></span></td>

		</tr>
		
		<tr class="user-nickname-wrap">

			<th><label for="tt_c_image_size">Tooltip Cancel Icon Image Size</label></th>

			<td><span class="long"><label class="up grey">Height(px)<input style="width:100px" type="number" max="20" min="0" class="regular-text up" value="<?php echo $qry['tt_c_image_size']; ?>" id="tt_c_image_size" name="tt_c_image_size"></label></span><span class="px-multiply"> &nbsp; X  &nbsp;</span>
			
			<span class="wid"><label class="up grey">Width(px)<input style="width:100px" type="number" max="20" min="0" class="regular-text up" value="<?php echo $qry['tt_c_image_size1']; ?>" id="tt_c_image_size1" name="tt_c_image_size1"></label></span><span class="px-multiply"></span></td>

		</tr>



		<tr class="user-nickname-wrap">

			<th><label for="help_image">Help Text Icon Image Upload</label></th>

			<td><input type="text" class="regular-text" value="<?php echo $qry['help_image']; ?>" id="help_image" name="help_image"><input id="help_image_button" class="button uploadimage" type="button" value="Upload" /></td>

		</tr>
		
		
		<tr class="user-nickname-wrap">

			<th><label for="tt_c_image">Tooltip Cancel Icon Image Upload</label></th>

			<td><input type="text" class="regular-text" value="<?php echo $qry['tt_c_image']; ?>" id="tt_c_image" name="tt_c_image"><input id="tt_c_image_button" class="button uploadimage1" type="button" value="Upload" /></td>

		</tr>


</tbody>

</table>

<p class=""><input type="submit" value="Save" class="button button-primary" id="submit" name="submit"> <a href="#" id="phoe_reset_form" class="button button-primary" >reset</a> </p>

</form>

<table class="form-table">

	<tbody>

			<tr class="user-nickname-wrap">

				<th><label style="color:red">Delete All PIncodes From Pincode List</label></th>	

				<td><a class="add-new-h2 delete-all" href="<?php echo admin_url( 'admin.php?page=pincodes_setting&&action=delete-all' ); ?>" onclick="return confirm('Are you sure You want to Delete All Pincodes?')" >Delete All</a></td>

			</tr>
			
	</tbody>

</table>

</div>

<script>

jQuery(document).ready(function($) {

	jQuery("#bgcolor").wpColorPicker();

	jQuery("#textcolor").wpColorPicker();
	
	jQuery("#bordercolor").wpColorPicker();

	jQuery("#buttoncolor").wpColorPicker();
	
	jQuery("#buttontcolor").wpColorPicker();
	
	jQuery("#ttbordercolor").wpColorPicker();
	
	jQuery("#ttbagcolor").wpColorPicker();
	
	jQuery("#tttextcolor").wpColorPicker();
	
	jQuery("#devbytcolor").wpColorPicker();
	
	jQuery("#codtcolor").wpColorPicker();
	
	jQuery("#datecolor").wpColorPicker();
	
	jQuery("#codmsgcolor").wpColorPicker();
	
	jQuery("#errormsgcolor").wpColorPicker();
	
    var custom_upload;

	var textid;

	$(document).on("click",".uploadimage",uploadimage_button);

    function uploadimage_button(){

        var custom_upload = wp.media({

        title: 'Add Media',

        button: {

            text: 'Insert Image'

        },

        multiple: false  // Set this to true to allow multiple files to be selected

		})

		.on('select', function() {

			var attachment = custom_upload.state().get('selection').first().toJSON();

			$('.custom_media_image').attr('src', attachment.url);

			$('#help_image').val(attachment.url);


		})

		.open();

    }

	$(document).on("click",".uploadimage1",uploadimage_button1);

    function uploadimage_button1() {

        var custom_upload = wp.media({

			title: 'Add Media',

			button: {

				text: 'Insert Image'

			},

			multiple: false  // Set this to true to allow multiple files to be selected

		})

		.on('select', function() {

			var attachment = custom_upload.state().get('selection').first().toJSON();

			$('.custom_media_image').attr('src', attachment.url);

			$('#tt_c_image').val(attachment.url);

		})

		.open();

    }

	if($("#showpp").is(':checked'))
	{
		
		$('.v-d-p-p').show();
		
	}
	else
	{
		
		$('.v-d-p-p').hide();
		
		$('#valpp').attr('checked', false); // Checks it
		
	}

	$("#showpp").change(function() {
		
		if(this.checked) {
			
			$('.v-d-p-p').show();
			
		}
		else{
			
			$('.v-d-p-p').hide();
			
			$('#valpp').attr('checked', false); // Checks it
			
		}
		
	});
	
	//alert($("input[type=radio][name=show_d_est]:checked").val());
	if($("input[type=radio][name=show_d_est]:checked").val() == 1) 
	{
		
		$('.s-d-d').show();
		
	}
	else
	{
		
		$('.s-d-d').hide();
		
	}
	
	
	$("input[type=radio][name=show_d_est]").change(function() {
		
		if(this.value == 1) {
			
			$('.s-d-d').show();
			
		}
		else{
			
			$('.s-d-d').hide();
			
		}
		
	});
	
});

jQuery(document).on("click","#phoe_reset_form",function(){
		
		jQuery( "#checkpc" ).prop( "checked", true );
		
		jQuery( "#pincode_len" ).val( "6" );
		
		jQuery( "#showpp" ).prop( "checked", true );
		
		jQuery( "#valpp" ).prop( "checked", true );
		
		jQuery( "#del_label" ).val( "Delivery Date" );
		
		jQuery( "#cod_label" ).val( "COD" );
		
		jQuery( "#cod_msg1" ).val( "Available." );
		
		jQuery( "#cod_msg2" ).val( "Not Available." );
		
		jQuery( "#error_msg_b" ).val( "Please Enter Vaild Pincode." );
		
		jQuery( "#error_msg" ).val( "Sorry, we do not ship to this location." );

		jQuery("input[name=s_s][value='1']").prop("checked",true);
		
		jQuery("input[name=s_s1][value='1']").prop("checked",true);

		jQuery("input[name=cod_p][value='1']").prop("checked",true);
		
		jQuery("input[name=show_s_on_pro][value='0']").prop("checked",true);
		
		jQuery("input[name=show_c_on_pro][value='0']").prop("checked",true);
		
		jQuery("input[name=show_d_est][value='1']").prop("checked",true);
		
		jQuery("input[name=show_cod_a][value='1']").prop("checked",true);
		
		jQuery("input[name=show_d_d_on_pro][value='1']").prop("checked",true);
		
		jQuery("input[name=auto_pch][value='0']").prop("checked",true);
		
		jQuery("input[name=auto_pchs][value='0']").prop("checked",true);
		
		jQuery("input[name=auto_pch_v][value='1']").prop("checked",true);
		
		jQuery("input[name=auto_pch_bu][value='0']").prop("checked",true);
		
		jQuery("input[name=del_date][value='1']").prop("checked",true);
		
		jQuery("input[name=cod][value='1']").prop("checked",true);
			
});

</script>
<style>
.form-table th {
    width: 270px;
	padding: 25px;
}

.form-table td {
	
    padding: 20px 10px;
}

.form-table {
	background-color: #fff;
}

h3 {
    padding: 10px;
}

.px-multiply{ color:#ccc; vertical-align:bottom;}

.long{ display:inline-block; vertical-align:middle; }

.wid{ display:inline-block; vertical-align:middle;}

.up{ display:block;}

.grey{ color:#b0adad;}

</style>