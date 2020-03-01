<?php
/**
 * Plugin Name: 	HM Recent Posts Widget
 * Plugin URI:		http://wordpress.org/plugins/hm-recent-posts-widget/
 * Description: 	This widget will display the recent posts in your sidebar/widget panel with post titles, thumbnails, categories and dates. You need to set featured image in post section to display the thumbnail.
 * Version: 		2.0
 * Author: 			Hossni Mubarak
 * Author URI: 		http://www.hossnimubarak.com
 * License:         GPL-2.0+
 * License URI:		http://www.gnu.org/licenses/gpl-2.0.txt
*/

if ( ! defined( 'WPINC' ) ) { die; }
if ( ! defined('ABSPATH') ) { exit; }

define( 'HMRPW_PATH', plugin_dir_path( __FILE__ ) );
define( 'HMRPW_ASSETS', plugins_url( '/assets/', __FILE__ ) );
define( 'WAB_LANG', plugins_url( '/languages/', __FILE__ ) );
define( 'HMRPW_SLUG', plugin_basename( __FILE__ ) );
define( 'HMRPW_PRFX', 'hmrpw_' );
define( 'HMRPW_CLS_PRFX', 'cls-hmrp-' );
define( 'HMRPW_TXT_DOMAIN', 'hm-recent-posts' );
define( 'HMRPW_VERSION', '2.0' );

require_once HMRPW_PATH . 'inc/' . HMRPW_CLS_PRFX . 'master.php';
$hmrpw = new Hmrpw_Master();
$hmrpw->hmrpw_run();
register_deactivation_hook( __FILE__, array($hmrpw, HMRPW_PRFX . 'unregister_settings') );
?>