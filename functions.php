<?php

defined( 'ABSPATH' ) || exit;

if ( ! defined( '_KAYJILESEN_VERSION' ) ) {
	define( '_KAYJILESEN_VERSION', '1.0.0' );
}

require_once get_template_directory() . '/inc/helpers.php';
require_once get_template_directory() . '/inc/remove.php';
require_once get_template_directory() . '/inc/settings.php';
require_once get_template_directory() . '/inc/post-types.php';
require_once get_template_directory() . '/inc/acf.php';
require_once get_template_directory() . '/inc/custom-header.php';
require_once get_template_directory() . '/inc/scripts.php';
require_once get_template_directory() . '/inc/template-functions.php';
require_once get_template_directory() . '/templates/components/button.php';

/**
 * Limit post/page revisions to maximum 5
 */
add_filter( 'wp_revisions_to_keep', 'kj_limit_revisions', 10, 2 );
function kj_limit_revisions( $num, $post ) {
	return 5;
}

/**
 * Modify query for kennisbank archive filtering
 */
add_action( 'pre_get_posts', 'kj_kennisbank_archive_filter' );
function kj_kennisbank_archive_filter( $query ) {
    // Only modify main query on blog archive/home page
    if ( ! is_admin() && $query->is_main_query() && ( is_home() || ( is_archive() && get_post_type() === 'post' ) ) ) {
        $current_category = isset( $_GET['categorie'] ) ? sanitize_text_field( $_GET['categorie'] ) : '';
        
        if ( $current_category && $current_category !== 'alle' ) {
            $query->set( 'category_name', $current_category );
        }
    }
}
