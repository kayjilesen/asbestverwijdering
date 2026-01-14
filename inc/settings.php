<?php

defined( 'ABSPATH' ) || exit;

if ( ! defined( 'ACF_PRO_LICENSE' ) ) {
    define( 'ACF_PRO_LICENSE', 'b3JkZXJfaWQ9MTY1NTEyfHR5cGU9ZGV2ZWxvcGVyfGRhdGU9MjAxOS0wNy0xNiAwODozNDo0OQ==');
}

// Check if the options have already been set
if ( ! get_option( 'kj_theme_settings' ) ) {

    // Set week start (0 for Sunday, 1 for Monday, etc.)
    update_option( 'start_of_week', 1 );
  
    // Set date format
    update_option( 'date_format', 'd-m-Y' );

    // Set time format
    update_option( 'time_format', 'H:i' );

    // Set timezone
    update_option( 'timezone_string', 'Europe/Amsterdam' );

    // Set permalink structure
    update_option( 'permalink_structure', '/%postname%/' );

    // Set site language
    update_option( 'WPLANG', 'nl_NL_formal' );

    // Init Functions
    kj_init_create_home_page();
    kj_init_create_menu();
    kj_init_create_footer_menu();

    // Set the flag to indicate that options have been set
    update_option( 'kj_theme_settings', true );
}

function kj_init_create_home_page() {

    $home_page = get_page_by_path( 'Home' );

    if ( ! $home_page ) {

        $page_data = array(
            'post_title'    => 'Home',
            'post_content'  => '',
            'post_status'   => 'publish',
            'post_type'     => 'page',
        );

        $page_id = wp_insert_post( $page_data );

        // Optionally, you can set this page as the front page
        update_option( 'show_on_front', 'page' );
        update_option( 'page_on_front', $page_id );

        return $page_id; // Return the ID of the newly created page
    } else {
        return $home_page->ID; // Return the ID of the existing page
    }
}

function kj_init_create_menu() {
    $menu_exists = wp_get_nav_menu_object( 'Hoofdmenu' );

    if ( ! $menu_exists ) {
        $menu_id = wp_create_nav_menu( 'Hoofdmenu' );

        // Optionally, you can add items to the menu here
        wp_update_nav_menu_item( $menu_id, 0, array(
            'menu-item-title'   => 'Home',
            'menu-item-url'     => home_url( '/' ),
            'menu-item-status'  => 'publish'
        ));

        $locations = get_theme_mod( 'nav_menu_locations' );
        $locations['primary-menu'] = $menu_id;
        set_theme_mod( 'nav_menu_locations', $locations );

        return $menu_id; 
    } else {
        return $menu_exists->term_id;
    }
}

/**
 * Create Footer Menu
 */
function kj_init_create_footer_menu() {
    $menu_exists = wp_get_nav_menu_object( 'Footermenu' );

    if ( ! $menu_exists ) {
        $menu_id = wp_create_nav_menu( 'Footermenu' );

        $locations = get_theme_mod( 'nav_menu_locations' );
        $locations['footer-menu'] = $menu_id;
        set_theme_mod( 'nav_menu_locations', $locations );

        return $menu_id; 
    } else {
        return $menu_exists->term_id;
    }
}

/**
 * Automatically add all products to the 'Products' menu item
 */
function kj_auto_add_products_to_menu() {
    // Get the Hoofdmenu menu
    $menu = wp_get_nav_menu_object( 'Hoofdmenu' );
    
    if ( ! $menu ) {
        return false;
    }
    
    $menu_id = $menu->term_id;
    
    // Get all menu items
    $menu_items = wp_get_nav_menu_items( $menu_id );
    
    // Find or create the 'Products' parent menu item
    $products_menu_item_db_id = null;
    
    if ( $menu_items ) {
        foreach ( $menu_items as $item ) {
            if ( ( $item->title === 'Products' || $item->title === 'Producten' ) && $item->menu_item_parent == 0 ) {
                $products_menu_item_db_id = $item->db_id;
                break;
            }
        }
    }
    
    // If Products menu item doesn't exist, create it
    if ( ! $products_menu_item_db_id ) {
        $products_parent_url = get_post_type_archive_link( 'product' );
        if ( ! $products_parent_url ) {
            $products_parent_url = home_url( '/products/' );
        }
        
        $products_menu_item_db_id = wp_update_nav_menu_item( $menu_id, 0, array(
            'menu-item-title'     => 'Products',
            'menu-item-url'       => $products_parent_url,
            'menu-item-status'    => 'publish',
            'menu-item-type'      => 'custom',
        ));
    }
    
    // Refresh menu items after potential creation
    $menu_items = wp_get_nav_menu_items( $menu_id );
    
    // Remove existing product submenu items
    if ( $menu_items && $products_menu_item_db_id ) {
        foreach ( $menu_items as $item ) {
            // Remove items that are children of Products menu item or are product post types under Products
            if ( $item->menu_item_parent == $products_menu_item_db_id || 
                 ( isset( $item->post_type ) && $item->post_type === 'product' && $item->menu_item_parent == $products_menu_item_db_id ) ) {
                wp_delete_post( $item->db_id, true );
            }
        }
    }
    
    // Get all published products
    $products = get_posts( array(
        'post_type'      => 'product',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'orderby'        => 'title',
        'order'          => 'ASC',
    ) );
    
    // Add each product as a submenu item
    if ( $products_menu_item_db_id && ! empty( $products ) ) {
        $menu_order = 1;
        foreach ( $products as $product ) {
            wp_update_nav_menu_item( $menu_id, 0, array(
                'menu-item-title'     => $product->post_title,
                'menu-item-url'       => get_permalink( $product->ID ),
                'menu-item-status'    => 'publish',
                'menu-item-type'      => 'post_type',
                'menu-item-object'    => 'product',
                'menu-item-object-id' => $product->ID,
                'menu-item-parent-id' => $products_menu_item_db_id,
                'menu-item-position'  => $menu_order++,
            ) );
        }
    }
    
    return true;
}

// Run when a product is saved, published, or deleted
add_action( 'save_post_product', 'kj_auto_add_products_to_menu' );

// Run when a product is deleted
add_action( 'delete_post', function( $post_id ) {
    $post = get_post( $post_id );
    if ( $post && $post->post_type === 'product' ) {
        kj_auto_add_products_to_menu();
    }
} );

// Also run on theme activation
add_action( 'after_switch_theme', 'kj_auto_add_products_to_menu' );

/**
 * Disable Gutenberg editor for pages not using the 'Text' template and for projects
 */
add_filter( 'use_block_editor_for_post_type', 'kj_disable_gutenberg_for_non_text_templates', 10, 2 );
function kj_disable_gutenberg_for_non_text_templates( $use_block_editor, $post_type ) {
    
    // Disable Gutenberg for projects (they use ACF pagebuilder)
    if ( $post_type === 'project' ) {
        return false;
    }
    
    // Disable Gutenberg for vacatures (they use ACF pagebuilder)
    if ( $post_type === 'vacature' ) {
        return false;
    }
    
    // Only apply to pages
    if ( $post_type !== 'page' ) {
        return $use_block_editor;
    }
    
    // If we're not in the admin, don't modify
    if ( ! is_admin() ) {
        return $use_block_editor;
    }
    
    // Get the current post ID
    global $post;
    if ( ! $post || ! isset( $post->ID ) ) {
        return $use_block_editor;
    }
    
    // Get the page template
    $template = get_page_template_slug( $post->ID );
    
    // Check if it's the 'text.php' template
    if ( $template === 'templates/text.php' ) {
        // Enable block editor for text template
        return true;
    } else {
        // Disable block editor for all other templates
        return false;
    }
}

/**
 * Hide editor and excerpt for vacature post type
 */
add_action( 'init', 'kj_hide_editor_excerpt_for_vacature' );
function kj_hide_editor_excerpt_for_vacature() {
    remove_post_type_support( 'vacature', 'editor' );
    remove_post_type_support( 'vacature', 'excerpt' );
}
