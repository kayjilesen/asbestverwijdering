<?php
/**
 * Stappen Block
 *
 * Layout met header (titel links, tekst + buttons rechts) en een grid van genummerde stappen
 *
 * @package asbestverwijdering
 */

defined( 'ABSPATH' ) || exit;

$title       = get_sub_field( 'title' );
$description = get_sub_field( 'description' );
$buttons     = get_sub_field( 'buttons' );
$stappen     = get_sub_field( 'stappen' );

// Normalize buttons
$button_list = array();
if ( is_array( $buttons ) ) {
    foreach ( $buttons as $btn ) {
        if ( isset( $btn['button'] ) && is_array( $btn['button'] ) && ! empty( $btn['button']['button_label'] ) ) {
            $button_list[] = $btn['button'];
        } elseif ( isset( $btn['button_label'] ) && ! empty( $btn['button_label'] ) ) {
            $button_list[] = $btn;
        }
    }
}

$stappen_count = is_array( $stappen ) ? count( $stappen ) : 0;

// Get padding options
$padding_top_value    = get_sub_field( 'padding_top' );
$padding_bottom_value = get_sub_field( 'padding_bottom' );
$padding_top          = ( $padding_top_value === null ) ? true : ! empty( $padding_top_value );
$padding_bottom       = ( $padding_bottom_value === null ) ? true : ! empty( $padding_bottom_value );

// Set padding classes
$padding_classes = array();
if ( $padding_top ) {
    $padding_classes[] = 'pt-20 lg:pt-[120px]';
}
if ( $padding_bottom ) {
    $padding_classes[] = 'pb-20 lg:pb-[120px]';
}
$padding_class = ! empty( $padding_classes ) ? implode( ' ', $padding_classes ) : '';

if ( ! $title && ! $description && ! $stappen_count ) {
    return;
}
?>

<section class="stappen-block relative z-[2] <?php echo esc_attr( $padding_class ); ?> bg-beige-darker">
    <div class="stappen-block__container container">

        <!-- Header -->
        <div class="stappen-block__header flex flex-col lg:flex-row lg:items-start lg:justify-between gap-8 lg:gap-16 mb-12 lg:mb-16 relative z-[3]">

            <!-- Left: Title -->
            <?php if ( $title ) : ?>
                <div class="stappen-block__header-left lg:w-1/2">
                    <h2 class="stappen-block__title font-title text-4xl md:text-5xl lg:text-6xl uppercase font-bold text-secondary highlight-strong"><?php echo wp_kses_post( $title ); ?></h2>
                </div>
            <?php endif; ?>

            <!-- Right: Description + Buttons -->
            <div class="stappen-block__header-right lg:w-1/2">
                <?php if ( $description ) : ?>
                    <div class="stappen-block__description text-grey-text text-base md:text-lg leading-relaxed text-wrapper mb-6">
                        <?php echo wp_kses_post( nl2br( $description ) ); ?>
                    </div>
                <?php endif; ?>

                <?php if ( ! empty( $button_list ) ) : ?>
                    <div class="stappen-block__buttons flex flex-wrap gap-3">
                        <?php foreach ( $button_list as $btn ) : ?>
                            <?php kj_render_button( $btn ); ?>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

        </div>

        <!-- Stappen Grid -->
        <?php if ( $stappen_count ) : ?>
            <div class="stappen-block__grid relative grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-5 p-4 md:p-5 bg-[#F7F7F2] rounded-[10px] z-[3]">
                <?php foreach ( $stappen as $index => $stap ) :
                    $stap_title = $stap['title'] ?? '';
                    $stap_text  = $stap['text'] ?? '';
                    $nummer     = $index + 1;
                ?>
                    <div class="stappen-block__item text-center bg-[#F0F0EC] rounded-[8px] p-4 md:p-6">
                        <!-- STAP label -->
                        <div class="stappen-block__label font-title text-sm md:text-base uppercase font-bold text-secondary -mb-3 relative z-[2]">
                            <?php esc_html_e( 'STAP', 'kj' ); ?>
                        </div>
                        
                        <!-- Nummer -->
                        <div class="relative inline-block mb-4 z-[1]">
                            <div class="absolute top-[42%] left-1/2 -translate-x-1/2 -translate-y-1/2 rotate-[4deg] bg-primary w-[68px] h-[73px] rounded-[2.5px] z-0"></div>
                            <span class="font-title text-5xl md:text-6xl lg:text-[80px] font-bold text-secondary relative z-10 inline-block !leading-[1]">
                                <?php echo esc_html( $nummer ); ?>
                            </span>
                        </div>

                        <!-- Titel -->
                        <?php if ( $stap_title ) : ?>
                            <h3 class="stappen-block__item-title relative block mb-3 z-[1] highlight-strong">
                                <div class="relative inline-block">
                                    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 -rotate-[2deg] bg-primary w-[calc(100%+8px)] h-3 md:h-4 rounded-sm z-0"></div>
                                    <span class="font-title text-xl md:text-2xl uppercase font-bold text-secondary relative z-10 inline-block">
                                        <?php echo wp_kses_post( $stap_title ); ?>
                                    </span>
                                </div>
                            </h3>
                        <?php endif; ?>

                        <!-- Tekst -->
                        <?php if ( $stap_text ) : ?>
                            <div class="stappen-block__item-text text-grey-text text-base leading-relaxed">
                                <?php echo wp_kses_post( nl2br( $stap_text ) ); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
            
        <?php endif; ?>

    </div>

    <!-- Decorative SVG - Left top (half above the grid, aligned to left edge) -->
    <div class="stappen-block__svg stappen-block__svg--left absolute left-0 top-0 h-[85px] w-auto z-[0] hidden lg:block translate-y-[300%]">
        <svg width="421" height="85" viewBox="0 0 421 85" fill="none" xmlns="http://www.w3.org/2000/svg" class="h-full w-auto">
            <rect x="-50.0605" y="1" width="469.792" height="82.99" rx="6" stroke="#FFD500" stroke-width="2"/>
        </svg>
    </div>
    
    <!-- Decorative SVG - Right (same as text-image with image right) -->
    <div class="stappen-block__svg stappen-block__svg--right absolute right-0 bottom-20 lg:bottom-[120px] h-[107px] translate-y-1/2 w-auto z-0 hidden lg:block">
        <svg width="317" height="108" viewBox="0 0 317 108" fill="none" xmlns="http://www.w3.org/2000/svg" class="h-full w-auto">
            <rect x="1" y="1" width="401.97" height="105.433" rx="6" stroke="#FFD500" stroke-width="2"/>
        </svg>
    </div>
</section>
