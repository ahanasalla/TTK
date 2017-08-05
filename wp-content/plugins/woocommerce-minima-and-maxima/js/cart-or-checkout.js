jQuery(document).ready(function($) {
	
	$('.woocommerce').on('input change', 'select.shipping_method, input[name^=shipping_method]', function() {
		update_ui_for_shipping_method(false, true);
	});
	
	$( document.body ).on( 'updated_checkout', function() {
		console.log("WC Min/Max: updated_checkout event received");
		update_ui_for_shipping_method(false, true);
	});
	
	// Nothing that follows is needed, or should be loaded, for the cart page
	// 	if ($('.cart-collaterals #shipping_method').length > 0) {
	// 		return;
	// 	}
	
	var current_shipping_method = 'default';

	if ($('#order_review .shipping_method').length > 0) {
		update_ui_for_shipping_method(true, false);
	} else if ($('.cart_totals #shipping_method, .cart_totals select.shipping_method').length > 0) {
		update_ui_for_shipping_method(true, true);
	}
	
	function update_shipping_methods() {
		
		// From woocommerce/assets/frontend/cart.js
		var shipping_methods = [];
		
		var debug = wcminmaxlion.hasOwnProperty('debug') ? wcminmaxlion.debug : false;
		
		$( 'select.shipping_method, input[name^=shipping_method][type=radio]:checked, input[name^=shipping_method][type=hidden]' ).each( function( index, input ) {
			shipping_methods[ $( this ).data( 'index' ) ] = $( this ).val();
		} );
		
		$( 'div.cart_totals' ).block({ message: null, overlayCSS: { background: '#fff url(' + wc_cart_params.ajax_loader_url + ') no-repeat center', backgroundSize: '16px 16px', opacity: 0.6 } });
		
		var data = {
			action: 'woocommerce_update_shipping_method',
			security: wc_cart_params.update_shipping_method_nonce,
			shipping_method: shipping_methods
		};
		
		$.post( wc_cart_params.ajax_url, data, function( response ) {
			
			$( 'div.cart_totals' ).replaceWith( response );
			if (debug) { console.log("update_shipping_methods: trigger updated_shipping_method"); }
			$( 'body' ).trigger( 'updated_shipping_method' );
			
		});
	}
	
	// This includes the instance suffix (WC 2.6+)
	function get_current_shipping_method() {
		var current_shipping_method = '';
		if ($('#shipping_method').length > 0) {
			current_shipping_method = $('#shipping_method input.shipping_method:checked').val();
		} else if ($('#order_review select.shipping_method').length > 0) {
			current_shipping_method = $('#order_review select.shipping_method').first().val();
		} else if ($('.cart_totals select.shipping_method').length > 0) {
			current_shipping_method = $('.cart_totals select.shipping_method').first().val();
		} else if ($('#order_review input.shipping_method').length > 0) {
			current_shipping_method = $('#order_review input.shipping_method').first().val();
		} else {
			current_shipping_method = 'default';
			console.log("WC Minima/Maxima: No shipping method widget found (which is expected if there is no shipping)");
		}
		return current_shipping_method;
	}
	
	function update_ui_for_shipping_method(is_page_load, is_cart) {

		var wcminmax_data = wcminmaxlion.settings;
		
		if (! wcminmax_data === 'undefined') {
			console.log("WC Min/Max: No min/max data found in page: presumably, not relevant to this cart.");
			return;
		}
		
		var debug = wcminmaxlion.hasOwnProperty('debug') ? wcminmaxlion.debug : false;

		current_shipping_method = get_current_shipping_method();
		
		if (debug) {
			console.log("WC Min/Max: update_ui_for_shipping_method: is_cart="+is_cart+" is_page_load="+is_page_load+" current_shipping_method="+current_shipping_method);
		}
		
		if ('' == current_shipping_method) return;
		
		// This part needs to happen on checkout too, not just is_cart

		// 1) If loading the page, if not open with this shipping method but open with others,then switch
		// 2) Decide whether to show the #wcminmax-notpossible info box (if it even exists)

		// console.log('is_open='+is_open+', current_shipping_method='+current_shipping_method);
		if (is_page_load) {
			for (var method in wcminmaxlion.shipping_method_labels) {
				var value = wcminmaxlion.shipping_method_labels.method;
				if (value) {
					$('#shipping_method input.shipping_method[value="'+method+'"]').click();
					$('#shipping_method input.shipping_method[value="'+method+'"]').change();
					// 						$('#shipping_method input.shipping_method[value="'+method+'"]').prop('checked', true);
					// Verify it worked
					new_current_shipping_method = get_current_shipping_method();
					if (new_current_shipping_method != current_shipping_method) {
						console.log('WC Min/Max: change: '+new_current_shipping_method+' '+current_shipping_method+' is_cart='+is_cart);
						current_shipping_method = new_current_shipping_method;
						if (!is_cart) {
							if (debug) { console.log("update_ui_for_shipping_method: trigger update_checkout"); }
							$('body').trigger('update_checkout');
							
						} else if (typeof wc_cart_params !== 'undefined') {
							// Not sure why this doesn't work - much better to call WC's code rather than duplicate it
							//$('select.shipping_method, input[name^=shipping_method]').trigger('change');
							update_shipping_methods();
						}
					}
				}
			}
		}

		$('.woocommerce-info-minmaxinfo').hide();
		
		var current_instance_id = '';
		var instance_regex = /^([^0-9]+):([0-9]+)$/;
		var instance_match = current_shipping_method.match(instance_regex);
		var css_shipping_method = current_shipping_method;
		if (null !== instance_match) {
			css_shipping_method = instance_match[1];
			var current_instance_id = instance_match[2];
			if (debug) {
				console.log("WC Min/Max: method="+current_shipping_method+", instance_id="+current_instance_id+", css_shipping_method="+css_shipping_method);
			}
		}
		
		var css_id = '#wcminmax_minmaxinfo-'+css_shipping_method+'-'+current_instance_id;
		
		if (0 == $(css_id).length) {
			// That was not expected. Seen with Weight Based Shipping which appears to devise its own method IDs on the fly
			console.log("WC Min/Max: not found: "+css_id);
			// This occurred when the actual shipping method and ID was wbs/4
			// current_shipping_method: wbs_0dd3bc79_weight_based_shipping
			// instance_id: 
			var try_regex = /^([a-z]+)_([0-9a-f]+)_(.*)$/;
			console.log(current_shipping_method);
			var try_match = current_shipping_method.match(try_regex);
			console.log(try_match);
			if (null !== try_match) {
				var try_css_class = '.woocommerce-info-minmaxinfo-'+try_match[1];
				if ($(try_css_class).length == 1) {
					if (debug) { console.log("WC Min/Max: show: "+try_css_class); }
					$(try_css_class).show();
				}
			}
		} else {
		
			if (debug) { console.log("WC Min/Max: show: "+css_id); }
			$(css_id).show();
			
		}
		
	}
	
});
