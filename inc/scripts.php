<?php

defined( 'ABSPATH' ) || exit;

/**
 * Scripts
 */
function kj_scripts() {

    wp_register_script('kj-script', get_template_directory_uri() . '/assets/js/script.js', array(), filemtime( get_stylesheet_directory() . '/assets/js/script.js'), 'all');
    wp_enqueue_script('kj-script');

    // Pagebuilder blocks JavaScript
    wp_register_script('kj-pagebuilder', get_template_directory_uri() . '/assets/js/pagebuilder.js', array('jquery', 'swiper'), filemtime( get_stylesheet_directory() . '/assets/js/pagebuilder.js'), true);
    wp_enqueue_script('kj-pagebuilder');

    if ( ! wp_script_is( 'jquery', 'enqueued' )) {
        wp_enqueue_script( 'jquery' );
    }

    // Swiper assets for sliders
    wp_enqueue_style(
        'swiper',
        'https://unpkg.com/swiper@10/swiper-bundle.min.css',
        array(),
        '10.0.0',
        'all'
    );

    wp_enqueue_script(
        'swiper',
        'https://unpkg.com/swiper@10/swiper-bundle.min.js',
        array(),
        '10.0.0',
        true
    );

    // Archive Project Scripts
    if (is_post_type_archive('project')) {
        wp_register_script('kj-archive-project', get_template_directory_uri() . '/assets/js/archive-project.js', array(), filemtime(get_stylesheet_directory() . '/assets/js/archive-project.js'), true);
        wp_enqueue_script('kj-archive-project');
    }
}
add_action('wp_enqueue_scripts', 'kj_scripts');

/**
 * Stylesheets
 */
function kj_styles() {    

    wp_register_style('style', get_template_directory_uri() . '/assets/css/style.css', array(), filemtime(get_theme_file_path('/assets/css/style.css')), 'all');
    wp_enqueue_style('style'); // Style

    // Archive Project Styles
    if (is_post_type_archive('project') || is_singular('project')) {
        wp_register_style('archive-project', get_template_directory_uri() . '/assets/css/archive-project.css', array('style'), filemtime(get_theme_file_path('/assets/css/archive-project.css')), 'all');
        wp_enqueue_style('archive-project');
    }

    // Archive Vacature Styles
    if (is_post_type_archive('vacature') || is_singular('vacature')) {
        wp_register_style('archive-vacature', get_template_directory_uri() . '/assets/css/archive-project.css', array('style'), filemtime(get_theme_file_path('/assets/css/archive-project.css')), 'all');
        wp_enqueue_style('archive-vacature');
    }

}
add_action('wp_enqueue_scripts', 'kj_styles');