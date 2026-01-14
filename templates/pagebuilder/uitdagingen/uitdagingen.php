<?php
/**
 * Uitdagingen Block
 * 
 * @package asbestverwijdering
 * @version 1.0.0
 * @author Kay Jilesen
 */

defined( 'ABSPATH' ) || exit;

$title = get_sub_field( 'title' );
$text = get_sub_field( 'text' );
$facts_title = get_sub_field( 'facts_title' );
$facts = get_sub_field( 'facts' );
$image = get_sub_field( 'image' );

// Normalize image to always get an ID
$image_id = null;
if ( $image ) {
    // Handle different ACF return formats
    if ( is_array( $image ) ) {
        // Image Array format
        $image_id = $image['ID'] ?? $image['id'] ?? null;
    } elseif ( is_numeric( $image ) ) {
        // Image ID format
        $image_id = (int) $image;
    } elseif ( is_string( $image ) ) {
        // Image URL format - get ID from URL
        $image_id = attachment_url_to_postid( $image );
    }
}

// Get padding options
$padding_top_value = get_sub_field( 'padding_top' );
$padding_bottom_value = get_sub_field( 'padding_bottom' );

$padding_top = ( $padding_top_value === null ) ? true : ! empty( $padding_top_value );
$padding_bottom = ( $padding_bottom_value === null ) ? true : ! empty( $padding_bottom_value );

$padding_classes = array();
if ( $padding_top ) {
    $padding_classes[] = 'pt-20 lg:pt-[120px]';
}
if ( $padding_bottom ) {
    $padding_classes[] = 'pb-20 lg:pb-[120px]';
}
$padding_class = ! empty( $padding_classes ) ? implode( ' ', $padding_classes ) : '';
?>

<section class="uitdagingen-block bg-white <?php echo esc_attr( $padding_class ); ?>">
    <div class="uitdagingen-block__container container">
        <div class="uitdagingen-block__wrapper grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-24">
            
            <!-- Text Content -->
            <div class="uitdagingen-block__content w-full col-span-1 lg:col-span-6 order-1">
                
                <?php if ( $title ) : ?>
                    <h2 class="uitdagingen-block__title font-title uppercase text-4xl md:text-5xl lg:text-[48px] font-normal leading-none text-secondary mb-6"><?php echo esc_html( $title ); ?></h2>
                <?php endif; ?>
                
                <?php if ( $text ) : ?>
                    <div class="uitdagingen-block__text text-wrapper mb-8">
                        <?php echo wp_kses_post( $text ); ?>
                    </div>
                <?php endif; ?>
                
                <?php if ( $facts && is_array( $facts ) && ! empty( $facts ) ) : ?>
                    <div class="uitdagingen-block__facts bg-yellow-light p-6 lg:p-8 mb-8">
                        <?php if ( $facts_title ) : ?>
                            <h3 class="uitdagingen-block__facts-title font-title uppercase text-2xl md:text-3xl lg:text-[28px] font-normal leading-none text-secondary mb-6"><?php echo esc_html( $facts_title ); ?></h3>
                        <?php endif; ?>
                        
                        <div class="uitdagingen-block__facts-list grid grid-cols-1 md:grid-cols-2 gap-4">
                            <?php foreach ( $facts as $fact ) : 
                                $fact_text = $fact['text'] ?? '';
                                if ( empty( $fact_text ) ) continue;
                            ?>
                                <div class="uitdagingen-block__fact flex items-start gap-3">
                                    <div class="uitdagingen-block__fact-icon flex-shrink-0 w-[23px] h-[23px] bg-primary flex items-center justify-center">
                                        <svg class="w-[14px] h-[14px] text-secondary" viewBox="0 0 12 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1 4.5L4.5 8L11 1" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </div>
                                    <p class="uitdagingen-block__fact-text font-sans font-bold text-base leading-[1.83] text-secondary"><?php echo esc_html( $fact_text ); ?></p>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
                
                <div class="uitdagingen-block__buttons">
                    <?php kj_render_buttons( 'buttons', false, 'flex flex-row gap-4' ); ?>
                </div>
            </div>
            
            <!-- Image -->
            <?php if ( $image_id ) : ?>
                <div class="uitdagingen-block__image-wrapper w-full col-span-1 lg:col-span-6 order-2">
                    <div class="uitdagingen-block__image-container relative overflow-hidden">
                        <?php echo wp_get_attachment_image( $image_id, 'large', false, array( 'class' => 'uitdagingen-block__image w-full h-auto' ) ); ?>
                    </div>
                </div>
            <?php endif; ?>
            
        </div>
    </div>
</section>

