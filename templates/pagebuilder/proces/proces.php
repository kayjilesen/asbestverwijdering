<?php
/**
 * Proces Block
 *
 * Layout:
 * - Titel en beschrijving gecentreerd boven de content (volledige breedte)
 * - Daaronder 2 kolommen (60% - 40%):
 *   - Links: stappen met nummering en gele verbindingslijn (accordion)
 *   - Rechts: staande afbeelding
 *
 * @package asbestverwijdering
 */

defined( 'ABSPATH' ) || exit;

$use_default = (bool) get_sub_field( 'mode' );

if ( $use_default ) {
    $title       = get_field( 'proces_default_title', 'option' );
    $description = get_field( 'proces_default_description', 'option' );
    $buttons     = get_field( 'proces_default_buttons', 'option' );
    $processes   = get_field( 'proces_default_processen', 'option' );
    $image       = get_field( 'proces_default_image', 'option' );
} else {
    $title       = get_sub_field( 'title' );
    $description = get_sub_field( 'description' );
    $buttons     = get_sub_field( 'buttons' );
    $processes   = get_sub_field( 'processen' );
    $image       = get_sub_field( 'image' );
}

// Normalize buttons (repeater of clone group_button_fields)
$button_list = array();
if ( is_array( $buttons ) ) {
    foreach ( $buttons as $btn ) {
        if ( isset( $btn['button'] ) && is_array( $btn['button'] ) && ! empty( $btn['button']['button_label'] ) ) {
            $button_list[] = $btn['button'];
        } elseif ( isset( $btn['button_label'] ) && ! empty( $btn['button_label'] ) ) {
            $button_list[] = $btn;
        }
    }
}

$process_count = is_array( $processes ) ? count( $processes ) : 0;
$block_id      = 'proces-' . uniqid();

// Get padding options
$padding_top_value    = get_sub_field( 'padding_top' );
$padding_bottom_value = get_sub_field( 'padding_bottom' );
$padding_top          = ( $padding_top_value === null ) ? true : ! empty( $padding_top_value );
$padding_bottom       = ( $padding_bottom_value === null ) ? true : ! empty( $padding_bottom_value );

$padding_classes = array();
if ( $padding_top ) {
    $padding_classes[] = 'pt-20 lg:pt-[120px]';
}
if ( $padding_bottom ) {
    $padding_classes[] = 'pb-20 lg:pb-[120px]';
}
$padding_class = ! empty( $padding_classes ) ? implode( ' ', $padding_classes ) : '';

if ( ! $title && ! $description && ! $process_count ) {
    return;
}
?>

<section class="proces-block <?php echo esc_attr( $padding_class ); ?> bg-beige" id="<?php echo esc_attr( $block_id ); ?>">
    <div class="proces-block__container container">

        <!-- Header (centered, full width) -->
        <?php if ( $title || $description ) : ?>
        <div class="proces-block__header text-center mb-10 lg:mb-16">
            <?php if ( $title ) : ?>
                <h2 class="proces-block__title font-title text-4xl md:text-5xl lg:text-6xl uppercase font-bold text-secondary mb-4"><?php echo esc_html( $title ); ?></h2>
            <?php endif; ?>

            <?php if ( $description ) : ?>
                <div class="proces-block__description text-grey-text text-base md:text-lg leading-relaxed text-wrapper max-w-2xl mx-auto">
                    <?php echo wp_kses_post( nl2br( $description ) ); ?>
                </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <!-- Content: Steps + Image -->
        <div class="proces-block__wrapper flex flex-col lg:flex-row gap-12 lg:gap-16">

            <!-- Left Content (60%) - Steps -->
            <div class="proces-block__left w-full lg:w-3/5">
                <!-- Steps (Accordion) -->
                <?php if ( $process_count ) : ?>
                <div class="proces-block__steps">
                    <?php foreach ( $processes as $index => $item ) :
                        $step_number = $index + 1;
                        $item_title  = $item['title'] ?? '';
                        $item_desc   = $item['description'] ?? '';
                        $is_last     = $index === $process_count - 1;
                        $is_active   = $index === 0;
                        $step_id     = $block_id . '-step-' . $index;
                        ?>
                        <div class="proces-block__step <?php echo $is_active ? 'is-active' : ''; ?>" data-proces-step>
                            <!-- Step header (clickable) -->
                            <button
                                type="button"
                                class="proces-block__step-header flex gap-5 lg:gap-8 w-full text-left cursor-pointer"
                                aria-expanded="<?php echo $is_active ? 'true' : 'false'; ?>"
                                aria-controls="<?php echo esc_attr( $step_id . '-content' ); ?>"
                                data-proces-toggle
                            >
                                <!-- Number column with line -->
                                <div class="proces-block__step-number-col relative flex flex-col items-center">
                                    <!-- Number box (rotated only when active) -->
                                    <div class="proces-block__step-number flex-shrink-0 w-12 h-12 lg:w-14 lg:h-14 border-2 border-primary bg-transparent flex items-center justify-center font-title text-xl lg:text-2xl font-bold relative z-10 <?php echo $is_active ? 'rotate-[8deg]' : ''; ?>">
                                        <span class="proces-block__step-number-text <?php echo $is_active ? '-rotate-[8deg]' : ''; ?> text-secondary"><?php echo esc_html( $step_number ); ?></span>
                                    </div>
                                    <!-- Vertical line -->
                                    <?php if ( ! $is_last ) : ?>
                                    <div class="proces-block__step-line flex-1 w-0.5 bg-primary mt-0"></div>
                                    <?php endif; ?>
                                </div>

                                <!-- Title column -->
                                <div class="proces-block__step-title-wrapper flex-1 pt-3 pb-4">
                                    <?php if ( $item_title ) : ?>
                                        <h3 class="proces-block__step-title font-title uppercase text-xl lg:text-2xl text-secondary flex items-center gap-3">
                                            <?php echo esc_html( $item_title ); ?>
                                            <span class="proces-block__step-icon text-secondary transition-transform duration-300">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                </svg>
                                            </span>
                                        </h3>
                                    <?php endif; ?>
                                </div>
                            </button>

                            <!-- Step content (collapsible) -->
                            <div
                                class="proces-block__step-content overflow-hidden transition-all duration-300 ease-in-out"
                                id="<?php echo esc_attr( $step_id . '-content' ); ?>"
                                data-proces-content
                            >
                                <div class="proces-block__step-content-inner flex gap-5 lg:gap-8">
                                    <!-- Spacer for number column -->
                                    <div class="proces-block__step-spacer flex-shrink-0 w-12 lg:w-14 relative flex flex-col items-center">
                                        <?php if ( ! $is_last ) : ?>
                                        <div class="proces-block__step-line-content flex-1 w-0.5 bg-primary"></div>
                                        <?php endif; ?>
                                    </div>

                                    <!-- Content column -->
                                    <div class="proces-block__step-text-wrapper flex-1 pb-6 lg:pb-8">
                                        <?php if ( $item_desc ) : ?>
                                            <div class="proces-block__step-text text-grey-text text-sm lg:text-base leading-relaxed">
                                                <?php echo wp_kses_post( nl2br( $item_desc ) ); ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>

                <!-- Buttons -->
                <?php if ( ! empty( $button_list ) ) : ?>
                    <div class="proces-block__buttons mt-10 lg:mt-12 flex flex-wrap gap-3">
                        <?php foreach ( $button_list as $btn ) : ?>
                            <?php kj_render_button( $btn ); ?>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Right Content (40%) - Image -->
            <?php if ( $image && ! empty( $image['url'] ) ) : ?>
            <div class="proces-block__right w-full lg:w-2/5">
                <div class="proces-block__image-wrapper relative h-full min-h-[400px] lg:min-h-[600px]">
                    <img
                        src="<?php echo esc_url( $image['sizes']['large'] ?? $image['url'] ); ?>"
                        alt="<?php echo esc_attr( $image['alt'] ?? '' ); ?>"
                        class="proces-block__image absolute inset-0 w-full h-full object-cover"
                        loading="lazy"
                    >
                </div>
            </div>
            <?php endif; ?>

        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const block = document.getElementById('<?php echo esc_js( $block_id ); ?>');
    if (!block) return;

    const steps = block.querySelectorAll('[data-proces-step]');
    const toggles = block.querySelectorAll('[data-proces-toggle]');

    toggles.forEach(function(toggle) {
        toggle.addEventListener('click', function() {
            const step = this.closest('[data-proces-step]');
            const content = step.querySelector('[data-proces-content]');
            const isActive = step.classList.contains('is-active');

            // Close all other steps
            steps.forEach(function(otherStep) {
                if (otherStep !== step) {
                    otherStep.classList.remove('is-active');
                    const otherToggle = otherStep.querySelector('[data-proces-toggle]');
                    const otherContent = otherStep.querySelector('[data-proces-content]');
                    const otherNumberBox = otherStep.querySelector('.proces-block__step-number');
                    const otherNumberText = otherStep.querySelector('.proces-block__step-number-text');
                    if (otherToggle) otherToggle.setAttribute('aria-expanded', 'false');
                    if (otherContent) otherContent.style.maxHeight = '0px';
                    if (otherNumberBox) otherNumberBox.classList.remove('rotate-[8deg]');
                    if (otherNumberText) otherNumberText.classList.remove('-rotate-[8deg]');
                }
            });

            // Toggle current step
            const numberBox = step.querySelector('.proces-block__step-number');
            const numberText = step.querySelector('.proces-block__step-number-text');
            
            if (isActive) {
                step.classList.remove('is-active');
                this.setAttribute('aria-expanded', 'false');
                content.style.maxHeight = '0px';
                if (numberBox) numberBox.classList.remove('rotate-[8deg]');
                if (numberText) numberText.classList.remove('-rotate-[8deg]');
            } else {
                step.classList.add('is-active');
                this.setAttribute('aria-expanded', 'true');
                content.style.maxHeight = content.scrollHeight + 'px';
                if (numberBox) numberBox.classList.add('rotate-[8deg]');
                if (numberText) numberText.classList.add('-rotate-[8deg]');
            }
        });
    });

    // Initialize first step as open
    const firstStep = block.querySelector('[data-proces-step]');
    if (firstStep) {
        const firstContent = firstStep.querySelector('[data-proces-content]');
        if (firstContent) {
            firstContent.style.maxHeight = firstContent.scrollHeight + 'px';
        }
    }
});
</script>
