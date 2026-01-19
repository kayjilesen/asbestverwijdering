<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package asbestverwijdering
 * @version 1.0.0
 * @author Kay Jilesen
 */

get_header(); ?>

<main id="primary" class="site-main bg-white">
	<div class="container py-16 md:py-24">
		<div class="max-w-3xl mx-auto text-center">
			
			<!-- 404 Heading -->
			<h1 class="text-8xl md:text-9xl font-bold text-secondary mb-4">404</h1>
			
			<!-- Error Message -->
			<h2 class="text-3xl md:text-4xl font-bold text-secondary mb-6">
				<?php esc_html_e( 'Pagina niet gevonden', 'kj' ); ?>
			</h2>

			<!-- Description -->
			<p class="text-lg text-grey mb-8 max-w-xl mx-auto">
				<?php esc_html_e( 'De pagina die je zoekt bestaat niet of is verplaatst. Controleer de URL of gebruik de onderstaande knoppen om verder te gaan.', 'kj' ); ?>
			</p>

			<!-- Action Buttons -->
			<div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
				<?php
				kj_render_button(array(
					'button_label' => __( 'Terug naar home', 'kj' ),
					'button_style' => 'primary blue',
					'button_link_type' => 'internal',
					'button_link_intern' => get_option('page_on_front') ?: home_url('/')
				));
				?>

				<?php
				$contact_page = get_field('page_contact', 'option');
				$contact_url = '/contact'; // Fallback
				if ($contact_page) {
					if (is_object($contact_page) && isset($contact_page->ID)) {
						$contact_url = $contact_page->ID;
					} elseif (is_array($contact_page) && isset($contact_page['ID'])) {
						$contact_url = $contact_page['ID'];
					} elseif (is_numeric($contact_page)) {
						$contact_url = $contact_page;
					}
				}
				?>
				<?php
				kj_render_button(array(
					'button_label' => __( 'Neem contact op', 'kj' ),
					'button_style' => 'primary grey-dark',
					'button_link_type' => 'internal',
					'button_link_intern' => $contact_url
				));
				?>
			</div>
			
		</div>
	</div>
</main><!-- #main -->

<?php get_footer(); ?>
