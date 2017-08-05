<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly /** 
/*
* Plugin Name: WooODT extended
* Plugin URI: http://plugins.byconsole.com/product/byconsole-wooodt-extended/ 
* Description: Let your buyers to choose if order to deliver or pickup along with their chosen date and time (Need to have Woocommerce installed first). 
* Version: 1.0.3.2
* Author: Mrinmoy Dalabar 
* Author URI: http://byconsole.com 
* Text Domain: ByConsoleWooODTExtended
* Domain Path: /languages
* License: GPL2 
*/ 
include('inc/admin.php');
include('inc/wooodt_features_settings.php');
include('inc/language-translator.php');
include('inc/wooodt-color-picker.php');global $woocommerce;
// load plugin's text domaim
add_action('plugins_loaded','byconsolewooodt_load_text_domain');
function byconsolewooodt_load_text_domain(){
load_plugin_textdomain( 'ByConsoleWooODTExtended', false, 'ByConsoleWooODTExtended/languages' );
}
// we need cookie so lets have a safe and confirm way
//add_action('init', 'byconsolewooodtSetCookie', 1);
add_action('init', 'byconsolewooodtSetCookie', 1);
function byconsolewooodtSetCookie() {
// set default values if empty to avoid undefined index issue using cookies
if(empty($_COOKIE['byconsolewooodt_delivery_widget_cookie'])){
// set default value based on order type selection on settings page
if(get_option('byconsolewooodt_order_type')=='levering'){
$byconsolewooodt_delivery_widget=array(
'byconsolewooodt_widget_date_field'=>'',
'byconsolewooodt_widget_time_field'=>'',
'byconsolewooodt_widget_time_type_field'=>'',
'byconsolewooodt_widget_type_field'=>'levering',
'byconsolewooodt_widget_pickup_location'=>'',
'byconsolewooodt_widget_delivery_location'=>''
); 
}else if(get_option('byconsolewooodt_order_type')=='take_away'){
$byconsolewooodt_delivery_widget=array(
'byconsolewooodt_widget_date_field'=>'',
'byconsolewooodt_widget_time_field'=>'',
'byconsolewooodt_widget_time_type_field'=>'',
'byconsolewooodt_widget_type_field'=>'take_away',
'byconsolewooodt_widget_pickup_location'=>'',
'byconsolewooodt_widget_delivery_location'=>''
); 
}else if(get_option('byconsolewooodt_order_type')=='both'){
$byconsolewooodt_delivery_widget=array(
'byconsolewooodt_widget_date_field'=>'',
'byconsolewooodt_widget_time_field'=>'',
'byconsolewooodt_widget_time_type_field'=>'',
'byconsolewooodt_widget_type_field'=>'levering',
'byconsolewooodt_widget_pickup_location'=>'',
'byconsolewooodt_widget_delivery_location'=>''
); 
}else{ // if accedently no value set for order type in settings page(if it happen there may be a ghost in your system) 
$byconsolewooodt_delivery_widget=array(
'byconsolewooodt_widget_date_field'=>'',
'byconsolewooodt_widget_time_field'=>'',
'byconsolewooodt_widget_time_type_field'=>'',
'byconsolewooodt_widget_type_field'=>'levering',
'byconsolewooodt_widget_pickup_location'=>'',
'byconsolewooodt_widget_delivery_location'=>''
); 			
}
$json_byconsolewooodt_delivery_widget=json_encode($byconsolewooodt_delivery_widget);
setcookie('byconsolewooodt_delivery_widget_cookie',$json_byconsolewooodt_delivery_widget,time() + 60 * 60 * 24 *1,'/');
$_COOKIE['byconsolewooodt_delivery_widget_cookie']=$json_byconsolewooodt_delivery_widget; // Avoide php notice while cookies are just created but not fetched yet in next http request
}else{
// if cookies are set already then overwrite cookie value based on admin settings for order type selection
// get cookie as array to overwrite them
$stripped_out_byconsolewooodt_delivery_widget_cookie=stripslashes($_COOKIE['byconsolewooodt_delivery_widget_cookie']);
$byconsolewooodt_delivery_widget_cookie_array=json_decode($stripped_out_byconsolewooodt_delivery_widget_cookie,true);
$byconsolewooodt_widget_date_field = ! empty( $byconsolewooodt_delivery_widget_cookie_array['byconsolewooodt_widget_date_field'] ) ? $byconsolewooodt_delivery_widget_cookie_array['byconsolewooodt_widget_date_field'] : false;
$byconsolewooodt_widget_time_field = ! empty( $byconsolewooodt_delivery_widget_cookie_array['byconsolewooodt_widget_time_field'] ) ? $byconsolewooodt_delivery_widget_cookie_array['byconsolewooodt_widget_time_field'] : false;
$byconsolewooodt_widget_time_type_field = ! empty( $byconsolewooodt_delivery_widget_cookie_array['byconsolewooodt_widget_time_type_field'] ) ? $byconsolewooodt_delivery_widget_cookie_array['byconsolewooodt_widget_time_type_field'] : false;
// override the cookie value if order type setting is set as only for delivery or pickup
if(get_option('byconsolewooodt_order_type')=='levering'){
$byconsolewooodt_widget_type_field = 'levering';	
}else
if(get_option('byconsolewooodt_order_type')=='take_away'){
$byconsolewooodt_widget_type_field = 'take_away';		
}else{
$byconsolewooodt_widget_type_field = ! empty( $byconsolewooodt_delivery_widget_cookie_array['byconsolewooodt_widget_type_field'] ) ? $byconsolewooodt_delivery_widget_cookie_array['byconsolewooodt_widget_type_field'] : false;
}
$byconsolewooodt_widget_time_type_field = ! empty( $byconsolewooodt_delivery_widget_cookie_array['byconsolewooodt_widget_time_type_field'] ) ? $byconsolewooodt_delivery_widget_cookie_array['byconsolewooodt_widget_time_type_field'] : false;
$byconsolewooodt_widget_pickup_location = ! empty( $byconsolewooodt_delivery_widget_cookie_array['byconsolewooodt_widget_pickup_location'] ) ? $byconsolewooodt_delivery_widget_cookie_array['byconsolewooodt_widget_pickup_location'] : false;
$byconsolewooodt_widget_delivery_location = ! empty( $byconsolewooodt_delivery_widget_cookie_array['byconsolewooodt_widget_delivery_location'] ) ? $byconsolewooodt_delivery_widget_cookie_array['byconsolewooodt_widget_delivery_location'] : false;
$byconsolewooodt_delivery_widget=array(
'byconsolewooodt_widget_date_field'=>$byconsolewooodt_widget_date_field,
'byconsolewooodt_widget_time_field'=>$byconsolewooodt_widget_time_field,
'byconsolewooodt_widget_time_type_field'=>$byconsolewooodt_widget_time_type_field,
'byconsolewooodt_widget_type_field'=>$byconsolewooodt_widget_type_field,
'byconsolewooodt_widget_pickup_location'=>$byconsolewooodt_widget_pickup_location,
'byconsolewooodt_widget_delivery_location'=>$byconsolewooodt_widget_delivery_location
); 	
// set the cookie with new values
$json_byconsolewooodt_delivery_widget=json_encode($byconsolewooodt_delivery_widget);
setcookie('byconsolewooodt_delivery_widget_cookie',$json_byconsolewooodt_delivery_widget,time() + 60 * 60 * 24 *1,'/');
$_COOKIE['byconsolewooodt_delivery_widget_cookie']=$json_byconsolewooodt_delivery_widget; // Avoide php notice while cookies are just created but not fetched yet in next http request
} // end of  if(empty($_COOKIE['byconsolewooodt_delivery_widget_cookie']))
} 
// front-end widget 
class byconsolewooodt_widget extends WP_Widget {
function __construct() {
parent::__construct(
// Base ID of our widget
'byconsolewooodt_widget', 
// Widget name will appear in UI
__('Order delivery time widget', 'ByConsoleWooODTExtended'), 
// Widget description
array( 'description' => __( 'Widget for users to choose time and date of delivery', 'ByConsoleWooODTExtended' ), ) 
);
}
// Creating widget front-end
// This is where the action happens
public function widget( $args, $instance ) {
$currentlang=get_locale();
global $woocommerce;
global $post;
echo $args['before_widget'];
if ( ! empty( $instance['byconsolewooodt_widget_title'] ) ) {
echo $args['before_title'] . apply_filters( 'widget_title', $instance['byconsolewooodt_widget_title'] ) . $args['after_title'];
}
//echo __( esc_attr( 'Enter your delivery date and time' ), 'ByConsoleWooODTExtended' );
echo $args['after_widget'];
// get cookie as array
$stripped_out_byconsolewooodt_delivery_widget_cookie=stripslashes($_COOKIE['byconsolewooodt_delivery_widget_cookie']);
$byconsolewooodt_delivery_widget_cookie_array=json_decode($stripped_out_byconsolewooodt_delivery_widget_cookie,true);
$byconsolewooodt_delivery_date = ! empty( $byconsolewooodt_delivery_widget_cookie_array['byconsolewooodt_widget_date_field'] ) ? $byconsolewooodt_delivery_widget_cookie_array['byconsolewooodt_widget_date_field'] : false;
$byconsolewooodt_delivery_time = ! empty( $byconsolewooodt_delivery_widget_cookie_array['byconsolewooodt_widget_time_field'] ) ? $byconsolewooodt_delivery_widget_cookie_array['byconsolewooodt_widget_time_field'] : false;
$byconsolewooodt_delivery_time_type = ! empty( $byconsolewooodt_delivery_widget_cookie_array['byconsolewooodt_widget_time_type_field'] ) ? $byconsolewooodt_delivery_widget_cookie_array['byconsolewooodt_widget_time_type_field'] : false;
// override the cookie value if order type setting is set as only for delivery or pickup
if(get_option('byconsolewooodt_order_type')=='levering'){
$byconsolewooodt_delivery_widget_cookie_array['byconsolewooodt_widget_type_field'] = 'levering';	
} 
if(get_option('byconsolewooodt_order_type')=='take_away'){
$byconsolewooodt_delivery_widget_cookie_array['byconsolewooodt_widget_type_field'] = 'take_away';		
}
$byconsolewooodt_delivery_type = ! empty( $byconsolewooodt_delivery_widget_cookie_array['byconsolewooodt_widget_type_field'] ) ? $byconsolewooodt_delivery_widget_cookie_array['byconsolewooodt_widget_type_field'] : false;
$byconsolewooodt_pickup_location = ! empty( $byconsolewooodt_delivery_widget_cookie_array['byconsolewooodt_widget_pickup_location'] ) ? $byconsolewooodt_delivery_widget_cookie_array['byconsolewooodt_widget_pickup_location'] : false;
$byconsolewooodt_delivery_location = ! empty( $byconsolewooodt_delivery_widget_cookie_array['byconsolewooodt_widget_delivery_location'] ) ? $byconsolewooodt_delivery_widget_cookie_array['byconsolewooodt_widget_delivery_location'] : false;
$isholiday = 'NO';
$todaydate = date("m/d/Y");
$todaydate_dm = date("m/d");
$shownotice='none';
$get_all_dates = get_option('byconsolewooodt_admin_holiday_date');
$dateexplode=explode(",",$get_all_dates);	
//Chaking if today is casual holiday
if(in_array($todaydate , $dateexplode))
{			
$isholiday = 'YES';			
}
// get todays date 
$gattodayname=date("l");
$gattodaynumericval=date("w");				
$sunday = get_option('byconsolewooodt_admin_closing_sunday');
$monday = get_option('byconsolewooodt_admin_closing_monday');
$tuesday = get_option('byconsolewooodt_admin_closing_tuesday');
$wednessday = get_option('byconsolewooodt_admin_closing_wednessday');
$thursday = get_option('byconsolewooodt_admin_closing_thursday');
$friday = get_option('byconsolewooodt_admin_closing_friday');
$saturday = get_option('byconsolewooodt_admin_closing_saturday');
/*echo '<script>alert("'.$sunday.'");</script>';*/
$sunday = ($sunday=='') ? 99 : 0;
$monday = ! empty($monday) ? $monday : 99;
$tuesday = ! empty($tuesday) ? $tuesday : 99;
$wednessday = ! empty($wednessday) ? $wednessday : 99;
$thursday = ! empty($thursday) ? $thursday : 99;
$friday = ! empty($friday) ? $friday : 99;
$saturday = ! empty($saturday) ? $saturday : 99;
//$allweekdays=array($sunday,$monday,$tuesday,$wednessday,$thursday,$friday,$saturday);
//print_r($allweekdays);
// check if shop is closed today
if($sunday==$gattodaynumericval || $monday==$gattodaynumericval || $tuesday==$gattodaynumericval || $wednessday==$gattodaynumericval || $thursday==$gattodaynumericval || $friday==$gattodaynumericval || $saturday==$gattodaynumericval)
{
$isholiday = 'YES';
}
$get_all_national_holidays_dates = get_option('byconsolewooodt_admin_national_holiday_date');
$national_holidays_array=explode(",",$get_all_national_holidays_dates);
// chaking if it is national holiday
if(in_array($todaydate_dm , $national_holidays_array))
{			
$isholiday = 'YES';			
}
if($isholiday === 'NO')
{
?>
<form action="" method="post">
<?php
$weekday_today=date('l');
/*echo '<script>alert("'.$weekday_today.'");</script>';*/
// populate order type based on order type selection on settings page
if(get_option('byconsolewooodt_order_type')=='take_away' || get_option('byconsolewooodt_order_type')=='both'){
?>
<input type="radio" name="byconsolewooodt_widget_type_field" value="take_away"<?php if($byconsolewooodt_delivery_type=='take_away'){echo ' checked="checked"';}?> /> <?php echo get_option('byconsolewooodt_pickup_lable');?>
<?php }
if(get_option('byconsolewooodt_order_type')=='levering' || get_option('byconsolewooodt_order_type')=='both'){
?>
<input type="radio" name="byconsolewooodt_widget_type_field" value="levering"<?php if($byconsolewooodt_delivery_type=='levering'){echo ' checked="checked"';}?> /><?php echo get_option('byconsolewooodt_delivery_lable');?>
<?php }?>
<?php 
// populate the delivery location only when levering is selected and delivery location list is not blank
$byconsolewooodt_multiple_delivery_location=get_option('byconsolewooodt_multiple_delivery_location');
$byconsolewooodt_delivery_locations= get_option('byconsolewooodt_delivery_location');
//print_r($byconsolewooodt_delivery_locations);
if($byconsolewooodt_delivery_type=='levering' && !empty($byconsolewooodt_delivery_locations) && $byconsolewooodt_multiple_delivery_location=='YES'){
$TotalCartAmountValue = $woocommerce->cart->total; // This is without currency symbo 
$TotalCartContentCount = $woocommerce->cart->cart_contents_count; // This is total no item
?>
<br />
<select name="byconsolewooodt_widget_delivery_location" id="byconsolewooodt_widget_delivery_location" onchange="ByconsolewooodtDeliveryWidgetTimePopulate('.byconsolewooodt_widget_date_field','.byconsolewooodt_widget_time_field',this);">
<option value="">Select delivery location</option>
<?php
foreach($byconsolewooodt_delivery_locations as $delivery_loaction_key => $delivery_loaction_value)
{
$DeliveryLocationArray[] = $delivery_loaction_value['min_cart_value'] .'/'.$delivery_loaction_key;
if($delivery_loaction_value['location_disable']!='on')
{
if(empty($delivery_loaction_value['min_cart_value'])|| $delivery_loaction_value['min_cart_value']=='' || $delivery_loaction_value['min_cart_value']==0){
$minimum_order_value=__('No bar', 'ByConsoleWooODTExtended');
}else{
$minimum_order_value=get_woocommerce_currency_symbol() .$delivery_loaction_value['min_cart_value'];
}
$delivery_loaction_option_text_value=$delivery_loaction_value['location'].'&nbsp;&nbsp;-- &nbsp;&nbsp;Time &nbsp;( '. $delivery_loaction_value['start_time'] .'-'.$delivery_loaction_value['end_time'].' )&nbsp;&nbsp;-- &nbsp;&nbsp; Min. Order:&nbsp;('.$minimum_order_value.')';
?>
<option value="<?php echo $delivery_loaction_key;?>" <?php if($delivery_loaction_key==$byconsolewooodt_delivery_location){echo ' selected="selected"';}?> ><?php echo $delivery_loaction_option_text_value; ?></option>
<?php 		}
}
//foreach($byconsolewooodt_delivery_locations as $delivery_location){?>
<!--<option value="<?php //echo $delivery_location;?>" <?php //if($delivery_location==$byconsolewooodt_delivery_location){echo ' selected="selected"';}?>><?php //echo $delivery_location; ?></option>-->
<?php //}?>
</select>
<?php }
if(!empty($DeliveryLocationArray)){
foreach($DeliveryLocationArray as $DeliveryLocationSingleArrayVal)
{
$ExplodeDeliveryLocationAndKeyValue=explode("/" ,$DeliveryLocationSingleArrayVal);
// || $ExplodeDeliveryLocationAndKeyValue[0]=='' || $ExplodeDeliveryLocationAndKeyValue[0]=='0'
if($TotalCartAmountValue < $ExplodeDeliveryLocationAndKeyValue[0] && ($ExplodeDeliveryLocationAndKeyValue[0]!=0 || !empty($ExplodeDeliveryLocationAndKeyValue[0])))
{
//echo $xyz[1];
//disable selection of below min. order options
?> 
<script>
jQuery(document).ready(function(){
jQuery('#byconsolewooodt_widget_delivery_location option[value="<?php echo $ExplodeDeliveryLocationAndKeyValue[1];?>"]').prop('disabled', 'disabled');
//alert();
});
</script>
<?php
}
else
{
}
}
}
// populate the pickup location only when take_away is selected and pickup location list is not blank
$byconsolewooodt_multiple_pickup_location=get_option('byconsolewooodt_multiple_pickup_location');
$byconsolewooodt_pickup_locations= get_option('byconsolewooodt_pickup_location');
//print_r($byconsolewooodt_pickup_locations);
if($byconsolewooodt_delivery_type=='take_away' && !empty($byconsolewooodt_pickup_locations) && $byconsolewooodt_multiple_pickup_location=="YES"){
?>
<br />
<?php $TotalCartAmountValue = $woocommerce->cart->total; // This is without currency symbo ?>
<select name="byconsolewooodt_widget_pickup_location" id="byconsolewooodt_widget_pickup_location" onchange="ByconsolewooodtDeliveryWidgetTimePopulate('.byconsolewooodt_widget_date_field','.byconsolewooodt_widget_time_field',this);">
<option value="">Select pickup location</option>
<?php foreach($byconsolewooodt_pickup_locations as $pickup_loaction_key => $pickup_loaction_value)	{
$PickupLocationArray[] = $pickup_loaction_value['min_cart_value'] .'/'.$pickup_loaction_key;
if($pickup_loaction_value['location_disable']!='on')
{
if(empty($pickup_loaction_value['min_cart_value'])|| $pickup_loaction_value['min_cart_value']=='' || $pickup_loaction_value['min_cart_value']==0){
$minimum_order_value=__('No bar', 'ByConsoleWooODTExtended');
}else{
$minimum_order_value=get_woocommerce_currency_symbol() .$pickup_loaction_value['min_cart_value'];
}
$pickup_loaction_option_text_value=$pickup_loaction_value['location'].'&nbsp;&nbsp;-- &nbsp;&nbsp;Time &nbsp;( '. $pickup_loaction_value['start_time'] .'-'.$pickup_loaction_value['end_time'].' )&nbsp;&nbsp;-- &nbsp;&nbsp; Min. Order:&nbsp;('.$minimum_order_value.')';
?>
<option value="<?php echo $pickup_loaction_key;?>" <?php if($pickup_loaction_key==$byconsolewooodt_pickup_location){echo ' selected="selected"';}?>><?php echo $pickup_loaction_option_text_value;?></option>
<?php 		} 
}
//foreach($byconsolewooodt_pickup_locations as $pickup_location){?>
<!--option value="<?php //echo $pickup_location;?>" <?php //if($pickup_location==$byconsolewooodt_pickup_location){echo ' selected="selected"';}?>><?php //echo $pickup_location;?></option-->
<?php //}?>
</select>
<?php }
if(!empty($PickupLocationArray)){
foreach($PickupLocationArray as $PickupLocationSingleArrayVal)
{
$ExplodePickupLocationAndKeyValue=explode("/" ,$PickupLocationSingleArrayVal);
// || $ExplodePickupLocationAndKeyValue[0]=='' || $ExplodePickupLocationAndKeyValue[0]=='0'
if($TotalCartAmountValue < $ExplodePickupLocationAndKeyValue[0] && ($ExplodePickupLocationAndKeyValue[0]!=0 || !empty($ExplodePickupLocationAndKeyValue[0])))
{
//echo $xyz[1];
//disable selection of below min. order options
?> 
<script>
jQuery(document).ready(function(){
jQuery('#byconsolewooodt_widget_pickup_location option[value="<?php echo $ExplodePickupLocationAndKeyValue[1];?>"]').prop('disabled', 'disabled');
//alert();
});
</script>
<?php
}
else
{
}
}
}
?>
<br />
<?php 
if($byconsolewooodt_delivery_widget_cookie_array['byconsolewooodt_widget_type_field']=='levering')
{
$byconsolewooodt_location_date_placeholder=get_option('byconsolewooodt_chekout_page_delivery_date_placeholder');	
$byconsolewooodt_location_time_placeholder=get_option('byconsolewooodt_chekout_page_delivery_time_placeholder');
}
if($byconsolewooodt_delivery_widget_cookie_array['byconsolewooodt_widget_type_field']=='take_away')
{
$byconsolewooodt_location_date_placeholder=get_option('byconsolewooodt_chekout_page_date_placeholder');	
$byconsolewooodt_location_time_placeholder=get_option('byconsolewooodt_chekout_page_time_placeholder');
}
?>
<input type="text" name="byconsolewooodt_widget_date_field" class="byconsolewooodt_widget_date_field" readonly="readonly" placeholder="<?php echo $byconsolewooodt_location_date_placeholder; ?>" value="<?php echo $byconsolewooodt_delivery_date;?>" />
<?php
/*
$start_time=get_option('byconsolewooodt_opening_hours_from');
$closing_time=get_option('byconsolewooodt_opening_hours_to');
$current_time=current_time( 'H:i' );
if($current_time<$closing_time && $current_time>$start_time){
*/
echo '<br /><br />';
if(get_option('byconsolewooodt_as_early_as_possible_and_exact_time_text_lable_enable_mode') == 'yes') {
?>
<input type="radio" class="input-radio " value="exact_time" name="byconsolewooodt_delivery_type_of_widget_delivery_time" id="byconsolewooodt_delivery_type_of_widget_delivery_time_exact_time" <?php if($byconsolewooodt_delivery_time_type=='exact_time') {?>  checked="checked" <?php }?> style="float: left;margin-top: 10px;" >
<label for="byconsolewooodt_delivery_type_of_widget_delivery_time_exact_time" class="radio byconsolewooodt_delivery_type_of_widget_delivery_time_radio_box" style="float: left;margin-right: 8px;font-size: 12px; margin-top: 5px;font-weight: bold !important;"><?php echo get_option('byconsolewooodt_exact_time_lable_text');?></label>
<input type="radio" class="input-radio " value="as_early_as_possible" name="byconsolewooodt_delivery_type_of_widget_delivery_time" id="byconsolewooodt_delivery_type_of_widget_delivery_time_as_early_as_possible" <?php if($byconsolewooodt_delivery_time_type=='as_early_as_possible') {?>  checked="checked" <?php }?> style="float: left;margin-top: 10px;" >
<label for="byconsolewooodt_delivery_type_of_widget_delivery_time_as_early_as_possible" class="radio byconsolewooodt_delivery_type_of_widget_delivery_time_radio_box"  style="float: left;margin-right: 8px;font-size: 12px;margin-top: 5px;font-weight: bold !important;"><?php echo get_option('byconsolewooodt_as_early_as_possible_lable_text');?></label><br />
<input type="text" name="byconsolewooodt_widget_time_field" class="byconsolewooodt_widget_time_field" id="byconsolewooodt_widget_time_field"  placeholder="<?php echo $byconsolewooodt_location_time_placeholder; ?>" value="<?php echo $byconsolewooodt_delivery_time;?>" <?php if($byconsolewooodt_delivery_time_type=='as_early_as_possible') {?> style="display: none;" <?php }?>/>
<?php } 
if(get_option('byconsolewooodt_as_early_as_possible_and_exact_time_text_lable_enable_mode') == '') {?>
<input type="radio" class="input-radio " value="exact_time" name="byconsolewooodt_delivery_type_of_widget_delivery_time" id="byconsolewooodt_delivery_type_of_widget_delivery_time_exact_time" checked="checked" style="display:none;" >
<input type="text" name="byconsolewooodt_widget_time_field" class="byconsolewooodt_widget_time_field" id="byconsolewooodt_widget_time_field"  placeholder="<?php echo $byconsolewooodt_location_time_placeholder; ?>" value="<?php echo $byconsolewooodt_delivery_time;?>"/>
<?php }?>
<p class="byconsolewooodt_widget_time_field_service_closed_notice"></p>
<?php
/*
}else{
printf( __('We are closed now (%s), openning at %s','ByConsoleWooODTExtended'),$current_time,$start_time);
}
*/	
?>
<br />
<?php 
if($byconsolewooodt_delivery_widget_cookie_array['byconsolewooodt_widget_type_field']=='levering'){?>
<p class="min-shipping-time"><img src="<?php echo plugins_url('images/min-shipping-time.png', __FILE__)?>" alt="Minimum shipping time" /> &nbsp; <?php echo get_option('byconsolewooodt_delivery_times');?></p>
<?php }?>
<input type="submit" name="byconsolewooodt_widget_submit" value="Save" />
</form>
<?php  } 
if($isholiday === 'YES') 
{
echo '<div class="byconsole_closig_day"><p>'.get_option('byconsolewooodt_store_close_notice').'</p></div>';
}
if($isholiday != 'YES' && $isholiday != 'NO')
{
echo '<div class="byconsole_closig_day"><p>'._e('ERROR : Please contact Vendor').'</p></div>';
}
echo $args['after_widget'];
$current_active_year=date("Y");
// casual holidays
$deactive_casual_holiday_from_calender=get_option('byconsolewooodt_admin_holiday_date');
$deactive_casual_holiday_from_calender_array = explode(',', $deactive_casual_holiday_from_calender);
//national holidays
$deactive_casual_holiday_from_calender_for_national=get_option('byconsolewooodt_admin_national_holiday_date');
$deactive_casual_holiday_from_calender_for_national_array = explode(',', $deactive_casual_holiday_from_calender_for_national);
$national_holiday_string='';
foreach($deactive_casual_holiday_from_calender_for_national_array as $deactive_casual_holiday_from_calender_for_national_array_single)
{
//national holidays add year after date and month
$national_holiday_single_val = ''.trim($deactive_casual_holiday_from_calender_for_national_array_single.'/'.$current_active_year).',';
$national_holiday_string=$national_holiday_string.$national_holiday_single_val;
}
$national_holiday_string=substr($national_holiday_string,0,-1);
//national holidays explode
$national_holiday_string_explode_single_arry_val=explode(",",$national_holiday_string);
//casual and national holidays marge
$national_and_casual_holiday_marge = array_merge($national_holiday_string_explode_single_arry_val,$deactive_casual_holiday_from_calender_array);
// get allowabl pickup days
$byconsolewooodt_pickupdays_array=get_option('byconsolewooodt_pickup_days');
$string_for_pickupdays_js_array='';
$allowable_pickup_days_js_array='';
if(!empty($byconsolewooodt_pickupdays_array)){
foreach($byconsolewooodt_pickupdays_array as $allowable_pickupday){
/*if($currentlang == 'en_US')
{
if ($allowable_pickupday==1){
$calendar_day='Sun';	
}else if ($allowable_pickupday==2){	
$calendar_day='Mon';	
}else if ($allowable_pickupday==3){	
$calendar_day='Tue';	
}else if ($allowable_pickupday==4){	
$calendar_day='Wed';	
}else if ($allowable_pickupday==5){	
$calendar_day='Thu';	
}else if ($allowable_pickupday==6){	
$calendar_day='Fri';	
}else if ($allowable_pickupday==7){	
$calendar_day='Sat';	
}else {	
$calendar_day='';	
}
}*/
/*English*/
if($currentlang == 'en_US')
{
if ($allowable_pickupday==1){
$calendar_day='Sun';	
}else if ($allowable_pickupday==2){	
$calendar_day='Mon';	
}else if ($allowable_pickupday==3){	
$calendar_day='Tue';	
}else if ($allowable_pickupday==4){	
$calendar_day='Wed';	
}else if ($allowable_pickupday==5){	
$calendar_day='Thu';	
}else if ($allowable_pickupday==6){	
$calendar_day='Fri';	
}else if ($allowable_pickupday==7){	
$calendar_day='Sat';	
}else {	
$calendar_day='';	
}
}
/*deutsch(sie)*/
else if($currentlang == 'de_DE_formal' || $currentlang == 'de_DE')
{
if ($allowable_pickupday==1){	
$calendar_day='So';
}else if ($allowable_pickupday==2){
$calendar_day='Mo';
}else if ($allowable_pickupday==3){
$calendar_day='Di';
}else if ($allowable_pickupday==4){
$calendar_day='Mi';
}else if ($allowable_pickupday==5){
$calendar_day='Do';
}else if ($allowable_pickupday==6){
$calendar_day='Fr';
}else if ($allowable_pickupday==7){
$calendar_day='Sa';
}else {
$calendar_day='';
}
}
/*Español --  Spanish*/
/*else if($currentlang == 'es_ES')
{
if ($allowable_pickupday==1){	
$calendar_day='Dom';
}else if ($allowable_pickupday==2){
$calendar_day='Lun';
}else if ($allowable_pickupday==3){
$calendar_day='Mar';
}else if ($allowable_pickupday==4){
$calendar_day='Mié';
}else if ($allowable_pickupday==5){
$calendar_day='Jue';
}else if ($allowable_pickupday==6){
$calendar_day='Vie';
}else if ($allowable_pickupday==7){
$calendar_day='sáb';
}else {
$calendar_day='';
}
}
*/
/*deutsch(schweiz)*/
else if($currentlang =='de_CH')
{
if ($allowable_pickupday==1){	
$calendar_day='So';
}else if ($allowable_pickupday==2){
$calendar_day='Mo';
}else if ($allowable_pickupday==3){
$calendar_day='Di';
}else if ($allowable_pickupday==4){
$calendar_day='Mi';
}else if ($allowable_pickupday==5){
$calendar_day='Do';
}else if ($allowable_pickupday==6){
$calendar_day='Fr';
}else if ($allowable_pickupday==7){
$calendar_day='Sa';
}else {
$calendar_day='';
}
}
/*Danish*/
else if($currentlang == 'da_DK')
{
if ($allowable_pickupday==1){	
$calendar_day='søn';
}else if ($allowable_pickupday==2){
$calendar_day='man';
}else if ($allowable_pickupday==3){
$calendar_day='tirs';
}else if ($allowable_pickupday==4){
$calendar_day='ons';
}else if ($allowable_pickupday==5){
$calendar_day='tors';
}else if ($allowable_pickupday==6){
$calendar_day='fre';
}else if ($allowable_pickupday==7){
$calendar_day='lør';
}else {
$calendar_day='';
}
}
/*French*/
else if($currentlang == 'fr_FR')
{
if ($allowable_pickupday==1){	
$calendar_day='dim';
}else if ($allowable_pickupday==2){
$calendar_day='lun';
}else if ($allowable_pickupday==3){
$calendar_day='mar';
}else if ($allowable_pickupday==4){
$calendar_day='mer';
}else if ($allowable_pickupday==5){
$calendar_day='jeu';
}else if ($allowable_pickupday==6){
$calendar_day='ven';
}else if ($allowable_pickupday==7){
$calendar_day='sam';
}else {
$calendar_day='';
}
}
/*Italian*/
else if($currentlang == 'it_IT')
{
if ($allowable_pickupday==1){	
$calendar_day='dom';
}else if ($allowable_pickupday==2){
$calendar_day='lun';
}else if ($allowable_pickupday==3){
$calendar_day='mar';
}else if ($allowable_pickupday==4){
$calendar_day='mer';
}else if ($allowable_pickupday==5){
$calendar_day='gio';
}else if ($allowable_pickupday==6){
$calendar_day='ven';
}else if ($allowable_pickupday==7){
$calendar_day='sab';
}else {
$calendar_day='';
}
}
/*Croatian*/
else if($currentlang == 'hr')
{
if ($allowable_pickupday==1){	
$calendar_day='Ned';
}else if ($allowable_pickupday==2){
$calendar_day='Pon';
}else if ($allowable_pickupday==3){
$calendar_day='Uto';
}else if ($allowable_pickupday==4){
$calendar_day='Sri';
}else if ($allowable_pickupday==5){
$calendar_day='Čet';
}else if ($allowable_pickupday==6){
$calendar_day='Pet';
}else if ($allowable_pickupday==7){
$calendar_day='Sub';
}else {
$calendar_day='';
}
}
/*Romanian*/
else if($currentlang == 'ro_RO')
{
if ($allowable_pickupday==1){	
$calendar_day='Dum';
}else if ($allowable_pickupday==2){
$calendar_day='lun';
}else if ($allowable_pickupday==3){
$calendar_day='mar';
}else if ($allowable_pickupday==4){
$calendar_day='mie';
}else if ($allowable_pickupday==5){
$calendar_day='joi';
}else if ($allowable_pickupday==6){
$calendar_day='vin';
}else if ($allowable_pickupday==7){
$calendar_day='sâm';
}else {
$calendar_day='';
}
}
/*Bulgarian*/
else if($currentlang =='bg_BG')
{
if ($allowable_pickupday==1){	
$calendar_day='нд';
}else if ($allowable_pickupday==2){
$calendar_day='пн';
}else if ($allowable_pickupday==3){
$calendar_day='вт';
}else if ($allowable_pickupday==4){
$calendar_day='ср';
}else if ($allowable_pickupday==5){
$calendar_day='чт';
}else if ($allowable_pickupday==6){
$calendar_day='пт';
}else if ($allowable_pickupday==7){
$calendar_day='сб';
}else {
$calendar_day='';
}
}
/*Czech*/
else if($currentlang =='cs_CZ')
{
if ($allowable_pickupday==1){	
$calendar_day='Ne';
}else if ($allowable_pickupday==2){
$calendar_day='Po';
}else if ($allowable_pickupday==3){
$calendar_day='Út';
}else if ($allowable_pickupday==4){
$calendar_day='St';
}else if ($allowable_pickupday==5){
$calendar_day='Čt';
}else if ($allowable_pickupday==6){
$calendar_day='Pá';
}else if ($allowable_pickupday==7){
$calendar_day='So';
}else {
$calendar_day='';
}
}
/*Hungarian*/
else if($currentlang == 'hu_HU')
{
if ($allowable_pickupday==1){	
$calendar_day='vas';
}else if ($allowable_pickupday==2){
$calendar_day='hét';
}else if ($allowable_pickupday==3){
$calendar_day='ked';
}else if ($allowable_pickupday==4){
$calendar_day='sze';
}else if ($allowable_pickupday==5){
$calendar_day='csü';
}else if ($allowable_pickupday==6){
$calendar_day='pén';
}else if ($allowable_pickupday==7){
$calendar_day='szo';
}else {
$calendar_day='';
}
}
/*Dutch*/
else if($currentlang == 'nl_NL')
{
if ($allowable_pickupday==1){	
$calendar_day='zo';
}else if ($allowable_pickupday==2){
$calendar_day='ma';
}else if ($allowable_pickupday==3){
$calendar_day='di';
}else if ($allowable_pickupday==4){
$calendar_day='wo';
}else if ($allowable_pickupday==5){
$calendar_day='do';
}else if ($allowable_pickupday==6){
$calendar_day='vr';
}else if ($allowable_pickupday==7){
$calendar_day='za';
}else {
$calendar_day='';
}
}
/*Portuguese*/
else if($currentlang == 'pt_PT')
{
if ($allowable_pickupday==1){	
$calendar_day='Dom';
}else if ($allowable_pickupday==2){
$calendar_day='Seg';
}else if ($allowable_pickupday==3){
$calendar_day='Ter';
}else if ($allowable_pickupday==4){
$calendar_day='Qua';
}else if ($allowable_pickupday==5){
$calendar_day='Qui';
}else if ($allowable_pickupday==6){
$calendar_day='Sex';
}else if ($allowable_pickupday==7){
$calendar_day='Sáb';
}else {
$calendar_day='';
}
}
/*Slovak*/
else if($currentlang == 'sk_SK')
{
if ($allowable_pickupday==1){	
$calendar_day='Ne';
}else if ($allowable_pickupday==2){
$calendar_day='Po';
}else if ($allowable_pickupday==3){
$calendar_day='Ut';
}else if ($allowable_pickupday==4){
$calendar_day='St';
}else if ($allowable_pickupday==5){
$calendar_day='Št';
}else if ($allowable_pickupday==6){
$calendar_day='Pi';
}else if ($allowable_pickupday==7){
$calendar_day='So';
}else {
$calendar_day='';
}
}
/*Finnish*/
else if($currentlang == 'fi')
{
if ($allowable_pickupday==1){	
$calendar_day='su';
}else if ($allowable_pickupday==2){
$calendar_day='ma';
}else if ($allowable_pickupday==3){
$calendar_day='ti';
}else if ($allowable_pickupday==4){
$calendar_day='ke';
}else if ($allowable_pickupday==5){
$calendar_day='to';
}else if ($allowable_pickupday==6){
$calendar_day='pe';
}else if ($allowable_pickupday==7){
$calendar_day='la';
}else {
$calendar_day='';
}
}	
else
{
if ($allowable_pickupday==1){	
$calendar_day='Sun';
}else if ($allowable_pickupday==2){
$calendar_day='Mon';
}else if ($allowable_pickupday==3){
$calendar_day='Tue';
}else if ($allowable_pickupday==4){
$calendar_day='Wed';
}else if ($allowable_pickupday==5){
$calendar_day='Thu';
}else if ($allowable_pickupday==6){
$calendar_day='Fri';
}else if ($allowable_pickupday==7){
$calendar_day='Sat';
}else {
$calendar_day='';
}
}
$string_for_pickupdays_js_array=$string_for_pickupdays_js_array.'"'.$calendar_day.'",';
}
$allowable_pickup_days_js_array='['.trim($string_for_pickupdays_js_array).']';
}
// get allowable delivery days
$byconsolewooodt_deliverydays_array=get_option('byconsolewooodt_delivery_days');
$string_for_deliverydays_js_array='';
$allowable_delivery_days_js_array='';
if(!empty($byconsolewooodt_deliverydays_array)){
foreach($byconsolewooodt_deliverydays_array as $allowable_deliveryday){
/*if($currentlang == 'en_US')
{
if ($allowable_deliveryday==1){
$calendar_day='Sun';
}else if ($allowable_deliveryday==2){
$calendar_day='Mon';
}else if ($allowable_deliveryday==3){
$calendar_day='Tue';
}else if ($allowable_deliveryday==4){
$calendar_day='Wed';
}else if ($allowable_deliveryday==5){
$calendar_day='Thu';
}else if ($allowable_deliveryday==6){
$calendar_day='Fri';
}else if ($allowable_deliveryday==7){
$calendar_day='Sat';
}else {
$calendar_day='';
}
}*/
/*English*/
if($currentlang == 'en_US')
{
if ($allowable_deliveryday==1){
$calendar_day='Sun';	
}else if ($allowable_deliveryday==2){	
$calendar_day='Mon';	
}else if ($allowable_deliveryday==3){	
$calendar_day='Tue';	
}else if ($allowable_deliveryday==4){	
$calendar_day='Wed';	
}else if ($allowable_deliveryday==5){	
$calendar_day='Thu';	
}else if ($allowable_deliveryday==6){	
$calendar_day='Fri';	
}else if ($allowable_deliveryday==7){	
$calendar_day='Sat';	
}else {	
$calendar_day='';	
}
}
/*deutsch(sie)*/
else if($currentlang == 'de_DE_formal' || $currentlang == 'de_DE')
{
if ($allowable_deliveryday==1){	
$calendar_day='So';
}else if ($allowable_deliveryday==2){
$calendar_day='Mo';
}else if ($allowable_deliveryday==3){
$calendar_day='Di';
}else if ($allowable_deliveryday==4){
$calendar_day='Mi';
}else if ($allowable_deliveryday==5){
$calendar_day='Do';
}else if ($allowable_deliveryday==6){
$calendar_day='Fr';
}else if ($allowable_deliveryday==7){
$calendar_day='Sa';
}else {
$calendar_day='';
}
}
/*Español --  Spanish*/
/*else if($currentlang == 'es_ES')
{
if ($allowable_deliveryday==1){	
$calendar_day='Dom';
}else if ($allowable_deliveryday==2){
$calendar_day='Lun';
}else if ($allowable_deliveryday==3){
$calendar_day='Mar';
}else if ($allowable_deliveryday==4){
$calendar_day='Mié';
}else if ($allowable_deliveryday==5){
$calendar_day='Jue';
}else if ($allowable_deliveryday==6){
$calendar_day='Vie';
}else if ($allowable_deliveryday==7){
$calendar_day='sáb';
}else {
$calendar_day='';
}
}*/
/*deutsch(schweiz)*/
else if($currentlang =='de_CH')
{
if ($allowable_deliveryday==1){	
$calendar_day='So';
}else if ($allowable_deliveryday==2){
$calendar_day='Mo';
}else if ($allowable_deliveryday==3){
$calendar_day='Di';
}else if ($allowable_deliveryday==4){
$calendar_day='Mi';
}else if ($allowable_deliveryday==5){
$calendar_day='Do';
}else if ($allowable_deliveryday==6){
$calendar_day='Fr';
}else if ($allowable_deliveryday==7){
$calendar_day='Sa';
}else {
$calendar_day='';
}
}
/*Danish*/
else if($currentlang == 'da_DK')
{
if ($allowable_pickupday==1){	
$calendar_day='søn';
}else if ($allowable_pickupday==2){
$calendar_day='man';
}else if ($allowable_pickupday==3){
$calendar_day='tirs';
}else if ($allowable_pickupday==4){
$calendar_day='ons';
}else if ($allowable_pickupday==5){
$calendar_day='tors';
}else if ($allowable_pickupday==6){
$calendar_day='fre';
}else if ($allowable_pickupday==7){
$calendar_day='lør';
}else {
$calendar_day='';
}
}
/*French*/
else if($currentlang == 'fr_FR')
{
if ($allowable_deliveryday==1){	
$calendar_day='dim';
}else if ($allowable_deliveryday==2){
$calendar_day='lun';
}else if ($allowable_deliveryday==3){
$calendar_day='mar';
}else if ($allowable_deliveryday==4){
$calendar_day='mer';
}else if ($allowable_deliveryday==5){
$calendar_day='jeu';
}else if ($allowable_deliveryday==6){
$calendar_day='ven';
}else if ($allowable_deliveryday==7){
$calendar_day='sam';
}else {
$calendar_day='';
}
}
/*Italian*/
else if($currentlang == 'it_IT')
{
if ($allowable_deliveryday==1){	
$calendar_day='dom';
}else if ($allowable_deliveryday==2){
$calendar_day='lun';
}else if ($allowable_deliveryday==3){
$calendar_day='mar';
}else if ($allowable_deliveryday==4){
$calendar_day='mer';
}else if ($allowable_deliveryday==5){
$calendar_day='gio';
}else if ($allowable_deliveryday==6){
$calendar_day='ven';
}else if ($allowable_deliveryday==7){
$calendar_day='sab';
}else {
$calendar_day='';
}
}
/*Croatian*/
else if($currentlang == 'hr')
{
if ($allowable_deliveryday==1){	
$calendar_day='Ned';
}else if ($allowable_deliveryday==2){
$calendar_day='Pon';
}else if ($allowable_deliveryday==3){
$calendar_day='Uto';
}else if ($allowable_deliveryday==4){
$calendar_day='Sri';
}else if ($allowable_deliveryday==5){
$calendar_day='Čet';
}else if ($allowable_deliveryday==6){
$calendar_day='Pet';
}else if ($allowable_deliveryday==7){
$calendar_day='Sub';
}else {
$calendar_day='';
}
}
/*Romanian*/
else if($currentlang == 'ro_RO')
{
if ($allowable_deliveryday==1){	
$calendar_day='Dum';
}else if ($allowable_deliveryday==2){
$calendar_day='lun';
}else if ($allowable_deliveryday==3){
$calendar_day='mar';
}else if ($allowable_deliveryday==4){
$calendar_day='mie';
}else if ($allowable_deliveryday==5){
$calendar_day='joi';
}else if ($allowable_deliveryday==6){
$calendar_day='vin';
}else if ($allowable_deliveryday==7){
$calendar_day='sâm';
}else {
$calendar_day='';
}
}
/*Bulgarian*/
else if($currentlang =='bg_BG')
{
if ($allowable_deliveryday==1){	
$calendar_day='нд';
}else if ($allowable_deliveryday==2){
$calendar_day='пн';
}else if ($allowable_deliveryday==3){
$calendar_day='вт';
}else if ($allowable_deliveryday==4){
$calendar_day='ср';
}else if ($allowable_deliveryday==5){
$calendar_day='чт';
}else if ($allowable_deliveryday==6){
$calendar_day='пт';
}else if ($allowable_deliveryday==7){
$calendar_day='сб';
}else {
$calendar_day='';
}
}
/*Czech*/
else if($currentlang =='cs_CZ')
{
if ($allowable_deliveryday==1){	
$calendar_day='Ne';
}else if ($allowable_deliveryday==2){
$calendar_day='Po';
}else if ($allowable_deliveryday==3){
$calendar_day='Út';
}else if ($allowable_deliveryday==4){
$calendar_day='St';
}else if ($allowable_deliveryday==5){
$calendar_day='Čt';
}else if ($allowable_deliveryday==6){
$calendar_day='Pá';
}else if ($allowable_deliveryday==7){
$calendar_day='So';
}else {
$calendar_day='';
}
}
/*Hungarian*/
else if($currentlang == 'hu_HU')
{
if ($allowable_deliveryday==1){	
$calendar_day='vas';
}else if ($allowable_deliveryday==2){
$calendar_day='hét';
}else if ($allowable_deliveryday==3){
$calendar_day='ked';
}else if ($allowable_deliveryday==4){
$calendar_day='sze';
}else if ($allowable_deliveryday==5){
$calendar_day='csü';
}else if ($allowable_deliveryday==6){
$calendar_day='pén';
}else if ($allowable_deliveryday==7){
$calendar_day='szo';
}else {
$calendar_day='';
}
}
/*Dutch*/
else if($currentlang == 'nl_NL')
{
if ($allowable_deliveryday==1){	
$calendar_day='zo';
}else if ($allowable_deliveryday==2){
$calendar_day='ma';
}else if ($allowable_deliveryday==3){
$calendar_day='di';
}else if ($allowable_deliveryday==4){
$calendar_day='wo';
}else if ($allowable_deliveryday==5){
$calendar_day='do';
}else if ($allowable_deliveryday==6){
$calendar_day='vr';
}else if ($allowable_deliveryday==7){
$calendar_day='za';
}else {
$calendar_day='';
}
}
/*Portuguese*/
else if($currentlang == 'pt_PT')
{
if ($allowable_deliveryday==1){	
$calendar_day='Dom';
}else if ($allowable_deliveryday==2){
$calendar_day='Seg';
}else if ($allowable_deliveryday==3){
$calendar_day='Ter';
}else if ($allowable_deliveryday==4){
$calendar_day='Qua';
}else if ($allowable_deliveryday==5){
$calendar_day='Qui';
}else if ($allowable_deliveryday==6){
$calendar_day='Sex';
}else if ($allowable_deliveryday==7){
$calendar_day='Sáb';
}else {
$calendar_day='';
}
}
/*Slovak*/
else if($currentlang == 'sk_SK')
{
if ($allowable_deliveryday==1){	
$calendar_day='Ne';
}else if ($allowable_deliveryday==2){
$calendar_day='Po';
}else if ($allowable_deliveryday==3){
$calendar_day='Ut';
}else if ($allowable_deliveryday==4){
$calendar_day='St';
}else if ($allowable_deliveryday==5){
$calendar_day='Št';
}else if ($allowable_deliveryday==6){
$calendar_day='Pi';
}else if ($allowable_deliveryday==7){
$calendar_day='So';
}else {
$calendar_day='';
}
}
/*Finnish*/
else if($currentlang == 'fi')
{
if ($allowable_deliveryday==1){	
$calendar_day='su';
}else if ($allowable_deliveryday==2){
$calendar_day='ma';
}else if ($allowable_deliveryday==3){
$calendar_day='ti';
}else if ($allowable_deliveryday==4){
$calendar_day='ke';
}else if ($allowable_deliveryday==5){
$calendar_day='to';
}else if ($allowable_deliveryday==6){
$calendar_day='pe';
}else if ($allowable_deliveryday==7){
$calendar_day='la';
}else {
$calendar_day='';
}
}	
else
{
if ($allowable_deliveryday==1){	
$calendar_day='Sun';
}else if ($allowable_deliveryday==2){
$calendar_day='Mon';
}else if ($allowable_deliveryday==3){
$calendar_day='Tue';
}else if ($allowable_deliveryday==4){
$calendar_day='Wed';
}else if ($allowable_deliveryday==5){
$calendar_day='Thu';
}else if ($allowable_deliveryday==6){
$calendar_day='Fri';
}else if ($allowable_deliveryday==7){
$calendar_day='Sat';
}else {
$calendar_day='';
}
}
$string_for_deliverydays_js_array=$string_for_deliverydays_js_array.'"'.$calendar_day.'",';
}
$allowable_delivery_days_js_array='['.trim($string_for_deliverydays_js_array).']';
}
//pre-order settings
////************************ datepicker script was here, now moved to footer *****************************************************/
} // end of function widget
public function form( $instance ) {
if ( isset( $instance[ 'byconsolewooodt_widget_title' ] ) ) {
$title = $instance[ 'byconsolewooodt_widget_title' ];
}else{
$title = __( 'New title', 'ByConsoleWooODTExtended' );
}
// Widget admin form
?>
<p>
<label for="<?php echo $this->get_field_id( 'byconsolewooodt_widget_title' ); ?>"><?php __( 'Title:','ByConsoleWooODTExtended' ); ?></label> 
<input class="widefat" id="<?php echo $this->get_field_id( 'byconsolewooodt_widget_title' ); ?>" name="<?php echo $this->get_field_name( 'byconsolewooodt_widget_title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
</p>
<?php 
}
// Updating widget replacing old instances with new
public function update( $new_instance, $old_instance ) {
$instance = array();
$instance['byconsolewooodt_widget_title'] = ( ! empty( $new_instance['byconsolewooodt_widget_title'] ) ) ? strip_tags( $new_instance['byconsolewooodt_widget_title'] ) : '';
return $instance;
}
/*****************************************************/
} // Class byconsolewooodt_widget ends here
// Register and load the widget
function byconsolewooodt_load_widget() {
register_widget( 'byconsolewooodt_widget' );
}
add_action( 'widgets_init', 'byconsolewooodt_load_widget' );//save frontend widget data in cookie, so we need to do it before any output, hence hook it on init
function byconsolewooodt_savefrontend_widget_data(){
// save thwe widget data in in cookie	
$byconsolewooodt_multiple_pickup_location=get_option('byconsolewooodt_multiple_pickup_location');
$byconsolewooodt_multiple_delivery_location=get_option('byconsolewooodt_multiple_delivery_location');
if(isset($_POST['byconsolewooodt_widget_submit'])){
$byconsolewooodt_widget_date_field_post_data   = $_POST['byconsolewooodt_widget_date_field'];
$byconsolewooodt_widget_time_field_post_data   = $_POST['byconsolewooodt_widget_time_field'];
$byconsolewooodt_widget_time_type_field_post_data   = $_POST['byconsolewooodt_delivery_type_of_widget_delivery_time'];
$byconsolewooodt_widget_type_field_post_data   = $_POST['byconsolewooodt_widget_type_field'];
if($byconsolewooodt_multiple_pickup_location=='YES' && $_POST['byconsolewooodt_widget_type_field']=='take_away'){
$byconsolewooodt_widget_pickup_location_post_data = $_POST['byconsolewooodt_widget_pickup_location'];	
}else{
$byconsolewooodt_widget_pickup_location_post_data='';
}
if($byconsolewooodt_multiple_delivery_location=='YES' && $_POST['byconsolewooodt_widget_type_field']=='levering'){
$byconsolewooodt_widget_delivery_location_post_data = $_POST['byconsolewooodt_widget_delivery_location'];
}else{
$byconsolewooodt_widget_delivery_location_post_data='';
}
$byconsolewooodt_delivery_widget_post_array = array(
'byconsolewooodt_widget_date_field'   => $byconsolewooodt_widget_date_field_post_data,
'byconsolewooodt_widget_time_field'   => $byconsolewooodt_widget_time_field_post_data,
'byconsolewooodt_widget_time_type_field'   => $byconsolewooodt_widget_time_type_field_post_data,
'byconsolewooodt_widget_type_field'   => $byconsolewooodt_widget_type_field_post_data,
'byconsolewooodt_widget_pickup_location' => $byconsolewooodt_widget_pickup_location_post_data,
'byconsolewooodt_widget_delivery_location' => $byconsolewooodt_widget_delivery_location_post_data
);
//print_r($byconsolewooodt_delivery_widget_post_array);
//set cookie
$json_byconsolewooodt_delivery_widget_post_array=json_encode($byconsolewooodt_delivery_widget_post_array);
setcookie('byconsolewooodt_delivery_widget_cookie',$json_byconsolewooodt_delivery_widget_post_array , time() + 60 * 60 * 24 * 1, '/');
$_COOKIE['byconsolewooodt_delivery_widget_cookie'] = $json_byconsolewooodt_delivery_widget_post_array;// for immediate access in widget
}
}// end of byconsolewooodt_savefrontend_widget_data
add_action('init','byconsolewooodt_savefrontend_widget_data');// Add the field to the checkout
/*function byconsolewooodt_get_cart_full_price_value() {
global $woocommerce;
echo $amount = $woocommerce->cart->cart_contents_total+$woocommerce->cart->tax_total;
}
add_action('init','byconsolewooodt_get_cart_full_price_value');// get cart full price value*/
add_action( 'woocommerce_after_order_notes', 'byconsolewooodt_checkout_field' );
function byconsolewooodt_checkout_field( $checkout ) {
global $woocommerce;// get cookie as array
$stripped_out_byconsolewooodt_delivery_widget_cookie=stripslashes($_COOKIE['byconsolewooodt_delivery_widget_cookie']);
$byconsolewooodt_delivery_widget_cookie_array=json_decode($stripped_out_byconsolewooodt_delivery_widget_cookie,true);
//get pickup and delivery location
$pickup_loactions_array= get_option('byconsolewooodt_pickup_location');
$delivery_loactions_array= get_option('byconsolewooodt_delivery_location');	
// Shop Closed By Date And Day
$isholiday = 'NO';
$todaydate = date("m/d/Y");
$todaydate_dm = date("m/d");
$shownotice='none';
$get_all_dates = get_option('byconsolewooodt_admin_holiday_date');
$dateexplode=explode(",",$get_all_dates);	
//Chaking if today is casual holiday
if(in_array($todaydate , $dateexplode))
{			
$isholiday = 'YES';			
}
// get todays date 
$gattodayname=date("l");
$gattodaynumericval=date("w");				
$sunday = get_option('byconsolewooodt_admin_closing_sunday');
$monday = get_option('byconsolewooodt_admin_closing_monday');
$tuesday = get_option('byconsolewooodt_admin_closing_tuesday');
$wednessday = get_option('byconsolewooodt_admin_closing_wednessday');
$thursday = get_option('byconsolewooodt_admin_closing_thursday');
$friday = get_option('byconsolewooodt_admin_closing_friday');
$saturday = get_option('byconsolewooodt_admin_closing_saturday');
$sunday = ($sunday=='') ? 99 : 0;
$monday = ! empty($monday) ? $monday : 99;
$tuesday = ! empty($tuesday) ? $tuesday : 99;
$wednessday = ! empty($wednessday) ? $wednessday : 99;
$thursday = ! empty($thursday) ? $thursday : 99;
$friday = ! empty($friday) ? $friday : 99;
$saturday = ! empty($saturday) ? $saturday : 99;
// check if shop is closed today
if($sunday==$gattodaynumericval || $monday==$gattodaynumericval || $tuesday==$gattodaynumericval || $wednessday==$gattodaynumericval || $thursday==$gattodaynumericval || $friday==$gattodaynumericval || $saturday==$gattodaynumericval)
{
$isholiday = 'YES';
}
$get_all_national_holidays_dates = get_option('byconsolewooodt_admin_national_holiday_date');
$national_holidays_array=explode(",",$get_all_national_holidays_dates);
// chaking if it is national holiday
if(in_array($todaydate_dm , $national_holidays_array))
{			
$isholiday = 'YES';			
}
if($isholiday === 'NO')
{
echo '<div id="byconsolewooodt_checkout_field"><h2>'.get_option('byconsolewooodt_chekout_page_section_heading') . '</h2>';
// show order type as per settings page
//if both
if(get_option('byconsolewooodt_order_type')=='both'){
$byconsolewooodt_order_type_checkout_array=array(
'type'          => 'radio',
'class'         => array('byconsolewooodt_delivery_type'),
'label'         => get_option('byconsolewooodt_chekout_page_order_type_lebel'),
'placeholder'   => __('Select delivery type','ByConsoleWooODTExtended'),
'default'		=> $byconsolewooodt_delivery_widget_cookie_array['byconsolewooodt_widget_type_field'],'checked'		=> 'checked',
'options'		=> array(
'take_away' => get_option('byconsolewooodt_pickup_lable'), 
'levering' => get_option('byconsolewooodt_delivery_lable'), 
),
);
}
//if only pickup
if(get_option('byconsolewooodt_order_type')=='take_away'){
$byconsolewooodt_order_type_checkout_array=array(
'type'          => 'radio',
'class'         => array('byconsolewooodt_delivery_type'),
'label'         => get_option('byconsolewooodt_chekout_page_order_type_lebel'),
'placeholder'   => __('Select delivery type','ByConsoleWooODTExtended'),
'default'		=> 'take_away',
'checked'		=> 'checked',
'options'		=> array(
'take_away' => get_option('byconsolewooodt_pickup_lable'), 
),
);
}
//if only delivery
if(get_option('byconsolewooodt_order_type')=='levering'){
$byconsolewooodt_order_type_checkout_array=array(
'type'          => 'radio',
'class'         => array('byconsolewooodt_delivery_type'),
'label'         => get_option('byconsolewooodt_chekout_page_order_type_lebel'),
'placeholder'   => __('Select delivery type','ByConsoleWooODTExtended'),
'default'		=> 'levering',
'checked'		=> 'checked',
'options'		=> array(
'levering' => get_option('byconsolewooodt_delivery_lable'), 
),
);
}
woocommerce_form_field( 'byconsolewooodt_delivery_type', $byconsolewooodt_order_type_checkout_array, $checkout->get_value( 'byconsolewooodt_delivery_type' ));
// populate the pickup location drop-down only if delivery type is take_away and pickup location list is not empty
$byconsolewooodt_multiple_pickup_location=get_option('byconsolewooodt_multiple_pickup_location');
if($byconsolewooodt_delivery_widget_cookie_array['byconsolewooodt_widget_type_field']=='take_away' && !empty($pickup_loactions_array) && $byconsolewooodt_multiple_pickup_location=='YES'){		
//create array for our woocommerce select type form field function
//$pickup_loactions_array=get_option('byconsolewooodt_pickup_location');
//lets use value onstead od array index in option value
echo '<div class="byconsole_location_name">'.get_option('byconsolewooodt_pickup_location_lebel').'</div>';
//$TotalCartAmountValue = $woocommerce->cart->get_cart_total(); // This is with currency symbol
$TotalCartAmountValue = $woocommerce->cart->total; // This is without currency symbol
//print_r($pickup_loactions_array);
$pickup_loaction_array_value=array();
foreach($pickup_loactions_array as $pickup_loaction_key => $pickup_loaction_value)
{
$PickupLocationArray[] = $pickup_loaction_value['min_cart_value'] .'/'.$pickup_loaction_key;
if(empty($pickup_loaction_value['min_cart_value']) || $pickup_loaction_value['min_cart_value']=='' || $pickup_loaction_value['min_cart_value']==0 ){
$minimum_order_value=__('No bar','ByConsoleWooODTExtended');
}else{
$minimum_order_value=get_woocommerce_currency_symbol() .$pickup_loaction_value['min_cart_value'];
}
$pickup_loaction_option_text_value=$pickup_loaction_value['location'].'&nbsp;&nbsp;-- &nbsp;&nbsp;Time &nbsp;( '. $pickup_loaction_value['start_time'] .'-'.$pickup_loaction_value['end_time'].' )&nbsp;&nbsp;-- &nbsp;&nbsp; Min. Order:&nbsp;('.$minimum_order_value.')';
if($pickup_loaction_value['location_disable']!='on')
{	
array_push($pickup_loaction_array_value[$pickup_loaction_key] = $pickup_loaction_option_text_value);
}
}
$pickup_loaction_combined_array=array_combine($pickup_loactions_array,$pickup_loactions_array);
woocommerce_form_field( 'byconsolewooodt_pickup_location', array(
'type'          => 'select',
'class'         => array('byconsolewooodt_pickup_location'),
'label'         => get_option('byconsolewooodt_chekout_page_pickup_location_lebel'),
'placeholder'   => __('Choose pickup location','ByConsoleWooODTExtended'),
'default'		=> $byconsolewooodt_delivery_widget_cookie_array['byconsolewooodt_widget_pickup_location'],
'options'		=> $pickup_loaction_array_value,
), $checkout->get_value( 'byconsolewooodt_pickup_location' ));
}// end of if take_away
// populate the delivery location drop-down only if delivery type is levering and delivery location list is not empty
$byconsolewooodt_multiple_delivery_location=get_option('byconsolewooodt_multiple_delivery_location');
if($byconsolewooodt_delivery_widget_cookie_array['byconsolewooodt_widget_type_field']=='levering' && !empty($delivery_loactions_array) && $byconsolewooodt_multiple_delivery_location=='YES'){	
//create array for our woocommerce select type form field function
//$pickup_loactions_array=get_option('byconsolewooodt_pickup_location');
//lets use value onstead od array index in option value
echo '<div class="byconsole_location_name">'.get_option('byconsolewooodt_delivery_location_lebel').'</div>';
$TotalCartAmountValue = $woocommerce->cart->total; // This is without currency symbol
$delivery_loaction_array_value=array();	
foreach($delivery_loactions_array as $delivery_loaction_key => $delivery_loaction_value)
{
$DeliveryLocationArray[] = $delivery_loaction_value['min_cart_value'] .'/'.$delivery_loaction_key;
if(empty($delivery_loaction_value['min_cart_value'])|| $delivery_loaction_value['min_cart_value']=='' || $delivery_loaction_value['min_cart_value']==0){
$minimum_order_value=__('No bar', 'ByConsoleWooODTExtended');
}else{
$minimum_order_value=get_woocommerce_currency_symbol() .$delivery_loaction_value['min_cart_value'];
}
$Delivery_Location_With_Mincartvalue_Location_key_Start_time_End_time_Array[] = $delivery_loaction_value['min_cart_value'] .'<@@>'.$delivery_loaction_key .'<@@>'. $delivery_loaction_value['start_time'].'<@@>'. $delivery_loaction_value['end_time'];
$delivery_loaction_option_text_value=$delivery_loaction_value['location'].'&nbsp;&nbsp;-- &nbsp;&nbsp;Time &nbsp;( '. $delivery_loaction_value['start_time'] .'-'.$delivery_loaction_value['end_time'].' )&nbsp;&nbsp;-- &nbsp;&nbsp; Min. Order:&nbsp;('.$minimum_order_value.')';
if($delivery_loaction_value['location_disable']!='on')
{
array_push($delivery_loaction_array_value[$delivery_loaction_key] = $delivery_loaction_option_text_value);
}
}
$delivery_loaction_combined_array=array_combine($delivery_loactions_array,$delivery_loactions_array);
woocommerce_form_field( 'byconsolewooodt_delivery_location', array(
'type'          => 'select',
'class'         => array('byconsolewooodt_delivery_location'),
'label'         => get_option('byconsolewooodt_chekout_page_delivery_location_lebel'),
'placeholder'   => __('Choose delivery location','ByConsoleWooODTExtended'),
'default'		=> $byconsolewooodt_delivery_widget_cookie_array['byconsolewooodt_widget_delivery_location'],
'options'		=> $delivery_loaction_array_value,
), $checkout->get_value( 'byconsolewooodt_delivery_location' ));
}// end of if delivery
if($byconsolewooodt_delivery_widget_cookie_array['byconsolewooodt_widget_type_field']=='levering')
{
$byconsolewooodt_location_date_placeholder=get_option('byconsolewooodt_chekout_page_delivery_date_placeholder');	
$byconsolewooodt_location_time_placeholder=get_option('byconsolewooodt_chekout_page_delivery_time_placeholder');
}
if($byconsolewooodt_delivery_widget_cookie_array['byconsolewooodt_widget_type_field']=='take_away')
{
$byconsolewooodt_location_date_placeholder=get_option('byconsolewooodt_chekout_page_date_placeholder');	
$byconsolewooodt_location_time_placeholder=get_option('byconsolewooodt_chekout_page_time_placeholder');
}
woocommerce_form_field( 'byconsolewooodt_delivery_date', array(
'type'          => 'text',
'class'         => array('byconsolewooodt_delivery_date'),
'label'         => get_option('byconsolewooodt_chekout_page_date_lebel'),
'placeholder'   => $byconsolewooodt_location_date_placeholder,
'default'		=> $byconsolewooodt_delivery_widget_cookie_array['byconsolewooodt_widget_date_field'],
), $checkout->get_value( 'byconsolewooodt_delivery_date' ));
$start_time=get_option('byconsolewooodt_opening_hours_from');
$closing_time=get_option('byconsolewooodt_opening_hours_to');
//$current_time=date('H:i', time());
if(get_option('byconsolewooodt_as_early_as_possible_and_exact_time_text_lable_enable_mode') == 'yes') {
woocommerce_form_field("byconsolewooodt_delivery_type_of_delivery_time", array(
'type'              => 'radio',
'class'             => array('byconsolewooodt_delivery_type_of_delivery_time'),
'label'             => '',
'label_class'       => 'byconsolewooodt_delivery_type_of_delivery_time_radio_box',
'options'           => array( 'exact_time' => get_option('byconsolewooodt_exact_time_lable_text') , 'as_early_as_possible' => get_option("byconsolewooodt_as_early_as_possible_lable_text")),
), $checkout->get_value( 'byconsolewooodt_delivery_type_of_delivery_time' ) );
}
if(get_option('byconsolewooodt_as_early_as_possible_and_exact_time_text_lable_enable_mode') == '') {
woocommerce_form_field("byconsolewooodt_delivery_type_of_delivery_time_hidden", array(
'type'              => 'radio',
'class'             => array('byconsolewooodt_delivery_type_of_delivery_time_hidden'),
'label'             => '',
'label_class'       => 'byconsolewooodt_delivery_type_of_delivery_time_radio_box_hidden',
'options'           => array( 'exact_time' => get_option('byconsolewooodt_exact_time_lable_text')),
), $checkout->get_value( 'byconsolewooodt_delivery_type_of_delivery_time_hidden' ) );
}
$current_time=current_time( 'H:m' );
//if($current_time<$closing_time && $current_time>$start_time){
woocommerce_form_field( 'byconsolewooodt_delivery_time', array(
'type'          => 'text',
'class'         => array('byconsolewooodt_delivery_time'),
'label'         => get_option('byconsolewooodt_chekout_page_time_lebel'),
'placeholder'   => $byconsolewooodt_location_time_placeholder,
'default'		=> $byconsolewooodt_delivery_widget_cookie_array['byconsolewooodt_widget_time_field'],
), $checkout->get_value( 'byconsolewooodt_delivery_time' ));
/*}else{
echo '<b>';
printf( __('We are closed now (%s), openning at %s','ByConsoleWooODTExtended'),$current_time,$start_time);
echo '</b>';
}
*/
echo '</div>';
} 
if($isholiday === 'YES') 
{
echo '<div class="byconsole_closig_day"><p>'.get_option('byconsolewooodt_store_close_notice').'</p></div>';
}
if($isholiday != 'YES' && $isholiday != 'NO')
{
echo '<div class="byconsole_closig_day"><p>'._e('ERROR : Please contact Vendor').'</p></div>';
}
/**** FOR DISABLED OPTION SCRIPT****/
if(!empty($PickupLocationArray)){
foreach($PickupLocationArray as $PickupLocationSingleArrayVal)
{
$ExplodePickupLocationAndKeyValue=explode("/" ,$PickupLocationSingleArrayVal);
// || $ExplodePickupLocationAndKeyValue[0]=='' || $ExplodePickupLocationAndKeyValue[0]=='0'
if($TotalCartAmountValue < $ExplodePickupLocationAndKeyValue[0] && ($ExplodePickupLocationAndKeyValue[0]!=0 || !empty($ExplodePickupLocationAndKeyValue[0])) )
{
//echo $xyz[1];
//disable selection of below min. order options
?> 
<script>
jQuery(document).ready(function(){
jQuery('#byconsolewooodt_pickup_location option[value="<?php echo $ExplodePickupLocationAndKeyValue[1];?>"]').prop('disabled', 'disabled');
//alert();
});
</script>
<?php
}
else
{
}
}
}
//print_r($DeliveryLocationArray);
if(!empty($DeliveryLocationArray)){
foreach($DeliveryLocationArray as $DeliveryLocationSingleArrayVal)
{
$ExplodeDeliveryLocationAndKeyValue=explode("/" ,$DeliveryLocationSingleArrayVal);
// || $ExplodeDeliveryLocationAndKeyValue[0]=='' || $ExplodeDeliveryLocationAndKeyValue[0]=='0'
if($TotalCartAmountValue < $ExplodeDeliveryLocationAndKeyValue[0] && ($ExplodeDeliveryLocationAndKeyValue[0]!=0 || !empty($ExplodeDeliveryLocationAndKeyValue[0])) )
{
//echo $xyz[1];
//disable selection of below min. order options
?> 
<script>
jQuery(document).ready(function(){
jQuery('#byconsolewooodt_delivery_location option[value="<?php echo $ExplodeDeliveryLocationAndKeyValue[1];?>"]').prop('disabled', 'disabled');
//alert();
});
</script>
<?php
}
else
{
}
}
}
/**************************************/
//print_r($Delivery_Location_With_Mincartvalue_Location_key_Start_time_End_time_Array);
$todaysCurrentDate=date("m/d/Y");
if(!empty($Delivery_Location_With_Mincartvalue_Location_key_Start_time_End_time_Array)){
foreach($Delivery_Location_With_Mincartvalue_Location_key_Start_time_End_time_Array as $Delivery_Location_With_Mincartvalue_Location_key_Start_time_End_time_SingleArrayVal)
{
$ExplodeDelivery_Location_With_Mincartvalue_Location_key_Start_time_End_time_AndKeyValue=explode("<@@>" , $Delivery_Location_With_Mincartvalue_Location_key_Start_time_End_time_SingleArrayVal);
//print_r($ExplodeDelivery_Location_With_Mincartvalue_Location_key_Start_time_End_time_AndKeyValue);
//echo $ExplodeDelivery_Location_With_Mincartvalue_Location_key_Start_time_End_time_AndKeyValue['2'];
// || $ExplodeDeliveryLocationAndKeyValue[0]=='' || $ExplodeDeliveryLocationAndKeyValue[0]=='0'
if($TotalCartAmountValue < $ExplodeDelivery_Location_With_Mincartvalue_Location_key_Start_time_End_time_AndKeyValue[0] && ($ExplodeDelivery_Location_With_Mincartvalue_Location_key_Start_time_End_time_AndKeyValue[0]!=0 || !empty($ExplodeDelivery_Location_With_Mincartvalue_Location_key_Start_time_End_time_AndKeyValue[0])) )
{
//disable selection of below min. order options
?> 
<script>
jQuery(document).ready(function(){
jQuery("#byconsolewooodt_delivery_time").change(function(){
//alert(<?php echo $ExplodeDelivery_Location_With_Mincartvalue_Location_key_Start_time_End_time_AndKeyValue[1];?>);
var byconsolewooodt_delivery_date_val = jQuery("#byconsolewooodt_delivery_date").val();
var byconsolewooodt_delivery_time_val = jQuery("#byconsolewooodt_delivery_time").val();
//alert(byconsolewooodt_delivery_date_val);
//alert(byconsolewooodt_delivery_time_val);
if(byconsolewooodt_delivery_date_val >= '<?php echo $todaysCurrentDate; ?>' && 
byconsolewooodt_delivery_time_val > '<?php echo $ExplodeDelivery_Location_With_Mincartvalue_Location_key_Start_time_End_time_AndKeyValue['2'];?>'&& 				byconsolewooodt_delivery_time_val < '<?php echo $ExplodeDelivery_Location_With_Mincartvalue_Location_key_Start_time_End_time_AndKeyValue['3'];?>')
{
//alert('<?php //echo $ExplodeDelivery_Location_With_Mincartvalue_Location_key_Start_time_End_time_AndKeyValue['2'];?>');
//alert('<?php //echo $ExplodeDelivery_Location_With_Mincartvalue_Location_key_Start_time_End_time_AndKeyValue['3'];?>');
jQuery('#byconsolewooodt_delivery_location option[value="<?php echo $ExplodeDelivery_Location_With_Mincartvalue_Location_key_Start_time_End_time_AndKeyValue[1];?>"]').prop('disabled', 'disabled');
}
else
{
//alert('<?php //echo $ExplodeDelivery_Location_With_Mincartvalue_Location_key_Start_time_End_time_AndKeyValue['2'];?>');
//alert('<?php //echo $ExplodeDelivery_Location_With_Mincartvalue_Location_key_Start_time_End_time_AndKeyValue['3'];?>');
}
jQuery('#byconsolewooodt_delivery_location option[value="<?php echo $ExplodeDelivery_Location_With_Mincartvalue_Location_key_Start_time_End_time_AndKeyValue[1];?>"]').prop('disabled', 'disabled');
//alert();
});
});
</script>
<?php
}
else
{
}
}
}
}
// Validate the custom field.
add_action('woocommerce_checkout_process', 'byconsolewooodt_checkout_field_process');
function byconsolewooodt_checkout_field_process() {
// Check if set, if its not set add an error.


$stripped_out_byconsolewooodt_delivery_widget_cookie=stripslashes($_COOKIE['byconsolewooodt_delivery_widget_cookie']);

$byconsolewooodt_delivery_widget_cookie_array=json_decode($stripped_out_byconsolewooodt_delivery_widget_cookie,true);

	if($byconsolewooodt_delivery_widget_cookie_array['byconsolewooodt_widget_type_field']=='take_away'){
	
		if ( ! $_POST['byconsolewooodt_delivery_date'])
		
		wc_add_notice( __( 'Enter your desired pickup date.','ByConsoleWooODTExtended' ), 'error' );
				
		if( ! $_POST['byconsolewooodt_delivery_time'])
		
		wc_add_notice( __( 'Enter your desired pickup time.','ByConsoleWooODTExtended' ), 'error' );
	}
	
	if($byconsolewooodt_delivery_widget_cookie_array['byconsolewooodt_widget_type_field']=='levering'){
	
		if ( ! $_POST['byconsolewooodt_delivery_date'])
		
		wc_add_notice( __( 'Enter your desired delivery date.','ByConsoleWooODTExtended' ), 'error' );
		
		if($_POST['byconsolewooodt_delivery_type_of_delivery_time']=='exact_time' || $_POST['byconsolewooodt_delivery_type_of_delivery_time_hidden']=='exact_time') 
		{
			if(! $_POST['byconsolewooodt_delivery_time'])
			wc_add_notice( __( 'Enter your desired delivery time.','ByConsoleWooODTExtended' ), 'error' );
		}
	}
	
	

/*if ( ! $_POST['byconsolewooodt_delivery_date'] )
wc_add_notice( __( 'Enter your desired delivery date.','ByConsoleWooODTExtended' ), 'error' );
//if ( ! $_POST['byconsolewooodt_delivery_time'] )
//wc_add_notice( __( 'Enter your desired delivery time.','ByConsoleWooODTExtended' ), 'error' );
if ($_POST['byconsolewooodt_delivery_type_of_delivery_time']=='exact_time' || $_POST['byconsolewooodt_delivery_type_of_delivery_time_hidden']=='exact_time' ) 
{
	if(! $_POST['byconsolewooodt_delivery_time'])
	{
	wc_add_notice( __( 'Enter your desired delivery time.','ByConsoleWooODTExtended' ), 'error' );
	}
}*/

}
//Save the order meta with field value
add_action( 'woocommerce_checkout_update_order_meta', 'byconsolewooodt_checkout_field_update_order_meta' );
function byconsolewooodt_checkout_field_update_order_meta( $order_id ) {
// get cookie as array
$stripped_out_byconsolewooodt_delivery_widget_cookie=stripslashes($_COOKIE['byconsolewooodt_delivery_widget_cookie']);
$byconsolewooodt_delivery_widget_cookie_array=json_decode($stripped_out_byconsolewooodt_delivery_widget_cookie,true);
if ( ! empty( $_POST['byconsolewooodt_delivery_type'] ) ) {
update_post_meta( $order_id, 'byconsolewooodt_delivery_type', $_POST['byconsolewooodt_delivery_type'] );
}
if ( ! empty( $_POST['byconsolewooodt_delivery_date'] ) ) {
update_post_meta( $order_id, 'byconsolewooodt_delivery_date', sanitize_text_field( $_POST['byconsolewooodt_delivery_date'] ) );
}
if ($_POST['byconsolewooodt_delivery_type_of_delivery_time']=='exact_time' || $_POST['byconsolewooodt_delivery_type_of_delivery_time_hidden']=='exact_time' ) {
if(! empty( $_POST['byconsolewooodt_delivery_time']))
{
update_post_meta( $order_id, 'byconsolewooodt_delivery_time', sanitize_text_field( $_POST['byconsolewooodt_delivery_time'] ) );
}
}
if ($_POST['byconsolewooodt_delivery_type_of_delivery_time']=='as_early_as_possible' ) 
{
update_post_meta( $order_id, 'byconsolewooodt_delivery_time', 'as_early_as_possible' );
}
if ( ! empty( $_POST['byconsolewooodt_delivery_location'] ) && $_POST['byconsolewooodt_delivery_type']=='levering'  ) {
update_post_meta( $order_id, 'byconsolewooodt_delivery_location', $_POST['byconsolewooodt_delivery_location'] );
}
if ( ! empty( $_POST['byconsolewooodt_pickup_location'] ) && $_POST['byconsolewooodt_delivery_type']=='take_away'  ) {
update_post_meta( $order_id, 'byconsolewooodt_pickup_location', $_POST['byconsolewooodt_pickup_location'] );
}
}
//Display field value on the order edit page
add_action( 'woocommerce_admin_order_data_after_shipping_address', 'byconsolewooodt_checkout_field_display_admin_order_meta', 10, 1 );
function byconsolewooodt_checkout_field_display_admin_order_meta($order){
if(get_post_meta( $order->id, 'byconsolewooodt_delivery_type', true )=='take_away'){
$order_delivery_type='Pickup';
$pickup_location=get_post_meta( $order->id, 'byconsolewooodt_pickup_location', true );
$pickup_location_get_option_array_value = get_option('byconsolewooodt_pickup_location');
if(!empty($pickup_location)){
$pickup_location_index=get_post_meta( $order->id, 'byconsolewooodt_pickup_location', true );
$pickup_location_name=$pickup_location_get_option_array_value[$pickup_location_index]['location'];
$location_string='<p><strong>'.__(get_option('byconsolewooodt_order_page_pickup_location_lable'),'ByConsoleWooODTExtended').':</strong> ' . $pickup_location_name . '</p>';
}else{
$location_string=__('No pickup location was selected','ByConsoleWooODTExtended');
}
}
if(get_post_meta( $order->id, 'byconsolewooodt_delivery_type', true )=='levering'){
$order_delivery_type='Delivery';
$delivery_location=get_post_meta( $order->id, 'byconsolewooodt_delivery_location', true );
$delivery_location_get_option_array_value = get_option('byconsolewooodt_delivery_location');
if(!empty($delivery_location)){
$delivery_location_index=get_post_meta( $order->id, 'byconsolewooodt_delivery_location', true );
$delivery_location_name=$delivery_location_get_option_array_value[$delivery_location_index]['location'];
$location_string='<p><strong>'.__(get_option('byconsolewooodt_order_page_delivery_location_lable'),'ByConsoleWooODTExtended').':</strong> ' . $delivery_location_name . '</p>';
}else{
$location_string=__('No delivery loaction was selected','ByConsoleWooODTExtended');
}
}
echo '<p><strong>'.__(get_option('byconsolewooodt_order_page_order_type_lable'),'ByConsoleWooODTExtended').':</strong> ' . $order_delivery_type . '</p>';
echo $location_string;
$productdeliverydate = new DateTime( get_post_meta( $order->id, 'byconsolewooodt_delivery_date', true ));
$formattedproductdeliverydate = get_option('byconsolewooodt_wooodt_date_formate_setting');
$delivery_time_val = get_post_meta( $order->id, 'byconsolewooodt_delivery_time', true );
if($delivery_time_val == 'as_early_as_possible')
{
$delivery_time_val_content = get_option('byconsolewooodt_as_early_as_possible_lable_text');
}
else
{
$delivery_time_val_content = get_post_meta( $order->id, 'byconsolewooodt_delivery_time', true );
}
if(!empty($pickup_location)){
echo '<p><strong>'.__(get_option('byconsolewooodt_order_page_pickup_date_lable'),'ByConsoleWooODTExtended').':</strong> ' . date_format($productdeliverydate, $formattedproductdeliverydate) . '</p>';
echo '<p><strong>'.__(get_option('byconsolewooodt_order_page_pickup_time_lable'),'ByConsoleWooODTExtended').':</strong> ' . $delivery_time_val_content . '</p>';
}
if(!empty($delivery_location)){
echo '<p><strong>'.__(get_option('byconsolewooodt_order_page_delivery_date_lable'),'ByConsoleWooODTExtended').':</strong> ' . date_format($productdeliverydate, $formattedproductdeliverydate) . '</p>';
echo '<p><strong>'.__(get_option('byconsolewooodt_order_page_delivery_time_lable'),'ByConsoleWooODTExtended').':</strong> ' . $delivery_time_val_content . '</p>';
}
}
// Display order meta in order details section
if(get_option('byconsolewooodt_widget_field_position')=='top'){ //hook here if it is set to show on top in admin settings page
//add_action( 'woocommerce_view_order', 'byconsolewooodt_checkout_field_display_user_order_meta', 10, 1 );
add_action( 'woocommerce_order_items_table', 'byconsolewooodt_checkout_field_display_user_order_meta', 10, 1 );
}
if(get_option('byconsolewooodt_widget_field_position')=='bottom'){  //hook here if it is set to show on bottom in admin settings page
add_action( 'woocommerce_order_details_after_order_table', 'byconsolewooodt_checkout_field_display_user_order_meta', 10, 1 );
}
function byconsolewooodt_checkout_field_display_user_order_meta($order){
if(get_post_meta( $order->id, 'byconsolewooodt_delivery_type', true )=='take_away'){
$order_delivery_type='Pickup';
$pickup_location=get_post_meta( $order->id, 'byconsolewooodt_pickup_location', true );
$pickup_location_get_option_array_value = get_option('byconsolewooodt_pickup_location');
//print_r($pickup_location_get_option_array_value);
if(!empty($pickup_location)){
$pickup_location_index=get_post_meta( $order->id, 'byconsolewooodt_pickup_location', true );
$pickup_location_name=$pickup_location_get_option_array_value[$pickup_location_index]['location'];
$location_string='<p><strong>'.__(get_option('byconsolewooodt_order_page_pickup_location_lable'),'ByConsoleWooODTExtended').':</strong> ' . $pickup_location_name . '</p>';
}else{
$location_string=__('No pickup loaction was selected','ByConsoleWooODTExtended');
}
}
if(get_post_meta( $order->id, 'byconsolewooodt_delivery_type', true )=='levering'){
$order_delivery_type='Delivery';
$delivery_location=get_post_meta( $order->id, 'byconsolewooodt_delivery_location', true );
$delivery_location_get_option_array_value = get_option('byconsolewooodt_delivery_location');	
if(!empty($delivery_location)){
$delivery_location_index=get_post_meta( $order->id, 'byconsolewooodt_delivery_location', true );
$delivery_location_name=$delivery_location_get_option_array_value[$delivery_location_index]['location'];	
$location_string='<p><strong>'.__(get_option('byconsolewooodt_order_page_delivery_location_lable'),'ByConsoleWooODTExtended').':</strong> ' . $delivery_location_name . '</p>';
}else{
$location_string=__('No delivery loaction was selected','ByConsoleWooODTExtended');
}		
}
echo '<p><strong>'.__(get_option('byconsolewooodt_order_page_order_type_lable'),'ByConsoleWooODTExtended').':</strong> ' . $order_delivery_type . '</p>';
echo $location_string;
$productdeliverydate = new DateTime( get_post_meta( $order->id, 'byconsolewooodt_delivery_date', true ));
$formattedproductdeliverydate = get_option('byconsolewooodt_wooodt_date_formate_setting');
$delivery_time_val = get_post_meta( $order->id, 'byconsolewooodt_delivery_time', true );
if($delivery_time_val == 'as_early_as_possible')
{
$delivery_time_val_content = get_option('byconsolewooodt_as_early_as_possible_lable_text');
}
else
{
$delivery_time_val_content = get_post_meta( $order->id, 'byconsolewooodt_delivery_time', true );
}
if(!empty($pickup_location)){
echo '<p><strong>'.__(get_option('byconsolewooodt_order_page_pickup_date_lable'),'ByConsoleWooODTExtended').':</strong> ' . date_format($productdeliverydate, $formattedproductdeliverydate) . '</p>';
echo '<p><strong>'.__(get_option('byconsolewooodt_order_page_pickup_time_lable'),'ByConsoleWooODTExtended').':</strong> ' . $delivery_time_val_content . '</p>';
}
if(!empty($delivery_location)){
echo '<p><strong>'.__(get_option('byconsolewooodt_order_page_delivery_date_lable'),'ByConsoleWooODTExtended').':</strong> ' . date_format($productdeliverydate, $formattedproductdeliverydate) . '</p>';
echo '<p><strong>'.__(get_option('byconsolewooodt_order_page_delivery_time_lable'),'ByConsoleWooODTExtended').':</strong> ' . $delivery_time_val_content . '</p>';
}
//echo '<p><strong>'.__('Delivery date','ByConsoleWooODTExtended').':</strong> ' .date_format($productdeliverydate, $formattedproductdeliverydate) . '</p>';
//echo '<p><strong>'.__(get_option('byconsolewooodt_order_page_delivery_date_lable'),'ByConsoleWooODTExtended').':</strong> ' .date_format($productdeliverydate, $formattedproductdeliverydate) . '</p>';
//echo '<p><strong>'.__(get_option('byconsolewooodt_order_page_delivery_time_lable'),'ByConsoleWooODTExtended').':</strong> ' . $delivery_time_val_content . '</p>';
//prepare shipping texts
if(get_post_meta( $order->id, 'byconsolewooodt_delivery_type', true )=='levering'){
$prepare_shipping_text= str_replace('[deliver_date]','<b>'.date_format($productdeliverydate, $formattedproductdeliverydate).'</b>',
get_option('byconsolewooodt_orders_delivered'));
echo '<p>'.str_replace('[deliver_time]','<b>'.$delivery_time_val_content.'</b>',$prepare_shipping_text).'</p>';
}
if(get_post_meta( $order->id, 'byconsolewooodt_delivery_type', true )=='take_away'){
$prepare_shipping_text= str_replace('[pickup_date]','<b>'.get_post_meta( $order->id, 'byconsolewooodt_delivery_date', true ).'</b>',get_option('byconsolewooodt_orders_pick_up'));
echo '<p>'.str_replace('[pickup_time]','<b>'.$delivery_time_val_content.'</b>',$prepare_shipping_text).'</p>';	
}}
//include the custom order meta to woocommerce mail
add_action( "woocommerce_email_after_order_table", "byconsolewooodt_woocommerce_email_after_order_table", 10, 1);
function byconsolewooodt_woocommerce_email_after_order_table( $order ) {
if(get_post_meta( $order->id, 'byconsolewooodt_delivery_type', true )=='take_away'){
$order_delivery_type='Pickup';
$pickup_location=get_post_meta( $order->id, 'byconsolewooodt_pickup_location', true );
$pickup_location_get_option_array_value = get_option('byconsolewooodt_pickup_location');
if(!empty($pickup_location)){
$pickup_location_index=get_post_meta( $order->id, 'byconsolewooodt_pickup_location', true );
$pickup_location_name=$pickup_location_get_option_array_value[$pickup_location_index]['location'];
$location_string='<p><strong>'.__(get_option('byconsolewooodt_order_page_pickup_location_lable'),'ByConsoleWooODTExtended').':</strong> ' . $pickup_location_name . '</p>';
}else{
$location_string=__('No pickup loaction was selected','ByConsoleWooODTExtended');
}
}
if(get_post_meta( $order->id, 'byconsolewooodt_delivery_type', true )=='levering'){
$order_delivery_type='Delivery';
$delivery_location=get_post_meta( $order->id, 'byconsolewooodt_delivery_location', true );
$delivery_location_get_option_array_value = get_option('byconsolewooodt_delivery_location');	
if(!empty($delivery_location)){
$delivery_location_index=get_post_meta( $order->id, 'byconsolewooodt_delivery_location', true );
$delivery_location_name=$delivery_location_get_option_array_value[$delivery_location_index]['location'];	
$location_string='<p><strong>'.__(get_option('byconsolewooodt_order_page_delivery_location_lable'),'ByConsoleWooODTExtended').':</strong> ' . $delivery_location_name . '</p>';
}else{
$location_string=__('No delivery loaction was selected','ByConsoleWooODTExtended');
}
}
echo '<p><strong>'.__(get_option('byconsolewooodt_order_page_order_type_lable'),'ByConsoleWooODTExtended').':</strong> ' . $order_delivery_type . '</p>';
echo $location_string;
$productdeliverydate = new DateTime( get_post_meta( $order->id, 'byconsolewooodt_delivery_date', true ));
$formattedproductdeliverydate = get_option('byconsolewooodt_wooodt_date_formate_setting');
$delivery_time_val = get_post_meta( $order->id, 'byconsolewooodt_delivery_time', true );
if($delivery_time_val == 'as_early_as_possible')
{
$delivery_time_val_content = get_option('byconsolewooodt_as_early_as_possible_lable_text');
}
else
{
$delivery_time_val_content = get_post_meta( $order->id, 'byconsolewooodt_delivery_time', true );
}
if(!empty($pickup_location)){
echo '<p><strong>'.__(get_option('byconsolewooodt_order_page_pickup_date_lable'),'ByConsoleWooODTExtended').':</strong> ' . date_format($productdeliverydate, $formattedproductdeliverydate) . '</p>';
echo '<p><strong>'.__(get_option('byconsolewooodt_order_page_pickup_time_lable'),'ByConsoleWooODTExtended').':</strong> ' . $delivery_time_val_content . '</p>';
}
if(!empty($delivery_location)){
echo '<p><strong>'.__(get_option('byconsolewooodt_order_page_delivery_date_lable'),'ByConsoleWooODTExtended').':</strong> ' . date_format($productdeliverydate, $formattedproductdeliverydate) . '</p>';
echo '<p><strong>'.__(get_option('byconsolewooodt_order_page_delivery_time_lable'),'ByConsoleWooODTExtended').':</strong> ' . $delivery_time_val_content . '</p>';
}
//echo '<p><strong>'.__(get_option('byconsolewooodt_order_page_delivery_date_lable'),'ByConsoleWooODTExtended').':</strong> ' . date_format($productdeliverydate, $formattedproductdeliverydate) . '</p>';
//echo '<p><strong>'.__(get_option('byconsolewooodt_order_page_delivery_time_lable'),'ByConsoleWooODTExtended').':</strong> ' . $delivery_time_val_content . '</p>';
}
// add our styles and js
function byconsolewooodt_add_scripts() {
wp_enqueue_script('jquery-ui-datepicker');
wp_register_script('byconsolewooodt_script_2', plugins_url('js/jquery.timepicker.min.js', __FILE__), array('jquery'),'1.12', true);
wp_register_script('byconsolewooodt_script_3', plugins_url('js/byconsolewooodt.js', __FILE__), array('jquery'),'1.12', true);
wp_enqueue_script('byconsolewooodt_script_2');
wp_enqueue_script('byconsolewooodt_script_3');
}
add_action( 'wp_enqueue_scripts', 'byconsolewooodt_add_scripts' ); 
//add styles
function byconsolewooodt_add_styles() {
wp_enqueue_style('byconsolewooodt_stylesheet', plugins_url('css/style.css', __FILE__));
wp_enqueue_style('byconsolewooodt_stylesheet_2', plugins_url('css/jquery-ui.min.css', __FILE__));
wp_enqueue_style('byconsolewooodt_stylesheet_3', plugins_url('css/jquery-ui.theme.min.css', __FILE__));
wp_enqueue_style('byconsolewooodt_stylesheet_4', plugins_url('css/jquery-ui.structure.min.css', __FILE__));
wp_enqueue_style('byconsolewooodt_stylesheet_5', plugins_url('css/jquery.timepicker.css', __FILE__));
}
add_action( 'wp_enqueue_scripts', 'byconsolewooodt_add_styles' ); 
// add admin scripts
function byconsolewooodt_admin_script($hook) {global $byconsolewooodt_admin_settings;
global $byconsolewooodt_admin_settings_holidays;
global $byconsolewooodt_admin_feature_settings;
global $byconsolewooodt_admin_location_settings;
global $byconsolewooodt_admin_language_translator_settings;
global $byconsolewooodt_admin_color_picker_settings;if( $hook == $byconsolewooodt_admin_settings ||  $hook == $byconsolewooodt_admin_settings_holidays  || $hook == $byconsolewooodt_admin_feature_settings || $hook == $byconsolewooodt_admin_location_settings || $hook == $byconsolewooodt_admin_language_translator_settings || $hook == $byconsolewooodt_admin_color_picker_settings) 
{	//return;
wp_register_script( 'byconsolewooodt-admin-script', plugins_url( 'js/byconsolewooodt-admin-script.js' , __FILE__ ),array('jquery'),'1.12', true );
//wp_register_script( 'byconsolewooodt-admin-script-2', plugins_url( 'js/jquery-1.12.4.js' , __FILE__ ),array('jquery'),'1.12', true );
wp_register_script( 'byconsolewooodt-admin-script-3', plugins_url( 'js/jquery-ui.js' , __FILE__ ),array('jquery'),'1.12', true );
wp_register_script( 'byconsolewooodt-admin-script-4', plugins_url( 'js/jquery-ui.multidatespicker.js' , __FILE__ ),array('jquery'),'1.12', true );
wp_register_script( 'byconsolewooodt-admin-script-5', plugins_url( 'js/jscolor.js' , __FILE__ ),array('jquery'),'1.12', true );
wp_register_script( 'byconsolewooodt-admin-script-6', plugins_url( 'js/jscolor.min.js' , __FILE__ ),array('jquery'),'1.12', true );
wp_enqueue_script( 'byconsolewooodt-admin-script');
//wp_enqueue_script( 'byconsolewooodt-admin-script-2');
wp_enqueue_script( 'byconsolewooodt-admin-script-3');
wp_enqueue_script( 'byconsolewooodt-admin-script-4');
wp_enqueue_script( 'byconsolewooodt-admin-script-5');
wp_enqueue_script( 'byconsolewooodt-admin-script-6');
wp_enqueue_style('byconsolewooodt_admin_stylesheet', plugins_url('css/admin.css', __FILE__));
wp_enqueue_style('byconsolewooodt_admin_stylesheet_3', plugins_url('css/adminjquery-ui.css', __FILE__));
}
else
{
return;
}
}
add_action('admin_enqueue_scripts', 'byconsolewooodt_admin_script');
// refreshing the cart on page load
/** Break html5 cart caching */
add_action('wp_enqueue_scripts', 'cartcache_enqueue_scripts', 100);
function cartcache_enqueue_scripts()
{
wp_deregister_script('wc-cart-fragments');
wp_enqueue_script( 'wc-cart-fragments', plugins_url( 'js/cart-fragments.js', __FILE__ ), array( 'jquery', 'jquery-cookie' ), '1.12', true );
}
// show only store pickup when take_away is selected	
add_filter('woocommerce_package_rates', 'byconsolewooodt_shipping_according_widget_input', 10, 2);
function byconsolewooodt_shipping_according_widget_input($rates, $package)
{
// get cookie as array
$stripped_out_byconsolewooodt_delivery_widget_cookie=stripslashes($_COOKIE['byconsolewooodt_delivery_widget_cookie']);
$byconsolewooodt_delivery_widget_cookie_array=json_decode($stripped_out_byconsolewooodt_delivery_widget_cookie,true);
global $woocommerce;
$version = "2.6";
if (version_compare($woocommerce->version, $version, ">=")) {
$new_rates = array();
/*echo '<hr />';
print_r($rates);*/
if($byconsolewooodt_delivery_widget_cookie_array['byconsolewooodt_widget_type_field']=='take_away'){
foreach($rates as $key => $rate) {
if ('local_pickup' === $rate->method_id || 'legacy_local_pickup' === $rate->method_id) {
$new_rates[$key] = $rates[$key];
}
}
/*print_r($new_rates);
print_r($rates);*/
}elseif($byconsolewooodt_delivery_widget_cookie_array['byconsolewooodt_widget_type_field']=='levering'){
foreach($rates as $key => $rate) {
/*print_r($rate);
echo '<hr />';*/
if ('local_pickup' != $rate->method_id && 'legacy_local_pickup' != $rate->method_id ) {
$new_rates[$key] = $rates[$key];
//unset($rates['local_pickup']);
}
}
}else{
//
}
return empty($new_rates) ? $rates : $new_rates;
/*echo '<hr />';
print_r($new_rates);*/
}
else {
if ($byconsolewooodt_delivery_widget_cookie_array['byconsolewooodt_widget_type_field']=='take_away') {
$predefined_shipping          = $rates['local_pickup'];
$rates                  = array();
$rates['local_pickup'] = $predefined_shipping;
}
if ($byconsolewooodt_delivery_widget_cookie_array['byconsolewooodt_widget_type_field']=='levering') {
$predefined_shipping          = $rates['flat_rate'];
$rates                  = array();
$rates['flat_rate'] = $predefined_shipping;
}
}
return $rates;
}
function byconsolewooodt_footer_script(){
$currentlang=get_locale();
// get cookie as array
$stripped_out_byconsolewooodt_delivery_widget_cookie=stripslashes($_COOKIE['byconsolewooodt_delivery_widget_cookie']);
$byconsolewooodt_delivery_widget_cookie_array=json_decode($stripped_out_byconsolewooodt_delivery_widget_cookie,true);
?>
<script>
function ByConsoleWooODTStartTimeByInterval(cur_hour,cur_minute){
if(cur_minute > 0 && cur_minute < 15){
var start_minute=15;
}else if(cur_minute >= 15 && cur_minute < 30){
var start_minute=30;
}else if(cur_minute >= 30 && cur_minute < 45){
var start_minute=45;
}else if(cur_minute >= 45 && cur_minute < 59){
var start_minute=59;
}else{}
if(start_minute==59){
var next_hour=parseInt(cur_hour)+1;
var start_time_updated=next_hour+":"+"00";
}else{
var start_time_updated=cur_hour+":"+start_minute;
}
return start_time_updated;
} // end of ByConsoleWooODTtimeInterval
function ByconsolewooodtDeliveryWidgetTimePopulate(date_field_identifier,time_field_identifier,location_eligibility){
//alert(location_eligibility);
var service_status='open';
//remove time picker to bound new timepicker according to allowable time for selected location
jQuery(time_field_identifier).timepicker("remove"); 
jQuery(time_field_identifier).val(''); 
// allow location based time if location feature is checked in setting page
<?php
if($byconsolewooodt_delivery_widget_cookie_array['byconsolewooodt_widget_type_field']=='levering'){
$is_location_enabled=get_option('byconsolewooodt_multiple_delivery_location');	
$location_field_to_pass='byconsolewooodt_widget_delivery_location';
}
if($byconsolewooodt_delivery_widget_cookie_array['byconsolewooodt_widget_type_field']=='take_away'){
$is_location_enabled=get_option('byconsolewooodt_multiple_pickup_location');
$location_field_to_pass='byconsolewooodt_widget_pickup_location';
}
if($is_location_enabled=='YES'){?>
//if no location is selected then exit from this loop
if(location_eligibility.options[location_eligibility.selectedIndex].value!=''){
//selected_location_eligibility_to_pass_for_datepicker=location_eligibility; // access this variable when clicking on datepicker
//alert(location_eligibility.options[location_eligibility.selectedIndex].text);
var location_condition_string=location_eligibility.options[location_eligibility.selectedIndex].text;
var location_condition_array=location_condition_string.split('--');
//alert(location_condition_array[1]);
var location_timing = location_condition_array[1].split("-");
//var delivery_opening_time = location_timing[0].replace(/[A-Za-z$-]/g, "");
order_type=jQuery('input[name=byconsolewooodt_widget_type_field]:checked').val();
//alert('order_type: '+order_type);
if(order_type=='take_away'){
pickup_opening_time = location_timing[0].replace(/[A-Za-z$-(]/g, "");
pickup_ending_time = location_timing[1].replace(/[A-Za-z$-)]/g, "");	
//alert('Pickup Start - Ending || '+pickup_opening_time+'-'+pickup_ending_time);
}
if(order_type=='levering'){
delivery_opening_time = location_timing[0].replace(/[A-Za-z$-(]/g, "");
delivery_ending_time = location_timing[1].replace(/[A-Za-z$-)]/g, "");	
//alert('Delivery Start - Ending || '+delivery_opening_time+'-'+delivery_ending_time);
}
}else{ //if no location is selected then return 'no location selected' and ask to select location first	
alert('Please select location first...');
var service_status='No_location_selected';
}
<?php }else{?>
var delivery_opening_time="<?php echo get_option('byconsolewooodt_delivery_hours_from'); ?>";
var delivery_ending_time="<?php echo get_option('byconsolewooodt_delivery_hours_to'); ?>";
var pickup_opening_time="<?php echo get_option('byconsolewooodt_opening_hours_from'); ?>";
var pickup_ending_time="<?php echo get_option('byconsolewooodt_opening_hours_to'); ?>";
<?php }?>
//alert('Pickup Start - Ending || '+pickup_opening_time+'-'+pickup_ending_time);
//if timing is not provided for the loaction then use default timeing.
if(delivery_opening_time!=null || delivery_opening_time!=''){
var delivery_opening_time=delivery_opening_time;
}else{
var delivery_opening_time="<?php echo get_option('byconsolewooodt_delivery_hours_from'); ?>";
}
if(delivery_ending_time!=null || delivery_ending_time!=''){
var delivery_ending_time=delivery_ending_time;
}else{
var delivery_ending_time="<?php echo get_option('byconsolewooodt_delivery_hours_to'); ?>";
}
if(pickup_opening_time!=null || pickup_opening_time!=''){
var pickup_opening_time=pickup_opening_time;
}else{
var pickup_opening_time="<?php echo get_option('byconsolewooodt_opening_hours_from'); ?>";
}
if(pickup_ending_time!=null || pickup_ending_time!=''){
var pickup_ending_time=pickup_ending_time;
}else{
var pickup_ending_time="<?php echo get_option('byconsolewooodt_opening_hours_to'); ?>";
}
// lock the time selection based on admin settings for delivery time
//echo 'var curtime_to_compare=new Date().toLocaleTimeString();';
var curtime= new Date().toLocaleTimeString("en-US", { hour12: false, hour: "numeric", minute: "numeric"});
//echo 'alert(curtime_to_compare+"|"+curtime);
// get local minute
var cur_minute= new Date().toLocaleTimeString("en-US", { hour12: false, minute: "numeric"});
// get local hour
var cur_hour= new Date().toLocaleTimeString("en-US", { hour12: false, hour: "numeric"});											 
ByConsoleWooODTStartTimeByInterval(cur_hour,cur_minute); // check this function in wp-footer
//populate time field based on date selection (call this function onSelect event of datepicker)
/*var selected_date=jQuery(".byconsolewooodt_widget_date_field").datepicker( "getDate" );*/
//selected_date=jQuery(date_field_identifier).datepicker().val();
//selected_date=jQuery(date_field_identifier).datepicker('getDate');
selected_date=jQuery(date_field_identifier).datepicker({ dateFormat: 'dd-mm-yy' }).val();
//alert('------------ we had problem here -- selectde_date='+selected_date+'---- coz of date_field_identifier='+date_field_identifier);
//selected_date=formatDate('d/m/y',selected_date);
//alert(selected_date);
/*if(selected_date=='' || selected_date==null){
alert('Please select your location first');
}*/
todays_date=new Date();
todays_date_month=(todays_date.getMonth()+1);
todays_date_date=todays_date.getDate();
todays_date_year=todays_date.getFullYear();
if( todays_date_month < 10){
todays_date_month='0' + todays_date_month;
}
if(todays_date_date < 10){
todays_date_date='0' + todays_date_date;
}
todays_formated_date= todays_date_month + "/" + todays_date_date + "/" + todays_date_year;
//alert(selected_date+"|"+todays_formated_date);	
//alert(selected_date +'||'+ todays_formated_date);
//alert('selected_date: '+selected_date +'|| todays_formated_date: '+ todays_formated_date);
if( Date.parse(selected_date) > Date.parse(todays_formated_date) ){
//alert(selected_date +'>'+ todays_formated_date);
<?php if($byconsolewooodt_delivery_widget_cookie_array['byconsolewooodt_widget_type_field']=='take_away'){?>
start_time_updated_as_per_selected_date = pickup_opening_time;
<?php }
if($byconsolewooodt_delivery_widget_cookie_array['byconsolewooodt_widget_type_field']=='levering'){?>
start_time_updated_as_per_selected_date = delivery_opening_time;
//alert('delivery opening time:'+start_time_updated_as_per_selected_date+'is it okay?');
<?php }?>
//alert('Different date, so starting time is store openning time '+delivery_opening_time + pickup_opening_time);
/*if(selected_date < todays_formated_date){
alert('Past date selected');
}
*/
}else if( Date.parse(selected_date) < Date.parse(todays_formated_date) ){ // this may happen when date value in cookie is older than today's date
//alert(selected_date +'<'+ todays_formated_date);
<?php if($byconsolewooodt_delivery_widget_cookie_array['byconsolewooodt_widget_type_field']=='take_away'){?>
start_time_updated_as_per_selected_date = pickup_opening_time;
<?php }
if($byconsolewooodt_delivery_widget_cookie_array['byconsolewooodt_widget_type_field']=='levering'){?>
start_time_updated_as_per_selected_date = delivery_opening_time;
<?php }?>
//alert('Different date, so starting time is store openning time '+delivery_opening_time + pickup_opening_time);
/*if(selected_date < todays_formated_date){
alert('Past date selected');
}
*/
var service_status='passed away';
//alert(service_status);
}else if( Date.parse(selected_date) == Date.parse(todays_formated_date) ){
//alert(selected_date +'=='+ todays_formated_date);
//if current time is grater than openning time then show current time
<?php if($byconsolewooodt_delivery_widget_cookie_array['byconsolewooodt_widget_type_field']=='take_away'){?>
//alert(curtime +"||"+ pickup_opening_time);
if(curtime <= pickup_opening_time){
start_time_updated_as_per_selected_date = pickup_opening_time;
}
if(curtime > pickup_opening_time){
start_time_updated_as_per_selected_date = ByConsoleWooODTStartTimeByInterval(cur_hour,cur_minute); // check this function in wp_footer
}
// do not accept orders for today if the current time is closing time already
if(curtime >= pickup_ending_time){
var service_status='close';
}
<?php }
if($byconsolewooodt_delivery_widget_cookie_array['byconsolewooodt_widget_type_field']=='levering'){?>
if(curtime <= delivery_opening_time){
start_time_updated_as_per_selected_date = delivery_opening_time;
}
if(curtime > delivery_opening_time){
start_time_updated_as_per_selected_date = ByConsoleWooODTStartTimeByInterval(cur_hour,cur_minute); // check this function in wp_footer
}
// do not accept orders for today if the current time is closing time already
if(curtime >= delivery_ending_time){
var service_status='close';
}
<?php }?>
//alert('equal date, so starting time is current time '+start_time_updated_as_per_selected_date)
}else{
if( selected_date == '' || selected_date == null ){
//alert('selected_date:BLANK');
}else{
//alert('selected_date: '+selected_date);	
alert('You have bug in this version of plugin, please update the plugin');
}
}
<?php
if($byconsolewooodt_delivery_widget_cookie_array['byconsolewooodt_widget_type_field']=='levering'){
?>
/*
echo 'if(curtime > "'.get_option('byconsolewooodt_delivery_hours_from').'"){';
echo 'var start_time=curtime;';
echo '}else{';
echo 'var start_time="'.get_option('byconsolewooodt_delivery_hours_from').'";}';
//echo 'alert(start_time);';
*/
jQuery(time_field_identifier).timepicker({
//if it is not today's date selected in dateicker then do not do the past time resriction 
//if(jQuery(".byconsolewooodt_widget_date_field").datepicker( "getDate" )!= new Date();
"minTime": start_time_updated_as_per_selected_date,
//"maxTime": "<?php //echo get_option('byconsolewooodt_delivery_hours_to');?>",
"maxTime": delivery_ending_time,
"disableTextInput": "true",
"disableTouchKeyboard": "true",
"scrollDefault": "now",
"step": "15",
"selectOnBlur": "true",
"timeFormat": "<?php echo get_option('byconsolewooodt_hours_format');?>"
});
<?php
}
// lock the time selection based on admin settings for pickup time
if($byconsolewooodt_delivery_widget_cookie_array['byconsolewooodt_widget_type_field']=='take_away'){
?>
//alert('start_time_updated_as_per_selected_date::: '+start_time_updated_as_per_selected_date);
jQuery(time_field_identifier).timepicker({
//"minTime": '09.00.00',
"minTime": start_time_updated_as_per_selected_date,
//"maxTime": "<?php //echo get_option('byconsolewooodt_opening_hours_to');?>",
"maxTime": pickup_ending_time,
"disableTextInput": "true",
"disableTouchKeyboard": "true",
"scrollDefault": "now",
"step": "15",
"selectOnBlur": "true",
"timeFormat": "<?php echo get_option('byconsolewooodt_hours_format');?>"
});
<?php
}
// if no delivery type is not selected then show all times
if($byconsolewooodt_delivery_widget_cookie_array['byconsolewooodt_widget_type_field']==''){
?>
jQuery(time_field_identifier).timepicker({
"disableTextInput": "true",
"disableTouchKeyboard": "true",
"scrollDefault": "now",
"step": "15",
"selectOnBlur": "true",
"timeFormat": "<?php echo get_option('byconsolewooodt_hours_format');?>"
});
<?php
}	
?>
//alert('end line');
//alert('minTime :'+start_time_updated_as_per_selected_date+'||maxTime: '+pickup_ending_time);
//alert(time_field_identifier);
//alert('service_status='+service_status);
// remove timepicker and say"we are closed" when delivery/pickup time is over for today
if(service_status=='close'){
jQuery(time_field_identifier).timepicker("remove"); 
jQuery(time_field_identifier).val(''); 
jQuery(time_field_identifier).css({'display':'none'});	
jQuery(time_field_identifier+'_service_closed_notice').html('<?php printf(__('we are closed for today, please select another day','ByConsoleWooODTExtended'));?>');
}
if(service_status=='passed away'){
jQuery(time_field_identifier).timepicker("remove"); 
jQuery(time_field_identifier).val(''); 
jQuery(time_field_identifier).css({'display':'none'});	
jQuery(time_field_identifier+'_service_closed_notice').html('<?php printf(__('Please select a date equal to or greater than current date','ByConsoleWooODTExtended'));?>');
}
if(service_status=='No_location_selected'){
jQuery(time_field_identifier).timepicker("remove"); 
jQuery(time_field_identifier).val(''); 
jQuery(time_field_identifier).css({'display':'none'});	
jQuery(time_field_identifier+'_service_closed_notice').html('<?php printf(__('Please select a location first','ByConsoleWooODTExtended'));?>');
}	
if(service_status=='open'){
jQuery(time_field_identifier).css({'display':'block'});		
jQuery(time_field_identifier+'_service_closed_notice').html('');	
}
} // End of function ByconsolewooodtDeliveryWidgetTimePopulate
</script>
<?php
// prepare shop close day by days
// get todays date 
$gattodayname=date("l");
$gattodaynumericval=date("w");				
$sunday = get_option('byconsolewooodt_admin_closing_sunday');
$monday = get_option('byconsolewooodt_admin_closing_monday');
$tuesday = get_option('byconsolewooodt_admin_closing_tuesday');
$wednessday = get_option('byconsolewooodt_admin_closing_wednessday');
$thursday = get_option('byconsolewooodt_admin_closing_thursday');
$friday = get_option('byconsolewooodt_admin_closing_friday');
$saturday = get_option('byconsolewooodt_admin_closing_saturday');
$sunday = ($sunday=='') ? 99 : 0;
$monday = ! empty($monday) ? $monday : 99;
$tuesday = ! empty($tuesday) ? $tuesday : 99;
$wednessday = ! empty($wednessday) ? $wednessday : 99;
$thursday = ! empty($thursday) ? $thursday : 99;
$friday = ! empty($friday) ? $friday : 99;
$saturday = ! empty($saturday) ? $saturday : 99;
//date and time fields population by plugin settings page
$current_active_year=date("Y");
// casual holidays
$deactive_casual_holiday_from_calender=get_option('byconsolewooodt_admin_holiday_date');
$deactive_casual_holiday_from_calender_array = explode(',', $deactive_casual_holiday_from_calender);
//national holidays
$deactive_casual_holiday_from_calender_for_national=get_option('byconsolewooodt_admin_national_holiday_date');
$deactive_casual_holiday_from_calender_for_national_array = explode(',', $deactive_casual_holiday_from_calender_for_national);
$national_holiday_string='';
foreach($deactive_casual_holiday_from_calender_for_national_array as $deactive_casual_holiday_from_calender_for_national_array_single)
{
//national holidays add year after date and month
$national_holiday_single_val = ''.trim($deactive_casual_holiday_from_calender_for_national_array_single.'/'.$current_active_year).',';
$national_holiday_string=$national_holiday_string.$national_holiday_single_val;
}
$national_holiday_string=substr($national_holiday_string,0,-1);
//national holidays explode
$national_holiday_string_explode_single_arry_val=explode(",",$national_holiday_string);
//casual and national holidays marge
$national_and_casual_holiday_marge = array_merge($national_holiday_string_explode_single_arry_val,$deactive_casual_holiday_from_calender_array);// get allowable pickup days
$byconsolewooodt_pickupdays_array=get_option('byconsolewooodt_pickup_days');
$string_for_pickupdays_js_array='';
$allowable_pickup_days_js_array='';
if(!empty($byconsolewooodt_pickupdays_array)){
foreach($byconsolewooodt_pickupdays_array as $allowable_pickupday){
/*if($currentlang == 'en_US')
{
if ($allowable_pickupday==1){
$calendar_day='Sun';
}else if ($allowable_pickupday==2){
$calendar_day='Mon';
}else if ($allowable_pickupday==3){
$calendar_day='Tue';
}else if ($allowable_pickupday==4){
$calendar_day='Wed';
}else if ($allowable_pickupday==5){
$calendar_day='Thu';
}else if ($allowable_pickupday==6){
$calendar_day='Fri';
}else if ($allowable_pickupday==7){
$calendar_day='Sat';
}else {
$calendar_day='';
}
}*/
/*English*/
if($currentlang == 'en_US')
{
if ($allowable_pickupday==1){
$calendar_day='Sun';	
}else if ($allowable_pickupday==2){	
$calendar_day='Mon';	
}else if ($allowable_pickupday==3){	
$calendar_day='Tue';	
}else if ($allowable_pickupday==4){	
$calendar_day='Wed';	
}else if ($allowable_pickupday==5){	
$calendar_day='Thu';	
}else if ($allowable_pickupday==6){	
$calendar_day='Fri';	
}else if ($allowable_pickupday==7){	
$calendar_day='Sat';	
}else {	
$calendar_day='';	
}
}
/*deutsch(sie)*/
else if($currentlang == 'de_DE_formal' || $currentlang == 'de_DE')
{
if ($allowable_pickupday==1){	
$calendar_day='So';
}else if ($allowable_pickupday==2){
$calendar_day='Mo';
}else if ($allowable_pickupday==3){
$calendar_day='Di';
}else if ($allowable_pickupday==4){
$calendar_day='Mi';
}else if ($allowable_pickupday==5){
$calendar_day='Do';
}else if ($allowable_pickupday==6){
$calendar_day='Fr';
}else if ($allowable_pickupday==7){
$calendar_day='Sa';
}else {
$calendar_day='';
}
}
/*Español --  Spanish*/
/*else if($currentlang == 'es_ES')
{
if ($allowable_pickupday==1){	
$calendar_day='Dom';
}else if ($allowable_pickupday==2){
$calendar_day='Lun';
}else if ($allowable_pickupday==3){
$calendar_day='Mar';
}else if ($allowable_pickupday==4){
$calendar_day='Mié';
}else if ($allowable_pickupday==5){
$calendar_day='Jue';
}else if ($allowable_pickupday==6){
$calendar_day='Vie';
}else if ($allowable_pickupday==7){
$calendar_day='sáb';
}else {
$calendar_day='';
}
}*/
/*deutsch(schweiz)*/
else if($currentlang =='de_CH')
{
if ($allowable_pickupday==1){	
$calendar_day='So';
}else if ($allowable_pickupday==2){
$calendar_day='Mo';
}else if ($allowable_pickupday==3){
$calendar_day='Di';
}else if ($allowable_pickupday==4){
$calendar_day='Mi';
}else if ($allowable_pickupday==5){
$calendar_day='Do';
}else if ($allowable_pickupday==6){
$calendar_day='Fr';
}else if ($allowable_pickupday==7){
$calendar_day='Sa';
}else {
$calendar_day='';
}
}
/*Danish*/
else if($currentlang == 'da_DK')
{
if ($allowable_pickupday==1){	
$calendar_day='søn';
}else if ($allowable_pickupday==2){
$calendar_day='man';
}else if ($allowable_pickupday==3){
$calendar_day='tirs';
}else if ($allowable_pickupday==4){
$calendar_day='ons';
}else if ($allowable_pickupday==5){
$calendar_day='tors';
}else if ($allowable_pickupday==6){
$calendar_day='fre';
}else if ($allowable_pickupday==7){
$calendar_day='lør';
}else {
$calendar_day='';
}
}
/*French*/
else if($currentlang == 'fr_FR')
{
if ($allowable_pickupday==1){	
$calendar_day='dim';
}else if ($allowable_pickupday==2){
$calendar_day='lun';
}else if ($allowable_pickupday==3){
$calendar_day='mar';
}else if ($allowable_pickupday==4){
$calendar_day='mer';
}else if ($allowable_pickupday==5){
$calendar_day='jeu';
}else if ($allowable_pickupday==6){
$calendar_day='ven';
}else if ($allowable_pickupday==7){
$calendar_day='sam';
}else {
$calendar_day='';
}
}
/*Italian*/
else if($currentlang == 'it_IT')
{
if ($allowable_pickupday==1){	
$calendar_day='dom';
}else if ($allowable_pickupday==2){
$calendar_day='lun';
}else if ($allowable_pickupday==3){
$calendar_day='mar';
}else if ($allowable_pickupday==4){
$calendar_day='mer';
}else if ($allowable_pickupday==5){
$calendar_day='gio';
}else if ($allowable_pickupday==6){
$calendar_day='ven';
}else if ($allowable_pickupday==7){
$calendar_day='sab';
}else {
$calendar_day='';
}
}
/*Croatian*/
else if($currentlang == 'hr')
{
if ($allowable_pickupday==1){	
$calendar_day='Ned';
}else if ($allowable_pickupday==2){
$calendar_day='Pon';
}else if ($allowable_pickupday==3){
$calendar_day='Uto';
}else if ($allowable_pickupday==4){
$calendar_day='Sri';
}else if ($allowable_pickupday==5){
$calendar_day='Čet';
}else if ($allowable_pickupday==6){
$calendar_day='Pet';
}else if ($allowable_pickupday==7){
$calendar_day='Sub';
}else {
$calendar_day='';
}
}
/*Romanian*/
else if($currentlang == 'ro_RO')
{
if ($allowable_pickupday==1){	
$calendar_day='Dum';
}else if ($allowable_pickupday==2){
$calendar_day='lun';
}else if ($allowable_pickupday==3){
$calendar_day='mar';
}else if ($allowable_pickupday==4){
$calendar_day='mie';
}else if ($allowable_pickupday==5){
$calendar_day='joi';
}else if ($allowable_pickupday==6){
$calendar_day='vin';
}else if ($allowable_pickupday==7){
$calendar_day='sâm';
}else {
$calendar_day='';
}
}
/*Bulgarian*/
else if($currentlang =='bg_BG')
{
if ($allowable_pickupday==1){	
$calendar_day='нд';
}else if ($allowable_pickupday==2){
$calendar_day='пн';
}else if ($allowable_pickupday==3){
$calendar_day='вт';
}else if ($allowable_pickupday==4){
$calendar_day='ср';
}else if ($allowable_pickupday==5){
$calendar_day='чт';
}else if ($allowable_pickupday==6){
$calendar_day='пт';
}else if ($allowable_pickupday==7){
$calendar_day='сб';
}else {
$calendar_day='';
}
}
/*Czech*/
else if($currentlang =='cs_CZ')
{
if ($allowable_pickupday==1){	
$calendar_day='Ne';
}else if ($allowable_pickupday==2){
$calendar_day='Po';
}else if ($allowable_pickupday==3){
$calendar_day='Út';
}else if ($allowable_pickupday==4){
$calendar_day='St';
}else if ($allowable_pickupday==5){
$calendar_day='Čt';
}else if ($allowable_pickupday==6){
$calendar_day='Pá';
}else if ($allowable_pickupday==7){
$calendar_day='So';
}else {
$calendar_day='';
}
}
/*Hungarian*/
else if($currentlang == 'hu_HU')
{
if ($allowable_pickupday==1){	
$calendar_day='vas';
}else if ($allowable_pickupday==2){
$calendar_day='hét';
}else if ($allowable_pickupday==3){
$calendar_day='ked';
}else if ($allowable_pickupday==4){
$calendar_day='sze';
}else if ($allowable_pickupday==5){
$calendar_day='csü';
}else if ($allowable_pickupday==6){
$calendar_day='pén';
}else if ($allowable_pickupday==7){
$calendar_day='szo';
}else {
$calendar_day='';
}
}
/*Dutch*/
else if($currentlang == 'nl_NL')
{
if ($allowable_pickupday==1){	
$calendar_day='zo';
}else if ($allowable_pickupday==2){
$calendar_day='ma';
}else if ($allowable_pickupday==3){
$calendar_day='di';
}else if ($allowable_pickupday==4){
$calendar_day='wo';
}else if ($allowable_pickupday==5){
$calendar_day='do';
}else if ($allowable_pickupday==6){
$calendar_day='vr';
}else if ($allowable_pickupday==7){
$calendar_day='za';
}else {
$calendar_day='';
}
}
/*Portuguese*/
else if($currentlang == 'pt_PT')
{
if ($allowable_pickupday==1){	
$calendar_day='Dom';
}else if ($allowable_pickupday==2){
$calendar_day='Seg';
}else if ($allowable_pickupday==3){
$calendar_day='Ter';
}else if ($allowable_pickupday==4){
$calendar_day='Qua';
}else if ($allowable_pickupday==5){
$calendar_day='Qui';
}else if ($allowable_pickupday==6){
$calendar_day='Sex';
}else if ($allowable_pickupday==7){
$calendar_day='Sáb';
}else {
$calendar_day='';
}
}
/*Slovak*/
else if($currentlang == 'sk_SK')
{
if ($allowable_pickupday==1){	
$calendar_day='Ne';
}else if ($allowable_pickupday==2){
$calendar_day='Po';
}else if ($allowable_pickupday==3){
$calendar_day='Ut';
}else if ($allowable_pickupday==4){
$calendar_day='St';
}else if ($allowable_pickupday==5){
$calendar_day='Št';
}else if ($allowable_pickupday==6){
$calendar_day='Pi';
}else if ($allowable_pickupday==7){
$calendar_day='So';
}else {
$calendar_day='';
}
}
/*Finnish*/
else if($currentlang == 'fi')
{
if ($allowable_pickupday==1){	
$calendar_day='su';
}else if ($allowable_pickupday==2){
$calendar_day='ma';
}else if ($allowable_pickupday==3){
$calendar_day='ti';
}else if ($allowable_pickupday==4){
$calendar_day='ke';
}else if ($allowable_pickupday==5){
$calendar_day='to';
}else if ($allowable_pickupday==6){
$calendar_day='pe';
}else if ($allowable_pickupday==7){
$calendar_day='la';
}else {
$calendar_day='';
}
}	
else
{
if ($allowable_pickupday==1){	
$calendar_day='Sun';
}else if ($allowable_pickupday==2){
$calendar_day='Mon';
}else if ($allowable_pickupday==3){
$calendar_day='Tue';
}else if ($allowable_pickupday==4){
$calendar_day='Wed';
}else if ($allowable_pickupday==5){
$calendar_day='Thu';
}else if ($allowable_pickupday==6){
$calendar_day='Fri';
}else if ($allowable_pickupday==7){
$calendar_day='Sat';
}else {
$calendar_day='';
}
}
$string_for_pickupdays_js_array=$string_for_pickupdays_js_array.'"'.$calendar_day.'",';
}
$allowable_pickup_days_js_array='['.trim($string_for_pickupdays_js_array).']';
}
// get allowable delivery days
$byconsolewooodt_deliverydays_array=get_option('byconsolewooodt_delivery_days');
$string_for_deliverydays_js_array='';
$allowable_delivery_days_js_array='';
if(!empty($byconsolewooodt_deliverydays_array)){
foreach($byconsolewooodt_deliverydays_array as $allowable_deliveryday){
/*if($currentlang == 'en_US')
{
if ($allowable_deliveryday==1){
$calendar_day='Sun';
}else if ($allowable_deliveryday==2){	
$calendar_day='Mon';
}else if ($allowable_deliveryday==3){	
$calendar_day='Tue';
}else if ($allowable_deliveryday==4){	
$calendar_day='Wed';
}else if ($allowable_deliveryday==5){	
$calendar_day='Thu';	
}else if ($allowable_deliveryday==6){	
$calendar_day='Fri';
}else if ($allowable_deliveryday==7){	
$calendar_day='Sat';
}else {	
$calendar_day='';
}
}*/
/*English*/
if($currentlang == 'en_US')
{
if ($allowable_deliveryday==1){
$calendar_day='Sun';	
}else if ($allowable_deliveryday==2){	
$calendar_day='Mon';	
}else if ($allowable_deliveryday==3){	
$calendar_day='Tue';	
}else if ($allowable_deliveryday==4){	
$calendar_day='Wed';	
}else if ($allowable_deliveryday==5){	
$calendar_day='Thu';	
}else if ($allowable_deliveryday==6){	
$calendar_day='Fri';	
}else if ($allowable_deliveryday==7){	
$calendar_day='Sat';	
}else {	
$calendar_day='';	
}
}
/*deutsch(sie)*/
else if($currentlang == 'de_DE_formal' || $currentlang == 'de_DE')
{
if ($allowable_deliveryday==1){	
$calendar_day='So';
}else if ($allowable_deliveryday==2){
$calendar_day='Mo';
}else if ($allowable_deliveryday==3){
$calendar_day='Di';
}else if ($allowable_deliveryday==4){
$calendar_day='Mi';
}else if ($allowable_deliveryday==5){
$calendar_day='Do';
}else if ($allowable_deliveryday==6){
$calendar_day='Fr';
}else if ($allowable_deliveryday==7){
$calendar_day='Sa';
}else {
$calendar_day='';
}
}
/*Español --  Spanish*/
/*else if($currentlang == 'es_ES')
{
if ($allowable_deliveryday==1){	
$calendar_day='Dom';
}else if ($allowable_deliveryday==2){
$calendar_day='Lun';
}else if ($allowable_deliveryday==3){
$calendar_day='Mar';
}else if ($allowable_deliveryday==4){
$calendar_day='Mié';
}else if ($allowable_deliveryday==5){
$calendar_day='Jue';
}else if ($allowable_deliveryday==6){
$calendar_day='Vie';
}else if ($allowable_deliveryday==7){
$calendar_day='sáb';
}else {
$calendar_day='';
}
}*/
/*deutsch(schweiz)*/
else if($currentlang =='de_CH')
{
if ($allowable_deliveryday==1){	
$calendar_day='So';
}else if ($allowable_deliveryday==2){
$calendar_day='Mo';
}else if ($allowable_deliveryday==3){
$calendar_day='Di';
}else if ($allowable_deliveryday==4){
$calendar_day='Mi';
}else if ($allowable_deliveryday==5){
$calendar_day='Do';
}else if ($allowable_deliveryday==6){
$calendar_day='Fr';
}else if ($allowable_deliveryday==7){
$calendar_day='Sa';
}else {
$calendar_day='';
}
}
/*Danish*/
else if($currentlang == 'da_DK')
{
if ($allowable_pickupday==1){	
$calendar_day='søn';
}else if ($allowable_pickupday==2){
$calendar_day='man';
}else if ($allowable_pickupday==3){
$calendar_day='tirs';
}else if ($allowable_pickupday==4){
$calendar_day='ons';
}else if ($allowable_pickupday==5){
$calendar_day='tors';
}else if ($allowable_pickupday==6){
$calendar_day='fre';
}else if ($allowable_pickupday==7){
$calendar_day='lør';
}else {
$calendar_day='';
}
}
/*French*/
else if($currentlang == 'fr_FR')
{
if ($allowable_deliveryday==1){	
$calendar_day='dim';
}else if ($allowable_deliveryday==2){
$calendar_day='lun';
}else if ($allowable_deliveryday==3){
$calendar_day='mar';
}else if ($allowable_deliveryday==4){
$calendar_day='mer';
}else if ($allowable_deliveryday==5){
$calendar_day='jeu';
}else if ($allowable_deliveryday==6){
$calendar_day='ven';
}else if ($allowable_deliveryday==7){
$calendar_day='sam';
}else {
$calendar_day='';
}
}
/*Italian*/
else if($currentlang == 'it_IT')
{
if ($allowable_deliveryday==1){	
$calendar_day='dom';
}else if ($allowable_deliveryday==2){
$calendar_day='lun';
}else if ($allowable_deliveryday==3){
$calendar_day='mar';
}else if ($allowable_deliveryday==4){
$calendar_day='mer';
}else if ($allowable_deliveryday==5){
$calendar_day='gio';
}else if ($allowable_deliveryday==6){
$calendar_day='ven';
}else if ($allowable_deliveryday==7){
$calendar_day='sab';
}else {
$calendar_day='';
}
}
/*Croatian*/
else if($currentlang == 'hr')
{
if ($allowable_deliveryday==1){	
$calendar_day='Ned';
}else if ($allowable_deliveryday==2){
$calendar_day='Pon';
}else if ($allowable_deliveryday==3){
$calendar_day='Uto';
}else if ($allowable_deliveryday==4){
$calendar_day='Sri';
}else if ($allowable_deliveryday==5){
$calendar_day='Čet';
}else if ($allowable_deliveryday==6){
$calendar_day='Pet';
}else if ($allowable_deliveryday==7){
$calendar_day='Sub';
}else {
$calendar_day='';
}
}
/*Romanian*/
else if($currentlang == 'ro_RO')
{
if ($allowable_deliveryday==1){	
$calendar_day='Dum';
}else if ($allowable_deliveryday==2){
$calendar_day='lun';
}else if ($allowable_deliveryday==3){
$calendar_day='mar';
}else if ($allowable_deliveryday==4){
$calendar_day='mie';
}else if ($allowable_deliveryday==5){
$calendar_day='joi';
}else if ($allowable_deliveryday==6){
$calendar_day='vin';
}else if ($allowable_deliveryday==7){
$calendar_day='sâm';
}else {
$calendar_day='';
}
}
/*Bulgarian*/
else if($currentlang =='bg_BG')
{
if ($allowable_deliveryday==1){	
$calendar_day='нд';
}else if ($allowable_deliveryday==2){
$calendar_day='пн';
}else if ($allowable_deliveryday==3){
$calendar_day='вт';
}else if ($allowable_deliveryday==4){
$calendar_day='ср';
}else if ($allowable_deliveryday==5){
$calendar_day='чт';
}else if ($allowable_deliveryday==6){
$calendar_day='пт';
}else if ($allowable_deliveryday==7){
$calendar_day='сб';
}else {
$calendar_day='';
}
}
/*Czech*/
else if($currentlang =='cs_CZ')
{
if ($allowable_deliveryday==1){	
$calendar_day='Ne';
}else if ($allowable_deliveryday==2){
$calendar_day='Po';
}else if ($allowable_deliveryday==3){
$calendar_day='Út';
}else if ($allowable_deliveryday==4){
$calendar_day='St';
}else if ($allowable_deliveryday==5){
$calendar_day='Čt';
}else if ($allowable_deliveryday==6){
$calendar_day='Pá';
}else if ($allowable_deliveryday==7){
$calendar_day='So';
}else {
$calendar_day='';
}
}
/*Hungarian*/
else if($currentlang == 'hu_HU')
{
if ($allowable_deliveryday==1){	
$calendar_day='vas';
}else if ($allowable_deliveryday==2){
$calendar_day='hét';
}else if ($allowable_deliveryday==3){
$calendar_day='ked';
}else if ($allowable_deliveryday==4){
$calendar_day='sze';
}else if ($allowable_deliveryday==5){
$calendar_day='csü';
}else if ($allowable_deliveryday==6){
$calendar_day='pén';
}else if ($allowable_deliveryday==7){
$calendar_day='szo';
}else {
$calendar_day='';
}
}
/*Dutch*/
else if($currentlang == 'nl_NL')
{
if ($allowable_deliveryday==1){	
$calendar_day='zo';
}else if ($allowable_deliveryday==2){
$calendar_day='ma';
}else if ($allowable_deliveryday==3){
$calendar_day='di';
}else if ($allowable_deliveryday==4){
$calendar_day='wo';
}else if ($allowable_deliveryday==5){
$calendar_day='do';
}else if ($allowable_deliveryday==6){
$calendar_day='vr';
}else if ($allowable_deliveryday==7){
$calendar_day='za';
}else {
$calendar_day='';
}
}
/*Portuguese*/
else if($currentlang == 'pt_PT')
{
if ($allowable_deliveryday==1){	
$calendar_day='Dom';
}else if ($allowable_deliveryday==2){
$calendar_day='Seg';
}else if ($allowable_deliveryday==3){
$calendar_day='Ter';
}else if ($allowable_deliveryday==4){
$calendar_day='Qua';
}else if ($allowable_deliveryday==5){
$calendar_day='Qui';
}else if ($allowable_deliveryday==6){
$calendar_day='Sex';
}else if ($allowable_deliveryday==7){
$calendar_day='Sáb';
}else {
$calendar_day='';
}
}
/*Slovak*/
else if($currentlang == 'sk_SK')
{
if ($allowable_deliveryday==1){	
$calendar_day='Ne';
}else if ($allowable_deliveryday==2){
$calendar_day='Po';
}else if ($allowable_deliveryday==3){
$calendar_day='Ut';
}else if ($allowable_deliveryday==4){
$calendar_day='St';
}else if ($allowable_deliveryday==5){
$calendar_day='Št';
}else if ($allowable_deliveryday==6){
$calendar_day='Pi';
}else if ($allowable_deliveryday==7){
$calendar_day='So';
}else {
$calendar_day='';
}
}
/*Finnish*/
else if($currentlang == 'fi')
{
if ($allowable_deliveryday==1){	
$calendar_day='su';
}else if ($allowable_deliveryday==2){
$calendar_day='ma';
}else if ($allowable_deliveryday==3){
$calendar_day='ti';
}else if ($allowable_deliveryday==4){
$calendar_day='ke';
}else if ($allowable_deliveryday==5){
$calendar_day='to';
}else if ($allowable_deliveryday==6){
$calendar_day='pe';
}else if ($allowable_deliveryday==7){
$calendar_day='la';
}else {
$calendar_day='';
}
}	
else
{
if ($allowable_deliveryday==1){	
$calendar_day='Sun';
}else if ($allowable_deliveryday==2){
$calendar_day='Mon';
}else if ($allowable_deliveryday==3){
$calendar_day='Tue';
}else if ($allowable_deliveryday==4){
$calendar_day='Wed';
}else if ($allowable_deliveryday==5){
$calendar_day='Thu';
}else if ($allowable_deliveryday==6){
$calendar_day='Fri';
}else if ($allowable_deliveryday==7){
$calendar_day='Sat';
}else {
$calendar_day='';
}
}
$string_for_deliverydays_js_array=$string_for_deliverydays_js_array.'"'.$calendar_day.'",';
}
$allowable_delivery_days_js_array='['.trim($string_for_deliverydays_js_array).']';
}
?>
<script>
// Selectd  Holiday Diasable Start
function checkHolidaysDates( date ){
var $return=true;
var $returnclass ="available";
//alert(date);
//echo 'var $shopCloseDates = new Array('.$holiday_string.');';
var $shopCloseDates = new Array(
//creating array for javascript holidays
<?php 
$stat_i=1;
$date_i=count($national_and_casual_holiday_marge);
foreach($national_and_casual_holiday_marge as $deactive_holiday_from_calender_array_single)
{
echo '"'.trim($deactive_holiday_from_calender_array_single).'"';
//handle the last comma(,)
if($stat_i<$date_i){
echo ',';
}
$stat_i++;
}
?>
);
$checkdate = jQuery.datepicker.formatDate("mm/dd/yy", date);
$checkday	= jQuery.datepicker.formatDate("D", date);
for(var i = 0; i < $shopCloseDates.length; i++)
{   
if($shopCloseDates[i] == $checkdate)
{
$return = false;
$returnclass= "unavailable shopholiday";
}
// next step is to check shop closed days by day
var day = date.getDay();
if(day == <?php echo $sunday; ?> || day == <?php echo $monday; ?> || day == <?php echo $tuesday; ?> || day == <?php echo $wednessday; ?> || day == <?php echo $thursday; ?> || day == <?php echo $friday; ?> || day == <?php echo $saturday; ?>)
{
$return = false;
$returnclass= "unavailable shopclosingday";
}
}
<?php
// do selection disable on closing days as per allowable pickup days settings
if($byconsolewooodt_delivery_widget_cookie_array['byconsolewooodt_widget_type_field']=='take_away' && !empty($allowable_pickup_days_js_array)){
?>
if(jQuery.inArray($checkday,<?php echo $allowable_pickup_days_js_array;?>)==-1){
$return = false;
$returnclass= "unavailable abc";
//alert('in condition 1');
}
<?php
}
// do selection disable on closing days as per allowable delivery days settings
if($byconsolewooodt_delivery_widget_cookie_array['byconsolewooodt_widget_type_field']=='levering' && !empty($allowable_delivery_days_js_array)){
?>
if(jQuery.inArray($checkday,<?php echo $allowable_delivery_days_js_array;?>)==-1){
$return = false;
$returnclass= "unavailable def";
//alert('in condition 2');
}
<?php 
}
?>
//function return value
return [$return,$returnclass];
}// Selectd  Holiday Diasable End
jQuery(document).ready(function(){
<?php
if(get_option('byconsolewooodt_preorder_days')==''){// if no pre-order date is not set in settings page
?>
jQuery(".byconsolewooodt_widget_date_field").datepicker({
<?php 
$mindate=get_option('byconsolewooodt_restricted_preorder_days');
if(!empty($mindate) || $mindate!=0 ){
$mindate=$mindate;
}else{
$mindate=0;	
}?>
minDate: <?php echo $mindate;?>, 
showAnim: "slideDown", 
dateFormat: "mm/dd/yy",
beforeShowDay: function(date){ return checkHolidaysDates( date ); },
onSelect: function(){
jQuery(".byconsolewooodt_widget_time_field").timepicker("remove"); 
jQuery(".byconsolewooodt_widget_time_field").val(''); 
<?php
if($byconsolewooodt_delivery_widget_cookie_array['byconsolewooodt_widget_type_field']=='levering'){
$is_location_enabled=get_option('byconsolewooodt_multiple_delivery_location');	
$location_field_to_pass='byconsolewooodt_widget_delivery_location';
}
if($byconsolewooodt_delivery_widget_cookie_array['byconsolewooodt_widget_type_field']=='take_away'){
$is_location_enabled=get_option('byconsolewooodt_multiple_pickup_location');
$location_field_to_pass='byconsolewooodt_widget_pickup_location';
}
if($is_location_enabled=='YES'){?>
selected_location_eligibility_to_pass_for_datepicker=document.getElementById('<?php echo $location_field_to_pass;?>');
//alert(selected_location_eligibility_to_pass_for_datepicker);
<?php }else{?>
selected_location_eligibility_to_pass_for_datepicker='location_is_disabled';
<?php }?>
ByconsolewooodtDeliveryWidgetTimePopulate(".byconsolewooodt_widget_date_field",".byconsolewooodt_widget_time_field",selected_location_eligibility_to_pass_for_datepicker);
} 
});
<?php
}else{//end of if no pre-order date is set in settings page do the date selection restriction
?>
jQuery( ".byconsolewooodt_widget_date_field" ).datepicker({ 
<?php 
$mindate=get_option('byconsolewooodt_restricted_preorder_days');
if(!empty($mindate) || $mindate!=0 ){
$mindate=$mindate;
}else{
$mindate=0;	
}?>
minDate: <?php echo $mindate;?>, 
maxDate: "<?php echo get_option('byconsolewooodt_preorder_days');?>+D", 
showOtherMonths: true,
selectOtherMonths: true,
showAnim: "slideDown",
dateFormat: "mm/dd/yy",
/*beforeShowDay: checkHolidaysDates( date ),*/
beforeShowDay: function(date){ return checkHolidaysDates( date ); },
onSelect: function(){
jQuery(".byconsolewooodt_widget_time_field").timepicker("remove"); 
jQuery(".byconsolewooodt_widget_time_field").val(''); 
<?php
if($byconsolewooodt_delivery_widget_cookie_array['byconsolewooodt_widget_type_field']=='levering'){
$is_location_enabled=get_option('byconsolewooodt_multiple_delivery_location');	
$location_field_to_pass='byconsolewooodt_widget_delivery_location';
}
if($byconsolewooodt_delivery_widget_cookie_array['byconsolewooodt_widget_type_field']=='take_away'){
$is_location_enabled=get_option('byconsolewooodt_multiple_pickup_location');
$location_field_to_pass='byconsolewooodt_widget_pickup_location';
}
if($is_location_enabled=='YES'){?>
selected_location_eligibility_to_pass_for_datepicker=document.getElementById('<?php echo $location_field_to_pass;?>');
//alert(selected_location_eligibility_to_pass_for_datepicker);
<?php }else{?>
selected_location_eligibility_to_pass_for_datepicker='location_is_disabled';
<?php }?>
ByconsolewooodtDeliveryWidgetTimePopulate(".byconsolewooodt_widget_date_field",".byconsolewooodt_widget_time_field",selected_location_eligibility_to_pass_for_datepicker);
// this variable 'selected_location_eligibility_to_pass_for_datepicker' is created when location was selected, make sure location have to be clicked before date selection in case og location enabled 
}
});
<?php
}	
//synchornize both the delivery type radio button in widget and in checkout field in simple way
if($byconsolewooodt_delivery_widget_cookie_array['byconsolewooodt_widget_type_field']=='levering'){
?>
jQuery("#byconsolewooodt_delivery_type_levering").prop("checked", true);
<?php
}
if($byconsolewooodt_delivery_widget_cookie_array['byconsolewooodt_widget_type_field']=='take_away'){
?>
jQuery("#byconsolewooodt_delivery_type_take_away").prop("checked", true);
<?php
}
?>
jQuery("input#byconsolewooodt_delivery_date").val("<?php echo $byconsolewooodt_delivery_widget_cookie_array['byconsolewooodt_widget_date_field'];?>");
jQuery("input#byconsolewooodt_delivery_time").val("<?php echo $byconsolewooodt_delivery_widget_cookie_array['byconsolewooodt_widget_time_field'];?>");
})
</script>
<?php
if(is_checkout()){// execute on woocommerce check out page only
?>
<script>
jQuery(document).ready(function(){
// call time drop-diwn generator on change of location
jQuery('#byconsolewooodt_pickup_location').change(function(){
ByconsolewooodtDeliveryWidgetTimePopulate('#byconsolewooodt_delivery_date','#byconsolewooodt_delivery_time',this);
});
jQuery('#byconsolewooodt_delivery_location').change(function(){
ByconsolewooodtDeliveryWidgetTimePopulate('#byconsolewooodt_delivery_date','#byconsolewooodt_delivery_time',this);
});
jQuery('#byconsolewooodt_delivery_time').after( '<p id="byconsolewooodt_delivery_time_service_closed_notice"></p>' );
jQuery("#byconsolewooodt_pickup_location").prepend("<option value='' selected='selected'>Select pick-up location</option>");	
jQuery("#byconsolewooodt_delivery_location").prepend("<option value='' selected='selected'>Select delivery location</option>");
<?php
if(get_option('byconsolewooodt_preorder_days')==''){// if no pre-order date is not set in settings page
?>
jQuery("#byconsolewooodt_delivery_date").datepicker({
<?php 
$mindate=get_option('byconsolewooodt_restricted_preorder_days');
if(!empty($mindate) || $mindate!=0 ){
$mindate=$mindate;
}else{
$mindate=0;	
}?>
minDate: <?php echo $mindate;?>, 
showAnim: "slideDown", 
dateFormat: "mm/dd/yy",
beforeShowDay: function(date){ return checkHolidaysDates( date ); },
onSelect: function(){
jQuery(".byconsolewooodt_widget_time_field").timepicker("remove"); 
jQuery(".byconsolewooodt_widget_time_field").val(''); 
<?php
if($byconsolewooodt_delivery_widget_cookie_array['byconsolewooodt_widget_type_field']=='levering'){
$is_location_enabled=get_option('byconsolewooodt_multiple_delivery_location');	
$location_field_to_pass='byconsolewooodt_delivery_location';
}
if($byconsolewooodt_delivery_widget_cookie_array['byconsolewooodt_widget_type_field']=='take_away'){
$is_location_enabled=get_option('byconsolewooodt_multiple_pickup_location');
$location_field_to_pass='byconsolewooodt_pickup_location';
}
if($is_location_enabled=='YES'){?>
selected_location_eligibility_to_pass_for_datepicker=document.getElementById('<?php echo $location_field_to_pass;?>');
<?php }else{?>
selected_location_eligibility_to_pass_for_datepicker='location_is_disabled';
<?php }?>
ByconsolewooodtDeliveryWidgetTimePopulate("#byconsolewooodt_delivery_date","#byconsolewooodt_delivery_time",selected_location_eligibility_to_pass_for_datepicker);
// this variable 'selected_location_eligibility_to_pass_for_datepicker' is created when location was selected, make sure location have to be clicked before date selection in case og location enabled 
}
});
<?php
}else{//end of if no pre-order date is set in settings page do the date selection restriction
?>
jQuery( "#byconsolewooodt_delivery_date" ).datepicker({ 
<?php 
$mindate=get_option('byconsolewooodt_restricted_preorder_days');
if(!empty($mindate) || $mindate!=0 ){
$mindate=$mindate;
}else{
$mindate=0;	
}?>
minDate: <?php echo $mindate;?>, 
maxDate: "<?php echo get_option('byconsolewooodt_preorder_days');?>+D", 
showOtherMonths: true,
selectOtherMonths: true,
showAnim: "slideDown",
dateFormat: "mm/dd/yy",
/*beforeShowDay: checkHolidaysDates( date ),*/
beforeShowDay: function(date){ return checkHolidaysDates( date ); },
onSelect: function(){
jQuery(".byconsolewooodt_widget_time_field").timepicker("remove"); 
jQuery(".byconsolewooodt_widget_time_field").val(''); 
<?php
if($byconsolewooodt_delivery_widget_cookie_array['byconsolewooodt_widget_type_field']=='levering'){
$is_location_enabled=get_option('byconsolewooodt_multiple_delivery_location');	
$location_field_to_pass='byconsolewooodt_delivery_location';
}
if($byconsolewooodt_delivery_widget_cookie_array['byconsolewooodt_widget_type_field']=='take_away'){
$is_location_enabled=get_option('byconsolewooodt_multiple_pickup_location');
$location_field_to_pass='byconsolewooodt_pickup_location';
}
if($is_location_enabled=='YES'){?>
selected_location_eligibility_to_pass_for_datepicker=document.getElementById('<?php echo $location_field_to_pass;?>');
<?php }else{?>
selected_location_eligibility_to_pass_for_datepicker='location_is_disabled';
<?php }?>
ByconsolewooodtDeliveryWidgetTimePopulate("#byconsolewooodt_delivery_date","#byconsolewooodt_delivery_time",selected_location_eligibility_to_pass_for_datepicker);
// this variable 'selected_location_eligibility_to_pass_for_datepicker' is created when location was selected, make sure location have to be clicked before date selection in case og location enabled 
}
});
<?php
}	
//synchornize both the delivery type radio button in widget and in checkout field in simple way
if($byconsolewooodt_delivery_widget_cookie_array['byconsolewooodt_widget_type_field']=='levering'){
?>
jQuery("#byconsolewooodt_delivery_type_levering").prop("checked", true);
<?php
}
if($byconsolewooodt_delivery_widget_cookie_array['byconsolewooodt_widget_type_field']=='take_away'){
?>
jQuery("#byconsolewooodt_delivery_type_take_away").prop("checked", true);
<?php
}
?>
jQuery("input#byconsolewooodt_delivery_date").val("<?php echo $byconsolewooodt_delivery_widget_cookie_array['byconsolewooodt_widget_date_field'];?>");
jQuery("input#byconsolewooodt_delivery_time").val("<?php echo $byconsolewooodt_delivery_widget_cookie_array['byconsolewooodt_widget_time_field'];?>");
})
</script>	
<?php
// refresh the page once delivery type is changed and if the checkout page dont have the widget present (if it has widget present it will be refresh by widget itself)
//check if it is checkout page
//check if widget is present on checkout page
if ( !is_active_widget( false, false, 'byconsolewooodt_widget', true ) ) {
//if widget is not present create it and make it hidden (coz we have to refresh the page by widget submit)
echo '<div style="display:none;">';
echo '<!-- do not remove it -->';
the_widget( 'byconsolewooodt_widget' );
echo '</div>';
}
}// !is_checkout///  Calender Tooltip jQuery Start..
?>
<script>
jQuery(document).on('mouseover','.shopholiday',function(){ 
jQuery(this).prepend('<span class="shopholidaycaltooltip"><?php echo get_option('byconsolewooodt_calender_holiday_lable');?></span>');
jQuery(this).addClass("shopholidaybackgroundcol");
});
jQuery(document).on('mouseout','.shopholiday', function(){ 
jQuery(".shopholidaycaltooltip").remove();
jQuery(this).removeClass("shopholidaybackgroundcol");
});
jQuery(document).on('mouseover','.shopclosingday',function(){ 
jQuery(this).prepend('<span class="shopclosingdaycaltooltip"><?php echo get_option('byconsolewooodt_calender_closing_lable');?></span>');
jQuery(this).addClass("shopclosingdaybackgroundcol");
});
jQuery(document).on('mouseout','.shopclosingday', function(){ 
jQuery(".shopclosingdaycaltooltip").remove();
jQuery(this).removeClass("shopclosingdaybackgroundcol");
});
jQuery(document).on('mouseover','.ui-datepicker-unselectable',function(){ 
if(jQuery(this).not('.shopholiday') || jQuery(this).not('.shopclosingday'))
{
jQuery(this).addClass("ordernotallowed");
jQuery(this).prepend('<span class="ordernotallowedtooltip"><?php echo get_option('byconsolewooodt_calender_pick_notallowed_lable');?></span>');
//jQuery(this).addClass("datenotpickedbackgroundcol");
}
});
jQuery(document).on('mouseout','.ui-datepicker-unselectable',function(){ 
if(jQuery(this).not('.shopholiday') || jQuery(this).not('.shopclosingday'))
{
jQuery(this).removeClass("ordernotallowed");
jQuery(".ordernotallowedtooltip").remove();
//jQuery(this).removeClass("datenotpickedbackgroundcol");
}
});
</script> <!---Calender Tooltip jQuery End.. --><style>
/*********************** Shop Holiday Start ****************************/
.shopholiday {
-webkit-transform: translateZ(0); /* webkit flicker fix */
-webkit-font-smoothing: antialiased; /* webkit text rendering fix */
}
.shopholidaybackgroundcol{background-color:#<?php echo get_option('byconsolewooodt_calender_holiday_tooltip_background_color');?>;}
/*.ui-state-disabled, .ui-widget-content .ui-state-disabled, .ui-widget-header .shopholidaycaltooltip{opacity: 1.35 !important;}*/
.shopholiday .shopholidaycaltooltip {
background: #<?php echo get_option('byconsolewooodt_calender_holiday_tooltip_background_color');?> !important;
bottom: 100%;
color: #<?php echo get_option('byconsolewooodt_calender_holiday_tooltip_text_color');?> !important;
display: block;
text-align:center;
margin-bottom: 5px;
opacity: 0;
font-size: 12px;
padding: 5px 3px;
pointer-events: none;
position: absolute;
width: 100px;
-webkit-transform: translateY(10px);
-moz-transform: translateY(10px);
-ms-transform: translateY(10px);
-o-transform: translateY(10px);
transform: translateY(10px);
-webkit-transition: all .25s ease-out;
-moz-transition: all .25s ease-out;
-ms-transition: all .25s ease-out;
-o-transition: all .25s ease-out;
transition: all .25s ease-out;
-webkit-box-shadow: 2px 2px 6px rgba(0, 0, 0, 0.28);
-moz-box-shadow: 2px 2px 6px rgba(0, 0, 0, 0.28);
-ms-box-shadow: 2px 2px 6px rgba(0, 0, 0, 0.28);
-o-box-shadow: 2px 2px 6px rgba(0, 0, 0, 0.28);
box-shadow: 2px 2px 6px rgba(0, 0, 0, 0.28);
}
/* This bridges the gap so you can mouse into the tooltip without it disappearing */
.shopholiday .shopholidaycaltooltip:before {
bottom: -20px;
content: " ";
display: block;
height: 20px;
left: 0;
position: absolute;
width: 100%;
}  
.shopholiday:hover .shopholidaycaltooltip {
opacity: 1;
pointer-events: auto;
-webkit-transform: translateY(0px);
-moz-transform: translateY(0px);
-ms-transform: translateY(0px);
-o-transform: translateY(0px);
transform: translateY(0px);
}
/* IE can just show/hide with no transition */
.lte8 .shopholiday .shopholidaycaltooltip {
display: none;
}
.lte8 .shopholiday:hover .shopholidaycaltooltip {
display: block;
}/********************** Shop Closing Day Start**********************************/
.shopclosingday { 
-webkit-transform: translateZ(0); /* webkit flicker fix */
-webkit-font-smoothing: antialiased; /* webkit text rendering fix */
}
.shopclosingdaybackgroundcol{background-color:#<?php echo get_option('byconsolewooodt_calender_closing_tooltip_background_color');?>;}
/*.ui-state-disabled, .ui-widget-content .ui-state-disabled, .ui-widget-header .shopclosingdaycaltooltip{opacity: 1.35 !important;}*/
.shopclosingday .shopclosingdaycaltooltip {
background: #<?php echo get_option('byconsolewooodt_calender_closing_tooltip_background_color');?> !important;
bottom: 100%;
color: #<?php echo get_option('byconsolewooodt_calender_closing_tooltip_text_color');?> !important;
display: block;
text-align:center;
margin-bottom: 5px;
opacity: 1.35 !important;
font-size: 12px;
padding: 5px 3px;
pointer-events: none;
position: absolute;
width: 100px;
-webkit-transform: translateY(10px);
-moz-transform: translateY(10px);
-ms-transform: translateY(10px);
-o-transform: translateY(10px);
transform: translateY(10px);
-webkit-transition: all .25s ease-out;
-moz-transition: all .25s ease-out;
-ms-transition: all .25s ease-out;
-o-transition: all .25s ease-out;
transition: all .25s ease-out;
-webkit-box-shadow: 2px 2px 6px rgba(0, 0, 0, 0.28);
-moz-box-shadow: 2px 2px 6px rgba(0, 0, 0, 0.28);
-ms-box-shadow: 2px 2px 6px rgba(0, 0, 0, 0.28);
-o-box-shadow: 2px 2px 6px rgba(0, 0, 0, 0.28);
box-shadow: 2px 2px 6px rgba(0, 0, 0, 0.28);
}
/* This bridges the gap so you can mouse into the tooltip without it disappearing */
.shopclosingday .shopclosingdaycaltooltip:before {
bottom: -20px;
content: " ";
display: block;
height: 20px;
left: 0;
position: absolute;
width: 100%;
}  
.shopclosingday:hover .shopclosingdaycaltooltip {
opacity: 1;
pointer-events: auto;
-webkit-transform: translateY(0px);
-moz-transform: translateY(0px);
-ms-transform: translateY(0px);
-o-transform: translateY(0px);
transform: translateY(0px);
}
/* IE can just show/hide with no transition */
.lte8 .shopclosingday .shopclosingdaycaltooltip {
display: none;
}
.lte8 .shopclosingday:hover .shopclosingdaycaltooltip {
display: block;
}
/***********************Date Pick Not Allowed Start*********************************/.ordernotallowed {
-webkit-transform: translateZ(0); /* webkit flicker fix */
-webkit-font-smoothing: antialiased; /* webkit text rendering fix */
opacity: 1.35 !important;
}
/*.datenotpickedbackgroundcol{background-color:#<?php echo get_option('byconsolewooodt_calender_pick_notallowed_tooltip_background_color');?>;}*/
/*.ui-state-disabled, .ui-widget-content .ui-state-disabled, .ui-widget-header .shopclosingdaycaltooltip{opacity: 1.35 !important;}*/
.ordernotallowed .ordernotallowedtooltip {
background: #<?php echo get_option('byconsolewooodt_calender_pick_notallowed_tooltip_background_color');?> !important;
bottom: 100%;
color: #<?php echo get_option('byconsolewooodt_calender_pick_notallowed_tooltip_text_color');?> !important;
display: block;
text-align:center;
margin-bottom: 5px;
opacity: 1.35 !important;
font-size: 12px;
padding: 5px 3px;
pointer-events: none;
position: absolute;
width: 100px;
-webkit-transform: translateY(10px);
-moz-transform: translateY(10px);
-ms-transform: translateY(10px);
-o-transform: translateY(10px);
transform: translateY(10px);
-webkit-transition: all .25s ease-out;
-moz-transition: all .25s ease-out;
-ms-transition: all .25s ease-out;
-o-transition: all .25s ease-out;
transition: all .25s ease-out;
-webkit-box-shadow: 2px 2px 6px rgba(0, 0, 0, 0.28);
-moz-box-shadow: 2px 2px 6px rgba(0, 0, 0, 0.28);
-ms-box-shadow: 2px 2px 6px rgba(0, 0, 0, 0.28);
-o-box-shadow: 2px 2px 6px rgba(0, 0, 0, 0.28);
box-shadow: 2px 2px 6px rgba(0, 0, 0, 0.28);
}
/* This bridges the gap so you can mouse into the tooltip without it disappearing */
.ordernotallowed .ordernotallowedtooltip:before {
bottom: -20px;
content: " ";
display: block;
height: 20px;
left: 0;
position: absolute;
width: 100%;
}  
.ordernotallowed:hover .ordernotallowedtooltip {
opacity: 1;
pointer-events: auto;
-webkit-transform: translateY(0px);
-moz-transform: translateY(0px);
-ms-transform: translateY(0px);
-o-transform: translateY(0px);
transform: translateY(0px);
}
/* IE can just show/hide with no transition */
.lte8 .ordernotallowed .ordernotallowedtooltip {
display: none;
}
.lte8 .ordernotallowed:hover .ordernotallowedtooltip {
display: block;
}.ui-datepicker .ui-datepicker-header{background:#<?php echo get_option('byconsolewooodt_calender_header_color');?> !important;}
.ui-datepicker .ui-datepicker-title{color:#<?php echo get_option('byconsolewooodt_calender_header_text_color');?> !important;}
td.byconsolewooodt_product_pickup_or_delivery_date{font-size:10px !important;}
</style>
<?php
}
add_action('wp_footer','byconsolewooodt_footer_script',9999);
/****************Calling Store Notice*******************/
function byconsolewooodt_store_closed_remove_addtocart()
{
//$todaydate = date("m/d/Y");
$todaydate=current_time('m/d/Y');
$shownotice='none';
$get_all_dates = get_option('byconsolewooodt_admin_holiday_date');
$dateexplode=explode(",",$get_all_dates);	
/*if($current_time<$closing_time && $current_time>$start_time){
$shownotice='byconsolewooodt_store_holiday';
}*/
foreach($dateexplode as $get_single_dates)
{
if($get_single_dates==$todaydate)
{
$shownotice = 'byconsolewooodt_store_holiday';
}
}
if($shownotice==='byconsolewooodt_store_holiday')
{
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
}
else
{
// get todays date 
$gattodayname=date("l");
$gattodaynumericval=date("w");				
$sunday = get_option('byconsolewooodt_admin_closing_sunday');
$monday = get_option('byconsolewooodt_admin_closing_monday');
$tuesday = get_option('byconsolewooodt_admin_closing_tuesday');
$wednessday = get_option('byconsolewooodt_admin_closing_wednessday');
$thursday = get_option('byconsolewooodt_admin_closing_thursday');
$friday = get_option('byconsolewooodt_admin_closing_friday');
$saturday = get_option('byconsolewooodt_admin_closing_saturday');
$sunday = ! empty($sunday) ? $sunday : 99;
$monday = ! empty($monday) ? $monday : 99;
$tuesday = ! empty($tuesday) ? $tuesday : 99;
$wednessday = ! empty($wednessday) ? $wednessday : 99;
$thursday = ! empty($thursday) ? $thursday : 99;
$friday = ! empty($friday) ? $friday : 99;
$saturday = ! empty($saturday) ? $saturday : 99;
if($sunday==$gattodaynumericval || $monday==$gattodaynumericval || $tuesday==$gattodaynumericval || $wednessday==$gattodaynumericval || $thursday==$gattodaynumericval || $friday==$gattodaynumericval || $saturday==$gattodaynumericval)
{
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
}
else 
{
}
}
}
add_action('init','byconsolewooodt_store_closed_remove_addtocart');
// ADDING COLUMN TITLES (Here 1 columns)
add_filter( 'manage_edit-shop_order_columns', 'byconsolewooodt_product_delivery_and_pickup_date_column');
function byconsolewooodt_product_delivery_and_pickup_date_column($columns)
{
//add columns
$byconsolewooodt_order_list_new_columns = (is_array($columns)) ? $columns : array();
unset( $byconsolewooodt_order_list_new_columns['order_actions'] );
$byconsolewooodt_order_list_new_columns['byconsolewooodt_product_pickup_or_delivery_date'] = 'Pickup / Delivery Date';
$byconsolewooodt_order_list_new_columns['order_actions'] = $columns['order_actions'];
return $byconsolewooodt_order_list_new_columns;
}
// adding the data for each orders by column
add_action( 'manage_shop_order_posts_custom_column' , 'byconsolewooodt_product_delivery_and_pickup_date_value',1);
function byconsolewooodt_product_delivery_and_pickup_date_value( $column )
{
global $post, $woocommerce, $the_order;
$order_id = $the_order->id;
if ( $column == 'byconsolewooodt_product_pickup_or_delivery_date' ) 
{
	$productdeliverydate=get_post_meta( $order_id, 'byconsolewooodt_delivery_date', true );
	$formattedproductdeliverydate = get_option('byconsolewooodt_wooodt_date_formate_setting');
		
	$fetch_seleted_date = new DateTime($productdeliverydate);

    echo $byconsolewooodtmyVarOne = $fetch_seleted_date->format($formattedproductdeliverydate);
	
/*$byconsolewooodtmyVarOne = get_post_meta( $order_id, 'byconsolewooodt_delivery_date', true );
echo $byconsolewooodtmyVarOne; */       
}
}
/*// check fopr updates
add_action( 'init', 'byconsolewooodt_activate_extented_copy' );
function byconsolewooodt_activate_extented_copy()
{
//echo 'hi...';
//exit;
require_once ( 'inc/update.php' );
$plugin_current_version = '1.0.2.0';
$plugin_remote_path = 'plugins.byconsole.com/upgrade.php';
echo 'printing plugin slug__';
echo $plugin_slug = plugin_basename(__FILE__);
echo '__Plugin slig end';
$license_user = 'user';
$license_key = 'abcd';
echo 'calling function..';
if ( $license_user && $license_key && $plugin_remote_path )
{
echo '__inside_if___';
new wp_autoupdate ($plugin_current_version, $plugin_remote_path, $plugin_slug, $license_user, $license_key);
}
echo 'function called..';
}*/
?>