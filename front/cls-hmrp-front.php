<?php
/**
*	Front Parent Class
*/
class Hmrpw_Front 
{	
	private $hmrpw_version;

	function __construct( $version ){
		$this->hmrpw_version = $version;
		$this->hmrpw_assets_prefix = substr(HMRPW_PRFX, 0, -1) . '-';
	}
	
	function hmrpw_front_assets(){
		$hmrpw_settings = stripslashes_deep(unserialize(get_option('hmrpw_settings')));
		wp_enqueue_style(	'hmrpw-front-style',
							HMRPW_ASSETS . 'css/' . $this->hmrpw_assets_prefix . 'front-style.css',
							array(),
							$this->hmrpw_version,
							FALSE );
		if(is_array($hmrpw_settings)){
			$hmrpwTitleColor = esc_attr($hmrpw_settings['hmrpw_post_title_color']);
			$hmrpwTickerDirection = esc_attr($hmrpw_settings['hmrpw_ticker_direction']);
		}
		$hmrpwCustomCss = "
							.hmrpw-front-view ul li .hmrpw-widget-content a.hmrpw-title,
							.hmrpw-shortcode-view ul li .hmrpw-shortcode-content a.hmrpw-title{
								color: {$hmrpwTitleColor}
							}
							";
		wp_add_inline_style( 'hmrpw-front-style', $hmrpwCustomCss );

		if ( !wp_script_is( 'jquery' ) ){
			wp_enqueue_script('jquery');
		}
		wp_enqueue_script(  'hmrpw-jquery-easing-min',
							HMRPW_ASSETS . 'js/jquery.easing.min.js',
							array('jquery'),
							'1.3',
							TRUE );
		wp_enqueue_script(  'hmrpw-jquery-easy-ticker-min',
							HMRPW_ASSETS . 'js/jquery.easy-ticker.min.js',
							array('jquery'),
							'2.0',
							TRUE );
		wp_enqueue_script(  'hmrpw-front-script',
							HMRPW_ASSETS . 'js/' . $this->hmrpw_assets_prefix . 'front-script.js',
							array('jquery'),
							$this->hmrpw_version,
							TRUE );

		$hmrpwFrontArray = array(
								'hmrpwTickerDirection' => $hmrpwTickerDirection
								);

		wp_localize_script( 'hmrpw-front-script', 'hmrpwFrontScript', $hmrpwFrontArray );
	}

	function hmrpw_load_shortcode(){
		add_shortcode( 'hm_recent_posts', array( $this, 'hmrpw_load_shortcode_view' ) );
	}
	
	function hmrpw_load_shortcode_view(){
		$output = '';
		ob_start();
		include HMRPW_PATH . 'front/view/' . $this->hmrpw_assets_prefix . 'front-view.php';
		//echo "sadas";
		$output .= ob_get_clean();
		return $output;
	}
}
?>