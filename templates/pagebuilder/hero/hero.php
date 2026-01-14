<?php
/**
 * Hero Block
 * 
 * @package asbestverwijdering
 * @version 1.0.0
 * @author Kay Jilesen
 */

defined( 'ABSPATH' ) || exit;

$title = get_sub_field( 'title' );
$subtitle = get_sub_field( 'subtitle' );
$background_image = get_sub_field( 'background_image' );

// Check if this is the homepage
$is_homepage = is_front_page();

// For non-homepage pages, use featured image if no background image is set
if ( ! $is_homepage && ! $background_image ) {
    $featured_image_id = get_post_thumbnail_id();
    if ( $featured_image_id ) {
        $background_image = array( 'ID' => $featured_image_id );
    }
}
?>

<section class="hero-block relative overflow-hidden" <?php echo ( $is_homepage || ! $background_image ) ? '' : ''; ?>"">
    <div class="outer-container">
        <?php if ( $background_image ) : ?>
            <div class="hero-block__background absolute top-0 left-0 right-0 bottom-0 w-full h-full z-0 overflow-hidden">
                <?php echo wp_get_attachment_image( $background_image['ID'], 'full', false, array( 'class' => 'hero-block__background-image object-cover object-center w-full h-full' ) ); ?>
            </div>
            <div class="hero-block__gradient absolute top-0 left-0 right-0 bottom-0 w-full h-full z-[5]"></div>
        <?php endif; ?>
        
        <div class="hero-block__container container relative z-10 px-4 md:px-8 <?php echo $is_homepage ? 'xl:px-8' : ''; ?>">
            <!-- Hero Content -->
            <div class="hero-block__content text-white <?php echo $is_homepage ? 'py-20 lg:py-32' : 'pt-72 pb-12'; ?> max-w-screen-lg mx-auto text-center">
                
                <?php if ( $title ) : ?>
                    <h1 class="hero-block__title text-3xl md:text-4xl lg:text-[90px] font-title uppercase font-normal mb-6 !leading-[1]"><?php echo wp_kses_post($title); ?></h1>
                <?php endif; ?>

                <?php if ( $is_homepage && $subtitle ) : ?>
                    <p class="hero-block__subtitle font-sans font-normal text-xs md:text-sm mb-4 opacity-90 pl-2 md:pl-4 border-l-2 border-yellow"><?php echo wp_kses_post($subtitle); ?></p>
                <?php endif; ?>
                
                <div class="hero-block__buttons button-wrapper flex flex-row gap-4 justify-center">
                    <?php kj_render_buttons(); ?>
                </div>
            </div>
        </div>
    </div>
</section>
