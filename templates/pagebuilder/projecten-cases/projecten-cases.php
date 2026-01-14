<?php
/**
 * Projecten en Cases Block
 * 
 * @package asbestverwijdering
 * @version 1.0.0
 * @author Kay Jilesen
 */

defined( 'ABSPATH' ) || exit;

$use_default = (bool) get_sub_field( 'mode' );

if ( $use_default ) {
    $title = get_field( 'projecten_cases_default_title', 'option' );
    $subtitle = get_field( 'projecten_cases_default_subtitle', 'option' );
} else {
    $title = get_sub_field( 'title' );
    $subtitle = get_sub_field( 'subtitle' );
}

$source = get_sub_field( 'source' ) ?: 'manual';

// Get projects based on source
$projects = array();

if ( $source === 'auto' ) {
    // Auto mode: get projects from current context or query
    $post_type = 'project';
    $posts_per_page = get_sub_field( 'posts_per_page' ) ?: 9;
    
    // Check if we're on an archive page
    if ( is_archive() || is_category() || is_tag() || is_tax() ) {
        global $wp_query;
        $projects = $wp_query->posts;
    } else {
        // Get recent posts of the specified post type
        $query_args = array(
            'post_type'      => $post_type,
            'posts_per_page' => $posts_per_page,
            'post_status'    => 'publish',
            'orderby'        => 'date',
            'order'          => 'DESC',
        );
        
        $query = new WP_Query( $query_args );
        $projects = $query->posts;
        wp_reset_postdata();
    }
} else {
    // Manual mode: get selected projects
    $selected_projects = get_sub_field( 'projects' );
    if ( $selected_projects && is_array( $selected_projects ) && ! empty( $selected_projects ) ) {
        $projects = $selected_projects;
    }
}

// Fallback: if no projects found and we're not on archive/tax, get default projects
if ( empty( $projects ) && ! is_archive() && ! is_category() && ! is_tag() && ! is_tax() ) {
    $post_type = 'project';
    $posts_per_page = get_sub_field( 'posts_per_page' ) ?: 9;
    
    $query_args = array(
        'post_type'      => $post_type,
        'posts_per_page' => $posts_per_page,
        'post_status'    => 'publish',
        'orderby'        => 'date',
        'order'          => 'DESC',
    );
    
    $query = new WP_Query( $query_args );
    $projects = $query->posts;
    wp_reset_postdata();
}

// Don't show section if no projects
if ( empty( $projects ) ) {
    return;
}

// Unique ID for this swiper instance
$swiper_id = 'projecten-cases-' . uniqid();

// Get padding options - ACF true_false returns empty string/0 when unchecked, 1 when checked
$padding_top_value = get_sub_field( 'padding_top' );
$padding_bottom_value = get_sub_field( 'padding_bottom' );

// If field hasn't been set (null), default to true. Otherwise check if value is truthy (1, true) or falsy (0, false, empty string)
$padding_top = ( $padding_top_value === null ) ? true : ! empty( $padding_top_value );
$padding_bottom = ( $padding_bottom_value === null ) ? true : ! empty( $padding_bottom_value );

// Set padding classes based on options
$padding_classes = array();
if ( $padding_top ) {
    $padding_classes[] = 'pt-20 lg:pt-[120px]';
}
if ( $padding_bottom ) {
    $padding_classes[] = 'pb-20 lg:pb-[120px]';
}
$padding_class = ! empty( $padding_classes ) ? implode( ' ', $padding_classes ) : '';
?>

<section class="projecten-cases-block <?php echo esc_attr( $padding_class ); ?> bg-white">
    <div class="projecten-cases-block__container container">
        
        <?php if ( $title ) : ?>
            <div class="projecten-cases-block__header mb-16 md:mb-20 text-center relative">
                
                <?php if ( $title ) : ?>
                    <h2 class="projecten-cases-block__title text-3xl md:text-4xl lg:text-5xl font-bold font-title uppercase relative z-[1]"><?php echo esc_html( $title ); ?></h2>
                    <span class="text-[15vw] sm:text-[12.5vw] md:text-[6.6rem] lg:text-[10rem] 2xl:text-[15rem] w-full font-title uppercase absolute left-1/2 -translate-x-1/2 -bottom-8 text-yellow-light !leading-[1] z-[0]"><?php _e('Projecten', 'kj'); ?></span>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        
        <div class="projecten-cases-block__swiper-wrapper">
            <div class="swiper js-projecten-cases-swiper" id="<?php echo esc_attr( $swiper_id ); ?>">
                <div class="swiper-wrapper">
                    <?php foreach ( $projects as $project ) : ?>
                        <div class="swiper-slide">
                            <?php
                            // Load the reusable project card component
                            get_template_part( 'templates/components/project-card', null, array( 'project' => $project ) );
                            ?>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <!-- Scrollbar -->
                <div class="swiper-scrollbar mt-6"></div>
                
                <!-- Navigation -->
                <div class="swiper-navigation-wrapper flex items-center mt-4">
                    <div class="swiper-button-prev">
                        <svg viewBox="0 0 16 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10.4825 0.398001C10.7243 0.15647 11.1165 0.156324 11.3582 0.398001L15.2989 4.33973C15.5407 4.58159 15.5407 4.97364 15.2989 5.2155L11.3582 9.15723C11.1165 9.39891 10.7243 9.39876 10.4825 9.15723C10.2407 8.91537 10.2407 8.52252 10.4825 8.28066L13.366 5.39694L0.836077 5.39694C0.494058 5.39694 0.216796 5.11966 0.216796 4.77761C0.216797 4.43557 0.494058 4.15829 0.836077 4.15829L13.366 4.15829L10.4825 1.27457C10.2407 1.03271 10.2407 0.639861 10.4825 0.398001Z" fill="currentColor" stroke="currentColor" stroke-width="0.43372"/>
                        </svg>
                    </div>
                    <div class="swiper-pagination-custom"></div>
                    <div class="swiper-button-next">
                        <svg viewBox="0 0 16 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10.4825 0.398001C10.7243 0.15647 11.1165 0.156324 11.3582 0.398001L15.2989 4.33973C15.5407 4.58159 15.5407 4.97364 15.2989 5.2155L11.3582 9.15723C11.1165 9.39891 10.7243 9.39876 10.4825 9.15723C10.2407 8.91537 10.2407 8.52252 10.4825 8.28066L13.366 5.39694L0.836077 5.39694C0.494058 5.39694 0.216796 5.11966 0.216796 4.77761C0.216797 4.43557 0.494058 4.15829 0.836077 4.15829L13.366 4.15829L10.4825 1.27457C10.2407 1.03271 10.2407 0.639861 10.4825 0.398001Z" fill="currentColor" stroke="currentColor" stroke-width="0.43372"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

