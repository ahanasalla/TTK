// jQuery(document).ready(function () {
        
//        //console.log(wdm_expiration_data); 
//       // console.log('hello'); 
        
//        jQuery('#wdm_start_date').datetimepicker({
//                 // minDate: moment(), removed as previous scheduled dates not getting displayed
//                 format : 'MM/DD/YYYY, HH:mm',
//                 defaultDate : moment(),
//                 showClear : true
//         });
//        jQuery('#wdm_end_date').datetimepicker({
//             minDate: moment(),
//             format : 'MM/DD/YYYY, HH:mm',
//             showClear : true,
//             useCurrent: true //Important! See issue #1075
//         });
       
//        //revise 'End date' --- minimum date after change in Start date
//         jQuery("#wdm_start_date").on("dp.change", function (e) {
//            jQuery('#wdm_end_date').data("DateTimePicker").minDate(e.date);
//         });
       
//        if (wdm_expiration_data.start_date.length > 2) {
        
//             jQuery('#wdm_start_date').data("DateTimePicker").date(wdm_expiration_data.start_date);
//        }
//        else
//        {
//             jQuery('#wdm_start_date').data("DateTimePicker").date(null);
//        }
       
//        if (wdm_expiration_data.end_date.length > 2) {
                
//            jQuery('#wdm_end_date').data("DateTimePicker").date(wdm_expiration_data.end_date);
//        }
//        else
//        {
//             jQuery('#wdm_end_date').data("DateTimePicker").date(null);
//        }
       
// jQuery('body').delegate('.woocommerce_variation',"click", function(){
//          // console.log('Hello');
//   jQuery('#wdm_start_date').datetimepicker({
//                 // minDate: moment(), removed as previous scheduled dates not getting displayed
//                 format : 'MM/DD/YYYY, HH:mm',
//                 defaultDate : moment(),
//                 showClear : true
//         });
//        // jQuery('#wdm_start_date').datetimepicker({
//        //          // minDate: moment(), removed as previous scheduled dates not getting displayed
//        //          format : 'MM/DD/YYYY, HH:mm',
//        //          defaultDate : moment(),
//        //          showClear : true
//        //  });
//        jQuery('#wdm_end_date').datetimepicker({
//            /* minDate: moment(),*/
//             format : 'MM/DD/YYYY, HH:mm',
//             showClear : true,
//             useCurrent: true //Important! See issue #1075
//         });
       
//        //revise 'End date' --- minimum date after change in Start date
//         // jQuery(".wdm_start_date").on("dp.change", function (e) {
//         //    jQuery(this).parent().siblings('p').children('.wdm_end_date').data("DateTimePicker").minDate(e.date);
//         // });


//       });


//         jQuery('#publish').click(function (){
        
//                 return validate();
//         });
// });




