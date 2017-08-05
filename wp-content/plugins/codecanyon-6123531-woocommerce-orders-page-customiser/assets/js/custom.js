jQuery(document).ready(function($){
  var table_type   = wc_opc_settings.table_type;
  var input_method = wc_opc_settings.input_method;
  var table_size   = wc_opc_settings.table_size;
  var width        = wc_opc_settings.cols_width_percent;
  var px           = '%';

  
  if(table_type == 'static' ){
    $('.wp-list-table').width(table_size);
  }
  $('.wp-list-table').addClass('resizablecolumns');

  if(table_type == 'static' && input_method == 'defined_values'){
    width = wc_opc_settings.cols_width_pixels;
    px = 'px';
  }
    
  $.each(width, function(index, val) {
    $('#'+index).css({
      width:val+px
    });
  });

});