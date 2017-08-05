<?php
function byconsolewooodt_admin_color_picker_settings_form()
	{
?>
	<div class="wrap">



			<h1>ByConsole Woocommerce Color Picker Settings</h1>



            



            <form method="post" class="form_byconsolewooodt_wooodt_features_settings" action="options.php">



				<?php



					settings_fields("colorpickersetting");



					do_settings_sections("byconsolewooodt_admin_color_picker_settings_options");      



					submit_button(); 



				?>          



			</form>



	</div>
		
<?php 	}


function byconsolewooodt_calender_holiday_tooltip_background_color()
{
?>
<input class="jscolor" name="byconsolewooodt_calender_holiday_tooltip_background_color" id="byconsolewooodt_calender_holiday_tooltip_background_color" value="<?php printf( __('%s','ByConsoleWooODTExtended'),get_option('byconsolewooodt_calender_holiday_tooltip_background_color')); ?>">
<br />
<span style="color:#a0a5aa">(Eg: calender holiday tooltip background color)</span>

<?php 
}

function byconsolewooodt_calender_holiday_tooltip_text_color()
{
?>
<input class="jscolor" name="byconsolewooodt_calender_holiday_tooltip_text_color" id="byconsolewooodt_calender_holiday_tooltip_text_color" value="<?php printf( __('%s','ByConsoleWooODTExtended'),get_option('byconsolewooodt_calender_holiday_tooltip_text_color')); ?>">
<br />
<span style="color:#a0a5aa">(Eg: calender holiday tooltip text color)</span>

<?php 
}

function byconsolewooodt_calender_closing_tooltip_background_color()
{
?>
<input class="jscolor" name="byconsolewooodt_calender_closing_tooltip_background_color" id="byconsolewooodt_calender_closing_tooltip_background_color" value="<?php printf( __('%s','ByConsoleWooODTExtended'),get_option('byconsolewooodt_calender_closing_tooltip_background_color')); ?>">
<br /><span style="color:#a0a5aa">(Eg: calender closing day tooltip background color)</span>

<?php 
}

function byconsolewooodt_calender_closing_tooltip_text_color()
{
?>
<input class="jscolor" name="byconsolewooodt_calender_closing_tooltip_text_color" id="byconsolewooodt_calender_closing_tooltip_text_color" value="<?php printf( __('%s','ByConsoleWooODTExtended'),get_option('byconsolewooodt_calender_closing_tooltip_text_color')); ?>">
<br /><span style="color:#a0a5aa">(Eg: calender closing day tooltip text color)</span>

<?php 
}
function byconsolewooodt_calender_pick_notallowed_tooltip_background_color()
{
?>
<input class="jscolor" name="byconsolewooodt_calender_pick_notallowed_tooltip_background_color" id="byconsolewooodt_calender_pick_notallowed_tooltip_background_color" value="<?php printf( __('%s','ByConsoleWooODTExtended'),get_option('byconsolewooodt_calender_pick_notallowed_tooltip_background_color')); ?>">
<br /><span style="color:#a0a5aa">(Eg: calender pick notallowed day tooltip background color)</span>

<?php 
}

function byconsolewooodt_calender_pick_notallowed_tooltip_text_color()
{
?>
<input class="jscolor" name="byconsolewooodt_calender_pick_notallowed_tooltip_text_color" id="byconsolewooodt_calender_pick_notallowed_tooltip_text_color" value="<?php printf( __('%s','ByConsoleWooODTExtended'),get_option('byconsolewooodt_calender_pick_notallowed_tooltip_text_color')); ?>">
<br /><span style="color:#a0a5aa">(Eg: calender pick notallowed day tooltip text color)</span>

<?php 
}

function byconsolewooodt_calender_header_color()
{
?>
<input class="jscolor" name="byconsolewooodt_calender_header_color" id="byconsolewooodt_calender_header_color" value="<?php printf( __('%s','ByConsoleWooODTExtended'),get_option('byconsolewooodt_calender_header_color')); ?>">
<br /><span style="color:#a0a5aa">(Eg: calender header color)</span>

<?php 
}


function byconsolewooodt_calender_header_text_color()
{
?>
<input class="jscolor" name="byconsolewooodt_calender_header_text_color" id="byconsolewooodt_calender_header_text_color" value="<?php printf( __('%s','ByConsoleWooODTExtended'),get_option('byconsolewooodt_calender_header_text_color')); ?>">
<br /><span style="color:#a0a5aa">(Eg: calender header text color)</span>

<?php 
}


add_action('admin_init', 'byconsolewooodt_wooodt_color_picker_settings_fields');

function byconsolewooodt_wooodt_color_picker_settings_fields()
{
add_settings_section("colorpickersetting", "Color Picker Settings", null, "byconsolewooodt_admin_color_picker_settings_options");

add_settings_field("byconsolewooodt_calender_holiday_tooltip_background_color", "Calender Holiday Tooltip Background Color:", "byconsolewooodt_calender_holiday_tooltip_background_color", "byconsolewooodt_admin_color_picker_settings_options", "colorpickersetting");

add_settings_field("byconsolewooodt_calender_holiday_tooltip_text_color", "Calender Holiday Tooltip Text Color:", "byconsolewooodt_calender_holiday_tooltip_text_color", "byconsolewooodt_admin_color_picker_settings_options", "colorpickersetting");


add_settings_field("byconsolewooodt_calender_closing_tooltip_background_color", "Calender Closing Tooltip Background Color:", "byconsolewooodt_calender_closing_tooltip_background_color", "byconsolewooodt_admin_color_picker_settings_options", "colorpickersetting");

add_settings_field("byconsolewooodt_calender_closing_tooltip_text_color", "Calender Closing Tooltip Text Color:", "byconsolewooodt_calender_closing_tooltip_text_color", "byconsolewooodt_admin_color_picker_settings_options", "colorpickersetting");	


add_settings_field("byconsolewooodt_calender_pick_notallowed_tooltip_background_color", "Calender Not Allowed Tooltip Background Color:", "byconsolewooodt_calender_pick_notallowed_tooltip_background_color", "byconsolewooodt_admin_color_picker_settings_options", "colorpickersetting");

add_settings_field("byconsolewooodt_calender_pick_notallowed_tooltip_text_color", "Calender Not Allowed Tooltip Text Color:", "byconsolewooodt_calender_pick_notallowed_tooltip_text_color", "byconsolewooodt_admin_color_picker_settings_options", "colorpickersetting");

add_settings_field("byconsolewooodt_calender_header_color", "Calender Header Color:", "byconsolewooodt_calender_header_color", "byconsolewooodt_admin_color_picker_settings_options", "colorpickersetting");

add_settings_field("byconsolewooodt_calender_header_text_color", "Calender Header Text Color:", "byconsolewooodt_calender_header_text_color", "byconsolewooodt_admin_color_picker_settings_options", "colorpickersetting");



register_setting("colorpickersetting", "byconsolewooodt_calender_holiday_tooltip_background_color");
register_setting("colorpickersetting", "byconsolewooodt_calender_holiday_tooltip_text_color");

register_setting("colorpickersetting", "byconsolewooodt_calender_closing_tooltip_background_color");
register_setting("colorpickersetting", "byconsolewooodt_calender_closing_tooltip_text_color");

register_setting("colorpickersetting", "byconsolewooodt_calender_pick_notallowed_tooltip_background_color");
register_setting("colorpickersetting", "byconsolewooodt_calender_pick_notallowed_tooltip_text_color");

register_setting("colorpickersetting", "byconsolewooodt_calender_header_color");
register_setting("colorpickersetting", "byconsolewooodt_calender_header_text_color");

}
?>