<?php
/**
 * The template for displaying all pages
 *
 * @package asbestverwijdering
 * @version 1.0.0
 * @author Kay Jilesen
 */

get_header(); ?>

<main id="primary" class="site-main">

        <?php
        while ( have_posts() ) :
            the_post();

            // Check if pagebuilder is enabled
            if ( have_rows( 'pagebuilder' ) ) {
                // Use pagebuilder
                get_template_part( 'templates/pagebuilder/loop' );
            } else {
                // Fallback to default content
                get_template_part( 'template-parts/content', 'page' );
            }

        endwhile; // End of the loop.
        ?>

</main><!-- #main -->

<?php get_footer(); ?>