<?php
/*
 * working behind the seen
*/


class NM_PLUGIN_WooConvo_Admin extends NM_PLUGIN_WooConvo{


	var $menu_pages, $plugin_scripts_admin, $plugin_settings, $order_email;


	function __construct(){


		//setting plugin meta saved in config.php
		$this -> plugin_meta = wooconvo_get_plugin_meta();

		//getting saved settings
		$this -> plugin_settings = get_option($this->plugin_meta['shortname'].'_settings');


		/*
		 * [1]
		* TODO: change this for plugin admin pages
		*/
		$this -> menu_pages		= array(array('page_title'	=> $this->plugin_meta['name'],
				'menu_title'	=> $this->plugin_meta['name'],
				'cap'			=> 'edit_plugins',
				'slug'			=> $this->plugin_meta['shortname'],
				'callback'		=> 'main_settings',
				'parent_slug'		=> '',)
			);


		/*
		 * [2]
		* TODO: Change this for admin related scripts
		* JS scripts and styles to loaded
		* ADMIN
		*/
		$this -> plugin_scripts_admin =  array(array(	'script_name'	=> 'scripts-global',
				'script_source'	=> '/js/nm-global.js',
				'localized'		=> false,
				'type'			=> 'js',
				'page_slug'		=> $this->plugin_meta['shortname']
		),
				array(	'script_name'	=> 'scripts-admin',
						'script_source'	=> '/js/admin.js',
						'localized'		=> true,
						'type'			=> 'js',
						'page_slug'		=> $this->plugin_meta['shortname'],
						'deps'			=> array('jquery-ui-core','jquery-ui-tabs'),
				),
			
				array(	'script_name'	=> 'tabs-css',
						'script_source'	=> '/js/ui/css/smoothness/jquery-ui-1.10.3.custom.min.css',
						'localized'		=> false,
						'type'			=> 'style',
						'page_slug'		=> $this->plugin_meta['shortname']
				),
				
				
				array(	'script_name'	=> 'grid-css',
						'script_source'	=> '/css/simplegrid.css',
						'localized'		=> false,
						'type'			=> 'style',
						'page_slug'		=> $this->plugin_meta['shortname']
				),
					
		);


		add_action('admin_menu', array($this, 'add_menu_pages'));
	}

	function load_scripts_admin(){

		//localized vars in js
		$arrLocalizedVars = array(	'ajaxurl' => admin_url( 'admin-ajax.php' ),
				'plugin_url' 		=> $this -> plugin_meta['url'],
				'settings'			=> $this -> plugin_settings,
				'order_id'			=> $this -> order_id,
				'order_email'		=> $this -> order_email,
				'expand_all'		=> __('Expand all', $this->plugin_meta['shortname']),
				'collapse_all'		=> __('Collapse all', $this->plugin_meta['shortname']),
			);

		//admin end scripts

		if($this -> plugin_scripts_admin){
			foreach($this -> plugin_scripts_admin as $script){

				$deps = isset($script['deps']) ? $script['deps'] : '';
				//checking if it is style
				if( $script['type'] == 'js'){
					wp_enqueue_script($this -> plugin_meta['shortname'].'-'.$script['script_name'], $this -> plugin_meta['url'].$script['script_source'], $deps);

					//if localized
					if( $script['localized'] )
						wp_localize_script( $this -> plugin_meta['shortname'].'-'.$script['script_name'], $this -> plugin_meta['shortname'].'_vars', $arrLocalizedVars);
				}else{

					wp_enqueue_style($this -> plugin_meta['shortname'].'-'.$script['script_name'], $this -> plugin_meta['url'].$script['script_source'], __FILE__);
				}
			}
		}

	}



	/*
	 * creating menu page for this plugin
	*/

	function add_menu_pages(){

		foreach ($this -> menu_pages as $page){
				
			if ($page['parent_slug'] == ''){

				$menu = add_menu_page(__($page['page_title'], $this->plugin_meta['shortname']),
						__($page['menu_title'], $this->plugin_meta['shortname']),
						$page['cap'],
						$page['slug'],
						array($this, $page['callback']),
						$this->plugin_meta['logo'],
						$this->plugin_meta['menu_position']);
			}else{

				$menu = add_submenu_page($page['parent_slug'],
						__($page['page_title'], $this->plugin_meta['shortname']),
						__($page['menu_title'], $this->plugin_meta['shortname']),
						$page['cap'],
						$page['slug'],
						array($this, $page['callback'])
				);

			}
				
			//loading script for only plugin optios pages
			// page_slug is key in $plugin_scripts_admin which determine the page
			foreach ($this -> plugin_scripts_admin as $script){

				if (is_array($script['page_slug'])){
						
					if (in_array($page['slug'], $script['page_slug']))
						add_action('admin_print_scripts-'.$menu, array($this, 'load_scripts_admin'));
				}else if ($script['page_slug'] == $page['slug']){
					add_action('admin_print_scripts-'.$menu, array($this, 'load_scripts_admin'));
				}
			}
		}

	}


	//====================== CALLBACKS =================================
	function main_settings(){

		$this -> load_template('admin/settings.php');

	}
}