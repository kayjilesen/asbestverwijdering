<?php
/**
 * Button Component
 * 
 * @package asbestverwijdering
 * @version 1.0.0
 * @author Kay Jilesen
 */

defined( 'ABSPATH' ) || exit;

/**
 * Render a button from button data array
 * This is used by both kj_button() and kj_component()
 * 
 * @param array $button_data Button data array
 * @return void
 */
function kj_render_button($button_data = array()) {
    if (empty($button_data) || !is_array($button_data)) {
        return;
    }
    
    $button = $button_data;
    
    // Ensure $button is an array
    if (!is_array($button)) {
        $button = array();
    }

    // Handle new group structure: if button data is nested in 'button' key, extract it
    if (isset($button['button']) && is_array($button['button'])) {
        $button = $button['button'];
    }

    // Handle both old and new field name formats
    $button_label = $button['button_label'] ?? $button['label'] ?? '';
    $button_style = $button['button_style'] ?? $button['button_stijl'] ?? $button['style'] ?? 'primary yellow';
    $button_link_type = $button['button_link_type'] ?? $button['type'] ?? 'internal';

    // Handle internal link - new field name is 'button_link_intern'
    $button_link_internal = $button['button_link_intern'] ?? $button['button_link_intern'] ?? $button['page'] ?? null;
    // Handle external link - new field name is 'button_link_extern'
    $button_link_extern = $button['button_link_extern'] ?? $button['external_url'] ?? '';
    // Handle section ID - new field name is 'button_section_id'
    $button_link_id = $button['button_section_id'] ?? $button['button_link_id'] ?? $button['section_id'] ?? '';

    if (empty($button_label)) {
        return;
    }

    $is_primary = str_contains($button_style, 'primary');
    $is_secondary = str_contains($button_style, 'secondary');
    $is_text = $button_style === 'text';
    ?>

        <?php if($button_link_type == 'intern' || $button_link_type == 'internal') : ?>
            
            <?php 
            $page_url = '';
            if ($button_link_internal) {
                if (is_object($button_link_internal)) {
                    $page_url = get_permalink($button_link_internal->ID);
                } else {
                    $page_url = get_permalink($button_link_internal);
                }
            }
            ?>
            <a href="<?php echo esc_url($page_url); ?>" class="kj-button <?php echo esc_attr($button_style); ?><?php echo ($is_primary || $is_secondary || $is_text) ? ' flex items-center gap-2' : ''; ?>">
                <?php if($is_primary) : ?>
                    <div class="kj-button-inner <?php echo esc_attr($button_style); ?>">
                        <span><?php echo esc_html($button_label); ?></span>
                    </div>
                    <div class="kj-button-arrow-box <?php echo esc_attr($button_style); ?>">
                        <svg class="kj-button-arrow-svg kj-button-arrow-svg-out" viewBox="0 0 16 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10.4825 0.398001C10.7243 0.15647 11.1165 0.156324 11.3582 0.398001L15.2989 4.33973C15.5407 4.58159 15.5407 4.97364 15.2989 5.2155L11.3582 9.15723C11.1165 9.39891 10.7243 9.39876 10.4825 9.15723C10.2407 8.91537 10.2407 8.52252 10.4825 8.28066L13.366 5.39694L0.836077 5.39694C0.494058 5.39694 0.216796 5.11966 0.216796 4.77761C0.216797 4.43557 0.494058 4.15829 0.836077 4.15829L13.366 4.15829L10.4825 1.27457C10.2407 1.03271 10.2407 0.639861 10.4825 0.398001Z" fill="currentColor" stroke="currentColor" stroke-width="0.43372"/>
                        </svg>
                        <svg class="kj-button-arrow-svg kj-button-arrow-svg-in" viewBox="0 0 16 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10.4825 0.398001C10.7243 0.15647 11.1165 0.156324 11.3582 0.398001L15.2989 4.33973C15.5407 4.58159 15.5407 4.97364 15.2989 5.2155L11.3582 9.15723C11.1165 9.39891 10.7243 9.39876 10.4825 9.15723C10.2407 8.91537 10.2407 8.52252 10.4825 8.28066L13.366 5.39694L0.836077 5.39694C0.494058 5.39694 0.216796 5.11966 0.216796 4.77761C0.216797 4.43557 0.494058 4.15829 0.836077 4.15829L13.366 4.15829L10.4825 1.27457C10.2407 1.03271 10.2407 0.639861 10.4825 0.398001Z" fill="currentColor" stroke="currentColor" stroke-width="0.43372"/>
                        </svg>
                    </div>
                <?php elseif($is_secondary) : ?>
                    <div class="kj-button-inner <?php echo esc_attr($button_style); ?>">
                        <span><?php echo esc_html($button_label); ?></span>
                    </div>
                    <div class="kj-button-arrow-box <?php echo esc_attr($button_style); ?>">
                        <svg class="kj-button-arrow-svg kj-button-arrow-svg-out" viewBox="0 0 16 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10.4825 0.398001C10.7243 0.15647 11.1165 0.156324 11.3582 0.398001L15.2989 4.33973C15.5407 4.58159 15.5407 4.97364 15.2989 5.2155L11.3582 9.15723C11.1165 9.39891 10.7243 9.39876 10.4825 9.15723C10.2407 8.91537 10.2407 8.52252 10.4825 8.28066L13.366 5.39694L0.836077 5.39694C0.494058 5.39694 0.216796 5.11966 0.216796 4.77761C0.216797 4.43557 0.494058 4.15829 0.836077 4.15829L13.366 4.15829L10.4825 1.27457C10.2407 1.03271 10.2407 0.639861 10.4825 0.398001Z" fill="currentColor" stroke="currentColor" stroke-width="0.43372"/>
                        </svg>
                        <svg class="kj-button-arrow-svg kj-button-arrow-svg-in" viewBox="0 0 16 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10.4825 0.398001C10.7243 0.15647 11.1165 0.156324 11.3582 0.398001L15.2989 4.33973C15.5407 4.58159 15.5407 4.97364 15.2989 5.2155L11.3582 9.15723C11.1165 9.39891 10.7243 9.39876 10.4825 9.15723C10.2407 8.91537 10.2407 8.52252 10.4825 8.28066L13.366 5.39694L0.836077 5.39694C0.494058 5.39694 0.216796 5.11966 0.216796 4.77761C0.216797 4.43557 0.494058 4.15829 0.836077 4.15829L13.366 4.15829L10.4825 1.27457C10.2407 1.03271 10.2407 0.639861 10.4825 0.398001Z" fill="currentColor" stroke="currentColor" stroke-width="0.43372"/>
                        </svg>
                    </div>
                <?php elseif($is_text) : ?>
                    <span><?php echo esc_html($button_label); ?></span>
                    <svg class="kj-button-text-arrow" viewBox="0 0 16 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10.4825 0.398001C10.7243 0.15647 11.1165 0.156324 11.3582 0.398001L15.2989 4.33973C15.5407 4.58159 15.5407 4.97364 15.2989 5.2155L11.3582 9.15723C11.1165 9.39891 10.7243 9.39876 10.4825 9.15723C10.2407 8.91537 10.2407 8.52252 10.4825 8.28066L13.366 5.39694L0.836077 5.39694C0.494058 5.39694 0.216796 5.11966 0.216796 4.77761C0.216797 4.43557 0.494058 4.15829 0.836077 4.15829L13.366 4.15829L10.4825 1.27457C10.2407 1.03271 10.2407 0.639861 10.4825 0.398001Z" fill="currentColor" stroke="currentColor" stroke-width="0.43372"/>
                    </svg>
                <?php else : ?>
                    <span><?php echo esc_html($button_label); ?></span>
                <?php endif; ?>
            </a>

        <?php elseif($button_link_type == 'extern' || $button_link_type == 'external') : ?>

            <a href="<?php echo esc_url($button_link_extern); ?>" target="_blank" rel="noopener noreferrer" class="kj-button <?php echo esc_attr($button_style); ?><?php echo ($is_primary || $is_secondary || $is_text) ? ' flex items-center gap-2' : ''; ?>">
                <?php if($is_primary) : ?>
                    <div class="kj-button-inner <?php echo esc_attr($button_style); ?>">
                        <span><?php echo esc_html($button_label); ?></span>
                    </div>
                    <div class="kj-button-arrow-box <?php echo esc_attr($button_style); ?>">
                        <svg class="kj-button-arrow-svg kj-button-arrow-svg-out" viewBox="0 0 16 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10.4825 0.398001C10.7243 0.15647 11.1165 0.156324 11.3582 0.398001L15.2989 4.33973C15.5407 4.58159 15.5407 4.97364 15.2989 5.2155L11.3582 9.15723C11.1165 9.39891 10.7243 9.39876 10.4825 9.15723C10.2407 8.91537 10.2407 8.52252 10.4825 8.28066L13.366 5.39694L0.836077 5.39694C0.494058 5.39694 0.216796 5.11966 0.216796 4.77761C0.216797 4.43557 0.494058 4.15829 0.836077 4.15829L13.366 4.15829L10.4825 1.27457C10.2407 1.03271 10.2407 0.639861 10.4825 0.398001Z" fill="currentColor" stroke="currentColor" stroke-width="0.43372"/>
                        </svg>
                        <svg class="kj-button-arrow-svg kj-button-arrow-svg-in" viewBox="0 0 16 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10.4825 0.398001C10.7243 0.15647 11.1165 0.156324 11.3582 0.398001L15.2989 4.33973C15.5407 4.58159 15.5407 4.97364 15.2989 5.2155L11.3582 9.15723C11.1165 9.39891 10.7243 9.39876 10.4825 9.15723C10.2407 8.91537 10.2407 8.52252 10.4825 8.28066L13.366 5.39694L0.836077 5.39694C0.494058 5.39694 0.216796 5.11966 0.216796 4.77761C0.216797 4.43557 0.494058 4.15829 0.836077 4.15829L13.366 4.15829L10.4825 1.27457C10.2407 1.03271 10.2407 0.639861 10.4825 0.398001Z" fill="currentColor" stroke="currentColor" stroke-width="0.43372"/>
                        </svg>
                    </div>
                <?php elseif($is_secondary) : ?>
                    <div class="kj-button-inner <?php echo esc_attr($button_style); ?>">
                        <span><?php echo esc_html($button_label); ?></span>
                    </div>
                    <div class="kj-button-arrow-box <?php echo esc_attr($button_style); ?>">
                        <svg class="kj-button-arrow-svg kj-button-arrow-svg-out" viewBox="0 0 16 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10.4825 0.398001C10.7243 0.15647 11.1165 0.156324 11.3582 0.398001L15.2989 4.33973C15.5407 4.58159 15.5407 4.97364 15.2989 5.2155L11.3582 9.15723C11.1165 9.39891 10.7243 9.39876 10.4825 9.15723C10.2407 8.91537 10.2407 8.52252 10.4825 8.28066L13.366 5.39694L0.836077 5.39694C0.494058 5.39694 0.216796 5.11966 0.216796 4.77761C0.216797 4.43557 0.494058 4.15829 0.836077 4.15829L13.366 4.15829L10.4825 1.27457C10.2407 1.03271 10.2407 0.639861 10.4825 0.398001Z" fill="currentColor" stroke="currentColor" stroke-width="0.43372"/>
                        </svg>
                        <svg class="kj-button-arrow-svg kj-button-arrow-svg-in" viewBox="0 0 16 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10.4825 0.398001C10.7243 0.15647 11.1165 0.156324 11.3582 0.398001L15.2989 4.33973C15.5407 4.58159 15.5407 4.97364 15.2989 5.2155L11.3582 9.15723C11.1165 9.39891 10.7243 9.39876 10.4825 9.15723C10.2407 8.91537 10.2407 8.52252 10.4825 8.28066L13.366 5.39694L0.836077 5.39694C0.494058 5.39694 0.216796 5.11966 0.216796 4.77761C0.216797 4.43557 0.494058 4.15829 0.836077 4.15829L13.366 4.15829L10.4825 1.27457C10.2407 1.03271 10.2407 0.639861 10.4825 0.398001Z" fill="currentColor" stroke="currentColor" stroke-width="0.43372"/>
                        </svg>
                    </div>
                <?php elseif($is_text) : ?>
                    <span><?php echo esc_html($button_label); ?></span>
                    <svg class="kj-button-text-arrow" viewBox="0 0 16 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10.4825 0.398001C10.7243 0.15647 11.1165 0.156324 11.3582 0.398001L15.2989 4.33973C15.5407 4.58159 15.5407 4.97364 15.2989 5.2155L11.3582 9.15723C11.1165 9.39891 10.7243 9.39876 10.4825 9.15723C10.2407 8.91537 10.2407 8.52252 10.4825 8.28066L13.366 5.39694L0.836077 5.39694C0.494058 5.39694 0.216796 5.11966 0.216796 4.77761C0.216797 4.43557 0.494058 4.15829 0.836077 4.15829L13.366 4.15829L10.4825 1.27457C10.2407 1.03271 10.2407 0.639861 10.4825 0.398001Z" fill="currentColor" stroke="currentColor" stroke-width="0.43372"/>
                    </svg>
                <?php else : ?>
                    <span><?php echo esc_html($button_label); ?></span>
                <?php endif; ?>
            </a>

        <?php elseif($button_link_type == 'section') : ?>

            <a href="#<?php echo esc_attr($button_link_id); ?>" class="kj-button <?php echo esc_attr($button_style); ?><?php echo ($is_primary || $is_secondary || $is_text) ? ' flex items-center gap-2' : ''; ?>">
                <?php if($is_primary) : ?>
                    <div class="kj-button-inner <?php echo esc_attr($button_style); ?>">
                        <span><?php echo esc_html($button_label); ?></span>
                    </div>
                    <div class="kj-button-arrow-box <?php echo esc_attr($button_style); ?>">
                        <svg class="kj-button-arrow-svg kj-button-arrow-svg-out" viewBox="0 0 16 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10.4825 0.398001C10.7243 0.15647 11.1165 0.156324 11.3582 0.398001L15.2989 4.33973C15.5407 4.58159 15.5407 4.97364 15.2989 5.2155L11.3582 9.15723C11.1165 9.39891 10.7243 9.39876 10.4825 9.15723C10.2407 8.91537 10.2407 8.52252 10.4825 8.28066L13.366 5.39694L0.836077 5.39694C0.494058 5.39694 0.216796 5.11966 0.216796 4.77761C0.216797 4.43557 0.494058 4.15829 0.836077 4.15829L13.366 4.15829L10.4825 1.27457C10.2407 1.03271 10.2407 0.639861 10.4825 0.398001Z" fill="currentColor" stroke="currentColor" stroke-width="0.43372"/>
                        </svg>
                        <svg class="kj-button-arrow-svg kj-button-arrow-svg-in" viewBox="0 0 16 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10.4825 0.398001C10.7243 0.15647 11.1165 0.156324 11.3582 0.398001L15.2989 4.33973C15.5407 4.58159 15.5407 4.97364 15.2989 5.2155L11.3582 9.15723C11.1165 9.39891 10.7243 9.39876 10.4825 9.15723C10.2407 8.91537 10.2407 8.52252 10.4825 8.28066L13.366 5.39694L0.836077 5.39694C0.494058 5.39694 0.216796 5.11966 0.216796 4.77761C0.216797 4.43557 0.494058 4.15829 0.836077 4.15829L13.366 4.15829L10.4825 1.27457C10.2407 1.03271 10.2407 0.639861 10.4825 0.398001Z" fill="currentColor" stroke="currentColor" stroke-width="0.43372"/>
                        </svg>
                    </div>
                <?php elseif($is_secondary) : ?>
                    <div class="kj-button-inner <?php echo esc_attr($button_style); ?>">
                        <span><?php echo esc_html($button_label); ?></span>
                    </div>
                    <div class="kj-button-arrow-box <?php echo esc_attr($button_style); ?>">
                        <svg class="kj-button-arrow-svg kj-button-arrow-svg-out" viewBox="0 0 16 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10.4825 0.398001C10.7243 0.15647 11.1165 0.156324 11.3582 0.398001L15.2989 4.33973C15.5407 4.58159 15.5407 4.97364 15.2989 5.2155L11.3582 9.15723C11.1165 9.39891 10.7243 9.39876 10.4825 9.15723C10.2407 8.91537 10.2407 8.52252 10.4825 8.28066L13.366 5.39694L0.836077 5.39694C0.494058 5.39694 0.216796 5.11966 0.216796 4.77761C0.216797 4.43557 0.494058 4.15829 0.836077 4.15829L13.366 4.15829L10.4825 1.27457C10.2407 1.03271 10.2407 0.639861 10.4825 0.398001Z" fill="currentColor" stroke="currentColor" stroke-width="0.43372"/>
                        </svg>
                        <svg class="kj-button-arrow-svg kj-button-arrow-svg-in" viewBox="0 0 16 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10.4825 0.398001C10.7243 0.15647 11.1165 0.156324 11.3582 0.398001L15.2989 4.33973C15.5407 4.58159 15.5407 4.97364 15.2989 5.2155L11.3582 9.15723C11.1165 9.39891 10.7243 9.39876 10.4825 9.15723C10.2407 8.91537 10.2407 8.52252 10.4825 8.28066L13.366 5.39694L0.836077 5.39694C0.494058 5.39694 0.216796 5.11966 0.216796 4.77761C0.216797 4.43557 0.494058 4.15829 0.836077 4.15829L13.366 4.15829L10.4825 1.27457C10.2407 1.03271 10.2407 0.639861 10.4825 0.398001Z" fill="currentColor" stroke="currentColor" stroke-width="0.43372"/>
                        </svg>
                    </div>
                <?php elseif($is_text) : ?>
                    <span><?php echo esc_html($button_label); ?></span>
                    <svg class="kj-button-text-arrow" viewBox="0 0 16 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10.4825 0.398001C10.7243 0.15647 11.1165 0.156324 11.3582 0.398001L15.2989 4.33973C15.5407 4.58159 15.5407 4.97364 15.2989 5.2155L11.3582 9.15723C11.1165 9.39891 10.7243 9.39876 10.4825 9.15723C10.2407 8.91537 10.2407 8.52252 10.4825 8.28066L13.366 5.39694L0.836077 5.39694C0.494058 5.39694 0.216796 5.11966 0.216796 4.77761C0.216797 4.43557 0.494058 4.15829 0.836077 4.15829L13.366 4.15829L10.4825 1.27457C10.2407 1.03271 10.2407 0.639861 10.4825 0.398001Z" fill="currentColor" stroke="currentColor" stroke-width="0.43372"/>
                    </svg>
                <?php else : ?>
                    <span><?php echo esc_html($button_label); ?></span>
                <?php endif; ?>
            </a>

        <?php elseif($button_link_type == 'contact') : ?>

            <?php 
            $contact_page = get_field('page_contact', 'option');
            $contact_url = $contact_page ? $contact_page : '/contact';
            ?>
            <a href="<?php echo esc_url($contact_url); ?>" class="kj-button <?php echo esc_attr($button_style); ?><?php echo ($is_primary || $is_secondary || $is_text) ? ' flex items-center gap-2' : ''; ?>">
                <?php if($is_primary) : ?>
                    <div class="kj-button-inner <?php echo esc_attr($button_style); ?>">
                        <span><?php echo esc_html($button_label); ?></span>
                    </div>
                    <div class="kj-button-arrow-box <?php echo esc_attr($button_style); ?>">
                        <svg class="kj-button-arrow-svg kj-button-arrow-svg-out" viewBox="0 0 16 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10.4825 0.398001C10.7243 0.15647 11.1165 0.156324 11.3582 0.398001L15.2989 4.33973C15.5407 4.58159 15.5407 4.97364 15.2989 5.2155L11.3582 9.15723C11.1165 9.39891 10.7243 9.39876 10.4825 9.15723C10.2407 8.91537 10.2407 8.52252 10.4825 8.28066L13.366 5.39694L0.836077 5.39694C0.494058 5.39694 0.216796 5.11966 0.216796 4.77761C0.216797 4.43557 0.494058 4.15829 0.836077 4.15829L13.366 4.15829L10.4825 1.27457C10.2407 1.03271 10.2407 0.639861 10.4825 0.398001Z" fill="currentColor" stroke="currentColor" stroke-width="0.43372"/>
                        </svg>
                        <svg class="kj-button-arrow-svg kj-button-arrow-svg-in" viewBox="0 0 16 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10.4825 0.398001C10.7243 0.15647 11.1165 0.156324 11.3582 0.398001L15.2989 4.33973C15.5407 4.58159 15.5407 4.97364 15.2989 5.2155L11.3582 9.15723C11.1165 9.39891 10.7243 9.39876 10.4825 9.15723C10.2407 8.91537 10.2407 8.52252 10.4825 8.28066L13.366 5.39694L0.836077 5.39694C0.494058 5.39694 0.216796 5.11966 0.216796 4.77761C0.216797 4.43557 0.494058 4.15829 0.836077 4.15829L13.366 4.15829L10.4825 1.27457C10.2407 1.03271 10.2407 0.639861 10.4825 0.398001Z" fill="currentColor" stroke="currentColor" stroke-width="0.43372"/>
                        </svg>
                    </div>
                <?php elseif($is_secondary) : ?>
                    <div class="kj-button-inner <?php echo esc_attr($button_style); ?>">
                        <span><?php echo esc_html($button_label); ?></span>
                    </div>
                    <div class="kj-button-arrow-box <?php echo esc_attr($button_style); ?>">
                        <svg class="kj-button-arrow-svg kj-button-arrow-svg-out" viewBox="0 0 16 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10.4825 0.398001C10.7243 0.15647 11.1165 0.156324 11.3582 0.398001L15.2989 4.33973C15.5407 4.58159 15.5407 4.97364 15.2989 5.2155L11.3582 9.15723C11.1165 9.39891 10.7243 9.39876 10.4825 9.15723C10.2407 8.91537 10.2407 8.52252 10.4825 8.28066L13.366 5.39694L0.836077 5.39694C0.494058 5.39694 0.216796 5.11966 0.216796 4.77761C0.216797 4.43557 0.494058 4.15829 0.836077 4.15829L13.366 4.15829L10.4825 1.27457C10.2407 1.03271 10.2407 0.639861 10.4825 0.398001Z" fill="currentColor" stroke="currentColor" stroke-width="0.43372"/>
                        </svg>
                        <svg class="kj-button-arrow-svg kj-button-arrow-svg-in" viewBox="0 0 16 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10.4825 0.398001C10.7243 0.15647 11.1165 0.156324 11.3582 0.398001L15.2989 4.33973C15.5407 4.58159 15.5407 4.97364 15.2989 5.2155L11.3582 9.15723C11.1165 9.39891 10.7243 9.39876 10.4825 9.15723C10.2407 8.91537 10.2407 8.52252 10.4825 8.28066L13.366 5.39694L0.836077 5.39694C0.494058 5.39694 0.216796 5.11966 0.216796 4.77761C0.216797 4.43557 0.494058 4.15829 0.836077 4.15829L13.366 4.15829L10.4825 1.27457C10.2407 1.03271 10.2407 0.639861 10.4825 0.398001Z" fill="currentColor" stroke="currentColor" stroke-width="0.43372"/>
                        </svg>
                    </div>
                <?php elseif($is_text) : ?>
                    <span><?php echo esc_html($button_label); ?></span>
                    <svg class="kj-button-text-arrow" viewBox="0 0 16 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10.4825 0.398001C10.7243 0.15647 11.1165 0.156324 11.3582 0.398001L15.2989 4.33973C15.5407 4.58159 15.5407 4.97364 15.2989 5.2155L11.3582 9.15723C11.1165 9.39891 10.7243 9.39876 10.4825 9.15723C10.2407 8.91537 10.2407 8.52252 10.4825 8.28066L13.366 5.39694L0.836077 5.39694C0.494058 5.39694 0.216796 5.11966 0.216796 4.77761C0.216797 4.43557 0.494058 4.15829 0.836077 4.15829L13.366 4.15829L10.4825 1.27457C10.2407 1.03271 10.2407 0.639861 10.4825 0.398001Z" fill="currentColor" stroke="currentColor" stroke-width="0.43372"/>
                    </svg>
                <?php else : ?>
                    <span><?php echo esc_html($button_label); ?></span>
                <?php endif; ?>
            </a>

        <?php endif; ?>

    <?php
}
