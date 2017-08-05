<?php
if (!class_exists('rp_donation')) {

    class rp_donation {

        private static $plugin_url;
        private static $plugin_dir;
        private static $plugin_title = "Donation/Tip";
        private static $plugin_slug = "rpdo-setting";
        private static $rpdo_option_key = "rpdo-setting";
        private $rpdo_settings;
        private static $donation_session = "rp_donation_session";

        public function __construct() {

            global $rpdo_plugin_dir, $rpdo_plugin_url;
            /* plugin url and directory variable */
            self::$plugin_dir = $rpdo_plugin_dir;
            self::$plugin_url = $rpdo_plugin_url;


            /* load donation  setting */
            $this->rpdo_settings = get_option(self::$rpdo_option_key);

            /* register admin menu for donation */
            add_action("admin_menu", array($this, "admin_menu"));
            add_action("admin_init", array($this, "admin_init"));
            add_action("woocommerce_thankyou", array($this, "woocommerce_thankyou"));

            if ($this->get_setting("enable") == 1) {
                $this->init();
            }
        }
        
        public function woocommerce_thankyou(){
            global $woocommerce;
            $woocommerce->session->set(self::$donation_session,0);
        }

        /* init function */

        public function init() {
            add_action("wp_head", array($this, "wp_head"));

            /* hook for add field on cart and checkout */
            add_action("woocommerce_cart_contents", array($this, "add_donation_field"));
            add_action('woocommerce_before_checkout_form', array(&$this, 'add_donation_field_checkout'));

            /* hook for add donation fee */
            add_action("wp_loaded", array($this, "update_donation"));
            add_action('woocommerce_cart_calculate_fees', array(&$this, 'donation_to_cart'));
        }

        /* function for add donation to cart */

        public function donation_to_cart() {
            global $woocommerce;
            $donation_amount = $this->get_donation_amount();
            if ($donation_amount && is_numeric($donation_amount) && $donation_amount > 0):
                $taxable = $this->get_setting('taxable') ? true : false;
                $woocommerce->cart->add_fee(__($this->get_setting('title'), 'rpdo'), $donation_amount, $taxable);
            endif;
        }

        /* add donation */

        public function update_donation() {
            if (isset($_POST["donate-btn"]) && isset($_POST["donation-amount"]) && is_numeric($_POST["donation-amount"])) {

                $amount = $_POST["donation-amount"];
                $this->set_donation_amount($amount);
            }
        }

        /* set donation amount to woo sesssion */

        public function set_donation_amount($amount) {
            global $woocommerce;
            $woocommerce->session->set(self::$donation_session, $amount);
        }

        /* get donation amount from woo session */

        public function get_donation_amount() {
            global $woocommerce;
            $amount = $woocommerce->session->get(self::$donation_session);
            if ($amount && is_numeric($amount)) {
                return $amount;
            }
            return "0";
        }

        /* function for add donation field on checkout page */

        public function add_donation_field_checkout() {

            if (!is_checkout())
                return;

            if ($this->get_setting("enable") != 1)
                return;

            if ($this->get_setting('display_donation') && ($this->get_setting('display_donation') == 1 || $this->get_setting("display_donation") == 2)):
                $amount = 0;
                if ($this->get_donation_amount() > 0) {
                    $amount = $this->get_donation_amount();
                } else {
                    $amount = $this->get_setting('default_amt');
                }
                ?>
                <form method="post" action="">
                    <div class="rp-donation-block checkout_donation" >
                        <p class="message"><strong><?php echo $this->get_setting('message'); ?></strong></p>
                        <div class="input text">
                            <input type="text" value="<?php echo $amount; ?>" class="input-text text-donation" name="donation-amount">
                            <input type="submit" value="<?php echo $this->get_setting('btn_lable'); ?>" class="button" name="donate-btn">
                        </div>
                    </div>
                </form>
                <?php
            endif;
        }

        /* function for add donation field on cart page */

        public function add_donation_field() {
            if (!is_cart())
                return;

            if ($this->get_setting("enable") != 1)
                return;


            if ($this->get_setting('display_donation') && ($this->get_setting('display_donation') == 3 || $this->get_setting("display_donation") == 2)):
                $amount = 0;

                if ($this->get_donation_amount() > 0) {
                    $amount = $this->get_donation_amount();
                } else {
                    $amount = $this->get_setting('default_amt');
                }
                ?>
                <tr class="rp-donation-block">
                    <td colspan="6">
                        <div class="donation">
                            <p class="message"><strong><?php echo $this->get_setting('message'); ?></strong></p>
                            <div class="input text">
                                <input type="text" value="<?php echo $amount; ?>" class="input-text text-donation" name="donation-amount">
                                <input type="submit" value="<?php echo $this->get_setting('btn_lable'); ?>" class="button" name="donate-btn">
                            </div>
                        </div>
                    </td>
                </tr>
                <?php
            endif;
        }

        public function wp_head() {
            if (is_checkout() || is_cart()):
                ?>
                <style type="text/css">
                    .text-donation{
                        max-width: 200px;
                        display: inline-block !important;
                        min-height:28px;
                        line-height: 28px;
                        margin-right: 10px;
                    }
                    .rp-donation-block p.message{margin-bottom: 10px;}
                    .checkout_donation{display: block;width:100%;}
                </style>

                <?php
            endif;
        }

        public function admin_init() {
            wp_enqueue_style('rpdo-admin', self::$plugin_url . "assets/css/admin.css");
        }

        public function admin_menu() {
            $wc_page = 'woocommerce';
            add_submenu_page($wc_page, self::$plugin_title, self::$plugin_title, "install_plugins", self::$plugin_slug, array($this, "setting_donation"));
        }

        public function setting_donation() {
            /* save donation setting */
            if (isset($_POST[self::$plugin_slug])) {
                $this->saveSetting();
            }

            /* include admin   setting file */
            include_once self::$plugin_dir . "view/setting.php";
        }

        public function saveSetting() {
            $arrayRemove = array(self::$plugin_slug, "btn-rpdo-submit");
            $saveData = array();
            foreach ($_POST as $key => $value):
                if (in_array($key, $arrayRemove))
                    continue;
                $saveData[$key] = $value;
            endforeach;
            $this->rpdo_settings = $saveData;
            update_option(self::$rpdo_option_key, $saveData);
        }

        public function get_setting($key) {

            if (!$key || $key == "")
                return;

            if (!isset($this->rpdo_settings[$key]))
                return;

            return $this->rpdo_settings[$key];
        }

    }

}

/* load plugin if woocommerce plugin is activated */
if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
    /* load Donation plugin code */
    new rp_donation();
}