jQuery(document).ready(function ($) {

        $('.expand_all').click(function(){
          scheduler_assign_date_time_picker();
        });


        $('body').on('click', '.woocommerce_variation.wc-metabox', function() {
            var start_date = $(this).find('.wdm_start_date');
            var end_date = $(this).find('.wdm_end_date');
            var variant = $(this);
            scheduler_assign_date_time_picker();
            start_date.on("dp.change",function (e) {
            $('.save-variation-changes').removeAttr('disabled');
            $('.cancel-variation-changes').removeAttr('disabled');
            variant.addClass('variation-needs-update');
            });

            var start_time = $(this).find('.wdm_start_time');
            var end_time = $(this).find('.wdm_end_time');

             start_time.on("dp.change",function (e) {
            $('.save-variation-changes').removeAttr('disabled');
            $('.cancel-variation-changes').removeAttr('disabled');
            variant.addClass('variation-needs-update');
            });

            end_date.on("dp.change",function (e) {
            $('.save-variation-changes').removeAttr('disabled');
            $('.cancel-variation-changes').removeAttr('disabled');
            variant.addClass('variation-needs-update');
            });

            end_time.on("dp.change",function (e) {
            $('.save-variation-changes').removeAttr('disabled');
            $('.cancel-variation-changes').removeAttr('disabled');
            variant.addClass('variation-needs-update');
            });

        });
        
        if ($(".wdm_simple_schedule")[0])
        {
            var start_date = $('.wdm_simple_schedule').find('.wdm_start_date');
            var end_date = $('.wdm_simple_schedule').find('.wdm_end_date');
        
            start_date.datetimepicker({
            /*minDate: moment(),*/
            format : 'MM/DD/YYYY',
            showClear : true,
            useCurrent: true //Important! See issue #1075
            });
            end_date.datetimepicker({
            /*minDate: moment(),*/
            format : 'MM/DD/YYYY',
            showClear : true,
            useCurrent: true //Important! See issue #1075
            });
            
            var start_time = $('.wdm_simple_schedule').find('.wdm_start_time');
            var end_time = $('.wdm_simple_schedule').find('.wdm_end_time');

            start_time.datetimepicker({
           /* minDate: moment(),*/
            format: 'HH:mm',
            showClear : true,
            useCurrent: true //Important! See issue #1075
            });
            end_time.datetimepicker({
           /* minDate: moment(),*/
            format: 'HH:mm',
            showClear : true,
            useCurrent: true //Important! See issue #1075
            });       
        }
       
       function scheduler_assign_date_time_picker(){
        jQuery('.wdm_start_date').datetimepicker({
            /*minDate: moment(),*/
            format : 'MM/DD/YYYY',
            showClear : true,
            useCurrent: true //Important! See issue #1075
            });
            jQuery('.wdm_end_date').datetimepicker({
            /*minDate: moment(),*/
            format : 'MM/DD/YYYY',
            showClear : true,
            useCurrent: true //Important! See issue #1075
            });


            jQuery('.wdm_start_time').datetimepicker({
           /* minDate: moment(),*/
            format: 'HH:mm',
            showClear : true,
            useCurrent: true //Important! See issue #1075
            });
            jQuery('.wdm_end_time').datetimepicker({
           /* minDate: moment(),*/
            format: 'HH:mm',
            showClear : true,
            useCurrent: true //Important! See issue #1075
            });
       }

       jQuery('#publish , .save-variation-changes').click(function (event){
       	var current_date=new Date();
            if (jQuery(".wdm_simple_schedule")[0]){
                var start_date = jQuery('.wdm_simple_schedule').find('.wdm_start_date').val();
                var end_date = jQuery('.wdm_simple_schedule').find('.wdm_end_date').val();
                var start_time = jQuery('.wdm_simple_schedule').find('.wdm_start_time').val();
                var end_time = jQuery('.wdm_simple_schedule').find('.wdm_end_time').val();
                start_val = new Date(start_date).getTime();
                end_val = new Date(end_date).getTime();

                if(end_val < start_val){
                    alert(scheduler_option.err_start_date_limit);
                        return false;
                }
                else if(start_val == end_val ){
                	if(end_time < start_time){
                        alert(scheduler_option.err_start_time_limit);
                        return false;
                    }
                }
                if(scheduler_option.option == 'per_day'){
                    if(end_time < start_time){
                        alert(scheduler_option.err_start_time_limit);
                        return false;
                    }
       			}
            } else {
                flag=0;
                jQuery('.wdm_start_date').each(function(){
                    var start_date =jQuery(this).val();
                    var end_date =jQuery(this).parent().siblings().find('.wdm_end_date').val();
                    var start_time =jQuery(this).parent().parent().siblings().find('.wdm_start_time').val();
                    var end_time =jQuery(this).parent().parent().siblings().find('.wdm_end_time').val();
                    start_val = new Date(start_date).getTime();
                    end_val = new Date(end_date).getTime();
                    if(end_val < start_val){
                        flag=1;
                    }
                    else if(start_val == end_val ){
                	if(end_time < start_time){
                        flag = 2;
                        return false;
                    }
                }
                    if(scheduler_option.option == 'per_day'){
                        if(end_time < start_time){
                            flag=2;
                        }
                    }
                    else{

                    }
                });
                if(flag == 1){
                    alert(scheduler_option.err_start_date_limit);
                    return false;
                }
                else if(flag == 2){
                    alert(scheduler_option.err_start_time_limit);
                    return false;
                }
            }
        });

});
