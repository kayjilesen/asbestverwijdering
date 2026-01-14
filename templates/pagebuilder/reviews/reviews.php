<?php
/**
 * Reviews Block
 * 
 * @package asbestverwijdering
 * @version 1.0.0
 * @author Kay Jilesen
 */

defined( 'ABSPATH' ) || exit;

$use_default = (bool) get_sub_field( 'mode' );

if ( $use_default ) {
    $subtitle = get_field( 'reviews_default_subtitle', 'option' );
    $title = get_field( 'reviews_default_title', 'option' );
    $buttons = get_field( 'reviews_default_buttons', 'option' );
} else {
    $subtitle = get_sub_field( 'subtitle' );
    $title = get_sub_field( 'title' );
    $buttons = get_sub_field( 'buttons' );
}

// Normalize buttons (repeater of clone group_button_fields)
$button_list = array();
if ( is_array( $buttons ) ) {
    foreach ( $buttons as $btn ) {
        if ( isset( $btn['button'] ) && is_array( $btn['button'] ) && ! empty( $btn['button']['button_label'] ) ) {
            $button_list[] = $btn['button'];
        } elseif ( isset( $btn['button_label'] ) && ! empty( $btn['button_label'] ) ) {
            $button_list[] = $btn;
        }
    }
}

$reviews_posts = get_sub_field( 'reviews' );
$text_position = get_sub_field( 'text_position' ) ?: 'left';

// If no reviews selected, automatically fetch latest reviews
if ( empty( $reviews_posts ) ) {
    $reviews_query = new WP_Query( array(
        'post_type'      => 'review',
        'posts_per_page' => 6,
        'orderby'        => 'date',
        'order'          => 'DESC',
    ) );
    
    if ( $reviews_query->have_posts() ) {
        $reviews_posts = $reviews_query->posts;
    }
    wp_reset_postdata();
}

// Still no reviews? Don't show the section
if ( empty( $reviews_posts ) ) {
    return;
}

// Ensure $reviews_posts is an array
if ( ! is_array( $reviews_posts ) ) {
    $reviews_posts = array( $reviews_posts );
}

// Check if there's only 1 review
$is_single_review = count( $reviews_posts ) === 1;

// Determine layout based on text position
// For grid, we'll use grid-column order instead of flex-row-reverse
$grid_order_class = ( $text_position === 'right' ) ? 'lg:order-2' : 'lg:order-1';
$swiper_order_class = ( $text_position === 'right' ) ? 'lg:order-1' : 'lg:order-2';
// Text content always left-aligned, only wrapper position changes
$position_class = 'text-left';

// Get background color
$background_color = get_sub_field( 'background_color' ) ?: 'grey-light';
$bg_class = 'bg-' . $background_color;

// Unique ID for this swiper instance
$swiper_id = 'reviews-' . uniqid();
?>

<section class="reviews-block section-pd <?php echo esc_attr( $bg_class ); ?> <?php echo esc_attr( $position_class ); ?>">
    <div class="reviews-block__container container">
        <div class="reviews-block__wrapper grid grid-cols-1 lg:grid-cols-3 gap-12 lg:gap-16">
            
            <!-- Content: Title, Subtitle, Button (1/3) -->
            <div class="reviews-block__content lg:col-span-1 bg-grey-light relative z-[1] <?php echo esc_attr( $grid_order_class ); ?>">
                <?php if ( $title ) : ?>
                    <h2 class="reviews-block__title font-title text-3xl md:text-4xl lg:text-5xl uppercase font-bold mb-6"><?php echo esc_html( $title ); ?></h2>
                <?php endif; ?>
                
                <?php if ( $subtitle ) : ?>
                    <p class="reviews-block__subtitle text-sm md:text-base text-grey mb-2"><?php echo esc_html( $subtitle ); ?></p>
                <?php endif; ?>
                
                <?php if ( ! empty( $button_list ) ) : ?>
                    <div class="reviews-block__buttons mt-8 flex flex-wrap gap-3">
                        <?php foreach ( $button_list as $btn ) : ?>
                            <?php kj_render_button( $btn ); ?>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
            
            <!-- Reviews Swiper (2/3) -->
            <div class="reviews-block__swiper-wrapper lg:col-span-2 relative z-[0] <?php echo esc_attr( $swiper_order_class ); ?>">
                <?php if ( $is_single_review ) : ?>
                    <!-- Single review: no Swiper, just display the review -->
                    <?php 
                    $review_post = $reviews_posts[0];
                    $review_obj = is_object( $review_post ) ? $review_post : get_post( $review_post );
                    
                    if ( $review_obj ) :
                        // Get ACF fields from review post
                        $review_name = get_field( 'review_name', $review_obj->ID );
                        $review_text = get_field( 'review_text', $review_obj->ID );
                        $review_logo = get_field( 'review_logo', $review_obj->ID );
                        
                        // Fallback to featured image if no review logo
                        if ( ! $review_logo ) {
                            $featured_image_id = get_post_thumbnail_id( $review_obj->ID );
                            if ( $featured_image_id ) {
                                $review_logo = array( 'ID' => $featured_image_id );
                            }
                        }
                        ?>
                        <article class="reviews-block__item bg-grey-dark p-4 md:p-6 lg:p-8 h-full flex flex-col">
                            <?php if ( $review_logo ) : ?>
                                <div class="reviews-block__logo-wrapper flex items-start justify-start mb-4">
                                    <div class="reviews-block__logo-container">
                                        <?php echo wp_get_attachment_image( 
                                            $review_logo['ID'], 
                                            'full', 
                                            false, 
                                            array( 
                                                'class' => 'reviews-block__logo h-8 md:h-10 w-auto object-contain' 
                                            ) 
                                        ); ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ( $review_text ) : ?>
                                <div class="reviews-block__text mb-4 flex-grow">
                                    <p class="text-grey-text leading-relaxed text-sm"><?php echo wp_kses_post( nl2br( $review_text ) ); ?></p>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ( $review_name ) : ?>
                                <div class="reviews-block__author">
                                    <p class="font-semibold text-white">- <?php echo esc_html( $review_name ); ?></p>
                                </div>
                            <?php endif; ?>

                            <!-- Even en Oneven -->
                            <svg class="h-10 md:h-16 absolute bottom-0 right-0" viewBox="0 0 118 59" fill="none" xmlns="http://www.w3.org/2000/svg"><rect opacity="0.45" x="1" y="30.5239" width="27.2934" height="27.2934" fill="#D9D9D9" stroke="#D9D9D9" stroke-width="2"/><rect opacity="0.45" x="87.8801" width="29.2934" height="29.2934" fill="#D9D9D9"/><rect opacity="0.45" x="30.2935" y="1.23047" width="27.2934" height="27.2934" stroke="#D9D9D9" stroke-width="2"/></svg>
                        </article>
                    <?php endif; ?>
                <?php else : ?>
                    <!-- Multiple reviews: use Swiper -->
                    <div class="swiper js-reviews-swiper" id="<?php echo esc_attr( $swiper_id ); ?>">
                        <div class="swiper-wrapper">
                            <?php 
                            $review_index = 0;
                            foreach ( $reviews_posts as $review_post ) : 
                                // Get review post object
                                $review_obj = is_object( $review_post ) ? $review_post : get_post( $review_post );
                                $review_index++;
                                
                                if ( ! $review_obj ) {
                                    continue;
                                }
                                
                                // Get ACF fields from review post
                                $review_name = get_field( 'review_name', $review_obj->ID );
                                $review_text = get_field( 'review_text', $review_obj->ID );
                                $review_logo = get_field( 'review_logo', $review_obj->ID );
                                
                                // Fallback to featured image if no review logo
                                if ( ! $review_logo ) {
                                    $featured_image_id = get_post_thumbnail_id( $review_obj->ID );
                                    if ( $featured_image_id ) {
                                        $review_logo = array( 'ID' => $featured_image_id );
                                    }
                                }
                                ?>
                                <div class="swiper-slide">
                                    <article class="reviews-block__item bg-grey-dark p-4 md:p-6 lg:p-8 h-full flex flex-col">
                                        <?php if ( $review_logo ) : ?>
                                            <div class="reviews-block__logo-wrapper flex items-start justify-start mb-4">
                                                <div class="reviews-block__logo-container">
                                                    <?php echo wp_get_attachment_image( 
                                                        $review_logo['ID'], 
                                                        'full', 
                                                        false, 
                                                        array( 
                                                            'class' => 'reviews-block__logo h-8 md:h-10 w-auto object-contain' 
                                                        ) 
                                                    ); ?>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <?php if ( $review_text ) : ?>
                                            <div class="reviews-block__text mb-4 flex-grow">
                                                <p class="text-grey-text leading-relaxed text-sm"><?php echo wp_kses_post( nl2br( $review_text ) ); ?></p>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <?php if ( $review_name ) : ?>
                                            <div class="reviews-block__author">
                                                <p class="font-semibold text-white">- <?php echo esc_html( $review_name ); ?></p>
                                            </div>
                                        <?php endif; ?>

                                        <!-- Even en Oneven -->
                                        <?php if ( $review_index % 2 === 0 ) : ?>
                                            <svg class="h-10 md:h-16 absolute bottom-0 right-0" viewBox="0 0 118 59" fill="none" xmlns="http://www.w3.org/2000/svg"><rect opacity="0.45" x="86.8057" y="28.2686" width="27.2683" height="27.2683" transform="rotate(180 86.8057 28.2686)" stroke="#D9D9D9" stroke-width="2"/><rect opacity="0.45" x="28.2683" y="56.8237" width="27.2683" height="27.2683" transform="rotate(180 28.2683 56.8237)" stroke="#D9D9D9" stroke-width="2"/><rect opacity="0.45" x="117.074" y="58.5366" width="29.2683" height="29.2683" transform="rotate(180 117.074 58.5366)" fill="#D9D9D9"/></svg>
                                        <?php else : ?>
                                            <svg class="h-10 md:h-16 absolute bottom-0 right-0" viewBox="0 0 118 59" fill="none" xmlns="http://www.w3.org/2000/svg"><rect opacity="0.45" x="1" y="30.5239" width="27.2934" height="27.2934" fill="#D9D9D9" stroke="#D9D9D9" stroke-width="2"/><rect opacity="0.45" x="87.8801" width="29.2934" height="29.2934" fill="#D9D9D9"/><rect opacity="0.45" x="30.2935" y="1.23047" width="27.2934" height="27.2934" stroke="#D9D9D9" stroke-width="2"/></svg>
                                        <?php endif; ?>

                                    </article>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        
                        <!-- Scrollbar -->
                        <div class="swiper-scrollbar mt-6"></div>
                        
                        <!-- Navigation -->
                        <div class="swiper-navigation-wrapper is-relative z-[1] flex items-center mt-4">
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
                <?php endif; ?>
            </div>
            
        </div>
    </div>
</section>

