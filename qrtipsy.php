<?php
/*
Plugin Name: QrTipsy
Plugin URI: 
Description: A simple Plugin to Convert your links in Qr Codes and Show them in six classic coloured tooltips.
Version: 2.2
Author: Agnel Waghela
Author URI: http://agnelwaghela.wordpress.com/
*/

	class QrTipsy {
		var $pluginUrl = '';
		var $pluginPath = '';
		var $title = 'qrtipsy';
		var $slug = 'qrtipsy_admin_page';
		var $version = '2.2';
		var $optionSlug = '';
		var $options = '';
		
		function QrTipsy() {
			$this->pluginUrl = plugin_dir_url( __FILE__ );
			$this->pluginPath = plugin_dir_path( __FILE__ );
			$this->init();
			$this->actions();
		}
		
		function init() {
			$this->optionSlug = $this->title . "_options";
			$this->options = get_option($this->optionSlug);
			if (!isset($this->options) || $this->options == null) {
				$this->createDefaultOptions();
			}
		}
		
		/**
		 * Creating Default options
		 */
		function createDefaultOptions() {
			$default = new stdClass();
			$default->skin = "black";
			$default->size = 80;
			$default->timeout = 500;
			$default->color = "";
			$default->randomize = "disabled";
			
			$this->options =& $default;
			add_option( $this->optionSlug, $default, null, "yes" );
		}
		
		/**
		 * Adding actions, filters and registering hooks
		 */
		function actions() {
			add_action('wp_head', array( &$this, 'qrtipsy_wp_head' ) );
			add_action('admin_head', array( &$this, 'qrtipsy_admin') );
			add_action('admin_menu', array( &$this, 'qrtipsy_admin_menu_page' ) );
			add_filter("plugin_action_links", array( &$this, 'qrtipsy_plugin_action_links'), 10, 2 );
			add_action('wp_ajax_qrSaveOptions', array( &$this, 'saveOptions' ) );
			add_shortcode('qrtipsy', array( &$this, 'qrtipsy_shortcode' ) );
			add_filter( 'mce_buttons', array( &$this, 'filter_mce_button' ) );
			add_filter( 'mce_external_plugins', array( &$this, 'filter_mce_plugin' ) );
			register_deactivation_hook( __FILE__ , array( 'qrtipsy_deactivation_hook' ) );
		}
		
		/**
		 * Enqueuing necessary styles and scripts to Frontend WP Head tag
		 */
		function qrtipsy_wp_head() {
			
			wp_enqueue_script( 'qrtipsy_js', $this->pluginUrl . 'js/qrtip-1.0-jquery.js', null, 1.0, false);
			wp_enqueue_script(array("jquery", "jquery-ui-core", "interface", 'jquery-ui-tabs', 'jquery-ui-button', 'jquery-ui-slider','json2'));
			wp_enqueue_style( 'qrtipsy_css', $this->pluginUrl . 'css/qrtip-1.0-jquery.css', null, 1.0, 'all' );
			
			$adminOptions["options"] =& $this->options;
			
			/**
			 * following code adds the adminOptions as javascript variable qrtipsy_option
			 */
			wp_enqueue_script('qrtipsy_options', plugin_dir_url( __FILE__ ) . 'js/script.js');
			
			wp_localize_script('qrtipsy_options', 'qrtipsy_options',$adminOptions);
			
		}
		
		/**
		 * Enqueuing necessary styles and scripts to Admin WP Head tag
		 */
		function qrtipsy_admin() {
			if( current_user_can('activate_plugins') && isset($_GET) && $_GET['page'] == $this->slug ) {
				
				/* Scripts */
				wp_enqueue_script(array("jquery", "jquery-ui-core", "interface", 'jquery-ui-tabs', 'jquery-ui-button', 'jquery-ui-slider','json2'));
				wp_enqueue_script( 'qrtipsy_f2o_js', $this->pluginUrl . 'js/form2object.min.js', null, 1.0, false);
				wp_enqueue_script( 'qrtipsy_js', $this->pluginUrl . 'js/qrtip-1.0-jquery.js', null, 1.0, true);
				wp_enqueue_script( 'qrtipsy_qtip_js', $this->pluginUrl . 'js/jquery.qtip.pack.js', null, 1.0, true);
				wp_enqueue_script( 'qrtipsy_json_js', $this->pluginUrl . 'js/jsonlib.js', null, 1.0, false);
				/* Styles */
				wp_enqueue_style( 'qrtipsy_css', $this->pluginUrl . 'css/qrtip-1.0-jquery.css', null, 1.0, 'all' );
				wp_enqueue_style( 'qrtipsy_qtip_css', $this->pluginUrl . 'css/jquery.qtip.min.css', null, 1.0, 'all' );
				wp_enqueue_style( 'qrtipsy_admin_css', $this->pluginUrl . 'css/admin.css', null, 1.0, 'all' );
				
				$adminOptions["options"] =& $this->options;
				$adminOptions["shortUrls"] =& $this->shortUrls;
				$adminOptions["slug"] = $this->slug;
				$adminOptions["nonce"] = wp_create_nonce( 'qr_admin_nonce');
				$adminOptions["ajaxUrl"] = admin_url('admin-ajax.php');
				$adminOptions["pluginUrl"] = $this->pluginUrl;
				
				/**
				 * following code adds the adminOptions as javascript variable qrtipsy_option
				 */
				wp_enqueue_script('qrtipsy_options', plugin_dir_url( __FILE__ ) . 'js/admin.js');
			
				wp_localize_script('qrtipsy_options', 'qrtipsy_options', $adminOptions);
				
				
				
			}
		}
		
		/**
		 * Creating admin menu pages for displaying plugin options
		 */
		function qrtipsy_admin_menu_page() {
			if( current_user_can('activate_plugins') ) {
				// add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
				add_menu_page( 'QrTipsy', 'QrTipsy', 'activate_plugins', $this->slug, array( &$this, 'qrtipsy_admin_page' ), $this->pluginUrl .'images/logo.png');
			}
		}
		
		/**
		 * options.php has the code for the UI for the options of the plugin
		 */
		function qrtipsy_admin_page() {
			include $this->pluginPath . 'options.php';
		}
		
		/**
		 * Adding settings link to plugin action links for direct access from the plugin.php page
		 */
		function qrtipsy_plugin_action_links( $links, $file ) {
			if ( dirname( $file ) == $this->title ) {
				 $links[] = '<a href="admin.php?page=' . $this->slug . '">Settings</a>';
			}
			
			return $links;
		}
		
		/**
		 * function for saving the options
		 */
		function saveOptions() {
			if ( !current_user_can("activate_plugins") || !wp_verify_nonce( $_POST['qr_admin_nonce'], 'qr_admin_nonce' )) die ('NOT ALLOWED');
			$_POST = array_map( 'stripslashes_deep', $_POST );
			$result = "blank";
			if(isset($_POST['action'])) {
				// $_POST['options'] is an array of options selected by user
				$this->options = json_decode( $_POST['options'] );
				$result = update_option('qrtipsy_options', $this->options);
				$result = json_encode( array( "options" => $this->options, "ok" => true ) );
			}
			
			header( "Content-Type: application/json" );
			echo $result;
		
			exit();
		}
		
		/**
		 * The shortcode function
		 * 
		 */
		function qrtipsy_shortcode( $atts, $content ) {
			extract( shortcode_atts( array(
					'href'	  => '#'
			), $atts ) );
			
			$c =  '<a href="' . $href . '" class="qrtipsy">' . $content . '</a>';
			
			return $c;
		}
		
		/**
		 * registering the editor button
		 */
		function filter_mce_button( $buttons ) {
			array_push( $buttons, 'separator', 'qrtipsy' );
			return $buttons;
		}
		
		function filter_mce_plugin( $plugins ) {
			$url = get_bloginfo('wpurl') . '/wp-includes/js/tinymce/tiny_mce_popup.js';
			$params = '?qrtipsypop=' . rawurlencode( $url ) . '&pluginUrl=' . rawurlencode( $this->pluginUrl );
			$plugins['qrtipsy'] = $this->pluginUrl . "qrtipsy.mce_plugin.php{$params}";
			return $plugins;
		}
		
		/**
		 * deactivation hook for deleting options
		 */
		function qrtipsy_deactivation_hook() {
			delete_option( 'qrtipsy_options' );
		}
		
	}
	
new Qrtipsy();