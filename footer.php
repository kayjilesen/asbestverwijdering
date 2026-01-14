<?php
/**
 * Footer Template
 * 
 * @package asbestverwijdering
 * @version 1.0.0
 * @author Kay Jilesen
 */

defined( 'ABSPATH' ) || exit;
?>

	</main><!-- #main -->

	<footer class="site-footer bg-secondary text-white">
		
		<div class="container py-16 md:py-24">
			<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-12">
				
				<?php
				// Column 1: Logo Wit
				$footer_logo_wit = get_field('logo_wit', 'option') ?: get_field('logo_kleur', 'option');
				?>
				<?php if ( $footer_logo_wit ) : ?>
				<!-- Column 1: Logo Wit -->
				<div class="footer-col">
					<div class="mb-4">
						<img src="<?php echo esc_url( $footer_logo_wit['url'] ); ?>" alt="<?php echo esc_attr( $footer_logo_wit['alt'] ?: 'Logo' ); ?>" class="h-auto max-h-12 object-contain">
					</div>
				</div>
				<?php endif; ?>
				
				<?php
				// Column 2: Diensten & Doelgroepen (from project taxonomies)
				$diensten = get_terms( array(
					'taxonomy'   => 'project_dienst',
					'hide_empty' => true,
					'orderby'    => 'name',
					'order'      => 'ASC',
				) );
				$doelgroepen = get_terms( array(
					'taxonomy'   => 'project_doelgroep',
					'hide_empty' => true,
					'orderby'    => 'name',
					'order'      => 'ASC',
				) );
				$has_diensten = !is_wp_error( $diensten ) && !empty( $diensten );
				$has_doelgroepen = !is_wp_error( $doelgroepen ) && !empty( $doelgroepen );
				?>
				<?php if ( $has_diensten || $has_doelgroepen ) : ?>
				<!-- Column 2: Diensten & Doelgroepen -->
				<div class="footer-col">
					<?php if ( $has_diensten ) : ?>
						<h4 class="footer-title mb-4"><?php _e( 'Asbest & Sloop', 'kj' ); ?></h4>
						<ul class="space-y-1 mb-6">
							<?php foreach ( $diensten as $dienst ) : ?>
								<li>
									<a href="<?php echo esc_url( get_term_link( $dienst ) ); ?>" class="footer-link-underline">
										<?php echo esc_html( $dienst->name ); ?>
									</a>
								</li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>

					<?php if ( $has_doelgroepen ) : ?>
						<h4 class="footer-title mb-4"><?php _e( 'Voor wie?', 'kj' ); ?></h4>
						<ul class="space-y-1">
							<?php foreach ( $doelgroepen as $doelgroep ) : ?>
								<li>
									<a href="<?php echo esc_url( get_term_link( $doelgroep ) ); ?>" class="footer-link-underline">
										<?php echo esc_html( $doelgroep->name ); ?>
									</a>
								</li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>
				</div>
				<?php endif; ?>

				<?php
				// Column 3: Footer Menu
				$footer_menu = wp_get_nav_menu_object( 'Footermenu' );
				$has_navigation = $footer_menu && wp_get_nav_menu_items( $footer_menu->term_id );
				?>
				<?php if ( $has_navigation ) : ?>
				<!-- Column 3: Footer Menu -->
				<div class="footer-col">
					<h4 class="footer-title mb-4"><?php _e( 'Menu', 'kj' ); ?></h4>
					<?php kj_nav( 'footer-menu', 'Footermenu' ); ?>
				</div>
				<?php endif; ?>
				
				<?php
				// Column 4: Contactgegevens (uit Algemeen options page)
				$bedrijfsnaam = get_field('bedrijfsnaam', 'option');
				$adres = get_field('adres', 'option');
				$postcode = get_field('postcode', 'option');
				$plaats = get_field('plaats', 'option');
				$land = get_field('land', 'option');
				$telefoon = get_field('telefoon', 'option');
				$email = get_field('email', 'option');
				$footer_route_button = get_field('footer_route_button', 'option');
				$route_link = get_field('route_link', 'option');
				
				$has_contact = !empty($bedrijfsnaam) || !empty($adres) || !empty($postcode) || 
				               !empty($plaats) || !empty($land) || !empty($email) || !empty($telefoon);
				?>
				<?php if ( $has_contact ) : ?>
				<div class="footer-col">	
						<h4 class="footer-title mb-4"><?php echo esc_html($bedrijfsnaam); ?></h4>
											
						<?php if (!empty($telefoon)) : ?>
							<div class="footer-block-info flex flex-row gap-4 md:gap-5 text-white mb-4">
								<div class="svg-wrapper">
									<svg class="size-[18px] fill-white translate-y-1" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M2.23371 4.8068C3.12226 6.55305 4.55381 7.9846 6.30006 8.87315L7.65756 7.51564C7.83034 7.34287 8.07098 7.2935 8.28695 7.36138C8.97804 7.58969 9.7185 7.7131 10.4898 7.7131C10.6535 7.7131 10.8104 7.77811 10.9261 7.89383C11.0418 8.00954 11.1069 8.16649 11.1069 8.33014V10.4898C11.1069 10.6535 11.0418 10.8104 10.9261 10.9261C10.8104 11.0418 10.6535 11.1069 10.4898 11.1069C7.70774 11.1069 5.03962 10.0017 3.07239 8.03446C1.10517 6.06724 0 3.39912 0 0.617048C0 0.453396 0.0650102 0.296448 0.180729 0.180729C0.296448 0.0650102 0.453396 0 0.617048 0H2.77671C2.94037 0 3.09731 0.0650102 3.21303 0.180729C3.32875 0.296448 3.39376 0.453396 3.39376 0.617048C3.39376 1.38836 3.51717 2.12881 3.74548 2.81991C3.81335 3.03587 3.76399 3.27652 3.59122 3.4493L2.23371 4.8068Z" fill="inheritColor"/></svg>
								</div>
								<a href="tel:<?php echo esc_attr($telefoon); ?>" class="footer-contact-link hover:text-primary transition-colors">
									<?php echo esc_html($telefoon); ?>
								</a>
							</div>
						<?php endif; ?>
						
						<?php if (!empty($email)) : ?>
							<div class="footer-block-info flex flex-row gap-4 md:gap-5 text-white mb-4">
								<div class="svg-wrapper">
									<svg class="size-[18px] fill-white translate-y-1" viewBox="0 0 12 10" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M9.99617 2.31393L5.55343 5.20634L1.11069 2.31393V1.15696L5.55343 4.04938L9.99617 1.15696V2.31393ZM9.99617 0H1.11069C0.494255 0 0 0.514849 0 1.15696V8.09875C0 8.4056 0.117018 8.69988 0.325312 8.91685C0.533606 9.13382 0.816114 9.25572 1.11069 9.25572H9.99617C10.2907 9.25572 10.5733 9.13382 10.7815 8.91685C10.9898 8.69988 11.1069 8.4056 11.1069 8.09875V1.15696C11.1069 0.514849 10.6071 0 9.99617 0Z" fill="inheritColor"/></svg>
								</div>
								<a href="mailto:<?php echo esc_attr($email); ?>" class="footer-contact-link hover:text-primary transition-colors">
									<?php echo esc_html($email); ?>
								</a>
							</div>
						<?php endif; ?>

						<?php if ($adres || $postcode || $plaats) : ?>
						<div class="footer-block-info flex flex-row gap-4 md:gap-5 text-white">
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
						
						<?php if ( $route_link ) : ?>
							<div class="pt-4">
								<?php
								$route_button = array(
									'button_label'       => 'Plan mijn route',
									'button_style'       => 'secondary white',
									'button_link_type'   => 'external',
									'button_link_extern' => $route_link,
								);
								kj_render_button( $route_button );
								?>
						</div>
						<?php endif; ?>
						
						<?php if ( $footer_route_button && ! empty( $footer_route_button['label'] ) ) : ?>
							<div class="pt-4">
								<?php
								global $button_data;
								$button_data = $footer_route_button;
								kj_component( 'button', 'button', 1, 0 );
								?>
							</div>
						<?php endif; ?>
					</div>
				</div>
				<?php endif; ?>
				
			</div>
		</div>
		
		<!-- Bottom Bar -->
		<div class="bg-secondary border-t border-primary/10 py-8">
			<div class="container">
				<div class="flex flex-col md:flex-row justify-between items-center gap-4">
					<div class="copyright-bar-items flex flex-col md:flex-row justify-start items-center gap-3 text-xs text-white/70">
						<p>&copy; <?php echo date( 'Y' ); ?></p>
						<?php
						$algemene_voorwaarden = get_field('algemene_voorwaarden', 'option');
						if ( $algemene_voorwaarden ) :
							?>
							<a href="<?php echo esc_url( $algemene_voorwaarden ); ?>" class="hover:text-primary transition-colors" target="_blank" rel="noopener noreferrer"><?php _e( 'Algemene voorwaarden', 'kj' ); ?></a>
						<?php endif; ?>
						<?php
						$page_privacy_statement = get_field('page_privacy_statement', 'option');
						if ( $page_privacy_statement ) :
							?>
							<a href="<?php echo esc_url( $page_privacy_statement ); ?>" class="hover:text-primary transition-colors"><?php _e( 'Privacy Statement', 'kj' ); ?></a>
						<?php endif; ?>
						<?php
						$page_cookies = get_field('page_cookies', 'option');
						if ( $page_cookies ) :
							?>
							<a href="<?php echo esc_url( $page_cookies ); ?>" class="hover:text-primary transition-colors"><?php _e( 'Cookies', 'kj' ); ?></a>
						<?php endif; ?>
					</div>
					<div class="flex items-center gap-4 md:gap-6">
						<a
							href="https://effecty.nl"
							target="_blank"
							rel="noopener noreferrer"
							aria-label="Webdesign door Effecty - Online marketing bureau"
							class="inline-flex items-center text-white transition-colors opacity-50 hover:opacity-100 hover:text-primary"
						>
							<svg class="h-4 w-auto" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 137.81 17" aria-hidden="true">
								<g>
									<g>
										<path d="M43.36,13.27h-6.86V4.73h6.69v2.03h-4.33v1.24h4.05v1.97h-4.05v1.29h4.44v2.02h.06Z" fill="currentColor"/>
										<path d="M52.14,13.27V4.73h6.58v2.03h-4.16v1.63h3.94v1.97h-3.94v2.92h-2.42Z" fill="currentColor"/>
										<path d="M67.33,13.27V4.73h6.58v2.03h-4.22v1.63h3.94v1.97h-3.94v2.92h-2.36Z" fill="currentColor"/>
										<path d="M89.38,13.27h-6.86V4.73h6.69v2.03h-4.33v1.24h4.05v1.97h-4.05v1.29h4.5v2.02Z" fill="currentColor"/>
										<path d="M105.69,12.15c-.96.96-2.14,1.35-3.43,1.35-3.37,0-4.67-2.14-4.67-4.44s1.46-4.56,4.67-4.56c1.24,0,2.36.45,3.32,1.35l-1.52,1.46c-.62-.56-1.24-.73-1.8-.73-1.63,0-2.31,1.35-2.31,2.47s.62,2.36,2.31,2.36c.56,0,1.41-.23,2.03-.84l1.41,1.57Z" fill="currentColor"/>
										<path d="M115.98,6.69h-2.48v-1.97h7.37v1.97h-2.53v6.58h-2.42v-6.58h.06Z" fill="currentColor"/>
										<path d="M133.19,7.65l1.86-2.92h2.76v.11l-3.43,5.06v3.43h-2.42v-3.43l-3.26-5.06v-.11h2.76l1.74,2.92Z" fill="currentColor"/>
										<path d="M21.4,5.48c-.19-3.05-2.74-5.48-5.84-5.48-1.6,0-3.09.64-4.18,1.77-.62-.39-1.33-.6-2.06-.6-1.52,0-2.91.9-3.55,2.28-3.19.04-5.77,2.65-5.77,5.85,0,3.02,2.35,5.57,5.39,5.82l4.26.03,1.34,1.33c.32.32.8.52,1.26.52.53,0,1.01-.24,1.26-.6l1.33-1.31h5.67s.45-.03.45-.03c2.48-.26,4.35-2.33,4.35-4.83,0-2.3-1.69-4.31-3.91-4.76ZM5.82,13.21c-2.14,0-3.88-1.74-3.88-3.88s1.74-3.88,3.88-3.88c.17,0,.32,0,.57.03h.84l.16-.81c.2-.88,1-1.52,1.9-1.52.56,0,1.1.24,1.45.66l.86.97.7-1.05c.75-1.11,1.92-1.74,3.23-1.74,2.14,0,3.88,1.74,3.88,3.88,0,.11,0,.24-.03.4l-.11,1.09h1.12c1.6.02,2.9,1.33,2.9,2.92s-1.29,2.89-2.86,2.92h-6.41l-1.77,1.77-1.77-1.77h-4.12l-.53.03Z" fill="currentColor"/>
									</g>
								</g>
							</svg>
						</a>
						<a
							href="https://kayjilesen.com/nl?rel=asbestverwijdering.nl"
							target="_blank"
							rel="noopener noreferrer"
							aria-label="Website ontwikkeld door Kay Jilesen - Freelance webdeveloper"
							class="inline-flex items-center text-white transition-colors opacity-50 hover:opacity-100 hover:text-primary"
						>
							<svg class="h-4 w-auto" viewBox="0 0 439 129" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
								<g clip-path="url(#clip0_441_2)">
									<path d="M60.96 0.889883C61.02 35.1299 88.76 62.8699 123 62.9299V12.3899C123 6.02988 117.85 0.879883 111.49 0.879883H60.96V0.889883Z" fill="currentColor"/>
									<path d="M0.109985 62.9296C34.35 62.8696 62.09 35.1297 62.15 0.889648H11.62C5.25999 0.889648 0.109985 6.03965 0.109985 12.3896V62.9196V62.9296Z" fill="currentColor"/>
									<path d="M62.04 123.78C61.98 89.5397 34.24 61.7997 0 61.7397V112.27C0 118.63 5.15 123.78 11.51 123.78H62.04Z" fill="currentColor"/>
									<path d="M60.85 123.89C95.09 123.83 122.83 96.0901 122.89 61.8501H72.36C66 61.8501 60.85 67.0001 60.85 73.3601V123.89Z" fill="currentColor"/>
									<path d="M253.09 76.87C249.74 71.11 246.79 67.13 242.54 64.67C246.34 62.01 248.89 58.41 251.31 54.02L264.99 29.33H244.99L233.06 50.89C229.73 56.91 228.62 57.39 218.16 57.39H214.18V0H196V101.6H214.18V73.41H218.16C229.84 73.41 231.37 74.47 234.74 80.44L246.68 101.6H267.24L253.09 76.87Z" fill="currentColor"/>
									<path d="M320.67 29.3398H277.75V47.0098H320.54C325.9 47.0098 328.62 49.3798 328.62 54.0598V56.8898H298.76C281.86 56.8898 273.65 64.0098 273.65 78.6698C273.65 89.1298 277.98 101.6 298.63 101.6H330.28C343.89 101.6 346.55 95.7798 346.55 85.7198V53.9398C346.55 38.3098 337.12 29.3398 320.67 29.3398ZM328.62 72.2598V82.6398C328.62 83.3898 328.49 83.6098 328.49 83.6098C328.47 83.6198 328.2 83.7998 327.2 83.7998H298.75C292.42 83.7998 291.57 80.8198 291.57 77.8998C291.57 74.9798 292.14 72.2598 299.01 72.2598H328.62Z" fill="currentColor"/>
									<path d="M419.09 29.3401L396.15 82.5201H395.87C394.82 82.5201 394.54 82.4401 394.51 82.4401C394.46 82.4001 394.29 82.1701 393.91 81.1401L372.95 29.3401H353.65L377.58 89.3701C379.68 94.7301 382.36 98.1501 389 98.9701L376.23 128.76H395.84L438.57 29.3301H419.08L419.09 29.3401Z" fill="currentColor"/>
								</g>
								<defs>
									<clipPath id="clip0_441_2">
										<rect width="438.58" height="128.77" fill="currentColor"/>
									</clipPath>
								</defs>
							</svg>
						</a>
					</div>
				</div>
			</div>
		</div>
		
	</footer><!-- #colophon -->

	</div><!-- #page -->

	<?php wp_footer(); ?>

</body>
</html>