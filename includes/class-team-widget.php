<?php
defined('ABSPATH') or die("you do not have access to this page!");
/**
 * Contains action hooks and functions for user authentication.
 *
 * @class ZTEC_Admin
 * @package zt-team-league\includes
 * @version 1.0.0
 */
class ZTEC_Elementor_Widget 
{
    /**
     * Constructor for the admin class. Loads options and hooks.
     */
    public function __construct()
    {
        //add_action('init', [$this, 'ztec_get_team_data']);
        add_action( 'wp_enqueue_scripts', [$this, 'ztec_enqueue_scripts'] );
        add_action('admin_enqueue_scripts', [$this, 'ztec_admin_css_and_js']);
    }

    /**
     * Responsible for enqueue scripts
     */
    function ztec_enqueue_scripts() {
        wp_enqueue_style( 'team_widget_css', ZTEC_ASSETS_URL.'css/style.css' );
    }
    function ztec_admin_css_and_js() {
        wp_enqueue_style( 'admin_style_css', ZTEC_ASSETS_URL.'css/admin_style.css' );
    }

}
new ZTEC_Elementor_Widget();
// End of Elementor Widget