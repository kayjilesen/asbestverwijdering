<?php

defined( 'ABSPATH' ) || exit;

// Prevent File Modifications
if ( ! defined( 'DISALLOW_FILE_EDIT' ) ) {
    define( 'DISALLOW_FILE_EDIT', true );
}

/**
 * Remove Actions
 */
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'index_rel_link');
remove_action('wp_head', 'parent_post_rel_link', 10, 0);
remove_action('wp_head', 'print_emoji_detection_script', 7 );
remove_action('wp_head', 'start_post_rel_link', 10, 0); 
remove_action('wp_head', 'rel_canonical');
remove_action('wp_head', 'rest_output_link_wp_head');
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'wp_generator' );
remove_action('wp_head', 'wp_oembed_add_discovery_links');
remove_action('wp_head', 'wp_oembed_add_host_js' );
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);

// Remove the REST API endpoint.
remove_action( 'rest_api_init', 'wp_oembed_register_route' );

//Remove REST API in HTTP Headers
remove_action('template_redirect', 'rest_output_link_header', 11, 0 );

// Remove Emoji Styles
remove_action('wp_print_styles', 'print_emoji_styles');

// Disable XML RPC
add_filter( 'xmlrpc_enabled', '__return_false' );

/**
 * Remove Admin Bar
 */
function remove_admin_bar() {
    return false;
}
add_filter('show_admin_bar', 'remove_admin_bar');

function my_remove_admin_menus() {
    remove_menu_page( 'edit-comments.php' );
}
add_action( 'admin_init', 'my_remove_admin_menus' );


/**
 * Disable Gutenberg
 */
//add_filter('use_block_editor_for_post_type', '__return_false', 10);

/**
 * Disable Gutenberg Scripts
 */
add_action( 'wp_enqueue_scripts', 'remove_block_css', 100 );
function remove_block_css() {
    wp_dequeue_style( 'wp-block-library' ); // Wordpress core
    wp_dequeue_style( 'wp-block-library-theme' ); // Wordpress core
    wp_dequeue_style( 'wc-block-style' ); // WooCommerce
    wp_dequeue_style( 'storefront-gutenberg-blocks' ); // Storefront theme
}

/**
 * Remove Included Styles
 */
add_action( 'wp_enqueue_scripts', function() {
    wp_dequeue_style('global-styles');
    wp_deregister_style( 'global-styles' );
    wp_dequeue_style( 'classic-theme-styles' );
}, 100000 );    

/**
 * Stop Heartbeat API
 */
function stop_heartbeat() {
    wp_deregister_script( 'heartbeat' );
}
add_action( 'init', 'stop_heartbeat', 1 );

