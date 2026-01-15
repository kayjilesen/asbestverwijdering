<?php
/**
 * Hero & Offerte Block
 * 
 * Desktop: 2 kolommen - Links: grote titel + afbeelding, Rechts: offerte formulier op gele achtergrond
 * 
 * @package asbestverwijdering
 * @version 1.0.0
 * @author Kay Jilesen
 */

defined( 'ABSPATH' ) || exit;

$title = get_sub_field( 'title' );
$image = get_sub_field( 'image' );
$form_shortcode = get_sub_field( 'form_shortcode' );

// Get padding options
$padding_top_value = get_sub_field( 'padding_top' );
$padding_bottom_value = get_sub_field( 'padding_bottom' );

// Get background color
$background_color = get_sub_field( 'background_color' ) ?: 'white';
$bg_class = 'bg-' . $background_color;

// If field hasn't been set (null), default to true
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

<section class="hero-offerte-block <?php echo esc_attr( $padding_class ); ?> <?php echo esc_attr( $bg_class ); ?>">
    <div class="hero-offerte-block__container container">
        <div class="hero-offerte-block__wrapper grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 pt-8">
            
            <!-- Left: Title + Image -->
            <div class="hero-offerte-block__left order-1 lg:order-1">
                <?php if ( $title ) : ?>
                    <h1 class="hero-offerte-block__title text-3xl md:text-4xl lg:text-5xl xl:text-[80px] font-title uppercase font-bold text-grey-dark mb-6 lg:mb-8 highlight-strong">
                        <?php echo wp_kses_post( $title ); ?>
                    </h1>
                <?php endif; ?>
                
                <?php if ( $image ) : ?>
                    <div class="hero-offerte-block__image-wrapper">
                        <?php echo wp_get_attachment_image(
                            $image['ID'],
                            'large',
                            false,
                            array(
                                'class' => 'hero-offerte-block__image w-full h-auto'
                            )
                        ); ?>
                    </div>
                <?php endif; ?>
            </div>
            
            <!-- Right: Form on Yellow Background -->
            <div class="hero-offerte-block__right order-2 lg:order-2">
                <?php if ( $form_shortcode ) : ?>
                    <div class="hero-offerte-block__form-wrapper bg-primary p-6 md:p-8 lg:p-10 rounded-[8px] mt-4">
                        <?php echo do_shortcode( wp_kses_post( $form_shortcode ) ); ?>
                    </div>
                <?php endif; ?>
            </div>
            
        </div>
    </div>
</section>
