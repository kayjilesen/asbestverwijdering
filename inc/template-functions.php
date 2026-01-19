<?php
  
defined( 'ABSPATH' ) || exit;

/**
 * Template Functions
*/

function kj_pagination($query = null) {
    global $wp_query;

    $pagination = '';
    $total_pages = $query ? $query->max_num_pages : $wp_query->max_num_pages;

    if ($total_pages > 1) {
        $current_page = max(1, get_query_var('paged'));

        $pagination .= '<div class="pagination">';
        $pagination .= paginate_links(array(
            'base' => get_pagenum_link(1) . '%_%',
            'format' => 'page/%#%',
            'current' => $current_page,
            'total' => $total_pages,
            'prev_text' => __('&laquo; Previous'),
            'next_text' => __('Next &raquo;'),
        ));
        $pagination .= '</div>';
    }

    return $pagination;
}

// Custom Excerpt Length
function kj_excerpt_length( $length ) {
	return 20;
}
add_filter( 'excerpt_length', 'kj_excerpt_length', 999 );

// Remove the [...] from the excerpt
function kj_excerpt_more( $more ) {
    return '' ;
}
add_filter('excerpt_more', 'kj_excerpt_more');

function kj_get_vimeo_id($url){
    $parsedUrl = parse_url($url, PHP_URL_PATH);

    // Extract the last number from the path using regex
    if (preg_match('/(\d+)$/', $parsedUrl, $matches)) {
        return $matches[1];
    }

    // Return null or an error message if no number is found
    return null;
}

// Function to get the second next post
function kj_get_second_next_post() {
    global $post;
    $args = array(
        'numberposts' => 1,
        'offset' => 1,
        'orderby' => 'date',
        'order' => 'ASC',
        'post_type' => $post->post_type,
        'post_status' => 'publish',
        'exclude' => array($post->ID)
    );

    $next_posts = get_posts($args);
    return !empty($next_posts) ? $next_posts[0] : null;
}

// Function to get the second previous post
function kj_get_second_previous_post() {
    global $post;
    $args = array(
        'numberposts' => 1,
        'offset' => 1,
        'orderby' => 'date',
        'order' => 'DESC',
        'post_type' => $post->post_type,
        'post_status' => 'publish',
        'exclude' => array($post->ID)
    );

    $prev_posts = get_posts($args);
    return !empty($prev_posts) ? $prev_posts[0] : null;
}

function kj_platform_logo($platform) {
    return 'test';
}

function kj_get_stars($rating = ''){

    // Based on 5 Stars
	$averageRating = $rating / 1;

	if($averageRating != 0){
		for($i = 0; $i < floor($averageRating + 0.25); $i++){
            echo '<svg xmlns="http://www.w3.org/2000/svg" class="star-full size-4 mx-0.25" viewBox="0 0 32 32"><g fill="inheritColor"><polygon points="31.995 12 19.734 12 16 .07 12.266 12 .005 12 9.774 19.341 5.921 31.201 16 23.878 26.079 31.201 22.226 19.341 31.995 12" stroke-width="0" fill="inheritColor"></polygon></g></svg>';
			//echo '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="inheritColor" class="w-4 h-4 fill-white mx-0.5"><path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z" clip-rule="evenodd" /></svg>';
		}
		if($averageRating < 4.75 && round(($averageRating - floor($averageRating)) * 2) == 1){
            echo '<svg class="star-half size-4 mx-0.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 29 28.15"><g>
              <polygon fill="none" stroke-color="inheritColor" class="" points="14.5 1.67 17.5 11.26 27.5 11.26 19.55 17.23 22.67 26.84 14.5 20.9 6.32 26.84 9.44 17.23 1.5 11.26 11.5 11.26 14.5 1.67"/>
              <polygon fill="inheritColor" stroke-width="0" points="14.5 1.67 14.5 20.9 6.32 26.84 9.44 17.23 1.5 11.26 11.5 11.26 14.5 1.67"/>
            </g></svg>';
		}
		for($i = 0; $i < (5 - ceil($averageRating)); $i++){
			//echo '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="inheritColor" class="w-4 h-4 fill-white mx-0.5"><path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" /></svg>';
            echo '<svg xmlns="http://www.w3.org/2000/svg" class="size-4" viewBox="0 0 32 32"><g fill="inheritColor" stroke-linecap="round" stroke-linejoin="round"><polygon points="16 3.417 19 13 29 13 21.054 18.971 24.177 28.583 16 22.642 7.823 28.583 10.946 18.971 3 13 13 13 16 3.417" fill="none" stroke="inheritColor" stroke-width="2"></polygon></g></svg>';
		}
	}
}

function kj_icon($icon) {
    switch($icon){
        case 'warning' :
            return '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"><g fill="inheritColor"><path d="m10,18c4.411,0,8-3.589,8-8S14.411,2,10,2,2,5.589,2,10s3.589,8,8,8Zm-1-12c0-.552.447-1,1-1s1,.448,1,1v4.5c0,.552-.447,1-1,1s-1-.448-1-1v-4.5Zm1,6.5c.689,0,1.25.561,1.25,1.25s-.561,1.25-1.25,1.25-1.25-.561-1.25-1.25.561-1.25,1.25-1.25Z" stroke-width="0" fill="inheritColor"></path></g></svg>';
            break;
        case 'new' :
            return '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"><g fill="inheritColor"><polygon points="6.5 10 7.3077 12.6923 10 13.5 7.3077 14.3077 6.5 17 5.6923 14.3077 3 13.5 5.6923 12.6923 6.5 10" stroke="inheritColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1" fill="inheritColor"></polygon><polygon points="13.5 3 14.3077 5.6923 17 6.5 14.3077 7.3077 13.5 10 12.6923 7.3077 10 6.5 12.6923 5.6923 13.5 3" stroke="inheritColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1" fill="inheritColor"></polygon><path class="opacity-50" d="m6.6526,3.978l-1.2005-.4533-.4506-1.2087c-.1563-.4214-.8468-.4214-1.0031,0l-.4506,1.2087-1.2005.4533c-.2086.079-.3474.2802-.3474.505s.1388.4259.3474.505l1.2005.4533.4506,1.2087c.0781.2107.2783.3501.5015.3501s.4234-.1394.5015-.3501l.4506-1.2087,1.2005-.4533c.2086-.079.3474-.2802.3474-.505s-.1388-.4259-.3474-.505Z" fill="inheritColor" stroke-width="0"></path><path d="m17.6526,14.978l-1.2005-.4533-.4506-1.2087c-.1563-.4214-.8468-.4214-1.0031,0l-.4506,1.2087-1.2005.4533c-.2086.079-.3474.2802-.3474.505s.1388.4259.3474.505l1.2005.4533.4506,1.2087c.0781.2107.2783.3501.5015.3501s.4234-.1394.5015-.3501l.4506-1.2087,1.2005-.4533c.2086-.079.3474-.2802.3474-.505s-.1388-.4259-.3474-.505Z" fill="inheritColor" class="opacity-50" stroke-width="0"></path></g></svg>';
    }
}


/**
 * Render a button with direct parameters
 * 
 * @param string $label Button label text
 * @param string|int|WP_Post $link Button link (URL, page ID, or WP_Post object)
 * @param string $type Link type: 'internal', 'external', or 'section' (default: 'internal')
 * @param string $style Button style (default: 'primary yellow')
 * @return void
 */
function kj_button($label = '', $link = '', $type = 'internal', $style = 'primary yellow') {

    if (empty($label)) {
        return;
    }
    
    // Build button data array with new field names
    $button_data = array(
        'button_label' => $label,
        'button_style' => $style,
        'button_link_type' => $type,
    );
    
    // Set link based on type using new field names
    if ($type === 'internal' || $type === 'intern') {
        $button_data['button_link_intern'] = $link;
    } elseif ($type === 'external' || $type === 'extern') {
        $button_data['button_link_extern'] = $link;
    } elseif ($type === 'section') {
        $button_data['button_section_id'] = $link;
    }
    
    kj_render_button($button_data);
}

/**
 * Render buttons from a repeater field
 * Simple wrapper function that uses the button.php component
 * 
 * @param string $field_name The ACF repeater field name (default: 'buttons')
 * @param bool $is_option Whether the field is in options (default: false)
 * @param string $wrapper_class Additional CSS classes for wrapper (default: 'flex flex-row gap-4')
 */
function kj_render_buttons($field_name = 'buttons', $is_option = false, $wrapper_class = 'flex flex-row gap-4') {
    // Determine the context for getting the field
    if ($is_option) {
        $buttons = get_field($field_name, 'option');
    } else {
        $buttons = get_sub_field($field_name);
    }
    
    if (empty($buttons)) {
        return;
    }
    
    echo '<div class="' . esc_attr($wrapper_class) . '">';
    
    foreach($buttons as $button) {
        // Handle new group structure: if button data is nested in 'button' key, extract it
        if (isset($button['button']) && is_array($button['button'])) {
            $button = $button['button'];
        }
        kj_render_button($button);
    }
    
    echo '</div>';
}

/**
 * Breadcrumb Function
 *
 * @param array $args Optional arguments for customization
 * @return string Breadcrumb HTML
 */
function kj_breadcrumbs($args = array()) {
    $defaults = array(
        'separator' => '>',
        'home_text' => __('Home', 'kj'),
        'show_home' => true,
    );

    $args = wp_parse_args($args, $defaults);

    $breadcrumbs = array();

    // Home link
    if ($args['show_home']) {
        $breadcrumbs[] = '<a href="' . esc_url(home_url('/')) . '" class="breadcrumb-link hover:underline">' . esc_html($args['home_text']) . '</a>';
    }

    // Archive page or blog home
    if (is_archive() || is_home()) {
        $post_type = get_post_type();

        // Blog home (kennisbank)
        if (is_home() && !is_front_page()) {
            $breadcrumbs[] = '<span class="breadcrumb-current font-normal">' . esc_html(__('Kennisbank', 'kj')) . '</span>';
        }
        // Add parent taxonomy links if available
        elseif (is_tax()) {
            $term = get_queried_object();

            // Add post type archive link
            if ($post_type === 'project') {
                $archive_url = get_post_type_archive_link('project');
                if ($archive_url) {
                    $breadcrumbs[] = '<a href="' . esc_url($archive_url) . '" class="breadcrumb-link hover:underline">' . esc_html(__('Projecten', 'kj')) . '</a>';
                }
            }

            // Add current term
            $breadcrumbs[] = '<span class="breadcrumb-current font-normal">' . esc_html($term->name) . '</span>';
        } else {
            // Regular archive
            if ($post_type === 'project') {
                $breadcrumbs[] = '<span class="breadcrumb-current font-normal">' . esc_html(__('Projecten', 'kj')) . '</span>';
            } elseif ($post_type === 'vacature') {
                $breadcrumbs[] = '<span class="breadcrumb-current font-normal">' . esc_html(__('Vacatures', 'kj')) . '</span>';
            } elseif ($post_type === 'post' || is_category()) {
                $breadcrumbs[] = '<span class="breadcrumb-current font-normal">' . esc_html(__('Kennisbank', 'kj')) . '</span>';
            } else {
                $breadcrumbs[] = '<span class="breadcrumb-current font-normal">' . esc_html(get_the_archive_title()) . '</span>';
            }
        }
    }

    // Single post/page
    if (is_single() || is_page()) {
        $post_type = get_post_type();

        // Add archive link for custom post types
        if ($post_type === 'project') {
            $archive_url = get_post_type_archive_link('project');
            if ($archive_url) {
                $breadcrumbs[] = '<a href="' . esc_url($archive_url) . '" class="breadcrumb-link hover:underline">' . esc_html(__('Projecten', 'kj')) . '</a>';
            }

            // Add taxonomy terms if available
            $dienst_terms = get_the_terms(get_the_ID(), 'project_dienst');
            if ($dienst_terms && !is_wp_error($dienst_terms)) {
                $first_dienst = reset($dienst_terms);
                // Link to project archive with filter instead of term archive
                $filter_url = add_query_arg(array(
                    'dienst' => $first_dienst->slug,
                ), $archive_url);
                if ($filter_url) {
                    $breadcrumbs[] = '<a href="' . esc_url($filter_url) . '" class="breadcrumb-link hover:underline">' . esc_html($first_dienst->name) . '</a>';
                }
            }
        } elseif ($post_type === 'vacature') {
            $archive_url = get_post_type_archive_link('vacature');
            if ($archive_url) {
                $breadcrumbs[] = '<a href="' . esc_url($archive_url) . '" class="breadcrumb-link hover:underline">' . esc_html(__('Vacatures', 'kj')) . '</a>';
            }
        } elseif ($post_type === 'post') {
            // Add kennisbank archive link for blog posts
            $archive_url = get_post_type_archive_link('post') ?: home_url('/');
            if ($archive_url) {
                $breadcrumbs[] = '<a href="' . esc_url($archive_url) . '" class="breadcrumb-link hover:underline">' . esc_html(__('Kennisbank', 'kj')) . '</a>';
            }
        }

        // Add current post/page
        $breadcrumbs[] = '<span class="breadcrumb-current font-normal">' . esc_html(get_the_title()) . '</span>';
    }

    // 404
    if (is_404()) {
        $breadcrumbs[] = '<span class="breadcrumb-current font-normal">' . esc_html(__('404', 'kj')) . '</span>';
    }

    if (empty($breadcrumbs)) {
        return '';
    }

    $output = '<nav class="breadcrumbs" aria-label="' . esc_attr__('Breadcrumb', 'kj') . '">';
    $output .= '<ol class="breadcrumbs-list flex flex-wrap items-center gap-3 text-base font-medium">';

    foreach ($breadcrumbs as $index => $crumb) {
        $output .= '<li class="breadcrumb-item">' . $crumb . '</li>';
        if ($index < count($breadcrumbs) - 1) {
            $output .= '<li class="breadcrumb-separator text-grey-dark" aria-hidden="true">' . esc_html($args['separator']) . '</li>';
        }
    }

    $output .= '</ol>';
    $output .= '</nav>';

    return $output;
}

