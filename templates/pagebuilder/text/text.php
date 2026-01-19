<?php
/**
 * Text Block
 *
 * @package asbestverwijdering
 * @version 1.0.0
 * @author Kay Jilesen
 */

defined( 'ABSPATH' ) || exit;

$title = get_sub_field( 'title' );
$text = get_sub_field( 'text' );

// Styling options
$background_color = get_sub_field( 'background_color' ) ?: 'white';
$padding_top = get_sub_field( 'padding_top' );
$padding_bottom = get_sub_field( 'padding_bottom' );
$text_alignment = get_sub_field( 'text_alignment' ) ?: 'center';
$container_width = get_sub_field( 'container_width' ) ?: '4xl';

// Build classes
$bg_class = 'bg-' . $background_color;
$padding_classes = '';
if ( $padding_top ) {
    $padding_classes .= ' pt-12 md:pt-16 lg:pt-20';
}
if ( $padding_bottom ) {
    $padding_classes .= ' pb-12 md:pb-16 lg:pb-20';
}

// Alignment classes
$alignment_class = $text_alignment === 'left' ? 'text-left' : 'text-center';

// Container width mapping (maps friendly values to Tailwind classes)
$container_width_map = array(
    'full'      => '',
    '2xl'       => 'max-w-2xl',
    '4xl'       => 'max-w-4xl',
    '5xl'       => 'max-w-5xl',
    'screen-lg' => 'max-w-screen-lg',
    'screen-xl' => 'max-w-screen-xl',
);

// Container width classes
$container_class = '';
if ( isset( $container_width_map[ $container_width ] ) && $container_width_map[ $container_width ] !== '' ) {
    $container_class = $container_width_map[ $container_width ] . ' mx-auto';
}

// Tailwind safelist - ensures these classes are included in the stylesheet
// max-w-2xl max-w-4xl max-w-6xl max-w-screen-lg max-w-screen-xl
?>

<section class="text-block <?php echo esc_attr( $bg_class . $padding_classes ); ?>">
    <div class="text-block__container container">

        <?php if ( $title || $text ) : ?>
            <!-- Tailwind safelist: max-w-2xl max-w-4xl max-w-5xl max-w-screen-lg max-w-screen-xl -->
            <div class="text-block__content <?php echo esc_attr( $alignment_class . ' ' . $container_class ); ?>">
                <?php if ( $title ) : ?>
                    <h2 class="text-block__title font-title text-3xl md:text-4xl lg:text-5xl uppercase font-bold mb-4 <?php echo esc_attr( $alignment_class ); ?>"><?php echo esc_html( $title ); ?></h2>
                <?php endif; ?>

                <?php if ( $text ) : ?>
                    <div class="text-block__text text-sm md:text-base text-grey <?php echo esc_attr( $alignment_class ); ?>"><?php echo wp_kses_post( $text ); ?></div>
                <?php endif; ?>
            </div>
        <?php endif; ?>

    </div>
</section>
