<?php

defined( 'ABSPATH' ) || exit;

/**
 * Register Custom Menu
 */
function register_custom_menu()
{
    register_nav_menus(array( 
        'primary-menu' => __('Primary Menu', 'kj'),
        'mobile-menu' => __('Mobile Menu', 'kj'),
        'footer-menu' => __('Footer Menu', 'kj'),
    ));
}

function kj_nav($nav_menu = 'primary-menu', $nav_menu_name = 'Hoofdmenu') {
    $args = array(
        'theme_location'  => $nav_menu,
        'menu'            => $nav_menu_name,
        'menu_class'      => 'menu',
        'menu_id'         => '',
        'container'       => 'div',
		'container_class' => $nav_menu . '-container',
        'container_id'    => '',
        'echo'            => true,
        'fallback_cb'     => 'wp_page_menu',
        'before'          => '',
        'after'           => '',
        'link_before'     => '',
        'link_after'      => '',
        'items_wrap'      => '<ul class="menu ' . $nav_menu . '">%3$s</ul>',
        'depth'           => 3,
        'walker'          => ''
    );
	wp_nav_menu($args);
}
add_action('init', 'register_custom_menu');

// <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class=""><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" /></svg>

/**
 *   Add Chevron to items with a submenu
 */
function kj_add_chevron_to_menu_item($item_output, $item, $depth, $args) {

    $chevron_icon = '<div class="chevron-wrapper"><svg class="w-6 h-6 lg:w-4 lg:h-4 lg:ml-1 duration-300 ease-in-out" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M7.41 7.84L12 12.42l4.59-4.58L18 9.25l-6 6-6-6z"/></svg></div>';

    if (in_array('menu-item-has-children', $item->classes)) {
        // For mobile menu, place chevron inside the <a> tag
        if ($args->theme_location == 'mobile-menu') {
            $item_output = str_replace('</a>', $chevron_icon . '</a>', $item_output);
        } else {
            // For desktop menu, keep chevron after </a>
            $item_output = str_replace('</a>','</a>' . $chevron_icon, $item_output);
        }
    }

    return $item_output;
}
add_filter('walker_nav_menu_start_el', 'kj_add_chevron_to_menu_item', 10, 4);

// Update contact menu item URL to use ACF option page_contact
function kj_update_contact_menu_item_url($item_output, $item, $depth, $args) {
    
    // Check if this is a contact menu item (by title or class)
    $is_contact_item = false;
    if (stripos($item->title, 'contact') !== false || 
        in_array('menu-item-contact', $item->classes) ||
        (isset($item->url) && stripos($item->url, 'contact') !== false)) {
        $is_contact_item = true;
    }
    
    if ($is_contact_item) {
        $contact_page = get_field('page_contact', 'option');
        if ( $contact_page ) {
            $contact_url = '';
            if ( is_object( $contact_page ) ) {
                $contact_url = get_permalink( $contact_page->ID );
            } else {
                $contact_url = get_permalink( $contact_page );
            }
            
            if ( $contact_url ) {
                // Replace the href attribute in the menu item
                $item_output = preg_replace(
                    '/(<a[^>]*href=")[^"]*("[^>]*>)/i',
                    '$1' . esc_url( $contact_url ) . '$2',
                    $item_output
                );
            }
        }
    }
    
    return $item_output;
}
add_filter('walker_nav_menu_start_el', 'kj_update_contact_menu_item_url', 10, 4);

// Add custom menu item to WordPress menu
function add_custom_menu_item($items, $args) {
    
    if ($args->theme_location == 'primary-menu' || $args->theme_location == 'mobile-menu') {

        // Add Socials
        $items .= '<li class="socials-item flex flex-row gap-1 pl-3">';
            if(get_field('socials_linkedin', 'option')) :
                $items .= '<a target="_blank" href="' . get_field('socials_linkedin', 'option') . '" class="social-menu-item">';
                    $items .= '<svg class="w-4 h-4 fill-grey" xmlns="http://www.w3.org/2000/svg" viewBox="0 5 1036 990"><path d="M0 120c0-33.334 11.667-60.834 35-82.5C58.333 15.833 88.667 5 126 5c36.667 0 66.333 10.666 89 32 23.333 22 35 50.666 35 86 0 32-11.333 58.666-34 80-23.333 22-54 33-92 33h-1c-36.667 0-66.333-11-89-33S0 153.333 0 120zm13 875V327h222v668H13zm345 0h222V622c0-23.334 2.667-41.334 8-54 9.333-22.667 23.5-41.834 42.5-57.5 19-15.667 42.833-23.5 71.5-23.5 74.667 0 112 50.333 112 151v357h222V612c0-98.667-23.333-173.5-70-224.5S857.667 311 781 311c-86 0-153 37-201 111v2h-1l1-2v-95H358c1.333 21.333 2 87.666 2 199 0 111.333-.667 267.666-2 469z"></path></svg>';
                $items .= '</a>';
            endif;
            if(get_field('socials_x', 'option')) :
                $items .= '<a target="_blank" href="' . get_field('socials_x', 'option') . '" class="social-menu-item">';
                    $items .= '<svg class="w-4 h-4 fill-grey" viewBox="0 0 24 24" aria-hidden="true"><g><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"></path></g></svg>';
                $items .= '</a>';
            endif;
        $items .= '</li>';
    }
    return $items;
}
add_filter('wp_nav_menu_items', 'add_custom_menu_item', 10, 2);


