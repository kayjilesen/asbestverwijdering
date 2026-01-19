<?php
/**
 * The template for displaying blog posts archive (Kennisbank)
 *
 * @package asbestverwijdering
 * @version 1.0.0
 * @author Kay Jilesen
 */

get_header();

// Get archive settings from ACF options or use defaults
$archive_title = get_field('kennisbank_archive_title', 'option') ?: __('Kennisbank', 'kj');
$archive_subtitle = get_field('kennisbank_archive_subtitle', 'option') ?: '';
$archive_hero_image = get_field('kennisbank_archive_hero_image', 'option');
$show_filters = get_field('kennisbank_archive_show_filters', 'option') !== false; // Default to true
$intro_title = get_field('kennisbank_archive_intro_title', 'option') ?: '';
$intro_text = get_field('kennisbank_archive_intro_text', 'option') ?: '';

// Get current filter values from URL
$current_category = isset($_GET['categorie']) ? sanitize_text_field($_GET['categorie']) : '';

// Use featured image of first post as fallback if no hero image is set
if (!$archive_hero_image) {
    // Try to get from current query first (respects filters)
    global $wp_query;
    $temp_query = new WP_Query($wp_query->query_vars);
    if ($temp_query->have_posts()) {
        $temp_query->the_post();
        $featured_image_id = get_post_thumbnail_id();
        if ($featured_image_id) {
            $archive_hero_image = array('ID' => $featured_image_id);
        }
        wp_reset_postdata();
    } else {
        // Fallback to latest post if no posts in current query
        $first_post = get_posts(array(
            'post_type' => 'post',
            'posts_per_page' => 1,
            'post_status' => 'publish',
            'orderby' => 'date',
            'order' => 'DESC',
        ));
        
        if (!empty($first_post)) {
            $featured_image_id = get_post_thumbnail_id($first_post[0]->ID);
            if ($featured_image_id) {
                $archive_hero_image = array('ID' => $featured_image_id);
            }
        }
    }
}
?>

<main id="primary" class="site-main">

    <!-- Hero Section -->
    <section class="hero-block relative overflow-hidden">
        <div class="outer-container bg-beige">
            <?php if ($archive_hero_image) : ?>
                <div class="hero-block__background absolute top-0 left-0 right-0 bottom-0 w-full h-full z-0 overflow-hidden">
                    <?php echo wp_get_attachment_image($archive_hero_image['ID'], 'full', false, array('class' => 'hero-block__background-image object-cover object-center w-full h-full')); ?>
                </div>
                <div class="hero-block__gradient absolute top-0 left-0 right-0 bottom-0 w-full h-full z-[5]"></div>
            <?php endif; ?>

            <div class="hero-block__container container relative z-10 px-4 md:px-8">
                <!-- Hero Content -->
                <div class="hero-block__content text-white pt-72 pb-12 max-w-screen-lg mx-auto text-center">

                    <?php if ($archive_title) : ?>
                        <h1 class="hero-block__title text-3xl md:text-4xl lg:text-[90px] font-title uppercase font-normal mb-6 !leading-[1]"><?php echo wp_kses_post($archive_title); ?></h1>
                    <?php endif; ?>

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

    <!-- Intro Section -->
    <?php if ($intro_title || $intro_text) : ?>
    <section class="kennisbank-archive-intro bg-beige py-12 lg:py-16">
        <div class="container">
            <div class="kennisbank-archive-intro__content max-w-4xl mx-auto text-center">
                <?php if ($intro_title) : ?>
                    <h2 class="kennisbank-archive-intro__title text-2xl md:text-4xl lg:text-5xl font-title uppercase font-normal mb-6">
                        <?php echo wp_kses_post($intro_title); ?>
                    </h2>
                <?php endif; ?>

                <?php if ($intro_text) : ?>
                    <div class="kennisbank-archive-intro__text text-sm md:text-base text-grey-text">
                        <?php echo wp_kses_post($intro_text); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- Filters Section -->
    <?php if ($show_filters) :
        // Get all categories
        $categories = get_terms(array(
            'taxonomy' => 'category',
            'hide_empty' => true,
            'orderby' => 'name',
            'order' => 'ASC',
        ));
    ?>
    <section class="kennisbank-archive-filters bg-beige sticky top-[var(--header-height,80px)] z-40 py-6">
        <div class="container">
            <div class="kennisbank-archive-filters__wrapper border border-grey/40 bg-white p-6 flex flex-col lg:flex-row lg:flex-wrap justify-between gap-6 rounded-lg">

                <!-- Category Filters -->
                <div class="kennisbank-archive-filters__group flex flex-col lg:flex-row lg:items-center gap-3">
                    <h3 class="kennisbank-archive-filters__title font-title uppercase text-base md:text-lg font-semibold text-grey-dark whitespace-nowrap">
                        <?php _e('Filter op categorie:', 'kj'); ?>
                    </h3>
                    <div class="kennisbank-archive-filters__buttons flex flex-wrap gap-2">
                        <?php 
                        // Add "Alle" filter button
                        $all_url = remove_query_arg('categorie', get_post_type_archive_link('post') ?: home_url('/'));
                        ?>
                        <a href="<?php echo esc_url($all_url); ?>" class="kennisbank-archive-filter-btn kennisbank-archive-filter-btn--category <?php echo empty($current_category) ? 'active' : ''; ?>" data-filter="alle">
                            <?php _e('Alle', 'kj'); ?>
                        </a>
                        <?php if ($categories && !is_wp_error($categories)) : ?>
                            <?php foreach ($categories as $category) :
                                $filter_url = add_query_arg(array(
                                    'categorie' => $category->slug,
                                ), get_post_type_archive_link('post') ?: home_url('/'));
                            ?>
                                <a href="<?php echo esc_url($filter_url); ?>" class="kennisbank-archive-filter-btn kennisbank-archive-filter-btn--category <?php echo $current_category === $category->slug ? 'active' : ''; ?>" data-filter="<?php echo esc_attr($category->slug); ?>">
                                    <?php echo esc_html($category->name); ?>
                                </a>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <?php endif; ?>
    
    <!-- Posts Grid -->
    <section class="kennisbank-archive-grid pb-16 lg:pb-24 bg-beige">
        <div class="container">

            <?php if (have_posts()) :
                // Separate featured and regular posts
                $featured_posts = array();
                $regular_posts = array();

                while (have_posts()) : the_post();
                    $is_featured = get_field('post_featured', get_the_ID());
                    if ($is_featured) {
                        $featured_posts[] = get_post();
                    } else {
                        $regular_posts[] = get_post();
                    }
                endwhile;

                // Reset post data
                wp_reset_postdata();
            ?>

                <!-- Featured Posts -->
                <?php if (!empty($featured_posts)) : ?>
                    <div class="kennisbank-archive-featured">
                        <div class="kennisbank-archive-featured__grid">
                            <?php foreach ($featured_posts as $post) :
                                setup_postdata($post);
                                get_template_part('templates/components/post-card', null, array(
                                    'post' => $post,
                                    'wrapper_class' => 'kennisbank-archive-item kennisbank-archive-item--featured',
                                    'is_featured' => true
                                ));
                            endforeach;
                            wp_reset_postdata();
                            ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Regular Posts -->
                <?php if (!empty($regular_posts)) : ?>
                    <div class="kennisbank-archive-grid__wrapper grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" id="posts-grid">
                        <?php foreach ($regular_posts as $post) :
                            setup_postdata($post);
                            // Get post categories for filtering
                            $post_categories = wp_get_post_categories($post->ID, array('fields' => 'slugs'));
                            $category_classes = !empty($post_categories) ? implode(' ', $post_categories) : '';
                            $category_data = !empty($post_categories) ? ' data-categories="' . esc_attr(implode(' ', $post_categories)) . '"' : '';
                            get_template_part('templates/components/post-card', null, array(
                                'post' => $post,
                                'wrapper_class' => 'kennisbank-archive-item ' . esc_attr($category_classes)
                            ));
                        endforeach;
                        wp_reset_postdata();
                        ?>
                    </div>
                <?php endif; ?>
                
                <!-- Pagination -->
                <div class="kennisbank-archive-pagination mt-12">
                    <?php
                    echo kj_pagination();
                    ?>
                </div>
                
            <?php else : ?>
                
                <div class="kennisbank-archive-empty text-center py-16">
                    <p class="text-lg text-gray-600"><?php _e('Geen artikelen gevonden.', 'kj'); ?></p>
                </div>
                
            <?php endif; ?>
            
        </div>
    </section>
    
</main><!-- #main -->

<?php
get_footer();
