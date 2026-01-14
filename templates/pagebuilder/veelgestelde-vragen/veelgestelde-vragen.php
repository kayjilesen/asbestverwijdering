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

// Don't show section if no questions
if ( empty( $questions ) ) {
    return;
}

// Unique ID for this FAQ block
$faq_id = 'faq-' . uniqid();
?>

<section class="veelgestelde-vragen-block section-pd bg-grey-dark relative overflow-hidden">
    <!-- Decorative blocks (left-bottom) -->
    <div class="veelgestelde-vragen-block__decor pointer-events-none absolute -left-[140px] bottom-0 w-[280px] h-[210px]" aria-hidden="true">
        <div class="absolute left-[140px] top-[140px] size-[70px] bg-grey-decor"></div>
        <div class="absolute left-[210px] top-0 size-[70px] bg-grey-decor"></div>
        <div class="absolute left-[140px] top-[70px] size-[70px] border-2 border-grey-decor"></div>
        <div class="absolute left-0 top-[140px] size-[70px] border-2 border-grey-decor"></div>
        <div class="absolute left-[70px] top-[70px] size-[70px] bg-grey-decor border-2 border-grey-decor"></div>
    </div>

    <!-- Decorative blocks (right-top) -->
    <div class="veelgestelde-vragen-block__decor pointer-events-none absolute right-0 top-0 w-[210px] h-[140px]" aria-hidden="true">
        <div class="absolute right-0 top-[70px] size-[70px] bg-grey-decor"></div>
        <div class="absolute right-0 top-0 size-[70px] border-2 border-grey-decor"></div>
        <div class="absolute right-[70px] top-0 size-[70px] bg-grey-decor border-2 border-grey-decor"></div>
        <div class="absolute right-[140px] top-[70px] size-[70px] border-2 border-grey-decor"></div>
    </div>

    <div class="veelgestelde-vragen-block__container container">
        <div class="veelgestelde-vragen-block__wrapper w-full mx-auto flex flex-col items-center">
            
            <!-- Header -->
            <div class="veelgestelde-vragen-block__header w-full flex flex-col items-center text-center mb-10 lg:mb-12">
                <?php if ( $title ) : ?>
                    <h2 class="veelgestelde-vragen-block__title font-title text-[32px] md:text-[40px] lg:text-[48px] leading-none uppercase text-white max-w-[748px] mx-auto">
                        <?php echo esc_html( $title ); ?>
                    </h2>
                <?php endif; ?>
                
                <?php if ( $subtitle ) : ?>
                    <p class="veelgestelde-vragen-block__subtitle font-sans font-normal text-base leading-[1.83] text-white max-w-[860px] mx-auto mt-4">
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
                    <div class="veelgestelde-vragen-block__item bg-grey-surface px-6 py-[18px] <?php echo $is_active ? 'is-active' : ''; ?>">
                        <button 
                            class="veelgestelde-vragen-block__question w-full text-left flex items-center justify-between gap-4 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-primary focus-visible:ring-offset-2 focus-visible:ring-offset-grey-dark transition-all"
                            type="button"
                            aria-expanded="<?php echo $is_active ? 'true' : 'false'; ?>"
                            aria-controls="<?php echo esc_attr( $item_id . '-answer' ); ?>"
                            data-faq-toggle
                        >
                            <span class="veelgestelde-vragen-block__question-text font-sans font-bold text-[18px] leading-[1.2] text-white pr-8">
                                <?php echo esc_html( $question ); ?>
                            </span>
                            <span class="veelgestelde-vragen-block__icon flex-shrink-0 size-4 flex items-center justify-center text-primary transition-transform duration-300">
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
                            <div class="veelgestelde-vragen-block__answer font-sans font-normal text-[18px] leading-[1.4] text-white/45">
                                <?php echo wp_kses_post( $answer ); ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
        </div>
    </div>
</section>


