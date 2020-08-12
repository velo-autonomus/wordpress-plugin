<?php
/**
 * Plugin Name: velo-autonomus-Plugin
 */

include_once(dirname(__FILE__).'/custom-post-types/velo_home_section.php');
include_once(dirname(__FILE__).'/custom-post-types/velo_roadmap_item.php');
 

function velo_setup_post_types() {
    velo_setup_home_section_type();
    velo_setup_roadmap_item_type();
}

function velo_unregister_post_types() {
    unregister_post_type('velo_home_section');
    unregister_post_type('velo_roadmap_item');
}

function velo_button_shortcode( $atts = [], $content = null, $tag = '' ) {
    // normalize attribute keys, lowercase
    $atts = array_change_key_case( (array) $atts, CASE_LOWER );
 
    // override default attributes with user attributes
    $wporg_atts = shortcode_atts(
        array(
            'link' => './',
        ), $atts, $tag
    );
 
    // start box
    $o = '<a href="'.esc_html__( $wporg_atts['link'] ).'"><button>';
 
    // enclosing tags
    if ( ! is_null( $content ) ) {
        // secure output by executing the_content filter hook on $content
        $o .= apply_filters( 'the_content', $content );
 
        // run shortcode parser recursively
        //$o .= do_shortcode( $content );
    }
 
    // end box
    $o .= '</button></a>';
 
    // return output
    return $o;
}

function velo_supporter_shortcode( $atts = [], $content = null, $tag = '' ) {
    // normalize attribute keys, lowercase
    $atts = array_change_key_case( (array) $atts, CASE_LOWER );
 
    // override default attributes with user attributes
    $wporg_atts = shortcode_atts(
        array(
            'link' => './',
            'img' => '',
            'alt' => ''
        ), $atts, $tag
    );
 
    // start box
    $o = '<a href="'.esc_url( $wporg_atts['link'] ).'" target="_blank" rel="noreferrer" class="supporter"><img src="'.esc_url( $wporg_atts['img']).'" alt="'.esc_html__( $wporg_atts['alt'] ).'" />';
 
    $o .= '</a>';
 
    // return output
    return $o;
}
 
/**
 * Central location to create all shortcodes.
 */
function velo_shortcodes_init() {
    add_shortcode( 'velo-button', 'velo_button_shortcode' );
    add_shortcode( 'velo-supporter', 'velo_supporter_shortcode' );
}


add_action( 'init', 'velo_shortcodes_init' );

/**
 * Activate the plugin.
 */
function velo_activate() { 
    // Trigger our function that registers the custom post type plugin.
    velo_setup_post_types(); 
    // Clear the permalinks after the post type has been registered.
    flush_rewrite_rules(); 
}
register_activation_hook( __FILE__, 'velo_activate' );

function velo_deactivate() {
    // Unregister the post type, so the rules are no longer in memory.
    velo_unregister_post_types();
    // Clear the permalinks to remove our post type's rules from the database.
    flush_rewrite_rules();
}
register_deactivation_hook( __FILE__, 'velo_deactivate' );

?>