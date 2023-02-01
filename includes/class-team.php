<?php
defined('ABSPATH') or die(esc_html("you do not have access to this page!"));
/**
 * Contains action hooks and functions for ZT Event post type.
 *
 * @class ZTEC_Team
 * @package zt-team-league\includes
 * @version 1.0.0
 */

class ZTEC_Team
{
    /**
     * Constructor for the Team class. Loads options and hooks.
     */
    public function __construct()
    {
        add_action('init', [$this, 'ztec_loaded_callback']);
        add_action( 'init', [$this, 'themes_taxonomy']);
        add_action('add_meta_boxes', [$this, 'ztec_event_register_meta_boxes']);
        add_action('save_post_' . ZTEC_TEAM_POST_TYPE, [$this, 'ztec_script_save_custom_box'], 10, 2);
    }
    /**
     * Callback funcation of register post type
     */
    public function ztec_loaded_callback()
    {
        $this->ztec_register_post_types();
    }
    
    /**
     * Responsible for register team post type
     */
    private function ztec_register_post_types()
    {
        $labels = array(
            'name' => __('Teams'),
            'singular_name' => __('Teams'),
            'menu_name' => __('Teams'),
            'name_admin_bar' => __(' Teams'),
            'add_new' => __('Add New'),
            'add_new_item' => __('Add New Teams'),
            'new_item' => __('New Teams'),
            'edit_item' => __('Edit Teams'),
            'view_item' => __('View Teams'),
            'all_items' => __('All Teams'),
            'search_items' => __('Search Teams'),
            'parent_item_colon' => __('Parent Teams:'),
            'not_found' => __('No Teams found.'),
            'not_found_in_trash' => __('No Teams found in Trash.'),
            'featured_image' => __('Teams logo'),
            'set_featured_image' => __('Set logo'),
            'remove_featured_image' => __('Remove logo'),
            'use_featured_image' => __('Use as logo'),
            'archives' => __('Teams archives'),
            'insert_into_item' => __('Insert into Teams'),
            'uploaded_to_this_item' => __('Uploaded to this Teams'),
            'filter_items_list' => __('Filter Teams list'),
            'items_list_navigation' => __('Teams list navigation'),
            'items_list' => __('Teams list'),
        );
        $args = array(
            'labels' => $labels,
            'description' => 'Teams',
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'query_var' => true,
            'rewrite' => array('slug' => ZTEC_TEAM_POST_TYPE),
            'capability_type' => 'post',
            'has_archive' => true,
            'hierarchical' => false,
            'menu_position' => 20,
            'show_in_rest' => true,
            'menu_icon'  => 'dashicons-calendar-alt',
            'supports' => array('title','thumbnail', 'block-editor'),
            'map_meta_cap' => true,
        );
        register_post_type(ZTEC_TEAM_POST_TYPE, $args);
    }

    /**
     * Responsible for register taxonomy of team 
     */
    function themes_taxonomy() {
        register_taxonomy(
            'league',  
            ZTEC_TEAM_POST_TYPE,            
            array(
                'hierarchical' => true,
                'label' => 'League', 
                'query_var' => true,
                'rewrite' => array(
                    'slug' => 'league',    
                    'with_front' => false 
                )
            )
        );
    }
    /**
     * Responsible for add meta box of team 
     */
    public function ztec_event_register_meta_boxes()
    {
        add_meta_box('ztec_event_plugin', __('Team Details', ZTEC_TEXT_DOMAIN), [$this, 'ztec_event_metabox_callback'], ZTEC_TEAM_POST_TYPE);
    }
    /**
     * Meta box callback funcation
     * 
     * @return metabox html 
     */
    function ztec_event_metabox_callback()
    {
        require_once ZTEC_UI_ADMIN_DIR . 'metabox/team_details.php';
    }
    /**
     * Responsible for store metabox data 
     */
    function ztec_script_save_custom_box($post_id, $post)
    { 
        if (isset($_POST['nickname'])) {
            update_post_meta($post_id, sanitize_key('_ztec_team_nickname'), sanitize_text_field($_POST['nickname']));
        }

        if (isset($_POST['history'])) {
            update_post_meta($post_id, sanitize_key('_ztec_team_history'), sanitize_text_field($_POST['history']));
        }       
    }


}
new ZTEC_Team();
// End Of Class Team