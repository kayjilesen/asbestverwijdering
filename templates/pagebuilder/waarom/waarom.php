<?php
/**
 * Waarom? Block
 * 
 * @package asbestverwijdering
 * @version 1.0.0
 * @author Kay Jilesen
 */

defined( 'ABSPATH' ) || exit;

$use_default = (bool) get_sub_field( 'mode' );

if ( $use_default ) {
    $subtitle = get_field( 'waarom_subtitle', 'option' );
    $title    = get_field( 'waarom_title', 'option' );
    $buttons  = get_field( 'waarom_buttons', 'option' );
    $items    = get_field( 'waarom_items', 'option' );
} else {
$subtitle = get_sub_field( 'subtitle' );
    $title    = get_sub_field( 'title' );
    $buttons  = get_sub_field( 'buttons' );
    $items    = get_sub_field( 'items' );
}

// Normalize buttons (repeater of clone group_button_fields)
$button_list = array();
if ( is_array( $buttons ) ) {
    foreach ( $buttons as $btn ) {
        if ( isset( $btn['button'] ) && is_array( $btn['button'] ) && ! empty( $btn['button']['button_label'] ) ) {
            $button_list[] = $btn['button'];
        } elseif ( isset( $btn['button_label'] ) && ! empty( $btn['button_label'] ) ) {
            $button_list[] = $btn;
        }
    }
} else {
    // Backward compatibility for single button structures
    $single_button = $use_default ? get_field( 'waarom_button', 'option' ) : get_sub_field( 'button' );
    if ( $single_button ) {
        if ( isset( $single_button['button'] ) && is_array( $single_button['button'] ) ) {
            $single_button = $single_button['button'];
        }
        if ( ! empty( $single_button['button_label'] ) ) {
            $button_list[] = $single_button;
        }
    }
}

// Don't show section if no items
if ( empty( $items ) ) {
    return;
}

// Count items to determine if last one should span 2 columns
$items_count = count( $items );
$is_three_items = ( $items_count === 3 );

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

<section class="waarom-block <?php echo esc_attr( $padding_class ); ?> bg-grey-light">
    <div class="waarom-block__container container">
        <div class="waarom-block__wrapper flex flex-col lg:flex-row gap-12 lg:gap-24">
            
            <div class="waarom-block__content w-full lg:w-1/3">
                
                <?php if ( $title ) : ?>
                    <h2 class="waarom-block__title text-3xl md:text-4xl lg:text-5xl font-normal font-title uppercase text-grey-dark mb-6"><?php echo esc_html( $title ); ?></h2>
                <?php endif; ?>

                <?php if ( $subtitle ) : ?>
                    <p class="waarom-block__subtitle text-sm md:text-base text-grey mb-2"><?php echo esc_html( $subtitle ); ?></p>
                <?php endif; ?>
                
                <?php if ( ! empty( $button_list ) ) : ?>
                    <div class="waarom-block__buttons mt-8 flex flex-wrap gap-3">
                        <?php foreach ( $button_list as $btn ) : ?>
                            <?php kj_render_button( $btn ); ?>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
            
            <div class="waarom-block__items w-full lg:w-2/3 lg:self-start grid grid-cols-1 xl:grid-cols-2 gap-8">
                <?php 
                $index = 0;
                foreach ( $items as $item ) : 

                    $index++;
                    $item_icon = $item['icon'] ?? null;
                    $item_title = $item['title'] ?? '';
                    $item_description = $item['description'] ?? '';
                    $item_link = $item['page'] ?? null;
                    
                    $span_class = ( $is_three_items && $index === 3 ) ? 'xl:col-span-2' : '';
                    ?>
                    <div class="waarom-block__item bg-yellow-light relative p-6 md:p-8 lg:p-10 h-full flex flex-col <?php echo esc_attr( $span_class ); ?>">
                        
                    
                        <div class="waarom-block__title-row relative flex flex-row">
                            <div class="waarom-block__title-row-inner relative flex flex-row gap-4 z-[1]">
                            <?php if ( $item_icon ) : ?>
                                <div class="waarom-block__icon-wrapper">
                                    <div class="waarom-block__icon-container w-8 h-8 bg-grey-dark flex items-center justify-center -translate-y-1.5">
                                        <?php echo wp_get_attachment_image( 
                                            $item_icon['ID'], 
                                            'thumbnail', 
                                            false, 
                                            array( 
                                                'class' => 'waarom-block__icon w-5 h-5 object-contain' 
                                            ) 
                                        ); ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ( $item_title ) : ?>
                                <h3 class="waarom-block__item-title font-title uppercase text-xl md:text-2xl font-semibold mb-3 text-grey-dark"><?php echo esc_html( $item_title ); ?></h3>
                            <?php endif; ?>

                            </div>
                        </div>
                        
                        <?php if ( $item_description ) : ?>
                            <div class="waarom-block__item-description text-grey leading-relaxed mb-4 flex-grow">
                                <?php echo wp_kses_post( $item_description ); ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php 
                        if ( $item_link ) : 
                        ?>
                            <div class="waarom-block__item-link mt-auto">
                                <?php kj_button( __('Lees meer', 'kj'), $item_link, 'internal', 'text'); ?>
                            </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>