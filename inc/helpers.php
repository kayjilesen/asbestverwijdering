<?php

defined( 'ABSPATH' ) || exit;

/**
 * Theme Support
 */

if (function_exists('add_theme_support'))
{
    // Add Menu Support
    add_theme_support('menus');

    // Add Title Tag Support
    add_theme_support( 'title-tag' );

   // Add Thumbnail Theme Support
   add_theme_support('post-thumbnails');
   add_image_size('icon-thumbnail', 60, 60, true);
   add_image_size('extra', 1024, '', true);
   add_image_size('large', 768, '', true);
   add_image_size('medium', 560, '', true);
   add_image_size('logo', 120, '', true);
   add_image_size('container', 1400,  788, true);
   add_image_size('fullscreen', 1920,  1024, true);
   add_image_size('ultra', 2560,  1440, true);
}

/**
 * Add Auto Version to CSS and JS to prevent caching
 */
function kj_auto_version($file) {
    if(strpos($file, '/') !== 0 || !file_exists($_SERVER['DOCUMENT_ROOT'] . $file))
      return $file;
  
    $mtime = filemtime($_SERVER['DOCUMENT_ROOT'] . $file);
    return preg_replace('{\\.([^./]+)$}', ".$mtime.\$1", $file);
}


/**
* Check if website is a Live website
*/
function kj_is_live_domain(){
    // If is Local (8888) or Subdomain / on kayilesen.dev
    if(!str_contains($_SERVER['HTTP_HOST'], ':8888') && !str_contains($_SERVER['HTTP_HOST'], '.local') && (substr_count($_SERVER['HTTP_HOST'], '.') < 2 || !str_contains($_SERVER['HTTP_HOST'], 'kayjilesen.dev'))) return true;
    return false;
}

add_filter( 'wp_lazy_loading_enabled', '__return_false' );

/**
* Update all Plugins and Core automatically when not Live
*/
if(!kj_is_live_domain()){
    add_filter( 'auto_update_plugin', '__return_true' );	
    add_filter( 'auto_update_core', '__return_true' );
    add_filter( 'allow_dev_auto_core_updates', '__return_true' );
    add_filter( 'allow_minor_auto_core_updates', '__return_true' );
    add_filter( 'allow_major_auto_core_updates', '__return_true' );
    add_filter( 'auto_update_theme', '__return_true' );	
    add_filter( 'auto_update_translation', '__return_true' );
}

/**
* No Core update Emails
*/
add_filter( 'auto_core_update_send_email', '__return_false' );

/**
 * Recursively extract text content from ACF field values
 * 
 * @param mixed $value Field value
 * @return string Extracted text content
 */
function kj_extract_text_from_acf_value( $value ) {
    $text = '';
    
    if ( is_string( $value ) ) {
        $text = $value;
    } elseif ( is_array( $value ) ) {
        foreach ( $value as $item ) {
            if ( is_string( $item ) ) {
                $text .= ' ' . $item;
            } elseif ( is_array( $item ) ) {
                // Recursively process nested arrays
                $text .= ' ' . kj_extract_text_from_acf_value( $item );
            }
        }
    }
    
    return $text;
}

/**
 * Calculate reading time for a post based on content and ACF fields
 * 
 * @param int|null $post_id Post ID (defaults to current post)
 * @return int Reading time in minutes
 */
function kj_calculate_reading_time( $post_id = null ) {
    if ( ! $post_id ) {
        $post_id = get_the_ID();
    }
    
    if ( ! $post_id ) {
        return 0;
    }
    
    $content = '';
    
    // Get post content
    $post = get_post( $post_id );
    if ( $post ) {
        $content .= $post->post_content;
        $content .= ' ' . $post->post_title;
    }
    
    // Helper function to extract text from ACF fields
    $extract_text_from_fields = function( $fields ) use ( &$extract_text_from_fields ) {
        $text = '';
        
        if ( ! is_array( $fields ) ) {
            return $text;
        }
        
        foreach ( $fields as $field_key => $field_value ) {
            // Skip field keys that start with 'field_'
            if ( preg_match( '/^field_/', $field_key ) ) {
                continue;
            }
            
            // Skip image fields (they return arrays with 'ID', 'url', etc.)
            if ( is_array( $field_value ) && isset( $field_value['ID'] ) && isset( $field_value['url'] ) ) {
                continue;
            }
            
            // Skip URL values
            if ( is_string( $field_value ) && filter_var( $field_value, FILTER_VALIDATE_URL ) ) {
                continue;
            }
            
            // Extract text from the value
            $extracted = kj_extract_text_from_acf_value( $field_value );
            if ( ! empty( $extracted ) ) {
                $text .= ' ' . $extracted;
            }
        }
        
        return $text;
    };
    
    // Get ACF pagebuilder content from options (for kennisbank articles)
    if ( have_rows( 'pagebuilder', 'option' ) ) {
        while ( have_rows( 'pagebuilder', 'option' ) ) : the_row();
            // Get all sub fields for this layout
            $sub_fields = get_fields();
            if ( $sub_fields ) {
                $content .= $extract_text_from_fields( $sub_fields );
            }
        endwhile;
        reset_rows();
    }
    
    // Also check regular pagebuilder field on the post itself
    if ( have_rows( 'pagebuilder', $post_id ) ) {
        while ( have_rows( 'pagebuilder', $post_id ) ) : the_row();
            // Get all sub fields for this layout
            $sub_fields = get_fields();
            if ( $sub_fields ) {
                $content .= $extract_text_from_fields( $sub_fields );
            }
        endwhile;
        reset_rows();
    }
    
    // Strip HTML tags and decode entities
    $content = wp_strip_all_tags( $content );
    $content = html_entity_decode( $content, ENT_QUOTES, 'UTF-8' );
    
    // Remove extra whitespace
    $content = preg_replace( '/\s+/', ' ', $content );
    $content = trim( $content );
    
    // Count words (split by whitespace)
    $word_count = str_word_count( $content );
    
    // Average reading speed: 200-250 words per minute (using 225 as average)
    $reading_speed = 225;
    $reading_time = ceil( $word_count / $reading_speed );
    
    // Minimum 1 minute
    return max( 1, $reading_time );
}

/**
 * Get excerpt from pagebuilder content
 * 
 * Loops through pagebuilder blocks and extracts text from the first text-containing block
 * 
 * @param int|null $post_id Post ID (defaults to current post)
 * @param int $length Maximum length of excerpt in words (default: 20)
 * @return string Excerpt text
 */
function kj_get_pagebuilder_excerpt( $post_id = null, $length = 20 ) {
    if ( ! $post_id ) {
        $post_id = get_the_ID();
    }
    
    if ( ! $post_id ) {
        return '';
    }
    
    // Blocks that contain text content (field name)
    $text_blocks = array(
        'text' => 'text',
        'text-image' => 'text',
        'text-services' => 'text',
        'kennisbank' => 'text',
        'call-to-action' => 'text',
        'offerte' => 'text',
        'content-usps' => 'text',
    );
    
    // Check if pagebuilder exists
    if ( ! have_rows( 'pagebuilder', $post_id ) ) {
        return '';
    }
    
    // Loop through pagebuilder blocks
    while ( have_rows( 'pagebuilder', $post_id ) ) : the_row();
        $layout = get_row_layout();
        
        // Check if this block type has text content
        if ( isset( $text_blocks[ $layout ] ) ) {
            $text_field = $text_blocks[ $layout ];
            $text_content = get_sub_field( $text_field );
            
            if ( ! empty( $text_content ) ) {
                // Strip HTML tags
                $text = wp_strip_all_tags( $text_content );
                // Decode HTML entities
                $text = html_entity_decode( $text, ENT_QUOTES, 'UTF-8' );
                // Remove extra whitespace
                $text = preg_replace( '/\s+/', ' ', $text );
                $text = trim( $text );
                
                // Generate excerpt with word limit
                $words = explode( ' ', $text );
                if ( count( $words ) > $length ) {
                    $words = array_slice( $words, 0, $length );
                    $text = implode( ' ', $words ) . '...';
                }
                
                // Reset rows before returning
                reset_rows();
                return $text;
            }
        }
    endwhile;
    
    // Reset rows
    reset_rows();
    
    return '';
}