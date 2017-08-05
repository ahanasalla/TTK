<?php
/*
 * this is main plugin class
*/


/* ======= the model main class =========== */
if(!class_exists('NM_Framwork_V1_wooconvo')){
	$_framework = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'nm-framework.php';
	if( file_exists($_framework))
		include_once($_framework);
	else
		die('Reen, Reen, BUMP! not found '.$_framework);
}


/*
 * [1]
* TODO: change the class name of your plugin
*/
class NM_PLUGIN_WooConvo extends NM_Framwork_V1_wooconvo{

	static $tbl_convo = 'nm_wooconvo';

	var $order_id, $order_valid, $upload_dir_name;
	
	var $inputs;
	/*
	 * plugin constructur
	*/
	function __construct(){

		//setting plugin meta saved in config.php
		$this -> plugin_meta = wooconvo_get_plugin_meta();

		//getting saved settings
		$this -> plugin_settings = get_option($this->plugin_meta['shortname'].'_settings');

		//setting current order id and order_email
		$this -> order_id = isset($_REQUEST['order']) ? intval($_REQUEST['order']) : true;

		if((isset($_REQUEST['email'] ) && $_REQUEST['email'] == '') || (isset($_REQUEST['email']) && $_REQUEST['email'] != get_post_meta($this -> order_id, '_billing_email', true))){
			$this -> order_valid = false;
		}
		else{
			$this -> order_valid = true;
		}

		//file upload dir name
		$this -> upload_dir_name = 'order_files';
		
		/*
		 * [2]
		* TODO: update scripts array for SHIPPED scripts
		* only use handlers
		*/
		//setting shipped scripts
		$this -> wp_shipped_scripts = array('jquery');


		/*
		 * [3]
		* TODO: update scripts array for custom scripts/styles
		*/
		//setting plugin settings
		$this -> plugin_scripts =  array(
				array(	'script_name'	=> 'scripts',
						'script_source'	=> '/js/convo.js',
						'localized'		=> true,
						'type'			=> 'js',
						'load_after'	=> array('jquery-effects-core', 'jquery-effects-shake'),
				),

				array(	'script_name'	=> 'styles',
						'script_source'	=> '/plugin.styles.css',
						'localized'		=> false,
						'type'			=> 'style',
						'load_after' => '',
				),
		);


		/*
		 * update scripts array for custom scripts/styles
		*/
		//setting plugin settings
		$this -> plugin_scripts_admin =  array(
				array(	'script_name'	=> 'scripts_admin',
						'script_source'	=> '/js/convo.js',
						'localized'		=> true,
						'type'			=> 'js',
						'load_after'	=> array('jquery-effects-core', 'jquery-effects-shake'),
				),
			
				array(	'script_name'	=> 'styles',
						'script_source'	=> '/plugin.styles.css',
						'localized'		=> false,
						'type'			=> 'style'
				),
		);

		/*
		 * [4]
		* TODO: localized array that will be used in JS files
		* Localized object will always be your pluginshortname_vars
		* e.g: pluginshortname_vars.ajaxurl
		*/
		$this -> localized_vars = array('ajaxurl' => admin_url( 'admin-ajax.php' ),
				'plugin_url' 		=> $this->plugin_meta['url'],
				'settings'			=> $this -> plugin_settings,
				'order_id'			=> $this -> order_id,
				'order_email'		=> (isset($this -> order_email)) ? $this -> order_email : '' ,
				'expand_all'		=> __('Expand all', 'nm-wooconvo'),
				'collapse_all'		=> __('Collapse all', 'nm-wooconvo'),
				'message_max_files_limit'	=> __(' files allowed only', 'nm-wooconvo'),
		);


		/*
		 * [5]
		* TODO: this array will grow as plugin grow
		* all functions which need to be called back MUST be in this array
		* setting callbacks
		*/
		//following array are functions name and ajax callback handlers
		$this -> ajax_callbacks = array(
				'save_settings',		//do not change this action, is for admin
				'upload_file',
				'send_message',
				'delete_file',
		);

		/*
		 * plugin localization being initiated here
		*/
		add_action('init', array($this, 'wpp_textdomain'));


		/*
		 * plugin main shortcode if needed
		*/
		add_shortcode('nm-wooconvo-orders', array($this , 'load_my_orders'));
		
		/**
		 * laoding convo template on order pages
		 * */
		add_action('woocommerce_view_order', array($this , 'render_wooconvo_myaccount'));


		/*
		 * hooking up scripts for front-end
		*/
		add_action('wp_enqueue_scripts', array($this, 'load_scripts'));

		/*
		 * hooking up scripts for admin
		*/
		add_action('admin_enqueue_scripts', array($this, 'load_scripts_admin'));

		/*
		 * registering callbacks
		*/
		$this -> do_callbacks();

		/*
		 * wp hook to render stuff after payment
		*/
		//add_action('woocommerce_order_details_after_order_table', array($this, 'render_wooconvo_frontend'));

		/*
		 * another panel in orders to display conversation
		* against each Order
		*/
		add_action( 'admin_init', array($this, 'render_convos_in_orders') );

		
		/**
		 * change order label view to view and messsage
		 **/
		 add_filter('woocommerce_my_account_my_orders_actions', array($this, 'change_order_text'), 10, 2);
	}



	/*
	 * =============== NOW do your JOB ===========================
	*
	*/

	/*
	 * rendering meta box in orders for convos
	*/
	function render_convos_in_orders() {

		add_meta_box( 'orders_convo', 'Conversation',
				array($this,'render_convo_admin'),
				'shop_order', 'normal', 'default');
	}


	/*
	 * saving admin setting in wp option data table
	*/
	function save_settings(){

		//pa($_REQUEST);
		$existingOptions = get_option($this->plugin_meta['shortname'].'_settings');
		//pa($existingOptions);

		update_option($this->plugin_meta['shortname'].'_settings', $_REQUEST);
		_e('All options are updated', 'nm-wooconvo');
		die(0);
	}


	/*
	 * pulling all order's detail
	*/
	function load_my_orders($atts){

		extract(shortcode_atts(array(
		), $atts));

		//saving page permalink
		update_option('nm_wooconvo_page_permalink', get_permalink());

		ob_start();

		$this -> load_template('load-order-convo.php');
		//$this -> load_template('contact-form.php', $template_vars);

		$output_string = ob_get_contents();
		ob_end_clean();
			
		return $output_string;
	}
	
	
	

	/*
	 * rendering convo after payment
	*/
	function render_wooconvo_frontend(){

		/*
		 * NOTE: $this -> order_id is being set in constructor
		*/
		$this -> load_template('convo-history.php');
		$this -> load_template('send-message.php');
	}
	
	
	/*
	 * rendering convo after payment
	*/
	function render_wooconvo_myaccount($order){

		//var_dump( $order );
		$this -> order_id = $order;
		$this -> load_template('convo-history.php');
		$this -> load_template('send-message.php');
	}

	/*
	 * function saving wooconvo
	*/
	function send_message()
	{

		// print_r($_REQUEST); exit;

		if ( empty($_POST) || !wp_verify_nonce($_POST['nm_wooconvo_nonce'], 'doing_wooconvo') &&
		current_user_can('subscriber') )
		{
			print 'Sorry, You are not HUMANE.';
			exit;
		}

		// sanitizing messages
		$order_id	= intval($_REQUEST['order_id']);
		$existing_convo_id	 = intval($_REQUEST['existing_convo_id']);
		$message	= sanitize_text_field($_REQUEST['message']);
		$is_admin	= sanitize_text_field($_REQUEST['is_admin']);
		$files = ''; // NA for free version
		
		$email_from = '';

		if($is_admin == 'yes'){

			$email_to 		= get_post_meta($order_id, '_billing_email', true);
			$sent_by 		= apply_filters('wooconvo_shop_admin_name', __('The Town Kitchen', 'nm-wooconvo'));
			$email_from 	= get_bloginfo('admin_email');
			$user 			= 'admin';

		}else{

			$sender_name = get_post_meta($order_id, '_billing_first_name', true).' '.get_post_meta($order_id, '_billing_last_name', true);

			$email_to 		= get_bloginfo('admin_email');
			$sent_by 		= $sender_name;
			$email_from 	= get_post_meta($order_id, '_billing_email', true);
			$user 			= get_post_meta($order_id, '_billing_email', true);
		}



		//print_r($data); exit;

		if ($existing_convo_id != '' &&	 $existing_convo_id != 'undefined')
		{
			//updating
			$select = array(self::$tbl_convo	=> '*');
			$where = array('d'	=>	array('order_id'	=> $order_id));

			$order_convos = $this -> get_row_data($select, $where);

			$existing_thread = json_decode($order_convos -> convo_thread, true);

			//appending new thread to existing

			$existing_thread[] = array(
					'sent_by'	=> $sent_by,
					'message'	=> $message,
					'files'		=> $files,
					'user'		=> $user,
					'senton'	=> current_time('mysql'),
			);

			//print_r($existing_thread); exit;

			$data = array(
					'unread_by'			=> $email_to,
					'convo_thread'		=> json_encode($existing_thread),
			);

			$format = array('%d','%s','%s');
			$where = array('order_id'	=> $order_id);
			$where_format = array('%d');
			$res = $this -> update_table(self::$tbl_convo, $data, $where, $format, $where_format);
			if ($res){
					
				$this -> send_email_alert($email_to, $email_from, $sent_by, $order_id, $is_admin);
			}
		}else{

			$thread[] = array(
					'sent_by'	=> $sent_by,
					'message'	=> $message,
					'files'		=> $files,
					'user'		=> $user,
					'senton'	=> current_time('mysql'),
			);
			//new convo
			$data = array(
					'order_id'			=> $order_id,
					'unread_by'			=> $email_to,
					'convo_thread'		=> json_encode($thread),
			);

			$format = array('%d','%s','%s');
			$res = $this -> insert_table(self::$tbl_convo, $data, $format);
			if ($res){
					
				$this -> send_email_alert($email_to, $email_from, $sent_by, $order_id, $is_admin);
			}
		}

		$response = array();
		if ($res){
			$message_sent = $this -> get_option('_message_sent');
			$message_sent = ($message_sent == '') ? __('Message sent successfully', 'nm-wooconvo') : $message_sent;
			$response['status'] = 'success';
			$response['message'] = $message_sent;

			$response['last_message'] = $this->get_last_message_html($email_from, $sent_by, $message, current_time('mysql'), $files);

		}else{
			$response['status'] = 'error';
			$response['message'] = __('Please try again', 'nm-wooconvo');
		}
		
		wp_send_json( $response );	
	}

	/**
	 * Last Message for Front Response
	 */
	function get_last_message_html($sender_email, $sender_name, $msg, $time, $files = ''){
		ob_start();
		?>
            <li class="self">
                <div class="avatar">
					<?php echo get_avatar( $sender_email, 128 ) ?>
                </div>
                <div class="msg">
                    <p><strong></strong></p>
                    <p>
                        <?php echo stripslashes($msg); ?>
						<?php if ($files != '') {
							$this -> render_attachments($files);
						} ?>
                    </p>
                    <time><span class="dashicons dashicons-clock"></span> <?php echo $this->time_difference($time); ?></time>
                </div>
            </li> 		
		<?php

		return ob_get_clean();
	}

	/*
	 ** Get Conversations againser order_id
	*/

	function get_order_convos()
	{

		//check if this order belongs to email
		if(!$this -> order_valid){
			return NULL;
		}else{

			$select = array(self::$tbl_convo	=> '*');
			$where = array('d'	=>	array('order_id'	=> $this -> order_id));

			$order_convos = $this -> get_row_data($select, $where);
			return $order_convos;
		}

	}

	/*
	 ** Get Convo Detail
	*/

	function get_convo_detail($order_id)
	{
		//echo "hello";
		global $wpdb;

		$myrows = $wpdb->get_results( "SELECT * FROM ".$wpdb->prefix . self::$tbl_convo."
				WHERE order_id = $order_id
				ORDER BY sent_on DESC");
		return $myrows[0];
	}

	/*
	 ** It is making title with suject and latest message excerpt
	*/
	function convo_title($subject, $thread)
	{
		$thread = json_decode($thread);

		//Getting last message array
		$lastChunk = end($thread);
		$lastMessage = stripslashes(self::fix_length_words($lastChunk -> message, 6));
		//print_r($lastMessage);

		$html = "<strong>".stripslashes($subject)."</strong>";
		$html .= "<span style=\"color:#999\"> - $lastMessage</span>";
		return $html;
	}


	/*
	 ** Helper: getting fix lenght of string
	*/
	function fix_length_words($pStr,$pLength)
	{
		$length = $pLength; // The number of words you want

		$text = strip_tags($pStr);
		/*echo $text;
		 exit;*/
		$words = explode(' ', $text); // Creates an array of words
		$words = array_slice($words, 0, $length);
		$str = implode(' ', $words);

		$str .= (count($words) < $pLength) ? '' : '...';

		return $str;
	}

	/*
	 * rendering convos
	* in admin
	*/
	function render_convo_admin($order){

		$this -> order_id = $order -> ID;
		$this -> load_template('convo-history.php');
		$this -> load_template('send-message.php');
	}

	/*
	 * sending email about every convo
	* Admin or Customer
	*/
	function send_email_alert($to, $from_email, $from_name, $order_id, $is_admin){


		$order = new WC_Order($order_id);
		
		if( $is_admin == 'yes'){
			$args = array('order'=>$order_id, 'email'=>$to);
			$url_read_message = $order -> get_view_order_url();
		}else{
			$url_read_message = admin_url( 'post.php?post='.$order_id.'&action=edit' );
		}

		$headers[] = "From: $from_name <$from_email >";
		$headers[] = "Content-Type: text/html";

		$subject = isset($_REQUEST['_subject']) ? $_REQUEST['_subject'] : 'Message sent by '.$from_name.' - order:# '.$order_id;
		$subject = apply_filters('wooconvo_message_subject', $subject, $order_id);

		$message = $this->get_option('_email_message');

		$message = str_replace('%sender_name%', $from_name, $message);
		$message = str_replace('%sender_email%', $from_email, $message);

		$message = nl2br($message);

		$message .= '<br><br>';

		$message .= '<a href="'.$url_read_message.'">'.__('Click here to reply', 'nm-wooconvo').'</a>';

		$message .= '<br><br>';
		$message .= '<em>Thanks<br>';
		$message .= 'Team '.$_SERVER[HTTP_HOST];
		$message .= '</em>';

		$to  = apply_filters('wooconvo_message_receivers', array(trim($to)));
		
		if (wp_mail($to, $subject, $message, $headers)){
			return true;

		}else{
			return false;
		}
	}
	

	


	function activate_plugin(){

		global $wpdb,$plugin_meta;

		/*
		 * NOTE: $plugin_meta is not object of this class, it is constant
		* defined in config.php
		*/
			
		$sql = "CREATE TABLE `".$wpdb->prefix . self::$tbl_convo."` (
		`convo_id` INT( 8 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
		`order_id` INT( 7 ) NOT NULL,
		`unread_by` VARCHAR( 100 ) NOT NULL,
		`convo_thread` MEDIUMTEXT NOT NULL);";

		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);

		add_option("nm_plugin_db_version", $plugin_meta['db_version']);

	}

	function deactivate_plugin(){

		//do nothing so far.
	}
	
	// i18n and l10n support here
	// plugin localization
	function wpp_textdomain() {
		$locale_dir = dirname( plugin_basename( __FILE__ ) ) . '/locale/';
		load_plugin_textdomain('nm-wooconvo', false, $locale_dir);
		
	}
	
	
	function change_order_text($actions, $order){
		
		$actions['view']['name'] = apply_filters('wooconvo_view_order_text', __('View and Message', 'nm-wooconvo'));
		
		return $actions;
	}

	function time_difference($date)
	{
		if(empty($date)) {
			return "No date provided";
		}

		$periods         = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
		$lengths         = array("60","60","24","7","4.35","12","10");

		$now             = current_time('timestamp');
		$unix_date       = strtotime($date);

		// check validity of date
		if(empty($unix_date)) {
			return "Bad date";
		}

		// is it future date or past date
		if($now > $unix_date) {
			$difference     = $now - $unix_date;
			$tense         = "ago";

		} else {
			$difference     = $unix_date - $now;
			$tense         = "from now";
		}

		for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
			$difference /= $lengths[$j];
		}

		$difference = round($difference);

		if($difference != 1) {
			$periods[$j].= "s";
		}

		return "$difference $periods[$j] {$tense}";
	}

	/*
	 * setting up user directory
	*/

	function setup_file_directory(){


		$upload_dir = wp_upload_dir ();
		
		$file_dir_path = $upload_dir ['basedir'] . '/' . $this->upload_dir_name . '/';
		
		if (! is_dir ( $file_dir_path )) {
			if (mkdir ( $file_dir_path, 0775, true ))
				$dirThumbPath = $file_dir_path . 'thumbs/';
			if (mkdir ( $dirThumbPath, 0775, true ))
				return $file_dir_path;
			else
				return 'errDirectory';
		} else {
			$dirThumbPath = $file_dir_path . 'thumbs/';
			if (! is_dir ( $dirThumbPath )) {
				if (mkdir ( $dirThumbPath, 0775, true ))
					return $file_dir_path;
				else
					return 'errDirectory';
			} else {
				return $file_dir_path;
			}
		}
		
	}
	

}