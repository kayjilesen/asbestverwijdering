<?php
/**
 * Zakelijke Aanvraag Block
 * 
 * @package asbestverwijdering
 * @version 1.0.0
 * @author Kay Jilesen
 */

defined( 'ABSPATH' ) || exit;

$title = get_sub_field( 'title' ) ?? '';
$text = get_sub_field( 'text' ) ?? '';
$buttons = get_sub_field( 'buttons' ) ?? [];
$image = get_sub_field( 'image' ) ?? null;

// Don't show section if no content
if ( empty( $title ) && empty( $text ) && empty( $buttons ) && empty( $image ) ) {
    return;
}

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

// Get image ID
$image_id = null;
if ( $image ) {
    $image_id = is_array( $image ) && isset( $image['ID'] ) ? $image['ID'] : ( is_numeric( $image ) ? $image : null );
}
?>

<section class="zakelijke-aanvraag-block <?php echo esc_attr( $padding_class ); ?> bg-beige">
    <div class="zakelijke-aanvraag-block__container container">
        <div class="zakelijke-aanvraag-block__wrapper grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8">
            
            <!-- Left Column: Content (larger) -->
            <?php if ( ! empty( $title ) || ! empty( $text ) || ! empty( $buttons ) ) : ?>
                <div class="zakelijke-aanvraag-block__content col-span-1 lg:col-span-8 bg-grey-dark p-8 lg:p-12 text-white relative overflow-hidden">
                    
                    <div class="zakelijke-aanvraag-block__content-inner relative z-10">
                        <?php if ( ! empty( $title ) ) : ?>
                            <h2 class="zakelijke-aanvraag-block__title font-title uppercase text-3xl md:text-4xl lg:text-[48px] text-white font-bold mb-6">
                                <?php echo esc_html( $title ); ?>
                            </h2>
                        <?php endif; ?>
                        
                        <?php if ( ! empty( $text ) ) : ?>
                            <div class="zakelijke-aanvraag-block__text text-wrapper prose prose-lg prose-invert mb-8 !text-grey-text">
                                <?php echo wp_kses_post( $text ); ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php if ( ! empty( $buttons ) ) : ?>
                            <div class="zakelijke-aanvraag-block__buttons flex flex-row flex-wrap gap-4">
                                <?php 
                                foreach ( $buttons as $button ) {
                                    // Handle cloned button field structure
                                    $button_data = isset( $button['button'] ) ? $button['button'] : $button;
                                    kj_render_button( $button_data );
                                }
                                ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
            
            <!-- Right Column: Image -->
            <?php if ( $image_id ) : ?>
                <div class="zakelijke-aanvraag-block__image-wrapper col-span-1 lg:col-span-4 bg-grey-dark p-8 lg:p-12 flex items-center justify-center relative overflow-hidden">
                    <div class="zakelijke-aanvraag-block__image-inner relative z-10 w-full">
                        <?php echo wp_get_attachment_image( $image_id, 'large', false, array( 'class' => 'zakelijke-aanvraag-block__image w-full h-auto object-contain' ) ); ?>
                    </div>
                </div>
            <?php endif; ?>
            
        </div>
    </div>
</section>
