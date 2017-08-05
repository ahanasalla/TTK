jQuery("#checkpin").click(function(){

	var pin_code = jQuery.trim(jQuery('#pincode_field_id').val());
	
	if(pin_code == '')
	{
		 jQuery('#error_pin').hide();
		 
		jQuery('#error_pin_b').show();
		
		jQuery('#pincode_field_id').val('');
	}
	else
	{
		if(/^\d{6}$/.test(pin_code) == true)
		{
			
			jQuery('#error_pin_b').hide();
		
		   jQuery('#error_pin').hide();

		   jQuery('#chkpin_loader').show();
		   
		   jQuery('.delivery-info-wrap2').hide(); 

		   jQuery.ajax({
					url : MyAjax.ajaxurl,
					type : 'post',
					data : {
					action : 'picodecheck_ajax_submit',
					pin_code : pin_code
					},
					success : function( response ) 
					{
						
						var result = response.split("####");
						
						//alert(result);
						if(result[0] == 11)
						{
							jQuery('.ul-discw').html(result[1]);
							
							jQuery('.cash-on-delivery').text(result[2]);
							
							jQuery('.delivery-info-wrap2').show();
							
							jQuery('#avlpin').show();
							
							jQuery('#my_custom_checkout_field2').hide();
							
							jQuery('.pincode_field_id_a').val(pin_code);
							
							if(show_s_on_pro == 1)
							{
								jQuery('#avat').text('Available at '+pin_code+'('+result[3]+')');
							}
							else
							{
								jQuery('#avat').text('Available at '+pin_code);
							}
						}
						else if((result[0] == 10))
						{
							
							jQuery('.ul-discw').html(result[1]);
							
							jQuery('.cash-on-delivery').text(result[2]);
							
							jQuery('.delivery-info-wrap2').show();
							
							jQuery('#avlpin').show();
							
							jQuery('#my_custom_checkout_field2').hide();
							
							jQuery('.pincode_field_id_a').val(pin_code);
							
							if(show_s_on_pro == 1)
							{
								jQuery('#avat').text('Available at '+pin_code+'('+result[3]+')');
							}
							else
							{
								jQuery('#avat').text('Available at '+pin_code);
							}
							
						}
						else
						{
							jQuery('#chkpin_loader').hide();

							jQuery('#error_pin').show();
							 
							jQuery('#pincode_field_id').val('');
							
						}
						
						jQuery('#chkpin_loader').hide();
							
					}
			});

		}
		else
		{
			jQuery('#error_pin_b').hide();

			jQuery('#error_pin').show();
			
			jQuery('#pincode_field_id').val('');

		}
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
			
			if(pin_code == '')
			{
				//alert('1');
				
				jQuery('#error_pin').hide();
				 
				jQuery('#error_pin_b').show();
				
				jQuery('#pincode_field_id').val('');
			}
			else
			{
				if(/^\d{6}$/.test(pin_code) == true)
				{
					jQuery('#error_pin').hide();
					
					jQuery('#chkpin_loader').show();
					
					jQuery('#error_pin_b').hide();
					
					jQuery.ajax({
						url : MyAjax.ajaxurl,
						type : 'post',
						data : {
						action : 'picodecheck_ajax_submit',
						pin_code : pin_code
						},
						success : function( response ) 
						{
							
							var result = response.split("####");
							
							//alert(result);
							if(result[0] == 11)
							{
								jQuery('.ul-discw').html(result[1]);
								
								jQuery('.cash-on-delivery').text(result[2]);
								
								jQuery('.delivery-info-wrap2').show(); 
								
								jQuery('#avlpin').show();
								
								jQuery('#my_custom_checkout_field2').hide();
								
								jQuery('.pincode_field_id_a').val(pin_code);
								
								if(show_s_on_pro == 1)
								{
									jQuery('#avat').text('Available at '+pin_code+'('+result[3]+')');
								}
								else
								{
									jQuery('#avat').text('Available at '+pin_code);
								}
								
								jQuery('.cart').submit();

							}
							else if((result[0] == 10))
							{
								
								jQuery('.ul-discw').html(result[1]);
								
								jQuery('.cash-on-delivery').text(result[2]);
								
								jQuery('.delivery-info-wrap2').show();
								
								jQuery('#avlpin').show();
								
								jQuery('#my_custom_checkout_field2').hide();
								
								jQuery('.pincode_field_id_a').val(pin_code);
								
								if(show_s_on_pro == 1)
								{
									jQuery('#avat').text('Available at '+pin_code+'('+result[3]+')');
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
								
								jQuery('#error_pin_b').hide();
								 
								jQuery('#pincode_field_id').val('');
								
							}
							
							jQuery('#chkpin_loader').hide();
							
						}
					});
				 
					return false;
				}
				else
				{
					jQuery('#error_pin_b').hide();
				
					jQuery('#error_pin').show();
						
					jQuery('#pincode_field_id').val('');
						
					return false;
				
				}
			}
		}
		

		var check_vis = jQuery('#my_custom_checkout_field2').is(':visible');
		
		if( check_vis == true)
		{
			if(pin_code == '')
			{
				//alert('1');
				
				jQuery('#error_pin').hide();
				 
				jQuery('#error_pin_b').show();
				
				jQuery('#pincode_field_id').val('');
			}
			else
			{	
				if(/^\d{6}$/.test(pin_code) == true)
				{
					//alert('2');
					
					jQuery('#error_pin').hide();
					
					jQuery('#error_pin_b').hide();
					
					jQuery('#chkpin_loader').show();
					
					jQuery.ajax({
						url : MyAjax.ajaxurl,
						type : 'post',
						data : {
						action : 'picodecheck_ajax_submit',
						pin_code : pin_code
						},
						success : function( response )
						{
						
							var result = response.split("####");
							
							//alert(result);
							if(result[0] == 11)
							{
								jQuery('.ul-discw').html(result[1]);
								
								jQuery('.cash-on-delivery').text(result[2]);
								
								jQuery('.delivery-info-wrap2').show(); 
								
								jQuery('#avlpin').show();
								
								jQuery('#my_custom_checkout_field2').hide();
								
								jQuery('.pincode_field_id_a').val(pin_code);
								
								if(show_s_on_pro == 1)
								{
									jQuery('#avat').text('Available at '+pin_code+'('+result[3]+')');
								}
								else
								{
									jQuery('#avat').text('Available at '+pin_code);
								}
								
								jQuery('.cart').submit();

							}
							else if((result[0] == 10))
							{
								
								jQuery('.ul-discw').html(result[1]);
								
								jQuery('.cash-on-delivery').text(result[2]);
								
								jQuery('.delivery-info-wrap2').show();
								
								jQuery('#avlpin').show();
								
								jQuery('#my_custom_checkout_field2').hide();
								
								jQuery('.pincode_field_id_a').val(pin_code);
								
								if(show_s_on_pro == 1)
								{
									jQuery('#avat').text('Available at '+pin_code+'('+result[3]+')');
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
								 
								jQuery('#pincode_field_id').val('');
								
							}
							
							jQuery('#chkpin_loader').hide();
							
						}
					});
					 
					return false;
				}
				else
				{
					//alert('3');
					
					jQuery('#error_pin').show();
					
					jQuery('#error_pin_b').hide();
						
					jQuery('#pincode_field_id').val('');
						
					return false;
				
				}
			}
			
		}
		   
		//alert(check_vis);
	});

}