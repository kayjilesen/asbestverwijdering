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
            <div class="container w-full flex justify-end items-center text-white text-sm px-4 lg:px-0">
                <div class="flex items-center gap-4 lg:gap-6">
                    <?php 
                    $phone = get_field( 'phone', 'option' ) ?: get_field( 'telefoon', 'option' );
                    if ( $phone ) : 
                    ?>
                        <a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $phone ) ); ?>" class="text-white hover:text-yellow transition-colors">
                            <?php echo esc_html( $phone ); ?>
                        </a>
                    <?php endif; ?>
                    
                    <?php if ( get_field( 'email', 'option' ) ) : ?>
                        <a href="mailto:<?php echo esc_attr( get_field( 'email', 'option' ) ); ?>" class="text-white hover:text-yellow transition-colors">
                            <?php echo esc_html( get_field( 'email', 'option' ) ); ?>
                        </a>
                    <?php endif; ?>
                    
                    <!-- Particulier / Zakelijk Switch -->
                    <div class="topbar-switch flex items-center border border-white px-1 py-1 rounded-[0px]">
                        <?php
                        $zakelijk_link = get_field( 'topbar_zakelijk_link', 'option' );
                        ?>
                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>"
                           class="topbar-switch-item topbar-switch-particulier px-3 py-1 bg-white text-grey text-sm transition-colors">
                            <?php _e( 'Particulier', 'kj' ); ?>
                        </a>
                        <a href="<?php echo esc_url( $zakelijk_link ?: '#' ); ?>"
                           class="topbar-switch-item topbar-switch-zakelijk px-3 py-1 text-white text-sm transition-colors <?php echo !$zakelijk_link ? 'pointer-events-none opacity-50' : ''; ?>"
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
                    <div class="hidden lg:flex items-center gap-6">
                        <?php kj_nav('primary-menu', 'Hoofdmenu'); ?>
                        
                        <!-- CTA Button -->
                        <?php 
                        $header_cta = get_field('header_cta_button', 'option');
                        if ( $header_cta ) : 
                            kj_render_button($header_cta);
                        endif; 
                        ?>
                        
                        <!-- Offerte Button -->
                        <?php
                        $contact_page = get_field('page_contact', 'option');
                        if ( $contact_page ) :
                            kj_button(__('Vraag offerte aan', 'kj'), $contact_page, 'internal', 'primary blue');
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
                <?php kj_nav('mobile-menu', 'Mobile menu'); ?>
            </div>
        </div>
    </header>
    <!-- Header Margin Spacer -->
    <div class="header-marge min-h-[134px]"></div>