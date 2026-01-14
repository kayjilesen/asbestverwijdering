<?php

defined( 'ABSPATH' ) || exit;

/**
 * Add ACF Pro Options
 */
if( function_exists('acf_add_options_page') ) {

    $parent = acf_add_options_page(array(
        'page_title'  => __('Theme Settings', 'kj'),
        'menu_title'  => __('Theme Settings', 'kj'),
        'menu_slug'   => 'theme-settings',
        'redirect'    => false,
    ));

    // ACF JSON Save/Load
    add_filter('acf/settings/save_json', function($path) {
        $path = get_template_directory() . '/acf-json';
        return $path;
    });

    add_filter('acf/settings/load_json', function($paths) {
        unset($paths[0]);
        $paths[] = get_template_directory() . '/acf-json';
        return $paths;
    });
}

/**
 * Auto Escape ACF Field
 */
function kj_acf($field_name, $post_id = null) {

    if ($post_id === 'sub') { 
        $field_value = get_sub_field($field_name);
        $field_object = $post_id ? get_sub_field_object($field_name, $post_id) : get_sub_field_object($field_name);
    } else {
        $field_value = $post_id ? get_field($field_name, $post_id) : get_field($field_name);
        $field_object = $post_id ? get_field_object($field_name, $post_id) : get_field_object($field_name);
    }
    
    echo kj_escape_html($field_value);
}

function kj_image($field_name, $size = 'full', $post_id = null, $default = null) {

    // Get attachment ID from ACF field (image field type   
    if($field_name === 'featured') {
        $attachment_id = $post_id ? get_post_thumbnail_id($post_id) : get_post_thumbnail_id();
        echo wp_get_attachment_image($attachment_id, $size);
    } else {

        $attachment = $post_id ? get_field($field_name, $post_id) : get_field($field_name);    
        if ($attachment) {
            // Check if the field value is an array with an ID
            if (is_array($attachment) && isset($attachment['ID'])) {
                $attachment_id = $attachment['ID'];
            } elseif (is_numeric($attachment)) {
                // If the field value is already an ID, use it directly
                $attachment_id = $attachment;
            } else {
                // Return empty string if the field value is not recognized
                return '';
            }
            echo wp_get_attachment_image($attachment_id, $size);
            return true;
        } else {
            return '';
        }
    }   
}


function kj_sub_image($field_name, $size = 'full', $post_id = null, $default = null) {

    $attachment = $post_id ? get_sub_field($field_name, $post_id) : get_sub_field($field_name);    
    if ($attachment) {
        // Check if the field value is an array with an ID
        if (is_array($attachment) && isset($attachment['ID'])) {
            $attachment_id = $attachment['ID'];
        } elseif (is_numeric($attachment)) {
            // If the field value is already an ID, use it directly
            $attachment_id = $attachment;
        } else {
            // Return empty string if the field value is not recognized
            return '';
        }
        echo wp_get_attachment_image($attachment_id, $size);
        return true;
    }
    return false;
}

function kj_escape_html($text) {

    // Escape HTML while preserving allowed tags
    return wp_kses($text, array(
        'br' => array(),
        'p' => array(),
        'h1' => array(),
        'h2' => array(),
        'h3' => array(),
        'h4' => array(),
        'h5' => array(),
        'h6' => array(),
        'strong' => array(),
        'span' => array(),
        'ul' => array(),
        'ol' => array(),
        'li' => array(),
        'a' => array(
            'href' => array(),
            'title' => array(),
            'target' => array(),
            'rel' => array()
        ),
    ));
}

/**
 * Render a component with automatic ACF data detection
 * 
 * @param string $component Component name (without .php extension)
 * @param string|array $field_name ACF field name or array of button data (optional)
 * @param bool $is_subfield Whether the field is a subfield (default: false)
 * @param bool $is_option Whether the field is in options (default: false)
 * @return void
 */
function kj_component($component, $field_name = '', $is_subfield = false, $is_option = false) {
    global $field;
    global $subfield;
    global $option;
    global $button_data;

    // If field_name is an array, treat it as direct data (for buttons)
    if (is_array($field_name) && $component === 'button') {
        // Handle new group structure: if button data is nested in 'button' key, extract it
        if (isset($field_name['button']) && is_array($field_name['button'])) {
            $field_name = $field_name['button'];
        }
        kj_render_button($field_name);
        return;
    }

    // If field_name is empty, try to auto-detect from context
    if (empty($field_name)) {
        // For button component, try common field names
        if ($component === 'button') {
            $possible_fields = array('button', 'link', 'cta_button');
            foreach ($possible_fields as $possible_field) {
                if ($is_subfield) {
                    $data = get_sub_field($possible_field);
                } elseif ($is_option) {
                    $data = get_field($possible_field, 'option');
                } else {
                    $data = get_field($possible_field);
                }
                
                if (!empty($data) && is_array($data)) {
                    // Check if it's the new group structure (has 'button' key) or old structure
                    if (isset($data['button']) && is_array($data['button']) || isset($data['button_label']) || isset($data['label'])) {
                        $field_name = $possible_field;
                        break;
                    }
                }
            }
        }
    }

    $field = $field_name ?: null;
    $subfield = $is_subfield;
    $option = $is_option;
    
    // For button component, check if we have a repeater field
    if ($component === 'button' && $field_name) {
        if ($is_subfield) {
            $field_data = get_sub_field($field_name);
        } elseif ($is_option) {
            $field_data = get_field($field_name, 'option');
        } else {
            $field_data = get_field($field_name);
        }
        
        // If it's a repeater (array of arrays), render each button
        if (is_array($field_data) && !empty($field_data) && isset($field_data[0]) && is_array($field_data[0])) {
            foreach ($field_data as $button_item) {
                // Handle new group structure: if button data is nested in 'button' key, extract it
                if (isset($button_item['button']) && is_array($button_item['button'])) {
                    $button_item = $button_item['button'];
                }
                kj_render_button($button_item);
            }
            return;
        }
        
        // If it's a single button array, render it directly
        if (is_array($field_data) && !empty($field_data)) {
            // Handle new group structure: if button data is nested in 'button' key, extract it
            if (isset($field_data['button']) && is_array($field_data['button'])) {
                $field_data = $field_data['button'];
            }
            kj_render_button($field_data);
            return;
        }
    }
    
    // Include the component template
    get_template_part('templates/components/' . $component);
}

add_filter('acfe/flexible/render/template/layout=my_layout', 'my_acf_layout_template', 10, 4);
function my_acf_layout_template($file, $field, $layout, $is_preview){

    $file_name = str_replace('_', '-', $layout) . '.php';
    $file = get_stylesheet_directory() . '/templates/pagebuilder' . $file_name . '.php';

    return $file;

}

/**
 * Set ACF Extended Flexible Content Layout Thumbnails
 * Looks for thumbnail images in /components/<slug>/thumbnail.*
 */
add_filter('acfe/flexible/thumbnail', 'kj_set_layout_thumbnail', 10, 3);
function kj_set_layout_thumbnail($thumbnail, $field, $layout){

    // Derive slugs
    $slug_dash = 'thumb-' . str_replace('_', '-', $layout['name']);
    $slug_underscore = 'thumb-' . $layout['name'];

    // 1) New per-component location: /components/<slug>/thumbnail.*
    $component_slug = str_replace('_', '-', $layout['name']);
    $component_dir  = get_template_directory() . '/components/' . $component_slug;
    $component_uri  = get_template_directory_uri() . '/components/' . $component_slug;

    $candidates = array('jpg', 'jpeg', 'png', 'webp');
    foreach ($candidates as $ext) {
        $component_thumb_file = $component_dir . '/thumbnail.' . $ext;
        if (file_exists($component_thumb_file)) {
            return $component_uri . '/thumbnail.' . $ext;
        }
    }

    // 2) Fallback to legacy pagebuilder location: /templates/pagebuilder/<slug>/thumbnail.*
    $pb_dir = get_template_directory() . '/templates/pagebuilder/' . $component_slug;
    $pb_uri = get_template_directory_uri() . '/templates/pagebuilder/' . $component_slug;
    foreach ($candidates as $ext) {
        $pb_thumb_file = $pb_dir . '/thumbnail.' . $ext;
        if (file_exists($pb_thumb_file)) {
            return $pb_uri . '/thumbnail.' . $ext;
        }
    }

    return false;
}