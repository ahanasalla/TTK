<?php
	function byconsolewooodt_admin_wooodt_features_settings_form()	
	{
?>    
    <div class="wrap">

			<h1>ByConsole Woocommerce Order Delivery Features Settings</h1>

            

            <form method="post" class="form_byconsolewooodt_wooodt_features_settings" action="options.php">

				<?php

					settings_fields("wooodtfeaturessetting");

					do_settings_sections("byconsolewooodt_wooodt_features_settings_options");      

					submit_button(); 

				?>          

			</form>

	</div>
	<?php
	}

	function byconsolewooodt_wooodt_disable_delivery_date_settings()
	{
		$wooodt_disable_delivery_date = get_option('byconsolewooodt_wooodt_disable_delivery_date');	
	?>
    <div class="closings_by_day">
	<input type="checkbox" name="byconsolewooodt_wooodt_disable_delivery_date" id="byconsolewooodt_wooodt_disable_delivery_date_settings" value="1" <?php if($wooodt_disable_delivery_date == '1') {?> checked="checked" <?php }?>/>
    </div>
    <?php }
	
	function byconsolewooodt_wooodt_disable_delivery_time_settings()
	{
		$wooodt_disable_delivery_time = get_option('byconsolewooodt_wooodt_disable_delivery_time');		
	?>
    <div class="closings_by_day">
	<input type="checkbox" name="byconsolewooodt_wooodt_disable_delivery_time" id="byconsolewooodt_wooodt_disable_delivery_time_settings" value="2" <?php if($wooodt_disable_delivery_time == '2') {?> checked="checked" <?php }?>/>
    </div>
	<?php }
	
	function byconsolewooodt_wooodt_disable_pickup_date_settings()
	{
		$wooodt_disable_pickup_date = get_option('byconsolewooodt_wooodt_disable_pickup_date');	
	?>
    <div class="closings_by_day">
	<input type="checkbox" name="byconsolewooodt_wooodt_disable_pickup_date" id="byconsolewooodt_wooodt_disable_pickup_date_settings" value="3" <?php if($wooodt_disable_pickup_date == '3') {?> checked="checked" <?php }?>/>
    </div>
	<?php }
	
	function byconsolewooodt_wooodt_disable_pickup_time_settings()
	{
		$wooodt_disable_pickup_time = get_option('byconsolewooodt_wooodt_disable_pickup_time');		
	?>
    <div class="closings_by_day">
	<input type="checkbox" name="byconsolewooodt_wooodt_disable_pickup_time" id="byconsolewooodt_wooodt_disable_pickup_time_settings" value="4" <?php if($wooodt_disable_pickup_time == '4') {?> checked="checked" <?php }?>/>
    </div>
    <?php }
	
	function byconsolewooodt_wooodt_date_formate_settings()
	{
		 $wooodt_date_formate = get_option('byconsolewooodt_wooodt_date_formate_setting');		
	?>
    <div class="closings_by_day">
	&nbsp;Y-m-d<input type="radio" name="byconsolewooodt_wooodt_date_formate_setting" id="byconsolewooodt_wooodt_date_formate_settings" value="Y-m-d" <?php if($wooodt_date_formate == 'Y-m-d') { ?>  checked="checked"  <?php }?> /><br />
    &nbsp;d-m-Y<input type="radio" name="byconsolewooodt_wooodt_date_formate_setting" id="byconsolewooodt_wooodt_date_formate_settings" value="d-m-Y" <?php if($wooodt_date_formate == 'd-m-Y') { ?>  checked="checked"  <?php }?>/><br />
   &nbsp;m-d-Y <input type="radio" name="byconsolewooodt_wooodt_date_formate_setting" id="byconsolewooodt_wooodt_date_formate_settings" value="m-d-Y" <?php if($wooodt_date_formate == 'm-d-Y') { ?>  checked="checked"  <?php }?>/><br />
   &nbsp;25th-May-2015 <input type="radio" name="byconsolewooodt_wooodt_date_formate_setting" id="byconsolewooodt_wooodt_date_formate_settings" value="dS-F-Y" <?php if($wooodt_date_formate == 'dS-F-Y') { ?>  checked="checked"  <?php }?>/> 
    </div>
    <?php } 
	
	function byconsolewooodt_as_early_as_possible_and_exact_time_text_lable_enable()
	{?>
		<input type="checkbox" name="byconsolewooodt_as_early_as_possible_and_exact_time_text_lable_enable_mode" id="byconsolewooodt_as_early_as_possible_and_exact_time_text_lable_enable" value="yes" <?php if(get_option('byconsolewooodt_as_early_as_possible_and_exact_time_text_lable_enable_mode') == 'yes') {?> checked="checked" <?php }?>  />
		
	<?php 
	}
	
	function byconsolewooodt_as_early_as_possible_lable()
	{
	?>
    <p id="byconsolewooodt_as_early_as_possible_lable_content">
    <input type="text" name="byconsolewooodt_as_early_as_possible_lable_text" id="byconsolewooodt_as_early_as_possible_lable" style="width:30%; padding:7px;" value="<?php printf( __('%s','ByConsoleWooODTExtended'),get_option('byconsolewooodt_as_early_as_possible_lable_text')); ?>" />	

	 <label> <?php echo __('Displayed as early as possible lebel on checkout page and widget area.','ByConsoleWooODTExtended');?></label>
    </p>
	<?php 
	}
	
	function byconsolewooodt_exact_time_lable()
	{
	?>
    <p id="byconsolewooodt_exact_time_lable_content">
    <input type="text" name="byconsolewooodt_exact_time_lable_text" id="byconsolewooodt_exact_time_lable" style="width:30%; padding:7px;" value="<?php printf( __('%s','ByConsoleWooODTExtended'),get_option('byconsolewooodt_exact_time_lable_text')); ?>" />	

	 <label> <?php echo __('Displayed exact time lebel on checkout page and widget area.','ByConsoleWooODTExtended');?></label>
    </p>
	<?php 
	}
	
		
/**********************************************wooodt features settings Field Start**************************************************************/	

add_action('admin_init', 'byconsolewooodt_wooodt_features_settings_fields');

function byconsolewooodt_wooodt_features_settings_fields()

{
	add_settings_section("wooodtfeaturessetting", "wooodt Features  Settings", null, "byconsolewooodt_wooodt_features_settings_options");
	
	//add_settings_field("byconsolewooodt_wooodt_disable_delivery_date", "Disable Delivery Date:", "byconsolewooodt_wooodt_disable_delivery_date_settings", "byconsolewooodt_wooodt_features_settings_options", "wooodtfeaturessetting");

	//add_settings_field("byconsolewooodt_wooodt_disable_delivery_time", "Disable Delivery Time:", "byconsolewooodt_wooodt_disable_delivery_time_settings", "byconsolewooodt_wooodt_features_settings_options", "wooodtfeaturessetting");	

	//add_settings_field("byconsolewooodt_wooodt_disable_pickup_date", "Disable Pickup Date:", "byconsolewooodt_wooodt_disable_pickup_date_settings", "byconsolewooodt_wooodt_features_settings_options", "wooodtfeaturessetting");
	
	//add_settings_field("byconsolewooodt_wooodt_disable_pickup_time", "Disable Pickup Time:", "byconsolewooodt_wooodt_disable_pickup_time_settings", "byconsolewooodt_wooodt_features_settings_options", "wooodtfeaturessetting");
	
	add_settings_field("byconsolewooodt_wooodt_date_formate_setting", "<p>Date Formate Setting:</p>", "byconsolewooodt_wooodt_date_formate_settings", "byconsolewooodt_wooodt_features_settings_options", "wooodtfeaturessetting");	
	
	add_settings_field("byconsolewooodt_as_early_as_possible_and_exact_time_text_lable_enable", "<p>ASAP text enable mode:</p>", "byconsolewooodt_as_early_as_possible_and_exact_time_text_lable_enable", "byconsolewooodt_wooodt_features_settings_options", "wooodtfeaturessetting");
	
	add_settings_field("byconsolewooodt_as_early_as_possible_lable", "<p>As early as possible text:</p>", "byconsolewooodt_as_early_as_possible_lable", "byconsolewooodt_wooodt_features_settings_options", "wooodtfeaturessetting");
	
	add_settings_field("byconsolewooodt_exact_time_lable", "<p>Exact time text:</p>", "byconsolewooodt_exact_time_lable", "byconsolewooodt_wooodt_features_settings_options", "wooodtfeaturessetting");
	

	//register_setting("wooodtfeaturessetting", "byconsolewooodt_wooodt_disable_delivery_date");

	//register_setting("wooodtfeaturessetting", "byconsolewooodt_wooodt_disable_delivery_time");	

	//register_setting("wooodtfeaturessetting", "byconsolewooodt_wooodt_disable_pickup_date");

	//register_setting("wooodtfeaturessetting", "byconsolewooodt_wooodt_disable_pickup_time");
	
	register_setting("wooodtfeaturessetting", "byconsolewooodt_wooodt_date_formate_setting");
	
	register_setting("wooodtfeaturessetting", "byconsolewooodt_as_early_as_possible_and_exact_time_text_lable_enable_mode");	
	
	register_setting("wooodtfeaturessetting", "byconsolewooodt_as_early_as_possible_lable_text");
	
	register_setting("wooodtfeaturessetting", "byconsolewooodt_exact_time_lable_text");
}
/**********************************************wooodt features settings Field End**************************************************************/		
?>