jQuery(document).ready(function($) {
    // Condition 1: In case Olark for WP is used
    // we will move the bottom right arrow up to avoid overlapping
    var isOlarkEnabled = (parseInt(ttk_custom.olark_for_wp) > 0), isScrollBarBottom = false;

    if (isOlarkEnabled) {
        $('#go-top').addClass('upper-for-olark');
    } else {
        // Only do further checks if Olark for WP is not enabled
        $(window).on('resize load scroll', function (e) {
            if (! isOlarkEnabled) {
                // Condition 2: If the scroll bar is at the bottom
                // Move the bottom right arrow up
                isScrollBarBottom = ($(window).scrollTop() === ($(document).height() - $(window).height()));
            }

            // Either of the conditions above
            if (isScrollBarBottom) {
                $('#go-top').addClass('upper-btm-page');
            } else {
                $('#go-top').removeClass('upper-btm-page');
            }
        });
    }
});