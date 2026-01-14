<?php
/**
 * Info Cards Block
 * 
 * Light grey background block with title, subtitle, and icon cards
 * 
 * @package asbestverwijdering
 * @version 1.0.0
 * @author Kay Jilesen
 */

defined( 'ABSPATH' ) || exit;

$subtitle = get_sub_field( 'subtitle' );
$title = get_sub_field( 'title' );
$cards = get_sub_field( 'cards' );
$buttons = get_sub_field( 'buttons' );

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

<section class="info-cards-block <?php echo esc_attr( $padding_class ); ?> bg-grey-light">
    <div class="info-cards-block__container container">
        
        <!-- Header -->
        <div class="info-cards-block__header text-center mb-12 lg:mb-16">
            <?php if ( $subtitle ) : ?>
                <p class="info-cards-block__subtitle text-lg text-grey mb-2"><?php echo esc_html( $subtitle ); ?></p>
            <?php endif; ?>
            
            <?php if ( $title ) : ?>
                <h2 class="info-cards-block__title font-title uppercase text-3xl md:text-4xl lg:text-5xl font-bold text-grey-dark"><?php echo esc_html( $title ); ?></h2>
            <?php endif; ?>
        </div>
        
        <!-- Cards Grid -->
        <?php if ( $cards && is_array( $cards ) && ! empty( $cards ) ) : ?>
            <div class="info-cards-block__grid grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ( $cards as $card ) : 
                    $icon = $card['icon'] ?? null;
                    $card_title = $card['title'] ?? '';
                    $card_description = $card['description'] ?? '';
                    if ( empty( $card_title ) ) continue;
                ?>
                    <div class="info-cards-block__card bg-white p-6 lg:p-8">
                        <?php if ( $icon ) : ?>
                            <div class="info-cards-block__card-icon mb-4">
                                <?php echo wp_get_attachment_image( $icon['ID'], 'thumbnail', false, array( 'class' => 'info-cards-block__icon w-12 h-12 object-contain' ) ); ?>
                            </div>
                        <?php endif; ?>
                        
                        <h3 class="info-cards-block__card-title font-title uppercase text-xl lg:text-2xl font-bold text-grey-dark mb-3"><?php echo esc_html( $card_title ); ?></h3>
                        
                        <?php if ( $card_description ) : ?>
                            <p class="info-cards-block__card-description text-grey"><?php echo wp_kses_post( $card_description ); ?></p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <!-- Buttons -->
        <?php if ( $buttons && is_array( $buttons ) && ! empty( $buttons ) ) : ?>
            <div class="info-cards-block__buttons text-center mt-12">
                <?php kj_render_buttons( 'buttons', false, 'flex flex-row gap-4 justify-center' ); ?>
            </div>
        <?php endif; ?>
        
    </div>
</section>

