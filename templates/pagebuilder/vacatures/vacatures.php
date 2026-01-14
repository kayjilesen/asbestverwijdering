<?php
/**
 * Vacatures Block
 * 
 * @package asbestverwijdering
 * @version 1.0.0
 * @author Kay Jilesen
 */

defined( 'ABSPATH' ) || exit;

$title = get_sub_field( 'title' );
$subtitle = get_sub_field( 'subtitle' );
$source = get_sub_field( 'source' ) ?: 'manual';

// Get padding options - ACF true_false returns empty string/0 when unchecked, 1 when checked
$padding_top_value = get_sub_field( 'padding_top' );
$padding_bottom_value = get_sub_field( 'padding_bottom' );

// If field hasn't been set (null), default to true. Otherwise check if value is truthy (1, true) or falsy (0, false, empty string)
$padding_top = ( $padding_top_value === null ) ? true : ! empty( $padding_top_value );
$padding_bottom = ( $padding_bottom_value === null ) ? true : ! empty( $padding_bottom_value );

// Get vacatures based on source
$vacatures = array();

if ( $source === 'auto' ) {
    // Auto mode: get vacatures from current context or query
    $post_type = get_sub_field( 'post_type' ) ?: 'vacature';
    
    // Check if we're on an archive page
    if ( is_archive() && is_post_type_archive('vacature') ) {
        global $wp_query;
        $vacatures = $wp_query->posts;
    } else {
        // Get all recent posts of the specified post type (maximaal)
        $query_args = array(
            'post_type'      => $post_type,
            'posts_per_page' => -1,
            'post_status'    => 'publish',
            'orderby'        => 'date',
            'order'          => 'DESC',
        );
        
        $query = new WP_Query( $query_args );
        $vacatures = $query->posts;
        wp_reset_postdata();
    }
} else {
    // Manual mode: get selected vacatures
    $selected_vacatures = get_sub_field( 'vacatures' );
    if ( $selected_vacatures && is_array( $selected_vacatures ) ) {
        $vacatures = $selected_vacatures;
    }
}

// Don't show section if no vacatures
if ( empty( $vacatures ) ) {
    return;
}

// Set padding classes based on options
$padding_classes = array();
if ( $padding_top ) {
    $padding_classes[] = 'pt-20 lg:pt-[120px]';
}
if ( $padding_bottom ) {
    $padding_classes[] = 'pb-20 lg:pb-[120px]';
}
$padding_class = ! empty( $padding_classes ) ? implode( ' ', $padding_classes ) : '';
?>

<section class="vacatures-block <?php echo esc_attr( $padding_class ); ?> bg-white">
    <div class="vacatures-block__container container">
        
        <?php if ( $subtitle || $title ) : ?>
            <div class="vacatures-block__header mb-12 text-center">
                <?php if ( $subtitle ) : ?>
                    <p class="vacatures-block__subtitle text-lg text-grey mb-2"><?php echo esc_html( $subtitle ); ?></p>
                <?php endif; ?>
                
                <?php if ( $title ) : ?>
                    <h2 class="vacatures-block__title text-4xl font-bold"><?php echo esc_html( $title ); ?></h2>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        
        <div class="vacatures-block__grid grid grid-cols-1 md:grid-cols-2 gap-8">
            <?php foreach ( $vacatures as $vacature ) : 
                get_template_part( 'templates/components/vacature-card', null, array(
                    'vacature' => $vacature
                ) );
            endforeach; ?>
        </div>
        
        <?php 
        // Show pagination if we're on archive page and using auto source
        if ( $source === 'auto' && is_archive() && is_post_type_archive('vacature') ) : 
            global $wp_query;
            if ( $wp_query->max_num_pages > 1 ) :
        ?>
            <div class="vacatures-block__pagination mt-12">
                <?php echo kj_pagination(); ?>
            </div>
        <?php 
            endif;
        endif; 
        ?>
    </div>
</section>

