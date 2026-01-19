<?php
/**
 * The template for displaying single posts
 *
 * @package asbestverwijdering
 * @version 1.0.0
 * @author Kay Jilesen
 */

get_header();

while ( have_posts() ) :
    the_post();
    
    // Get featured image for hero
    $featured_image_id = get_post_thumbnail_id();
    ?>
    
    <main id="primary" class="site-main">
        
        <!-- Hero Section -->
        <section class="hero-block relative overflow-hidden">
            <div class="outer-container bg-white">
                <?php if ( $featured_image_id ) : ?>
                    <div class="hero-block__background absolute top-0 left-0 right-0 bottom-0 w-full h-full z-0 overflow-hidden">
                        <?php echo wp_get_attachment_image( $featured_image_id, 'full', false, array( 'class' => 'hero-block__background-image object-cover object-center w-full h-full' ) ); ?>
                    </div>
                    <div class="hero-block__gradient absolute top-0 left-0 right-0 bottom-0 w-full h-full z-[5]"></div>
                <?php endif; ?>

                <div class="hero-block__container container relative z-10 px-4 md:px-8">
                    <!-- Hero Content -->
                    <div class="hero-block__content text-white pt-72 pb-12 max-w-screen-lg mx-auto text-center">
                        <h1 class="hero-block__title text-3xl md:text-4xl lg:text-[90px] font-title uppercase font-normal mb-6 !leading-[1]"><?php echo esc_html( get_the_title() ); ?></h1>
                    </div>
                </div>
            </div>
        </section>

        <!-- Breadcrumbs -->
        <section class="breadcrumbs-section bg-beige">
            <div class="container py-4">
                <?php echo kj_breadcrumbs(); ?>
            </div>
        </section>

        <!-- Author Info -->
        <?php
        $auteur = get_field( 'auteur' );
        if ( $auteur ) :
            // Handle both object and ID formats
            if ( is_object( $auteur ) ) {
                $auteur_id = $auteur->ID;
                $auteur_naam = $auteur->post_title;
            } else {
                $auteur_id = (int) $auteur;
                $auteur_post = get_post( $auteur_id );
                $auteur_naam = $auteur_post ? $auteur_post->post_title : '';
            }
            
            $auteur_functietitel = get_field( 'functietitel', $auteur_id );
            $auteur_profielfoto = get_field( 'profielfoto', $auteur_id );
            $leestijd = kj_calculate_reading_time();
            
            // Get image ID from ACF field
            $profielfoto_id = null;
            if ( $auteur_profielfoto ) {
                if ( is_array( $auteur_profielfoto ) && isset( $auteur_profielfoto['ID'] ) ) {
                    $profielfoto_id = $auteur_profielfoto['ID'];
                } elseif ( is_numeric( $auteur_profielfoto ) ) {
                    $profielfoto_id = (int) $auteur_profielfoto;
                }
            }
            // Fallback to featured image if no profielfoto
            if ( ! $profielfoto_id ) {
                $profielfoto_id = get_post_thumbnail_id( $auteur_id );
            }
            ?>
            <section class="author-info bg-beige py-6 lg:py-8">
                <div class="container">
                    <div class="author-info__wrapper flex items-center gap-4 lg:gap-6 border-b border-grey-dark/10 pb-6 lg:pb-8">
                        <?php if ( $profielfoto_id ) : ?>
                            <div class="author-info__image flex-shrink-0">
                                <?php echo wp_get_attachment_image( $profielfoto_id, 'icon-thumbnail', false, array( 'class' => 'author-info__photo rounded-full w-[44px] h-[44px] object-cover' ) ); ?>
                            </div>
                        <?php endif; ?>
                        <div class="author-info__content flex-1">
                            <p class="author-info__text text-xs md:text-sm text-grey-text">
                                <span class="author-info__by">Geschreven door</span>
                                <span class="author-info__name font-medium text-grey-dark"><?php echo esc_html( $auteur_naam ); ?></span>
                                <?php if ( $auteur_functietitel ) : ?>
                                    <span class="author-info__title">, <?php echo esc_html( $auteur_functietitel ); ?></span>
                                <?php endif; ?>
                            </p>
                            <p class="author-info__reading-time text-xs md:text-sm text-grey-text mt-1">
                                <span class="author-info__reading-label">Geschatte leestijd: </span>
                                <span class="author-info__reading-minutes font-medium text-grey-dark"><?php echo esc_html( $leestijd ); ?> minuten</span>
                            </p>
                        </div>
                    </div>
                </div>
            </section>
        <?php endif; ?>

        <!-- Pagebuilder Content from Post -->
        <?php
        // Render pagebuilder content from the post itself first
        if ( have_rows( 'pagebuilder' ) ) {
            get_template_part( 'templates/pagebuilder/loop' );
        }
        ?>

        <!-- Pagebuilder from Options -->
        <?php
        // Get pagebuilder from options page 'Kennisbank - Artikel'
        // The pagebuilder field group is configured to appear on the 'kennisbank-artikel' options page
        if ( have_rows( 'post_pagebuilder', 'option' ) ) :
            while ( have_rows( 'post_pagebuilder', 'option' ) ) : the_row();
                $layout = get_row_layout();
                
                if ( ! empty( $layout ) ) {
                    // Get the template for this layout (new folder structure)
                    $template_path = get_stylesheet_directory() . '/templates/pagebuilder/' . $layout . '/' . $layout . '.php';
                    
                    if ( file_exists( $template_path ) ) {
                        include $template_path;
                    } else {
                        // Fallback: try old structure
                        $old_template_path = get_stylesheet_directory() . '/templates/pagebuilder/' . $layout . '.php';
                        
                        if ( file_exists( $old_template_path ) ) {
                            include $old_template_path;
                        } else {
                            // Fallback: use component
                            $component_path = get_stylesheet_directory() . '/templates/components/' . $layout . '.php';
                            
                            if ( file_exists( $component_path ) ) {
                                include $component_path;
                            }
                        }
                    }
                }
            endwhile;
        endif;
        ?>
        
    </main><!-- #main -->
    
    <?php
endwhile;

get_footer();
