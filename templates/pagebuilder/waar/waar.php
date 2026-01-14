<?php
/**
 * Waar? Block
 * 
 * @package asbestverwijdering
 * @version 1.0.0
 * @author Kay Jilesen
 */

defined( 'ABSPATH' ) || exit;

$subtitle = get_sub_field( 'subtitle' );
$title = get_sub_field( 'title' );
$items = get_sub_field( 'items' );

// Don't show section if no items
if ( empty( $items ) ) {
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
?>

<section class="waar-block <?php echo esc_attr( $padding_class ); ?> bg-white">
    <div class="waar-block__container container">
        <div class="waar-block__wrapper">
            
            <!-- Header: Title & Subtitle -->
            <div class="waar-block__header mb-12 text-center"> 
                <?php if ( $title ) : ?>
                    <h2 class="waar-block__title text-3xl md:text-4xl lg:text-5xl font-normal font-title uppercase font-bold mb-6"><?php echo esc_html( $title ); ?></h2>
                <?php endif; ?>
                <?php if ( $subtitle ) : ?>
                    <p class="waar-block__subtitle text-sm md:text-base text-grey mb-2"><?php echo esc_html( $subtitle ); ?></p>
                <?php endif; ?>
            </div>
            
            <!-- Items Grid -->
            <div class="waar-block__items grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                <?php 
                foreach ( $items as $item ) : 
                    $item_icon = $item['icon'] ?? null;
                    $item_title = $item['title'] ?? '';
                    $item_description = $item['description'] ?? '';
                    $item_link = $item['page'] ?? null;
                    ?>
                    <div class="waar-block__item bg-yellow-light relative p-6 md:p-8 lg:p-10 h-full flex flex-col">
                        
                        <div class="waar-block__title-row relative flex flex-row gap-4 z-[1]">
                            <div class="waar-block__title-row-inner relative flex flex-row gap-4">
                            <?php if ( $item_icon ) : ?>
                                <div class="waar-block__icon-wrapper">
                                    <div class="waar-block__icon-container w-8 h-8 bg-grey-dark flex items-center justify-center -translate-y-1.5">
                                        <?php echo wp_get_attachment_image( 
                                            $item_icon['ID'], 
                                            'thumbnail', 
                                            false, 
                                            array( 
                                                'class' => 'waar-block__icon w-5 h-5 object-contain' 
                                            ) 
                                        ); ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ( $item_title ) : ?>
                                <h3 class="waar-block__item-title font-title uppercase text-xl md:text-2xl font-semibold mb-3 text-grey-dark"><?php echo esc_html( $item_title ); ?></h3>
                            <?php endif; ?>

                            </div>
                        </div>
                        
                        <?php if ( $item_description ) : ?>
                            <div class="waar-block__item-description text-grey leading-relaxed mb-4 flex-grow">
                                <?php echo wp_kses_post( $item_description ); ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php 
                        if ( $item_link ) : 
                        ?>
                            <div class="waar-block__item-link mt-auto">
                                <?php kj_button( __('Lees meer', 'kj'), $item_link, 'internal', 'text'); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <!-- Buttons -->
            <div class="waar-block__buttons flex justify-center">
                <?php kj_render_buttons( 'buttons', false, 'flex flex-row gap-4' ); ?>
            </div>
            
        </div>
    </div>
</section>

