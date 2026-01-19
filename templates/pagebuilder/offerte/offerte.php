<?php
/**
 * Offerte Block
 * 
 * Desktop: Titel + tekst boven (50% 50%), Geel blok met formulier (volle breedte)
 * 
 * @package asbestverwijdering
 * @version 1.0.0
 * @author Kay Jilesen
 */

defined( 'ABSPATH' ) || exit;

$use_default = (bool) get_sub_field( 'mode' );

if ( $use_default ) {
    $title = get_field( 'offerte_default_title', 'option' );
    $text = get_field( 'offerte_default_text', 'option' );
    $form_title = get_field( 'offerte_default_form_title', 'option' );
    $form_subtitle = get_field( 'offerte_default_form_subtitle', 'option' );
    $form_checks = get_field( 'offerte_default_form_checks', 'option' );
    $form_shortcode = get_field( 'offerte_default_form_shortcode', 'option' );
} else {
    $title = get_sub_field( 'title' ) ?: get_field( 'offerte_default_title', 'option' );
    $text = get_sub_field( 'text' ) ?: get_field( 'offerte_default_text', 'option' );
    $form_title = get_sub_field( 'form_title' ) ?: get_field( 'offerte_default_form_title', 'option' );
    $form_subtitle = get_sub_field( 'form_subtitle' ) ?: get_field( 'offerte_default_form_subtitle', 'option' );
    $form_checks = get_sub_field( 'form_checks' ) ?: get_field( 'offerte_default_form_checks', 'option' );
    $form_shortcode = get_sub_field( 'form_shortcode' ) ?: get_field( 'offerte_default_form_shortcode', 'option' );
}

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

<section class="offerte-block <?php echo esc_attr( $padding_class ); ?> <?php echo esc_attr( $bg_class ); ?>">
    <div class="offerte-block__container container">
        
        <!-- Title + Text Above Yellow Block -->
        <?php if ( $title || $text ) : ?>
            <div class="offerte-block__header grid grid-cols-1 lg:grid-cols-2 gap-4 md:gap-8 mb-8 lg:mb-12">
                <?php if ( $title ) : ?>
                    <div class="offerte-block__title-wrapper">
                        <h2 class="offerte-block__title text-2xl md:text-4xl lg:text-5xl font-title uppercase font-bold text-grey-dark highlight-strong">
                            <?php echo wp_kses_post( $title ); ?>
                        </h2>
                    </div>
                <?php endif; ?>
                
                <?php if ( $text ) : ?>
                    <div class="offerte-block__text-wrapper">
                        <div class="offerte-block__text text-wrapper text-grey-dark">
                            <?php echo wp_kses_post( $text ); ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        
        <!-- Yellow Block with Form - Full Width -->
        <div class="offerte-block__form-wrapper bg-primary p-6 md:p-8 lg:p-10 lg:px-16 xl:px-20 md:pb-2 lg:pb-4 rounded-[8px] flex flex-col">
            
            <!-- Form Title, Subtitle and Checks - Above Form -->
            <div class="offerte-block__form-header mb-6">
                <?php if ( $form_title ) : ?>
                    <h3 class="offerte-block__form-title text-2xl md:text-3xl font-title font-bold text-grey-dark mb-3">
                        <?php echo wp_kses_post( $form_title ); ?>
                    </h3>
                <?php endif; ?>
                
                <?php if ( $form_subtitle ) : ?>
                    <p class="offerte-block__form-subtitle font-light text-sm text-grey-dark mb-4">
                        <?php echo wp_kses_post( $form_subtitle ); ?>
                    </p>
                <?php endif; ?>
                
                <?php if ( $form_checks ) : ?>
                    <ul class="offerte-block__form-checks flex flex-row items-start flex-wrap gap-2 md:gap-4">
                        <?php foreach ( $form_checks as $check ) : ?>
                            <?php if ( ! empty( $check['text'] ) ) : ?>
                                <li class="flex items-center gap-2">
                                    <div class="offerte-block__check-wrapper bg-grey-dark w-[12px] h-[12px] md:w-4 md:h-4 rounded-[3px] flex items-center justify-center flex-shrink-0 mt-0.5">
                                        <svg class="size-2 md:size-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>
                                    <span class="text-grey-dark text-xs md:text-sm font-medium"><?php echo esc_html( $check['text'] ); ?></span>
                                </li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
            
            <!-- Form -->
            <?php if ( $form_shortcode ) : ?>
                <div class="offerte-block__form flex-grow">
                    <div class="gform-on-yellow-bg gform-offerte">
                        <?php echo do_shortcode( wp_kses_post( $form_shortcode ) ); ?>
                    </div>
                </div>
            <?php endif; ?>
            
        </div>
        
    </div>
</section>
