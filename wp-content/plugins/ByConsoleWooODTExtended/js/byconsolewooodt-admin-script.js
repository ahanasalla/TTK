function locationDelete(str){
	alert(str);
	jQuery('fieldset.'+str).remove();
	}
jQuery(document).on('click','#del_pickup',function(e){
 var alert_confirmation = confirm("If any order was placed for this location in past, would not be able to show this location any more on order details section.");
	
	if (alert_confirmation == true) {
		var plickup_location_to_remove=jQuery(this).attr("class");
		jQuery('fieldset.'+plickup_location_to_remove).remove();
	} else {		
	}
	
	})
	
jQuery(document).on('click','#del_delivery',function(e){
 var alert_confirmation = confirm("If any order was placed for this location in past, would not be able to show this location any more on order details section.");
	
	if (alert_confirmation == true) {
		var delivery_location_to_remove=jQuery(this).attr("class");
		jQuery('fieldset.'+delivery_location_to_remove).remove();
	} else {		
	}
	
	})	
//jQuery("#byconsolewooodt_as_early_as_possible_and_exact_time_text_lable_enable").click(function(){		
//		if(jQuery("#byconsolewooodt_as_early_as_possible_and_exact_time_text_lable_enable").prop('checked') === true){
//			jQuery("#byconsolewooodt_as_early_as_possible_lable_content").css("display","block");
//			jQuery("#byconsolewooodt_exact_time_lable_content").css("display","block");
//			jQuery("#byconsolewooodt_as_early_as_possible_lable_content_text").css("display","block");
//			jQuery("#byconsolewooodt_exact_time_lable_content_text").css("display","block");
//        }else{
//			jQuery("#byconsolewooodt_as_early_as_possible_lable_content").css("display","none");
//			jQuery("#byconsolewooodt_exact_time_lable_content").css("display","none");
//			jQuery("#byconsolewooodt_as_early_as_possible_lable_content_text").css("display","none");
//			jQuery("#byconsolewooodt_exact_time_lable_content_text").css("display","none");
//        }
//});