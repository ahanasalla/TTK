<div class="wrap">
    <?php
        //Grab all options
        $options = get_option($this->plugin_tag);
        $license = $options['license'];
        $buyer = $options['buyer'];
        $status = isset($options['status'])?$options['status']:"unknown";
    ?>
	<h1><?php echo __("Settings"); ?> - <?php echo $this->plugin_name; ?> <small>v<?php echo $this->plugin_version; ?></small></h1>
	<p><?php if ($status == 'valid') { echo __('Hello').' '.$buyer.'! ',__('Thank you for purchasing', $this->plugin_tag).' '.$this->plugin_name.'!<br />'; } else {  } ?><?php echo __("PimpMyWoo helps you customize the way your WooCommerce shop looks without writing any code!<br />You can do all customization throughout the Customize option from your Appearance menu. ", $this->plugin_tag); ?></p>
	<p><?php if ($status == 'valid') { echo '<a href="' . admin_url( '/customize.php' ) . '">'.__('Customize').'</a>'; } else { echo '<strong>'.__("Just fill in your license key and hit the Save button to start customizing!", $this->plugin_tag).'</strong>'; } ?>
	</p>
	<form method="post" name="pimpmywoo_settings" action="options.php">
	    <?php settings_fields($this->plugin_tag); do_settings_sections($this->plugin_tag); ?>
		<table class="form-table">
		   <tbody>
		      <tr>
		         <th scope="row"><label for="<?php echo $this->plugin_tag; ?>[license]"><?php echo $this->plugin_name; ?> <?php echo __("License", $this->plugin_tag); ?><br />(<?php echo $status; ?>)</label></th>
		         <td>
		            <input name="<?php echo $this->plugin_tag; ?>[license]" type="text" id="<?php echo $this->plugin_tag; ?>-license" aria-describedby="<?php echo $this->plugin_tag; ?>-license-description" value="<?php echo $license; ?>" class="regular-text code">
		            <p class="description" id="<?php echo $this->plugin_tag; ?>-license-description"><?php if ($status != 'valid') { echo __("Please fill in your license key. You received it when you purchased the plugin and it is also available in CodeCanyon's Downloads area.", $this->plugin_tag); } ?></p>
		         </td>
		      </tr>
		      <tr>
		         <th scope="row"><?php echo __("Perform Rollback", $this->plugin_tag); ?></th>
		         <td>
			         <fieldset>
				         <legend class="screen-reader-text"><?php echo __("Perform Rollback", $this->plugin_tag); ?><span></span></legend>
				         <label for="<?php echo $this->plugin_tag; ?>[rollback]">
				         	<input name="<?php echo $this->plugin_tag; ?>[rollback]" type="checkbox" id="<?php echo $this->plugin_tag; ?>[rollback]" >
				         	<?php echo __("You cannot undo that!", $this->plugin_tag); ?>
				         </label>
			         </fieldset>		            
		            <p class="description" id="<?php echo $this->plugin_tag; ?>-license-description"><?php echo __("Check this box if you want to delete all PimpMyWoo custom settings at once.", $this->plugin_tag); ?></p>
		         </td>
		      </tr>
		   </tbody>
		</table>
		<?php submit_button(__("Save"), 'primary','submit', TRUE); ?>
	</form>
</div>