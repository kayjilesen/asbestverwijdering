<?php
/**
 * Call to Action Block
 *
 * Nieuwe layout: links geel vlak met titel, tekst en buttons
 * Rechts afbeelding aan onderkant uitgelijnd
 *
 * @package asbestverwijdering
 * @version 2.0.0
 * @author Kay Jilesen
 */

defined( 'ABSPATH' ) || exit;

$use_default = (bool) get_sub_field( 'mode' );

if ( $use_default ) {
    $title   = get_field( 'cta_default_title', 'option' );
    $text    = get_field( 'cta_default_text', 'option' );
    $buttons = get_field( 'cta_default_buttons', 'option' );
    $image   = get_field( 'cta_default_image', 'option' );
} else {
    $title   = get_sub_field( 'title' ) ?: get_field( 'cta_default_title', 'option' );
    $text    = get_sub_field( 'text' ) ?: get_field( 'cta_default_text', 'option' );
    $buttons = get_sub_field( 'buttons' ) ?: get_field( 'cta_default_buttons', 'option' );
    $image   = get_sub_field( 'right_image' ) ?: get_field( 'cta_default_image', 'option' );
}

// Get padding options
$padding_top_value = get_sub_field( 'padding_top' );
$padding_bottom_value = get_sub_field( 'padding_bottom' );

// Get background color
$background_color = get_sub_field( 'background_color' ) ?: 'beige';
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

<section class="call-to-action-block rounded-[8px] <?php echo esc_attr( $padding_class ); ?> <?php echo esc_attr( $bg_class ); ?>">
    <div class="call-to-action-block__container container">
        <div class="call-to-action-block__wrapper grid grid-cols-1 lg:grid-cols-5 bg-primary rounded-lg overflow-hidden">

            <!-- Left: Content (3/5 = 60%) -->
            <div class="call-to-action-block__left lg:col-span-3 p-8 md:p-12 lg:p-16 flex flex-col justify-center items-center text-center lg:items-start lg:text-left">
                <?php if ( $title ) : ?>
                    <h2 class="call-to-action-block__title text-3xl md:text-4xl lg:text-5xl font-title uppercase font-bold text-grey-dark mb-6"><?php echo esc_html( $title ); ?></h2>
                <?php endif; ?>

                <?php if ( $text ) : ?>
                    <div class="call-to-action-block__text text-grey-dark mb-8">
                        <?php echo $text; ?>
                    </div>
                <?php endif; ?>

                <?php if ( $buttons && is_array( $buttons ) ) : ?>
                    <div class="call-to-action-block__buttons flex flex-wrap gap-4 justify-center lg:justify-start">
                        <?php foreach ( $buttons as $button_item ) : ?>
                            <?php
                            if ( ! empty( $button_item['button'] ) ) {
                                kj_render_button( $button_item['button'] );
                            }
                            ?>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Right: Image (2/5 = 40%) -->
            <div class="call-to-action-block__right lg:col-span-2 flex items-end justify-center lg:justify-end lg:pr-16">
                <?php if ( $image ) : ?>
                    <div class="call-to-action-block__image-wrapper w-full max-w-xs lg:max-w-full">
                        <?php echo wp_get_attachment_image(
                            $image['ID'],
                            'medium_large',
                            false,
                            array(
                                'class' => 'call-to-action-block__image w-full h-auto object-contain object-bottom'
                            )
                        ); ?>
                    </div>
                <?php endif; ?>
            </div>

        </div>
    </div>
</section>
