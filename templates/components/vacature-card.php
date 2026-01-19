<?php
/**
 * Vacature Card Component
 *
 * Reusable vacature card component used in both pagebuilder blocks and archive pages
 *
 * @package asbestverwijdering
 * @version 1.0.0
 * @author Kay Jilesen
 *
 * @param int|WP_Post $vacature - Vacature post object or ID
 * @param string $wrapper_class - Additional CSS classes for the wrapper (optional)
 */

defined('ABSPATH') || exit;

// Extract args if passed via get_template_part (WP 5.5+)
if (isset($args) && is_array($args)) {
    extract($args);
}

// Validate vacature parameter
if (!isset($vacature)) {
    return;
}

// Convert to vacature ID if it's a post object
$vacature_id = is_object($vacature) ? $vacature->ID : $vacature;

// Get vacature data
$vacature_title = get_the_title($vacature_id);
$vacature_link = get_permalink($vacature_id);
$vacature_beschrijving = get_field('beschrijving', $vacature_id);

// Get ACF fields for vacancy details
$location = get_field('location', $vacature_id);
$dienstverband = get_field('dienstverband', $vacature_id);
$uren = get_field('uren', $vacature_id);
$salaris = get_field('salaris', $vacature_id);

// Format dienstverband (multiple select)
$dienstverband_text = '';
if ($dienstverband && is_array($dienstverband)) {
    $dienstverband_labels = array(
        'full_time'   => __( 'Full time', 'kj' ),
        'part_time'   => __( 'Part time', 'kj' ),
        'zelfstandig' => __( 'Zelfstandig', 'kj' )
    );
    $labels = array();
    foreach ($dienstverband as $value) {
        if (isset($dienstverband_labels[$value])) {
            $labels[] = $dienstverband_labels[$value];
        }
    }
    $dienstverband_text = implode(', ', $labels);
}

// Combine dienstverband and uren
$working_hours_text = '';
if ($dienstverband_text && $uren) {
    $working_hours_text = $dienstverband_text . ' (' . $uren . ')';
} elseif ($dienstverband_text) {
    $working_hours_text = $dienstverband_text;
} elseif ($uren) {
    $working_hours_text = $uren;
}

// Get image - always use featured image
$image = null;
$featured_image_id = get_post_thumbnail_id($vacature_id);
if ($featured_image_id) {
    $image = array('ID' => $featured_image_id);
}

// Wrapper classes
$wrapper_class = isset($wrapper_class) ? $wrapper_class : '';
?>

<article class="vacatures-block__item group relative flex flex-col overflow-hidden rounded-lg <?php echo esc_attr($wrapper_class); ?>">
    <a href="<?php echo esc_url($vacature_link); ?>" class="vacatures-block__link block flex flex-col">
        <?php if ($image) : ?>
            <div class="vacatures-block__image-wrapper relative overflow-hidden">
                <?php 
                echo wp_get_attachment_image( 
                    $image['ID'], 
                    'large', 
                    false, 
                    array( 
                        'class' => 'vacatures-block__image absolute inset-0 w-full h-full object-cover transition-transform duration-300 group-hover:scale-105' 
                    ) 
                ); 
                ?>
                
                <!-- Gradient Overlay -->
                <div class="vacatures-block__gradient absolute bottom-0 left-0 right-0 bg-gradient-to-t from-beige via-beige to-transparent z-10 h-[80%]"></div>
                
                <!-- Content Overlay on Image -->
                <div class="vacatures-block__image-content absolute inset-0 z-20 flex flex-col items-start justify-end p-6 text-grey-dark">
                    <?php if ($vacature_title) : ?>
                        <h3 class="vacatures-block__item-title font-title text-2xl md:text-3xl lg:text-4xl uppercase font-bold mb-3 leading-none">
                            <?php echo esc_html($vacature_title); ?>
                        </h3>
                    <?php endif; ?>
                    
                    <?php if ($vacature_beschrijving) : ?>
                        <p class="vacatures-block__item-excerpt text-sm md:text-base leading-[1.4] text-grey-dark line-clamp-3 mb-6">
                            <?php echo esc_html(wp_strip_all_tags($vacature_beschrijving)); ?>
                        </p>
                    <?php endif; ?>
                    
                    <!-- Details Section on Image -->
                    <div class="vacatures-block__details w-full">
                        <?php if ($location) : ?>
                            <div class="vacatures-block__detail-item flex items-center gap-3 mb-4 pb-4 border-b border-grey/10">
                                <div class="vacatures-block__icon-wrapper flex-shrink-0">
                                    <svg class="vacatures-block__icon w-5 h-5 text-grey-dark" viewBox="0 0 12 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5.8291 0C9.32659 0 11.6581 2.91452 11.6582 5.8291C11.6582 8.00981 8.39533 11.496 6.75195 13.1133C6.22857 13.6283 5.41188 13.6526 4.86719 13.1602C3.21157 11.6632 0 8.42505 0 5.8291C6.92465e-05 2.33169 2.33169 6.90467e-05 5.8291 0ZM5.83008 3.10938C4.75701 3.10938 3.88683 3.97872 3.88672 5.05176C3.88672 6.12489 4.75694 6.99512 5.83008 6.99512C6.90309 6.99497 7.77246 6.1248 7.77246 5.05176C7.77235 3.97881 6.90302 3.10952 5.83008 3.10938Z" fill="currentColor"/>
                                    </svg>

                                </div>
                                <p class="vacatures-block__detail-text font-bold text-base text-grey-dark">
                                    <?php echo esc_html($location); ?>
                                </p>
                            </div>
                        <?php endif; ?>
                        
                        <?php if ($working_hours_text) : ?>
                            <div class="vacatures-block__detail-item flex items-center gap-3 mb-4 pb-4 border-b border-grey/10">
                                <div class="vacatures-block__icon-wrapper flex-shrink-0">
                                    <svg class="vacatures-block__icon w-5 h-5 text-grey-dark" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M0 5.9835C0 2.67891 2.67891 0 5.9835 0C9.28662 0.00357257 11.9634 2.68039 11.967 5.9835C11.967 9.2881 9.2881 11.967 5.9835 11.967C2.67891 11.967 0 9.2881 0 5.9835ZM7.87086 8.61773C8.07551 8.79942 8.38746 8.78573 8.57542 8.58682V8.58731C8.66467 8.48951 8.71135 8.36022 8.70518 8.22796C8.69901 8.0957 8.64048 7.97132 8.54251 7.88226L6.23188 5.7641V3.24105C6.23188 2.96567 6.00864 2.74243 5.73325 2.74243C5.45787 2.74243 5.23463 2.96567 5.23463 3.24105V5.98349C5.23513 6.12352 5.29448 6.25688 5.39818 6.35098L7.87086 8.61773Z" fill="currentColor"/>
                                    </svg>

                                </div>
                                <p class="vacatures-block__detail-text font-bold text-base text-grey-dark">
                                    <?php echo esc_html($working_hours_text); ?>
                                </p>
                            </div>
                        <?php endif; ?>
                        
                        <?php if ($salaris) : ?>
                            <div class="vacatures-block__detail-item flex items-center gap-3 mb-6">
                                <div class="vacatures-block__icon-wrapper flex-shrink-0">
                                    <svg class="vacatures-block__icon w-5 h-5 text-grey-dark" viewBox="0 0 15 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M12.2555 7.30241V0.663632C12.258 0.490059 12.1914 0.322621 12.0703 0.198162C11.9493 0.0737031 11.7838 0.00242071 11.6103 0H0.645315C0.471741 0.00242071 0.30624 0.0737031 0.185228 0.198162C0.0642169 0.322621 -0.00238942 0.490059 6.55331e-05 0.663632V7.30241C-0.00238942 7.47598 0.0642169 7.64342 0.185228 7.76788C0.30624 7.89234 0.471741 7.96362 0.645315 7.96604H11.6103C11.7838 7.96362 11.9493 7.89234 12.0703 7.76788C12.1914 7.64342 12.258 7.47598 12.2555 7.30241ZM6.12906 5.82139C5.11379 5.82139 4.29074 4.99835 4.29074 3.98307C4.29074 2.9678 5.11379 2.14476 6.12906 2.14476C7.14433 2.14476 7.96738 2.9678 7.96738 3.98307C7.96738 4.47063 7.7737 4.93821 7.42895 5.28296C7.0842 5.62771 6.61661 5.82139 6.12906 5.82139ZM13.3279 2.14468C13.3279 1.89087 13.5337 1.6851 13.7875 1.6851C14.0413 1.6851 14.2471 1.89087 14.2471 2.14468V8.88518C14.2464 9.47714 13.7667 9.95685 13.1747 9.95753H2.14481C1.89099 9.95753 1.68523 9.75177 1.68523 9.49795C1.68523 9.24413 1.89099 9.03837 2.14481 9.03837H13.1747C13.2593 9.03837 13.3279 8.96979 13.3279 8.88518V2.14468Z" fill="currentColor"/>
                                    </svg>
                                </div>
                                <p class="vacatures-block__detail-text font-bold text-base text-grey-dark">
                                    <?php echo esc_html($salaris); ?>
                                </p>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Button -->
                        <div class="vacatures-block__button-wrapper mt-auto">
                            <?php
                            kj_render_button(array(
                                'button_label' => __('Bekijk vacature', 'kj'),
                                'button_style' => 'primary blue',
                                'button_link_type' => 'internal',
                                'button_link_intern' => $vacature_id
                            ));
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </a>
</article>
