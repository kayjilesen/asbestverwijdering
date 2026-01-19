<?php

defined( 'ABSPATH' ) || exit;

/**
 * Register Custom Post Types
 */
function kj_register_post_types() {
    
    // Register Projects Post Type
    $labels = array(
        'name'                  => _x( 'Projecten', 'Post Type General Name', 'kj' ),
        'singular_name'         => _x( 'Project', 'Post Type Singular Name', 'kj' ),
        'menu_name'             => __( 'Projecten', 'kj' ),
        'name_admin_bar'        => __( 'Project', 'kj' ),
        'archives'              => __( 'Project Archief', 'kj' ),
        'attributes'            => __( 'Project Attributen', 'kj' ),
        'parent_item_colon'     => __( 'Bovenliggend Project:', 'kj' ),
        'all_items'             => __( 'Alle Projecten', 'kj' ),
        'add_new_item'          => __( 'Nieuw Project Toevoegen', 'kj' ),
        'add_new'               => __( 'Nieuw Project', 'kj' ),
        'new_item'              => __( 'Nieuw Project', 'kj' ),
        'edit_item'             => __( 'Project Bewerken', 'kj' ),
        'update_item'           => __( 'Project Bijwerken', 'kj' ),
        'view_item'             => __( 'Project Bekijken', 'kj' ),
        'view_items'            => __( 'Projecten Bekijken', 'kj' ),
        'search_items'          => __( 'Project Zoeken', 'kj' ),
        'not_found'             => __( 'Niet gevonden', 'kj' ),
        'not_found_in_trash'    => __( 'Niet gevonden in prullenbak', 'kj' ),
        'featured_image'        => __( 'Uitgelichte Afbeelding', 'kj' ),
        'set_featured_image'    => __( 'Uitgelichte Afbeelding Instellen', 'kj' ),
        'remove_featured_image' => __( 'Uitgelichte Afbeelding Verwijderen', 'kj' ),
        'use_featured_image'    => __( 'Gebruik als Uitgelichte Afbeelding', 'kj' ),
        'insert_into_item'      => __( 'Invoegen in Project', 'kj' ),
        'uploaded_to_this_item' => __( 'Geüpload naar dit Project', 'kj' ),
        'items_list'            => __( 'Projecten Lijst', 'kj' ),
        'items_list_navigation' => __( 'Projecten Lijst Navigatie', 'kj' ),
        'filter_items_list'     => __( 'Filter Projecten Lijst', 'kj' ),
    );
    
    $args = array(
        'label'                 => __( 'Project', 'kj' ),
        'description'           => __( 'Projecten post type', 'kj' ),
        'labels'                => $labels,
        'supports'              => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields' ),
        'taxonomies'            => array(),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 20,
        'menu_icon'             => 'dashicons-portfolio',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'post',
        'show_in_rest'          => true,
        'rewrite'               => array(
            'slug'                  => 'projecten',
            'with_front'            => false,
            'pages'                 => true,
            'feeds'                 => true,
        ),
    );
    
    register_post_type( 'project', $args );
    
    // Register Vacatures Post Type
    $labels = array(
        'name'                  => _x( 'Vacatures', 'Post Type General Name', 'kj' ),
        'singular_name'         => _x( 'Vacature', 'Post Type Singular Name', 'kj' ),
        'menu_name'             => __( 'Vacatures', 'kj' ),
        'name_admin_bar'        => __( 'Vacature', 'kj' ),
        'archives'              => __( 'Vacature Archief', 'kj' ),
        'attributes'            => __( 'Vacature Attributen', 'kj' ),
        'parent_item_colon'     => __( 'Bovenliggende Vacature:', 'kj' ),
        'all_items'             => __( 'Alle Vacatures', 'kj' ),
        'add_new_item'          => __( 'Nieuwe Vacature Toevoegen', 'kj' ),
        'add_new'               => __( 'Nieuwe Vacature', 'kj' ),
        'new_item'              => __( 'Nieuwe Vacature', 'kj' ),
        'edit_item'             => __( 'Vacature Bewerken', 'kj' ),
        'update_item'           => __( 'Vacature Bijwerken', 'kj' ),
        'view_item'             => __( 'Vacature Bekijken', 'kj' ),
        'view_items'            => __( 'Vacatures Bekijken', 'kj' ),
        'search_items'          => __( 'Vacature Zoeken', 'kj' ),
        'not_found'             => __( 'Niet gevonden', 'kj' ),
        'not_found_in_trash'    => __( 'Niet gevonden in prullenbak', 'kj' ),
        'featured_image'        => __( 'Uitgelichte Afbeelding', 'kj' ),
        'set_featured_image'    => __( 'Uitgelichte Afbeelding Instellen', 'kj' ),
        'remove_featured_image' => __( 'Uitgelichte Afbeelding Verwijderen', 'kj' ),
        'use_featured_image'    => __( 'Gebruik als Uitgelichte Afbeelding', 'kj' ),
        'insert_into_item'      => __( 'Invoegen in Vacature', 'kj' ),
        'uploaded_to_this_item' => __( 'Geüpload naar deze Vacature', 'kj' ),
        'items_list'            => __( 'Vacatures Lijst', 'kj' ),
        'items_list_navigation' => __( 'Vacatures Lijst Navigatie', 'kj' ),
        'filter_items_list'     => __( 'Filter Vacatures Lijst', 'kj' ),
    );
    
    $args = array(
        'label'                 => __( 'Vacature', 'kj' ),
        'description'           => __( 'Vacatures post type', 'kj' ),
        'labels'                => $labels,
        'supports'              => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields' ),
        'taxonomies'            => array(),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 21,
        'menu_icon'             => 'dashicons-groups',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => false,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'post',
        'show_in_rest'          => true,
        'rewrite'               => array(
            'slug'                  => 'vacatures',
            'with_front'            => false,
            'pages'                 => true,
            'feeds'                 => true,
        ),
    );
    
    register_post_type( 'vacature', $args );
    
    // Register Reviews Post Type
    $labels = array(
        'name'                  => _x( 'Reviews', 'Post Type General Name', 'kj' ),
        'singular_name'         => _x( 'Review', 'Post Type Singular Name', 'kj' ),
        'menu_name'             => __( 'Reviews', 'kj' ),
        'name_admin_bar'        => __( 'Review', 'kj' ),
        'archives'              => __( 'Review Archief', 'kj' ),
        'attributes'            => __( 'Review Attributen', 'kj' ),
        'parent_item_colon'     => __( 'Bovenliggende Review:', 'kj' ),
        'all_items'             => __( 'Alle Reviews', 'kj' ),
        'add_new_item'          => __( 'Nieuwe Review Toevoegen', 'kj' ),
        'add_new'               => __( 'Nieuwe Review', 'kj' ),
        'new_item'              => __( 'Nieuwe Review', 'kj' ),
        'edit_item'             => __( 'Review Bewerken', 'kj' ),
        'update_item'           => __( 'Review Bijwerken', 'kj' ),
        'view_item'             => __( 'Review Bekijken', 'kj' ),
        'view_items'            => __( 'Reviews Bekijken', 'kj' ),
        'search_items'          => __( 'Review Zoeken', 'kj' ),
        'not_found'             => __( 'Niet gevonden', 'kj' ),
        'not_found_in_trash'    => __( 'Niet gevonden in prullenbak', 'kj' ),
        'featured_image'        => __( 'Uitgelichte Afbeelding', 'kj' ),
        'set_featured_image'    => __( 'Uitgelichte Afbeelding Instellen', 'kj' ),
        'remove_featured_image' => __( 'Uitgelichte Afbeelding Verwijderen', 'kj' ),
        'use_featured_image'    => __( 'Gebruik als Uitgelichte Afbeelding', 'kj' ),
        'insert_into_item'      => __( 'Invoegen in Review', 'kj' ),
        'uploaded_to_this_item' => __( 'Geüpload naar deze Review', 'kj' ),
        'items_list'            => __( 'Reviews Lijst', 'kj' ),
        'items_list_navigation' => __( 'Reviews Lijst Navigatie', 'kj' ),
        'filter_items_list'     => __( 'Filter Reviews Lijst', 'kj' ),
    );
    
    $args = array(
        'label'                 => __( 'Review', 'kj' ),
        'description'           => __( 'Reviews post type', 'kj' ),
        'labels'                => $labels,
        'supports'              => array( 'title', 'thumbnail', 'custom-fields' ),
        'taxonomies'            => array(),
        'hierarchical'          => false,
        'public'                => false,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 22,
        'menu_icon'             => 'dashicons-star-filled',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => false,
        'can_export'            => true,
        'has_archive'           => false,
        'exclude_from_search'   => true,
        'publicly_queryable'    => false,
        'capability_type'       => 'post',
        'show_in_rest'          => true,
    );
    
    register_post_type( 'review', $args );
    
    // Register Auteurs Post Type
    $labels = array(
        'name'                  => _x( 'Auteurs', 'Post Type General Name', 'kj' ),
        'singular_name'         => _x( 'Auteur', 'Post Type Singular Name', 'kj' ),
        'menu_name'             => __( 'Auteurs', 'kj' ),
        'name_admin_bar'        => __( 'Auteur', 'kj' ),
        'archives'              => __( 'Auteur Archief', 'kj' ),
        'attributes'            => __( 'Auteur Attributen', 'kj' ),
        'parent_item_colon'     => __( 'Bovenliggende Auteur:', 'kj' ),
        'all_items'             => __( 'Alle Auteurs', 'kj' ),
        'add_new_item'          => __( 'Nieuwe Auteur Toevoegen', 'kj' ),
        'add_new'               => __( 'Nieuwe Auteur', 'kj' ),
        'new_item'              => __( 'Nieuwe Auteur', 'kj' ),
        'edit_item'             => __( 'Auteur Bewerken', 'kj' ),
        'update_item'           => __( 'Auteur Bijwerken', 'kj' ),
        'view_item'             => __( 'Auteur Bekijken', 'kj' ),
        'view_items'            => __( 'Auteurs Bekijken', 'kj' ),
        'search_items'          => __( 'Auteur Zoeken', 'kj' ),
        'not_found'             => __( 'Niet gevonden', 'kj' ),
        'not_found_in_trash'    => __( 'Niet gevonden in prullenbak', 'kj' ),
        'featured_image'        => __( 'Profielfoto', 'kj' ),
        'set_featured_image'    => __( 'Profielfoto Instellen', 'kj' ),
        'remove_featured_image' => __( 'Profielfoto Verwijderen', 'kj' ),
        'use_featured_image'    => __( 'Gebruik als Profielfoto', 'kj' ),
        'insert_into_item'      => __( 'Invoegen in Auteur', 'kj' ),
        'uploaded_to_this_item' => __( 'Geüpload naar deze Auteur', 'kj' ),
        'items_list'            => __( 'Auteurs Lijst', 'kj' ),
        'items_list_navigation' => __( 'Auteurs Lijst Navigatie', 'kj' ),
        'filter_items_list'     => __( 'Filter Auteurs Lijst', 'kj' ),
    );
    
    $args = array(
        'label'                 => __( 'Auteur', 'kj' ),
        'description'           => __( 'Auteurs post type', 'kj' ),
        'labels'                => $labels,
        'supports'              => array( 'title', 'thumbnail', 'custom-fields' ),
        'taxonomies'            => array(),
        'hierarchical'          => false,
        'public'                => false,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 23,
        'menu_icon'             => 'dashicons-admin-users',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => false,
        'can_export'            => true,
        'has_archive'           => false,
        'exclude_from_search'   => true,
        'publicly_queryable'    => false,
        'capability_type'       => 'post',
        'show_in_rest'          => true,
    );
    
    register_post_type( 'auteur', $args );
}
add_action( 'init', 'kj_register_post_types', 0 );

/**
 * Register Custom Taxonomies for Projects
 */
function kj_register_project_taxonomies() {

    // Register Project Diensten Taxonomy
    $labels = array(
        'name'                       => _x( 'Diensten', 'Taxonomy General Name', 'kj' ),
        'singular_name'              => _x( 'Dienst', 'Taxonomy Singular Name', 'kj' ),
        'menu_name'                  => __( 'Diensten', 'kj' ),
        'all_items'                  => __( 'Alle Diensten', 'kj' ),
        'parent_item'                => __( 'Bovenliggende Dienst', 'kj' ),
        'parent_item_colon'          => __( 'Bovenliggende Dienst:', 'kj' ),
        'new_item_name'              => __( 'Nieuwe Dienst Naam', 'kj' ),
        'add_new_item'               => __( 'Nieuwe Dienst Toevoegen', 'kj' ),
        'edit_item'                  => __( 'Dienst Bewerken', 'kj' ),
        'update_item'                => __( 'Dienst Bijwerken', 'kj' ),
        'view_item'                  => __( 'Dienst Bekijken', 'kj' ),
        'separate_items_with_commas' => __( 'Scheid diensten met komma\'s', 'kj' ),
        'add_or_remove_items'        => __( 'Diensten toevoegen of verwijderen', 'kj' ),
        'choose_from_most_used'      => __( 'Kies uit meest gebruikte', 'kj' ),
        'popular_items'              => __( 'Populaire Diensten', 'kj' ),
        'search_items'               => __( 'Diensten Zoeken', 'kj' ),
        'not_found'                  => __( 'Niet gevonden', 'kj' ),
        'no_terms'                   => __( 'Geen diensten', 'kj' ),
        'items_list'                 => __( 'Diensten lijst', 'kj' ),
        'items_list_navigation'      => __( 'Diensten lijst navigatie', 'kj' ),
    );

    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => false,
        'show_in_rest'               => true,
        'rewrite'                    => array(
            'slug'                   => 'projecten/dienst',
            'with_front'             => false,
            'hierarchical'           => true,
        ),
    );

    register_taxonomy( 'project_dienst', array( 'project' ), $args );

    // Register Project Doelgroep Taxonomy
    $labels = array(
        'name'                       => _x( 'Doelgroepen', 'Taxonomy General Name', 'kj' ),
        'singular_name'              => _x( 'Doelgroep', 'Taxonomy Singular Name', 'kj' ),
        'menu_name'                  => __( 'Doelgroepen', 'kj' ),
        'all_items'                  => __( 'Alle Doelgroepen', 'kj' ),
        'parent_item'                => __( 'Bovenliggende Doelgroep', 'kj' ),
        'parent_item_colon'          => __( 'Bovenliggende Doelgroep:', 'kj' ),
        'new_item_name'              => __( 'Nieuwe Doelgroep Naam', 'kj' ),
        'add_new_item'               => __( 'Nieuwe Doelgroep Toevoegen', 'kj' ),
        'edit_item'                  => __( 'Doelgroep Bewerken', 'kj' ),
        'update_item'                => __( 'Doelgroep Bijwerken', 'kj' ),
        'view_item'                  => __( 'Doelgroep Bekijken', 'kj' ),
        'separate_items_with_commas' => __( 'Scheid doelgroepen met komma\'s', 'kj' ),
        'add_or_remove_items'        => __( 'Doelgroepen toevoegen of verwijderen', 'kj' ),
        'choose_from_most_used'      => __( 'Kies uit meest gebruikte', 'kj' ),
        'popular_items'              => __( 'Populaire Doelgroepen', 'kj' ),
        'search_items'               => __( 'Doelgroepen Zoeken', 'kj' ),
        'not_found'                  => __( 'Niet gevonden', 'kj' ),
        'no_terms'                   => __( 'Geen doelgroepen', 'kj' ),
        'items_list'                 => __( 'Doelgroepen lijst', 'kj' ),
        'items_list_navigation'      => __( 'Doelgroepen lijst navigatie', 'kj' ),
    );

    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => false,
        'show_in_rest'               => true,
        'rewrite'                    => array(
            'slug'                   => 'projecten/doelgroep',
            'with_front'             => false,
            'hierarchical'           => true,
        ),
    );

    register_taxonomy( 'project_doelgroep', array( 'project' ), $args );
}
add_action( 'init', 'kj_register_project_taxonomies', 0 );

