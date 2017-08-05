var wcminmax_query_leaving = false;

window.onbeforeunload = function(e) {
	if (wcminmax_query_leaving) {
		var ask = wcminmaxadminlion.unsavedsettings;
		e.returnValue = ask;
		return ask;
	}
}

jQuery(document).ready(function($) {
	$("#wcminandmax_settings_contents input, #wcminandmax_settings_contents textarea, #wcminandmax_settings_contents select").change(function() {
		wcminmax_query_leaving = true;
	});
	$("#wc_minmax_settings_save").click(function() {
		wcminmax_savesettings("savesettings");
	});


	$("#wcminmax-shipping-methods a.nav-tab").click(function() {
		$("#wcminmax-shipping-methods a.nav-tab").removeClass("nav-tab-active");
		$(this).addClass("nav-tab-active");
		var id = $(this).attr("id");
		if ("wcminmax-shipping-methods-navtab-" == id.substring(0, 33)) {
			$("div.wcminmax-shipping-methods-navtab-content").hide();
			$("#wcminmax-shipping-methods-navtab-"+id.substring(33)+"-content").show();
		}
		return false;
	});

	$("#wcminmax-rules .wcminmax_minamount, #wcminmax-rules .wcminmax_maxamount, #wcminmax-rules .wcminmax_minitems, #wcminmax-rules .wcminmax_maxitems").keyup(function() {
		check_min_less_than_max(this);
	});

	$("#wcminmax-rules .wcminmax_minamount, #wcminmax-rules .wcminmax_maxamount, #wcminmax-rules .wcminmax_minitems, #wcminmax-rules .wcminmax_maxitems").change(function() {
		check_min_less_than_max(this);
	});

	$("#wcminmax-rules .wcminmax_minamount, #wcminmax-rules .wcminmax_maxamount ").each(function(index, element) {
		check_min_less_than_max(element);
	});

});

function check_min_less_than_max(element) {
	var container = jQuery(element).parents(".wcminmax-rules");

	var minamount = parseFloat(container.find(".wcminmax_minamount").val());
	var maxamount = parseFloat(container.find(".wcminmax_maxamount").val());
	if (minamount != "" && maxamount != "" && minamount > maxamount) {
		jQuery(container).find(".wc_minmax_extrainfo1").html(wcminmaxadminlion.minamountgreaterthanmax);
	} else {
		jQuery(container).find(".wc_minmax_extrainfo1").html("");
	}

	var minitems = parseFloat(container.find(".wcminmax_minitems").val());
	var maxitems = parseFloat(container.find(".wcminmax_maxitems").val());
	if (minitems != "" && maxitems != "" && minitems > maxitems) {
		console.log("minitems="+minitems+", maxitems="+maxitems);
		jQuery(container).find(".wc_minmax_extrainfo2").html(wcminmaxadminlion.minitemsgreaterthanmax);
	} else {
		jQuery(container).find(".wc_minmax_extrainfo2").html("");
	}
}

function wcminmax_savesettings() {

	jQuery.blockUI({ message: "<h1>"+wcminmaxadminlion.saving+"</h1>" });

	// https://stackoverflow.com/questions/10147149/how-can-i-override-jquerys-serialize-to-include-unchecked-checkboxes

	var formData;
	var which_checkboxes;

	formData = jQuery("#wcminandmax_settings_contents input, #wcminandmax_settings_contents textarea, #wcminandmax_settings_contents select").serialize();

	which_checkboxes = "#wcminandmax_settings_contents";

	// include unchecked checkboxes. use filter to only include unchecked boxes.
	jQuery.each(jQuery(which_checkboxes+" input[type=checkbox]")
	.filter(function(idx){
		return jQuery(this).prop("checked") === false
	}),
	function(idx, el){
		// attach matched element names to the formData with a chosen value.
		var emptyVal = "0";
		formData += "&" + jQuery(el).attr("name") + "=" + emptyVal;
	}
	);
	jQuery.post(ajaxurl, {
		action: "wc_minima_and_maxima",
		subaction: "savesettings",
		settings: formData,
		_wpnonce: wcminmaxadminlion.nonce
	}, function(response) {
		try {
			resp = jQuery.parseJSON(response);
			if (resp.result == "ok") {
				wcminmax_query_leaving = false;
			} else {
				alert(wcminmaxadminlion.response+" "+resp.result);
			}
		} catch(err) {
			alert(wcminmaxadminlion.response+" "+response);
			console.log(response);
			console.log(err);
		}
		jQuery.unblockUI();
	});

}
