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

