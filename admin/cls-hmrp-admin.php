<?php
/**
*	Admin Parent Class
*/
class Hmrpw_Admin 
{	
	private $hmrpw_version;
	private $hmrpw_assets_prefix;

	function __construct( $version ){
		$this->hmrpw_version = $version;
		$this->hmrpw_assets_prefix = substr(HMRPW_PRFX, 0, -1) . '-';
	}
	
	/**
	*	Loading the admin menu
	*/
	public function hmrpw_admin_menu(){
		
		add_menu_page(	esc_html__('HM Recent Posts', HMRPW_TXT_DOMAIN),
						esc_html__('HM Recent Posts', HMRPW_TXT_DOMAIN),
						'manage_options', // area of the admin panel
						'hmrpw-admin-panel',
						array( $this, HMRPW_PRFX . 'load_admin_panel' ),
						'',
						100 
					);
	}
	
	/**
	*	Loading admin panel assets
	*/
	function hmrpw_admin_assets(){
		if (isset($_GET['page']) && $_GET['page'] == 'hmrpw-admin-panel'){
			wp_enqueue_style(
								$this->hmrpw_assets_prefix . 'admin-style',
								HMRPW_ASSETS . 'css/' . $this->hmrpw_assets_prefix . 'admin-style.css',
								array(),
								$this->hmrpw_version,
								FALSE
							);
			
			wp_enqueue_style('wp-color-picker');
			wp_enqueue_script('wp-color-picker');

			if ( !wp_script_is( 'jquery' ) ) {
				wp_enqueue_script('jquery');
			}
			wp_enqueue_script(
								$this->hmrpw_assets_prefix . 'admin-script',
								HMRPW_ASSETS . 'js/' . $this->hmrpw_assets_prefix . 'admin-script.js',
								array('jquery'),
								$this->hmrpw_version,
								TRUE
							);
			$hmrpwAdminArray = array(
				'hmrpwIdsOfColorPicker' => array( '#hmrpw_post_title_color' )
			);
			
			wp_localize_script( $this->hmrpw_assets_prefix . 'admin-script', 'hmrpwAdminScript', $hmrpwAdminArray );
		}
	}
	
	/**
	*	Loading admin panel
	*/
	function hmrpw_load_admin_panel(){
		require_once HMRPW_PATH . 'admin/view/' . $this->hmrpw_assets_prefix . 'admin-settings.php';
	}

	protected function hmrpw_display_notification($type, $msg){ ?>
		<div class="hmrpw-alert <?php printf('%s', $type); ?>">
			<span class="hmrpw-closebtn">&times;</span> 
			<strong><?php esc_html_e(ucfirst($type), HMRPW_TXT_DOMAIN); ?>!</strong> <?php esc_html_e($msg, HMRPW_TXT_DOMAIN); ?>
		</div>
	<?php }
}
?>