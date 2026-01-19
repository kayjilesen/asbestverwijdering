<?php
/**
 * Text & Image Block
 * 
 * @package asbestverwijdering
 * @version 1.0.0
 * @author Kay Jilesen
 */

defined( 'ABSPATH' ) || exit;

$subtitle = get_sub_field( 'subtitle' );
$title = get_sub_field( 'title' );
$text = get_sub_field( 'text' );
$image = get_sub_field( 'image' );
$alignment = get_sub_field( 'alignment' );
$mode = get_sub_field( 'mode' ) ?: 'beige';

// Get padding options - ACF true_false returns empty string/0 when unchecked, 1 when checked
$padding_top_value = get_sub_field( 'padding_top' );
$padding_bottom_value = get_sub_field( 'padding_bottom' );

// If field hasn't been set (null), default to true. Otherwise check if value is truthy (1, true) or falsy (0, false, empty string)
$padding_top = ( $padding_top_value === null ) ? true : ! empty( $padding_top_value );
$padding_bottom = ( $padding_bottom_value === null ) ? true : ! empty( $padding_bottom_value );

// Set background and text colors based on mode
$bg_classes = array(
    'beige' => 'bg-beige',
    'beige-darker' => 'bg-beige-darker',
    'white' => 'bg-white',
    'dark' => 'bg-secondary'
);
$bg_class = isset( $bg_classes[ $mode ] ) ? $bg_classes[ $mode ] : 'bg-beige';
$text_class = $mode === 'dark' ? 'text-white' : '';

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

<section class="text-image-block relative <?php echo esc_attr( $padding_class ); ?> <?php echo esc_attr( $bg_class ); ?>">
    <div class="text-image-block__container container">
        <div class="text-image-block__wrapper grid grid-cols-1 lg:grid-cols-12 xl:grid-cols-11 gap-12 lg:gap-24">
            
            <!-- Text Content -->
            <div class="text-image-block__content w-full col-span-1 lg:col-span-6 xl:col-span-6 order-1 <?php echo $alignment === 'left' ? 'lg:order-2' : 'lg:order-1'; ?> <?php echo esc_attr( $text_class ); ?>">
                <?php if ( $subtitle ) : ?>
                    <p class="text-image-block__subtitle text-lg <?php echo $mode === 'dark' ? 'text-grey-text' : 'text-grey'; ?> mb-2"><?php echo esc_html( $subtitle ); ?></p>
                <?php endif; ?>
                
                <?php if ( $title ) : ?>
                    <h2 class="text-image-block__title font-title uppercase text-3xl md:text-4xl lg:text-5xl font-bold mb-6 <?php echo esc_attr( $text_class ); ?>"><?php echo wp_kses_post( $title ); ?></h2>
                <?php endif; ?>
                
                <?php if ( $text ) : ?>
                    <div class="text-image-block__text text-wrapper prose prose-lg mb-8 <?php echo $mode === 'dark' ? 'prose-invert' : ''; ?>">
                        <?php echo wp_kses_post( $text ); ?>
                    </div>
                <?php endif; ?>
                
                <div class="text-image-block__buttons">
                    <?php kj_render_buttons( 'buttons', false, 'flex flex-row gap-4' ); ?>
                </div>
            </div>
            
            <!-- Image -->
            <?php if ( $image ) : ?>
                <div class="text-image-block__image-wrapper relative z-10 w-full col-span-1 lg:col-span-6 xl:col-span-5 order-2 <?php echo $alignment === 'left' ? 'lg:order-1' : 'lg:order-2'; ?>">
                    <div class="text-image-block__image-container overflow-hidden rounded-lg">
                        <?php echo wp_get_attachment_image( $image['ID'], 'large', false, array( 'class' => 'text-image-block__image w-full h-auto' ) ); ?>
                    </div>
                    
                    <!-- Decorative SVG - Show when image is on the left -->
                    <?php if ( $alignment === 'left' ) : ?>
                        <div class="text-image-block__svg text-image-block__svg--left absolute left-0 bottom-0 h-[181px] w-auto z-20 hidden lg:block">
                            <svg width="317" height="181" viewBox="0 0 317 181" fill="none" xmlns="http://www.w3.org/2000/svg" class="h-full w-auto">
                                <rect x="229.477" y="1" width="86.37" height="86.373" rx="6" stroke="#FFD500" stroke-width="2"/>
                                <rect x="1" y="93.5" width="226.476" height="86.373" rx="6" stroke="#FFD500" stroke-width="2"/>
                            </svg>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            
        </div>
    </div>
    
    <!-- Decorative SVG - Show when image is on the right -->
    <?php if ( $alignment === 'right' ) : ?>
        <div class="text-image-block__svg text-image-block__svg--right absolute right-0 bottom-20 lg:bottom-[120px] h-[107px] w-auto z-0 hidden lg:block">
            <svg width="317" height="108" viewBox="0 0 317 108" fill="none" xmlns="http://www.w3.org/2000/svg" class="h-full w-auto">
                <rect x="1" y="1" width="401.97" height="105.433" rx="6" stroke="#FFD500" stroke-width="2"/>
            </svg>
        </div>
    <?php endif; ?>
</section>

