(function( $ ) {
	//'use strict';

	/**
	 * All of the code for your admin-specific JavaScript source
	 * should reside in this file.
	 *
	 * Note that this assume you're going to use jQuery, so it prepares
	 * the $ function reference to be used within the scope of this
	 * function.
	 *
	 * From here, you're able to define handlers for when the DOM is
	 * ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * Or when the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and so on.
	 *
	 * Remember that ideally, we should not attach any more than a single DOM-ready or window-load handler
	 * for any particular page. Though other scripts in WordPress core, other plugins, and other themes may
	 * be doing this, we should try to minimize doing that in our own work.
	 */
	
	$(function() {
	     
	     /**
	     * creates ajax request to display Selection list
	     */
	     
	    $('#woo_schedule_selection_type').change( function( ){
		
	    	$('.wdm_selections').remove(); // empty the response
		jQuery('.wdm_selection_details').empty(); //empty the container
		
		if ($('#woo_schedule_selection_type').val() == -1) {
			
			//jQuery('.response-box').append('<div class="alert alert-error">' + woo_single_view_obj.select_least_option_message + '</div>');
			return;
		}
		else
		{
			//display loading animation
                $( '#woo_schedule_selection_type' ).parent().after( '<img src="' + woo_single_view_obj.loading_image_path + '" alt="' + woo_single_view_obj.loading_text + '" id="loading">' );
				
			$.ajax({
				method: "post",
				url: woo_single_view_obj.admin_ajax_path,
				data: {
				    'action':'handle_selection_type',
                                    'selection' : jQuery('#woo_schedule_selection_type').val()
				},
				success:function( data ) {
					
					$('#loading').remove(); //remove loading
					$('.wdm_selection_row').append(data); // Append data to Parent row
				}
			});
		}

	    });
	    
	    /*
	     * Display settings for selected selection
	     */	    
	    
	   $("body").delegate("#woo_schedule_display_selection","click",function(){
		
		jQuery('.wdm_selection_details').empty(); //empty the container
		jQuery('#message').remove();
		if (jQuery('#woo_schedule_selections').val() != null && jQuery('#woo_schedule_selections').val() != -1) {

			//display loading animation
               // $( '#woo_schedule_display_selection' ).before( '<img src="' + woo_single_view_obj.loading_image_path + '" alt="' + woo_single_view_obj.loading_text + '" id="loading">' );
				$( '<img src="' + woo_single_view_obj.loading_image_path + '" alt="' + woo_single_view_obj.loading_text + '" id="loading" class="loading-left">' ).insertAfter('#woo_schedule_display_selection' );	
			$.ajax({
				method: "post",
				url: woo_single_view_obj.admin_ajax_path,
				data: {
				    'action':'display_scheduler_fields',
                                    'selections_id' : $('#woo_schedule_selections').val(),
				    'selection_type' : $('#woo_schedule_selections').attr('selection_type')
				},
				success:function( data ) {
					
                        $( '#loading' ).remove(); //remove loading
					jQuery('.wdm_selection_details').append(data);
				}
			});
			
			//jQuery('#woo_schedule_display_selection').button('reset');
		}else{
			selection_type=jQuery('#woo_schedule_selections').attr('selection_type');
			if(jQuery('#message').length == 0){
				jQuery('.wdm-woo-scheduler-settings').prepend('<div id="message" class="error"><p>' + woo_single_view_obj.please_select_msg + ' ' + selection_type + ' </p></div>')
			}
		}
	    });
	    
	    /*
	     * Update values -- on "Update Values" click
	     */
	    $("body").delegate("#woo_single_view_update_details","click",function(){

		var start_date = $('#wdm_start_date').val();
		var end_date = $('#wdm_end_date').val();

		var checked = [];

		jQuery('[name^="days_of_week"]:checked').each(function(){
		  checked.push((jQuery(this).attr('day_of_week')));
		});

		$('#woo_single_view_update_details').parent().find('p').remove();

		if(validate()) {

		var r = confirm(woo_single_view_obj.confirm_save_msg);

	  	if (r == true) {

		
		$( '<img src="' + woo_single_view_obj.loading_image_path + '" alt="' + woo_single_view_obj.loading_text + '" id="loading" class="loading-left">' ).insertAfter('#woo_single_view_update_details' );	
		$.ajax({
			method: "post",
			url: woo_single_view_obj.admin_ajax_path,
			data: {
			    'action':'update_expiration_details',
			    'start_date' : start_date,
			    'end_date' : end_date,
			    'day_of_week' : checked,
			    'selection_type' : $('#woo_schedule_selections').attr('selection_type'),
			    'selections_id' : $('#woo_schedule_selections').val()
			},
			success:function( data ) {
				$( '#loading' ).remove();
				if (data.indexOf('details updated') > -1) {
					jQuery('#woo_single_view_update_details').after('<p class="bg-success wdm-message"><b>' + woo_single_view_obj.details_updated_msg + '</b></p>');
					data = data.replace('details updated','');
				}
				else if(data.indexOf('Selection empty') > -1){
					jQuery('#woo_single_view_update_details').after('<p class="bg-danger wdm-message"><b>' + woo_single_view_obj.selection_empty_msg + '</b></p>');
					data = data.replace('Selection empty','');
				}
				jQuery('.woo-schedule-existing-details').remove();
				jQuery('#woo_single_view_update_details').parents('.wdm-woo-schedule-category').after(data);
			}
		});
		}
	  }
	//}
	    });
	});
	/*
	 * Delete Product data
	 */
	 $("body").delegate(".wdm_delete_product","click",function(){
		
		//$('#woo_single_view_update_details').parent().find('p').remove();
		
		var r = confirm(woo_single_view_obj.delete_confirm_msg);
		
		var ref = $(this);
		
		if (r == true) {
			
		   $.ajax({
			method: "post",
			url: woo_single_view_obj.admin_ajax_path,
			data: {
			    'action':'remove_product_details',
			    'product_id' : $(this).attr('product_id')
			},
			success:function( data ) {
				
				$('#loading').remove(); //remove loading
				
				if (data.length) {
					
					$(ref).append(data);
				}
				else
				{
					$(ref).parents('tr').remove();
				}
				//jQuery('#woo_single_view_update_details').after(data);
				return false;
			}
		  });
		}
		
		return false;
	 });
	 
	 /*
	 * Delete Product data
	 */
	
	 $("body").delegate(".wdm_delete_term","click",function(){
		
		//$('#woo_single_view_update_details').parent().find('p').remove();
		
		var r = confirm(woo_single_view_obj.delete_confirm_msg);
		
		var ref = $(this);
		
		if (r == true) {
			
		   $.ajax({
			method: "post",
			url: woo_single_view_obj.admin_ajax_path,
			data: {
			    'action':'remove_term_details',
			    'term_id' : $(this).attr('term_id')
			},
			success:function( data ) {
				
				$('#loading').remove(); //remove loading
				$(ref).parents('tr').remove();
				return false;
				//jQuery('#woo_single_view_update_details').after(data);
			}
		  });
		}
		
		return false;
	 });

})( jQuery );