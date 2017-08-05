<?php
add_action('admin_menu', 'add_custom_myaccount_page');
	
	function add_custom_myaccount_page() 
	{

		$plugin_dir_url =  plugin_dir_url( __FILE__ );
		
		add_menu_page( 'phoeniixx', __( 'Phoeniixx', 'phe' ), 'nosuchcapability', 'phoeniixx', NULL, $plugin_dir_url.'/images/logo-wp.png', 57 );
        
		add_submenu_page( 'phoeniixx', 'Custom My Account', 'Custom My Account', 'manage_options', 'phoe_myaccount_setting', 'phoe_myaccount_setting' );	
	
	}
	
	function phoe_myaccount_setting()
	{
		?>
		<div id="profile-page" class="wrap">
			<?php
				if(isset($_GET['tab']))
				{
					$tab = sanitize_text_field( $_GET['tab'] );
				}
				else
				{
					$tab="";
				}
				
				
			?>
			<h2>
			 Custom My Account Plugin Options
			</h2>
			<h2 class="nav-tab-wrapper woo-nav-tab-wrapper">
				<a class="nav-tab <?php if($tab == 'setting' || $tab == ''){ echo esc_html( "nav-tab-active" ); } ?>" href="?page=phoe_myaccount_setting&amp;tab=setting">Settings</a>
				<a class="nav-tab <?php if($tab == 'endpoints'){ echo esc_html( "nav-tab-active" ); } ?>" href="?page=phoe_myaccount_setting&amp;tab=endpoints">Menu</a>
				
			</h2>
		</div>
		<?php
		if($tab == 'endpoints')
		{
		include(dirname(__FILE__).'/admin/endpoint_setting.php');
		}
		
		if($tab=='setting' || $tab == '')
		{
		include(dirname(__FILE__).'/admin/general_setting.php');
		}
	}
	
	function create_custom_page()
	{
		if(isset($_POST['add']))
		{
			
			
			$title = $_POST['phoen-new-endpoint'];
			
			if (get_page_by_title($title) == NULL) {
			$page = get_page_by_path( 'my-account');
			$content = $_POST['post_myaccount'];
			
			$post = array(
				'comment_status' => 'open',
				'ping_status' => 'closed',
				'post_content' => $content,
				'post_date' => date('Y-m-d H:i:s'),
				'post_name' => '$title',
				'post_status' => 'publish',
				'post_title' => '$title',
				'post_type' => 'page',
				'post_parent'=>$page->ID
				
	
			);
			//insert page and save the id
			$newvalue = wp_insert_post($post, false);
			//save the id in the database
			update_option('compare_page', $newvalue);
		}
			
		}
		
		
		
		
	}
?>