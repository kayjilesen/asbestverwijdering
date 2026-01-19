<?php
/**
 * The template for displaying single vacature posts
 *
 * @package asbestverwijdering
 * @version 1.0.0
 * @author Kay Jilesen
 */

get_header();

while ( have_posts() ) :
    the_post();
    
    // Check if first pagebuilder block is hero
    $has_pagebuilder = have_rows( 'pagebuilder' );
    $first_block_is_hero = false;
    
    if ( $has_pagebuilder ) {
        the_row();
        $first_block_is_hero = ( get_row_layout() === 'hero' );
        reset_rows();
    }
    
    // Render hero block (either from pagebuilder or default)
    if ( $first_block_is_hero ) {
        // Render hero from pagebuilder
        the_row();
        get_template_part( 'templates/pagebuilder/hero/hero' );
        reset_rows();
    } else {
        // Render default hero using featured image
        $featured_image_id = get_post_thumbnail_id();
        ?>
        <section class="hero-block relative overflow-hidden">
            <div class="outer-container bg-white">
                <?php if ( $featured_image_id ) : ?>
                    <div class="hero-block__background absolute top-0 left-0 right-0 bottom-0 w-full h-full z-0 overflow-hidden">
                        <?php echo wp_get_attachment_image( $featured_image_id, 'full', false, array( 'class' => 'hero-block__background-image object-cover object-center w-full h-full' ) ); ?>
                    </div>
                    <div class="hero-block__gradient absolute top-0 left-0 right-0 bottom-0 w-full h-full z-[5]"></div>
                <?php endif; ?>

                <div class="hero-block__container container relative z-10 px-4 md:px-8">
                    <div class="hero-block__content text-white pt-72 pb-12 max-w-screen-lg mx-auto text-center">
                        <h1 class="hero-block__title text-3xl md:text-4xl lg:text-[90px] font-title uppercase font-normal mb-6 !leading-[1]">
                            <?php echo esc_html( get_the_title() ); ?>
                        </h1>
                    </div>
                </div>
                <div class="svg-wrapper">
                    <?php echo file_get_contents( get_template_directory() . '/assets/svg/hero.svg' ); ?>
                </div>
            </div>
        </section>
        <?php
    }
    
    // Render remaining pagebuilder blocks (skip first if it was hero)
    if ( $has_pagebuilder ) {
        $row_index = 0;
        while ( have_rows( 'pagebuilder' ) ) : the_row();
            // Skip first row if it was hero (already rendered)
            if ( $row_index === 0 && $first_block_is_hero ) {
                $row_index++;
                continue;
            }
            
            // Get the template for this layout
            $layout = get_row_layout();
            $template_path = get_stylesheet_directory() . '/templates/pagebuilder/' . $layout . '/' . $layout . '.php';
            
            if ( file_exists( $template_path ) ) {
                include $template_path;
            }
            
            $row_index++;
        endwhile;
    }
    
endwhile;
?>

<?php get_footer(); ?>
