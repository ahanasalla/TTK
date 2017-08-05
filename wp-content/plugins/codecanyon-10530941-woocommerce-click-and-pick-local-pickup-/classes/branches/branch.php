<?php

namespace Click_And_Pick\Branch;

use Click_And_Pick\Click_And_Pick;
use Click_And_Pick\Helpers\Helper;

/**
 * Class Click_And_Pick_Branch
 * @package Click_And_Pick\Branch
 */
class Click_And_Pick_Branch
{

    /**
     * @var Helper
     */
    public $helper;

    /**
     * Construction
     */
    public function __construct()
    {
        $this->helper = new Helper(); // get to the helper methods

        $this->cbt_class();
        $this->adding_the_branch_details();
        add_action('cmb2_init', array($this, 'adding_the_branch_meta_fields'));

        add_action( 'wp_ajax_save_branches_order', array( $this, 'save_branches_order') );
        add_action('pre_get_posts', array($this, 'reorder_branches'), 1);
    }


    public function save_branches_order()
    {
        $ids = serialize($_POST['ids']);
        $updated = update_option("_clicknpick_branches_order", $ids);
        echo json_encode(array( "updated" => $updated ));
        wp_die();
    }


    /**
     * Adding the details in the lists for the posts
     */
    private function adding_the_branch_details()
    {
        $branch = new \CPT(array(
            'post_type_name' => 'branch',
            'singular' => 'Branch',
            'plural' => 'Branches',
            'slug' => 'branch',
        ), array(
            'supports' => array(
                'title',
            ),
        ));

        $branch->columns(array(
            'cb' => '<input type="checkbox" />',
            'title' => __('Title'),
            'working_hours' => __('Working hours'),
            'vacations' => __('Vacations'),
            'date' => __('Date'),
        ));

        $branch->populate_column('working_hours', function ($column, $post) {
            $from = get_post_meta($post->ID, '_clicknpick_branch_from', true);
            $to = get_post_meta($post->ID, '_clicknpick_branch_to', true);

            if (!empty($from) || !empty($to)) {
                echo "<b>From</b> : " . $from . "<br/><b>To</b> : " . $to;
            } else {
                _e('No working hours specified', Click_And_Pick::TEXTDOMAIN);
            }

        });

        // $branch->populate_column('working_days', function ($column, $post) {
        //     $from = get_post_meta($post->ID, '_clicknpick_branch_working_day_from', true);
        //     $to = get_post_meta($post->ID, '_clicknpick_branch_working_day_to', true);

        //     if (!empty($from) || !empty($to)) {
        //         echo "<b>From</b> : " . $from . "<br/><b>To</b> : " . $to;
        //     } else {
        //         _e('No Working days specified', Click_And_Pick::TEXTDOMAIN);
        //     }
        // });

        $branch->populate_column('vacations', function ($column, $post) {
            $vacations = get_post_meta($post->ID, '_clicknpick_branches_vacations', true);
            if (!empty($vacations)) {
                foreach ($vacations as $v) {
                    echo ucfirst($v) . "<br/>";
                }
            } else {
                _e('No Vacations Specified', Click_And_Pick::TEXTDOMAIN);
            }
        });

        $branch->menu_icon('dashicons-admin-site');

    }

    /**
     *  adding the branches meta fields
     */
    public function adding_the_branch_meta_fields()
    {
        $prefix = '_clicknpick_'; // Prefix for all fields

        /*
        |--------------------------------------------------------------------------
        | Branches Time
        |--------------------------------------------------------------------------
         */
        $branch_time = new_cmb2_box(array(
            'id' => 'branches_time',
            'title' => __('Working Hours', Click_And_Pick::TEXTDOMAIN),
            'object_types' => array('branch'), // Post type
            'context' => 'side',
            'priority' => 'high',
            'show_names' => true, // Show field names on the left
        ));

        $branch_time->add_field(array(
            'name' => __("From", Click_And_Pick::TEXTDOMAIN),
            'id' => $prefix . 'branch_from',
            'type' => 'text_time',
            'time_format' => 'H:i',
        ));

        $branch_time->add_field(array(
            'name' => __("To", Click_And_Pick::TEXTDOMAIN),
            'id' => $prefix . 'branch_to',
            'type' => 'text_time',
            'time_format' => 'H:i',
        ));

        /*
        |--------------------------------------------------------------------------
        | Branches working days
        |--------------------------------------------------------------------------
         */
        // $branches_meta_working_days = new_cmb2_box(array(
        //     'id' => 'branches_working_days',
        //     'title' => __('Working Days', Click_And_Pick::TEXTDOMAIN),
        //     'object_types' => array('branch'), // Post type
        //     'context' => 'side',
        //     'priority' => 'high',
        //     'show_names' => true, // Show field names on the left
        // ));

        // $branches_meta_working_days->add_field(
        //     array(
        //         'name' => __("From", Click_And_Pick::TEXTDOMAIN),
        //         'id' => $prefix . 'branch_working_day_from',
        //         'type' => 'text_date',
        //     )
        // );

        // $branches_meta_working_days->add_field(
        //     array(
        //         'name' => __("To", Click_And_Pick::TEXTDOMAIN),
        //         'id' => $prefix . 'branch_working_day_to',
        //         'type' => 'text_date',
        //     )
        // );

        /*
        |--------------------------------------------------------------------------
        | Branches Vacations
        |--------------------------------------------------------------------------
         */
        $branches_vacations = new_cmb2_box(array(
            'id' => 'branches_vacations',
            'title' => __('Vacations', Click_And_Pick::TEXTDOMAIN),
            'object_types' => array('branch'), // Post type
            'context' => 'normal',
            'priority' => 'high',
            'show_names' => true, // Show field names on the left
        ));

        $branches_vacations->add_field(
            array(
                'name' => __('Vacations', Click_And_Pick::TEXTDOMAIN),
                'id' => $prefix . 'branches_vacations',
                'type' => 'multicheck',
                'options' => array(
                    'sunday' => 'Sunday',
                    'monday' => 'Monday',
                    'tuesday' => 'Tuesday',
                    'wednesday' => 'Wednesday',
                    'thursday' => 'Thursday',
                    'friday' => 'Friday',
                    'saturday' => 'Saturday',
                ),
            ));

        /*
        |--------------------------------------------------------------------------
        | Branches Notes
        |--------------------------------------------------------------------------
         */
        $branches_notes = new_cmb2_box(array(
            'id' => 'branches_notes',
            'title' => __('Add note for this branch', Click_And_Pick::TEXTDOMAIN),
            'object_types' => array('branch'), // Post type
            'context' => 'normal',
            'priority' => 'high',
            'show_names' => true, // Show field names on the left
        ));

        $branches_notes->add_field(array(
            'name' => __('Note', Click_And_Pick::TEXTDOMAIN),
            'id' => $prefix . 'branches_notes',
            'type' => 'text',
        ));

        /*
        |--------------------------------------------------------------------------
        | Branch order pickup delay
        |--------------------------------------------------------------------------
         */
        $branches_notes = new_cmb2_box(array(
            'id' => 'branches_pickup_delay',
            'title' => __('Branch\'s order pickup delay', Click_And_Pick::TEXTDOMAIN),
            'object_types' => array('branch'), // Post type
            'context' => 'normal',
            'priority' => 'high',
            'show_names' => true, // Show field names on the left
        ));

        $branches_notes->add_field(array(
            'name' => __('Delay (in hours)', Click_And_Pick::TEXTDOMAIN),
            'id' => $prefix . 'branches_order_pickup_delay',
            'type' => 'text',
        ));

        /*
        |--------------------------------------------------------------------------
        | Branches Locations
        |--------------------------------------------------------------------------
         */
        $branches_location = new_cmb2_box(array(
            'id' => 'branches_location',
            'title' => __('Get location on map', Click_And_Pick::TEXTDOMAIN),
            'object_types' => array('branch'), // Post type
            'context' => 'normal',
            'priority' => 'high',
            'show_names' => true, // Show field names on the left
        ));


        $branches_location->add_field(
            array(
                'name' => 'Show the location',
                'id' => $prefix . 'branches_location_show',
                'type' => 'checkbox',
            )
        );


        $branches_location->add_field(
            array(
                'name' => 'Location',
                'desc' => __('Drag the marker to set the exact location', Click_And_Pick::TEXTDOMAIN),
                'id' => $prefix . 'branches_location',
                'type' => 'pw_map',
                'split_values' => true, // Save latitude and longitude as two separate fields
            )
        );
    }

    /**
     * reorder the branches in the admin page
     *
     * @return bool
     */
    public function reorder_branches( $query )
    {
        $branches_id = get_option( "_clicknpick_branches_order" );

        if ($query->is_main_query() && $query->is_admin && $query->query['post_type'] == "branch" && !empty($branches_id)) {
            $query->set("post__in", unserialize($branches_id));
            $query->set("orderby", "post__in");
        }

        return false;
    }
    /**
     *
     */
    private function cbt_class()
    {
        require_once plugin_dir_path(__FILE__) . '../../extras/CPT.php'; // include custom post type
    }

}
