<?php
/**
 * The template for displaying project archive
 *
 * @package asbestverwijdering
 * @version 1.0.0
 * @author Kay Jilesen
 */

get_header();

// Get archive settings from ACF options or use defaults
$archive_title = get_field('project_archive_title', 'option') ?: __('Projecten', 'kj');
$archive_subtitle = get_field('project_archive_subtitle', 'option') ?: '';
$archive_hero_image = get_field('project_archive_hero_image', 'option');
$show_filters = get_field('project_archive_show_filters', 'option') !== false; // Default to true
$intro_title = get_field('project_archive_intro_title', 'option') ?: '';
$intro_text = get_field('project_archive_intro_text', 'option') ?: '';

// Get current filter values from URL
$current_dienst = isset($_GET['dienst']) ? sanitize_text_field($_GET['dienst']) : '';
$current_doelgroep = isset($_GET['doelgroep']) ? sanitize_text_field($_GET['doelgroep']) : '';

// Modify the main query based on filters
if ($current_dienst || $current_doelgroep) {
    $tax_query = array('relation' => 'AND');

    if ($current_dienst && $current_dienst !== 'alle') {
        $tax_query[] = array(
            'taxonomy' => 'project_dienst',
            'field' => 'slug',
            'terms' => $current_dienst,
        );
    }

    if ($current_doelgroep && $current_doelgroep !== 'alle') {
        $tax_query[] = array(
            'taxonomy' => 'project_doelgroep',
            'field' => 'slug',
            'terms' => $current_doelgroep,
        );
    }

    if (count($tax_query) > 1) {
        global $wp_query;
        $wp_query->set('tax_query', $tax_query);
    }
}
?>

<main id="primary" class="site-main">

    <!-- Hero Section -->
    <section class="hero-block relative overflow-hidden">
        <div class="outer-container">
            <?php if ($archive_hero_image) : ?>
                <div class="hero-block__background absolute top-0 left-0 right-0 bottom-0 w-full h-full z-0 overflow-hidden">
                    <?php echo wp_get_attachment_image($archive_hero_image['ID'], 'full', false, array('class' => 'hero-block__background-image object-cover object-center w-full h-full')); ?>
                </div>
                <div class="hero-block__gradient absolute top-0 left-0 right-0 bottom-0 w-full h-full bg-gradient-to-r from-black/80 to-black/30 z-[5]"></div>
            <?php endif; ?>

            <div class="hero-block__container container relative z-10 px-4 md:px-8">
                <!-- Hero Content -->
                <div class="hero-block__content text-white pt-72 pb-12 max-w-screen-lg mr-auto">

                    <?php if ($archive_title) : ?>
                        <h1 class="hero-block__title text-3xl md:text-4xl lg:text-[90px] font-title uppercase font-normal mb-6 !leading-[1]"><?php echo wp_kses_post($archive_title); ?></h1>
                    <?php endif; ?>

                </div>
            </div>
            <div class="svg-wrapper">
                <?php echo file_get_contents(get_template_directory() . '/assets/svg/hero.svg'); ?>
            </div>
        </div>
    </section>

    <!-- Breadcrumbs -->
    <section class="breadcrumbs-section bg-white">
        <div class="container py-4">
            <?php echo kj_breadcrumbs(); ?>
        </div>
    </section>

    <!-- Intro Section -->
    <?php if ($intro_title || $intro_text) : ?>
    <section class="project-archive-intro bg-white py-12 lg:py-16">
        <div class="container">
            <div class="project-archive-intro__content max-w-4xl mx-auto text-center">
                <?php if ($intro_title) : ?>
                    <h2 class="project-archive-intro__title text-2xl md:text-4xl lg:text-5xl font-title uppercase font-normal mb-6">
                        <?php echo wp_kses_post($intro_title); ?>
                    </h2>
                <?php endif; ?>

                <?php if ($intro_text) : ?>
                    <div class="project-archive-intro__text text-sm md:text-base text-grey-text">
                        <?php echo wp_kses_post($intro_text); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- Filters Section -->
    <?php if ($show_filters) :
        // Get all diensten and doelgroepen terms
        $diensten = get_terms(array(
            'taxonomy' => 'project_dienst',
            'hide_empty' => true,
            'orderby' => 'name',
            'order' => 'ASC',
        ));

        $doelgroepen = get_terms(array(
            'taxonomy' => 'project_doelgroep',
            'hide_empty' => true,
            'orderby' => 'name',
            'order' => 'ASC',
        ));
    ?>
    <section class="project-archive-filters bg-white sticky top-[var(--header-height,80px)] z-40 py-6">
        <div class="container">
            <div class="project-archive-filters__wrapper border border-grey/40 p-6 flex flex-col lg:flex-row lg:flex-wrap justify-between gap-6">

                <!-- Diensten Filters (Left) -->
                <div class="project-archive-filters__group flex flex-col lg:flex-row lg:items-center gap-3">
                    <h3 class="project-archive-filters__title font-title uppercase text-base md:text-lg font-semibold text-grey-dark whitespace-nowrap">
                        <?php _e('Filter op dienst:', 'kj'); ?>
                    </h3>
                    <div class="project-archive-filters__buttons flex flex-wrap gap-2">
                        <?php if ($diensten && !is_wp_error($diensten)) : ?>
                            <?php foreach ($diensten as $dienst) :
                                $filter_url = add_query_arg(array(
                                    'dienst' => $dienst->slug,
                                    'doelgroep' => $current_doelgroep ? $current_doelgroep : null,
                                ), get_post_type_archive_link('project'));
                            ?>
                                <a href="<?php echo esc_url($filter_url); ?>" class="project-archive-filter-btn project-archive-filter-btn--dienst <?php echo $current_dienst === $dienst->slug ? 'active' : ''; ?>">
                                    <?php echo esc_html($dienst->name); ?>
                                </a>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Doelgroep Filters (Right) -->
                <div class="project-archive-filters__group flex flex-col lg:flex-row lg:items-center gap-3">
                    <h3 class="project-archive-filters__title font-title uppercase text-base md:text-lg font-semibold text-grey-dark whitespace-nowrap">
                        <?php _e('Filter op doelgroep:', 'kj'); ?>
                    </h3>
                    <div class="project-archive-filters__buttons flex flex-wrap gap-2">
                        <?php if ($doelgroepen && !is_wp_error($doelgroepen)) : ?>
                            <?php foreach ($doelgroepen as $doelgroep) :
                                $filter_url = add_query_arg(array(
                                    'dienst' => $current_dienst ? $current_dienst : null,
                                    'doelgroep' => $doelgroep->slug,
                                ), get_post_type_archive_link('project'));
                            ?>
                                <a href="<?php echo esc_url($filter_url); ?>" class="project-archive-filter-btn project-archive-filter-btn--doelgroep <?php echo $current_doelgroep === $doelgroep->slug ? 'active' : ''; ?>">
                                    <?php echo esc_html($doelgroep->name); ?>
                                </a>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <?php endif; ?>
    
    <!-- Projects Grid -->
    <section class="project-archive-grid pb-16 lg:pb-24 bg-white">
        <div class="container">

            <?php if (have_posts()) :
                // Separate featured and regular projects
                $featured_projects = array();
                $regular_projects = array();

                while (have_posts()) : the_post();
                    $is_featured = get_field('project_featured');
                    if ($is_featured) {
                        $featured_projects[] = get_post();
                    } else {
                        $regular_projects[] = get_post();
                    }
                endwhile;

                // Reset post data
                wp_reset_postdata();
            ?>

                <!-- Featured Projects -->
                <?php if (!empty($featured_projects)) : ?>
                    <div class="project-archive-featured">
                        <div class="project-archive-featured__grid">
                            <?php foreach ($featured_projects as $project) :
                                setup_postdata($project);
                                get_template_part('templates/components/project-card', null, array(
                                    'project' => $project,
                                    'wrapper_class' => 'project-item project-item--featured',
                                    'is_featured' => true
                                ));
                            endforeach;
                            wp_reset_postdata();
                            ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Regular Projects -->
                <?php if (!empty($regular_projects)) : ?>
                    <div class="project-archive-grid__wrapper grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" id="projects-grid">
                        <?php foreach ($regular_projects as $project) :
                            setup_postdata($project);
                            get_template_part('templates/components/project-card', null, array(
                                'project' => $project,
                                'wrapper_class' => 'project-item'
                            ));
                        endforeach;
                        wp_reset_postdata();
                        ?>
                    </div>
                <?php endif; ?>
                
                <!-- Pagination -->
                <div class="project-archive-pagination mt-12">
                    <?php
                    echo kj_pagination();
                    ?>
                </div>
                
            <?php else : ?>
                
                <div class="project-archive-empty text-center py-16">
                    <p class="text-lg text-gray-600"><?php _e('Geen projecten gevonden.', 'kj'); ?></p>
                </div>
                
            <?php endif; ?>
            
        </div>
    </section>
    
</main><!-- #main -->

<?php
get_footer();

