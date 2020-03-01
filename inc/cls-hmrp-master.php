<?php
/**
 * Main plugin class
*/
class Hmrpw_Master
{
	protected $hmrpw_loader;
	protected $hmrpw_version;
	
	/**
	 * Class Constructor
	*/
	public function __construct() {
		$this->hmrpw_version = HMRPW_VERSION;
		add_action('plugins_loaded', array($this, 'hmrpw_plugin_textdomain'));
		$this->hmrpw_load_dependencies();
		$this->hmrpw_trigger_widget_hooks();
		$this->hmrpw_trigger_admin_hooks();
		$this->hmrpw_trigger_front_hooks();
	}

	function hmrpw_plugin_textdomain(){
		load_plugin_textdomain( HMRPW_TXT_DOMAIN, FALSE, HMRPW_TXT_DOMAIN . '/languages/' );
	}
	
	private function hmrpw_load_dependencies(){
		require_once HMRPW_PATH . 'widget/' . HMRPW_CLS_PRFX . 'widget.php';
		require_once HMRPW_PATH . 'admin/' . HMRPW_CLS_PRFX . 'admin.php';
		require_once HMRPW_PATH . 'front/' . HMRPW_CLS_PRFX . 'front.php';
		require_once HMRPW_PATH . 'inc/' . HMRPW_CLS_PRFX . 'loader.php';
		$this->hmrpw_loader = new Hmrpw_Loader();
	}
	
	/**
	 * Calling the widget section widget child class
	*/
	private function hmrpw_trigger_widget_hooks(){
		new Hmrpw_Widget();
		add_action( 'widgets_init', function(){ register_widget( 'Hmrpw_Widget' ); });
	}

	private function hmrpw_trigger_admin_hooks(){
		$hmrpw_admin = new Hmrpw_Admin($this->hmrpw_version());
		$this->hmrpw_loader->add_action( 'admin_menu', $hmrpw_admin, HMRPW_PRFX . 'admin_menu' );
		$this->hmrpw_loader->add_action( 'admin_enqueue_scripts', $hmrpw_admin, HMRPW_PRFX . 'admin_assets' );
	}

	private function hmrpw_trigger_front_hooks(){
		$hmrpw_front = new Hmrpw_Front($this->hmrpw_version());
		$this->hmrpw_loader->add_action( 'wp_enqueue_scripts', $hmrpw_front, HMRPW_PRFX . 'front_assets' );
		$hmrpw_front->hmrpw_load_shortcode();
	}
	
	function hmrpw_run(){
		$this->hmrpw_loader->hmrpw_run();
	}

	/**
	 * Controlling the version
	*/
	public function hmrpw_version() {
		return $this->hmrpw_version;
	}

	function hmrpw_unregister_settings(){
		global $wpdb;
	
		$tbl = $wpdb->prefix . 'options';
		$search_string = HMRPW_PRFX . '%';
		
		$sql = $wpdb->prepare( "SELECT option_name FROM $tbl WHERE option_name LIKE %s", $search_string );
		$options = $wpdb->get_results( $sql , OBJECT );
	
		if(is_array($options) && count($options)) {
			foreach( $options as $option ) {
				delete_option( $option->option_name );
				delete_site_option( $option->option_name );
			}
		}
	}
}
