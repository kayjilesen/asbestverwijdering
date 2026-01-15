<?php
/**
 * Certificeringen Block
 * 
 * @package asbestverwijdering
 * @version 1.0.0
 * @author Kay Jilesen
 */

defined( 'ABSPATH' ) || exit;

$use_default = (bool) get_sub_field( 'mode' );

if ( $use_default ) {
    $logos = get_field( 'certificeringen_default_logos', 'option' );
    $content = get_field( 'certificeringen_default_content', 'option' );
} else {
$logos = get_sub_field( 'logos' );
$content = get_sub_field( 'content' );
}

$title = $content['title'] ?? '';
$text = $content['text'] ?? '';
$button = $content['button'] ?? null;

// Don't show section if no logos and no content
if ( empty( $logos ) && empty( $title ) && empty( $text ) ) {
    return;
}

// Get padding options - ACF true_false returns empty string/0 when unchecked, 1 when checked
$padding_top_value = get_sub_field( 'padding_top' );
$padding_bottom_value = get_sub_field( 'padding_bottom' );

// If field hasn't been set (null), default to true. Otherwise check if value is truthy (1, true) or falsy (0, false, empty string)
$padding_top = ( $padding_top_value === null ) ? true : ! empty( $padding_top_value );
$padding_bottom = ( $padding_bottom_value === null ) ? true : ! empty( $padding_bottom_value );

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

<section class="certificeringen-block <?php echo esc_attr( $padding_class ); ?> bg-beige">
    <div class="certificeringen-block__container container">
        <div class="certificeringen-block__wrapper grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8">
            
            <!-- Left Column: Logos -->
            <?php if ( ! empty( $logos ) ) : ?>
                <div class="certificeringen-block__logos col-span-1 lg:col-span-4 bg-beige-darker p-8 lg:p-12 flex flex-col items-center justify-center gap-8 relative overflow-hidden">
                    
                    <div class="certificeringen-block__logos-list flex flex-col items-center gap-8 relative z-10">
                        <?php foreach ( $logos as $logo ) : 
                            $logo_image = $logo['image'] ?? null;
                            $logo_link = $logo['link'] ?? '';
                            
                            if ( ! $logo_image ) {
                                continue;
                            }
                            
                            $image_id = is_array( $logo_image ) && isset( $logo_image['ID'] ) ? $logo_image['ID'] : ( is_numeric( $logo_image ) ? $logo_image : null );
                            
                            if ( ! $image_id ) {
                                continue;
                            }
                            ?>
                            
                            <?php if ( ! empty( $logo_link ) ) : ?>
                                <a href="<?php echo esc_url( $logo_link ); ?>" target="_blank" rel="noopener noreferrer" class="certificeringen-block__logo-link block transition-opacity hover:opacity-80">
                                    <?php echo wp_get_attachment_image( $image_id, 'medium', false, array( 'class' => 'certificeringen-block__logo-image max-w-full object-contain h-20' ) ); ?>
                                </a>
                            <?php else : ?>
                                <div class="certificeringen-block__logo-wrapper">
                                    <?php echo wp_get_attachment_image( $image_id, 'medium', false, array( 'class' => 'certificeringen-block__logo-image max-w-full object-contain h-20' ) ); ?>
                                </div>
                            <?php endif; ?>
                            
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
            
            <!-- Right Column: Content -->
            <?php if ( ! empty( $title ) || ! empty( $text ) || ! empty( $button ) ) : ?>
                <div class="certificeringen-block__content col-span-1 lg:col-span-8 bg-beige-darker p-8 lg:p-12 text-white relative overflow-hidden">
                    
                    <div class="certificeringen-block__content-inner relative z-10">
                        <?php if ( ! empty( $title ) ) : ?>
                            <h2 class="certificeringen-block__title font-title uppercase text-3xl md:text-4xl lg:text-[80px] text-grey-dark font-bold mb-6">
                                <?php echo esc_html( $title ); ?>
                            </h2>
                        <?php endif; ?>
                        
                        <?php if ( ! empty( $text ) ) : ?>
                            <div class="certificeringen-block__text text-wrapper prose prose-lg prose-invert mb-8 !text-grey-text">
                                <?php echo wp_kses_post( $text ); ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php if ( ! empty( $button ) ) : ?>
                            <div class="certificeringen-block__buttons flex flex-row gap-4">
                                <?php 
                                // Handle cloned button field structure
                                $button_data = isset( $button['button'] ) ? $button['button'] : $button;
                                kj_render_button( $button_data ); 
                                ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
            
        </div>
    </div>
</section>

