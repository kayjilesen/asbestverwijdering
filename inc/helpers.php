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