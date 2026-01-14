<?php
/**
 * The template for displaying vacature archive
 *
 * @package asbestverwijdering
 * @version 1.0.0
 * @author Kay Jilesen
 */

get_header();

// Get archive settings from ACF options or use defaults
$archive_title = get_field('vacature_archive_title', 'option') ?: __('Vacatures', 'kj');
$archive_subtitle = get_field('vacature_archive_subtitle', 'option') ?: '';
$archive_hero_image = get_field('vacature_archive_hero_image', 'option');
$show_pagebuilder = get_field('vacature_archive_show_pagebuilder', 'option') !== false; // Default to true
?>

<main id="primary" class="site-main">
    
    <!-- Hero Section -->
    <section class="vacature-archive-hero relative overflow-hidden <?php echo $archive_hero_image ? '' : 'bg-green-dark'; ?>">
        <?php if ($archive_hero_image) : ?>
            <div class="vacature-archive-hero__background absolute top-0 left-0 right-0 bottom-0 w-full h-full z-0 overflow-hidden">
                <?php echo wp_get_attachment_image($archive_hero_image['ID'], 'full', false, array('class' => 'vacature-archive-hero__background-image object-cover object-center w-full h-full')); ?>
            </div>
            <div class="vacature-archive-hero__gradient absolute top-0 left-0 right-0 bottom-0 w-full h-full bg-gradient-to-r from-black to-black/40 z-[5]"></div>
        <?php endif; ?>
        
        <div class="vacature-archive-hero__container container relative z-10">
            <div class="vacature-archive-hero__content text-white py-20 lg:py-32">
                
                <!-- Breadcrumbs -->
                <div class="vacature-archive-hero__breadcrumbs mb-6">
                    <?php echo kj_breadcrumbs(); ?>
                </div>
                
                <?php if ($archive_subtitle) : ?>
                    <p class="vacature-archive-hero__subtitle text-lg md:text-xl lg:text-2xl mb-4 opacity-90"><?php echo wp_kses_post($archive_subtitle); ?></p>
                <?php endif; ?>
                
                <?php if ($archive_title) : ?>
                    <h1 class="vacature-archive-hero__title text-2xl md:text-3xl lg:text-5xl font-serif font-medium mb-6 !leading-[1.25]"><?php echo wp_kses_post($archive_title); ?></h1>
                <?php endif; ?>
            </div>
        </div>
    </section>
    
    <?php if ($show_pagebuilder && have_rows('pagebuilder', 'option')) : ?>
        <!-- Pagebuilder Content -->
        <?php get_template_part('templates/pagebuilder/loop'); ?>
    <?php else : ?>
        <!-- Default Vacatures Grid -->
        <section class="vacature-archive-grid py-16 lg:py-24 bg-white">
            <div class="container">
                
                <?php if (have_posts()) : ?>
                    
                    <div class="vacature-archive-grid__wrapper grid grid-cols-1 md:grid-cols-2 gap-8" id="vacatures-grid">
                        <?php while (have_posts()) : the_post(); 
                            $vacature_id = get_the_ID();
                            $vacature_title = get_the_title();
                            $vacature_link = get_permalink();
                            $vacature_excerpt = get_the_excerpt();
                            $featured_image_id = get_post_thumbnail_id();
                        ?>
                            <article class="vacature-archive-item">
                                <a href="<?php echo esc_url($vacature_link); ?>" class="vacature-archive-item__link block group">
                                    
                                    <?php if ($featured_image_id) : ?>
                                        <div class="vacature-archive-item__image-wrapper aspect-[4/3] overflow-hidden rounded-lg mb-4">
                                            <?php 
                                            echo wp_get_attachment_image(
                                                $featured_image_id,
                                                'large',
                                                false,
                                                array(
                                                    'class' => 'vacature-archive-item__image w-full h-full object-cover transition-transform duration-300 group-hover:scale-105'
                                                )
                                            );
                                            ?>
                                        </div>
                                    <?php else : ?>
                                        <div class="vacature-archive-item__image-wrapper aspect-[4/3] overflow-hidden rounded-lg mb-4 bg-gray-200 flex items-center justify-center">
                                            <span class="text-gray-400"><?php _e('Geen afbeelding', 'kj'); ?></span>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <?php if ($vacature_title) : ?>
                                        <h3 class="vacature-archive-item__title text-xl font-semibold mb-2 group-hover:text-green transition-colors">
                                            <?php echo esc_html($vacature_title); ?>
                                        </h3>
                                    <?php endif; ?>
                                    
                                    <?php if ($vacature_excerpt) : ?>
                                        <p class="vacature-archive-item__excerpt text-gray-600 line-clamp-3">
                                            <?php echo esc_html($vacature_excerpt); ?>
                                        </p>
                                    <?php endif; ?>
                                    
                                </a>
                            </article>
                        <?php endwhile; ?>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="vacature-archive-pagination mt-12">
                        <?php
                        echo kj_pagination();
                        ?>
                    </div>
                    
                <?php else : ?>
                    
                    <div class="vacature-archive-empty text-center py-16">
                        <p class="text-lg text-gray-600"><?php _e('Geen vacatures gevonden.', 'kj'); ?></p>
                    </div>
                    
                <?php endif; ?>
                
            </div>
        </section>
    <?php endif; ?>
    
</main><!-- #main -->

<?php
get_footer();

