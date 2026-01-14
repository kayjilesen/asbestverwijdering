<?php
/**
 * The main template file
 *
 * @package asbestverwijdering
 * @version 1.0.0
 * @author Kay Jilesen
 */

get_header(); 
?>

<main id="primary" class="site-main">
    <div class="container">
        <div class="content-area">

        <?php
        if ( have_posts() ) :

            /* Start the Loop */
            while ( have_posts() ) :
                the_post();

                /*
                 * Include the Post-Type-specific template for the content.
                 * If you want to override this in a child theme, then include a file
                 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
                 */
                get_template_part( 'template-parts/card-post');

            endwhile;

            kj_pagination();

        else :

            get_template_part( 'template-parts/content', 'none' );

        endif;
        ?>

        </div>
    </div>
</main><!-- #main -->

<?php get_footer(); ?>