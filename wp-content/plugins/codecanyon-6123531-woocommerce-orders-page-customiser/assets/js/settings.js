var pagenow = 'edit-shop_order';
jQuery(document).ready(function($){
    var resize_data;
    var full_width = $('#wpbody').width();
    var size = $('#wc_order_page_columns thead th').length;
    var max_w = size*150;
    var min_w = $('#mainform').width()-20;
    var cur_w = $('#wc_order_customiser_table_width').val();
    var destroyed     = true;
    var input_method  = $('#wc_order_customiser_column_width_input_method').val();
    var table_type    = $('input[name="wc_order_customiser_table_type"]:checked').val();
    var $table        = $('#wc_order_page_columns');
    var $tableHeaders = $('#wc_order_page_columns thead tr th');

    


    /****************/
    function parsePercentWidth(el) {
      var width = el.outerWidth() / $table.width() * 100;
      width = width.toFixed(2);
      width = width > 0 ? width : 0;
      return width;
    };
    function parsePixelWidth(el) {
      return el.width();
    };
    function saveColumnsSize(){
      $tableHeaders.each(function(index, el) {
          var $el;
          $el = $(el);
          if ($el.attr('data-noresize') == null) {
            var id = $el.attr('id');
            var percent_width = parsePercentWidth($el);
            var pixels_width  = parsePixelWidth($el);
            $('.dynamic_defined_values .column-'+id+' input').val(percent_width);
            $('.static_defined_values .column-'+id+' input').val(pixels_width);
          }
      });

    }

    function setColumnsSize(){
      if(table_type == 'static' && input_method == 'defined_values' ){
        console.log(input_method);
        $('.static_defined_values input').each(function(index, el) {
          var width  = $(el).val();
          var headid = $(el).data('headid');
          if(width != ''){
            $('#'+headid).css('width', width+'px');
          }else{
            $('#'+headid).css('width', '60px');
          }
        });
      }
      else{
        $('.dynamic_defined_values input').each(function(index, el) {
          var width  = $(el).val();
          var headid = $(el).data('headid');
          if(width != ''){
            $('#'+headid).css('width', width+'%');
          }else{
            $('#'+headid).css('width', '5%');
          }
        });
      }
    }

    startResizeTable = function(){
      $("#wc_order_page_columns").resizableColumns({
        stop : saveColumnsSize,
        store: null
      });
      resize_data = $("#wc_order_page_columns").data('resizableColumns');
      destroyed   = false;
    }
    function syncHandleWidths(){
      if(input_method == 'draggable'){
        if(destroyed === true){
          startResizeTable();
        }else{
          resize_data.syncHandleWidths();
        }
      }
    }
    
    /****************/
    $('.static_defined_values input').change(function(){
      var id    = $(this).data('headid');
      var width = $(this).val();
      var form_w = $('#mainform').width();
      var summ = 0;
      $('.static_defined_values input').each(function(index, el) {
        var w = parseInt($(el).val());
        summ += w;
      });

      $('#'+id).css('width', width+'px');
      var tw = summ + $('.static_defined_values input').length*20;
      $("#wc_order_page_columns").width(tw);

      setColumnsSize();
    });

    $('.dynamic_defined_values input').change(function(){
      
      var width = $(this).val();
      if (width>100) width = 100;

      var $parent = $(this).closest('td') ;
      var id    = $(this).data('headid');
      
      var summ = 0;
      $('.dynamic_defined_values input').each(function(index, el) {
        var w = parseFloat($(el).val());
        if(summ+w > 100){
          $(el).val(parseFloat(100-summ));
          w = parseFloat(100-summ);
          summ += w;
        }else{
          summ += w;
        }
      });
      
      if(summ < 100){
        var last_w = parseFloat($('.dynamic_defined_values input').last().val());
        var diff = 100-summ-last_w;
        if(diff < 0) diff = 1;
        $('.dynamic_defined_values input').last().val(diff);
      }
      setColumnsSize();
    });
      
    $('input[name="wc_order_customiser_table_type"], #wc_order_customiser_column_width_input_method').change(function(event) {     
      
      table_type   = $('input[name="wc_order_customiser_table_type"]:checked').val();
      input_method = $('#wc_order_customiser_column_width_input_method').val();
      if(table_type == 'static'){
        
        if(input_method == 'draggable'){
          cur_w = $('#wc_order_customiser_table_width').val();
          $("#wc_order_page_columns").width(cur_w);
          $("#table_wc_order_customiser_table_width").show();
          $("#wc_order_page_columns tr.static_defined_values, #wc_order_page_columns tr.dynamic_defined_values").hide();
        }else{
          $('.static_defined_values input').first().trigger('change');
          $("#table_wc_order_customiser_table_width").hide();
          $('#wc_order_page_columns').resizableColumns('destroy');
          destroyed = true;
          $("#wc_order_page_columns tr.static_defined_values").show();
          $("#wc_order_page_columns tr.dynamic_defined_values").hide();
        }
      }else{
        $('.dynamic_defined_values input').first().trigger('change');
        $('#wc_order_page_columns').resizableColumns('destroy');
        destroyed = true;
        $("#wc_order_page_columns").removeAttr('style');
        $("#table_wc_order_customiser_table_width").hide();
        if(input_method == 'draggable'){
          $("#wc_order_page_columns tr.static_defined_values, #wc_order_page_columns tr.dynamic_defined_values").hide();
        }else{
          $("#wc_order_page_columns tr.static_defined_values").hide();
          $("#wc_order_page_columns tr.dynamic_defined_values").show();          
        }
      }
      setColumnsSize();
      syncHandleWidths();
    }).first().trigger('change');


    $('#wc_order_customiser_table_width').change(function(){
      var val = $(this).val();
        $("#wc_order_page_columns").width(val);
        syncHandleWidths();
    });

  var linen_cols_order;
  jQuery( ".linen_sortable" ).sortable({
      stop: function( event, ui ) {
        item_name = ui.item.attr('name');
        linen_cols_order = [];
        jQuery('.linen_order_cols_li').each(function(){
          linen_cols_order.push( jQuery(this).attr('name') );
        });
        jQuery.post( ajaxurl, {'items': linen_cols_order, 'item_name': item_name, 'action': 'linen_cols_order'}, function( data ) {
          data = jQuery.parseJSON(data);
          
          if( typeof data == 'object' ) {

            // Fix the checkbox problem!
            data.related_element = ( data.related_element.indexOf('cb') !== -1 )?data.related_element+',.check-column':data.related_element;

            data.item_name = ( data.item_name.indexOf('cb') !== -1 )?data.item_name+',.check-column':data.item_name;

            if( data.action == 'before' ) {
              // Place the column with name data.item_name after/before (data.action) the data.related_element
              jQuery('#wc_order_page_columns tr').children('.column-' + data.related_element ).each(function(){
                jQuery(this).before( jQuery(this).siblings('.column-' + data.item_name ) ); // This moves the inside the siblings to BEFORE the this - dev comment 
              })
            } else {
              jQuery('#wc_order_page_columns tr').children('.column-' + data.related_element ).each(function(){
                jQuery(this).after( jQuery(this).siblings('.column-' + data.item_name ) ); // This moves the inside the siblings to BEFORE the this - dev comment 
              })  
            }
            
            syncHandleWidths();
          }
        } );
      }
  });

});