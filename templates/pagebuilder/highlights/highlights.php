<?php
/**
 * Highlights Block
 * 
 * @package asbestverwijdering
 * @version 1.0.0
 * @author Kay Jilesen
 */

defined( 'ABSPATH' ) || exit;

$title = get_sub_field( 'title' );
$description = get_sub_field( 'description' );
$images = get_sub_field( 'images' );

// Don't show section if no images
if ( empty( $images ) ) {
    return;
}

// Split images: first one is featured, rest go in swiper
$featured_image = ! empty( $images[0] ) ? $images[0] : null;
$remaining_images = array_slice( $images, 1 );

// Unique ID for this swiper instance
$swiper_id = 'highlights-' . uniqid();
?>

<section class="highlights-block section-pd bg-white">
    <div class="highlights-block__container container">
        <div class="highlights-block__grid grid grid-cols-1 lg:grid-cols-5 gap-8 lg:gap-12">
            
            <!-- Left: Featured Image (2/5) -->
            <?php if ( $featured_image && ! empty( $featured_image['ID'] ) ) : ?>
                <div class="highlights-block__featured lg:col-span-2">
                    <div class="highlights-block__featured-wrapper">
                        <?php echo wp_get_attachment_image( 
                            $featured_image['ID'], 
                            'large', 
                            false, 
                            array( 
                                'class' => 'highlights-block__featured-image w-full h-auto object-cover' 
                            ) 
                        ); ?>
                    </div>
                </div>
            <?php endif; ?>
            
            <!-- Right: Title, Description & Remaining Images (3/5) -->
            <div class="highlights-block__content lg:col-span-3 flex flex-col">
                
                <!-- Title & Description (top) -->
                <?php if ( $title || $description ) : ?>
                    <div class="highlights-block__header mb-8 lg:mb-12">
                        <?php if ( $title ) : ?>
                            <h2 class="highlights-block__title font-title text-3xl md:text-4xl lg:text-5xl uppercase font-bold mb-4"><?php echo esc_html( $title ); ?></h2>
                        <?php endif; ?>
                        
                        <?php if ( $description ) : ?>
                            <div class="highlights-block__description text-grey-text">
                                <?php echo wp_kses_post( $description ); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                
                <!-- Remaining Images Swiper (bottom) -->
                <?php if ( ! empty( $remaining_images ) ) : ?>
                    <div class="highlights-block__swiper-wrapper mt-auto">
                        <div class="swiper js-highlights-swiper" id="<?php echo esc_attr( $swiper_id ); ?>">
                            <div class="swiper-wrapper">
                                <?php foreach ( $remaining_images as $image ) : ?>
                                    <?php if ( ! empty( $image['ID'] ) ) : ?>
                                        <div class="swiper-slide">
                                            <div class="highlights-block__image-wrapper">
                                                <?php echo wp_get_attachment_image( 
                                                    $image['ID'], 
                                                    'large', 
                                                    false, 
                                                    array( 
                                                        'class' => 'highlights-block__image w-full h-auto object-cover' 
                                                    ) 
                                                ); ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>
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
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

