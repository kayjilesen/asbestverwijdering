<?php
/**
 * The template for displaying single project posts
 *
 * @package asbestverwijdering
 * @version 1.0.0
 * @author Kay Jilesen
 */

get_header();

// Get project fields
$featured_image = get_field( 'featured_image_portrait' );

// Normalize featured image to always get an ID
$featured_image_id = null;

if ( $featured_image ) {
    // Handle different ACF return formats
    if ( is_array( $featured_image ) ) {
        // Image Array format
        $featured_image_id = $featured_image['ID'] ?? $featured_image['id'] ?? null;
    } elseif ( is_numeric( $featured_image ) ) {
        // Image ID format
        $featured_image_id = (int) $featured_image;
    } elseif ( is_string( $featured_image ) ) {
        // Image URL format - get ID from URL
        $featured_image_id = attachment_url_to_postid( $featured_image );
    }
}

// Fallback to featured image if no portrait image is set
if ( ! $featured_image_id ) {
    $featured_image_id = get_post_thumbnail_id();
}
?>

<main id="primary" class="site-main">

    <!-- Project Hero -->
    <section class="project-hero-block relative overflow-hidden">
        <div class="outer-container">
            <?php if ( $featured_image_id ) : ?>
                <div class="project-hero-block__background absolute top-0 left-0 right-0 bottom-0 w-full h-full z-0 overflow-hidden">
                    <?php echo wp_get_attachment_image( $featured_image_id, 'full', false, array( 'class' => 'project-hero-block__background-image object-cover object-center w-full h-full' ) ); ?>
                </div>
                <div class="project-hero-block__gradient absolute top-0 left-0 right-0 bottom-0 w-full h-full bg-gradient-to-r from-black/80 to-black/30 z-[5]"></div>
            <?php endif; ?>
            
            <div class="project-hero-block__container container relative z-10 px-4 md:px-8">
                <!-- Hero Content -->
                <div class="project-hero-block__content text-white pt-48 lg:pt-72 pb-12 lg:pb-20 max-w-screen-lg mr-auto">

                    <h1 class="project-hero-block__title text-3xl md:text-4xl lg:text-[90px] font-title uppercase font-normal mb-6 !leading-[1]"><strong><?php echo esc_html( get_the_title() ); ?></strong></h1>
                    
                </div>
            </div>
            <div class="svg-wrapper">
                <?php echo file_get_contents( get_template_directory() . '/assets/svg/hero.svg' ); ?>
            </div>
        </div>
    </section>

    <!-- Breadcrumbs -->
    <section class="breadcrumbs-section bg-white">
        <div class="container py-4">
            <?php echo kj_breadcrumbs(); ?>
        </div>
    </section>

    <?php
    // Render pagebuilder content if available
    if ( have_rows( 'pagebuilder' ) ) {
        get_template_part( 'templates/pagebuilder/loop' );
    }
    ?>

</main><!-- #main -->

<?php get_footer(); ?>

