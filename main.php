<?php
/*
Plugin Name: Ztec Team League 
Plugin URI: https://zehntech.com
Description: Team League widget for Elementor
Version: 1.0.0
Author: Zehntech
Author URI: https://zehntech.com
License: GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: zt-team-league
*/


defined('ABSPATH') or die("you do not have access to this page!");

defined( 'ZTEC_PLUGIN_DIR' )    ? : define ( 'ZTEC_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
defined( 'ZTEC_TEXT_DOMAIN' )   ? : define ( 'ZTEC_TEXT_DOMAIN', 'zt-team-league' );
defined( 'ZTEC_PLUGIN_URL' )    ? : define ( 'ZTEC_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
defined( 'ZTEC_ASSETS_URL' )    ? : define ( 'ZTEC_ASSETS_URL', plugin_dir_url( __FILE__ ).'assets/' );
defined( 'ZTEC_PLUGIN_INCLUDES_DIR' )   ? : define ( 'ZTEC_PLUGIN_INCLUDES_DIR', ZTEC_PLUGIN_DIR . 'includes/' );
defined( 'ZTEC_UI_FRONT_DIR' )   ? : define ( 'ZTEC_UI_FRONT_DIR', ZTEC_PLUGIN_DIR . 'ui-front/' );
defined( 'ZTEC_UI_ADMIN_DIR' )   ? : define ( 'ZTEC_UI_ADMIN_DIR', ZTEC_PLUGIN_DIR . 'ui-admin/' );

defined( 'ZTEC_TEAM_POST_TYPE' )   ? : define ( 'ZTEC_TEAM_POST_TYPE', 'teams' );

require_once(ZTEC_PLUGIN_INCLUDES_DIR . 'class-team.php');
require_once(ZTEC_PLUGIN_INCLUDES_DIR . 'class-team-widget.php');

/*Hook Act when user activate the plugin*/

register_activation_hook( __FILE__, 'ztec_team_activate' );
function ztec_team_activate(){

}


/*Hook Act when user delete the plugin*/
register_uninstall_hook(__FILE__, 'ztec_team_uninstall');
function ztec_team_uninstall(){
            
}



function register_list_widget( $widgets_manager ) {

	require_once ZTEC_UI_FRONT_DIR . 'widgets/team_widget.php';

	$widgets_manager->register( new \Elementor_Team_Widget() );

}
add_action( 'elementor/widgets/register', 'register_list_widget' );
