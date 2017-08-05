<div class="clear"></div>
<div class="postbox rpdocontainer" id="dashboard_right_now" >
    <h3 class="hndle"><?php echo __('Donation/Tip Settings', 'rpdo') ?></h3>
    <div class="inside">
        <div class="main">
            <form method="post" action="" name="<?php echo self::$plugin_slug; ?>">
                <input type="hidden" name="<?php echo self::$plugin_slug; ?>" value="1"/>
                <table class="rp_table" >
                    <tr>
                        <td  width="20%" class="label"><?php echo __('Enable?', 'rpdo') ?></td>
                        <td>
                            <input type="checkbox" name="enable" <?php echo ($this->get_setting("enable")) ? "checked=checked" : ""; ?> value="1" />
                        </td>
                    </tr>
                    <tr>
                        <td class="label"><?php echo __('Display Donation Fields on', 'rpdo') ?></td>
                        <td>
                            <select name="display_donation">
                                <option value="3" <?php echo $this->get_setting("display_donation")==3?"selected=selected":""; ?> ><?php echo __("Only Cart Page", 'rpdo'); ?></option>
                                <option value="1" <?php echo $this->get_setting("display_donation")==1?"selected=selected":""; ?> ><?php echo __("Only Checkout Page", 'rpdo'); ?></option>
                                <option value="2" <?php echo $this->get_setting("display_donation")==2?"selected=selected":""; ?> ><?php echo __("Both(Cart And Checkout)", 'rpdo'); ?></option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="label"><?php echo __('Donation Button Lable', 'rpdo') ?></td>
                        <td>
                            <input type="text" name="btn_lable" value="<?php echo $this->get_setting('btn_lable') ?>" />
                        </td>
                    </tr>
                    <tr>
                        <td class="label"><?php echo __('Title', 'rpdo') ?></td>
                        <td>
                            <input type="text" name="title" value="<?php echo $this->get_setting('title') ?>" />
                        </td>
                    </tr>
                    <tr>
                        <td class="label"><?php echo __('Donation/Tip Messsage', 'rpdo') ?></td>
                        <td>
                            <textarea name="message" rows="5" cols="25" ><?php echo $this->get_setting('message'); ?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td class="label"><?php echo __('Default Amount', 'rpdo') ?></td>
                        <td>
                            <?php echo get_woocommerce_currency_symbol() ?> <input type="text" name="default_amt" value="<?php echo $this->get_setting('default_amt') ?>" />
                        </td>
                    </tr>
                    <tr>
                        <td class="label"><?php echo __('Taxable?', 'rpdo') ?></td>
                        <td>
                            <input type="checkbox" name="taxable" <?php echo ($this->get_setting("taxable")) ? "checked=checked" : ""; ?> value="1" />
                        </td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>
                            <input type="submit" class="button button-primary" name="btn-rpdo-submit" value="<?php echo __("Save Settings", "rpdo") ?>" />
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>
