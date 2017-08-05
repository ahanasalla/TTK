<?php 
class WAS_Remover
{
	var $as_item_removed;
	var $already_add_to_cart_buttons_modified;	
	public function __construct()
	{
		/* Removal managment */
		add_action('init', array( &$this, 'AS_remove_single_product_page_add_to_cart_links'));
		add_filter('woocommerce_loop_add_to_cart_link',array( &$this,'AS_remove_shop_page_add_to_cart' ), 99, 2);
		add_action( 'wp', array(&$this, 'force_removing_extra_html_add_to_cart_buttons_on_shop_page') );
		
		//common javascript variables
		add_action('wp_head', array( &$this, 'add_common_js_code'));
		
		//cart check
		/* add_action( 'woocommerce_before_shop_loop_item', array( &$this,'AS_remove_unavailable_items_from_cart' ));
		add_action( 'woocommerce_before_main_content', array( &$this,'AS_remove_unavailable_items_from_cart' ));
		add_action( 'woocommerce_before_cart', array( &$this,'AS_remove_unavailable_items_from_cart' ));
		add_action( 'woocommerce_before_checkout_form', array( &$this,'AS_remove_unavailable_items_from_cart' )); */
		//add_action('woocommerce_update_cart_validation', array(&$this, 'AS_cart_update_validation'), 10, 4);
		
		//expired item
		/* add_action( 'woocommerce_before_single_product', array( &$this,'AS_remove_expired_item' ), 20);
		add_action( 'woocommerce_after_single_product', array( &$this,'AS_check_if_reload_page' ), 20);
		add_action( 'woocommerce_before_shop_loop_item', array( &$this,'AS_remove_expired_item'), 20 );
		add_action( 'woocommerce_after_shop_loop', array( &$this,'AS_check_if_reload_page'), 10 );
		add_action( 'woocommerce_before_shop_loop', array( &$this,'AS_before_shop_loop') , 10 ); */
		
		//forced actions
		add_action('woocommerce_after_single_product', array( &$this,'AS_force_remove_single_product_page_add_to_cart_button'));
		add_action('posts_request', array( &$this,'AS_check_if_unhide_products_and_update_cart')); //wp_loaded //posts_request
		
		add_action('woocommerce_checkout_process', array( &$this, 'checkout_validation' ));
		add_action('woocommerce_add_to_cart_validation', array(&$this, 'cart_add_to_validation'), 10, 5);
		add_action('woocommerce_update_cart_validation', array(&$this, 'cart_update_validation'), 10, 4);
		
		$this->already_add_to_cart_buttons_modified = array();
	}
	//Add to cart
	public function cart_add_to_validation( $original_result, $product_id, $quantity , $variation_id = 0, $variations = null )
	{
		global $woocommerce,$was_product_model;

		$product = new WC_Product($product_id);
		$result = $was_product_model->check_if_product_can_be_purchase_due_to_purchase_limit($product->get_title( ), $product_id,  $variation_id,  $quantity, false);
		
		if(!$result['result'])
			foreach($result['messages'] as $message)
				wc_add_notice( $message ,'error');
		
		if($result['result'] == true)
			$result['result'] = $original_result;
		
		return $result['result'];
	}
	//Update cart
	public function cart_update_validation($original_result, $cart_item_key, $values, $quantity )
	{
		global $woocommerce,$was_product_model;
		$result = array('result' => $original_result);
		$items = WC()->cart->cart_contents;
		if(isset($items[$cart_item_key]))
		{
			$result = $was_product_model->check_if_product_can_be_purchase_due_to_purchase_limit($items[$cart_item_key]['data']->post->post_title, $items[$cart_item_key]['product_id'], $items[$cart_item_key]['variation_id'], $quantity);
			if(!$result['result'])
				foreach($result['messages'] as $message)
					wc_add_notice( $message ,'error');
		}
		
		return $result['result'];
	}
	//Checkout
	public function checkout_validation( )
	{
		global $was_product_model;
		$results = $was_product_model->validate_current_cart_products();
		foreach($results as $result)
			if(!$result['result'])
			{
				$error = true;
				foreach($result['messages'] as $message)
					wc_add_notice( $message ,'error');
			}
	}
	public function add_common_js_code()
	{
		if(@is_single() || @is_shop()):
		?>
			<script>
			var wcas_sec_string = "<?php _e('sec', 'woocommerce-availability-scheduler'); ?>";
			var wcas_min_string = "<?php _e('min', 'woocommerce-availability-scheduler'); ?>";
			var wcas_hour_string = "<?php _e('hr', 'woocommerce-availability-scheduler'); ?>";
			var wcas_days_string = "<?php _e('days', 'woocommerce-availability-scheduler'); ?>";
			var wcas_weeks_string = "<?php _e('weeks', 'woocommerce-availability-scheduler'); ?>";
			</script>
		<?php endif;
	}
	public function AS_remove_single_product_page_add_to_cart_links()
	{
		wp_enqueue_style( 'was-frontend', AS_PLUGIN_PATH.'/css/was-frontend.css' );
		//wp_enqueue_script('was-countdown-js', AS_PLUGIN_PATH.'/js/jquery.countdown.js', array('jquery'));  
		wp_enqueue_script('was-countdown', AS_PLUGIN_PATH.'/js/countdown.js', array('jquery'));    
		wp_enqueue_script('was-data-formatter', AS_PLUGIN_PATH.'/js/was-data-formatter.js', array('jquery'));    
		wp_enqueue_script('was-countdown-2', AS_PLUGIN_PATH.'/js/vendor/jquery.countdown.js', array('jquery'));  
		
		
		//remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 ); 
		//add_action( 'woocommerce_after_shop_loop_item', 'remove_product_page_add_to_cart_link', 30 );
		add_action( 'woocommerce_single_product_summary', array( &$this,'AS_remove_single_product_page_add_to_cart_link' ), 30);
	}
	/* public function AS_remove_unavailable_items_from_cart()
	{
		global $woocommerce, $was_product_model;
		if(!$woocommerce->cart)
			return;
		$items = $woocommerce->cart->get_cart();
		foreach($items as $item => $values) 
		{
			$_product = $values['data']->post; 
			$result = WAS_PostAddon::get_post_meta($_product->ID);
			$current_period = $this->AS_get_current_period($result);
			if($this->AS_is_disabled_for_today($result) || ($current_period != "during" && $current_period != "all_day") || $was_product_model->product_has_expired($_product->ID))
			{
				 $prod_unique_id = WC()->cart->generate_cart_id( $_product->ID );
				unset( WC()->cart->cart_contents[$prod_unique_id] );
				$woocommerce->cart->set_quantity($prod_unique_id, 0);
			}
		} 

	} */
	
	public function check_which_product_unhide($reload = true)
	{
		global $was_product_model;
		if($was_product_model->check_which_product_unhide())
		{
			if($reload)	
				$this->AS_reload_page();
		}
	}
	/*public function AS_before_shop_loop()
	{
		//global $as_item_removed;
		$this->as_item_removed = 0;
		$this->check_produtcs_to_unhide();		
	}
	 public function AS_check_if_reload_page()
	{
		//global $as_item_removed;
		//Items in the loop have been changed, reload shoppage
		if($this->as_item_removed > 0)
		{
			$this->AS_reload_page();
		}
	}
	private function AS_reload_page()
	{
		echo '<script>location.reload();</script>';
	}
	public function AS_remove_expired_item()
	{
		global $product, $was_product_model;
		if($was_product_model->product_has_expired($product->id))
		{ 
			$this->as_item_removed++;
			$was_product_model->change_product_status($product->id,'draft');
		}
	} */
	public function AS_check_if_unhide_products_and_update_cart($input)
	{
		global $was_product_model;
		if( @is_single() || @is_shop() || @is_archive() || @is_category() ||@is_page() ||@is_cart() ||@is_checkout())
		{
			$was_product_model->hide_expired_products(); //by expiring date or only for today
			$this->check_which_product_unhide(false);
			if(!is_admin())
				$this->update_cart_contents();
		}
		return $input;
	}
	//forced
	public function AS_force_remove_single_product_page_add_to_cart_button()
	{
		//FORCING ADD TO CART HIDING
		//note: some themes doens't lauch the correct event
		global $product, $was_product_model;
		 $result = WAS_PostAddon::get_post_meta($product->id); 
		/*if($was_product_model->product_has_expired($product->id) || !$result)
			return; 		*/
		$current_period = $this->AS_get_current_period($result);
		$is_reversed = $this->AS_is_reversed_availability_on($result);
		
		if($was_product_model->is_product_expired_but_visible($product->id) || $this->AS_is_disabled_for_today($result) || (($current_period == "during" && $is_reversed) || ($current_period != "during" && !$is_reversed) && $current_period != "all_day")):
		?>
		<script>
		function was_remove_add_to_cart(event)
			{
				event.stopImmediatePropagation();
				event.preventDefault();
				return false;
			}
			
		
			jQuery('.single_add_to_cart_button').css('display', 'none');
			jQuery('.cart').css('display', 'none');
			jQuery('.cart').css('opacity', 0);
			jQuery('.qty-cart').css('display', 'none');
			jQuery('.qty-cart').css('opacity', 0);
			jQuery('.single_add_to_cart_button').click(was_remove_add_to_cart);
		jQuery(document).ready(function()
		{	
			jQuery('.qty-cart').remove();
			jQuery('.single_add_to_cart_button').remove();
		});
		</script>
		<?php
		endif;
	}
	private function AS_current_product_can_be_purchased_during_current_period($product_data, $today, $current_period, $is_reversed)
	{
		global $was_product_model;
		$roles = isset($product_data['was_customer_roles'][$today]) ? $product_data['was_customer_roles'][$today] : "none";
		$strategy = isset($product_data['was_customer_roles_restriction_type'][$today]) ? $product_data['was_customer_roles_restriction_type'][$today] : "apply_to_selected";
		 if($roles != 'none' && !is_user_logged_in())
			return false;
		$current_user = wp_get_current_user();
		$current_user_roles = $current_user->roles;
		
		if($was_product_model->is_product_expired_but_visible($product_data["ID"]))
				return false;
			
		$result = (($current_period == "during" && !$is_reversed) || ($current_period != "during" && $is_reversed) || $current_period == "all_day") &&
			   ($roles == 'none' || current_user_can( 'manage_options' ) || ($strategy == "apply_to_selected" && array_intersect($roles,$current_user_roles)) || ($strategy == "except_the_selected" && !array_intersect($roles,$current_user_roles)));
	
		return $result;
	}
	private function AS_current_user_can_view_item($product_data, $today)
	{
		$roles = isset($product_data['was_customer_roles'][$today]) ? $product_data['was_customer_roles'][$today] : "none";
		$strategy = isset($product_data['was_customer_roles_restriction_type'][$today]) ? $product_data['was_customer_roles_restriction_type'][$today] : "apply_to_selected";
		$current_user = wp_get_current_user();
		$current_user_roles = $current_user->roles;
		
		if($roles != 'none' && !is_user_logged_in())
			return false;
		else if ( $roles == 'none' ||
				  ($strategy == "apply_to_selected" && array_intersect($roles,$current_user_roles)) || 
				  ($strategy == "except_the_selected" && !array_intersect($roles,$current_user_roles)))
			return true;
		return false;
	}
	//Update cart
	public function update_cart_contents( )
	{
		//wcps_var_dump(WC()->cart->get_cart());
		global $woocommerce,$wcps_product_model;
		$products_to_remove = array();
		$items = WC()->cart->cart_contents;
		$time_offset = WAS_OptionsMenu::get_option('time_offset');
		
		if(is_array($items))
		{
			foreach((array)$items as $cart_key => $product)
			{
				$result = WAS_PostAddon::get_post_meta($product['product_id']); 
				$is_reversed = $this->AS_is_reversed_availability_on($result);
				$current_period = $this->AS_get_current_period($result);
				$today = date("N", strtotime($time_offset.' minutes'))-1;
				
				if(/* !$this->AS_current_user_can_view_item($result, $today ) || */
					get_post_status($product['product_id']) != 'publish' ||
				    $this->AS_is_disabled_for_today($result) || 
				   !$this->AS_current_product_can_be_purchased_during_current_period($result, $today, $current_period, $is_reversed))
					$products_to_remove[] = $cart_key;
			
			}
		}
		
		 foreach((array)$products_to_remove as $product_cart_key)
				WC()->cart->remove_cart_item($product_cart_key);
		
	}
	public function AS_remove_single_product_page_add_to_cart_link() 
	{
		global $post, $was_product_model;
		if(isset($this->already_add_to_cart_buttons_modified[$post->ID]))
			return;
		$this->already_add_to_cart_buttons_modified[$post->ID] = true; 
		
		$time_offset = WAS_OptionsMenu::get_option('time_offset');
		$today = date("N", strtotime($time_offset.' minutes'))-1;
		//var_dump($post->ID);
		$result = WAS_PostAddon::get_post_meta($post->ID); 
		
		if(!$this->AS_current_user_can_view_item($result, $today ))
		{
			echo '<div id="wcas-message">';
			echo $this->AS_get_day_message_for_unauthorized_users($result);
			echo '</div>';
			return false;
		}
		
		if(!$result)
			woocommerce_template_single_add_to_cart();
		else
		{
			if($was_product_model->is_product_expired_but_visible($post->ID))
				return;
			
			$messages =  $this->AS_get_day_messages($result);
			$current_period = $this->AS_get_current_period($result);
			$is_reversed = $this->AS_is_reversed_availability_on($result);
			
			//time range check
			if($this->AS_is_disabled_for_today($result))
			{
				echo '<div id="wcas-message">';
				echo $messages["product_page_msg"];
				echo '</div>';
			}
			else
			{
				//wcas_var_dump($current_period);
				if( $this->AS_current_product_can_be_purchased_during_current_period($result, $today, $current_period, $is_reversed))
					woocommerce_template_single_add_to_cart();
				//if(isset($result["always_show_product_message"][$today]) && $result["always_show_product_message"][$today] == 1)
				{
					
					echo '<div id="wcas-message">';
					
					switch($current_period)
					{
						case 'all_day': echo $messages["product_page_msg"]; break;
						case 'before': echo $messages["product_page_msg"]; break;
						case 'during': echo $messages["product_page_during_msg"]; break;
						case 'after': echo $messages["product_page_after_msg"]; break;
					}
					echo '</div>';
				}
			}
			
			if($this->AS_show_product_countdown($result))
					include AS_PLUGIN_ABS_PATH."/template/product_page_countdown.php";
				
			if(isset($result["where_sales_progressbar"]) && isset($result["where_sales_progressbar"][$today]) && $result["where_sales_progressbar"][$today] != 0 && ($result["where_sales_progressbar"][$today] == 3 || $result["where_sales_progressbar"][$today] == 2))
			{
				$this->render_progress_sales_box($post->ID,$today, $result);
			}
		}
		
	}
	public function render_progress_sales_box($product_id, $today, $result)
	{
		global $was_product_model;
		$sales_data = $was_product_model->get_current_and_total_sales_limit($product_id);	
		
		if($sales_data['sales_limit'][$today] == 0)
			return;
		
		$sales_progress_bar_background_color = WAS_OptionsMenu::get_option('sales_progress_bar_background_color');
		$sales_progress_bar_color = WAS_OptionsMenu::get_option('sales_progress_bar_color');
		$hide_sales_progress_bar_label = WAS_OptionsMenu::get_option('hide_sales_progress_bar_label');
		//wcas_var_dump($sales_data);
		$progress_value = ($sales_data['total_sales']/$sales_data['sales_limit'][$today])*100;
		$progress_value = $progress_value > 100 ? $progress_value : $progress_value;
		include AS_PLUGIN_ABS_PATH."/template/sales_progress.php";
	}
	function force_removing_extra_html_add_to_cart_buttons_on_shop_page()
	{
		if(@is_shop() )
		{
			wp_enqueue_script('was-frontend-shop-page-add-to-cart-buttons', AS_PLUGIN_PATH.'/js/was-frontend-shop-page-add-to-cart-buttons.js', array('jquery'));
		}
	}
	public function AS_remove_shop_page_add_to_cart( $add_to_cart_text, $product ) 
	{
		global $was_product_model;
		
		if(isset($this->already_add_to_cart_buttons_modified[$product->id]))
			return;
				$this->already_add_to_cart_buttons_modified[$product->id] = true; 
		
		
		$time_offset = WAS_OptionsMenu::get_option('time_offset');
		$today = date("N", strtotime($time_offset.' minutes'))-1;
		
		$result = WAS_PostAddon::get_post_meta($product->id);
		
		if(!$this->AS_current_user_can_view_item($result, $today ))
		{
			echo '<div id="wcas-message-shop">';
			echo $this->AS_get_day_message_for_unauthorized_users($result);
			echo '</div>';
			return false;
		}
		if(!$result)
		{
			
			echo $add_to_cart_text; //Add to cart button
		}
		else
		{ 
			if($was_product_model->is_product_expired_but_visible($product->id))
				return;
			
			$messages =  $this->AS_get_day_messages($result);
			$current_period = $this->AS_get_current_period($result);
			$is_reversed = $this->AS_is_reversed_availability_on($result);
			
			//time range check
			if($this->AS_is_disabled_for_today($result))
			{
				echo '<div id="wcas-message-shop">';
				echo $messages["shop_page_msg"];
				echo '</div>';
			}
			else
			{
				//if(isset($result["always_show_shop_message"][$today]) && $result["always_show_shop_message"][$today] == 1)
				{
					if($this->AS_current_product_can_be_purchased_during_current_period($result, $today, $current_period, $is_reversed))
						echo $add_to_cart_text;
					
					echo '<div id="wcas-message-shop">'; 
					switch($current_period)
					{
						case 'all_day': echo $messages["shop_page_msg"]; break;
						case 'before': echo $messages["shop_page_msg"]; break;
						case 'during': echo $messages["shop_page_during_msg"]; break;
						case 'after': echo $messages["shop_page_after_msg"]; break;
					}
					echo '</div>';
				}
			}
			
			if($this->AS_show_shop_countdown($result))
					include AS_PLUGIN_ABS_PATH."/template/shop_page_countdown.php";
			
			if(isset($result["where_sales_progressbar"]) && isset($result["where_sales_progressbar"][$today]) && $result["where_sales_progressbar"][$today] != 0 && ($result["where_sales_progressbar"][$today] == 3 || $result["where_sales_progressbar"][$today] == 1))
			{
				$this->render_progress_sales_box($product->id,$today, $result);
			}
		}
	}
	
	public function AS_is_reversed_availability_on($result)
	{
		$time_offset = WAS_OptionsMenu::get_option('time_offset');
		$today = date("N", strtotime($time_offset.' minutes'))-1;
		$period_type =  $result["availability_strategy"][$today];
		return $period_type == 3 ? true:false;
	}
	public function AS_get_current_period($result)
	{
		global $was_product_model;
		$time_offset = WAS_OptionsMenu::get_option('time_offset');
		$today = date("N", strtotime($time_offset.' minutes'))-1;
		$now = date("H:i", strtotime($time_offset.' minutes'));
		$period_type =  $result["availability_strategy"][$today];
		$currentTime = new DateTime($now);
		
		//product sales limit
		if(isset($result["total_sales_limit"][$today]) && $result["total_sales_limit"][$today] != 0)
		{
			$total_sales = $was_product_model->get_today_product_total_sales($result["ID"]);
			if(is_numeric($total_sales) && $total_sales >= $result["total_sales_limit"][$today])
				return "after";
		}
		if( ($period_type == 1 || $period_type==3) &&   isset($result["stat_time"][$today])  && isset($result["end_time"][$today]))
		 {
			
		    $startTime = explode(":",$result["stat_time"][$today]);
			$startTime[0] = $startTime[0] > 24 ? 24 : $startTime[0];
			$startTime[1] = $startTime[1] > 59 ? "00" : $startTime[1];
			$endTime = explode(":",$result["end_time"][$today]);
			$endTime[0] = $endTime[0] > 24 ? 24 : $endTime[0];
			$endTime[1] = $endTime[1] > 59 ? "00" : $endTime[1];
			
			$startTime = new DateTime($startTime[0].":".$startTime[1]);
			$endTime = new DateTime($endTime[0].":".$endTime[1]);
			if( $currentTime < $startTime)
				return "before";
			
			else if( $currentTime >= $startTime &&
					$currentTime < $endTime)
				return "during";
				
			else if( $currentTime >= $endTime)
				return "after";
		 }
		return "all_day";
	}
	public function AS_get_day_message_for_unauthorized_users($result)
	{
		$time_offset = WAS_OptionsMenu::get_option('time_offset');
		$today = date("N", strtotime($time_offset.' minutes'))-1;
	
		return isset($result["was_customer_roles_restriction_message"][$today]) ? $result["was_customer_roles_restriction_message"][$today]  : "";
	}
	public function AS_get_day_messages($result)
	{
		$messages = array();
		$time_offset = WAS_OptionsMenu::get_option('time_offset');
		$today = date("N", strtotime($time_offset.' minutes'))-1;
		$period_type =  $result["availability_strategy"][$today];
		$messages["shop_page_msg"] = isset($result["shop_page_msg"][$today]) ? $result["shop_page_msg"][$today]  : "";
		$messages["product_page_msg"] = isset($result["product_page_msg"][$today]) ? $result["product_page_msg"][$today] : "";
		
		$messages["shop_page_during_msg"] = isset($result["shop_page_during_msg"][$today]) ? $result["shop_page_during_msg"][$today] : "";
		$messages["shop_page_after_msg"] = isset($result["shop_page_after_msg"][$today]) ? $result["shop_page_after_msg"][$today] : "";
		
		$messages["product_page_during_msg"] = isset($result["product_page_during_msg"][$today]) ? $result["product_page_during_msg"][$today] : "";
		$messages["product_page_after_msg"] = isset($result["product_page_after_msg"][$today]) ? $result["product_page_after_msg"][$today] : "";
		
		if($period_type==1 || $period_type==3)
		{
			$startTime = $result["stat_time"][$today];
			$endTime = $result["end_time"][$today];
			$messages["shop_page_msg"] = str_replace("[start_time]", $startTime, $messages["shop_page_msg"] );
			$messages["shop_page_msg"] = str_replace("[end_time]", $endTime, $messages["shop_page_msg"] );
			$messages["shop_page_during_msg"] = str_replace("[start_time]", $startTime, $messages["shop_page_during_msg"] );
			$messages["shop_page_during_msg"] = str_replace("[end_time]", $endTime, $messages["shop_page_during_msg"] );
			$messages["shop_page_after_msg"] = str_replace("[start_time]", $startTime, $messages["shop_page_after_msg"] );
			$messages["shop_page_after_msg"] = str_replace("[end_time]", $endTime, $messages["shop_page_after_msg"] );
			
			$messages["product_page_msg"] = str_replace("[start_time]", $startTime, $messages["product_page_msg"] );
			$messages["product_page_msg"] = str_replace("[end_time]", $endTime, $messages["product_page_msg"] );
			$messages["product_page_during_msg"] = str_replace("[start_time]", $startTime, $messages["product_page_during_msg"] );
			$messages["product_page_during_msg"] = str_replace("[end_time]", $endTime, $messages["product_page_during_msg"] );
			$messages["product_page_after_msg"] = str_replace("[start_time]", $startTime, $messages["product_page_after_msg"] );
			$messages["product_page_after_msg"] = str_replace("[end_time]", $endTime, $messages["product_page_after_msg"] );
		}
		
		return $messages;
	}
	public function AS_is_disabled_for_today($result)
	{
		$time_offset = WAS_OptionsMenu::get_option('time_offset');
		$today = date("N", strtotime($time_offset.' minutes'))-1;
		$time = date("H:i", strtotime($time_offset.' minutes'));
		$period_type =  $result["availability_strategy"][$today];
		 
		if($period_type==2)
			return true;
		else if($period_type == 0)
			return false;
		else
		{
			/* $currentTime = new DateTime($time);
			$startTime = new DateTime($result["stat_time"][$today]);
			$endTime = new DateTime($result["end_time"][$today]);

			if($currentTime >= $startTime && $currentTime <= $endTime)
				return false;
			else
				return true; */
			return false;
		}
	}
		
	public function AS_show_product_countdown($result)
	{
		$time_offset = WAS_OptionsMenu::get_option('time_offset');
		$today = date("N", strtotime($time_offset.' minutes'))-1;
		if( ($result["availability_strategy"][$today] == 1 || $result["availability_strategy"][$today] == 3) && 
		  ((isset($result["countdown_to_start"][$today]) && $result["countdown_to_start"][$today] ==1) || 
		  (isset($result["countdown_to_end"][$today]) && $result["countdown_to_end"][$today] ==1 )) &&
		  ($result["where_countdown_to_start"][$today] != 0 || $result["where_countdown_to_end"][$today] != 0))
		  return true;
		return false;
	}
	public function AS_show_shop_countdown($result)
	{
		$time_offset = WAS_OptionsMenu::get_option('time_offset');
		$today = date("N", strtotime($time_offset.' minutes'))-1;
		if(($result["availability_strategy"][$today] == 1 || $result["availability_strategy"][$today] == 3)&& 
		  ((isset($result["countdown_to_start"][$today]) && $result["countdown_to_start"][$today] ==1)  || 
		  (isset($result["countdown_to_end"][$today]) && $result["countdown_to_end"][$today] ==1 )) &&
		  ($result["where_countdown_to_start"][$today] != 1 || $result["where_countdown_to_end"][$today] != 1))
		  return true;
		return false;
	}
	
}
?>