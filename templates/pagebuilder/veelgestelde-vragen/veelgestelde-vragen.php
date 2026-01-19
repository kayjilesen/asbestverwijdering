<?php
/**
 * Veelgestelde Vragen Block
 * 
 * @package asbestverwijdering
 * @version 1.0.0
 * @author Kay Jilesen
 */

defined( 'ABSPATH' ) || exit;

$subtitle = get_sub_field( 'subtitle' );
$title = get_sub_field( 'title' );
$questions = get_sub_field( 'questions' );

// Get padding options
$padding_top_value = get_sub_field( 'padding_top' );
$padding_bottom_value = get_sub_field( 'padding_bottom' );

// Get background color
$background_color = get_sub_field( 'background_color' ) ?: 'grey-dark';
$bg_class = 'bg-' . $background_color;

// Set text colors based on background color
$is_dark_bg = in_array( $background_color, array( 'grey-dark', 'secondary' ), true );
$text_color_class = $is_dark_bg ? 'text-white' : 'text-grey-dark';
$text_color_subtitle_class = $is_dark_bg ? 'text-white' : 'text-grey-dark';
$text_color_answer_class = $is_dark_bg ? 'text-white/45' : 'text-grey-text';
$focus_ring_offset_class = $is_dark_bg ? 'focus-visible:ring-offset-grey-dark' : 'focus-visible:ring-offset-white';

// If field hasn't been set (null), default to true
$padding_top = ( $padding_top_value === null ) ? true : ! empty( $padding_top_value );
$padding_bottom = ( $padding_bottom_value === null ) ? true : ! empty( $padding_bottom_value );

// Set padding classes
$padding_classes = array();
if ( $padding_top ) {
    $padding_classes[] = 'pt-20 lg:pt-[120px]';
}
if ( $padding_bottom ) {
    $padding_classes[] = 'pb-20 lg:pb-[120px]';
}
$padding_class = ! empty( $padding_classes ) ? implode( ' ', $padding_classes ) : '';

// Don't show section if no questions
if ( empty( $questions ) ) {
    return;
}

// Unique ID for this FAQ block
$faq_id = 'faq-' . uniqid();
?>

<section class="veelgestelde-vragen-block <?php echo esc_attr( $padding_class ); ?> <?php echo esc_attr( $bg_class ); ?> relative overflow-hidden">
    <!-- Decorative SVG (right-top) -->
    <div class="veelgestelde-vragen-block__svg veelgestelde-vragen-block__svg--top absolute right-0 top-20 lg:top-[120px] h-[60px] lg:h-[107px] w-auto z-0 pointer-events-none" aria-hidden="true">
        <svg width="317" height="108" viewBox="0 0 317 108" fill="none" xmlns="http://www.w3.org/2000/svg" class="h-full w-auto">
            <rect x="1" y="1" width="401.97" height="105.433" rx="6" stroke="#FFD500" stroke-width="2"/>
        </svg>
    </div>

    <!-- Decorative SVG (left-bottom) -->
    <div class="veelgestelde-vragen-block__svg veelgestelde-vragen-block__svg--bottom absolute left-0 bottom-20 lg:bottom-[120px] h-[90px] lg:h-[160px] w-auto z-0 pointer-events-none translate-y-[60%]" aria-hidden="true">
        <svg width="317" height="181" viewBox="0 0 317 181" fill="none" xmlns="http://www.w3.org/2000/svg" class="h-full w-auto">
            <rect x="229.477" y="1" width="86.37" height="86.373" rx="6" stroke="#FFD500" stroke-width="2"/>
            <rect x="1" y="93.5" width="226.476" height="86.373" rx="6" stroke="#FFD500" stroke-width="2"/>
        </svg>
    </div>

    <div class="veelgestelde-vragen-block__container container relative z-20">
        <div class="veelgestelde-vragen-block__wrapper w-full mx-auto flex flex-col items-center">
            
            <!-- Header -->
            <div class="veelgestelde-vragen-block__header w-full flex flex-col items-center text-center mb-10 lg:mb-12">
                <?php if ( $title ) : ?>
                    <h2 class="veelgestelde-vragen-block__title font-title text-[32px] md:text-[40px] lg:text-[48px] leading-none uppercase text-grey-dark mx-auto">
                        <?php echo esc_html( $title ); ?>
                    </h2>
                <?php endif; ?>
                
                <?php if ( $subtitle ) : ?>
                    <p class="veelgestelde-vragen-block__subtitle font-sans font-normal text-base leading-[1.83] text-grey-dark mx-auto mt-4">
                        <?php echo esc_html( $subtitle ); ?>
                    </p>
                <?php endif; ?>
            </div>
            
            <!-- FAQ Items -->
            <div class="veelgestelde-vragen-block__items w-full max-w-[861px] mx-auto flex flex-col gap-[14px]" id="<?php echo esc_attr( $faq_id ); ?>">
                <?php foreach ( $questions as $index => $question_item ) : 
                    $question = $question_item['question'] ?? '';
                    $answer = $question_item['answer'] ?? '';
                    $item_id = $faq_id . '-item-' . $index;
                    $is_active = ( 0 === $index );
                    
                    if ( empty( $question ) || empty( $answer ) ) {
                        continue;
                    }
                    ?>
                    <div class="veelgestelde-vragen-block__item bg-beige <?php echo $is_active ? 'is-active' : ''; ?> relative">
                        <button 
                            class="veelgestelde-vragen-block__question w-full text-left flex items-center justify-between gap-4 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-primary focus-visible:ring-offset-2 <?php echo esc_attr( $focus_ring_offset_class ); ?> transition-all px-6 py-[18px]"
                            type="button"
                            aria-expanded="<?php echo $is_active ? 'true' : 'false'; ?>"
                            aria-controls="<?php echo esc_attr( $item_id . '-answer' ); ?>"
                            data-faq-toggle
                        >
                            <span class="veelgestelde-vragen-block__question-text font-sans font-bold text-[18px] leading-[1.2] <?php echo esc_attr( $text_color_class ); ?> pr-8">
                                <?php echo esc_html( $question ); ?>
                            </span>
                            <span class="veelgestelde-vragen-block__icon flex-shrink-0 size-4 flex items-center justify-center text-grey-dark transition-transform duration-300">
                                <svg class="w-full h-full" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </span>
                        </button>
                        
                        <div 
                            class="veelgestelde-vragen-block__answer-wrapper overflow-hidden transition-all duration-300 ease-in-out"
                            id="<?php echo esc_attr( $item_id . '-answer' ); ?>"
                            data-faq-content
                        >
                            <div class="veelgestelde-vragen-block__answer font-sans font-normal text-sm md:text-base leading-[1.4] <?php echo esc_attr( $text_color_answer_class ); ?> px-6 pb-[18px]">
                                <?php echo wp_kses_post( $answer ); ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
        </div>
    </div>
</section>


