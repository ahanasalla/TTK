jQuery('document').ready( function($) {
    $('body').on('click', '#place_order', function(){
        var inputs              = $('.clicktime-pick-class');
        var clickAndPickElement = $('#click-and-pick');

    	// assign the valueList first to empty array
    	var valueList = [];
        inputs.each(function(index, value) {
			valueList.push($(value).val());
        });

        // compact here remove the falsy array values from the array
        // so if we have "" value in the array it will be removed
        // reference: https://lodash.com/docs/4.17.1#compact
        var notFalseyArrayList =  _.compact(valueList);

        // After than we check if we have empty array
        // then the array values empty value ( it has items but the items is empty )
        // Also we check if click and pick dom is already there is the page
        // then we show the alert error
        if (clickAndPickElement.length && _.isEmpty(notFalseyArrayList)) {
			alert(click_n_pick.error);
			return false;
        }
    });
});