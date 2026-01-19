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
$form_title = get_sub_field( 'form_title' );
$form_subtitle = get_sub_field( 'form_subtitle' );
$form_checks = get_sub_field( 'form_checks' );
$form_shortcode = get_sub_field( 'form_shortcode' );
$form_button = get_sub_field( 'form_button' );
$usps = get_sub_field( 'usps' );

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

// Add margin bottom to section
$padding_class .= ' mb-8 lg:mb-20';
?>

<section class="hero-offerte-block <?php echo esc_attr( $padding_class ); ?> <?php echo esc_attr( $bg_class ); ?>">
    <div class="hero-offerte-block__container container relative">
        <div class="hero-offerte-block__wrapper grid grid-cols-1 lg:grid-cols-2 gap-4 md:gap-8 pt-8">
            
            <!-- Left: Title + Image -->
            <div class="hero-offerte-block__left order-1 lg:order-1 flex flex-col">
                <?php if ( $title ) : ?>
                    <h1 class="hero-offerte-block__title text-3xl md:text-5xl lg:text-6xl xl:text-[80px] font-title uppercase font-bold text-grey-dark mb-6 lg:mb-8 highlight-strong">
                        <?php echo wp_kses_post( $title ); ?>
                    </h1>
                <?php endif; ?>
                
                <?php if ( $image ) : ?>
                    <div class="hero-offerte-block__image-wrapper overflow-hidden rounded-[8px] flex-grow flex">
                        <?php echo wp_get_attachment_image(
                            $image['ID'],
                            'large',
                            false,
                            array(
                                'class' => 'hero-offerte-block__image w-full h-full object-cover'
                            )
                        ); ?>
                    </div>
                <?php endif; ?>
            </div>
            
            <!-- Right: Form on Yellow Background -->
            <div class="hero-offerte-block__right order-2 lg:order-2">
                <div class="hero-offerte-block__form-wrapper bg-primary p-6 md:p-8 lg:p-10 md:pb-2 lg:pb-4 rounded-[8px] lg:mt-4 mb-4 lg:mb-20 flex flex-col">
                    
                    <!-- Form Title, Subtitle and Checks - Above Form -->
                    <div class="hero-offerte-block__form-header mb-6">
                        <?php if ( $form_title ) : ?>
                            <h2 class="hero-offerte-block__form-title text-2xl md:text-3xl font-title font-bold text-grey-dark mb-3">
                                <?php echo wp_kses_post( $form_title ); ?>
                            </h2>
                        <?php endif; ?>
                        
                        <?php if ( $form_subtitle ) : ?>
                            <p class="hero-offerte-block__form-subtitle font-light text-sm text-grey-dark mb-4">
                                <?php echo wp_kses_post( $form_subtitle ); ?>
                            </p>
                        <?php endif; ?>
                        
                        <?php if ( $form_checks ) : ?>
                            <ul class="hero-offerte-block__form-checks flex flex-row items-start flex-wrap gap-2">
                                <?php foreach ( $form_checks as $check ) : ?>
                                    <?php if ( ! empty( $check['text'] ) ) : ?>
                                        <li class="flex items-start gap-2">
                                            <div class="hero-offerte-block__check-wrapper bg-grey-dark w-[12px] h-[12px] rounded-[3px] flex items-center justify-center flex-shrink-0 mt-0.5">
                                                <svg class="w-2 h-2 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                            </div>
                                            <span class="text-grey-dark text-xs font-medium"><?php echo esc_html( $check['text'] ); ?></span>
                                        </li>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Form -->
                    <?php if ( $form_shortcode ) : ?>
                        <div class="hero-offerte-block__form flex-grow">
                            <div class="gform-on-yellow-bg gform-hero-offerte">
                                <?php echo do_shortcode( wp_kses_post( $form_shortcode ) ); ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Button - Below Form -->
                    <?php if ( $form_button ) : ?>
                        <div class="hero-offerte-block__form-button mt-6">
                            <?php kj_render_button( $form_button ); ?>
                        </div>
                    <?php endif; ?>
                    
                </div>
            </div>
            
        </div>
        
        <!-- USP's - Overlapping Hero Image -->
        <?php if ( $usps ) : ?>
            <div class="hero-offerte-block__usps bg-white rounded-[8px] p-4 md:p-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                <?php foreach ( $usps as $usp ) : ?>
                    <?php if ( ! empty( $usp['icon'] ) || ! empty( $usp['title'] ) || ! empty( $usp['subtitle'] ) ) : ?>
                        <div class="hero-offerte-block__usp flex items-start gap-3">
                            <?php if ( ! empty( $usp['icon'] ) ) : ?>
                                <div class="hero-offerte-block__usp-icon flex-shrink-0">
                                    <?php echo wp_get_attachment_image(
                                        $usp['icon']['ID'],
                                        'thumbnail',
                                        false,
                                        array(
                                            'class' => 'hero-offerte-block__usp-icon-img w-8 h-8 md:w-10 md:h-10 object-contain'
                                        )
                                    ); ?>
                                </div>
                            <?php endif; ?>
                            
                            <div class="hero-offerte-block__usp-content flex-1">
                                <?php if ( ! empty( $usp['title'] ) ) : ?>
                                    <h3 class="hero-offerte-block__usp-title font-bold text-grey-dark">
                                        <?php echo esc_html( $usp['title'] ); ?>
                                    </h3>
                                <?php endif; ?>
                                
                                <?php if ( ! empty( $usp['subtitle'] ) ) : ?>
                                    <p class="hero-offerte-block__usp-subtitle text-xs text-grey-dark opacity-70">
                                        <?php echo esc_html( $usp['subtitle'] ); ?>
                                    </p>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
    </div>
</section>
