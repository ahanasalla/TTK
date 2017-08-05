<?php
	function byconsolewooodt_admin_language_translator_settings_form()
	{
?>
	<div class="wrap">



			<h1>ByConsole Woocommerce Language Traslator Settings</h1>



            



            <form method="post" class="form_byconsolewooodt_wooodt_features_settings" action="options.php">



				<?php



					settings_fields("languagetraslatorsetting");



					do_settings_sections("byconsolewooodt_admin_language_translator_settings_options");      



					submit_button(); 



				?>          



			</form>



	</div>
		
<?php 	}

function byconsolewooodt_orders_delivered()
{
?>
<input type="text" name="byconsolewooodt_orders_delivered" id="byconsolewooodt_orders_delivered" style="width:50%; padding:7px;" value="<?php printf( __('%s','ByConsoleWooODTExtended'),get_option('byconsolewooodt_orders_delivered')); ?>" />

<label> <?php echo __('This is the text showed in Order Delivered page.','ByConsoleWooODTExtended');?></label><br />
<span style="color:#a0a5aa">(<?php echo __('Eg: The order will be delivered on','ByConsoleWooODTExtended');?>  [deliver_date] <?php echo __('at','ByConsoleWooODTExtended');?>   [deliver_time])<br>
Delivery date will work as short code on [deliver_date] <br>
Delivery time will work as short code on [deliver_time]</span>
<?php
}


function byconsolewooodt_orders_pick_up()
{
?>
<input type="text" name="byconsolewooodt_orders_pick_up" id="byconsolewooodt_orders_pick_up" style="width:50%; padding:7px;" value="<?php printf( __('%s','ByConsoleWooODTExtended'),get_option('byconsolewooodt_orders_pick_up')); ?>" />
<label> <?php echo __('This is the text showed in Order Picked Up page.','ByConsoleWooODTExtended');?></label><br />
<span style="color:#a0a5aa">(<?php echo __('Eg: The order can be Picked Up on','ByConsoleWooODTExtended');?>  [pickup_date] <?php echo __('at','ByConsoleWooODTExtended');?>  [pickup_time])<br>
Pickup date will work as short code on [pickup_date] <br>
Pickup time will work as short code on [pickup_time]</span>
<?php
}

function byconsolewooodt_chekout_page_section()
{
?>
<input type="text" name="byconsolewooodt_chekout_page_section_heading" id="byconsolewooodt_chekout_page_section_heading" style="width:30%; padding:7px;" value="<?php printf( __('%s','ByConsoleWooODTExtended'),get_option('byconsolewooodt_chekout_page_section_heading')); ?>"/>
<label><?php echo __('Texts to display on checkout page as section heading.','ByConsoleWooODTExtended');?></label><br />
<span style="color:#a0a5aa">(Eg: Desired delivery date and time)</span>
<?php
}

function byconsolewooodt_chekout_page_order_type_lebel()
{
?>
<input type="text" name="byconsolewooodt_chekout_page_order_type_lebel" id="byconsolewooodt_chekout_page_order_type_lebel" style="width:30%; padding:7px;" value="<?php printf( __('%s','ByConsoleWooODTExtended'),get_option('byconsolewooodt_chekout_page_order_type_lebel')); ?>"/>
<label><?php echo __('Displayed as time drop-down lebel on checkout page.','ByConsoleWooODTExtended');?></label><br />
<span style="color:#a0a5aa">(Eg: Select order type)</span>
<?php
}

function byconsolewooodt_chekout_page_date_lebel()
{
?>
<input type="text" name="byconsolewooodt_chekout_page_date_lebel" id="byconsolewooodt_chekout_page_date_lebel" style="width:30%; padding:7px;" value="<?php printf( __('%s','ByConsoleWooODTExtended'),get_option('byconsolewooodt_chekout_page_date_lebel')); ?>"/>
<label><?php echo __('Displayed as calendar lebel on checkout page.','ByConsoleWooODTExtended');?></label><br />
<span style="color:#a0a5aa">(Eg: Select date)</span>
<?php
}


function byconsolewooodt_chekout_page_time_lebel()
{
?>
<input type="text" name="byconsolewooodt_chekout_page_time_lebel" id="byconsolewooodt_chekout_page_time_lebel" style="width:30%; padding:7px;" value="<?php printf( __('%s','ByConsoleWooODTExtended'),get_option('byconsolewooodt_chekout_page_time_lebel')); ?>"/>
<label><?php echo __('Displayed as time drop-down lebel on checkout page.','ByConsoleWooODTExtended');?></label><br />
<span style="color:#a0a5aa">(Eg: Select time)</span>
<?php
}

function byconsolewooodt_pickup_location_lebel()
{
?>
<input type="text" name="byconsolewooodt_pickup_location_lebel" id="byconsolewooodt_pickup_location_lebel" style="width:30%; padding:7px;" value="<?php printf( __('%s','ByConsoleWooODTExtended'),get_option('byconsolewooodt_pickup_location_lebel')); ?>" />
<label> <?php echo __('Displayed as pickup location drop-down lebel on checkout page.','ByConsoleWooODTExtended');?></label><br />
<span style="color:#a0a5aa">(Eg: select pickup location lebel)</span>
<?php
}

function byconsolewooodt_delivery_location_lebel()
{
?>
<input type="text" name="byconsolewooodt_delivery_location_lebel" id="byconsolewooodt_delivery_location_lebel" style="width:30%; padding:7px;" value="<?php printf( __('%s','ByConsoleWooODTExtended'),get_option('byconsolewooodt_delivery_location_lebel')); ?>" />
<label> <?php echo __('Displayed as delivery location drop-down lebel on checkout page.','ByConsoleWooODTExtended');?></label><br />
<span style="color:#a0a5aa">(Eg: select delivery location lebel)</span>
<?php
}


function byconsolewooodt_pickup_location_date_textbox_placeholder()
{
?>
<input type="text" name="byconsolewooodt_chekout_page_date_placeholder" id="byconsolewooodt_chekout_page_date_placeholder" style="width:30%; padding:7px;" value="<?php printf( __('%s','ByConsoleWooODTExtended'),get_option('byconsolewooodt_chekout_page_date_placeholder')); ?>" /><br />
<span style="color:#a0a5aa">(Eg: select your pickup date)</span>	
<?php
}

function byconsolewooodt_pickup_location_time_textbox_placeholder()
{
?>
<input type="text" name="byconsolewooodt_chekout_page_time_placeholder" id="byconsolewooodt_chekout_page_time_placeholder" style="width:30%; padding:7px;" value="<?php printf( __('%s','ByConsoleWooODTExtended'),get_option('byconsolewooodt_chekout_page_time_placeholder')); ?>" /><br />
<span style="color:#a0a5aa">(Eg: select your pickup time)</span>
<?php	
}

function byconsolewooodt_delivery_location_date_textbox_placeholder()
{
?>
<input type="text" name="byconsolewooodt_chekout_page_delivery_date_placeholder" id="byconsolewooodt_chekout_page_delivery_date_placeholder" style="width:30%; padding:7px;" value="<?php printf( __('%s','ByConsoleWooODTExtended'),get_option('byconsolewooodt_chekout_page_delivery_date_placeholder')); ?>" /><br />
<span style="color:#a0a5aa">(Eg: select your delivery date)</span>	
<?php
}

function byconsolewooodt_delivery_location_time_textbox_placeholder()
{
?>
<input type="text" name="byconsolewooodt_chekout_page_delivery_time_placeholder" id="byconsolewooodt_chekout_page_delivery_time_placeholder" style="width:30%; padding:7px;" value="<?php printf( __('%s','ByConsoleWooODTExtended'),get_option('byconsolewooodt_chekout_page_delivery_time_placeholder')); ?>" /><br />
<span style="color:#a0a5aa">(Eg: select your delivery time)</span>
<?php	
}

function byconsolewooodt_store_close_lebel()
{
?>
<input type="text" name="byconsolewooodt_store_close_notice" id="byconsolewooodt_store_close_notice" style="width:30%; padding:7px;" value="<?php printf( __('%s','ByConsoleWooODTExtended'),get_option('byconsolewooodt_store_close_notice')); ?>" />
<label> <?php echo __('Displayed as store close notice drop-down lebel on checkout page.','ByConsoleWooODTExtended');?></label><br />
<span style="color:#a0a5aa">(Eg: select store close notice)</span>
<?php
}




function byconsolewooodt_pickup_lable()
{
?>
<input type="text" name="byconsolewooodt_pickup_lable" id="byconsolewooodt_pickup_lable" style="width:30%; padding:7px;" value="<?php printf( __('%s','ByConsoleWooODTExtended'),get_option('byconsolewooodt_pickup_lable')); ?>" />
<label> <?php echo __('Displayed as pickup lebel on checkout page.','ByConsoleWooODTExtended');?></label><br />
<span style="color:#a0a5aa">(Eg: pickup lebel)</span>
<?php	
}
function byconsolewooodt_delivery_lable()
{
?>
<input type="text" name="byconsolewooodt_delivery_lable" id="byconsolewooodt_delivery_lable" style="width:30%; padding:7px;" value="<?php printf( __('%s','ByConsoleWooODTExtended'),get_option('byconsolewooodt_delivery_lable')); ?>" />
<label> <?php echo __('Displayed as delivery lebel on checkout page.','ByConsoleWooODTExtended');?></label><br />
<span style="color:#a0a5aa">(Eg: delivery lebel)</span>
<?php	
}
function byconsolewooodt_order_page_order_type_lable()
{
?>
<input type="text" name="byconsolewooodt_order_page_order_type_lable" id="byconsolewooodt_order_page_order_type_lable" style="width:30%; padding:7px;" value="<?php printf( __('%s','ByConsoleWooODTExtended'),get_option('byconsolewooodt_order_page_order_type_lable')); ?>" />
<label> <?php echo __('Displayed order type lebel on order page.','ByConsoleWooODTExtended');?></label><br />
<span style="color:#a0a5aa">(Eg: order type lebel on order page)</span>
<?php	
}
function byconsolewooodt_order_page_pickup_location_lable()
{
?>
<input type="text" name="byconsolewooodt_order_page_pickup_location_lable" id="byconsolewooodt_order_page_pickup_location_lable" style="width:30%; padding:7px;" value="<?php printf( __('%s','ByConsoleWooODTExtended'),get_option('byconsolewooodt_order_page_pickup_location_lable')); ?>" />
<label> <?php echo __('Displayed pickup location lebel on order page.','ByConsoleWooODTExtended');?></label><br />
<span style="color:#a0a5aa">(Eg: pickup location lebel on order page)</span>
<?php	
}
function byconsolewooodt_order_page_pickup_date_lable()
{
?>
<input type="text" name="byconsolewooodt_order_page_pickup_date_lable" id="byconsolewooodt_order_page_pickup_date_lable" style="width:30%; padding:7px;" value="<?php printf( __('%s','ByConsoleWooODTExtended'),get_option('byconsolewooodt_order_page_pickup_date_lable')); ?>" />
<label> <?php echo __('Displayed pickup date lebel on order page.','ByConsoleWooODTExtended');?></label><br />
<span style="color:#a0a5aa">(Eg: pickup date lebel on order page)</span>
<?php	
}
function byconsolewooodt_order_page_pickup_time_lable()
{
?>
<input type="text" name="byconsolewooodt_order_page_pickup_time_lable" id="byconsolewooodt_order_page_pickup_time_lable" style="width:30%; padding:7px;" value="<?php printf( __('%s','ByConsoleWooODTExtended'),get_option('byconsolewooodt_order_page_pickup_time_lable')); ?>" />
<label> <?php echo __('Displayed pickup time lebel on order page.','ByConsoleWooODTExtended');?></label><br />
<span style="color:#a0a5aa">(Eg: pickup time lebel on order page)</span>
<?php	
}
function byconsolewooodt_order_page_delivery_location_lable()
{
?>
<input type="text" name="byconsolewooodt_order_page_delivery_location_lable" id="byconsolewooodt_order_page_delivery_location_lable" style="width:30%; padding:7px;" value="<?php printf( __('%s','ByConsoleWooODTExtended'),get_option('byconsolewooodt_order_page_delivery_location_lable')); ?>" />
<label> <?php echo __('Displayed delivery location lebel on order page.','ByConsoleWooODTExtended');?></label><br />
<span style="color:#a0a5aa">(Eg: delivery location lebel on order page)</span>
<?php	
}
function byconsolewooodt_order_page_delivery_date_lable()
{
?>
<input type="text" name="byconsolewooodt_order_page_delivery_date_lable" id="byconsolewooodt_order_page_delivery_date_lable" style="width:30%; padding:7px;" value="<?php printf( __('%s','ByConsoleWooODTExtended'),get_option('byconsolewooodt_order_page_delivery_date_lable')); ?>" />
<label> <?php echo __('Displayed delivery date lebel on order page.','ByConsoleWooODTExtended');?></label><br />
<span style="color:#a0a5aa">(Eg: delivery date lebel on order page)</span>
<?php	
}
function byconsolewooodt_order_page_delivery_time_lable()
{
?>
<input type="text" name="byconsolewooodt_order_page_delivery_time_lable" id="byconsolewooodt_order_page_delivery_time_lable" style="width:30%; padding:7px;" value="<?php printf( __('%s','ByConsoleWooODTExtended'),get_option('byconsolewooodt_order_page_delivery_time_lable')); ?>" />
<label> <?php echo __('Displayed delivery time lebel on order page.','ByConsoleWooODTExtended');?></label><br />
<span style="color:#a0a5aa">(Eg: delivery time lebel on order page)</span>
<?php	
}
function byconsolewooodt_calender_holiday_lable()
{
?>
<input type="text" name="byconsolewooodt_calender_holiday_lable" id="byconsolewooodt_calender_holiday_lable" style="width:30%; padding:7px;" value="<?php printf( __('%s','ByConsoleWooODTExtended'),get_option('byconsolewooodt_calender_holiday_lable')); ?>" />
<label> <?php echo __('Calender holiday lable.','ByConsoleWooODTExtended');?></label><br />
<span style="color:#a0a5aa">(Eg: calender holiday lable)</span>
<?php	
}



function byconsolewooodt_calender_closing_lable()
{
?>
<input type="text" name="byconsolewooodt_calender_closing_lable" id="byconsolewooodt_calender_closing_lable" style="width:30%; padding:7px;" value="<?php printf( __('%s','ByConsoleWooODTExtended'),get_option('byconsolewooodt_calender_closing_lable')); ?>" />
<label> <?php echo __('Calender closing lable.','ByConsoleWooODTExtended');?></label><br />
<span style="color:#a0a5aa">(Eg: calender closeing lable)</span>
<?php	
}



function byconsolewooodt_calender_pick_notallowed_lable()
{
?>
<input type="text" name="byconsolewooodt_calender_pick_notallowed_lable" id="byconsolewooodt_calender_pick_notallowed_lable" style="width:30%; padding:7px;" value="<?php printf( __('%s','ByConsoleWooODTExtended'),get_option('byconsolewooodt_calender_pick_notallowed_lable')); ?>" />
<label> <?php echo __('Calender date pick not allowed lable.','ByConsoleWooODTExtended');?></label><br />
<span style="color:#a0a5aa">(Eg: calender date pick not allowed lable)</span>
<?php	
}




add_action('admin_init', 'byconsolewooodt_wooodt_language_traslator_settings_fields');

function byconsolewooodt_wooodt_language_traslator_settings_fields()
{

add_settings_section("languagetraslatorsetting", "Language Translator Settings", null, "byconsolewooodt_admin_language_translator_settings_options");

add_settings_field("byconsolewooodt_orders_delivered", "<p>Exact time text:</p>", "byconsolewooodt_orders_delivered", "byconsolewooodt_admin_language_translator_settings_options", "languagetraslatorsetting");

add_settings_field("byconsolewooodt_orders_pick_up", "The order can be Pickup:", "byconsolewooodt_orders_pick_up", "byconsolewooodt_admin_language_translator_settings_options", "languagetraslatorsetting");

add_settings_field("byconsolewooodt_chekout_page_section_heading", "Checkout page section heading", "byconsolewooodt_chekout_page_section", "byconsolewooodt_admin_language_translator_settings_options", "languagetraslatorsetting");


add_settings_field("byconsolewooodt_chekout_page_order_type_lebel", "Order type lebel on checkout page:", "byconsolewooodt_chekout_page_order_type_lebel", "byconsolewooodt_admin_language_translator_settings_options", "languagetraslatorsetting");


add_settings_field("byconsolewooodt_chekout_page_date_lebel", "Calendar lebel on checkout page:", "byconsolewooodt_chekout_page_date_lebel", "byconsolewooodt_admin_language_translator_settings_options", "languagetraslatorsetting");

add_settings_field("byconsolewooodt_chekout_page_time_lebel", "Time select lebel on checkout page:", "byconsolewooodt_chekout_page_time_lebel", "byconsolewooodt_admin_language_translator_settings_options", "languagetraslatorsetting");

add_settings_field("byconsolewooodt_pickup_location_lebel", "Pickup location lebel:", "byconsolewooodt_pickup_location_lebel", "byconsolewooodt_admin_language_translator_settings_options", "languagetraslatorsetting");

add_settings_field("byconsolewooodt_delivery_location_lebel", "Delivery location lebel:", "byconsolewooodt_delivery_location_lebel", "byconsolewooodt_admin_language_translator_settings_options", "languagetraslatorsetting");

add_settings_field("byconsolewooodt_chekout_page_date_placeholder", "Pickup Date Placeholder:", "byconsolewooodt_pickup_location_date_textbox_placeholder", "byconsolewooodt_admin_language_translator_settings_options", "languagetraslatorsetting");

add_settings_field("byconsolewooodt_chekout_page_time_placeholder", "Pickup Time Placeholder:", "byconsolewooodt_pickup_location_time_textbox_placeholder", "byconsolewooodt_admin_language_translator_settings_options", "languagetraslatorsetting");

add_settings_field("byconsolewooodt_chekout_page_delivery_date_placeholder", "Delivery Date Placeholder:", "byconsolewooodt_delivery_location_date_textbox_placeholder", "byconsolewooodt_admin_language_translator_settings_options", "languagetraslatorsetting");

add_settings_field("byconsolewooodt_chekout_page_delivery_time_placeholder", "Delivery Time Placeholder:", "byconsolewooodt_delivery_location_time_textbox_placeholder", "byconsolewooodt_admin_language_translator_settings_options", "languagetraslatorsetting");

add_settings_field("byconsolewooodt_store_close_lebel", "Store close notice:", "byconsolewooodt_store_close_lebel", "byconsolewooodt_admin_language_translator_settings_options", "languagetraslatorsetting");

add_settings_field("byconsolewooodt_pickup_lable", "Pickup Lable:", "byconsolewooodt_pickup_lable", "byconsolewooodt_admin_language_translator_settings_options", "languagetraslatorsetting");	
add_settings_field("byconsolewooodt_delivery_lable", "Delivery Lable:", "byconsolewooodt_delivery_lable", "byconsolewooodt_admin_language_translator_settings_options", "languagetraslatorsetting");	
add_settings_field("byconsolewooodt_order_page_order_type_lable", "Order Type Lable:", "byconsolewooodt_order_page_order_type_lable", "byconsolewooodt_admin_language_translator_settings_options", "languagetraslatorsetting");	
add_settings_field("byconsolewooodt_order_page_pickup_location_lable", "Pickup Location Lable:", "byconsolewooodt_order_page_pickup_location_lable", "byconsolewooodt_admin_language_translator_settings_options", "languagetraslatorsetting");	
add_settings_field("byconsolewooodt_order_page_pickup_date_lable", "Pickup Date Lable:", "byconsolewooodt_order_page_pickup_date_lable", "byconsolewooodt_admin_language_translator_settings_options", "languagetraslatorsetting");	
add_settings_field("byconsolewooodt_order_page_pickup_time_lable", "Pickup Time Lable:", "byconsolewooodt_order_page_pickup_time_lable", "byconsolewooodt_admin_language_translator_settings_options", "languagetraslatorsetting");	
add_settings_field("byconsolewooodt_order_page_delivery_location_lable", "Delivery Location Lable:", "byconsolewooodt_order_page_delivery_location_lable", "byconsolewooodt_admin_language_translator_settings_options", "languagetraslatorsetting");	
add_settings_field("byconsolewooodt_order_page_delivery_date_lable", "Delivery Date Lable:", "byconsolewooodt_order_page_delivery_date_lable", "byconsolewooodt_admin_language_translator_settings_options", "languagetraslatorsetting");	
add_settings_field("byconsolewooodt_order_page_delivery_time_lable", "Delivery Time Lable:", "byconsolewooodt_order_page_delivery_time_lable", "byconsolewooodt_admin_language_translator_settings_options", "languagetraslatorsetting");
add_settings_field("byconsolewooodt_calender_holiday_lable", "Calender Holiday Tooltip Lable:", "byconsolewooodt_calender_holiday_lable", "byconsolewooodt_admin_language_translator_settings_options", "languagetraslatorsetting");	




add_settings_field("byconsolewooodt_calender_closing_lable", "Calender Closing Tooltip Lable:", "byconsolewooodt_calender_closing_lable", "byconsolewooodt_admin_language_translator_settings_options", "languagetraslatorsetting");




add_settings_field("byconsolewooodt_calender_pick_notallowed_lable", "Calender Not Allowed Tooltip Lable:", "byconsolewooodt_calender_pick_notallowed_lable", "byconsolewooodt_admin_language_translator_settings_options", "languagetraslatorsetting");







register_setting("languagetraslatorsetting", "byconsolewooodt_orders_delivered");
register_setting("languagetraslatorsetting", "byconsolewooodt_orders_pick_up");
register_setting("languagetraslatorsetting", "byconsolewooodt_chekout_page_section_heading");
register_setting("languagetraslatorsetting", "byconsolewooodt_chekout_page_order_type_lebel");
register_setting("languagetraslatorsetting", "byconsolewooodt_chekout_page_date_lebel");
register_setting("languagetraslatorsetting", "byconsolewooodt_chekout_page_time_lebel");
register_setting("languagetraslatorsetting", "byconsolewooodt_pickup_location_lebel");
register_setting("languagetraslatorsetting", "byconsolewooodt_delivery_location_lebel");
register_setting("languagetraslatorsetting", "byconsolewooodt_chekout_page_date_placeholder");
register_setting("languagetraslatorsetting", "byconsolewooodt_chekout_page_time_placeholder");
register_setting("languagetraslatorsetting", "byconsolewooodt_chekout_page_delivery_date_placeholder");
register_setting("languagetraslatorsetting", "byconsolewooodt_chekout_page_delivery_time_placeholder");
register_setting("languagetraslatorsetting", "byconsolewooodt_store_close_notice");
register_setting("languagetraslatorsetting", "byconsolewooodt_pickup_lable");
register_setting("languagetraslatorsetting", "byconsolewooodt_delivery_lable");
register_setting("languagetraslatorsetting", "byconsolewooodt_order_page_order_type_lable");
register_setting("languagetraslatorsetting", "byconsolewooodt_order_page_pickup_location_lable");
register_setting("languagetraslatorsetting", "byconsolewooodt_order_page_pickup_date_lable");
register_setting("languagetraslatorsetting", "byconsolewooodt_order_page_pickup_time_lable");
register_setting("languagetraslatorsetting", "byconsolewooodt_order_page_delivery_location_lable");
register_setting("languagetraslatorsetting", "byconsolewooodt_order_page_delivery_date_lable");
register_setting("languagetraslatorsetting", "byconsolewooodt_order_page_delivery_time_lable");

register_setting("languagetraslatorsetting", "byconsolewooodt_calender_holiday_lable");


register_setting("languagetraslatorsetting", "byconsolewooodt_calender_closing_lable");


register_setting("languagetraslatorsetting", "byconsolewooodt_calender_pick_notallowed_lable");

}

?>