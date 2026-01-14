<?php
/**
 * Text & Services Block
 * 
 * @package asbestverwijdering
 * @version 1.0.0
 * @author Kay Jilesen
 */

defined( 'ABSPATH' ) || exit;

$title = get_sub_field( 'title' );
$text = get_sub_field( 'text' );
$services = get_sub_field( 'services' );
?>

<section class="text-services-block section-pd bg-white">
    <div class="text-services-block__container container">
        <div class="text-services-block__wrapper grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-24">
            
            <!-- Text Content -->
            <div class="text-services-block__content w-full col-span-1 lg:col-span-6 xl:col-span-5 order-1">
                <?php if ( $title ) : ?>
                    <h2 class="text-services-block__title font-title uppercase text-3xl md:text-4xl lg:text-5xl font-bold mb-6 text-grey-dark"><?php echo esc_html( $title ); ?></h2>
                <?php endif; ?>
                
                <?php if ( $text ) : ?>
                    <div class="text-services-block__text text-wrapper prose prose-lg">
                        <?php echo wp_kses_post( $text ); ?>
                    </div>
                <?php endif; ?>
            </div>
            
            <!-- Services -->
            <?php if ( $services && is_array( $services ) && !empty( $services ) ) : ?>
                <div class="text-services-block__services w-full col-span-1 lg:col-span-6 xl:col-span-7 order-2 flex flex-col gap-4">
                    <?php foreach ( $services as $service ) : 
                        $page = $service['page'];
                        if ( ! $page ) continue;
                        
                        $page_id = is_object( $page ) ? $page->ID : $page;
                        $page_title = is_object( $page ) ? $page->post_title : get_the_title( $page );
                        $page_url = is_object( $page ) ? get_permalink( $page->ID ) : get_permalink( $page );
                        $featured_image_id = get_post_thumbnail_id( $page_id );
                    ?>
                        <a href="<?php echo esc_url( $page_url ); ?>" class="text-services-block__service group relative block h-40 max-h-40 overflow-hidden <?php echo $featured_image_id ? '' : 'bg-grey-dark'; ?>">
                            <?php if ( $featured_image_id ) : ?>
                                <?php 
                                echo wp_get_attachment_image( 
                                    $featured_image_id, 
                                    'large', 
                                    false, 
                                    array( 
                                        'class' => 'text-services-block__service-image absolute inset-0 w-full h-full object-cover duration-500 ease-in-out' 
                                    ) 
                                ); 
                                ?>
                                
                                <!-- Overlay -->
                                <div class="text-services-block__service-overlay absolute inset-0 bg-gradient-to-t from-black/80 to-transparent transition-colors duration-300 z-10"></div>
                            <?php endif; ?>
                            
                            <!-- Content -->
                            <div class="text-services-block__service-content absolute inset-0 z-20 flex items-end justify-between p-6 text-white">
                                <h3 class="text-services-block__service-title font-title uppercase text-xl md:text-2xl font-bold">
                                    <?php echo esc_html( $page_title ); ?>
                                </h3>
                                
                                <!-- Arrow Icon -->
                                <svg class="text-services-block__service-arrow h-3 md:h-4 shrink-0 transform scale-100 text-white transition-transform duration-300" viewBox="0 0 16 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10.4825 0.398001C10.7243 0.15647 11.1165 0.156324 11.3582 0.398001L15.2989 4.33973C15.5407 4.58159 15.5407 4.97364 15.2989 5.2155L11.3582 9.15723C11.1165 9.39891 10.7243 9.39876 10.4825 9.15723C10.2407 8.91537 10.2407 8.52252 10.4825 8.28066L13.366 5.39694L0.836077 5.39694C0.494058 5.39694 0.216796 5.11966 0.216796 4.77761C0.216797 4.43557 0.494058 4.15829 0.836077 4.15829L13.366 4.15829L10.4825 1.27457C10.2407 1.03271 10.2407 0.639861 10.4825 0.398001Z" fill="currentColor" stroke="currentColor" stroke-width="0.43372"/>
                                </svg>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            
        </div>
    </div>
</section>