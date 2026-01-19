<?php
/**
 * Pagebuilder Loop
 * 
 * @package asbestverwijdering
 * @version 1.0.0
 * @author Kay Jilesen
 */

defined( 'ABSPATH' ) || exit;

// Get flexible content field
if ( have_rows( 'pagebuilder' ) ) :
    $first_block_is_hero = false;
    $row_index = 0;

    while ( have_rows( 'pagebuilder' ) ) : the_row();

        $layout = get_row_layout();

        // Check if first block is hero
        if ( $row_index === 0 && $layout === 'hero' ) {
            $first_block_is_hero = true;
        }

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

        // Add breadcrumbs after hero block (but not on homepage)
        if ( $row_index === 0 && $first_block_is_hero && ! is_front_page() ) {
            ?>
            <!-- Breadcrumbs -->
            <section class="breadcrumbs-section bg-beige border-b border-grey-light">
                <div class="container py-4">
                    <?php echo kj_breadcrumbs(); ?>
                </div>
            </section>
            <?php
        }

        $row_index++;

    endwhile;
endif;
