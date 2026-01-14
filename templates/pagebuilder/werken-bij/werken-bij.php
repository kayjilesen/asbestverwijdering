<?php
/**
 * Werken bij Block
 * 
 * @package asbestverwijdering
 * @version 1.0.0
 * @author Kay Jilesen
 */

defined( 'ABSPATH' ) || exit;

$title = get_sub_field( 'title' );
$description = get_sub_field( 'description' );
$usps = get_sub_field( 'usps' );
$buttons = get_sub_field( 'buttons' );
$image = get_sub_field( 'image' );

// Get background color
$background_color = get_sub_field( 'background_color' ) ?: 'grey-dark';
$bg_class = 'bg-' . $background_color;
?>

<section class="werken-bij-block section-pd <?php echo esc_attr( $bg_class ); ?>">
    <div class="werken-bij-block__container container">
        <div class="werken-bij-block__wrapper grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-24">
            
            <!-- Text Content -->
            <div class="werken-bij-block__content w-full col-span-1 lg:col-span-6 xl:col-span-6 order-1">
                
                <?php if ( $title ) : ?>
                    <h2 class="werken-bij-block__title font-title uppercase text-3xl md:text-4xl lg:text-5xl font-bold mb-6 text-white"><?php echo esc_html( $title ); ?></h2>
                <?php endif; ?>
                
                <?php if ( $description ) : ?>
                    <div class="werken-bij-block__description text-wrapper prose prose-lg prose-invert mb-8 !text-grey-text">
                        <?php echo wp_kses_post( $description ); ?>
                    </div>
                <?php endif; ?>
                
                <?php if ( $usps && is_array( $usps ) && !empty( $usps ) ) : ?>
                    <div class="werken-bij-block__usps flex flex-col gap-4 mb-8">
                        <?php foreach ( $usps as $usp ) : 
                            $usp_text = $usp['text'] ?? '';
                            if ( empty( $usp_text ) ) continue;
                        ?>
                            <div class="werken-bij-block__usp flex items-start gap-3">
                                <div class="werken-bij-block__usp-icon w-6 h-6 bg-primary flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <svg class="size-3 text-grey-dark" viewBox="0 0 16 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M14.5 1L5.5 10L1.5 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>
                                <p class="werken-bij-block__usp-text text-white font-bold"><?php echo esc_html( $usp_text ); ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                
                <?php if ( $buttons && is_array( $buttons ) && !empty( $buttons ) ) : ?>
                    <div class="werken-bij-block__buttons">
                        <?php kj_render_buttons( 'buttons', false, 'flex flex-row gap-4' ); ?>
                    </div>
                <?php endif; ?>
            </div>
            
            <!-- Image -->
            <?php if ( $image ) : ?>
                <div class="werken-bij-block__image-wrapper w-full col-span-1 lg:col-span-6 xl:col-span-6 order-2">
                    <div class="werken-bij-block__image-container overflow-hidden">
                        <?php echo wp_get_attachment_image( $image['ID'], 'large', false, array( 'class' => 'werken-bij-block__image w-full h-auto' ) ); ?>
                    </div>
                </div>
            <?php endif; ?>
            
        </div>
    </div>
</section>

