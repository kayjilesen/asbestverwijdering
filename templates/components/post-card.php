<?php
/**
 * Post Card Component
 *
 * Reusable post card component for standard WordPress posts
 *
 * @package asbestverwijdering
 * @version 1.0.0
 * @author Kay Jilesen
 *
 * @param int|WP_Post $post - Post object or ID
 * @param string $wrapper_class - Additional CSS classes for the wrapper (optional)
 * @param bool $is_featured - Whether this is a featured post (optional)
 */

defined('ABSPATH') || exit;

// Extract args if passed via get_template_part (WP 5.5+)
if (isset($args) && is_array($args)) {
    extract($args);
}

// Validate post parameter
if (!isset($post)) {
    return;
}

// Convert to post ID if it's a post object
$post_id = is_object($post) ? $post->ID : $post;

// Get post data
$post_title = get_the_title($post_id);
$post_link = get_permalink($post_id);
// Get excerpt from pagebuilder content first, fallback to WordPress excerpt
$post_excerpt = kj_get_pagebuilder_excerpt($post_id, 20);
if (empty($post_excerpt)) {
    $post_excerpt = get_the_excerpt($post_id);
}
$post_date = get_the_date('d-m-y', $post_id);
$post_categories = get_the_category($post_id);

// Get featured image
$image = null;
$featured_image_id = get_post_thumbnail_id($post_id);
if ($featured_image_id) {
    $image = array('ID' => $featured_image_id);
}

// Wrapper classes
$wrapper_class = isset($wrapper_class) ? $wrapper_class : '';
$is_featured = isset($is_featured) && $is_featured;
?>

<article class="post-card <?php echo $is_featured ? 'post-card--featured' : ''; ?> group <?php echo esc_attr($wrapper_class); ?>">
    <a href="<?php echo esc_url($post_link); ?>" class="post-card__link block relative <?php echo $is_featured ? 'lg:h-[400px]' : ''; ?>">
        <?php if ($image) : ?>
            <div class="post-card__image-wrapper <?php echo $is_featured ? 'lg:w-full lg:h-full aspect-[3/4]' : 'aspect-[3/4]'; ?> overflow-hidden relative">
                <?php
                echo wp_get_attachment_image(
                    $image['ID'],
                    'large',
                    false,
                    array(
                        'class' => 'post-card__image w-full h-full object-cover transition-transform duration-300 group-hover:scale-105'
                    )
                );
                ?>

                <div class="post-card__gradient absolute bg-gradient-to-t from-beige via-40% via-beige/90 to-beige/0 z-10"></div>
                <div class="post-card__hover-overlay"></div>

                <!-- Categories Badge (Top Left) -->
                <?php if ( ! empty( $post_categories ) ) : ?>
                    <div class="post-card__categories-wrapper absolute top-4 left-4 z-30 flex flex-wrap gap-2">
                        <?php foreach ( $post_categories as $category ) : ?>
                            <div class="post-card__categories-badge bg-primary px-3 py-2 rounded-[6px]">
                                <span class="font-title uppercase text-sm md:text-base font-semibold text-grey-dark whitespace-nowrap">
                                    <?php echo esc_html( $category->name ); ?>
                                </span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <!-- Featured Badge (Top Right) -->
                <?php if ($is_featured) : ?>
                    <div class="post-card__featured-badge absolute top-4 right-4 z-30 bg-white px-3 py-2 rounded-[6px]">
                        <span class="font-title uppercase text-sm md:text-base font-semibold text-grey-dark whitespace-nowrap">
                            <?php _e('Uitgelicht', 'kj'); ?>
                        </span>
                    </div>
                <?php endif; ?>

                <?php if (!$is_featured) : ?>
                    <div class="post-card__content absolute inset-0 z-20 flex flex-col items-start justify-end p-6 text-grey-dark">

                        <?php if ($post_date) : ?>
                            <p class="post-card__date font-title text-xs md:text-sm opacity-75">
                                <?php echo esc_html($post_date); ?>
                            </p>
                        <?php endif; ?>
                        <?php if ($post_title) : ?>
                            <h3 class="post-card__title font-title uppercase text-xl md:text-2xl font-bold mb-2 transition-colors flex items-center gap-2">
                                <span><?php echo esc_html($post_title); ?></span>
                                <svg class="post-card__arrow w-4 h-4 md:w-5 md:h-5 transition-transform duration-300 group-hover:translate-x-1" viewBox="0 0 16 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10.4825 0.398001C10.7243 0.15647 11.1165 0.156324 11.3582 0.398001L15.2989 4.33973C15.5407 4.58159 15.5407 4.97364 15.2989 5.2155L11.3582 9.15723C11.1165 9.39891 10.7243 9.39876 10.4825 9.15723C10.2407 8.91537 10.2407 8.52252 10.4825 8.28066L13.366 5.39694L0.836077 5.39694C0.494058 5.39694 0.216796 5.11966 0.216796 4.77761C0.216797 4.43557 0.494058 4.15829 0.836077 4.15829L13.366 4.15829L10.4825 1.27457C10.2407 1.03271 10.2407 0.639861 10.4825 0.398001Z" fill="currentColor" stroke="currentColor" stroke-width="0.43372"/>
                                </svg>
                            </h3>
                        <?php endif; ?>

                        <?php if ($post_excerpt) : ?>
                            <p class="post-card__description text-xs md:text-sm font-serif mb-3 text-left line-clamp-2 opacity-90">
                                <?php echo esc_html($post_excerpt); ?>
                            </p>
                        <?php endif; ?>

                    </div>
                <?php endif; ?>
            </div>

            <?php if ($is_featured) : ?>
                <div class="post-card__content absolute inset-0 z-20 flex flex-col items-start justify-end p-6 text-grey-dark">

                    <?php if ($post_date) : ?>
                        <p class="post-card__date font-title text-xs md:text-sm opacity-75">
                            <?php echo esc_html($post_date); ?>
                        </p>
                    <?php endif; ?>
                    <?php if ($post_title) : ?>
                        <h3 class="post-card__title font-title uppercase text-xl md:text-2xl font-bold mb-2 transition-colors flex items-center gap-2">
                            <span><?php echo esc_html($post_title); ?></span>
                            <svg class="post-card__arrow w-4 h-4 md:w-5 md:h-5 transition-transform duration-300 group-hover:translate-x-1" viewBox="0 0 16 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10.4825 0.398001C10.7243 0.15647 11.1165 0.156324 11.3582 0.398001L15.2989 4.33973C15.5407 4.58159 15.5407 4.97364 15.2989 5.2155L11.3582 9.15723C11.1165 9.39891 10.7243 9.39876 10.4825 9.15723C10.2407 8.91537 10.2407 8.52252 10.4825 8.28066L13.366 5.39694L0.836077 5.39694C0.494058 5.39694 0.216796 5.11966 0.216796 4.77761C0.216797 4.43557 0.494058 4.15829 0.836077 4.15829L13.366 4.15829L10.4825 1.27457C10.2407 1.03271 10.2407 0.639861 10.4825 0.398001Z" fill="currentColor" stroke="currentColor" stroke-width="0.43372"/>
                            </svg>
                        </h3>
                    <?php endif; ?>

                    <?php if ($post_excerpt) : ?>
                        <p class="post-card__description text-xs md:text-sm font-serif mb-3 text-left line-clamp-2 opacity-90">
                            <?php echo esc_html($post_excerpt); ?>
                        </p>
                    <?php endif; ?>

                </div>
            <?php endif; ?>

        <?php else : ?>
            <div class="post-card__image-wrapper aspect-[3/4] overflow-hidden bg-grey-light flex items-center justify-center">
                <span class="text-gray-400"><?php _e('Geen afbeelding', 'kj'); ?></span>
            </div>
        <?php endif; ?>
    </a>
</article>
