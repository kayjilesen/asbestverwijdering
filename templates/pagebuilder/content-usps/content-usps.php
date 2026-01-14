<?php
/**
 * Content & USPs Block
 * 
 * Dark background block with title, description, USPs list, and two images
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
$image_left = get_sub_field( 'image_left' );
$image_right = get_sub_field( 'image_right' );

// Get padding options
$padding_top_value = get_sub_field( 'padding_top' );
$padding_bottom_value = get_sub_field( 'padding_bottom' );
$padding_top = ( $padding_top_value === null ) ? true : ! empty( $padding_top_value );
$padding_bottom = ( $padding_bottom_value === null ) ? true : ! empty( $padding_bottom_value );

// Set padding classes
$padding_classes = array();
if ( $padding_top ) {
    $padding_classes[] = 'pt-20 lg:pt-[120px]';
}
if ( $padding_bottom ) {
    $padding_classes[] = 'pb-20 lg:pb-[120px]';
}
$padding_class = ! empty( $padding_classes ) ? implode( ' ', $padding_classes ) : '';
?>

<section class="content-usps-block <?php echo esc_attr( $padding_class ); ?> bg-grey-dark">
    <div class="content-usps-block__container container">
        <div class="content-usps-block__wrapper grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16">
            
            <!-- Text Content -->
            <div class="content-usps-block__content col-span-1 lg:col-span-6 order-2 lg:order-1">
                
                <?php if ( $title ) : ?>
                    <h2 class="content-usps-block__title font-title uppercase text-3xl md:text-4xl lg:text-5xl font-bold mb-6 text-white"><?php echo esc_html( $title ); ?></h2>
                <?php endif; ?>
                
                <?php if ( $description ) : ?>
                    <div class="content-usps-block__description text-wrapper prose prose-lg prose-invert mb-8 !text-grey-text">
                        <?php echo wp_kses_post( $description ); ?>
                    </div>
                <?php endif; ?>
                
                <?php if ( $usps && is_array( $usps ) && ! empty( $usps ) ) : ?>
                    <div class="content-usps-block__usps flex flex-col gap-4 mb-8">
                        <?php foreach ( $usps as $usp ) : 
                            $usp_text = $usp['text'] ?? '';
                            if ( empty( $usp_text ) ) continue;
                        ?>
                            <div class="content-usps-block__usp flex items-start gap-3">
                                <div class="content-usps-block__usp-icon w-6 h-6 bg-primary flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <svg class="size-3 text-grey-dark" viewBox="0 0 16 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M14.5 1L5.5 10L1.5 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>
                                <p class="content-usps-block__usp-text text-white font-bold"><?php echo esc_html( $usp_text ); ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                
                <?php if ( $buttons && is_array( $buttons ) && ! empty( $buttons ) ) : ?>
                    <div class="content-usps-block__buttons">
                        <?php kj_render_buttons( 'buttons', false, 'flex flex-row gap-4' ); ?>
                    </div>
                <?php endif; ?>
            </div>
            
            <!-- Images -->
            <div class="content-usps-block__images col-span-1 lg:col-span-6 order-1 lg:order-2">
                <div class="content-usps-block__images-grid grid grid-cols-2 gap-4">
                    <?php if ( $image_left ) : ?>
                        <div class="content-usps-block__image-left">
                            <?php echo wp_get_attachment_image( $image_left['ID'], 'large', false, array( 'class' => 'content-usps-block__image w-full h-auto' ) ); ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ( $image_right ) : ?>
                        <div class="content-usps-block__image-right mt-8">
                            <?php echo wp_get_attachment_image( $image_right['ID'], 'large', false, array( 'class' => 'content-usps-block__image w-full h-auto' ) ); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
        </div>
    </div>
</section>

