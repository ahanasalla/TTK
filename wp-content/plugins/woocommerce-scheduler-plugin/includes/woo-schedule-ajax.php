<?php
namespace WooScheduleAjax;

if (!class_exists('WooScheduleAjax')) {
    class WooScheduleAjax
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

        // callback to send Selection List

            add_action('wp_ajax_handle_selection_type', array($this,'handleSelectionTypeCallback'));
            add_action('wp_ajax_nopriv_handle_selection_type', array($this,'handleSelectionTypeCallback'));

        //callback to fetch selection details

            add_action('wp_ajax_fetch_selections_details', array($this,'fetch_selections_details_callback'));
            add_action('wp_ajax_nopriv_fetch_selections_details', array($this,'fetch_selections_details_callback'));

        //callback to update selection details for particular product / category

            add_action('wp_ajax_update_expiration_details', array($this,'updateExpirationDetailsCallback'));
            add_action('wp_ajax_nopriv_update_expiration_details', array($this,'updateExpirationDetailsCallback'));

        //callback to display scheduler setting

            add_action('wp_ajax_display_scheduler_fields', array($this,'displaySchedulerFieldsCallback'));
            add_action('wp_ajax_nopriv_display_scheduler_fields', array($this,'displaySchedulerFieldsCallback'));

        //callback to remove Product scheduler setting

            add_action('wp_ajax_remove_product_details', array($this,'removeProductDetailsCallback'));
            add_action('wp_ajax_nopriv_remove_product_details', array($this,'removeProductDetailsCallback'));

        //callback to remove Term scheduler setting

            add_action('wp_ajax_remove_term_details', array($this,'removeTermDetailsCallback'));
            add_action('wp_ajax_nopriv_remove_term_details', array($this,'removeTermDetailsCallback'));
        }

/*
* This function is callback of AJAX -- handle_selection_type
* It check received data is in valid selection and returns list in dropdown. 
*/
        public function handleSelectionTypeCallback()
        {

            $selection = isset($_POST['selection'])? trim($_POST['selection']) : '';

            $valid_selection = array('product','category');

            if (wdm_check_selection_type($selection, $valid_selection)) {
        //As selection is empty -- there must be some error

                echo self::wooScheduleWrongSelection();
                die();
            }

            ob_start();

            $results = array();

            if ($selection === 'product') {
                $results=handleProductSelectionCallType();
            } elseif ($selection === 'category') {
                $taxonomies = array(
                    'product_cat',
                    );

                $args = array(
                    'orderby'           => 'name',
                    'order'             => 'ASC',
                    'hide_empty'        => false,
                    'fields'            => 'id=>name'
                    );

                $results = get_terms($taxonomies, $args);

            }

            if (!empty($results)) {
                ?>
                <div class="form-group col-md-12 wdm_selections">
                    <label class="col-md-2 control-label" for="woo_schedule_selections"><?php echo ucfirst($selection); ?></label>
            <div class="col-md-4">
                <select id="woo_schedule_selections" name="woo_schedule_selections" class="form-control" selection_type="<?php echo $selection; ?>" multiple>
                    <?php echo __('Select ', WDM_WOO_SCHED_TXT_DOMAIN) . ' ' . $selection; ?>
                    <?php foreach ($results as $id => $title) : ?>
                        <option value="<?php echo $id; ?>"><?php echo $title; ?></option>
                        <?php
endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-12">
                            <div class="text-right">
                                <input type="button" class="btn btn-primary" data-loading-text="<?php _e('Loading...', WDM_WOO_SCHED_TXT_DOMAIN); ?>" id="woo_schedule_display_selection" value="<?php _e('Show Schedule', WDM_WOO_SCHED_TXT_DOMAIN); ?>" autocomplete="off">
                            </div>

                        </div>

                    </div>


                    <script type="text/javascript">
                        jQuery('document').ready(function(){jQuery('#woo_schedule_selections').select2({ placeholder: "<?php echo __('Select ', WDM_WOO_SCHED_TXT_DOMAIN) . $selection; ?>"});});
                    </script>
                    <?php
            }//results not empty

            $content = ob_get_clean();
            echo $content;

            die();
        }

/*
* This function returns details to displayed if there is wrong selection
* @return $content string  details of wrong selection
* @since 1.0.3
* 
*/
        public function wooScheduleWrongSelection()
        {
            ob_start();
            ?>
            <div class="wdm_selections col-md-12">
                <p class="bg-danger wdm-message"><b><?php _e('Wrong selection.', WDM_WOO_SCHED_TXT_DOMAIN); ?></b></p>
    </div>

    <?php

    $content = ob_get_clean();
    return $content;
        }

        public function updateExpirationDetailsCallback()
        {
            $wdm_start_date = wdm_check_isset($_POST['start_date']);
            $wdm_end_date = wdm_check_isset($_POST['end_date']);

            if (isset($_POST['day_of_week']) && ! empty($_POST['day_of_week'])) {
                $day_of_week = $_POST['day_of_week'];
            }

            $days_selected = '';

            if (!empty($day_of_week) && is_array($day_of_week)) {
                foreach ($day_of_week as $single_day) {
                    $days_selected[$single_day] = 'on';
                }
            }

            $selection_type = wdm_check_isset($_POST['selection_type']);

            $selections_list = wdm_check_isset($_POST['selections_id']);


            $valid_selection = array('product','category');

            if (wdm_check_selection_type($selection_type, $valid_selection)) {
        //As selection is empty -- there must be some error

                ob_start();

                ?>
                <p class="bg-danger"><b><?php _e('Wrong selection.', WDM_WOO_SCHED_TXT_DOMAIN); ?></b></p>
        <?php

        $content = ob_get_clean();

        echo $content;

        die();
            }


            if (wdm_check_empty($selection_type, $selections_list)) {
        //Update the details
                if ($selection_type === 'product') {
                    wdm_selection_type_product($wdm_start_date, $wdm_end_date, $selections_list, $days_selected);


                } //selection type - Product ends
                elseif ($selection_type === 'category') {
                    wdm_selection_type_category($selections_list, $days_selected, $wdm_start_date, $wdm_end_date);


                }//selection type - Category ends


                ob_start();

                _e('details updated', WDM_WOO_SCHED_TXT_DOMAIN);
                self::wooScheduleDisplayExistingDetails($selections_list, $selection_type);

                $content = ob_get_clean();

                echo $content;
                die();
            } else {
                ob_start();

                _e('Selection empty', WDM_WOO_SCHED_TXT_DOMAIN);

                self::wooScheduleDisplayExistingDetails($selections_list, $selection_type);
                $content = ob_get_clean();

                echo $content;

                die();
            }

            die();
        }

/*
* This is callback to display scheduler setting - 
* Start date, End date & selected dates
*/
        public function displaySchedulerFieldsCallback()
        {

            $selection_type = isset($_POST['selection_type'])? $_POST['selection_type'] : '';

            $selection_id = isset($_POST['selections_id']) ? $_POST['selections_id'] : ''; //not used currently

            $valid_selection = array('product','category');

            $days_selection_type = get_option('woocommerce_custom_product_expiration_type');

            if (!empty($selection_type) && !empty($selection_id) && in_array($selection_type, $valid_selection)) {
                ob_start();

                $week_array = array(
                    'Monday'    => __('Monday', WDM_WOO_SCHED_TXT_DOMAIN),
                    'Tuesday'   => __('Tuesday', WDM_WOO_SCHED_TXT_DOMAIN),
                    'Wednesday' => __('Wednesday', WDM_WOO_SCHED_TXT_DOMAIN),
                    'Thursday'  => __('Thursday', WDM_WOO_SCHED_TXT_DOMAIN),
                    'Friday'    => __('Friday', WDM_WOO_SCHED_TXT_DOMAIN),
                    'Saturday'  => __('Saturday', WDM_WOO_SCHED_TXT_DOMAIN),
                    'Sunday'    => __('Sunday', WDM_WOO_SCHED_TXT_DOMAIN)
                );


                ?>
                <h4><?php printf(__('Schedule %s', WDM_WOO_SCHED_TXT_DOMAIN), ucfirst($selection_type)); ?></h4>
        <div class="wdm-box clearfix wdm-woo-schedule-category">
            <div class="row">
            <div class="col-md-12 form-group">


                <label class="control-label col-md-2" for="start_date"><?php _e('Start date', WDM_WOO_SCHED_TXT_DOMAIN); ?></label>                 <input type="text" name="wdm_start_date" id="wdm_start_date" class="col-md-2">

                <label class="control-label col-md-1 col-md-offset-1" for="end_date"><?php _e('End date', WDM_WOO_SCHED_TXT_DOMAIN); ?></label>
                <input type="text" name="wdm_end_date" id="wdm_end_date" class="col-md-2">    
            </div>
            </div>

            <?php if ($days_selection_type == 'per_day') : ?>

            <div class="row">
                <div class="col-md-12 form-group">
                    <label for="wdm_lat_field" class="col-md-1 wdm-date-week"><?php _e('Days of Week', WDM_WOO_SCHED_TXT_DOMAIN); ?></label>
                    <div class="checkbox col-md-10 wdm-checkbox">

                        <?php foreach ($week_array as $week_day => $day) : ?>
                            <label class="checkbox-inline">
                                <input type='checkbox' name='days_of_week[<?php echo $week_day; ?>]' class='wdm_day_of_week' checked="checked" day_of_week="<?php echo $week_day;?>">
                                <?php echo $day; ?>
                            </label>
                            <?php
endforeach; ?>

                        </div>
                    </div>




                </div>

                <?php
endif; ?>

                        <div class="row"><div class="col-md-12"><button type="button" class="btn btn-primary" id="woo_single_view_update_details"><?php _e('Set Schedule', WDM_WOO_SCHED_TXT_DOMAIN); ?></button></div></div>
                    </div><!-- /.wdm-box -->
                    <script type="text/javascript">

                        jQuery(document).ready(function () {
                     var selection_type= "<?php echo $days_selection_type; ?>";
                     if(selection_type == "per_day"){
                        mindate = moment().format('MM/DD/YYYY');
                     }
                     else{
                        mindate = moment();
                     }
                        jQuery('#wdm_start_date').datetimepicker({
                        minDate: mindate,//moment().format('MM/DD/YYYY'),
                        format : 'MM/DD/YYYY, HH:mm',
                        defaultDate : moment(),
                        ignoreReadonly : true,
                        showClear : true
                            });

                        jQuery('#wdm_end_date').datetimepicker({
                        minDate: mindate,//moment().format('MM/DD/YYYY'),
                        format : 'MM/DD/YYYY, HH:mm',
                        ignoreReadonly : true,
                        showClear : true,
        useCurrent: true //Important! See issue #1075
        });

        //revise 'End date' --- minimum date after change in Start date

        jQuery("#wdm_start_date").on("dp.change", function (e) {

        //console.log(e);

        jQuery('#wdm_end_date').data("DateTimePicker").minDate(e.date);
        });


        jQuery('#wdm_start_date').data("DateTimePicker").date(null);

        jQuery('#wdm_end_date').data("DateTimePicker").date(null);
        });
                    </script>
                    <?php
                    self::wooScheduleDisplayExistingDetails($selection_id, $selection_type);

                    $content = ob_get_clean();
                    echo $content;
                    die();
            } else {
                echo self::wooScheduleWrongSelection();
                die();
            }

                die();
        }

        public function wooScheduleDisplayExistingDetails($selection_id, $selection_type)
        {
            global $wpdb;

            $days_selection_type = get_option('woocommerce_custom_product_expiration_type');

            $details_result = array();

            ?>
            <div class="woo-schedule-existing-details">
            <h4><?php echo __('Schedule Details', WDM_WOO_SCHED_TXT_DOMAIN); ?></h4>           
            <div class="clearfix wdm-box"><div class="col-md-12">
                <?php

                if (is_array($selection_id)) {
                    $table_display = true;

                    if ($selection_type === 'product') {
                        $query = "SELECT * FROM `" . $wpdb->prefix . "postmeta` WHERE 
                        `post_id` IN (" . implode(',', $selection_id) . ") 
                        AND `meta_key` IN ('wdm_start_date','wdm_end_date')
                        AND `meta_value` <> ''
                        Order by `post_id`";

                        $result = $wpdb->get_results($query);

                        if (count($result) === 0) {
                            $table_display = false;
                            echo self::noDisplayMessage();
                        }
                    } else if ($selection_type === 'category') {
                        $query = "SELECT * FROM `" . $wpdb->prefix . "woo_schedule_category` WHERE `term_id` IN (" . implode(',', $selection_id) . ")";

                        $details_result = $wpdb->get_results($query);

                        if (empty($details_result)) {
                            $table_display = false;
                            echo self::noDisplayMessage();
                        }
                    }

                    if ($table_display) {
                        ?>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th><?php _e('Name', WDM_WOO_SCHED_TXT_DOMAIN); ?></th>
                                    <th><?php _e('Start Date', WDM_WOO_SCHED_TXT_DOMAIN); ?></th>
                                    <th><?php _e('End Date', WDM_WOO_SCHED_TXT_DOMAIN); ?></th>

                                    <?php if ($days_selection_type == 'per_day') : ?>
                                        <th><?php _e('Days selection', WDM_WOO_SCHED_TXT_DOMAIN); ?></th>
                                        <?php
endif; ?>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                    if ($selection_type === 'product') :
                                        wdm_product_selection($selection_id);

                                    elseif ($selection_type === 'category') :
                                        wdm_category_selection($details_result, $days_selection_type);

                                    endif;
                                    ?>

                                </tbody>
                            </table>
                            <?php

                    }//table display check ends

                }// is_array($selection_id) check ends
    ?>
    </div></div></div>
    <?php
        }

/*
* This will remove all details of particular product
*/
        public function removeProductDetailsCallback()
        {
            $product_id = isset($_POST['product_id'])? intval($_POST['product_id']) : '';

            if (empty($product_id) || $product_id <= 0) {
                echo __("Product ID incorrect", WDM_WOO_SCHED_TXT_DOMAIN);
                die();
            }

            delete_post_meta($product_id, 'wdm_start_date');
            delete_post_meta($product_id, 'wdm_end_date');
            delete_post_meta($product_id, 'wdm_start_time_hr');
            delete_post_meta($product_id, 'wdm_start_time_min');
            delete_post_meta($product_id, 'wdm_end_time_hr');
            delete_post_meta($product_id, 'wdm_end_time_min');
            delete_post_meta($product_id, 'wdm_days_selected');
            die();
        }

/*
* This will remove all details of particular Term -- Product category
*/
        public function removeTermDetailsCallback()
        {
            global $wpdb;

            $term_id = isset($_POST['term_id'])? intval($_POST['term_id']) : '';

            if (empty($term_id) || $term_id <= 0) {
                echo __("Term ID incorrect", WDM_WOO_SCHED_TXT_DOMAIN);
                die();
            }

            $table = $wpdb->prefix . 'woo_schedule_category';

            $where = array('term_id' => $term_id);

            $wpdb->delete($table, $where);

            die();

        }

        public function noDisplayMessage()
        {
            ?>
            <p><?php _e('No details saved.', WDM_WOO_SCHED_TXT_DOMAIN); ?></p>
    <?php
        }
    }
}

function wdm_selection_type_product($wdm_start_date, $wdm_end_date, $selections_list, $days_selected)
{
    if (!empty($wdm_start_date) && !empty($wdm_end_date)) {
        $start = substr($wdm_start_date, 0, strpos($wdm_start_date, ','));
        $end = substr($wdm_end_date, 0, strpos($wdm_end_date, ','));

        $start = strtotime(trim($start));
        $end = strtotime(trim($end));

        $start_time = trim(substr($wdm_start_date, strpos($wdm_start_date, ',')+1));
        $end_time = trim(substr($wdm_end_date, strpos($wdm_end_date, ',')+1));

        $start_time_hr = substr($start_time, 0, strpos($start_time, ':'));
        $end_time_hr = substr($end_time, 0, strpos($end_time, ':'));

        $start_time_min = substr($start_time, strpos($start_time, ':')+1);
        $end_time_min = substr($end_time, strpos($end_time, ':')+1);

        $type = get_option('woocommerce_custom_product_expiration_type');

        $start_time  = $start_time_hr . ":" . $start_time_min . ":00";
        $end_time    = $end_time_hr . ":" . $end_time_min . ":59";

        $str_start_time  = strtotime($start_time);
        $str_end_time    = strtotime($end_time);

/*
* Checking whether Start Time is greater than End Time. If true, both of them are set the same value.
* 
*/

        if ($type == 'per_day') {
            if ($str_start_time > $str_end_time) {
                $start_time_hr   = $end_time_hr;
                $start_time_min  = $end_time_min;
            }
            if ($end < $start) {
                $end = $start;
            }
        }

        foreach ($selections_list as $selections_id) {
        //Update selection details

            if ($days_selected!='') {
                update_post_meta($selections_id, 'wdm_days_selected', $days_selected);
            } else {
                delete_post_meta($selections_id, 'wdm_days_selected');
            }

            update_post_meta($selections_id, 'wdm_start_date', date('m/d/Y', $start));
            update_post_meta($selections_id, 'wdm_end_date', date('m/d/Y', $end));

        /*
        * Updating the start and end time
        *              
        */
            if ($start_time_hr != -1 && $start_time_min != -1 && $end_time_hr != -1 && $end_time_min != -1) {
                update_post_meta($selections_id, 'wdm_start_time_hr', $start_time_hr);
                update_post_meta($selections_id, 'wdm_start_time_min', $start_time_min);
                update_post_meta($selections_id, 'wdm_end_time_hr', $end_time_hr);
                update_post_meta($selections_id, 'wdm_end_time_min', $end_time_min);

            } else {
                update_post_meta($selections_id, 'wdm_start_time_hr', -1);
                update_post_meta($selections_id, 'wdm_start_time_min', -1);
                update_post_meta($selections_id, 'wdm_end_time_hr', -1);
                update_post_meta($selections_id, 'wdm_end_time_min', -1);
            }

        }//foreach ends -- selections list loop ends
    } else {
        foreach ($selections_list as $selections_id) {
            delete_post_meta($selections_id, 'wdm_start_date');
            delete_post_meta($selections_id, 'wdm_end_date');
            delete_post_meta($selections_id, 'wdm_start_time_hr');
            delete_post_meta($selections_id, 'wdm_start_time_min');
            delete_post_meta($selections_id, 'wdm_end_time_hr');
            delete_post_meta($selections_id, 'wdm_end_time_min');
        }
    }
}

/**
 * update schedule if selection type is category
 * @param  [type] $selections_list [description]
 * @param  String $days_selected   [description]
 * @param  String $wdm_start_date  [description]
 * @param  String $wdm_end_date    [description]
 * @return [type]                  [description]
 */
function wdm_selection_type_category($selections_list, $days_selected, $wdm_start_date, $wdm_end_date)
{
    if (!empty($wdm_start_date) && !empty($wdm_end_date)) {
        $wdm_start_date = $wdm_start_date . ':00';
        $wdm_end_date = $wdm_end_date . ':59';
        $type = get_option('woocommerce_custom_product_expiration_type');

//Update selection details

        if (!empty($days_selected)) {
            $days_selected = serialize($days_selected);
        }

        if (!($type == 'per_day')) {
            $days_selected = '';
        }

        foreach ($selections_list as $selections_id) {
            woo_schedule_update_term_details($selections_id, date('Y-m-d H:i:s', strtotime($wdm_start_date)), date('Y-m-d H:i:s', strtotime($wdm_end_date)), $days_selected);
        }
    } else {
        woo_schedule_delete_term_details($selections_list);
    }
}

/**
 * check selection list is empty or not
 * @param  [type] $selection_type  [description]
 * @param  [type] $selections_list [description]
 * @return boolean                  [description]
 */
function wdm_check_empty($selection_type, $selections_list)
{
    if (!empty($selection_type) && !empty($selections_list) && is_array($selections_list)) {
        return true;
    }
    return false;
}

/**
 * check selection type is valid or not
 * @param  String $selection_type  current selection type
 * @param  Array $valid_selection valid selection types i.e product or category
 * @return boolean                  [description]
 */
function wdm_check_selection_type($selection_type, $valid_selection)
{
    if (empty($selection_type) || !in_array($selection_type, $valid_selection)) {
        return true;
    }
    return false;
}

/**
 * Save and display data for selected products
 * @param  [type] $selection_id [description]
 * @return [type]               [description]
 */
function wdm_product_selection($selection_id)
{
    $show_msg_counter = 0;
    $days_selection_type = get_option('woocommerce_custom_product_expiration_type');
    foreach ($selection_id as $single_selection) :
        $wdm_start_date   = get_post_meta($single_selection, 'wdm_start_date', true);
        $wdm_end_date     = get_post_meta($single_selection, 'wdm_end_date', true);

        $wdm_start_time_hr    = get_post_meta($single_selection, 'wdm_start_time_hr', true);
        $wdm_start_time_min   = get_post_meta($single_selection, 'wdm_start_time_min', true);
        $wdm_end_time_hr  = get_post_meta($single_selection, 'wdm_end_time_hr', true);
        $wdm_end_time_min     = get_post_meta($single_selection, 'wdm_end_time_min', true);
        $options = get_post_meta($single_selection, 'wdm_days_selected', true);

        if (!empty($options)) {
            $options = implode(',', array_keys($options));
        } else {
            $options = '--';
        }

        $ptitle = get_the_title($single_selection);

        $parent_id = wp_get_post_parent_id($single_selection);

        if ($parent_id != 0) {
            $variant_prod = new \WC_Product_Variation($single_selection);

            $attr = $variant_prod->get_variation_attributes();

            $ptitle = get_the_title($parent_id);

            $ptitle .= ' (';

            $cnt = count($attr);

            $i = 0;

            foreach ($attr as $key => $value) {
                $key = str_replace('attribute_', '', $key);
                $ptitle .= "$key:$value";

                if (++$i <= $cnt-1) {
                    $ptitle .= ' | ';
                }
            }

            $ptitle .= ')';

        }

?>
<?php if (!empty($wdm_start_date) && !empty($wdm_end_date)) {
    $show_msg_counter += 1; ?>
    <tr>  
        <td><?php echo $ptitle; ?></td>

        <td><?php echo date('Y-m-d', strtotime($wdm_start_date)) . ' ' . $wdm_start_time_hr . ':' . $wdm_start_time_min; ?></td>
        <td><?php echo date('Y-m-d', strtotime($wdm_end_date)) . ' ' . $wdm_end_time_hr . ':' . $wdm_end_time_min; ?> </td>
        <?php if ($days_selection_type == 'per_day') : ?>
            <td><?php echo $options;?> </td>
            <?php
endif; ?>

            <td>    <a href="#" class="btn wdm_delete_product" product_id="<?php echo$single_selection; ?>"><span class="glyphicon glyphicon-trash"></span></a></td>
        </tr>

        <?php
} ?>

    <?php

    endforeach;

    if ($show_msg_counter == 0) : ?>

    <tr><td><?php _e('No details saved', WDM_WOO_SCHED_TXT_DOMAIN); ?></td></tr>

    <?php
    endif;
}

/**
 * save and display result of category selection
 * @param  [type] $details_result      [description]
 * @param  [type] $days_selection_type [description]
 * @return [type]                      [description]
 */
function wdm_category_selection($details_result, $days_selection_type)
{
    $days_selection_type = get_option('woocommerce_custom_product_expiration_type');
    if (!empty($details_result)) {
        foreach ($details_result as $single_result) {
            $wdm_start_date = wdm_check_isset($single_result->start_date);
            $wdm_end_date = wdm_check_isset($single_result->end_date);
            $selected_days = wdm_check_isset($single_result->selected_days);
            if (!empty($selected_days)) {
                $selected_days = unserialize($selected_days);
                $selected_days = implode(',', array_keys($selected_days));
            } else {
                $selected_days = '--';
            }
            $term_array = get_term_by('id', $single_result->term_id, 'product_cat', 'ARRAY_A');
            $title = isset($term_array['name'])? $term_array['name'] : '';
            if (!empty($wdm_start_date) && !empty($wdm_end_date) && !empty($title)) {
                ?>
                <tr>
                    <td><?php echo $title; ?></td>
                    <td><?php echo date("Y-m-d H:i", strtotime($wdm_start_date)); ?></td>
                    <td><?php echo date("Y-m-d H:i", strtotime($wdm_end_date)); ?></td>
                    <?php if ($days_selection_type == 'per_day') : ?>
                        <td><?php echo $selected_days; ?> </td>
                        <?php
endif; ?>
                        <td>    <a href="#" class="btn wdm_delete_term" term_id="<?php echo $single_result->term_id; ?>"><span class="glyphicon glyphicon-trash"></span></a></td>
                    </tr>
                    <?php
            }
        }
    } else {
        ?>
        <tr><td><?php _e('No details saved', WDM_WOO_SCHED_TXT_DOMAIN); ?></td></tr>
            <?php
    }
}

/**
 * check isset for variables
 * @param  [type] $data [description]
 * @return [type]       [description]
 */
function wdm_check_isset($data)
{
    if (isset($data)) {
        return $data;
    } else {
        return '';
    }
}

/**
 * returns list of products variations in dropdown.
 * @return [type] [description]
 */
function handleProductSelectionCallType()
{
    $args = array('post_type' => array('product'),
        'post_status' => array('publish','draft'),
        'posts_per_page' => -1,
        'orderby' => 'title',
        'order' => 'ASC',
        'fields' => 'ids'
        );

    $simples = get_posts($args);
    foreach ($simples as $sid) {
        $product = get_product($sid);
        if ($product->product_type === 'simple') {
            $results[$sid] = get_the_title($sid);
        }
    }

    $args = array('post_type' => array('product_variation'),
        'post_status' => array('publish','draft','private'),
        'posts_per_page' => -1,
        'orderby' => 'title',
        'order' => 'ASC',
        'fields' => 'ids'
        );
    $variants = get_posts($args);
    foreach ($variants as $vid) {
        $parent_id = wp_get_post_parent_id($vid);

        if ($parent_id != 0) {
            $variant_prod = new \WC_Product_Variation($vid);
            $attr = $variant_prod->get_variation_attributes();
            $vtitle = get_the_title($parent_id);
            if (isset($vtitle) && !empty($vtitle)) {
                $vtitle .= ' (';
                $cnt = count($attr);
                $i = 0;
                foreach ($attr as $key => $value) {
                    $key = str_replace('attribute_', '', $key);
                    $vtitle .= "$key:$value";

                    if (++$i <= $cnt-1) {
                        $vtitle .= ' | ';
                    }
                }
                            $vtitle .= ')';
                $results[$vid] = $vtitle;
            }
        }
    }
    return $results;
}