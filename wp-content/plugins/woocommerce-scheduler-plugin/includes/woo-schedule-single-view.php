<?php
namespace WooScheduleSingleView;

if (!class_exists('WooScheduleSingleView')) {
    class WooScheduleSingleView
    {
        /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
        private $plugin_name;

        /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
        private $version;
        public function __construct($plugin_name, $version)
        {
            $this->plugin_name   = $plugin_name;
            $this->version       = $version;
        }
        public function registerSingleViewSubmenuPage()
        {
            add_submenu_page('edit.php?post_type=product', __('Schedule Products', WDM_WOO_SCHED_TXT_DOMAIN), __('Schedule Products', WDM_WOO_SCHED_TXT_DOMAIN), 'manage_options', 'woo-schedule-single-view', array($this,'wooSingleViewSubmenuPageCallback'));
        }
        public function wooSingleViewSubmenuPageCallback()
        {
            wp_register_script('wdm_moment_js_handler', plugins_url('/js/moment.js', dirname(__FILE__)), array('jquery'));
            wp_enqueue_script('wdm_moment_js_handler');
            wp_register_script('wdm_datepicker', plugins_url('/js/bootstrap-datetimepicker.min.js', dirname(__FILE__)), array('wdm_moment_js_handler'));
            wp_enqueue_script('wdm_datepicker');
            wp_register_style('bootstrap_css', plugins_url('/css/bootstrap.css', dirname(__FILE__)));
            wp_enqueue_style('bootstrap_css');
            wp_register_style('wdm_datepicker_css', plugins_url('/css/bootstrap-datetimepicker.min.css', dirname(__FILE__)));
            wp_enqueue_style('wdm_datepicker_css');
            $expiration_type = get_option('woocommerce_custom_product_expiration_type');
            wp_register_script('wdm_singleview_js_handler', plugins_url('/js/woo_schedule_single_view.js', dirname(__FILE__)), array('jquery'), time());
            wp_enqueue_script('wdm_singleview_js_handler');

            $array_to_sent = array('admin_ajax_path' => admin_url('admin-ajax.php'),
                   'loading_image_path' => plugins_url('/css/images/loading.gif', dirname(__FILE__)),
                   'loading_text' => __('Loading', WDM_WOO_SCHED_TXT_DOMAIN),
                   'details_updated_msg' =>  __('Details updated.', WDM_WOO_SCHED_TXT_DOMAIN),
                   'selection_empty_msg' => __('Selection empty.', WDM_WOO_SCHED_TXT_DOMAIN),
                   'confirm_save_msg' => __('This will override all scheduler entries, Do you want to proceed?', WDM_WOO_SCHED_TXT_DOMAIN),
                   'delete_confirm_msg' => __('This will delete entry, Do you want to proceed?', WDM_WOO_SCHED_TXT_DOMAIN),
                   'please_select_msg' => __('Please select', WDM_WOO_SCHED_TXT_DOMAIN)
            );
            wp_localize_script('wdm_singleview_js_handler', 'woo_single_view_obj', $array_to_sent);
            
            $expiration_type = get_option('woocommerce_custom_product_expiration_type');
            //validation script
            wp_register_script('woo_singleview_validate_js_handler', plugins_url('/js/woo_schedule_validate.js', dirname(__FILE__)), array('jquery'), time());
            wp_enqueue_script('woo_singleview_validate_js_handler');
        
             $array_to_sent = array('type' => $expiration_type,
                   'error_msg_end_time_more_than_start_time' => __('End time can\'t be less than start time', WDM_WOO_SCHED_TXT_DOMAIN),
                   'error_msg_time_empty' => __('Please Select Time', WDM_WOO_SCHED_TXT_DOMAIN),
                   'error_msg_start_date_less_than_end_date' => __('Start date must be less than End date', WDM_WOO_SCHED_TXT_DOMAIN),
                   'error_msg_details_empty' => __('Please enter all details', WDM_WOO_SCHED_TXT_DOMAIN));
        
             wp_localize_script('woo_singleview_validate_js_handler', 'woo_schedule_validate_obj', $array_to_sent);
                
            //select 2 script
        
             wp_register_script('woo_singleview_select2_js_handler', plugins_url('/js/woo_schedule_select2.js', dirname(__FILE__)), array('jquery'), time());
             wp_enqueue_script('woo_singleview_select2_js_handler');
        
             wp_register_style('woo_select2_css', plugins_url('/css/woo_schedule_select2.css', dirname(__FILE__)));
             wp_enqueue_style('woo_select2_css');
        
             wp_register_style('bootstrap_select2_css', plugins_url('/css/select2-bootstrap.css', dirname(__FILE__)));
             wp_enqueue_style('bootstrap_select2_css');
        
            ?>
	    
            <div class="wrap"><div id="icon-tools" class="icon32"></div>
                    <h2><?php _e('WooCommerce Scheduler', WDM_WOO_SCHED_TXT_DOMAIN); ?></h2>
		    
					<div class="wdm-woo-scheduler-settings">
						<div class="container-fluid wdm_selection_criteria">
									<div class="row wdm_selection_row">

							<!-- Select Basic -->
							<div class="form-group col-md-12">
										<label class="col-md-2 control-label" for="woo_schedule_selection_type"><?php _e('Select Option', WDM_WOO_SCHED_TXT_DOMAIN); ?></label>
								<div class="col-md-4">
									<select id="woo_schedule_selection_type" name="woo_schedule_selection_type" class="form-control">
										<option value="-1" disabled selected><?php _e('Select Product or Category', WDM_WOO_SCHED_TXT_DOMAIN); ?></option>
										<option value="product"><?php _e('Products', WDM_WOO_SCHED_TXT_DOMAIN); ?></option>
										<option value="category"><?php _e('Product category', WDM_WOO_SCHED_TXT_DOMAIN); ?></option>
									</select>
								</div>
							</div>

							<!-- Select Basic -->

						</div>
					</div>

			
					<div class="container-fluid wdm_selection_details">
					</div>
					</div><!-- /.wdm-woo-scheduler-settings -->
					<!--</fieldset>
			</form>-->


            </div> <!--wrap ends-->
	    
	    <?php
    
        }
    }
}