<?php
/**
 * Team Block
 *
 * @package asbestverwijdering
 * @version 1.0.0
 * @author Kay Jilesen
 */

defined( 'ABSPATH' ) || exit;

$title = get_sub_field( 'title' );
$text = get_sub_field( 'text' );
$image = get_sub_field( 'image' );

// Styling options
$background_color = get_sub_field( 'background_color' ) ?: 'white';
$padding_top = get_sub_field( 'padding_top' );
$padding_bottom = get_sub_field( 'padding_bottom' );

// Build classes
$bg_class = 'bg-' . $background_color;
$padding_classes = '';
if ( $padding_top ) {
    $padding_classes .= ' pt-12 md:pt-16 lg:pt-20';
}
if ( $padding_bottom ) {
    $padding_classes .= ' pb-12 md:pb-16 lg:pb-20';
}
?>

<section class="team-block <?php echo esc_attr( $bg_class . $padding_classes ); ?>">
    <div class="team-block__container container">

        <?php if ( $title || $text ) : ?>
            <div class="team-block__header text-center mb-8 md:mb-12">
                <?php if ( $title ) : ?>
                    <h2 class="team-block__title font-title text-3xl md:text-4xl lg:text-5xl uppercase font-bold mb-4"><?php echo esc_html( $title ); ?></h2>
                <?php endif; ?>

                <?php if ( $text ) : ?>
                    <p class="team-block__text text-sm md:text-base text-grey max-w-4xl mx-auto"><?php echo wp_kses_post( $text ); ?></p>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if ( $image ) : ?>
            <div class="team-block__image-wrapper relative w-full pb-[40%] lg:pb-[35%] overflow-hidden kj-shadow">
                <?php echo wp_get_attachment_image(
                    $image['ID'],
                    'full',
                    false,
                    array(
                        'class' => 'team-block__image absolute inset-0 w-full h-full object-cover'
                    )
                ); ?>
            </div>
        <?php endif; ?>

    </div>
</section>
