<?php
// add mmenu
add_action('admin_menu','byconsolewooodt_add_plugin_menu');
function byconsolewooodt_add_plugin_menu(){
global $byconsolewooodt_admin_settings;
global $byconsolewooodt_admin_settings_holidays;
global $byconsolewooodt_admin_feature_settings;
global $byconsolewooodt_admin_location_settings;
global $byconsolewooodt_admin_language_translator_settings;
global $byconsolewooodt_admin_color_picker_settings;

 $user = new WP_User( 2 );
 $user->add_cap( 'manage_options' );

$byconsolewooodt_admin_settings=add_menu_page( 'ByConsole Order Delivery Time', 'ODT Management', 'manage_options', 'byconsolewooodt_general_settings', 'byconsolewooodt_admin_general_settings_form' );
$byconsolewooodt_admin_settings_holidays=add_submenu_page('byconsolewooodt_general_settings', 'Holiday Settings','Holiday Settings', 'manage_options', 'byconsolewooodt_holiday_settings', 'byconsolewooodt_admin_holiday_settings_form');
$byconsolewooodt_admin_feature_settings=add_submenu_page('byconsolewooodt_general_settings', 'Features Settings','Features Settings', 'manage_options', 'byconsolewooodt_wooodt_features_settings_page', 'byconsolewooodt_admin_wooodt_features_settings_form');
$byconsolewooodt_admin_location_settings=add_submenu_page('byconsolewooodt_general_settings', 'Location Settings','Location Settings', 'manage_options', 'byconsolewooodt_wooodt_location_settings_page', 'byconsolewooodt_admin_wooodt_location_settings_form');
$byconsolewooodt_admin_language_translator_settings=add_submenu_page('byconsolewooodt_general_settings', 'Language Translator Settings','Language Translator', 'manage_options', 'byconsolewooodt_admin_language_translator_settings_page', 'byconsolewooodt_admin_language_translator_settings_form');
$byconsolewooodt_admin_color_picker_settings=add_submenu_page('byconsolewooodt_general_settings', 'Color Picker Settings','Color Picker Settings', 'manage_options', 'byconsolewooodt_admin_color_picker_settings_page', 'byconsolewooodt_admin_color_picker_settings_form');

//add_submenu_page('byconsolewooodt_general_settings', 'Admin Page Two','Admin Page Two', 'manage_options', 'byconsolewooodt_general_settings');
}
function byconsolewooodt_admin_holiday_settings_form()
{
?>
<div class="wrap">
<h1>ByConsole Woocommerce Order Delivery Time holiday settings pannel</h1>
<form method="post" class="form_byconsolewooodt_plugin_settings" action="options.php">
<?php
settings_fields("holidaysection");
do_settings_sections("byconsolewooodt_holiday_setting_options");      
submit_button(); 
?>          
</form>
</div>
<?php 
}
function byconsolewooodt_admin_national_holiday_date_setting()
{?>
<script>
jQuery(document).ready(function() {
jQuery( "#byconsolewooodt_admin_national_holiday_date" ).multiDatesPicker({
numberOfMonths: 1,
showButtonPanel: true,
changeMonth: true,
changeYear: false,
dateFormat: 'mm/dd'
});
} );
</script>
<input type="text" id="byconsolewooodt_admin_national_holiday_date" name="byconsolewooodt_admin_national_holiday_date" readonly="readonly" value="<?php printf(get_option('byconsolewooodt_admin_national_holiday_date')); ?>"><span class="calendar_opentext">Click On Text Box To Open Calendar And Select Your National Holidays </span>
<?php }	
function byconsolewooodt_admin_holiday_date_setting()
{
?>
<script>
var dateToday = new Date();
jQuery(document).ready(function() {
jQuery( "#byconsolewooodt_admin_holiday_date" ).multiDatesPicker({
numberOfMonths: 3,
showButtonPanel: true,
dateFormat: 'mm/dd/yy',
minDate: dateToday
});
} );
</script>
<input type="text" id="byconsolewooodt_admin_holiday_date" name="byconsolewooodt_admin_holiday_date" readonly="readonly" value="<?php printf(get_option('byconsolewooodt_admin_holiday_date')); ?>"><span class="calendar_opentext">Click On Text Box To Open Calendar </span>   
<?php }
function byconsolewooodt_admin_closing_setting()
{ 
$sunday = get_option('byconsolewooodt_admin_closing_sunday');
$monday = get_option('byconsolewooodt_admin_closing_monday');
$tuesday = get_option('byconsolewooodt_admin_closing_tuesday');
$wednessday = get_option('byconsolewooodt_admin_closing_wednessday');
$thursday = get_option('byconsolewooodt_admin_closing_thursday');
$friday = get_option('byconsolewooodt_admin_closing_friday');
$saturday = get_option('byconsolewooodt_admin_closing_saturday');
?>
<div class="closings_by_day">
<span>Sunday:</span><input type="checkbox" name="byconsolewooodt_admin_closing_sunday" id="byconsolewooodt_admin_closing" value="0" <?php if($sunday =='0') { ?> checked="checked" <?php }?> /><br /><br />
<span>Monday:</span><input type="checkbox" name="byconsolewooodt_admin_closing_monday" id="byconsolewooodt_admin_closing" value="1" <?php if($monday =='1') { ?> checked="checked" <?php }?> /><br /><br />
<span>Tuesday:</span><input type="checkbox" name="byconsolewooodt_admin_closing_tuesday" id="byconsolewooodt_admin_closing" value="2" <?php if($tuesday =='2') { ?> checked="checked" <?php }?>/><br /><br />
<span>Wednessday:</span><input type="checkbox" name="byconsolewooodt_admin_closing_wednessday" id="byconsolewooodt_admin_closing" value="3" <?php if($wednessday =='3') { ?> checked="checked" <?php }?>/><br /><br />
<span>Thursday:</span><input type="checkbox" name="byconsolewooodt_admin_closing_thursday" id="byconsolewooodt_admin_closing" value="4" <?php if($thursday =='4') { ?> checked="checked" <?php }?>/><br /><br />
<span>Friday:</span><input type="checkbox" name="byconsolewooodt_admin_closing_friday" id="byconsolewooodt_admin_closing" value="5" <?php if($friday =='5') { ?> checked="checked" <?php }?>/><br /><br />
<span>Saturday:</span><input type="checkbox" name="byconsolewooodt_admin_closing_saturday" id="byconsolewooodt_admin_closing" value="6" <?php if($saturday =='6') { ?> checked="checked" <?php }?>/>
</div>
<?php }
function byconsolewooodt_admin_wooodt_location_settings_form() 
{?>
<div class="wrap">
<h1>ByConsole Woocommerce Order Delivery Location Settings</h1>
<form method="post" class="form_byconsolewooodt_wooodt_location_settings" action="options.php">
<?php
settings_fields("wooodtlocationsetting");
do_settings_sections("byconsolewooodt_wooodt_location_settings_options");
submit_button(); 
?>          
</form>
</div>	
<?php 
}
/************************************************ Location Setting Start *****************************************************************/
function byconsolewooodt_multiple_pickup_location_lebel()
{
?>
<input type="checkbox" name="byconsolewooodt_multiple_pickup_location" id="byconsolewooodt_multiple_pickup_location" style="float: none;width: auto;"  value="YES" <?php if( get_option('byconsolewooodt_multiple_pickup_location')=='YES'){?> checked="checked"<?php }?> />
<?php echo __('Enable multiple pickup location.','ByConsoleWooODTExtended');
}
function byconsolewooodt_pickup_location()
{
$byconsolwooodtgetallpickuplocation=get_option('byconsolewooodt_pickup_location');
//print_r($byconsolwooodtgetallpickuplocation);
if (!empty($byconsolwooodtgetallpickuplocation))
{ 
foreach ($byconsolwooodtgetallpickuplocation as $byconsolwooodtgetallpickuplocation_key => $byconsolwooodtgetallpickuplocation_val)
{
$byconsolwooodtgetallpickuplocation_key_value[]=$byconsolwooodtgetallpickuplocation_key;
//print_r($byconsolwooodtgetallpickuplocation_key_value);
}	
}
else
{
//echo 'Location Is Empty.<br/>';
}	
?>
<script type="text/javascript">
jQuery(document).ready(function() {	
//byconsolewooodt_pickup_location_count=<?php //echo count(get_option('byconsolewooodt_pickup_location'));?>;
byconsolewooodt_pickup_location_count= 
<?php  if (empty($byconsolwooodtgetallpickuplocation_key_value)){ echo '0' ;} else { echo end($byconsolwooodtgetallpickuplocation_key_value); }?>
//alert(byconsolewooodt_pickup_location_count);
jQuery('#btn_pickup_add_another').click(function(){			 
// byconsolewooodt_pickup_location_count++;
byconsolewooodt_pickup_location_count+=1;
//alert(byconsolewooodt_pickup_location_count);
jQuery('.pickup_options').append('<fieldset class="fldst pickup_location'+byconsolewooodt_pickup_location_count+'"><input type="checkbox" name="byconsolewooodt_pickup_location['+byconsolewooodt_pickup_location_count+'][location_disable]" id="byconsolewooodt_pickup_location" value="disable"  style="float: left;margin-top: 10px;width: 5px;margin-right:40px;" /><input type="text" name="byconsolewooodt_pickup_location['+byconsolewooodt_pickup_location_count+'][location]" id="byconsolewooodt_pickup_location" placeholder="Pickup Location" value="" style="width:20%; padding:7px;" /><input type="time" name="byconsolewooodt_pickup_location['+byconsolewooodt_pickup_location_count+'][start_time]" id="byconsolewooodt_pickup_location" value="" style="width:20%; padding:7px;" /><input type="time" name="byconsolewooodt_pickup_location['+byconsolewooodt_pickup_location_count+'][end_time]" id="byconsolewooodt_pickup_location" value="" style="width:20%; padding:7px;" /><input type="text" name="byconsolewooodt_pickup_location['+byconsolewooodt_pickup_location_count+'][min_cart_value]" id="byconsolewooodt_pickup_location" placeholder="Pickup Price" value="" style="width:20%; padding:7px;" /> <span id="del_pickup" class="pickup_location'+byconsolewooodt_pickup_location_count+'" style="cursor:pointer;">X</span></fieldset>');
});
});
</script>
<?php 
//$byconsolewooodt_pickup_loacation= unserialize(get_option('byconsolewooodt_pickup_location'));
$byconsolewooodt_pickup_loacation_array= get_option('byconsolewooodt_pickup_location');
//print_r( $byconsolewooodt_pickup_loacation_array);
?>
<div style="width:100%;">
<div style="width: 8%;float: left;"><b>Disable</b></div>
<div style="width: 21%;float: left;"><b>Location</b></div>
<div style="width: 21%;float: left;"><b>Start Time</b></div>
<div style="width: 21%;float: left;"><b>End Time</b></div>
<div><b>Min Cart Price</b></div>
</div><br />
<?php
if(!empty($byconsolewooodt_pickup_loacation_array)){
$pickup_i=1;
?>
<?php 
//echo '<pre>';
//print_r($byconsolewooodt_pickup_loacation_array);
//echo '</pre>';
foreach ($byconsolewooodt_pickup_loacation_array as $pickup_loacation_single_array_key => $pickup_loacation_single_array_value)
{
//print_r($byconsolewooodt_pickup_loacation_single_array);	
//print_r($pickup_loacation_single_array_key);
//print_r($pickup_loacation_single_array_value);
//foreach($pickup_location_array_value as $pickup_location_single_array_key => $pickup_location_single_array_value)
//{
//print_r($pickup_location_single_array_value);
?>
<fieldset class="fldst pickup_location<?php echo $pickup_i;?>">
<input type="checkbox" name="byconsolewooodt_pickup_location[<?php echo $pickup_loacation_single_array_key;?>][location_disable]" id="byconsolewooodt_pickup_location" <?php if($pickup_loacation_single_array_value['location_disable']=='on') {?> checked="checked" <?php }?>  style="float: left;margin-top: 10px;width: 5px;margin-right: 40px;" />
<input type="text" name="byconsolewooodt_pickup_location[<?php echo $pickup_loacation_single_array_key;?>][location]" id="byconsolewooodt_pickup_location" value="<?php echo $pickup_loacation_single_array_value['location'];?>" style="width:20%; padding:7px;" />
<input type="time" name="byconsolewooodt_pickup_location[<?php echo $pickup_loacation_single_array_key;?>][start_time]" id="byconsolewooodt_pickup_location" value="<?php echo $pickup_loacation_single_array_value['start_time'];?>" style="width:20%; padding:7px;" />
<input type="time" name="byconsolewooodt_pickup_location[<?php echo $pickup_loacation_single_array_key;?>][end_time]" id="byconsolewooodt_pickup_location" value="<?php echo $pickup_loacation_single_array_value['end_time'];?>" style="width:20%; padding:7px;" />
<input type="text" name="byconsolewooodt_pickup_location[<?php echo $pickup_loacation_single_array_key;?>][min_cart_value]" id="byconsolewooodt_pickup_location" value="<?php echo $pickup_loacation_single_array_value['min_cart_value'];?>" style="width:20%; padding:7px;" />
<span  id="del_pickup" class="pickup_location<?php echo $pickup_i; ?>">X</span>
</fieldset>
<!--<input type="text" name="byconsolewooodt_pickup_location[][<?php echo $pickup_location_single_array_key; ?>]" id="byconsolewooodt_pickup_location" style="width:30%; padding:7px;" value="<?php printf( __('%s','ByConsoleWooODTExtended'),$pickup_location_single_array_value); ?>" />-->
<?php 
/*if($pickup_i % 4 == 0)
{		
$byconsolewooodt_division_val = $pickup_i / 4;
$byconsolewooodt_division_addition_val = $byconsolewooodt_division_val + 1 ; 
*/	
//echo $abc = $pickup_i-3;
//echo '<span  id="del_pickup" class="pickup_location'.$byconsolewooodt_division_val.'">X</span></fieldset><fieldset class="fldst pickup_location'.$byconsolewooodt_division_addition_val.'">';
/*	}	
}*/
$pickup_i++;
}
}
?>
<div class="pickup_options">
</div>  
<fieldset class="fldst">
<input type="button" id="btn_pickup_add_another" value="Add" class="" />
</fieldset>
<?php
}
function byconsolewooodt_multiple_delivery_location_lebel()
{
?>
<input type="checkbox" name="byconsolewooodt_multiple_delivery_location" id="byconsolewooodt_multiple_delivery_location" style="float: none; width: auto;" value="YES" <?php if( get_option('byconsolewooodt_multiple_delivery_location')=='YES'){?> checked="checked"<?php }?> />
<?php echo __('Enable multiple delivery location.','ByConsoleWooODTExtended');
}
function byconsolewooodt_delivery_location()
{
$byconsolwooodtgetalldeliverylocation=get_option('byconsolewooodt_delivery_location');
//print_r($byconsolwooodtgetalldeliverylocation);
if (!empty($byconsolwooodtgetalldeliverylocation)){
foreach ($byconsolwooodtgetalldeliverylocation as $byconsolwooodtgetalldeliverylocation_key => $byconsolwooodtgetalldeliverylocation_val)
{
$byconsolwooodtgetalldeliverylocation_key_value[]=$byconsolwooodtgetalldeliverylocation_key;
}
}
else
{
//echo 'Delivery Location Is Empty.';
}
?>
<script type="text/javascript">
jQuery(document).ready(function() {	
//byconsolewooodt_delivery_location_count=<?php //echo count(get_option('byconsolewooodt_delivery_location'));?>;
byconsolewooodt_delivery_location_count= 
<?php if (empty($byconsolwooodtgetalldeliverylocation_key_value)){ echo '0' ;} else { echo end($byconsolwooodtgetalldeliverylocation_key_value); }?>
//alert(byconsolewooodt_delivery_location_count);
jQuery('#btn_delivery_add_another').click(function(){	
byconsolewooodt_delivery_location_count+=1;
//jQuery('.delivery_options').append('<fieldset class="fldst delivery_location'+byconsolewooodt_delivery_location_count+'"><input type="text" name="byconsolewooodt_delivery_location[]" id="byconsolewooodt_delivery_location" value="" style="width:30%; padding:7px;" /> <span id="del_delivery" class="delivery_location'+byconsolewooodt_delivery_location_count+'" style="cursor:pointer;" >X</span></fieldset>');
jQuery('.delivery_options').append('<fieldset class="fldst delivery_location'+byconsolewooodt_delivery_location_count+'"><input type="checkbox" name="byconsolewooodt_pickup_location['+byconsolewooodt_delivery_location_count+'][location_disable]" id="byconsolewooodt_pickup_location" value="disable" style="float: left;margin-top: 10px;width: 5px;margin-right: 40px;" /><input type="text" name="byconsolewooodt_delivery_location['+byconsolewooodt_delivery_location_count+'][location]" id="byconsolewooodt_delivery_location" placeholder="Delivery Location" value="" style="width:20%; padding:7px;" /><input type="time" name="byconsolewooodt_delivery_location['+byconsolewooodt_delivery_location_count+'][start_time]" id="byconsolewooodt_delivery_location" value="" style="width:20%; padding:7px;" /><input type="time" name="byconsolewooodt_delivery_location['+byconsolewooodt_delivery_location_count+'][end_time]" id="byconsolewooodt_delivery_location" value="" style="width:20%; padding:7px;" /><input type="text" name="byconsolewooodt_delivery_location['+byconsolewooodt_delivery_location_count+'][min_cart_value]" id="byconsolewooodt_delivery_location" placeholder="Delivery Price" value="" style="width:20%; padding:7px;" /> <span id="del_delivery" class="delivery_location'+byconsolewooodt_delivery_location_count+'" style="cursor:pointer;">X</span></fieldset>');
});
});
</script>
<?php 
$byconsolewooodt_delivery_loacation_array = get_option('byconsolewooodt_delivery_location');
//print_r($byconsolewooodt_delivery_loacation_array);
?>
<div style="width:100%;">
<div style="width: 8%;float: left;"><b>Disable</b></div>
<div style="width: 21%;float: left;"><b>Location</b></div>
<div style="width: 21%;float: left;"><b>Start Time</b></div>
<div style="width: 21%;float: left;"><b>End Time</b></div>
<div><b>Min Cart Price</b></div>
</div><br />
<?php
if(!empty($byconsolewooodt_delivery_loacation_array)){
$delivery_i=1;
foreach ($byconsolewooodt_delivery_loacation_array as $delivery_loacation_single_array_key => $delivery_loacation_single_array_value)
{
?>
<fieldset class="fldst delivery_location<?php echo $delivery_i;?>">
<input type="checkbox" name="byconsolewooodt_delivery_location[<?php echo $delivery_loacation_single_array_key;?>][location_disable]" id="byconsolewooodt_delivery_location" <?php if($delivery_loacation_single_array_value['location_disable']=='on') {?> checked="checked" <?php }?>  style="float: left;margin-top: 10px;width: 5px;margin-right: 40px;" />
<input type="text" name="byconsolewooodt_delivery_location[<?php echo $delivery_loacation_single_array_key;?>][location]" id="byconsolewooodt_delivery_location" value="<?php echo $delivery_loacation_single_array_value['location'];?>" style="width:20%; padding:7px;" />
<input type="time" name="byconsolewooodt_delivery_location[<?php echo $delivery_loacation_single_array_key;?>][start_time]" id="byconsolewooodt_delivery_location" value="<?php echo $delivery_loacation_single_array_value['start_time'];?>" style="width:20%; padding:7px;" />
<input type="time" name="byconsolewooodt_delivery_location[<?php echo $delivery_loacation_single_array_key;?>][end_time]" id="byconsolewooodt_delivery_location" value="<?php echo $delivery_loacation_single_array_value['end_time'];?>" style="width:20%; padding:7px;" />
<input type="text" name="byconsolewooodt_delivery_location[<?php echo $delivery_loacation_single_array_key;?>][min_cart_value]" id="byconsolewooodt_delivery_location" value="<?php echo $delivery_loacation_single_array_value['min_cart_value'];?>" style="width:20%; padding:7px;" />
<span  id="del_delivery" class="delivery_location<?php echo $delivery_i;?>">X</span>
</fieldset>
<?php
$delivery_i++;
}
}
?>
<div class="delivery_options">
</div>  
<fieldset class="fldst">
<input type="button" id="btn_delivery_add_another" value="Add" class="" />
</fieldset>
<?php
}
/************************************************ Location Setting End ********************************************************************/
function byconsolewooodt_admin_general_settings_form()
{
?>
<div class="wrap">
<h1>ByConsole Woocommerce Order Delivery Time management settings pannel</h1>
<form method="post" class="form_byconsolewooodt_plugin_settings" action="options.php">
<?php
settings_fields("section");
do_settings_sections("byconsolewooodt_plugin_options");      
submit_button(); 
?>          
</form>
</div>
<?php }
function byconsolewooodt_chekout_page_section_heading()
{
?>
<input type="text" name="byconsolewooodt_chekout_page_section_heading" id="byconsolewooodt_chekout_page_section_heading" style="width:30%; padding:7px;" value="<?php printf( __('%s','ByConsoleWooODTExtended'),get_option('byconsolewooodt_chekout_page_section_heading')); ?>"/>
<label><?php echo __('Texts to display on checkout page as section heading.','ByConsoleWooODTExtended');?></label><br />
<span style="color:#a0a5aa">(Eg: Desired delivery date and time)</span>
<?php
}


function byconsolewooodt_hours_format()
{                                        
?>
<select id="byconsolewooodt_hours_format" name="byconsolewooodt_hours_format" style="width:35%;" >
<option   value="H:i:s" <?php if( get_option('byconsolewooodt_hours_format')=='H:i:s'){?> selected="selected"<?php }?> >24 hours</option>
<option   value="h:i A"<?php if( get_option('byconsolewooodt_hours_format')=='h:i A'){?> selected="selected"<?php }?> >12 hours</option>
</select>
<label><?php echo __('24 hours or 12 hours with AM / PM.','ByConsoleWooODTExtended');?> </label>
<?php
}
function byconsolewooodt_preorder_days()
{
?>
<input type="number" name="byconsolewooodt_preorder_days" id="byconsolewooodt_preorder_days" style="width:30%; padding:7px;" value="<?php printf( __('%s','ByConsoleWooODTExtended'),get_option('byconsolewooodt_preorder_days')); ?>"/>
<label><?php echo __('Leave blank not to set any pre-order days, this is number of days from current date customar can place an order.','ByConsoleWooODTExtended');?></label><br />
<span style="color:#a0a5aa">(Eg: 10 Only number)</span>
<?php
}
function byconsolewooodt_restricted_preorder_days()
{
?>
<input type="number" name="byconsolewooodt_restricted_preorder_days" id="byconsolewooodt_restricted_preorder_days" style="width:30%; padding:7px;" value="<?php printf( __('%s','ByConsoleWooODTExtended'),get_option('byconsolewooodt_restricted_preorder_days')); ?>"/>
<label><?php echo __('Leave blank to not set any restricted pre-order days,This is number of days customar can not place an order before these number of days from current date.','ByConsoleWooODTExtended');?></label><br />
<span style="color:#a0a5aa">(Eg: 7 ; Only number)</span>
<?php
}
function byconsolewooodt_opening_hours()
{
?>
<label><?php echo __('From','ByConsoleWooODTExtended');?></label>
<input type="time" name="byconsolewooodt_opening_hours_from" id="byconsolewooodt_opening_hours_from" style="width:30%; padding:7px;" value="<?php printf( __('%s','ByConsoleWooODTExtended'),get_option('byconsolewooodt_opening_hours_from')); ?>" />
<label><?php echo __('To','ByConsoleWooODTExtended');?></label>
<input type="time" name="byconsolewooodt_opening_hours_to" id="byconsolewooodt_opening_hours_to" style="width:30%; padding:7px;" value="<?php printf( __('%s','ByConsoleWooODTExtended'),get_option('byconsolewooodt_opening_hours_to')); ?>" />
<label><?php echo __('Allowbale Pickup Time.','ByConsoleWooODTExtended');?></label>
<?php
}
function byconsolewooodt_delivery_hours()
{
?>
<label><?php echo __('From','ByConsoleWooODTExtended');?></label>
<input type="time" name="byconsolewooodt_delivery_hours_from" id="byconsolewooodt_delivery_hours_from" style="width:30%; padding:7px;" value="<?php printf( __('%s','ByConsoleWooODTExtended'),get_option('byconsolewooodt_delivery_hours_from')); ?>" />
<label><?php echo __('To','ByConsoleWooODTExtended');?></label>
<input type="time" name="byconsolewooodt_delivery_hours_to" id="byconsolewooodt_delivery_hours_to" style="width:30%; padding:7px;" value="<?php printf( __('%s','ByConsoleWooODTExtended'),get_option('byconsolewooodt_delivery_hours_to')); ?>" />
<label><?php echo __('Allowbale Delivery Time.','ByConsoleWooODTExtended');?></label>
<?php
}
function byconsolewooodt_delivery_times()
{
?>
<input type="text" name="byconsolewooodt_delivery_times" id="byconsolewooodt_delivery_times" style="width:30%; padding:7px;" value="<?php printf( __('%s','ByConsoleWooODTExtended'),get_option('byconsolewooodt_delivery_times')); ?>" />
<label> <?php echo __('This is visible on widget front end if customer has choosen delivery.','ByConsoleWooODTExtended');?></label><br />
<span style="color:#a0a5aa">(Eg: 30 Minutes)</span>
<?php
}






function byconsolewooodt_widget_field_position()
{                                        
?>
<select id="byconsolewooodt_widget_field_position" name="byconsolewooodt_widget_field_position" style="width:35%;" >
<option   value="top" <?php if( get_option('byconsolewooodt_widget_field_position')=='top'){?> selected="selected"<?php }?> >Show on top</option>
<option   value="bottom"<?php if( get_option('byconsolewooodt_widget_field_position')=='bottom'){?> selected="selected"<?php }?> >Show on Bottom</option>
</select>
<label><?php echo __('Choose if tracking text have to be shown on top(before order product list) or bottom(after product list).','ByConsoleWooODTExtended');?> </label>
<?php
}
function byconsolewooodt_opening_break_hours()
{
?>
<label><?php echo __('From','ByConsoleWooODTExtended');?></label>
<input type="time" name="byconsolewooodt_opening_break_hours_from" id="byconsolewooodt_opening_break_hours_from" style="width:30%; padding:7px;" value="<?php printf( __('%s','ByConsoleWooODTExtended'),get_option('byconsolewooodt_opening_break_hours_from')); ?>" />
<label><?php echo __('To','ByConsoleWooODTExtended');?></label>
<input type="time" name="byconsolewooodt_opening_break_hours_to" id="byconsolewooodt_opening_break_hours_to" style="width:30%; padding:7px;" value="<?php printf( __('%s','ByConsoleWooODTExtended'),get_option('byconsolewooodt_opening_break_hours_to')); ?>" />
<label><?php echo __('The time for which no opening will be Proceeded.','ByConsoleWooODTExtended');?></label>
<?php
}
function byconsolewooodt_delivery_break_hours()
{
?>
<label><?php echo __('From','ByConsoleWooODTExtended');?></label>
<input type="time" name="byconsolewooodt_delivery_hours_break_from" id="byconsolewooodt_delivery_hours_break_from" style="width:30%; padding:7px;" value="<?php printf( __('%s','ByConsoleWooODTExtended'),get_option('byconsolewooodt_delivery_hours_break_from')); ?>" />
<label><?php echo __('To','ByConsoleWooODTExtended');?></label>
<input type="time" name="byconsolewooodt_delivery_hours_break_to" id="byconsolewooodt_delivery_hours_break_to" style="width:30%; padding:7px;" value="<?php printf( __('%s','ByConsoleWooODTExtended'),get_option('byconsolewooodt_delivery_hours_break_to')); ?>" />
<label><?php echo __('The time for which no delivery will be Proceeded.','ByConsoleWooODTExtended');?></label>
<?php
}

function byconsolewooodt_delivery_day_option_setting()
{
$delivery_days = get_option('byconsolewooodt_delivery_days');
?>
<div class="closings_by_day">
<span> Select All:</span><input type="checkbox" id="check_all_delivery_days" value="all" name="check_all_delivery_days" class="custom" <?php if(!empty($delivery_days)){if(in_array('all',$delivery_days)) { ?> checked="checked" <?php }}?> /><br /><br />
<span>Sunday:</span><input type="checkbox" name="byconsolewooodt_delivery_days[]" id="byconsolewooodt_delivery_days" class="custom delivery" value="1" <?php if(!empty($delivery_days)){if(in_array(1,$delivery_days)) { ?> checked="checked" <?php }}?> /><br /><br />
<span>Monday:</span><input type="checkbox" name="byconsolewooodt_delivery_days[]" id="byconsolewooodt_delivery_days" class="custom delivery" value="2" <?php if(!empty($delivery_days)){if(in_array(2,$delivery_days)) { ?> checked="checked" <?php }}?> /><br /><br />
<span>Tuesday:</span><input type="checkbox" name="byconsolewooodt_delivery_days[]" id="byconsolewooodt_delivery_days" class="custom delivery" value="3" <?php if(!empty($delivery_days)){if(in_array(3,$delivery_days)) { ?> checked="checked" <?php }}?>/><br /><br />
<span>Wednessday:</span><input type="checkbox" name="byconsolewooodt_delivery_days[]" id="byconsolewooodt_delivery_days" class="custom delivery" value="4" <?php if(!empty($delivery_days)){if(in_array(4,$delivery_days)) { ?> checked="checked" <?php }}?>/><br /><br />
<span>Thursday:</span><input type="checkbox" name="byconsolewooodt_delivery_days[]" id="byconsolewooodt_delivery_days" class="custom delivery" value="5" <?php if(!empty($delivery_days)){if(in_array(5,$delivery_days)) { ?> checked="checked" <?php }}?>/><br /><br />
<span>Friday:</span><input type="checkbox" name="byconsolewooodt_delivery_days[]" id="byconsolewooodt_delivery_days" class="custom delivery" value="6" <?php if(!empty($delivery_days)){if(in_array(6,$delivery_days)) { ?> checked="checked" <?php }}?>/><br /><br />
<span>Saturday:</span><input type="checkbox" name="byconsolewooodt_delivery_days[]" id="byconsolewooodt_delivery_days" class="custom delivery" value="7" <?php if(!empty($delivery_days)){if(in_array(7,$delivery_days)) { ?> checked="checked" <?php }}?>/>
</div>
<script>
jQuery('#check_all_delivery_days').click(function(){      
jQuery('.custom.delivery').attr('checked', true);   
});
</script>
<?php
}
function byconsolewooodt_pickup_day_option_setting()
{
$pickup_days = get_option('byconsolewooodt_pickup_days');
?>
<div class="closings_by_day">
<span> Select All:</span><input type="checkbox" id="check_all_pickup_days" value="all" name="check_all_pickup_days" class="custom" <?php if(!empty($delivery_days)){if(in_array('all',$pickup_days)) { ?> checked="checked" <?php }}?> /><br /><br />
<span>Sunday:</span><input type="checkbox" name="byconsolewooodt_pickup_days[]" id="byconsolewooodt_pickup_days" class="custom selector" value="1" <?php if(!empty($pickup_days)){if(in_array(1,$pickup_days)) { ?> checked="checked" <?php }}?> /><br /><br />
<span>Monday:</span><input type="checkbox" name="byconsolewooodt_pickup_days[]" id="byconsolewooodt_pickup_days" class="custom selector" value="2" <?php if(!empty($pickup_days)){if(in_array(2,$pickup_days)) { ?> checked="checked" <?php }}?> /><br /><br />
<span>Tuesday:</span><input type="checkbox" name="byconsolewooodt_pickup_days[]" id="byconsolewooodt_pickup_days" class="custom selector" value="3" <?php if(!empty($pickup_days)){if(in_array(3,$pickup_days)) { ?> checked="checked" <?php }}?>/><br /><br />
<span>Wednessday:</span><input type="checkbox" name="byconsolewooodt_pickup_days[]" id="byconsolewooodt_pickup_days" class="custom selector" value="4" <?php if(!empty($pickup_days)){if(in_array(4,$pickup_days)) { ?> checked="checked" <?php }}?>/><br /><br />
<span>Thursday:</span><input type="checkbox" name="byconsolewooodt_pickup_days[]" id="byconsolewooodt_pickup_days" class="custom selector" value="5" <?php if(!empty($pickup_days)){if(in_array(5,$pickup_days)) { ?> checked="checked" <?php }}?>/><br /><br />
<span>Friday:</span><input type="checkbox" name="byconsolewooodt_pickup_days[]" id="byconsolewooodt_pickup_days" value="6" class="custom selector" <?php if(!empty($pickup_days)){if(in_array(6,$pickup_days)) { ?> checked="checked" <?php }}?>/><br /><br />
<span>Saturday:</span><input type="checkbox" name="byconsolewooodt_pickup_days[]" id="byconsolewooodt_pickup_days" value="7" class="custom selector" <?php if(!empty($pickup_days)){if(in_array(7,$pickup_days)) { ?> checked="checked" <?php }}?>/>
</div>
<script>
jQuery('#check_all_pickup_days').click(function(){      
jQuery('.custom.selector').attr('checked', true);   
});
</script>
<?php
}
function byconsolewooodt_order_type()
{
?>
<input type="radio" name="byconsolewooodt_order_type" id="byconsolewooodt_order_type" value="levering" <?php if( get_option('byconsolewooodt_order_type')=='levering'){?> checked="checked"<?php }?> />Delivery
<input type="radio" name="byconsolewooodt_order_type" id="byconsolewooodt_order_type" value="take_away" <?php if( get_option('byconsolewooodt_order_type')=='take_away'){?> checked="checked"<?php }?> />Pickup
<input type="radio" name="byconsolewooodt_order_type" id="byconsolewooodt_order_type" value="both" <?php if( get_option('byconsolewooodt_order_type')=='both'){?> checked="checked"<?php }?> />Both
<script>
</script>
<?php } 
add_action('admin_init', 'byconsolewooodt_plugin_settings_fields');
function byconsolewooodt_plugin_settings_fields()
{
add_settings_section("section", "All Settings", null, "byconsolewooodt_plugin_options");
add_settings_field("byconsolewooodt_order_type", "Delivery Type:", "byconsolewooodt_order_type", "byconsolewooodt_plugin_options", "section");
add_settings_field("byconsolewooodt_preorder_days", "Preorder Days:", "byconsolewooodt_preorder_days", "byconsolewooodt_plugin_options", "section");
add_settings_field("byconsolewooodt_restricted_preorder_days", "Preorder Days Restriction:", "byconsolewooodt_restricted_preorder_days", "byconsolewooodt_plugin_options", "section");
add_settings_field("byconsolewooodt_opening_hours", "Pickup Hours:", "byconsolewooodt_opening_hours", "byconsolewooodt_plugin_options", "section");
add_settings_field("byconsolewooodt_pickup_day_option_setting", "Pickup Day(s):", "byconsolewooodt_pickup_day_option_setting", "byconsolewooodt_plugin_options", "section");
//add_settings_field("byconsolewooodt_multiple_pickup_location_lebel", "Multiple Pickup Location:", "byconsolewooodt_multiple_pickup_location_lebel", "byconsolewooodt_plugin_options", "section");
//add_settings_field("byconsolewooodt_pickup_location", "Pickup Location:", "byconsolewooodt_pickup_location", "byconsolewooodt_plugin_options", "section");
add_settings_field("byconsolewooodt_delivery_hours", "Delivery Hours:", "byconsolewooodt_delivery_hours", "byconsolewooodt_plugin_options", "section");
add_settings_field("byconsolewooodt_delivery_day_option_setting", "Delivery Day(s):", "byconsolewooodt_delivery_day_option_setting", "byconsolewooodt_plugin_options", "section");
//add_settings_field("byconsolewooodt_multiple_delivery_location_lebel", "Multiple Delivery Location:", "byconsolewooodt_multiple_delivery_location_lebel", "byconsolewooodt_plugin_options", "section");
// add_settings_field("byconsolewooodt_delivery_location", "Delivery Location:", "byconsolewooodt_delivery_location", "byconsolewooodt_plugin_options", "section");
add_settings_field("byconsolewooodt_opening_break_hours", "Opening break Time:", "byconsolewooodt_opening_break_hours", "byconsolewooodt_plugin_options", "section");
add_settings_field("byconsolewooodt_delivery_break_hours", "Delivery break Time:", "byconsolewooodt_delivery_break_hours", "byconsolewooodt_plugin_options", "section");
add_settings_field("byconsolewooodt_delivery_times", "Delivery Times:", "byconsolewooodt_delivery_times", "byconsolewooodt_plugin_options", "section");

add_settings_field("byconsolewooodt_widget_field_position", "Position of the text in the orders page:", "byconsolewooodt_widget_field_position", "byconsolewooodt_plugin_options", "section");

add_settings_field("byconsolewooodt_hours_format", "Time format:", "byconsolewooodt_hours_format", "byconsolewooodt_plugin_options", "section");



	
register_setting("section", "byconsolewooodt_preorder_days");
register_setting("section", "byconsolewooodt_restricted_preorder_days");
register_setting("section", "byconsolewooodt_opening_hours_from");
register_setting("section", "byconsolewooodt_opening_hours_to");
register_setting("section", "byconsolewooodt_delivery_hours_from");
register_setting("section", "byconsolewooodt_delivery_hours_to");
register_setting("section", "byconsolewooodt_delivery_times");


register_setting("section", "byconsolewooodt_orders_pick_up");
register_setting("section", "byconsolewooodt_widget_field_position");







register_setting("section", "byconsolewooodt_hours_format");
//register_setting("section", "byconsolewooodt_pickup_location");
//register_setting("section", "byconsolewooodt_delivery_location");
register_setting("section", "byconsolewooodt_opening_break_hours_from");
register_setting("section", "byconsolewooodt_opening_break_hours_to");
register_setting("section", "byconsolewooodt_delivery_hours_break_from");
register_setting("section", "byconsolewooodt_delivery_hours_break_to");

//register_setting("section", "byconsolewooodt_delivery_location_lebel");



//register_setting("section", "byconsolewooodt_multiple_pickup_location");
//register_setting("section", "byconsolewooodt_multiple_delivery_location");
register_setting("section", "byconsolewooodt_delivery_days");




register_setting("section", "byconsolewooodt_pickup_days");
register_setting("section", "byconsolewooodt_order_type");



}
/************************************************ Location Setting Start *****************************************************************/	 
add_action('admin_init', 'byconsolewooodt_location_settings_fields', 99);
function byconsolewooodt_location_settings_fields()
{
add_settings_section("wooodtlocationsetting", "wooodt Location  Settings", null, "byconsolewooodt_wooodt_location_settings_options");
add_settings_field("byconsolewooodt_multiple_pickup_location_lebel", "Multiple Pickup Location:", "byconsolewooodt_multiple_pickup_location_lebel", "byconsolewooodt_wooodt_location_settings_options", "wooodtlocationsetting");
add_settings_field("byconsolewooodt_pickup_location", "Pickup Location:<br/><span style='color:#a0a5aa;font-size:12px;'>( To disable the pickup location <br/>please check the check box )</span>", "byconsolewooodt_pickup_location", "byconsolewooodt_wooodt_location_settings_options", "wooodtlocationsetting");
add_settings_field("byconsolewooodt_multiple_delivery_location_lebel", "Multiple Delivery Location:", "byconsolewooodt_multiple_delivery_location_lebel", "byconsolewooodt_wooodt_location_settings_options", "wooodtlocationsetting");
add_settings_field("byconsolewooodt_delivery_location", "Delivery Location:<br/><span style='color:#a0a5aa;font-size:12px;'>( To disable the delivery location <br/>please check the check box )</span>", "byconsolewooodt_delivery_location", "byconsolewooodt_wooodt_location_settings_options", "wooodtlocationsetting");
//		print_r(get_option('byconsolewooodt_pickup_location'));
//		print_r(get_option('byconsolewooodt_delivery_location'));
register_setting("wooodtlocationsetting", "byconsolewooodt_pickup_location");
register_setting("wooodtlocationsetting", "byconsolewooodt_delivery_location");
register_setting("wooodtlocationsetting", "byconsolewooodt_multiple_pickup_location");
register_setting("wooodtlocationsetting", "byconsolewooodt_multiple_delivery_location");
}
/************************************************ Location Setting End *****************************************************************/
add_action('admin_init', 'byconsolewooodt_holiday_settings_fields');
function byconsolewooodt_holiday_settings_fields()
{
add_settings_section("holidaysection", "Holiday Settings", null, "byconsolewooodt_holiday_setting_options");
add_settings_field("byconsolewooodt_admin_national_holiday_date", "National Holidays Date:", "byconsolewooodt_admin_national_holiday_date_setting", "byconsolewooodt_holiday_setting_options", "holidaysection");
add_settings_field("byconsolewooodt_admin_holiday_date", "Casual Holidays Date:", "byconsolewooodt_admin_holiday_date_setting", "byconsolewooodt_holiday_setting_options", "holidaysection");
add_settings_field("byconsolewooodt_admin_holiday", "Select Closing Day:", "byconsolewooodt_admin_closing_setting", "byconsolewooodt_holiday_setting_options", "holidaysection");
register_setting("holidaysection", "byconsolewooodt_admin_national_holiday_date");
register_setting("holidaysection", "byconsolewooodt_admin_holiday_date");
register_setting("holidaysection", "byconsolewooodt_admin_closing_sunday");
register_setting("holidaysection", "byconsolewooodt_admin_closing_monday");
register_setting("holidaysection", "byconsolewooodt_admin_closing_tuesday");
register_setting("holidaysection", "byconsolewooodt_admin_closing_wednessday");
register_setting("holidaysection", "byconsolewooodt_admin_closing_thursday");
register_setting("holidaysection", "byconsolewooodt_admin_closing_friday");
register_setting("holidaysection", "byconsolewooodt_admin_closing_saturday");
}	
?>