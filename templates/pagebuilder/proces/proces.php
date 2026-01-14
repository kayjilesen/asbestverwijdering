<?php
/**
 * Proces Block
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
} else {
    $title       = get_sub_field( 'title' );
    $description = get_sub_field( 'description' );
    $buttons     = get_sub_field( 'buttons' );
    $processes   = get_sub_field( 'processen' );
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

if ( ! $title && ! $description && ! $process_count ) {
    return;
}
?>

<section class="proces-block <?php echo esc_attr( $padding_class ); ?> bg-white" id="<?php echo esc_attr( $block_id ); ?>">
    <div class="proces-block__container container">
        <div class="proces-block__wrapper flex flex-col lg:flex-row gap-12 lg:gap-16">

            <!-- Left Content -->
            <div class="proces-block__left w-full lg:w-1/3 space-y-6">
                <?php if ( $title ) : ?>
                    <h2 class="proces-block__title font-title text-4xl md:text-5xl lg:text-6xl uppercase font-bold text-secondary"><?php echo esc_html( $title ); ?></h2>
                <?php endif; ?>

                <?php if ( $description ) : ?>
                    <div class="proces-block__description text-grey-text text-base md:text-lg leading-relaxed text-wrapper">
                        <?php echo wp_kses_post( nl2br( $description ) ); ?>
                    </div>
                <?php endif; ?>

                <?php if ( ! empty( $button_list ) ) : ?>
                    <div class="proces-block__buttons pt-2 flex flex-wrap gap-3">
                        <?php foreach ( $button_list as $btn ) : ?>
                            <?php kj_render_button( $btn ); ?>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Right Content -->
            <?php if ( $process_count ) : ?>
            <div class="proces-block__right w-full lg:w-2/3 bg-secondary text-white">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-0">

                    <!-- Nav -->
                    <div class="proces-block__nav-wrapper col-span-1 flex flex-row items-start p-6 md:p-8 lg:p-10 !pr-0">
                        <!-- Navigation Arrows -->
                        <div class="proces-block__nav-arrows flex flex-col gap-2 flex-shrink-0 -ml-4 -mt-3">
                            <button type="button" class="proces-block__nav-arrow proces-block__nav-arrow--prev disabled" data-proces-nav="prev" aria-label="Vorige stap">
                                <svg viewBox="0 0 16 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10.4825 0.398001C10.7243 0.15647 11.1165 0.156324 11.3582 0.398001L15.2989 4.33973C15.5407 4.58159 15.5407 4.97364 15.2989 5.2155L11.3582 9.15723C11.1165 9.39891 10.7243 9.39876 10.4825 9.15723C10.2407 8.91537 10.2407 8.52252 10.4825 8.28066L13.366 5.39694L0.836077 5.39694C0.494058 5.39694 0.216796 5.11966 0.216796 4.77761C0.216797 4.43557 0.494058 4.15829 0.836077 4.15829L13.366 4.15829L10.4825 1.27457C10.2407 1.03271 10.2407 0.639861 10.4825 0.398001Z" fill="currentColor" stroke="currentColor" stroke-width="0.43372"/>
                                </svg>
                            </button>
                            <button type="button" class="proces-block__nav-arrow proces-block__nav-arrow--next" data-proces-nav="next" aria-label="Volgende stap">
                                <svg viewBox="0 0 16 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10.4825 0.398001C10.7243 0.15647 11.1165 0.156324 11.3582 0.398001L15.2989 4.33973C15.5407 4.58159 15.5407 4.97364 15.2989 5.2155L11.3582 9.15723C11.1165 9.39891 10.7243 9.39876 10.4825 9.15723C10.2407 8.91537 10.2407 8.52252 10.4825 8.28066L13.366 5.39694L0.836077 5.39694C0.494058 5.39694 0.216796 5.11966 0.216796 4.77761C0.216797 4.43557 0.494058 4.15829 0.836077 4.15829L13.366 4.15829L10.4825 1.27457C10.2407 1.03271 10.2407 0.639861 10.4825 0.398001Z" fill="currentColor" stroke="currentColor" stroke-width="0.43372"/>
                                </svg>
                            </button>
                        </div>

                        <!-- Scrollbar -->
                        <div class="proces-block__scrollbar-wrapper h-full relative mr-4">
                            <div class="proces-block__scrollbar-track absolute top-0 left-0 w-full bg-black/20"></div>
                            <div class="proces-block__scrollbar-indicator absolute top-0 left-0 w-full bg-primary" id="<?php echo esc_attr( $block_id . '-scrollbar-indicator' ); ?>"></div>
                        </div>

                        <!-- Steps List -->
                        <div class="proces-block__nav-list-wrapper relative flex-1 w-full">
                            <div class="proces-block__nav-list-gradient proces-block__nav-list-gradient--top"></div>
                            <div class="proces-block__nav-list flex flex-col gap-0 relative w-full overflow-y-auto" id="<?php echo esc_attr( $block_id . '-nav-list' ); ?>">
                                <?php foreach ( $processes as $index => $item ) : 
                                    $is_active = $index === 0;
                                    $step_id   = $block_id . '-' . $index;
                                    $title_i   = $item['title'] ?? '';
                                    ?>
                                    <?php if ( $title_i ) : ?>
                                    <button type="button"
                                        class="proces-block__step <?php echo $is_active ? 'is-active' : ''; ?>"
                                        data-proces-step="<?php echo esc_attr( $step_id ); ?>"
                                        data-proces-index="<?php echo esc_attr( $index ); ?>"
                                        aria-controls="<?php echo esc_attr( $step_id . '-content' ); ?>"
                                        aria-expanded="<?php echo $is_active ? 'true' : 'false'; ?>">
                                        <span class="proces-block__step-title"><?php echo esc_html( $title_i ); ?></span>
                                    </button>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                            <div class="proces-block__nav-list-gradient proces-block__nav-list-gradient--bottom"></div>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="proces-block__details col-span-1 bg-grey-light text-grey-dark p-6 md:p-8 lg:p-10 relative">
                        <?php foreach ( $processes as $index => $item ) : 
                            $is_active    = $index === 0;
                            $step_id      = $block_id . '-' . $index;
                            $item_title   = $item['title'] ?? '';
                            $item_desc    = $item['description'] ?? '';
                            ?>
                            <div class="proces-block__content <?php echo $is_active ? 'is-active' : 'hidden'; ?>" data-proces-content="<?php echo esc_attr( $step_id ); ?>" id="<?php echo esc_attr( $step_id . '-content' ); ?>">
                                <?php if ( $item_title ) : ?>
                                    <div class="proces-block__content-header mb-4">
                                        <div class="proces-block__content-ebadge-wrapper mb-4">
                                            <span class="proces-block__content-badge">Stap <?php echo esc_html( $index + 1 ); ?> / <?php echo esc_html( $process_count ); ?></span>
                                        </div>
                                        <h3 class="proces-block__content-title font-title uppercase text-2xl md:text-3xl text-secondary mb-0"><?php echo esc_html( $item_title ); ?></h3>
                                    </div>
                                <?php endif; ?>

                                <?php if ( $item_desc ) : ?>
                                    <div class="proces-block__content-text text-grey text-sm md:text-base leading-relaxed">
                                        <?php echo wp_kses_post( nl2br( $item_desc ) ); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>

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
    const contents = block.querySelectorAll('[data-proces-content]');
    const navList = block.querySelector('#<?php echo esc_js( $block_id . '-nav-list' ); ?>');
    const navListWrapper = block.querySelector('.proces-block__nav-list-wrapper');
    const scrollbarIndicator = block.querySelector('#<?php echo esc_js( $block_id . '-scrollbar-indicator' ); ?>');
    const scrollbarWrapper = block.querySelector('.proces-block__scrollbar-wrapper');
    const prevBtn = block.querySelector('.proces-block__nav-arrow--prev');
    const nextBtn = block.querySelector('.proces-block__nav-arrow--next');
    
    let currentIndex = 0;
    const totalSteps = steps.length;

    function updateScrollbarIndicator() {
        if (!scrollbarIndicator || !scrollbarWrapper || totalSteps === 0) return;
        
        const wrapperHeight = scrollbarWrapper.clientHeight;
        const indicatorHeight = wrapperHeight / totalSteps;
        const indicatorTop = (currentIndex / totalSteps) * wrapperHeight;
        
        scrollbarIndicator.style.height = indicatorHeight + 'px';
        scrollbarIndicator.style.top = indicatorTop + 'px';
    }

    function updateGradients() {
        if (!navList || !navListWrapper) return;
        
        const scrollTop = navList.scrollTop;
        const scrollHeight = navList.scrollHeight;
        const clientHeight = navList.clientHeight;
        const isScrollable = scrollHeight > clientHeight;
        
        if (!isScrollable) {
            navListWrapper.classList.remove('scrollable-top', 'scrollable-bottom');
            return;
        }
        
        // Check if scrolled from top
        if (scrollTop > 1) {
            navListWrapper.classList.add('scrollable-top');
        } else {
            navListWrapper.classList.remove('scrollable-top');
        }
        
        // Check if scrolled to bottom (with 1px tolerance for rounding)
        if (scrollTop + clientHeight < scrollHeight - 1) {
            navListWrapper.classList.add('scrollable-bottom');
        } else {
            navListWrapper.classList.remove('scrollable-bottom');
        }
    }

    function updateNavigation() {
        if (prevBtn) {
            prevBtn.classList.toggle('disabled', currentIndex === 0);
        }
        if (nextBtn) {
            nextBtn.classList.toggle('disabled', currentIndex === totalSteps - 1);
        }
    }

    function activate(stepId) {
        const stepIndex = parseInt(block.querySelector('[data-proces-step="' + stepId + '"]')?.getAttribute('data-proces-index') || '0');
        currentIndex = stepIndex;

        steps.forEach(function(btn) {
            const isActive = btn.getAttribute('data-proces-step') === stepId;
            btn.classList.toggle('is-active', isActive);
            btn.setAttribute('aria-expanded', isActive ? 'true' : 'false');
        });

        contents.forEach(function(panel) {
            const isActive = panel.getAttribute('data-proces-content') === stepId;
            panel.classList.toggle('is-active', isActive);
            panel.classList.toggle('hidden', !isActive);
        });

        // Scroll active step into view
        const activeStep = block.querySelector('[data-proces-step="' + stepId + '"]');
        if (activeStep && navList) {
            const stepTop = activeStep.offsetTop;
            const stepHeight = activeStep.offsetHeight;
            const listHeight = navList.clientHeight;
            const scrollTop = navList.scrollTop;
            
            if (stepTop < scrollTop) {
                navList.scrollTop = stepTop;
            } else if (stepTop + stepHeight > scrollTop + listHeight) {
                navList.scrollTop = stepTop + stepHeight - listHeight;
            }
        }

        updateScrollbarIndicator();
        updateNavigation();
        updateGradients();
    }

    function navigate(direction) {
        if (direction === 'prev' && currentIndex > 0) {
            const prevStep = steps[currentIndex - 1];
            activate(prevStep.getAttribute('data-proces-step'));
        } else if (direction === 'next' && currentIndex < totalSteps - 1) {
            const nextStep = steps[currentIndex + 1];
            activate(nextStep.getAttribute('data-proces-step'));
        }
    }

    steps.forEach(function(btn) {
        btn.addEventListener('click', function() {
            activate(this.getAttribute('data-proces-step'));
        });
    });

    if (prevBtn) {
        prevBtn.addEventListener('click', function() {
            if (!this.classList.contains('disabled')) {
                navigate('prev');
            }
        });
    }

    if (nextBtn) {
        nextBtn.addEventListener('click', function() {
            if (!this.classList.contains('disabled')) {
                navigate('next');
            }
        });
    }

    // Initialize scrollbar indicator and gradients
    updateScrollbarIndicator();
    updateGradients();
    
    // Update gradients on scroll
    if (navList) {
        navList.addEventListener('scroll', updateGradients);
    }

    // Initialize navigation
    updateNavigation();
    
    // Initialize with first step
    if (steps.length > 0) {
        activate(steps[0].getAttribute('data-proces-step'));
    }

    // Update scrollbar indicator and gradients on resize
    window.addEventListener('resize', function() {
        updateScrollbarIndicator();
        updateGradients();
    });
});
</script>

