/*
 * NOTE: all actions are prefixed by plugin shortnam_action_name
 */

jQuery(function($) {

	// stylings
	$('#wooconvo-send').find('textarea').css({
		'width' : '100%'
	});
	
	
	//showing/hiding convos
	$(".nm-wooconvo-subject").click(function(){
		
		var _convo_item = $(this).parent();
		_convo_item.find(".nm-wooconvo-message, .nm-wooconvo-files").slideToggle(500);		
	});
	
	//expand all message
	$("a.nm-wooconvo-expand-all").click(function(){
		
		if(nm_wooconvo_vars.collapse_all === $(this).html()){
			$(this).html(nm_wooconvo_vars.expand_all);	
			$(".nm-wooconvo-message, .nm-wooconvo-files").slideUp(500);
		}else{
			$(this).html(nm_wooconvo_vars.collapse_all);
			$(".nm-wooconvo-message, .nm-wooconvo-files").slideDown(500);
		}
			
		
	});

	$('.nm-open-uploader').click(function(event) {
		event.preventDefault();
		$('.nm-uploader-area').toggle(400);
	});
});

function send_order_message() {

	show_working('sending-order-message', false);

	var _wrapper = jQuery("#wooconvo-send");
	var message = _wrapper.find('.textarea').val();

	if (message != '') {
		
		_wrapper.find('.textarea').css({'border':''});
		
		var files_attached = Array();
		jQuery('input[name^="thefile_wooconvo_file"]').each(function(i, item){
			//console.log(item);
			files_attached.push( jQuery(item).val() );
		});
		
	
		var data = 'message=' + message;
		data = data + '&is_admin='+ _wrapper.find('input[name="is_admin"]').val();
		data = data + '&existing_convo_id='+ jQuery('input[name="existing_convo_id"]').val();
		data = data + '&order_id='+ _wrapper.find('input[name="order_id"]').val();
		data = data + '&nm_wooconvo_nonce='+ jQuery('input[name="nm_wooconvo_nonce"]').val();
		data = data + '&files='+ files_attached;
		data = data + '&action=nm_wooconvo_send_message';

		jQuery.post(nm_wooconvo_vars.ajaxurl, data, function(resp) {
			console.log(resp);
			if(resp.status == 'error'){
				jQuery('#sending-order-message').html(resp.message);
			}else{
				jQuery('#sending-order-message').html(resp.message);
				var last_msg = resp.last_message;
				jQuery('ol.chat').append(resp.last_message);
				_wrapper.find('.textarea').val('');
			}
			

		});
	}else{
		
		_wrapper.find('.textarea').effect('shake');
		// _wrapper.find('.textarea').css({'border':'1px solid red'});
		show_working('sending-order-message', true);
	}

	return false;
}

function get_option(key) {

	/*
	 * TODO: change plugin shortname
	 */
	var keyprefix = 'nm_wooconvo';

	key = keyprefix + key;

	var req_option = '';

	jQuery.each(nm_wooconvo_vars.settings, function(k, option) {

		// console.log(k);

		if (k == key)
			req_option = option;
	});

	// console.log(req_option);
	return req_option;

}

// a function showing working gif
function show_working(element, off) {

	var _html = '';
	if (off == false) {
		var _html = '<img src="' + nm_wooconvo_vars.plugin_url
				+ '/images/loading.gif">';
	}

	jQuery('#' + element).html(_html);
}