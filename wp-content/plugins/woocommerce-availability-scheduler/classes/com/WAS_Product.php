<?php 
class WAS_product
{
	public function __construct()
	{
		add_action('wp_ajax_wcas_reset_products_avaiability', array(&$this, 'ajax_reset_products_avaiability'));
	}
	//start_time,end_time,expiring_date
	public function get_product_date_info($porduct_id, $type_of_date = 'start_time')
	{
		$result = WAS_PostAddon::get_post_meta($porduct_id);
		$time_offset = WAS_OptionsMenu::get_option('time_offset');
		$today = date("N", strtotime($time_offset.' minutes'))-1;
		
		
		switch($type_of_date)
		{
			case 'start_time': return isset($result["stat_time"][$today]) ? $result["stat_time"][$today] :  ""; break;
			case 'end_time': return isset($result["end_time"][$today]) ? $result["end_time"][$today] :  ""; break;
			case 'expiring_date': return isset($result['expiring_date']) ? $result['expiring_date'] :  ""; break;
		}
		return "";
	}
	public function validate_current_cart_products()
	{
		//$cart = WC()->cart->get_cart();
		//$cart = WC()->cart;
		$results = array();
		$items_to_remove = array();
		foreach(WC()->cart->get_cart() as $cart_item_key => $item)
		{
			$results[] = $this->check_if_product_can_be_purchase_due_to_purchase_limit($item['data']->post->post_title, $item['product_id'], $item['variation_id'], $item['quantity']);	
			if(get_post_status($item['product_id']) != 'publish')
			{
				$temp_result_data = array();
				$temp_result_data['result'] = false;
				$temp_result_data['messages'] = array(0 => sprintf( __('You cannot buy product %s. If you procede with the checkout it will not be included in your order','woocommerce-availability-scheduler'), $item['data']->post->post_title));
				$results[] = $temp_result_data;
				//wcas_var_dump($cart_item_key);
				$items_to_remove[] = $cart_item_key;
			}
		}
		if(!empty($items_to_remove))
			foreach($items_to_remove as $item_to_remove)
				WC()->cart->remove_cart_item($item_to_remove);
		return $results;
	}
	public function get_current_and_total_sales_limit($product_id)
	{
		//$today = date("N", strtotime($time_offset.' minutes'))-1;
		$sales_limit = $this->get_product_single_meta($product_id,'_was_total_sales_limit');
		$total_sales = $this->get_today_product_total_sales($product_id);
		$total_sales = is_numeric($total_sales) ? $total_sales : 0;
		return isset($sales_limit) ? array('sales_limit' =>$sales_limit, 'total_sales' =>$total_sales) : false; 
	}
	public function check_if_product_can_be_purchase_due_to_purchase_limit($item_name, $product_id, $variation_id = 0, $quantity = 0, $absolute_quantity = true)
	{
		$result_data = array('result' => true, 'messages' => array(), 'product_id' => $product_id, 'variation_id' => $variation_id, 'cart_item_key'=>null, 'quantity' => $quantity);
		$time_offset = WAS_OptionsMenu::get_option('time_offset');
		$today = date("N", strtotime($time_offset.' minutes'))-1;
		$sales_limit = $this->get_product_single_meta($product_id,'_was_total_sales_limit');
		
		if(!$absolute_quantity)
		{
			$cart = WC()->cart;	
			foreach($cart->cart_contents as $cart_item_key => $item)
			{
				if($item['product_id'] == $product_id)
				{
					/* if($item['variation_id'] == 0 || $item['variation_id'] == $variation_id)
						$result_data['cart_item_key'] = $cart_item_key;
						
					$item_name = $item['data']->post->post_title; 
					if(!$absolute_quantity)*/
						 $quantity += $item['quantity'];
					
				}
			}
		}
		if(isset($sales_limit) && isset($sales_limit[$today]) && $sales_limit[$today] != 0)
		{
			$total_sales = $this->get_today_product_total_sales($product_id);
			if(is_numeric($total_sales) && ($quantity > (int)$sales_limit[$today] - $total_sales || $total_sales > $sales_limit[$today]))
			{
				$result_data['result'] = false;
				$name_to_output = isset($item_name) ? $item_name  : __('the selected product','woocommerce-availability-scheduler');
				$purchasable_number = $sales_limit[$today] - $total_sales > 0 ? $sales_limit[$today] - $total_sales : 0;
				$result_data['messages'][] = sprintf( __('You cannot buy more than %d for the product %s.','woocommerce-availability-scheduler'), $purchasable_number, $name_to_output);
			}
		}
		
		return $result_data;
	}
	public function get_product_single_meta($product_id, $meta_name)
	{
		return  get_post_meta( $product_id, $meta_name, true );
	}
	public function ajax_reset_products_avaiability()
	{
		global $wpdb;
		$query = "DELETE 
					FROM {$wpdb->postmeta} ".
					"WHERE meta_key LIKE '_was_%' ";
					/* WHERE meta_key IN('_was_period', '_was_start_time','_was_end_time','_was_shop_page_msg','_was_shop_page_during_msg','_was_shop_page_after_msg'
									   '_was_product_page_msg','_was_product_page_during_msg','_was_product_page_after_msg','_was_countdown_to_start',
									   '_was_countdown_to_end','_was_always_show_shop_message','_was_always_show_product_message','_was_where_countdown_to_start',
									   '_was_always_show_shop_message','_was_always_show_product_message', '_was_where_countdown_to_start', '_was_where_countdown_to_end',
									   '_was_where_sales_progressbar', '_was_expiring_date', '_was_total_sales_limit', '_was_total_sales_limit', '_was_customer_roles_restriction_type',
									   '_was_customer_roles_restriction_message') " */;
		$wpdb->get_results($query);
		wp_die();
	}
	public function get_product_meta($post_id)
	{
		$result = array();
		$result["ID"] = $post_id;
		$result["availability_strategy"] = get_post_meta( $post_id, '_was_period', true );
		$result["stat_time"] = get_post_meta( $post_id, '_was_start_time', true );
		$result["end_time"] = get_post_meta( $post_id, '_was_end_time', true );
		
		$result["shop_page_msg"] = get_post_meta( $post_id, '_was_shop_page_msg', true );
		$result["shop_page_during_msg"] = get_post_meta( $post_id, '_was_shop_page_during_msg', true );
		$result["shop_page_after_msg"] = get_post_meta( $post_id, '_was_shop_page_after_msg', true );
		
		$result["product_page_msg"] = get_post_meta( $post_id, '_was_product_page_msg', true );
		$result["product_page_during_msg"] = get_post_meta( $post_id, '_was_product_page_during_msg', true );
		$result["product_page_after_msg"] = get_post_meta( $post_id, '_was_product_page_after_msg', true );
		
		$result["countdown_to_start"] = get_post_meta($post_id, '_was_countdown_to_start', true);
		$result["countdown_to_end"] = get_post_meta( $post_id, '_was_countdown_to_end', true);
		$result["always_show_shop_message"] = get_post_meta( $post_id, '_was_always_show_shop_message', true);
		$result["always_show_product_message"] = get_post_meta( $post_id, '_was_always_show_product_message', true);
		$result["where_countdown_to_start"] = get_post_meta($post_id, '_was_where_countdown_to_start', true);
		$result["where_countdown_to_end"] = get_post_meta( $post_id, '_was_where_countdown_to_end', true);
		$result["where_sales_progressbar"] = get_post_meta( $post_id, '_was_where_sales_progressbar', true);
		$result["expiring_date"] = get_post_meta( $post_id, '_was_expiring_date', true);
		$result["visible_after_expiring_date"] = get_post_meta( $post_id, '_was_visible_after_expiring_date', true);
		
		$result["hide"] = get_post_meta( $post_id, '_was_hide', true);
		$result["total_sales_limit"] = get_post_meta( $post_id, '_was_total_sales_limit', true);
		
		$result["was_customer_roles_restriction_type"] = get_post_meta( $post_id, '_was_customer_roles_restriction_type', true);
		$result["was_customer_roles"] = get_post_meta( $post_id, '_was_customer_roles', true);
		$result["was_customer_roles_restriction_message"] = get_post_meta( $post_id, '_was_customer_roles_restriction_message', true);
		
		if(empty($result["availability_strategy"]))
			return false;
		
		return $result;
	}
	public function save_product_meta($post_id, $skip_id_translation_check = false)
	{
		global $was_wpml_model;
		if($was_wpml_model->wpml_is_active() && !$skip_id_translation_check)
		{
			$translated_ids = $was_wpml_model->get_translated_id($post_id);
			//wcas_var_dump($translated_ids);
			if(!empty($translated_ids))
				foreach($translated_ids as $translation_id)
					$this->save_product_meta($translation_id, true);
		}
					
		update_post_meta( $post_id, '_was_period', isset($_POST['_was_period']) ? $_POST['_was_period'] : null );
		update_post_meta( $post_id, '_was_start_time',isset( $_POST['_was_start_time']) ? $_POST['_was_start_time'] : null);
		update_post_meta( $post_id, '_was_end_time', isset( $_POST['_was_end_time']) ? $_POST['_was_end_time'] : null );
		
		if(isset($_POST['_was_shop_page_msg']))
			update_post_meta( $post_id, '_was_shop_page_msg', $_POST['_was_shop_page_msg'] );
		if(isset($_POST['_was_shop_page_during_msg']))
			update_post_meta( $post_id, '_was_shop_page_during_msg', $_POST['_was_shop_page_during_msg'] );
		if(isset($_POST['_was_shop_page_after_msg']))
			update_post_meta( $post_id, '_was_shop_page_after_msg', $_POST['_was_shop_page_after_msg'] );
		if(isset($_POST['_was_product_page_msg']))
			update_post_meta( $post_id, '_was_product_page_msg', $_POST['_was_product_page_msg'] );
		if(isset($_POST['_was_product_page_during_msg']))
			update_post_meta( $post_id, '_was_product_page_during_msg', $_POST['_was_product_page_during_msg'] );
		if(isset($_POST['_was_product_page_after_msg']))
			update_post_meta( $post_id, '_was_product_page_after_msg', $_POST['_was_product_page_after_msg'] );
		
		if(isset($_POST['_was_hide']))
			update_post_meta( $post_id, '_was_hide',  $_POST['_was_hide'] );
		else
			update_post_meta( $post_id, '_was_hide', null);
		
		if(isset($_POST['_was_total_sales_limit']))
			update_post_meta( $post_id, '_was_total_sales_limit',  $_POST['_was_total_sales_limit'] );
		else
			update_post_meta( $post_id, '_was_total_sales_limit', 0);
		
		if(isset($_POST['_was_countdown_to_start']))
			update_post_meta( $post_id, '_was_countdown_to_start',  $_POST['_was_countdown_to_start'] );
		if(isset($_POST['_was_countdown_to_end']))
			update_post_meta( $post_id, '_was_countdown_to_end',  $_POST['_was_countdown_to_end'] );
			/* update_post_meta( $post_id, '_was_always_show_shop_message',  $_POST['_was_always_show_shop_message'] );
			update_post_meta( $post_id, '_was_always_show_product_message', $_POST['_was_always_show_product_message'] ); */
		if(isset($_POST['_was_where_countdown_to_start']))
			update_post_meta( $post_id, '_was_where_countdown_to_start',  $_POST['_was_where_countdown_to_start'] );
		if(isset($_POST['_was_where_countdown_to_end']))
			update_post_meta( $post_id, '_was_where_countdown_to_end',  $_POST['_was_where_countdown_to_end'] );
		
		if(isset($_POST['_was_where_sales_progressbar']))
			update_post_meta( $post_id, '_was_where_sales_progressbar',  $_POST['_was_where_sales_progressbar'] );
		
		//Expiring date
		update_post_meta( $post_id, '_was_expiring_date',  isset($_POST['_was_expiring_date']) ? $_POST['_was_expiring_date'] : null );
		update_post_meta( $post_id, '_was_visible_after_expiring_date',  isset($_POST['_was_visible_after_expiring_date']) ? $_POST['_was_visible_after_expiring_date'] : null );
		
		update_post_meta( $post_id, '_was_customer_roles',  isset($_POST['_was_customer_roles']) ? $_POST['_was_customer_roles'] : "" );
		if(isset($_POST['_was_customer_roles_restriction_type']))
			update_post_meta( $post_id, '_was_customer_roles_restriction_type',  $_POST['_was_customer_roles_restriction_type'] );
		
		update_post_meta( $post_id, '_was_customer_roles_restriction_message',  $_POST['_was_customer_roles_restriction_message'] );
	}
	/*
	$post_id - The ID of the post you'd like to change.
	$status -  The post status publish|pending|draft|private|static|object|attachment|inherit|future|trash.
	*/
	public function change_product_status($post_id,$status){
		//$current_post = get_post( $post_id, 'ARRAY_A' );
		$current_post = array();
		$current_post['ID'] = $post_id;
		$current_post['post_status'] = $status;
		wp_update_post($current_post);
	}
	public function bulk_change_products_status($ids, $status = 'publish')
	{
		/* global $wpdb;
		$query = "UPDATE {$wpdb->posts} as products
		          SET  products.post_status = '{$status}'
				  WHERE products.ID IN ('".implode("','",$ids)."')
				  ";
		$wpdb->get_results($query);  */ 
		$products_array = array();
		foreach((array)$ids as $id)
			wp_update_post( array('ID' => $id, 'post_status' => $status));  
	}
	public function get_today_product_total_sales($product_id)
	{
		global $was_wpml_model,$was_order_model;
		$all_ids = array(0 => $product_id);
		if($was_wpml_model->wpml_is_active())
		{
			$translated_ids = $was_wpml_model->get_translated_id($product_id);
			//wcas_var_dump($translated_ids);
			if(!empty($translated_ids))
				foreach($translated_ids as $translation_id)
					array_push($all_ids, $translation_id);
		}
		return $was_order_model->get_today_orders_by_product_id($all_ids);
	}
	
	public function is_product_expired_but_visible($product_id)
	{
		if($this->product_has_expired($product_id))
		{
			$still_visible = get_post_meta( $product_id, '_was_visible_after_expiring_date', true);
			if(isset($still_visible))
				return true;
		}
		return false;
	}
	//hides expired product (due to expiring date or for today unavailability)
	public function hide_expired_products()
	{
		global $wpdb, $was_post_remover;
		//$wpdb->query('SET OPTION SQL_BIG_SELECTS = 1');
		$wpdb->query('SET SQL_BIG_SELECTS=1');
		$query = "SELECT products.ID as ID,  productmeta_expiring_date.meta_value as expiring_date, productmeta_hide.meta_value as hide, 
				  productmeta_period.meta_value as availability_strategy, productmeta_start_time.meta_value as stat_time, productmeta_end.meta_value as end_time,
				  productmeta_total_sale_limit.meta_value as total_sales_limit, productmeta_visible_after_expiring_date.meta_value as visible_after_expiring_date
				  FROM {$wpdb->posts} as products
				  INNER JOIN {$wpdb->postmeta} as productmeta_hide ON productmeta_hide.post_id = products.ID
				  INNER JOIN {$wpdb->postmeta} as productmeta_expiring_date ON productmeta_expiring_date.post_id = products.ID
				  INNER JOIN {$wpdb->postmeta} as productmeta_period ON productmeta_period.post_id = products.ID
				  INNER JOIN {$wpdb->postmeta} as productmeta_start_time ON productmeta_start_time.post_id = products.ID
				  INNER JOIN {$wpdb->postmeta} as productmeta_end ON productmeta_end.post_id = products.ID
				  INNER JOIN {$wpdb->postmeta} as productmeta_total_sale_limit ON productmeta_total_sale_limit.post_id = products.ID
				  INNER JOIN {$wpdb->postmeta} as productmeta_visible_after_expiring_date ON productmeta_visible_after_expiring_date.post_id = products.ID
				  AND products.post_status = 'publish'
				  AND productmeta_hide.meta_key = '_was_hide'
				  AND productmeta_expiring_date.meta_key = '_was_expiring_date' 
				  AND productmeta_period.meta_key = '_was_period' 
				  AND productmeta_start_time.meta_key = '_was_start_time' 
				  AND productmeta_end.meta_key = '_was_end_time' 
				  AND productmeta_total_sale_limit.meta_key = '_was_total_sales_limit' 
				  AND productmeta_visible_after_expiring_date.meta_key = '_was_visible_after_expiring_date' 
				  GROUP BY products.ID";
		$products = $wpdb->get_results($query, 'ARRAY_A');	
		 //$wpdb->show_errors();
		//wcas_var_dump($products);
		if(empty($products))
			return false;
	
		$time_offset = WAS_OptionsMenu::get_option('time_offset');
		$today = date("Y-m-d G:i", strtotime($time_offset.' minutes'));
		$today_number = date("N", strtotime($time_offset.' minutes'))-1;
		$removed_expired = false;
		$products_ids = array();
		
		foreach($products as $product)
		{
			$today_day = date("N", strtotime($time_offset.' minutes'))-1;
			$product['availability_strategy'] = isset($product['availability_strategy']) ? unserialize($product['availability_strategy']) : null;
			$product['hide'] = isset($product['hide']) ? unserialize($product['hide']) : null;
			$product['stat_time'] = isset($product['stat_time']) ? unserialize($product['stat_time']) : null;
			$product['end_time'] = isset($product['end_time']) ? unserialize($product['end_time']) : null;			
			$product['expiring_date'] = isset($product['expiring_date']) ? $product['expiring_date'] : null;
			$product['visible_after_expiring_date'] = isset($product['visible_after_expiring_date']) ? $product['visible_after_expiring_date'] : null;
			$product['total_sales_limit'] = isset($product['total_sales_limit']) ? unserialize($product['total_sales_limit']) : null;
			$hide_option =  isset($product["hide"]) && isset($product["hide"][$today_number]) ? $product["hide"][$today_number]: null;
			$current_period = $was_post_remover->AS_get_current_period($product);
			
			//var_dump($hide_option." ".$current_period." ".$was_post_remover->AS_is_disabled_for_today($product));
			//var_dump($product);
			/* if($product['ID'] == 12)
			{
				wcas_var_dump($product['ID']);
				wcas_var_dump($product['availability_strategy'][$today_day]);
				wcas_var_dump($current_period);
				wcas_var_dump($hide_option); 
			}  */
			
			/* if($product['ID'] == 32)
			{
				 wcas_var_dump(strtotime($today));
				 wcas_var_dump(strtotime($product['expiring_date']));
				 wcas_var_dump(strtotime($product['expiring_date']) <= strtotime($today));
			} */
			if((isset($product['expiring_date']) && !isset($product['visible_after_expiring_date']) && $product['expiring_date'] != "" && strtotime($product['expiring_date']) <= strtotime($today)) ||
			   (isset($hide_option) && ( ($product['availability_strategy'][$today_day] == 1 && ($current_period != "during" && $current_period != "all_day")) ||
										 ($product['availability_strategy'][$today_day] == 3 && $current_period == "during") ||
										  $was_post_remover->AS_is_disabled_for_today($product))
			   ))
			   {
				  
					array_push($products_ids, $product['ID']);
					$removed_expired = true;
				}
		}
		if($removed_expired)
			$this->bulk_change_products_status($products_ids, 'draft');
		
		return $removed_expired;
	}
	public function product_has_expired($post_id)
	{
		global $wpdb;
		//$wpdb->query('SET OPTION SQL_BIG_SELECTS = 1');
		$wpdb->query('SET SQL_BIG_SELECTS=1');
		$query = "SELECT products.ID as ID, productmeta_hide.meta_value as hide, productmeta_expiring_date.meta_value as expiring_date     
				  FROM {$wpdb->posts} as products
				  INNER JOIN {$wpdb->postmeta} as productmeta_hide ON productmeta_hide.post_id = products.ID
				  INNER JOIN {$wpdb->postmeta} as productmeta_expiring_date ON productmeta_expiring_date.post_id = products.ID
				  WHERE products.ID = {$post_id}
				  AND products.post_status = 'publish'
				  AND productmeta_hide.meta_key = '_was_hide' 
				  AND productmeta_expiring_date.meta_key = '_was_expiring_date' ";
		$product = $wpdb->get_results($query, 'ARRAY_A');		
		$product = isset($product[0]) ? $product[0]:null;
		if($product == null)
			return false;
		
		$time_offset = WAS_OptionsMenu::get_option('time_offset');
		$today = date("Y-m-d G:i", strtotime($time_offset.' minutes'));
	
		if(isset($product['expiring_date']) && $product['expiring_date'] != "" && strtotime($product['expiring_date']) <= strtotime($today))
		{
			return true;
		}
		return false;
	}

	public function check_which_product_unhide()
	{
		global $wpdb, $was_post_remover;
		
		//$wpdb->query('SET OPTION SQL_BIG_SELECTS = 1');
		$wpdb->query('SET SQL_BIG_SELECTS=1');
		$query = "SELECT products.ID as ID, productmeta_hide.meta_value as hide, productmeta_period.meta_value as availability_strategy,
		          productmeta_start_time.meta_value as stat_time, productmeta_end.meta_value as end_time, productmeta_expiring_date.meta_value as expiring_date,
				  productmeta_total_sale_limit.meta_value as total_sales_limit , productmeta_visible_after_expiring_date.meta_value as visible_after_expiring_date      
				  FROM {$wpdb->posts} as products
				  INNER JOIN {$wpdb->postmeta} as productmeta_hide ON productmeta_hide.post_id = products.ID
				  INNER JOIN {$wpdb->postmeta} as productmeta_period ON productmeta_period.post_id = products.ID
				  INNER JOIN {$wpdb->postmeta} as productmeta_start_time ON productmeta_start_time.post_id = products.ID
				  INNER JOIN {$wpdb->postmeta} as productmeta_end ON productmeta_end.post_id = products.ID
				  INNER JOIN {$wpdb->postmeta} as productmeta_total_sale_limit ON productmeta_total_sale_limit.post_id = products.ID
				  INNER JOIN {$wpdb->postmeta} as productmeta_visible_after_expiring_date ON productmeta_visible_after_expiring_date.post_id = products.ID
				  LEFT JOIN {$wpdb->postmeta} as productmeta_expiring_date ON productmeta_expiring_date.post_id = products.ID  AND productmeta_expiring_date.meta_key = '_was_expiring_date' 
				  WHERE products.post_status = 'draft'
				  AND productmeta_hide.meta_key = '_was_hide' 
				  AND productmeta_period.meta_key = '_was_period' 
				  AND productmeta_start_time.meta_key = '_was_start_time' 
				  AND productmeta_end.meta_key = '_was_end_time' 
				  AND productmeta_total_sale_limit.meta_key = '_was_total_sales_limit' 
				  AND productmeta_visible_after_expiring_date.meta_key = '_was_visible_after_expiring_date'
				  GROUP BY products.ID ";
		$product_drafts = $wpdb->get_results($query, 'ARRAY_A');
		
		$time_offset = WAS_OptionsMenu::get_option('time_offset');
		$today = date("N", strtotime($time_offset.' minutes'))-1;
		$today_for_expiration = date("Y-m-d G:i", strtotime($time_offset.' minutes'));
		$time = date("H:i", strtotime($time_offset.' minutes'));
		$unhide_results = false;
		$products_ids = array();
		foreach($product_drafts as $product)
		{
			$product['availability_strategy'] = isset($product['availability_strategy']) ? unserialize($product['availability_strategy']) : null;
			$product['hide'] = isset($product['hide']) ? unserialize($product['hide']) : null;
			$product['stat_time'] = isset($product['stat_time']) ? unserialize($product['stat_time']) : null;
			$product['end_time'] = isset($product['end_time']) ? unserialize($product['end_time']) : null;
			$product['expiring_date'] = isset($product['expiring_date']) ? $product['expiring_date'] : null;
			$product['visible_after_expiring_date'] = isset($product['visible_after_expiring_date']) ? $product['visible_after_expiring_date'] : null;
			$product['total_sales_limit'] = isset($product['total_sales_limit']) ? unserialize($product['total_sales_limit']) : null;
			/* echo "<pre>";
			var_dump($product);
			echo "</pre>"; */
	
			//$result = WAS_PostAddon::get_post_meta($product->ID); 
			$current_period = $was_post_remover->AS_get_current_period($product); //$result["availability_strategy"]
			$hide_option =  isset($product["hide"]) && isset($product["hide"][$today]) ? $product["hide"][$today]: null;	
			/*  wcas_var_dump($product['ID']);
			wcas_var_dump($current_period);
			wcas_var_dump($hide_option);  */
			if(isset($product['expiring_date']) && $product['expiring_date'] != "" && strtotime($product['expiring_date']) <= strtotime($today_for_expiration))
			{
				$unhide_results = !isset($product['visible_after_expiring_date']) ? false : true;
			}
			else if((!isset($hide_option) && $was_post_remover->AS_is_disabled_for_today($product)) || ((/* isset($hide_option) && */ (($product['availability_strategy'][$today] == 1 && ($current_period == "during")) ||
																										($product['availability_strategy'][$today] == 3 && ($current_period != "during")))  
																				) || 
																				($current_period == "all_day" && !$was_post_remover->AS_is_disabled_for_today($product)) )
				)
			{
				array_push($products_ids, $product['ID']);
				$unhide_results = true;
			} 
		}
		if($unhide_results)
			$this->bulk_change_products_status($products_ids);
		
		return $unhide_results;
	}
}
?>