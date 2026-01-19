<!doctype html>
<html <?php language_attributes(); ?> class="no-js overflow-x-hidden w-full">
	<head>
		<meta charset="<?php bloginfo('charset'); ?>">
		<title><?php wp_title(''); ?><?php if(wp_title('', false)) { echo ' -'; } ?> <?php bloginfo('name'); ?></title>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
		<?php wp_head(); ?>
    </head>
    <body id="page-top" <?php body_class('bg-beige max-w-full overflow-x-hidden'); ?>>
    <header id="masthead" class="site-header color fixed top-0 left-0 right-0 z-50">
        <!-- Top Bar -->
        <div id="topbar" class="top-bar bg-grey-dark h-auto py-2 flex items-center">
            <div class="container w-full flex justify-end items-center text-white text-xs px-4 lg:px-0">
                <!-- Mobile Swiper -->
                <div class="topbar-mobile lg:hidden w-full">
                    <div class="swiper js-topbar-swiper">
                        <div class="swiper-wrapper">
                            <?php 
                            $phone = get_field( 'phone', 'option' ) ?: get_field( 'telefoon', 'option' );
                            $email = get_field( 'email', 'option' );
                            if ( $phone || $email ) : 
                            ?>
                                <!-- Slide 1: Telefoon & Email -->
                                <div class="swiper-slide">
                                    <div class="flex items-center justify-center gap-4">
                                        <?php if ( $phone ) : ?>
                                            <a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $phone ) ); ?>" class="text-white hover:text-yellow transition-colors flex items-center gap-2">
                                                <svg width="12" height="12" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg" class="fill-current">
                                                    <path d="M1.56617 3.3703C2.18918 4.59468 3.19291 5.59842 4.4173 6.22142L5.36911 5.26961C5.49026 5.14847 5.65899 5.11386 5.81041 5.16145C6.29497 5.32152 6.81415 5.40805 7.35495 5.40805C7.4697 5.40805 7.57974 5.45364 7.66088 5.53477C7.74201 5.61591 7.7876 5.72595 7.7876 5.8407V7.35495C7.7876 7.4697 7.74201 7.57974 7.66088 7.66088C7.57974 7.74201 7.4697 7.7876 7.35495 7.7876C5.4043 7.7876 3.53354 7.0127 2.15422 5.63338C0.774894 4.25406 0 2.3833 0 0.432644C0 0.3179 0.045582 0.207855 0.126719 0.126719C0.207855 0.045582 0.3179 0 0.432644 0H1.9469C2.06164 0 2.17169 0.045582 2.25282 0.126719C2.33396 0.207855 2.37954 0.3179 2.37954 0.432644C2.37954 0.97345 2.46607 1.49262 2.62615 1.97718C2.67374 2.12861 2.63913 2.29734 2.51799 2.41848L1.56617 3.3703Z"/>
                                                </svg>
                                                <?php echo esc_html( $phone ); ?>
                                            </a>
                                            <?php if ( $email ) : ?>
                                                <span class="h-4 w-px bg-white/30"></span>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                        
                                        <?php if ( $email ) : ?>
                                            <a href="mailto:<?php echo esc_attr( $email ); ?>" class="text-white hover:text-yellow transition-colors flex items-center gap-2">
                                                <svg width="12" height="12" viewBox="0 0 10 8" fill="none" xmlns="http://www.w3.org/2000/svg" class="fill-current">
                                                    <path d="M8.24552 1.83234L4.58084 4.12276L0.916169 1.83234V0.916169L4.58084 3.20659L8.24552 0.916169V1.83234ZM8.24552 0H0.916169C0.407695 0 0 0.407695 0 0.916169V6.41318C0 6.65616 0.0965246 6.8892 0.26834 7.06101C0.440155 7.23283 0.673186 7.32935 0.916169 7.32935H8.24552C8.4885 7.32935 8.72153 7.23283 8.89335 7.06101C9.06516 6.8892 9.16169 6.65616 9.16169 6.41318V0.916169C9.16169 0.407695 8.74941 0 8.24552 0Z"/>
                                                </svg>
                                                <?php echo esc_html( $email ); ?>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                            
                            <?php
                            // Get vacatures count and link
                            $vacatures_count = wp_count_posts( 'vacature' )->publish;
                            $werken_bij_page = get_field( 'page_werken_bij', 'option' );
                            $vacatures_url = $werken_bij_page ? get_permalink( $werken_bij_page->ID ) : '';
                            if ( $vacatures_url && $vacatures_count > 0 ) :
                            ?>
                                <!-- Slide 2: Bekijk vacatures -->
                                <div class="swiper-slide">
                                    <div class="flex items-center justify-center">
                                        <a href="<?php echo esc_url( $vacatures_url ); ?>" class="text-white hover:text-yellow transition-colors relative inline-block">
                                            <?php _e( 'Bekijk onze vacatures', 'kj' ); ?>
                                            <span class="absolute -top-1 -right-3 bg-yellow text-grey-dark text-[10px] font-bold rounded-full min-w-[14px] h-3.5 flex items-center justify-center leading-none px-0.5"><?php echo esc_html( $vacatures_count ); ?></span>
                                        </a>
                                    </div>
                                </div>
                            <?php endif; ?>
                            
                            <!-- Slide 3: Particulier / Zakelijk Switch -->
                            <div class="swiper-slide">
                                <div class="flex items-center justify-center gap-2">
                                    <span class="text-white text-xs"><?php _e( 'Wissel naar:', 'kj' ); ?></span>
                                    <div class="topbar-switch flex items-center border border-white/30 px-1 py-1 rounded">
                                        <?php
                                        $zakelijk_link = get_field( 'topbar_zakelijk_link', 'option' );
                                        ?>
                                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>"
                                           class="topbar-switch-item topbar-switch-particulier px-3 py-1 bg-white text-grey text-xs transition-colors">
                                            <?php _e( 'Particulier', 'kj' ); ?>
                                        </a>
                                        <a href="<?php echo esc_url( $zakelijk_link ?: '#' ); ?>"
                                           class="topbar-switch-item topbar-switch-zakelijk px-3 py-1 text-white text-xs transition-colors <?php echo !$zakelijk_link ? 'pointer-events-none opacity-50' : ''; ?>"
                                           <?php echo $zakelijk_link ? 'target="_blank" rel="noopener noreferrer"' : ''; ?>>
                                            <?php _e( 'Zakelijk', 'kj' ); ?>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Desktop View -->
                <div class="hidden lg:flex items-center gap-4 lg:gap-6">
                    <?php 
                    if ( $phone ) : 
                    ?>
                        <a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $phone ) ); ?>" class="text-white hover:text-yellow transition-colors flex items-center gap-2">
                            <svg width="12" height="12" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg" class="fill-current">
                                <path d="M1.56617 3.3703C2.18918 4.59468 3.19291 5.59842 4.4173 6.22142L5.36911 5.26961C5.49026 5.14847 5.65899 5.11386 5.81041 5.16145C6.29497 5.32152 6.81415 5.40805 7.35495 5.40805C7.4697 5.40805 7.57974 5.45364 7.66088 5.53477C7.74201 5.61591 7.7876 5.72595 7.7876 5.8407V7.35495C7.7876 7.4697 7.74201 7.57974 7.66088 7.66088C7.57974 7.74201 7.4697 7.7876 7.35495 7.7876C5.4043 7.7876 3.53354 7.0127 2.15422 5.63338C0.774894 4.25406 0 2.3833 0 0.432644C0 0.3179 0.045582 0.207855 0.126719 0.126719C0.207855 0.045582 0.3179 0 0.432644 0H1.9469C2.06164 0 2.17169 0.045582 2.25282 0.126719C2.33396 0.207855 2.37954 0.3179 2.37954 0.432644C2.37954 0.97345 2.46607 1.49262 2.62615 1.97718C2.67374 2.12861 2.63913 2.29734 2.51799 2.41848L1.56617 3.3703Z"/>
                            </svg>
                            <?php echo esc_html( $phone ); ?>
                        </a>
                        <?php if ( $email ) : ?>
                            <span class="h-4 w-px bg-white/30"></span>
                        <?php endif; ?>
                    <?php endif; ?>
                    
                    <?php if ( $email ) : ?>
                        <a href="mailto:<?php echo esc_attr( $email ); ?>" class="text-white hover:text-yellow transition-colors flex items-center gap-2">
                            <svg width="12" height="12" viewBox="0 0 10 8" fill="none" xmlns="http://www.w3.org/2000/svg" class="fill-current">
                                <path d="M8.24552 1.83234L4.58084 4.12276L0.916169 1.83234V0.916169L4.58084 3.20659L8.24552 0.916169V1.83234ZM8.24552 0H0.916169C0.407695 0 0 0.407695 0 0.916169V6.41318C0 6.65616 0.0965246 6.8892 0.26834 7.06101C0.440155 7.23283 0.673186 7.32935 0.916169 7.32935H8.24552C8.4885 7.32935 8.72153 7.23283 8.89335 7.06101C9.06516 6.8892 9.16169 6.65616 9.16169 6.41318V0.916169C9.16169 0.407695 8.74941 0 8.24552 0Z"/>
                            </svg>
                            <?php echo esc_html( $email ); ?>
                        </a>
                        <span class="h-4 w-px bg-white/30"></span>
                    <?php endif; ?>
                    
                    <?php
                    if ( $vacatures_url && $vacatures_count > 0 ) :
                    ?>
                        <a href="<?php echo esc_url( $vacatures_url ); ?>" class="text-white hover:text-yellow transition-colors relative inline-block">
                            <?php _e( 'Bekijk onze vacatures', 'kj' ); ?>
                            <span class="absolute -top-1 -right-3 bg-yellow text-grey-dark text-[10px] font-bold rounded-full min-w-[14px] h-3.5 flex items-center justify-center leading-none px-0.5"><?php echo esc_html( $vacatures_count ); ?></span>
                        </a>
                        <span class="h-4 w-px bg-white/30"></span>
                    <?php endif; ?>
                    
                    <!-- Particulier / Zakelijk Switch -->
                    <span class="text-white text-xs"><?php _e( 'Wissel naar:', 'kj' ); ?></span>
                    <div class="topbar-switch flex items-center border border-white/30 px-1 py-1 rounded">
                        <?php
                        $zakelijk_link = get_field( 'topbar_zakelijk_link', 'option' );
                        ?>
                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>"
                           class="topbar-switch-item topbar-switch-particulier px-3 py-1 bg-white text-grey text-xs transition-colors">
                            <?php _e( 'Particulier', 'kj' ); ?>
                        </a>
                        <a href="<?php echo esc_url( $zakelijk_link ?: '#' ); ?>"
                           class="topbar-switch-item topbar-switch-zakelijk px-3 py-1 text-white text-xs transition-colors <?php echo !$zakelijk_link ? 'pointer-events-none opacity-50' : ''; ?>"
                           <?php echo $zakelijk_link ? 'target="_blank" rel="noopener noreferrer"' : ''; ?>>
                            <?php _e( 'Zakelijk', 'kj' ); ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Header -->
        <div id="main-header" class="main-bar bg-beige transition-all duration-300">
            <div class="container px-4 lg:px-0">
                <nav class="flex items-center justify-between py-4">
                    <!-- Logo -->
                    <div class="logo">
                        <a href="<?php echo home_url(); ?>" class="flex items-center gap-2">
                            <?php if ( get_field('logo_kleur', 'option') ) : ?>
                                <?php 
                                $logo_kleur = get_field('logo_kleur', 'option');
                                echo '<img src="' . esc_url($logo_kleur['url']) . '" alt="' . esc_attr($logo_kleur['alt']) . '" class="logo-color h-auto max-h-10 object-contain">';
                                ?>
                            <?php endif; ?>
                        </a>
                    </div>

                    <!-- Desktop Navigation -->
                    <div class="hidden lg:flex items-center">
                        <?php kj_nav('primary-menu', __( 'Hoofdmenu', 'kj' )); ?>
                        
                        <!-- CTA Button -->
                        <?php 
                        $header_cta = get_field('header_cta_button', 'option');
                        if ( $header_cta ) : 
                            kj_render_button($header_cta);
                        endif; 
                        ?>
                        
                        <!-- Offerte Button -->
                        <?php
                        $offerte_page = get_field('page_offerte_aanvragen', 'option');
                        if ( $offerte_page ) :
                            kj_button(__('Vraag offerte aan', 'kj'), $offerte_page, 'internal', 'primary blue');
                        endif;
                        ?>
                    </div>

                    <!-- Mobile Menu Button -->
                    <button class="toggle-menu mobile-nav-button lg:hidden p-2" id="toggle-menu" aria-label="Toggle menu">
                        <div class="flex flex-col gap-1.5">
                            <div class="navbar-bar bar1 w-6 h-0.5 bg-grey-dark transition-all duration-300"></div>
                            <div class="navbar-bar bar2 w-6 h-0.5 bg-grey-dark transition-all duration-300"></div>
                            <div class="navbar-bar bar3 w-6 h-0.5 bg-grey-dark transition-all duration-300"></div>
                        </div>
                    </button>
                </nav>
            </div>
        </div>

        <!-- Mobile Menu Overlay -->
        <div class="mobile-menu-overlay lg:hidden fixed inset-0 bg-black/50 z-[85] opacity-0 pointer-events-none transition-opacity duration-300"></div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="lg:hidden w-full max-w-sm h-screen fixed right-0 top-0 z-[90] bg-green-dark transform translate-x-full transition-transform duration-300 ease-in-out">
            <div class="p-4 md:p-8">
                <div class="flex justify-end items-center mb-8">
                    <button class="toggle-menu close-nav-button bg-yellow w-10 h-10 p-2 group" id="close-menu" aria-label="Close menu">
                        <svg class="w-6 h-6 fill-grey-dark duration-300 ease-in-out group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <?php kj_nav('mobile-menu', __( 'Mobiel menu', 'kj' )); ?>
            </div>
        </div>
    </header>
    <!-- Header Margin Spacer -->
    <div class="header-marge min-h-[134px]"></div>