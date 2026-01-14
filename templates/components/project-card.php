<?php
/**
 * Project Card Component
 *
 * Reusable project card component used in both pagebuilder blocks and archive pages
 *
 * @package asbestverwijdering
 * @version 1.0.0
 * @author Kay Jilesen
 *
 * @param int|WP_Post $project - Project post object or ID
 * @param string $wrapper_class - Additional CSS classes for the wrapper (optional)
 * @param string $data_filter - Data filter attribute for filtering (optional)
 */

defined('ABSPATH') || exit;

// Extract args if passed via get_template_part (WP 5.5+)
if (isset($args) && is_array($args)) {
    extract($args);
}

// Validate project parameter
if (!isset($project)) {
    return;
}

// Convert to project ID if it's a post object
$project_id = is_object($project) ? $project->ID : $project;

// Get project data
$project_title = get_the_title($project_id);
$project_link = get_permalink($project_id);
$project_description = get_field('project_description', $project_id);
$project_date = get_field('project_date', $project_id);
$project_services = get_field('project_services', $project_id);

// Get portrait image (preferred) or fallback to featured image
$image = null;

// Try portrait image first
$portrait_image = get_field('featured_image_portrait', $project_id);
if ($portrait_image && is_array($portrait_image)) {
    $image = $portrait_image;
} elseif (is_numeric($portrait_image)) {
    $image = array('ID' => $portrait_image);
}

// Fallback to featured image
if (!$image) {
    $featured_image_id = get_post_thumbnail_id($project_id);
    if ($featured_image_id) {
        $image = array('ID' => $featured_image_id);
    }
}

// Format date
$formatted_date = '';
if ($project_date) {
    $date_obj = DateTime::createFromFormat('Y-m-d', $project_date);
    if ($date_obj) {
        $formatted_date = $date_obj->format('d-m-y');
    }
}

// Wrapper classes
$wrapper_class = isset($wrapper_class) ? $wrapper_class : '';
$is_featured = isset($is_featured) && $is_featured;

// Data attributes for filtering
$data_attributes = '';
if (isset($data_filter)) {
    $data_attributes .= ' data-filter="' . esc_attr($data_filter) . '"';
}
if (isset($data_diensten)) {
    $data_attributes .= ' data-diensten="' . esc_attr($data_diensten) . '"';
}
if (isset($data_doelgroepen)) {
    $data_attributes .= ' data-doelgroepen="' . esc_attr($data_doelgroepen) . '"';
}
?>

<article class="project-card <?php echo $is_featured ? 'project-card--featured' : ''; ?> group <?php echo esc_attr($wrapper_class); ?>"<?php echo $data_attributes; ?>>
    <a href="<?php echo esc_url($project_link); ?>" class="project-card__link block relative <?php echo $is_featured ? 'lg:h-[400px]' : ''; ?>">
        <?php if ($image) : ?>
            <div class="project-card__image-wrapper <?php echo $is_featured ? 'lg:w-full lg:h-full aspect-[3/4]' : 'aspect-[3/4]'; ?> overflow-hidden relative">
                <?php
                echo wp_get_attachment_image(
                    $image['ID'],
                    'large',
                    false,
                    array(
                        'class' => 'project-card__image w-full h-full object-cover transition-transform duration-300 group-hover:scale-105'
                    )
                );
                ?>

                <div class="project-card__gradient absolute bg-gradient-to-t from-black via-black/60 to-transparent z-10"></div>

                <!-- Services Badge (Top Left) -->
                <?php if ($project_services && is_array($project_services) && !empty($project_services)) : ?>
                    <div class="project-card__services absolute top-4 left-4 z-30 bg-white px-3 py-2 flex flex-wrap gap-2">
                        <?php
                        // Get the choices from ACF field
                        $field = get_field_object('project_services', $project_id);
                        $choices = $field && isset($field['choices']) ? $field['choices'] : array();

                        foreach ($project_services as $service_value) :
                            $service_label = isset($choices[$service_value]) ? $choices[$service_value] : $service_value;
                        ?>
                            <span class="project-card__service-badge font-title uppercase text-sm md:text-base font-semibold text-grey-dark whitespace-nowrap">
                                <?php echo esc_html($service_label); ?>
                            </span>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <!-- Featured Badge (Top Right) -->
                <?php if ($is_featured) : ?>
                    <div class="project-card__featured-badge absolute top-4 right-4 z-30 bg-white px-3 py-2">
                        <span class="font-title uppercase text-sm md:text-base font-semibold text-grey-dark whitespace-nowrap">
                            <?php _e('Uitgelicht', 'kj'); ?>
                        </span>
                    </div>
                <?php endif; ?>

                <?php if (!$is_featured) : ?>
                    <div class="project-card__content absolute inset-0 z-20 flex flex-col items-start justify-end p-6 text-white">

                        <?php if ($formatted_date) : ?>
                            <p class="project-card__date font-title text-xs md:text-sm opacity-75">
                                <?php echo esc_html($formatted_date); ?>
                            </p>
                        <?php endif; ?>
                        <?php if ($project_title) : ?>
                            <h3 class="project-card__title font-title uppercase text-xl md:text-2xl font-bold mb-2 group-hover:text-primary transition-colors flex items-center gap-2">
                                <span><?php echo esc_html($project_title); ?></span>
                                <svg class="project-card__arrow w-4 h-4 md:w-5 md:h-5 transition-transform duration-300 group-hover:translate-x-1" viewBox="0 0 16 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10.4825 0.398001C10.7243 0.15647 11.1165 0.156324 11.3582 0.398001L15.2989 4.33973C15.5407 4.58159 15.5407 4.97364 15.2989 5.2155L11.3582 9.15723C11.1165 9.39891 10.7243 9.39876 10.4825 9.15723C10.2407 8.91537 10.2407 8.52252 10.4825 8.28066L13.366 5.39694L0.836077 5.39694C0.494058 5.39694 0.216796 5.11966 0.216796 4.77761C0.216797 4.43557 0.494058 4.15829 0.836077 4.15829L13.366 4.15829L10.4825 1.27457C10.2407 1.03271 10.2407 0.639861 10.4825 0.398001Z" fill="currentColor" stroke="currentColor" stroke-width="0.43372"/>
                                </svg>
                            </h3>
                        <?php endif; ?>

                        <?php if ($project_description) : ?>
                            <p class="project-card__description text-xs md:text-sm font-serif mb-3 text-left line-clamp-2 opacity-90">
                                <?php echo esc_html($project_description); ?>
                            </p>
                        <?php endif; ?>

                    </div>
                <?php endif; ?>
            </div>

            <?php if ($is_featured) : ?>
                <div class="project-card__content absolute inset-0 z-20 flex flex-col items-start justify-end p-6 text-white">

                    <?php if ($formatted_date) : ?>
                        <p class="project-card__date font-title text-xs md:text-sm opacity-75">
                            <?php echo esc_html($formatted_date); ?>
                        </p>
                    <?php endif; ?>
                    <?php if ($project_title) : ?>
                        <h3 class="project-card__title font-title uppercase text-xl md:text-2xl font-bold mb-2 group-hover:text-primary transition-colors flex items-center gap-2">
                            <span><?php echo esc_html($project_title); ?></span>
                            <svg class="project-card__arrow w-4 h-4 md:w-5 md:h-5 transition-transform duration-300 group-hover:translate-x-1" viewBox="0 0 16 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10.4825 0.398001C10.7243 0.15647 11.1165 0.156324 11.3582 0.398001L15.2989 4.33973C15.5407 4.58159 15.5407 4.97364 15.2989 5.2155L11.3582 9.15723C11.1165 9.39891 10.7243 9.39876 10.4825 9.15723C10.2407 8.91537 10.2407 8.52252 10.4825 8.28066L13.366 5.39694L0.836077 5.39694C0.494058 5.39694 0.216796 5.11966 0.216796 4.77761C0.216797 4.43557 0.494058 4.15829 0.836077 4.15829L13.366 4.15829L10.4825 1.27457C10.2407 1.03271 10.2407 0.639861 10.4825 0.398001Z" fill="currentColor" stroke="currentColor" stroke-width="0.43372"/>
                            </svg>
                        </h3>
                    <?php endif; ?>

                    <?php if ($project_description) : ?>
                        <p class="project-card__description text-xs md:text-sm font-serif mb-3 text-left line-clamp-2 opacity-90">
                            <?php echo esc_html($project_description); ?>
                        </p>
                    <?php endif; ?>

                </div>
            <?php endif; ?>

        <?php else : ?>
            <div class="project-card__image-wrapper aspect-[3/4] overflow-hidden bg-grey-light flex items-center justify-center">
                <span class="text-gray-400"><?php _e('Geen afbeelding', 'kj'); ?></span>
            </div>
        <?php endif; ?>
    </a>
</article>
