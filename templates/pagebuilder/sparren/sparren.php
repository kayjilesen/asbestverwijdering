<?php
/**
 * Sparren Block
 *
 * @package asbestverwijdering
 * @version 1.0.0
 * @author Kay Jilesen
 */

defined( 'ABSPATH' ) || exit;

$use_default = (bool) get_sub_field( 'mode' );

if ( $use_default ) {
    $title         = get_field( 'sparren_default_title', 'option' );
    $subtitle      = get_field( 'sparren_default_subtitle', 'option' );
    $form          = get_field( 'sparren_default_form_id', 'option' );
    $contact_title = get_field( 'sparren_default_contact_title', 'option' );
    $right_image   = get_field( 'sparren_default_image', 'option' );
    $openingstijden= get_field( 'sparren_default_openingstijden', 'option' );
} else {
    $title = get_sub_field( 'title' );
    $subtitle = get_sub_field( 'subtitle' );
    $form = get_sub_field( 'form' ) ?: get_field( 'sparren_default_form_id', 'option' );
    $contact_title = get_sub_field( 'contact_title' );
    $openingstijden = get_field( 'sparren_default_openingstijden', 'option' );
    $right_image = get_sub_field( 'right_image' ) ?: get_field( 'sparren_default_image', 'option' );
}

// Get contact info from options page (with fallback to sub fields)
$phone = get_field( 'telefoon', 'option' );
$email = get_field( 'email', 'option' );
$bedrijfsnaam = get_field( 'bedrijfsnaam', 'option' );
$adres = get_field( 'adres', 'option' );
$postcode = get_field( 'postcode', 'option' );
$plaats = get_field( 'plaats', 'option' );
$address = get_sub_field( 'address' );
$openingstijden = $openingstijden;
$right_image = $right_image;

// Get padding options - ACF true_false returns empty string/0 when unchecked, 1 when checked
$padding_top_value = get_sub_field( 'padding_top' );
$padding_bottom_value = get_sub_field( 'padding_bottom' );

// Get background color
$background_color = get_sub_field( 'background_color' ) ?: 'white';
$bg_class = 'bg-' . $background_color;

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

<section class="sparren-block <?php echo esc_attr( $padding_class ); ?> <?php echo esc_attr( $bg_class ); ?> w-full relative">
    <div class="sparren-block__container container relative z-[1]">
        <div class="sparren-block__wrapper grid grid-cols-1 lg:grid-cols-11 gap-4 md:gap-8 lg:gap-16 xl:gap-24">

            <div class="sparren-block__left w-full col-span-1 lg:col-span-6 flex flex-col">

                <?php if ( $title ) : ?>
                    <h2 class="sparren-block__left-title text-4xl lg:text-8xl font-title uppercase font-bold mb-6"><?php echo esc_html( $title ); ?></h2>
                <?php endif; ?>
                <?php if ( $subtitle ) : ?>
                    <p class="sparren-block__left-subtitle text-sm md:text-base text-grey-text mb-6 lg:mb-8"><?php echo esc_html( $subtitle ); ?></p>
                <?php endif; ?>

                <?php if ( $form ) : ?>
                    <div class="sparren-block__form">
                        <?php echo do_shortcode( $form ); ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Right Side (40%) -->
            <div class="sparren-block__right w-full col-span-1 lg:col-span-5 bg-primary text-white relative flex flex-col min-h-full rounded-[8px]">
                <div class="sparren-block__right-content flex-grow flex flex-col justify-between">
                    <div class="sparren-block__top-section flex flex-col p-4 md:p-6 lg:p-8">
                        <?php if ( $contact_title ) : ?>
                            <h3 class="sparren-block__right-title text-2xl md:text-3xl lg:text-5xl font-title uppercase text-grey-dark font-bold mb-6"><?php echo esc_html( $contact_title ); ?></h3>
                        <?php endif; ?>

                        <div class="sparren-block__contact-info gap-4 md:gap-6">
                            <!-- Left Column: Phone & Email -->
                            <div class="sparren-block__contact-left space-y-3 col-span-1 md:col-span-5">
                            <?php if ( $phone ) : ?>
                                    <div class="sparren-block__phone flex flex-row gap-3 md:gap-4 text-grey-dark">
                                        <div class="svg-wrapper">
                                            <svg class="size-4 fill-grey-dark translate-y-1" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M2.23371 4.8068C3.12226 6.55305 4.55381 7.9846 6.30006 8.87315L7.65756 7.51564C7.83034 7.34287 8.07098 7.2935 8.28695 7.36138C8.97804 7.58969 9.7185 7.7131 10.4898 7.7131C10.6535 7.7131 10.8104 7.77811 10.9261 7.89383C11.0418 8.00954 11.1069 8.16649 11.1069 8.33014V10.4898C11.1069 10.6535 11.0418 10.8104 10.9261 10.9261C10.8104 11.0418 10.6535 11.1069 10.4898 11.1069C7.70774 11.1069 5.03962 10.0017 3.07239 8.03446C1.10517 6.06724 0 3.39912 0 0.617048C0 0.453396 0.0650102 0.296448 0.180729 0.180729C0.296448 0.0650102 0.453396 0 0.617048 0H2.77671C2.94037 0 3.09731 0.0650102 3.21303 0.180729C3.32875 0.296448 3.39376 0.453396 3.39376 0.617048C3.39376 1.38836 3.51717 2.12881 3.74548 2.81991C3.81335 3.03587 3.76399 3.27652 3.59122 3.4493L2.23371 4.8068Z" fill="inheritColor"/></svg>
                                        </div>
                                        <a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $phone ) ); ?>" class="hover:text-secondary transition-colors text-sm">
                                        <?php echo esc_html( $phone ); ?>
                                    </a>
                                </div>
                            <?php endif; ?>

                            <?php if ( $email ) : ?>
                                    <div class="sparren-block__email flex flex-row gap-3 md:gap-4 text-grey-dark">
                                        <div class="svg-wrapper">
                                            <svg class="size-4 fill-grey-dark translate-y-1" viewBox="0 0 12 10" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M9.99617 2.31393L5.55343 5.20634L1.11069 2.31393V1.15696L5.55343 4.04938L9.99617 1.15696V2.31393ZM9.99617 0H1.11069C0.494255 0 0 0.514849 0 1.15696V8.09875C0 8.4056 0.117018 8.69988 0.325312 8.91685C0.533606 9.13382 0.816114 9.25572 1.11069 9.25572H9.99617C10.2907 9.25572 10.5733 9.13382 10.7815 8.91685C10.9898 8.69988 11.1069 8.4056 11.1069 8.09875V1.15696C11.1069 0.514849 10.6071 0 9.99617 0Z" fill="inheritColor"/></svg>
                                        </div>
                                        <a href="mailto:<?php echo esc_attr( $email ); ?>" class="hover:text-secondary transition-colors text-sm">
                                        <?php echo esc_html( $email ); ?>
                                    </a>
                                </div>
                            <?php endif; ?>

                            <?php if ( $bedrijfsnaam || $adres || $postcode || $plaats ) : ?>
                                <div class="sparren-block__address flex flex-row gap-3 md:gap-4 text-grey-dark">
                                    <div class="svg-wrapper">
                                        <svg class="size-4 fill-grey-dark translate-y-1" viewBox="0 0 14 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6.56641 0C10.1929 1.49442e-05 13.1328 2.9399 13.1328 6.56641C13.1328 9.46785 9.06749 16.1393 7.31934 18.874C7.15531 19.1303 6.87169 19.286 6.56738 19.2861C6.26242 19.2875 5.97783 19.1315 5.81445 18.874C4.06543 16.1402 2.58294e-05 9.46787 0 6.56641C0 2.9399 2.9399 0 6.56641 0ZM6.56641 3.12695C4.84082 3.12695 3.44165 4.52545 3.44141 6.25098C3.44141 7.97671 4.84067 9.37598 6.56641 9.37598C8.29201 9.37583 9.69043 7.97662 9.69043 6.25098C9.69018 4.52554 8.29186 3.1271 6.56641 3.12695Z" fill="inheritColor"/></svg>
                                    </div>
                                    <div class="info-wrapper flex flex-col gap-0.5 text-sm">
                                        <?php if ( $bedrijfsnaam ) : ?>
                                            <p class="text-grey-dark mb-1"><?php echo esc_html( $bedrijfsnaam ); ?></p>
                                        <?php endif; ?>
                                        <?php if ( $adres ) : ?>
                                            <p class="text-grey-dark mb-1"><?php echo esc_html( $adres ); ?></p>
                                        <?php endif; ?>
                                        <?php if ( $postcode && $plaats ) : ?>
                                            <p class="text-grey-dark"><?php echo esc_html( $postcode ); ?> <?php echo esc_html( $plaats ); ?></p>
                                        <?php elseif ( $postcode ) : ?>
                                            <p class="text-grey-dark"><?php echo esc_html( $postcode ); ?></p>
                                        <?php elseif ( $plaats ) : ?>
                                            <p class="text-grey-dark"><?php echo esc_html( $plaats ); ?></p>
                                        <?php endif; ?>
                                    </div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <?php if ( $right_image ) : ?>
                    <div class="sparren-block__right-image mt-auto relative w-full">
                        <div class="sparren-block__right-image-container max-w-[75%] ml-auto relative z-[1] w-full flex justify-end">
                            <?php echo wp_get_attachment_image( $right_image['ID'], 'large', false, array( 'class' => 'sparren-block__right-image-img w-full h-auto object-contain' ) ); ?>
                        </div>

                        <?php if ( $openingstijden ) : ?>
                            <div class="sparren-block__openingstijden-box absolute bottom-4 left-4 md:bottom-6 md:left-6 max-w-[calc(100%-24px)] md:max-w-[60%] bg-secondary p-4 md:p-5 z-[3]">
                                <div class="sparren-block__openingstijden-content text-primary text-sm md:text-base font-semibold">
                                    <?php echo $openingstijden; ?>
                                </div>
                            </div>
                        <?php endif; ?>

                    </div>
                <?php endif; ?>
            </div>

        </div>
    </div>
</section>
