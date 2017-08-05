<?php
	function phoe_pincode_check()
	{
		
		global $table_prefix, $wpdb,$woocommerce;
		
		$customer = new WC_Customer();
		
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
		
			?>
				<script>
				
					var usejs = 1;
					
				</script>
				
			<?php
			
			$plugin_dir_url =  plugin_dir_url( __FILE__ );

			$ship_pin = $customer->get_shipping_postcode();
			
			$cookie_pin = $_COOKIE['valid_pincode'];
			
			if(!isset($cookie_pin) && $ship_pin != ''){
				
				$cookie_pin = $ship_pin;
				
			}
			
			$num_rows = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM `".$table_prefix."check_pincode_p` where `pincode` = %s" , $cookie_pin ) );
	
			if($num_rows == 0)
			{

				$cookie_pin = '';

			}

			if(isset($cookie_pin) && $cookie_pin != '') {
			
				$qry22 = $wpdb->get_results("SELECT * FROM `".$table_prefix."pincode_setting_p` ORDER BY `id` ASC  limit 1",ARRAY_A);
				
				$query = " SELECT * FROM `".$table_prefix."check_pincode_p` where `pincode` = '$cookie_pin' ";

				$getdata = $wpdb->get_results($query);

				foreach($getdata as $data){

					$dod =  $data->dod;

					$cod =  $data->cod;
					
					$state =  $data->state;

				}


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


				<div style="clear:both;font-size:14px;" class="wc-delivery-time-response wc-delivery-time-response-widget">
					
					<span class='avlpin' id='avlpin'>
					
					<span class="phoe-green-location-icon">
							<img src="<?php echo esc_url( $plugin_dir_url ); ?>assets/img/phoeniixx_pin_location_icon1.jpg" />
						</span>
					
					<p id="avat"><span class="pincode_static_text">Available at <?php echo esc_html( $cookie_pin ); if( $show_s_on_pro == 1 || $show_c_on_pro == 1 ){ echo "</span> <br /><span class='pincode_custom_text'>("; } if($show_c_on_pro == 1){ echo $city; } if( $show_s_on_pro == 1 && $show_c_on_pro == 1 ){ echo ","; } if($show_s_on_pro == 1){ echo $state; } if( $show_s_on_pro == 1 || $show_c_on_pro == 1 ){ echo ")</span>"; } ?></p><a class="button" id='change_pin'><img src="<?php echo esc_url( $plugin_dir_url ); ?>assets/img/phoeniixx_pin_pencil_logo.jpg" /></a></span>

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
						
													<ul class="ul-disc ul-discw">
						
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
															<img height="<?php echo esc_html( $qry22[0]['tt_c_image_size'] ); ?>" width="<?php echo esc_html( $qry22[0]['tt_c_image_size1'] ); ?>" id="delivery_help_x" class="delivery-help-cross" src="<?php echo esc_url( $qry22[0]['tt_c_image'] ); ?>"/>
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
											</div>
											<?php
										}
									?>

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
														<a id="cash_n_delivery_help_a" class="cash-on-delivery-help-icon"><?php if($qry22[0]['help_image'] != ''){ ?><img height="<?php echo esc_html( $qry22[0]['image_size'] ); ?>" width="<?php echo esc_html( $qry22[0]['image_size1'] ); ?>" class="help_icon_img" alt="" src="<?php echo esc_url( $qry22[0]['help_image'] ); ?>"><?php } else { ?> <img class="help_icon_img" alt="?" src="<?php echo esc_url( $plugin_dir_url ); ?>assets/img/phoeniixx_pin_question_mark.jpg"> <?php } ?></a>
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
															
																<img height="<?php echo esc_html( $qry22[0]['tt_c_image_size'] ); ?>" width="<?php echo esc_html( $qry22[0]['tt_c_image_size1'] ); ?>" id="cash_n_delivery_help_x" class="delivery-help-cross" src="<?php echo esc_url( $qry22[0]['tt_c_image'] ); ?>"/>
															
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
											</div>	
												<?php
											}
											?>
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

				$qry22 = $wpdb->get_results( "SELECT * FROM `".$table_prefix."pincode_setting_p` ORDER BY `id` ASC  limit 1"  ,ARRAY_A);	
				
				?>
				<div style="clear:both;font-size:14px;" class="wc-delivery-time-response wc-delivery-time-response-widget">
					
					<span class='avlpin' id='avlpin' style="display:none">
					
					<span class="phoe-green-location-icon">
							<img src="<?php echo esc_url( $plugin_dir_url ); ?>assets/img/phoeniixx_pin_location_icon1.jpg" />
						</span>
					
					<p id="avat"><span class="pincode_static_text">Available at <?php echo esc_html( $cookie_pin ); if( $show_s_on_pro == 1 || $show_c_on_pro == 1 ){ echo "</span><br /> <span class='pincode_custom_text'>("; } if($show_c_on_pro == 1){ echo $city; } if( $show_s_on_pro == 1 && $show_c_on_pro == 1 ){ echo ","; } if($show_s_on_pro == 1){ echo $state; } if( $show_s_on_pro == 1 || $show_c_on_pro == 1 ){ echo ") </span>"; } ?></p><a class="button" id='change_pin'><img src="<?php echo esc_url( $plugin_dir_url ); ?>assets/img/phoeniixx_pin_pencil_logo.jpg" /></a></span>

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
								
															<ul class="ul-disc ul-discw">
							
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
																
																	<img height="<?php echo esc_html( $qry22[0]['tt_c_image_size'] ); ?>" width="<?php echo esc_html( $qry22[0]['tt_c_image_size1'] ); ?>" id="delivery_help_x" class="delivery-help-cross" src="<?php echo esc_url( $qry22[0]['tt_c_image'] ); ?>"/>
																
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
								<?php
								}
								?>
								<div class="cash-on-delivery-info-wrap">

									<div class="cash-on-delivery-info animated">
										<?php
										if($show_cod_a == 1)
										{
										?>
											<div class="header">
											
											<div class="phoe-pincode-pro-tick-img">
												<span class="phoen_chk_avail">
													<img src="<?php echo esc_url( $plugin_dir_url ); ?>assets/img/phoeniixx_pin_cross.jpg" />
												</span>
												<img src="<?php echo esc_url( $plugin_dir_url ); ?>assets/img/phoeniixx_pin_coins.jpg" />
											</div>
											
											<div class="phoe-pincode-pro-tick-img">

											<h6><?php if($cod_label == '' ){ echo "Cash On Delivery"; }else { echo $cod_label; } ?></h6>
											<?php
												
												if($qry22[0]['cod'] == 1)
												{
													?>
														<a id="cash_n_delivery_help_a" class="cash-on-delivery-help-icon"><?php if($qry22[0]['help_image'] != ''){ ?><img height="<?php echo esc_html( $qry22[0]['image_size'] ); ?>" width="<?php echo esc_html( $qry22[0]['image_size1'] ); ?>" class="help_icon_img" alt="" src="<?php echo esc_url( $qry22[0]['help_image'] ); ?>"><?php } else { ?> <img class="help_icon_img" alt="?" src="<?php echo esc_url( $plugin_dir_url ); ?>assets/img/phoeniixx_pin_question_mark.jpg"> <?php } ?></a>
													<?php
												}
												
											?>
											<div class="cash-on-delivery"></div>
											
											<?php
											
											if($qry22[0]['cod'] == 1)
											{
											
											?>
												<div class="cash_on_delivery_help_text_main width_class" style="display:none;">
													<?php
														
														if($qry22[0]['tt_c_image'] != '')
														{
															?>
															
																<img height="<?php echo esc_html( $qry22[0]['tt_c_image_size'] ); ?>" width="<?php echo esc_html( $qry22[0]['tt_c_image_size1'] ); ?>" id="cash_n_delivery_help_x" class="delivery-help-cross" src="<?php echo esc_url( $qry22[0]['tt_c_image'] ); ?>"/>
															
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
												</div>
												<?php
											}
											?>
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
?>