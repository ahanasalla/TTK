<?php
namespace TtkAccessParallaxPro;

/**
 * Class Options
 * @package TtkAccessParallaxPro
 */
class Options
{
    /**
     * @var bool
     */
    public $delMenuOptionEnable = false;

    /**
     * @var string
     */
    public $delMenuOptionEnableName = 'ttk_del_menu_enable';

    /**
     * @var string
     */
    public $delMenuOptionName = 'ttk_del_menu_after_time';

    /**
     * @var bool
     */
    public $delMenuOptionValue = false;

    /**
     * @var bool
     */
    public $delFirstMenuExpired = false;

    /**
     * Options constructor.
     */
    public function init()
    {
        add_action('init', array($this, 'onInit'));
        add_action('admin_menu', array($this, 'addGlobalCustomOptions'));
    }

    /**
     *
     */
    public function onInit()
    {
        $this->setDelMenuOptionValues();

        // Pre-update option
        add_filter('pre_update_option_'.$this->delMenuOptionName, array($this, 'updateDelMenuOptionValue'), 10, 2);

        if ($this->delMenuOptionEnable === 'true') {
            $args        = array();
            $productCats = get_terms('product_cat', $args);

            reset($productCats);

            $firstMenuCat = current($productCats);

            if (isset($firstMenuCat->term_id)) {
                $this->doDelProductCatBasedOnTimeSet($firstMenuCat);
            }
        }
    }

    /**
     * @return string
     */
    public function updateDelMenuOptionValue()
    {
        $hour = isset($_POST['ttk_del_menu_after_hour']) ? $_POST['ttk_del_menu_after_hour'] : false;
        $minute = isset($_POST['ttk_del_menu_after_minute']) ? $_POST['ttk_del_menu_after_minute'] : false;

        if ($hour && $minute) {
            return $hour.':'.$minute;
        }

        return '';
    }

    /**
     *
     */
    public function addGlobalCustomOptions()
    {
        add_options_page(
            'TTK Global Options',
            'TTK Global Options',
            'manage_options',
            'ttk_global_options',
            array($this, 'globalCustomOptions')
        );
    }

    /**
     *
     */
    public function globalCustomOptions()
    {
        $rangeHours = range(0, 24);
        $rangeMinutes = range(0, 59);

        foreach ($rangeHours as $rangeHourKey => $rangeHour) {
            if ($rangeHour < 10) {
                $rangeHours[$rangeHourKey] = '0' . $rangeHour;
            }
        }

        foreach ($rangeMinutes as $rangeMinuteKey => $rangeMinute) {
            if ($rangeMinute < 10) {
                $rangeMinutes[$rangeMinuteKey] = '0' . $rangeMinute;
            }
        }

        // Default Values
        $defaultMenuHour = '10';
        $defaultMenuMinute = '00';

        if (! $this->delMenuOptionValue) {
            $menuHour = $defaultMenuHour;
            $menuMinute = $defaultMenuMinute;
        } else {
            // Some validation first to make sure the format is right
            if (strpos($this->delMenuOptionValue, ':') !== false) {
                list($menuHour, $menuMinute) = explode(':', $this->delMenuOptionValue);
            } else {
                // No valid values found?
                $menuHour = $defaultMenuHour;
                $menuMinute = $defaultMenuMinute;
            }
        }
    ?>
        <div class="wrap">
            <h2>TheTownKitchen.com: Global Fields</h2>
            <form method="post" action="options.php">
                <?php wp_nonce_field('update-options') ?>

                <p><label><strong>Enable "Daily Expiration Menu"?</strong></label><br />
                    <input <?php if ($this->delMenuOptionEnable === 'true') { echo 'checked="checked"'; } ?> type="radio" id="ttk_del_menu_enable_true" name="<?php echo $this->delMenuOptionEnableName; ?>" value="true" /><label for="ttk_del_menu_enable_true"><span style="color: green;">Yes</span></label> &nbsp;&nbsp;
                    <input <?php if ($this->delMenuOptionEnable === 'false') { echo 'checked="checked"'; } ?> type="radio" id="ttk_del_menu_enable_false" name="<?php echo $this->delMenuOptionEnableName; ?>" value="false" /><label for="ttk_del_menu_enable_false"><span style="color: red;">No</span></label>
                </p>

                <p><strong>Delete Day Menu (First from "Categories") After (X) Time:</strong><br />
                    <label for="ttk_del_menu_after_hour_dd">Hour:</label>
                    <select id="ttk_del_menu_after_hour_dd" name="ttk_del_menu_after_hour">
                    <?php
                    foreach ($rangeHours as $rangeHour) {
                        $selected = ($rangeHour == $menuHour) ? 'selected="selected"' : '';
                    ?>
                        <option <?php echo $selected; ?> value="<?php echo $rangeHour; ?>"><?php echo $rangeHour; ?></option>
                    <?php
                    }
                    ?>
                    </select>

                    &nbsp;

                    <label for="ttk_del_menu_after_minute_dd">Minute:</label>
                    <select id="ttk_del_menu_after_minute_dd" name="ttk_del_menu_after_minute">
                        <?php
                        foreach ($rangeMinutes as $rangeMinute) {
                            $selected = ($rangeMinute == $menuMinute) ? 'selected="selected"' : '';
                            ?>
                            <option <?php echo $selected; ?> value="<?php echo $rangeMinute; ?>"><?php echo $rangeMinute; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </p>
                <p><input class="button button-primary" type="submit" name="Submit" value="Save Options" /></p>
                <input type="hidden" name="action" value="update" />
                <input type="hidden" name="page_options" value="ttk_del_menu_enable,ttk_del_menu_after_time" />
            </form>
        </div>
    <?php
    }

    /**
     * @param $cat
     */
    public function doDelProductCatBasedOnTimeSet($cat)
    {
        if (! $this->delMenuOptionValue) {
            $this->delMenuOptionValue = get_option('ttk_del_menu_after_time');
        }

        if (strpos($this->delMenuOptionValue, ':') === false) {
            return;
        }

        list ($hour, $minute) = explode(':', $this->delMenuOptionValue);

        $delAfterTimeStamp = mktime($hour, $minute, 0, date('m'), date('d'), date('Y'));
        $now = current_time('timestamp');

        if ($now > $delAfterTimeStamp && $this->catMatchesPattern($cat)) {
            wp_delete_term($cat->term_id, 'product_cat');
        }
    }

    /**
     * @param $cat
     *
     * @return bool
     */
    public function catMatchesPattern($cat)
    {
        $name = $cat->name;

        // This will work as long as this is triggered at least once a day
        // e.g. someones uses the admin panel or a visitor visits the website (a non-cached page)

        // Check if it contains today's week day within the name
        // (e.g. "Thursday" will be found in "Thursday 5/25")
        if (stripos($name, date('l')) !== false) {
            return true;
        }

        return false;
    }

    /**
     *
     */
    public function setDelMenuOptionValues()
    {
        if (! $this->delMenuOptionEnable) {
            $this->delMenuOptionEnable = (get_option($this->delMenuOptionEnableName) === 'true') ? 'true' : 'false';
        }

        if (! $this->delMenuOptionValue && $this->delMenuOptionEnable) {
            $this->delMenuOptionValue = get_option($this->delMenuOptionName);
        }
    }
}
