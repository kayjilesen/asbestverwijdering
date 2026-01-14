<?php
/**
 * Route Block
 * 
 * @package asbestverwijdering
 * @version 1.0.0
 * @author Kay Jilesen
 */

defined( 'ABSPATH' ) || exit;

$title = get_sub_field( 'title' );
$button = get_sub_field( 'button' );
$google_maps = get_sub_field( 'google_maps' );

$bedrijfsnaam = get_field('bedrijfsnaam', 'option');
$adres = get_field('adres', 'option');
$postcode = get_field('postcode', 'option');
$plaats = get_field('plaats', 'option');
$land = get_field('land', 'option');
$telefoon = get_field('telefoon', 'option');
$email = get_field('email', 'option');

$kvk = get_field('kvk', 'option');
$btw = get_field('btw', 'option');
$iban = get_field('iban', 'option');
$sca = get_field('sca', 'option');
?>

<section class="route-block section-mg">
    <div class="route-block__container container">
        <div class="route-block__wrapper grid grid-cols-1 lg:grid-cols-12 xl:grid-cols-10 gap-4 items-start">
            
            <!-- Text Content Column -->
            <div class="route-block__content w-full bg-secondary col-span-1 lg:col-span-6 xl:col-span-4 p-4 md:p-6 lg:p-8 h-full flex flex-col justify-between">
                <div class="top-content flex flex-col justify-between">
                    
                    <?php if ( $title ) : ?>
                        <h2 class="route-block__title text-3xl md:text-4xl lg:text-5xl uppercase font-title font-bold mb-6 lg:mb-8 text-white"><?php echo esc_html( $title ); ?></h2>
                    <?php endif; ?>

                    <?php if($kvk || $btw || $iban || $sca) : ?>
                        <div class="route-block-info flex flex-row gap-4 md:gap-5 text-white mb-6">
                            <div class="svg-wrapper">
                                <svg class="size-[18px] fill-white translate-y-1" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M7.90187 6.1459H9.65784V4.38993H7.90187V6.1459ZM8.77986 15.8037C4.90794 15.8037 1.75597 12.6518 1.75597 8.77986C1.75597 4.90794 4.90794 1.75597 8.77986 1.75597C12.6518 1.75597 15.8037 4.90794 15.8037 8.77986C15.8037 12.6518 12.6518 15.8037 8.77986 15.8037ZM8.77986 0C7.62687 0 6.48517 0.227098 5.41995 0.668327C4.35473 1.10956 3.38685 1.75628 2.57156 2.57156C0.925018 4.2181 0 6.4513 0 8.77986C0 11.1084 0.925018 13.3416 2.57156 14.9882C3.38685 15.8034 4.35473 16.4502 5.41995 16.8914C6.48517 17.3326 7.62687 17.5597 8.77986 17.5597C11.1084 17.5597 13.3416 16.6347 14.9882 14.9882C16.6347 13.3416 17.5597 11.1084 17.5597 8.77986C17.5597 7.62687 17.3326 6.48517 16.8914 5.41995C16.4502 4.35473 15.8034 3.38685 14.9882 2.57156C14.1729 1.75628 13.205 1.10956 12.1398 0.668327C11.0745 0.227098 9.93285 0 8.77986 0V0ZM7.90187 13.1698H9.65784V7.90187H7.90187V13.1698Z" fill="inheritColor"/></svg>
                            </div>
                            <div class="info-wrapper flex flex-col gap-0.75">
                                <?php if($kvk) : ?>
                                    <p class="font-normal font-sans mb-2">KvK: <?php echo esc_html($kvk); ?></p>
                                <?php endif; ?>
                                <?php if($btw) : ?>
                                    <p class="font-normal font-sans mb-2">BTW: <?php echo esc_html($btw); ?></p>
                                <?php endif; ?>
                                <?php if($iban) : ?>
                                    <p class="font-normal font-sans mb-2">IBAN: <?php echo esc_html($iban); ?></p>
                                <?php endif; ?>
                                <?php if($sca) : ?>
                                    <p class="font-normal font-sans mb-2">SCA: <?php echo esc_html($sca); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($bedrijfsnaam || $adres || $postcode || $plaats || $land) : ?>

                        <div class="route-block-info flex flex-row gap-4 md:gap-5 text-white">
                            <div class="svg-wrapper">
                                <svg class="size-[18px] fill-white translate-y-1" viewBox="0 0 14 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6.56641 0C10.1929 1.49442e-05 13.1328 2.9399 13.1328 6.56641C13.1328 9.46785 9.06749 16.1393 7.31934 18.874C7.15531 19.1303 6.87169 19.286 6.56738 19.2861C6.26242 19.2875 5.97783 19.1315 5.81445 18.874C4.06543 16.1402 2.58294e-05 9.46787 0 6.56641C0 2.9399 2.9399 0 6.56641 0ZM6.56641 3.12695C4.84082 3.12695 3.44165 4.52545 3.44141 6.25098C3.44141 7.97671 4.84067 9.37598 6.56641 9.37598C8.29201 9.37583 9.69043 7.97662 9.69043 6.25098C9.69018 4.52554 8.29186 3.1271 6.56641 3.12695Z" fill="inheritColor"/></svg>
                            </div>
                            <div class="info-wrapper flex flex-col gap-0.75">
                                <?php if($bedrijfsnaam) : ?>
                                    <p class="font-normal mb-2"><?php echo esc_html($bedrijfsnaam); ?></p>
                                <?php endif; ?>
                                <?php if($adres) : ?>
                                    <p class="font-normal mb-2"><?php echo esc_html($adres); ?></p>
                                <?php endif; ?>
                                <?php if($postcode && $plaats) : ?>
                                    <p class="font-normal mb-2"><?php echo esc_html($postcode); ?> <?php echo esc_html($plaats); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                </div>
                
                <?php if ( $button ) : ?>
                    <div class="route-block__button">
                        <?php 
                        global $button_data;
                        $button_data = $button;
                        kj_component( 'button', 'button', true );
                        ?>
                    </div>
                <?php endif; ?>
            </div>
            
            <!-- Google Maps iframe Column -->
            <?php if ( $google_maps ) : ?>
                <div class="route-block__map-wrapper bg-secondary w-full col-span-1 lg:col-span-6 xl:col-span-6 p-4 md:p-6 lg:p-8">
                    <div class="route-block__map-container overflow-hidden aspect-video">
                        <?php echo wp_kses( $google_maps, array(
                            'iframe' => array(
                                'src' => array(),
                                'width' => array(),
                                'height' => array(),
                                'frameborder' => array(),
                                'style' => array(),
                                'allowfullscreen' => array(),
                                'loading' => array(),
                                'referrerpolicy' => array(),
                                'class' => array(),
                                'id' => array(),
                            ),
                        ) ); ?>
                    </div>
                </div>
            <?php endif; ?>
            
        </div>
    </div>
</section>

