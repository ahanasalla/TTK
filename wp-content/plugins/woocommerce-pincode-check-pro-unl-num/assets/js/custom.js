jQuery(document).ready(function($){
		
		
		
			if(usejs == 1)
			{

				jQuery("#checkpin").click(function(){
					
					//jQuery('.delivery-info').show();
					
					var pin_code = jQuery.trim(jQuery('#pincode_field_id').val());
					
					if(pin_code == '' || pin_code.length < pincode_length || pin_code.length > pincode_length )
					{
						 jQuery('#error_pin').hide();
						 
						jQuery('#error_pin_b').show();
						
						jQuery('.delivery-info-wrap').hide();
						
						jQuery('#pincode_field_id').val('');
					}
					else
					{
						
						jQuery('#error_pin_b').hide();
					
					   jQuery('#error_pin').hide();

					   jQuery('#chkpin_loader').show();
					   
					   jQuery('.delivery-info-wrap2').hide(); 
					   
					   var product_id = jQuery('input[name="add-to-cart"]').val();

					   jQuery.ajax({
								url : MyAjax.ajaxurl,
								type : 'post',
								data : {
								action : 'picodecheck_ajax_submit',
								pin_code : pin_code,
								product_id : product_id
								},
								success : function( response ) 
								{
									
									var result = response.split("####");
									
									if(result[0] == 11)
									{
										jQuery('.ul-disc').html(result[1]);
										
										if(result[2] == cod_msg1){
											
											jQuery('.phoen_chk_avail img').attr('src',right_image);
											
										}else{
											jQuery('.phoen_chk_avail img').attr('src',not_avail);
										}
										
										jQuery('.cash-on-delivery').text(result[2]);
										
										jQuery('.delivery-info-wrap2').show();
										
										jQuery('.delivery-info-wrap').show(); 
										
										jQuery('#avlpin').show();
										
										jQuery('#my_custom_checkout_field2').hide();
										
										jQuery('.pincode_field_id_a').val(pin_code);
										
										//alert(jQuery('#avat').html());
										
										if( show_s_on_pro == 1 && show_c_on_pro != 1 )
										{
											
											jQuery('#avat .pincode_static_text').text('Available at '+pin_code );
											jQuery('#avat .pincode_custom_text').text('('+result[3]+')');
											
											
										}
										else if( show_c_on_pro == 1 && show_s_on_pro != 1 )
										{
											jQuery('#avat .pincode_static_text').text('Available at '+pin_code);
											jQuery('#avat .pincode_custom_text').text('('+result[4]+')');
										
										}
										else if(show_c_on_pro == 1 && show_s_on_pro == 1)
										{
											jQuery('#avat .pincode_static_text').text('Available at '+pin_code);
											jQuery('#avat .pincode_custom_text').text('('+result[4]+', '+result[3]+')');
											
										}
										else
										{
											
											jQuery('#avat').text('Available at '+pin_code);
											
										}
																				
									}
									else if((result[0] == 10))
									{
										
										jQuery('.ul-disc').html(result[1]);
										
										if(result[2] == cod_msg1){
											
											jQuery('.phoen_chk_avail img').attr('src',right_image);
											
										}else{
											jQuery('.phoen_chk_avail img').attr('src',not_avail);
										}
										
										jQuery('.cash-on-delivery').text(result[2]);
										
										jQuery('.delivery-info-wrap2').show();
										
										jQuery('.delivery-info-wrap').show(); 
										
										jQuery('#avlpin').show();
										
										jQuery('#my_custom_checkout_field2').hide();
										
										jQuery('.pincode_field_id_a').val(pin_code);
										
										if( show_s_on_pro == 1 && show_c_on_pro != 1 )
										{
											
											jQuery('#avat .pincode_static_text').text('Available at '+pin_code );
											jQuery('#avat .pincode_custom_text').text('('+result[3]+')');
											
											
										}
										else if( show_c_on_pro == 1 && show_s_on_pro != 1 )
										{
											jQuery('#avat .pincode_static_text').text('Available at '+pin_code);
											jQuery('#avat .pincode_custom_text').text('('+result[4]+')');
										
										}
										else if(show_c_on_pro == 1 && show_s_on_pro == 1)
										{
											jQuery('#avat .pincode_static_text').text('Available at '+pin_code);
											jQuery('#avat .pincode_custom_text').text('('+result[4]+', '+result[3]+')');
											
										}
										else
										{
											
											jQuery('#avat').text('Available at '+pin_code);
											
										}
										
									}
									else
									{
										
										//console.log('else');
										
										jQuery('#chkpin_loader').hide();

										jQuery('#error_pin').show();
										 
										jQuery('#pincode_field_id').val('');
										
										jQuery('.delivery-info-wrap').hide();
										
									}
									
									jQuery('#chkpin_loader').hide();
										
								}
						});

					}

				});

				if(val_pro_page == 1)
				{			
			
					jQuery(".single_add_to_cart_button").click(function() {
					   
						var pin_code_a = jQuery('.pincode_field_id_a').val();
						
						var pin_code = jQuery.trim(jQuery('#pincode_field_id').val());
						
						//alert(pin_code_a+'-'+pin_code);
						
						if(typeof pin_code_a === "undefined" || pin_code_a == "")
						{
							
							if(pin_code == '' || pin_code.length < pincode_length || pin_code.length > pincode_length )
							{
								//alert('1');
								
								jQuery('#error_pin').hide();
								
								jQuery('.delivery-info-wrap').hide();
								 
								jQuery('#error_pin_b').show();
								
								jQuery('#pincode_field_id').val('');
							}
							else
							{
								
									jQuery('#error_pin').hide();
									
									jQuery('#chkpin_loader').show();
									
									jQuery('#error_pin_b').hide();
									
									var product_id = jQuery('input[name="add-to-cart"]').val();

									jQuery.ajax({
										url : MyAjax.ajaxurl,
										type : 'post',
										data : {
										action : 'picodecheck_ajax_submit',
										pin_code : pin_code,
										product_id : product_id
										},
										success : function( response ) 
										{
											
											var result = response.split("####");
											
											//alert(result);
											if(result[0] == 11)
											{
												jQuery('.ul-disc').html(result[1]);
												
												if(result[2] == cod_msg1){
											
													jQuery('.phoen_chk_avail img').attr('src',right_image);
													
												}else{
													jQuery('.phoen_chk_avail img').attr('src',not_avail);
												}
												
												jQuery('.cash-on-delivery').text(result[2]);
												
												jQuery('.delivery-info-wrap2').show(); 
												
												jQuery('.delivery-info-wrap').show(); 
												
												jQuery('#avlpin').show();
												
												jQuery('#my_custom_checkout_field2').hide();
												
												jQuery('.pincode_field_id_a').val(pin_code);
												
												if( show_s_on_pro == 1 && show_c_on_pro != 1 )
												{
													
													jQuery('#avat .pincode_static_text').text('Available at '+pin_code );
													jQuery('#avat .pincode_custom_text').text('('+result[3]+')');
													
													
												}
												else if( show_c_on_pro == 1 && show_s_on_pro != 1 )
												{
													jQuery('#avat .pincode_static_text').text('Available at '+pin_code);
													jQuery('#avat .pincode_custom_text').text('('+result[4]+')');
												
												}
												else if(show_c_on_pro == 1 && show_s_on_pro == 1)
												{
													jQuery('#avat .pincode_static_text').text('Available at '+pin_code);
													jQuery('#avat .pincode_custom_text').text('('+result[4]+', '+result[3]+')');
													
												}
												else
												{
													jQuery('#avat').text('Available at '+pin_code);
												}
												
												jQuery('.cart').submit();

											}
											else if((result[0] == 10))
											{
												
												jQuery('.ul-disc').html(result[1]);
												
												if(result[2] == cod_msg1){
											
													jQuery('.phoen_chk_avail img').attr('src',right_image);
													
												}else{
													
													jQuery('.phoen_chk_avail img').attr('src',not_avail);
												
												}
												
												jQuery('.cash-on-delivery').text(result[2]);
												
												jQuery('.delivery-info-wrap2').show();
												
												jQuery('.delivery-info-wrap').show(); 
												
												jQuery('#avlpin').show();
												
												jQuery('#my_custom_checkout_field2').hide();
												
												jQuery('.pincode_field_id_a').val(pin_code);
												
												if( show_s_on_pro == 1 && show_c_on_pro != 1 )
												{
													
													jQuery('#avat .pincode_static_text').text('Available at '+pin_code );
													jQuery('#avat .pincode_custom_text').text('('+result[3]+')');
													
													
												}
												else if( show_c_on_pro == 1 && show_s_on_pro != 1 )
												{
													jQuery('#avat .pincode_static_text').text('Available at '+pin_code);
													jQuery('#avat .pincode_custom_text').text('('+result[4]+')');
												
												}
												else if(show_c_on_pro == 1 && show_s_on_pro == 1)
												{
													jQuery('#avat .pincode_static_text').text('Available at '+pin_code);
													jQuery('#avat .pincode_custom_text').text('('+result[4]+', '+result[3]+')');
													
												}
												else
												{
													jQuery('#avat').text('Available at '+pin_code);
												}
												
												jQuery('.cart').submit();

											}
											else
											{
												jQuery('#chkpin_loader').hide();

												jQuery('#error_pin').show();
												
												jQuery('.delivery-info-wrap').hide();
												
												jQuery('#error_pin_b').hide();
												 
												jQuery('#pincode_field_id').val('');
												
												
												
											}
											
											jQuery('#chkpin_loader').hide();
											
										}
									});
								 
									return false;
								
							}
						}
						

						var check_vis = jQuery('#my_custom_checkout_field2').is(':visible');
						
						if( check_vis == true)
						{
							if(pin_code == '' || pin_code.length < pincode_length || pin_code.length > pincode_length )
							{
								//alert('1');
								
								jQuery('#error_pin').hide();
								 
								jQuery('#error_pin_b').show();
								
								jQuery('.delivery-info-wrap').hide();
								
								jQuery('#pincode_field_id').val('');
							}
							else
							{	
								
									//alert('2');
									
									jQuery('#error_pin').hide();
									
									jQuery('#error_pin_b').hide();
									
									jQuery('#chkpin_loader').show();
									
									var product_id = jQuery('input[name="add-to-cart"]').val();

										jQuery.ajax({
										url : MyAjax.ajaxurl,
										type : 'post',
										data : {
										action : 'picodecheck_ajax_submit',
										pin_code : pin_code,
										product_id : product_id
										},
										success : function( response )
										{
										
											var result = response.split("####");
											
											//alert(result);
											if(result[0] == 11)
											{
												jQuery('.ul-disc').html(result[1]);
												
												if(result[2] == cod_msg1){
											
													jQuery('.phoen_chk_avail img').attr('src',right_image);
													
												}else{
													
													jQuery('.phoen_chk_avail img').attr('src',not_avail);
													
												}
												
												jQuery('.cash-on-delivery').text(result[2]);
												
												jQuery('.delivery-info-wrap2').show(); 
												
												jQuery('.delivery-info-wrap').show(); 
												
												jQuery('#avlpin').show();
												
												jQuery('#my_custom_checkout_field2').hide();
												
												jQuery('.pincode_field_id_a').val(pin_code);
												
												if( show_s_on_pro == 1 && show_c_on_pro != 1 )
												{
													
													jQuery('#avat .pincode_static_text').text('Available at '+pin_code );
													jQuery('#avat .pincode_custom_text').text('('+result[3]+')');
													
													
												}
												else if( show_c_on_pro == 1 && show_s_on_pro != 1 )
												{
													jQuery('#avat .pincode_static_text').text('Available at '+pin_code);
													jQuery('#avat .pincode_custom_text').text('('+result[4]+')');
												
												}
												else if(show_c_on_pro == 1 && show_s_on_pro == 1)
												{
													jQuery('#avat .pincode_static_text').text('Available at '+pin_code);
													jQuery('#avat .pincode_custom_text').text('('+result[4]+', '+result[3]+')');
													
												}
												else
												{
													jQuery('#avat').text('Available at '+pin_code);
												}
												
												jQuery('.cart').submit();

											}
											else if((result[0] == 10))
											{
												
												jQuery('.ul-disc').html(result[1]);
												
												if(result[2] == cod_msg1){
											
													jQuery('.phoen_chk_avail img').attr('src',right_image);
													
												}else{
													
													jQuery('.phoen_chk_avail img').attr('src',not_avail);
													
												}
												
												jQuery('.cash-on-delivery').text(result[2]);
												
												jQuery('.delivery-info-wrap2').show();
												
												jQuery('.delivery-info-wrap').show(); 
												
												jQuery('#avlpin').show();
												
												jQuery('#my_custom_checkout_field2').hide();
												
												jQuery('.pincode_field_id_a').val(pin_code);
												
												if( show_s_on_pro == 1 && show_c_on_pro != 1 )
												{
													
													jQuery('#avat .pincode_static_text').text('Available at '+pin_code );
													jQuery('#avat .pincode_custom_text').text('('+result[3]+')');
													
													
												}
												else if( show_c_on_pro == 1 && show_s_on_pro != 1 )
												{
													jQuery('#avat .pincode_static_text').text('Available at '+pin_code);
													jQuery('#avat .pincode_custom_text').text('('+result[4]+')');
												
												}
												else if(show_c_on_pro == 1 && show_s_on_pro == 1)
												{
													jQuery('#avat .pincode_static_text').text('Available at '+pin_code);
													jQuery('#avat .pincode_custom_text').text('('+result[4]+', '+result[3]+')');
													
												}
												else
												{
													jQuery('#avat').text('Available at '+pin_code);
												}
												
												jQuery('.cart').submit();
							
											}
											else
											{
												jQuery('#chkpin_loader').hide();

												jQuery('#error_pin').show();
												
												jQuery('.delivery-info-wrap').hide();
												 
												jQuery('#pincode_field_id').val('');
												
											}
											
											jQuery('#chkpin_loader').hide();
											
										}
									});
									 
									return false;
								
							}
							
						}
						   
						//alert(check_vis);
					});
				
				}
				
			}


			if ($('#billing_postcode').length > 0) {
				
			   $("#billing_postcode").attr("maxlength", pincode_length);
			   
			}
			
			if ($('#shipping_postcode').length > 0) {
			   
			   $("#shipping_postcode").attr("maxlength", pincode_length);
			}
			
			if ($('#calc_shipping_postcode').length > 0) {
			   
			   $("#calc_shipping_postcode").attr("maxlength", pincode_length);
			}
		
		
		
			$(this).on( 'change', '.woocommerce-checkout .form-row input', function() {
				
				//console.log( 'change' );

				updated_checkout();
				
				//console.log( remove_cod );
				
			});
			
			jQuery(document.body).on('updated_checkout', function(){
				
				//console.log( 'body' );
				
				//console.log( remove_cod );
				
				updated_checkout();
				
			});
			
			function updated_checkout()
			{
				
				var $this = jQuery('#ship-to-different-address-checkbox');
                
				if( $this.is(':checked') == true )
		     	{
                                
					jQuery("#billing_postcode").removeClass("error_class"); 
					
					jQuery("#shipping_postcode").removeClass("error_class"); 

					var pin_code = jQuery('#shipping_postcode').val();
					
					jQuery('.checkout').block({message: null, overlayCSS: { background: '#fff', opacity: 0.6 }});

					jQuery.ajax({
						url : MyAjax.ajaxurl,
						type : 'post',
						data : {
						action : 'picodecheck_ajax_submit_out',
						pin_code : pin_code
						},
						success : function( response )
						{
							//console.log('checkout if');
							
							var json_obj = jQuery.parseJSON( response );
							 
							//console.log( json_obj.json );
							//console.log( json_obj.json.error );	
							//console.log( json_obj.json.cod );	
							
							if( json_obj.json.error > 0)
							{
								//console.log('chekif if');
								
								if( remove_cod == 1 )
								{
																		
									jQuery('li.payment_method_cod').html('');
									
									jQuery('.chng_pincode_checkout').text(pin_code);
									
									jQuery('#remove_pro_popup_id').show();
									
									jQuery('div.place-order #place_order').remove();
									
								}
								
								

							}
							else
							{
								//console.log('check_if else');
								

								if( remove_cod == 1 )
								{
									
									if(json_obj.json.cod == 'yes')
									{
										
										var cod_html = jQuery('.phoen-cod-html-div').html();
										
										var place_order_button = jQuery('.phoen-place-order-html-div').html();
										
										jQuery('li.payment_method_cod').html(cod_html);
											
										
									}
									else
									{  
										
										jQuery('li.payment_method_cod').html('');
										
									}
									
									jQuery('#remove_pro_popup_id').hide();
								
								}
								if(remove_place_order == 1){
											
									if(json_obj.json.cod == 'yes')
									{
										
										var place_order_button = jQuery('.phoen-place-order-html-div').html();
										
										jQuery('li.payment_method_cod').html(cod_html);
																	
										if(jQuery('div.place-order').find('#place_order').length == 0){
											
											jQuery('div.place-order').append(place_order_button);
											
										}
										
									}
									else
									{
										
										jQuery('div.place-order #place_order').remove();
										
									}
									
								} 
																
							}
							
							jQuery('.checkout').unblock();

						}
					}); 
						

				} else {

					var pin_code = jQuery('#billing_postcode').val();

					jQuery("#billing_postcode").removeClass("error_class"); 
                    
					jQuery('.checkout').block({message: null, overlayCSS: { background: '#fff', opacity: 0.6 }});

					jQuery.ajax({
						url : MyAjax.ajaxurl,
						type : 'post',
						data : {
						action : 'picodecheck_ajax_submit_out',
						pin_code : pin_code
						},
						success : function( response )
						{
							
							var json_obj = jQuery.parseJSON( response );
							
							//console.log(json_obj);
							//console.log('checkout else');
							//console.log( json_obj.json );
							//console.log( json_obj.json.error );	
							//console.log( json_obj.json.cod );	
							
							if( json_obj.json.error > 0)
							{
								//console.log('checkout else if');
								
								if( remove_cod == 1 )
								{
									
									jQuery('div.place-order #place_order').remove();
																		
									var cod_html = jQuery('li.payment_method_cod ').html();
									
									console.log(cod_html);
									
									jQuery('li.payment_method_cod').html('');
									
									jQuery('.chng_pincode_checkout').text(pin_code);
									
									jQuery('#remove_pro_popup_id').show();
								
								}
								
								
								
							}
							else
							{
								
								if( remove_cod == 1 )
								{
									
									if(json_obj.json.cod == 'yes')
									{
										var place_order_button = jQuery('.phoen-place-order-html-div').html();
										
										if(remove_place_order == 1){
									
											if(jQuery('div.place-order').find('#place_order').length == 0){
												
												jQuery('div.place-order').append(place_order_button);
													
											}
										} 
										
										var cod_html = jQuery('.phoen-cod-html-div').html();
										
										jQuery('li.payment_method_cod').html(cod_html);
										
									}
									else
									{
										if(remove_place_order == 1){
									
											jQuery('div.place-order #place_order').remove();
											
										}
										
										var cod_html = jQuery('li.payment_method_cod ').html();
									
										//console.log(cod_html);
										 
										jQuery('li.payment_method_cod').html('');
										
									}
									
									jQuery('#remove_pro_popup_id').hide();
								
								}
								
							     
							}
							
							jQuery('.checkout').unblock();
							

						}
						
					}); 

				}
				
			}   

            jQuery('body').bind('click',function(e){
 
                jQuery('.delivery_help_text_main').hide();
                
                jQuery('.cash_on_delivery_help_text_main').hide();
                
             });
			 
			 jQuery("#delivery_help_a").click( function(e){
		  
				e.stopPropagation();

				jQuery('.delivery_help_text_main').show();

				jQuery('.cash_on_delivery_help_text_main').hide();

			});


			jQuery("#cash_n_delivery_help_a").click( function(e){
			  
				e.stopPropagation();

				jQuery('.cash_on_delivery_help_text_main').show();

				jQuery('.delivery_help_text_main').hide();

			});

			jQuery("#delivery_help_x").click( function(e){
			  
				e.stopPropagation();

				jQuery('.delivery_help_text_main').hide();

			});

			jQuery("#cash_n_delivery_help_x").click( function(e){
			  
				e.stopPropagation();

				jQuery('.cash_on_delivery_help_text_main').hide();


			});

			jQuery(".delivery_help_text").click( function(e){
			  
				e.stopPropagation();

			});

        
			jQuery(".cash_on_delivery_help_text").click( function(e){
			  
				e.stopPropagation();

			});
        
			jQuery("#change_pin").click(function(){
		
				jQuery('#my_custom_checkout_field2').show();

				jQuery('#avlpin').hide();

			});
		
			// process the form
			jQuery('#pho_home_pck').submit(function(event) {
					
				var pin_code = jQuery.trim( jQuery('#enter_pincode').val() );
				
				if( pin_code == ''  || pin_code.length < pincode_length || pin_code.length > pincode_length )
				{
					
					jQuery('#error_pinn').hide();
					 
					jQuery('#error_pin_bn').show();
					
					jQuery('#enter_pincode').val('');
					
				}
				else
				{
					
					var formURL = $(this).attr("action");
					
					var site_url = $(this).attr("data-siteurl");
					
					jQuery('#error_pin_bn').hide();

					jQuery('#error_pinn').hide();

					jQuery('.delivery-info-wrap2').hide(); 
					
					jQuery('#home_chkpin_loader').show();

					jQuery.ajax({
							url : MyAjax.ajaxurl,
							type : 'post',
							data : {
							action :  'picodecheck_ajax_submit_home',
							pin_code : pin_code
							},
							success : function( response ) 
							{
								jQuery('#home_chkpin_loader').hide();
								
								var result = response.split("####");
								
								if( result[0] == 11 || result[0] == 10 )
								{
									
									jQuery('.pho-close_btn ').show();										
									
									jQuery('.pho-para p').text(pincode_success_msg+'( '+ pin_code +' ).');
									
									
								}
								else
								{

									jQuery('#error_pinn').show();
									 
									jQuery('#enter_pincode').val('');
									
									jQuery('#error_pin_bn').hide();
									
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
		
				}
				
				event.preventDefault();
					
			});
			
			
			jQuery('#pho_home_pck_shop').submit(function(event) {
					
				var pin_code = jQuery.trim( jQuery('#enter_pincode_shop').val() );
				
				jQuery('#shop_chkpin_loader').show();
				
				if( pin_code == ''  || pin_code.length < pincode_length || pin_code.length > pincode_length )
				{
					jQuery('#shop_chkpin_loader').hide();
					
					jQuery('#error_pin_shop').hide();
					 
					jQuery('#error_pin_b_shop').show();
					
					jQuery('#enter_pincode_shop').val('');
					
				}
				else
				{
					
					var formURL = $(this).attr("action");
					
					var site_url = $(this).attr("data-siteurl");
					
					var product_id = jQuery.trim( jQuery('#popup_pro_id_shop').val() );
					
					jQuery('#error_pin_b_shop').hide();

					jQuery('#error_pin_shop').hide();

					jQuery('.delivery-info-wrap2').hide();
					
					jQuery.ajax({
							url : MyAjax.ajaxurl,
							type : 'post',
							data : {
							action :  'picodecheck_ajax_submit',
							pin_code : pin_code,
							product_id : product_id
							},
							success : function( response ) 
							{
								
								var result = response.split("####");
								
								//console.log( result );
								
								
								if( result[0] == 11 || result[0] == 10 )
								{
									jQuery('#shop_chkpin_loader').hide(); 
									
									jQuery('#cookie_pin_shop').val( pin_code );
									
									jQuery('.phoen_chk_pncde_anmt_div').addClass(woocommerce_pincode_params.exit);
												
									setTimeout(function(){
										
										jQuery('.pho-popup-body-shop').hide();
										
										jQuery('.phoen_chk_pncde_anmt_div').removeClass(woocommerce_pincode_params.exit);
								
									}, 1000);
									
									
									
									//console.log(jQuery(".ajax_add_to_cart[data-product_id='"+product_id+"']"));
									
									jQuery(".ajax_add_to_cart[data-product_id='"+product_id+"']").trigger("click");
									
									//jQuery('#cookie_pin_shop').val( '' );
					 
									jQuery('#popup_pro_id_shop').val( '' );
									
									jQuery('#enter_pincode_shop').val('');
									
								}
								else
								{
									jQuery('#shop_chkpin_loader').hide(); 
									
									jQuery('#error_pin_shop').show();
									 
									jQuery('#enter_pincode_shop').val('');
									
									jQuery('#error_pin_b_shop').hide();
									
									//return false;
									
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
		
				}
				
				event.preventDefault();
					
			});

			/*jQuery(".pho-close_btn").click( function(e) {
				 
				 jQuery('.pho-popup-body').fadeOut();
			   
			});*/
			
			jQuery(".pho-close_btn_shop").click( function(e) {
				 
				// jQuery('.pho-popup-body-shop').fadeOut();
			   
			});
			
	});

	(function($){
		
		$(window).load(function(){
			
			if(usejs == 1)
			{
				
				$.mCustomScrollbar.defaults.theme="light-2";
				
				$(".delivery_help_text").mCustomScrollbar();
				
				$(".cash_on_delivery_help_text").mCustomScrollbar();
				
			}

			var section = $('.wc-delivery-time-response .delivery-info');
			
			var section2 = $('.wc-delivery-time-response .pin_div');
			
				var dwidth = section.width();
				
				var dwidth2 = section2.width();
				
				if(dwidth < 420 || dwidth2 < 420)	{
					
					//alert(dwidth);
					
					section.addClass('full');
					
					section2.addClass('full');
					
				}		
		});
		
		$(window).resize(function(){
			
			var section = $('.wc-delivery-time-response .delivery-info');
			
			var section2 = $('.wc-delivery-time-response .pin_div');
			
			if($(window).width() < 479)
			{
			
				section.addClass('full');
					
				section2.addClass('full');
					
			}
			else
			{
				section.removeClass('full');
				
				section2.removeClass('full');
				
			}
			
		});	

	})(jQuery);
