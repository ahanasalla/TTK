<?php

namespace Click_And_Pick\Helpers;

use Click_And_Pick\Click_And_Pick;

/**
 * Class Helper
 *
 * @property mixed click_and_pick
 * @package Click_And_Pick\Helpers
 */
class Helper
{

    /**
     * @var
     */
    public $click_and_pick;

    /**
     * @return array
     * Get the current completed order
     */
    public function get_current_completed_order()
    {
        $query = new \WP_Query(array(
            'post_type' => 'shop_order',
            'post_status' => 'wc-completed',
        ));

        $orders = $query->get_posts();

        // if there is no orders return false;
        if (empty($orders)) {
            return false;
        }

        foreach ($orders as $order) {
            $orders_comp[$order->ID] = $order->post_title;
        }

        return $orders_comp;

    }

    /**
     * @return array|bool
     * Get the current published branches
     */
    public function get_current_branches()
    {
        // Let's check here if there is order in the database
        $ids = get_option("_clicknpick_branches_order");
        if(!empty($ids)) {
            // Then get the branches corresponding to the order 
            $ids = unserialize($ids);
            foreach ($ids as $id) {
                $branches[] = get_post($id);
            }
        } else {
            $query = new \WP_Query(array(
                'post_type' => 'branch',
                'post_status' => 'publish',
                'posts_per_page' => -1,
            ));

          $branches = $query->get_posts();
        }
        

        // if there is no orders return false;
        if (empty($branches)) {
            return false;
        }

        return $branches;
    }

    /**
     * @param null $key
     *
     * @return mixed|void
     * Get the options for click and pick shipping method
     */
    public function getClickAndPickOptions($key = null)
    {

        $options = get_option('woocommerce_' . Click_And_Pick::TEXTDOMAIN . '_shipping_method_settings');

        if ($key == null) {
            return $options;
        }

        return $options[$key];

    }

    /**
     * @param $order_id
     * Check if the current order is click and pick order by checking for the branch
     * and the picked time
     *
     * @return bool
     */
    public function check_for_click_and_pick($order_id)
    {
        $branch = get_post_meta($order_id, 'click_n_pick_branch', true);
        $picked_time = get_post_meta($order_id, 'click_n_pick_picked_time', true);

        if (!empty($branch) && !empty($picked_time)) {
            return true;
        }

        return false;
    }

    /**
     * @param      $order_id
     * @param null $field_name
     * Get the branch by ID
     *
     * @return null|\WP_Post
     */
    public function get_branch($order_id, $field_name = null)
    {

        $branch_id = get_post_meta($order_id, 'click_n_pick_branch', true);

        $branch = get_post($branch_id, ARRAY_A);

        if (isset($field_name)) {
            return $branch[$field_name];
        }

        return $branch;
    }

    /**
     * @param      $branch_id
     * @param      $key
     * get the current branch meta data
     * @param bool $single
     *
     * @return bool|mixed
     */
    public function get_branch_meta($branch_id, $key, $single = true)
    {

        $value = get_post_meta($branch_id, $key, $single);

        if (!empty($value)) {
            return $value;
        }

        return false;
    }

    /**
     * @param $branch_id
     *
     * @return string
     * Get the vacations list
     *
     */
    public function get_vacations_list($branch_id)
    {

        $vacations = $this->get_branch_meta($branch_id, '_clicknpick_branches_vacations', false);

        if (!empty($vacations)) {

            foreach ($vacations[0] as $d) {

                $months = array(
                    "January",
                    "February",
                    "March",
                    "April",
                    "May",
                    "June",
                    "July",
                    "August",
                    "September",
                    "October",
                    "November",
                    "December",
                );

                foreach ($months as $key => $month) {
                    $date[$key] = new \DateTime("first $d of $month");
                    $thisMonth = $date[$key]->format('m');

                    while ($date[$key]->format('m') === $thisMonth) {
                        $days[] = $date[$key]->format('m/d/Y');
                        $date[$key]->modify("next $d");
                    }

                }

            }

            $day_list = implode('\',\'', $days); // get the days

            return $day_list;

        }

        return false;

    }

    /**
     * @param $orderId
     *
     * Get order time
     * @param $branchId
     * @return mixed|string
     *
     * Get order time also it handle if there is a delay in the time
     */
    public function get_order_time($orderId, $branchId)
    {
        // check first if there is delay in the time
        $delayTime = get_post_meta($branchId, '_clicknpick_branches_order_pickup_delay', true);
        $pickupDateTime = get_post_meta($orderId, 'click_n_pick_picked_time', true);
        $dateTime = new \DateTime($pickupDateTime);
        $delayDateTime = false;     // there is no delay time be default 

        if (!empty($delayTime)) {
            $delayedDateTime = $dateTime->modify("+$delayTime hour");
            $delayDateTime = $delayedDateTime->format('m/d/Y H:i');
            return array($pickupDateTime, $delayDateTime);
        }

        return array($pickupDateTime, $delayDateTime);

    }

}
