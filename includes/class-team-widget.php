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
    }

    function ztec_enqueue_scripts() {
        wp_enqueue_style( 'team_widget_css', ZTEC_ASSETS_URL.'css/style.css' );
    }

    function ztec_get_team_data()
    {
        $args = array(
            'post_type'        => ZTEC_TEAM_POST_TYPE,
            'posts_per_page'   => -1,
            'orderby'          => 'post_date',
            'order'            => 'DESC',
            'post_status'      => 'publish',
            'tax_query' => array(
                array(
                    'taxonomy' => 'league',
                    'field'    => 'term_id',
                    'terms'    => 34,
                    ),
                ),
           
            /* 'meta_query' => array(
                array(
                    'key'     => 'enterprise_on_page',
                    'value'   => serialize(strval('trainees')),
                    'compare' => 'LIKE',
                ),
            ), */
        );
        
        $enterprise_posts = get_posts( $args );
        echo "<pre>";
        print_r($enterprise_posts);
        echo "</pre>";
    }


    


}
new ZTEC_Elementor_Widget();
// End of Elementor Widget