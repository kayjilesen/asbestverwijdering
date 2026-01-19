<?php
/**
 * Kennisbank Block
 * 
 * @package asbestverwijdering
 * @version 1.0.0
 * @author Kay Jilesen
 */

defined( 'ABSPATH' ) || exit;

$use_default = (bool) get_sub_field( 'mode' );

if ( $use_default ) {
    $title = get_field( 'kennisbank_default_title', 'option' );
    $subtitle = get_field( 'kennisbank_default_subtitle', 'option' );
    $text = get_field( 'kennisbank_default_text', 'option' );
    $buttons = get_field( 'kennisbank_default_buttons', 'option' );
} else {
    $title = get_sub_field( 'title' );
    $subtitle = get_sub_field( 'subtitle' );
    $text = get_sub_field( 'text' );
    $buttons = get_sub_field( 'buttons' );
}

$source = get_sub_field( 'source' ) ?: 'manual';
$featured_post = get_sub_field( 'featured_post' );

// Get current post ID to exclude it from queries (if on single post page)
$current_post_id = is_singular( 'post' ) ? get_queried_object_id() : 0;

// Get posts based on source
$posts = array();

if ( $source === 'auto' ) {
    // Auto mode: get posts from current context or query
    $post_type = 'post';
    $posts_per_page = get_sub_field( 'posts_per_page' ) ?: 4;
    
    // Check if we're on an archive page
    if ( is_archive() || is_category() || is_tag() || is_tax() ) {
        global $wp_query;
        $posts = $wp_query->posts;
    } else {
        // Get recent posts of the specified post type
        $exclude_ids = array();
        
        // Exclude current post if on single post page
        if ( $current_post_id ) {
            $exclude_ids[] = $current_post_id;
        }
        
        // Exclude featured post if set
        if ( $featured_post ) {
            $exclude_ids[] = $featured_post->ID;
        }
        
        $query_args = array(
            'post_type'      => $post_type,
            'posts_per_page' => $posts_per_page,
            'post_status'    => 'publish',
            'orderby'        => 'date',
            'order'          => 'DESC',
        );
        
        // Add exclusion list if we have IDs to exclude
        if ( ! empty( $exclude_ids ) ) {
            $query_args['post__not_in'] = $exclude_ids;
        }
        
        $query = new WP_Query( $query_args );
        $posts = $query->posts;
        wp_reset_postdata();
    }
} else {
    // Manual mode: get selected posts
    $selected_posts = get_sub_field( 'posts' );
    if ( $selected_posts && is_array( $selected_posts ) && ! empty( $selected_posts ) ) {
        $posts = $selected_posts;
        
        // Exclude current post if on single post page
        if ( $current_post_id ) {
            $posts = array_filter( $posts, function( $post ) use ( $current_post_id ) {
                $post_id = is_object( $post ) ? $post->ID : $post;
                return $post_id !== $current_post_id;
            } );
        }
    }
}

// If featured post is set, ensure it's not in the regular posts array
// Also exclude current post if on single post page
if ( $featured_post || $current_post_id ) {
    $posts = array_filter( $posts, function( $post ) use ( $featured_post, $current_post_id ) {
        $post_id = is_object( $post ) ? $post->ID : $post;
        
        // Exclude featured post
        if ( $featured_post && $post_id === $featured_post->ID ) {
            return false;
        }
        
        // Exclude current post
        if ( $current_post_id && $post_id === $current_post_id ) {
            return false;
        }
        
        return true;
    });
}

// Fallback: if no posts found and we're not on archive/tax, get default posts
if ( empty( $posts ) && ! is_archive() && ! is_category() && ! is_tag() && ! is_tax() ) {
    $post_type = 'post';
    $posts_per_page = get_sub_field( 'posts_per_page' ) ?: 4;
    
    $exclude_ids = array();
    
    // Exclude current post if on single post page
    if ( $current_post_id ) {
        $exclude_ids[] = $current_post_id;
    }
    
    // Exclude featured post if set
    if ( $featured_post ) {
        $exclude_ids[] = $featured_post->ID;
    }
    
    $query_args = array(
        'post_type'      => $post_type,
        'posts_per_page' => $posts_per_page,
        'post_status'    => 'publish',
        'orderby'        => 'date',
        'order'          => 'DESC',
    );
    
    // Add exclusion list if we have IDs to exclude
    if ( ! empty( $exclude_ids ) ) {
        $query_args['post__not_in'] = $exclude_ids;
    }
    
    $query = new WP_Query( $query_args );
    $posts = $query->posts;
    wp_reset_postdata();
}

// Exclude current post from featured post if it's the current post
if ( $featured_post && $current_post_id && $featured_post->ID === $current_post_id ) {
    $featured_post = null;
}

// Don't show section if no posts and no featured post
if ( empty( $posts ) && ! $featured_post ) {
    return;
}

// Unique ID for this swiper instance
$swiper_id = 'kennisbank-' . uniqid();

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

<section class="kennisbank-block <?php echo esc_attr( $padding_class ); ?> bg-beige">
    <div class="kennisbank-block__container container">
        
        <?php if ( $title ) : ?>
            <div class="kennisbank-block__header mb-16 md:mb-20 text-center relative">
                
                <?php if ( $title ) : ?>
                    <h2 class="kennisbank-block__title text-3xl md:text-4xl lg:text-5xl font-bold font-title uppercase relative z-[1]"><?php echo esc_html( $subtitle ); ?></h2>
                    <span class="text-[15vw] sm:text-[12.5vw] md:text-[6.6rem] lg:text-[10rem] 2xl:text-[15rem] w-full font-title uppercase absolute left-1/2 -translate-x-1/2 -bottom-8 text-yellow-light !leading-[1] z-[0]"><?php echo esc_html( $title ); ?></span>
                <?php endif; ?>
            </div>
            
            <?php if ( $text ) : ?>
                <div class="kennisbank-block__text mb-16 md:mb-20 text-center max-w-4xl mx-auto">
                    <?php echo wp_kses_post( $text ); ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>
        
        <div class="kennisbank-block__content">
            <!-- Mobile Swiper -->
            <div class="kennisbank-block__swiper-wrapper lg:hidden">
                <div class="swiper js-kennisbank-swiper" id="<?php echo esc_attr( $swiper_id ); ?>">
                    <div class="swiper-wrapper">
                        <?php if ( $featured_post ) : ?>
                            <div class="swiper-slide">
                                <?php
                                get_template_part( 'templates/components/post-card', null, array( 'post' => $featured_post, 'is_featured' => true ) );
                                ?>
                            </div>
                        <?php endif; ?>
                        <?php foreach ( $posts as $post ) : ?>
                            <div class="swiper-slide">
                                <?php
                                get_template_part( 'templates/components/post-card', null, array( 'post' => $post, 'is_featured' => false ) );
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
            
            <!-- Desktop Grid -->
            <div class="kennisbank-block__grid hidden lg:grid lg:grid-cols-12 lg:gap-6">
                <?php if ( $featured_post ) : ?>
                    <div class="lg:col-span-12">
                        <?php
                        get_template_part( 'templates/components/post-card', null, array( 'post' => $featured_post, 'is_featured' => true ) );
                        ?>
                    </div>
                <?php endif; ?>
                <?php foreach ( $posts as $post ) : ?>
                    <div class="lg:col-span-4">
                        <?php
                        get_template_part( 'templates/components/post-card', null, array( 'post' => $post, 'is_featured' => false ) );
                        ?>
                    </div>
                <?php endforeach; ?>
                <?php wp_reset_postdata(); ?>
            </div>
        </div>
        
        <?php if ( ! empty( $buttons ) ) : ?>
            <div class="kennisbank-block__buttons mt-12 lg:mt-16 flex flex-row gap-4 justify-center">
                <?php foreach ( $buttons as $button ) : ?>
                    <?php
                    // Handle new group structure: if button data is nested in 'button' key, extract it
                    $button_data = isset( $button['button'] ) && is_array( $button['button'] ) ? $button['button'] : $button;
                    kj_render_button( $button_data );
                    ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
