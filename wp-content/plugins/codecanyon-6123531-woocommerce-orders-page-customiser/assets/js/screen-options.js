function linen_set_col_width( col_id, w_in_px ) {
	if( w_in_px.length == 0 ) {
		jQuery( 'th#' + col_id ).css( 'width', '' );
	}else	if( w_in_px.length == '' ) {
		jQuery( 'th#' + col_id ).css( 'min-width', '100px' );
	} else {
		var val = 'px';
		var table_type = wc_opc_settings.table_type;
		if(table_type == 'dynamic')
			val = '%';
		jQuery( 'th#' + col_id ).css( 'width', w_in_px + val );
	}
}


var xhr = '';
jQuery(function($){
	function performAutosave(){
		if(xhr != '')
			xhr.abort();
		var panel = $(this).parents('div.custom-options-panel');
		var params = panel.find('input, select, textarea').serialize();
		params = params + '&action=save_settings-' + panel.attr('id');
		xhr = $.post(
			ajaxurl,
			params
		);
		// linen_hide_element( this );
	}

	function linen_set_col_width_live() {
		linen_set_col_width( $(this).attr('id'), $(this).val() );
	}
	
	$('#screen-options-wrap div.requires-autosave').find('input, select, textarea').on('change blur', performAutosave);
	$('.linen_set_css').keyup(linen_set_col_width_live);

	$('.hide-column-tog').change(function(){
		var id  = $(this).attr('id');
		    id  = id.substring(0, id.length-5);
		var $el = $('li.linen_order_cols_li[name='+id+']')
		
		if($(this).is(':checked')){
			$el.show();
			if(wc_opc_settings.table_type != 'dynamic'){
				var w = $el.find('input').val();
				if(w == '' || w < 100 ){
					w = $( 'th#' + id ).width();
					if(id == 'cb' || id == 'order_status'){
						if(w < 30)
							w = 30;
					}else{
						if(w < 100)
							w = 150;
					}
					$el.find('input').val(w);
				}
				$( 'th#' + id ).css('width', w+'px');
			}
		}else{
			$el.hide();
		}
	}).trigger('change');
});