/**
 * Asbestverwijdering Theme JavaScript
 * 
 * @package asbestverwijdering
 * @version 1.0.0
 * @author Kay Jilesen
 */

(function() {
    'use strict';

    // DOM Ready
    document.addEventListener('DOMContentLoaded', function() {
        // Mobile menu toggle
        kj_initMobileMenu();

        // Submenu toggle for mobile
        kj_initMobileSubmenus();

        // Topbar swiper
        kj_initTopbarSwiper();

        // Header margin spacer
        kj_initHeaderMargin();

        // Header scroll shadow
        kj_initHeaderScroll();

        // Radio with icons
        kj_initRadioWithIcons();
    });

    /**
     * Initialize mobile menu
     */
    function kj_initMobileMenu() {
        const menuToggle = document.querySelector('#toggle-menu');
        const closeMenu = document.querySelector('#close-menu');
        const mobileNav = document.querySelector('#mobile-menu');
        
        if (!menuToggle || !mobileNav) return;

        function openMenu() {
            document.body.classList.add('show-mobile-menu');
            document.body.style.overflow = 'hidden';
            menuToggle.setAttribute('aria-expanded', 'true');
        }

        function closeMenuFunc() {
            document.body.classList.remove('show-mobile-menu');
            document.body.style.overflow = '';
            menuToggle.setAttribute('aria-expanded', 'false');
        }

        // Open menu
        menuToggle.addEventListener('click', function(e) {
            e.preventDefault();
            if (document.body.classList.contains('show-mobile-menu')) {
                closeMenuFunc();
            } else {
                openMenu();
            }
        });

        // Close menu
        if (closeMenu) {
            closeMenu.addEventListener('click', function(e) {
                e.preventDefault();
                closeMenuFunc();
            });
        }

        // Close menu when clicking on overlay
        const overlay = document.querySelector('.mobile-menu-overlay');
        if (overlay) {
            overlay.addEventListener('click', function(e) {
                e.preventDefault();
                closeMenuFunc();
            });
        }

        // Close menu on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && document.body.classList.contains('show-mobile-menu')) {
                closeMenuFunc();
            }
        });
    }

    /**
     * Initialize mobile submenus
     */
    function kj_initMobileSubmenus() {
        const menuItemsWithChildren = document.querySelectorAll('#mobile-menu .menu-item-has-children');
        
        menuItemsWithChildren.forEach(function(menuItem) {
            const chevronWrapper = menuItem.querySelector('.chevron-wrapper');
            
            if (chevronWrapper) {
                // Toggle submenu on click of chevron wrapper
                chevronWrapper.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    // Close other open submenus (optional - remove if you want multiple open)
                    menuItemsWithChildren.forEach(function(otherItem) {
                        if (otherItem !== menuItem && otherItem.classList.contains('open')) {
                            otherItem.classList.remove('open');
                        }
                    });
                    
                    // Toggle current submenu
                    menuItem.classList.toggle('open');
                });
                
                // Prevent hover from opening submenus on mobile
                menuItem.addEventListener('mouseenter', function(e) {
                    e.stopPropagation();
                });
            }
        });
    }

    /**
     * Initialize topbar Swiper slider for mobile
     */
    function kj_initTopbarSwiper() {
        const slider = document.querySelector('.js-topbar-swiper');
        if (!slider || typeof Swiper === 'undefined') return;

        // Only initialize on mobile
        function initSwiper() {
            if (window.innerWidth >= 1024) {
                // Destroy swiper on desktop if it exists
                if (slider.swiper) {
                    slider.swiper.destroy(true, true);
                }
                return;
            }

            // Initialize swiper on mobile
            if (!slider.swiper) {
                // eslint-disable-next-line no-new
                new Swiper(slider, {
                    slidesPerView: 1,
                    spaceBetween: 0,
                    autoplay: {
                        delay: 3000,
                        disableOnInteraction: false,
                    },
                    loop: true,
                    speed: 500,
                    allowTouchMove: false,
                });
            }
        }

        // Initialize on load
        initSwiper();

        // Re-initialize on resize
        let resizeTimer;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(initSwiper, 150);
        });
    }

    /**
     * Initialize header margin spacer - sets height based on actual header height
     */
    function kj_initHeaderMargin() {
        const header = document.querySelector('header#masthead');
        const headerMargin = document.querySelector('.header-marge');
        
        if (!header || !headerMargin) return;
        
        function updateHeaderMargin() {
            // Use getBoundingClientRect for more accurate measurement
            const headerRect = header.getBoundingClientRect();
            const headerHeight = headerRect.height;
            headerMargin.style.height = headerHeight + 'px';
        }
        
        // Update immediately on load
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', function() {
                // Small delay to ensure all elements are rendered
                setTimeout(updateHeaderMargin, 50);
            });
        } else {
            setTimeout(updateHeaderMargin, 50);
        }
        
        // Update on window resize (in case header height changes)
        let resizeTimer;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(updateHeaderMargin, 150);
        });
        
        // Update on orientation change (mobile)
        window.addEventListener('orientationchange', function() {
            setTimeout(updateHeaderMargin, 200);
        });
        
        // Update when images in header load (logo, etc.)
        const headerImages = header.querySelectorAll('img');
        headerImages.forEach(function(img) {
            if (img.complete) {
                updateHeaderMargin();
            } else {
                img.addEventListener('load', updateHeaderMargin);
            }
        });
        
        // Use ResizeObserver for more reliable height tracking (modern browsers)
        if (typeof ResizeObserver !== 'undefined') {
            const resizeObserver = new ResizeObserver(function(entries) {
                for (let entry of entries) {
                    updateHeaderMargin();
                }
            });
            resizeObserver.observe(header);
        }
    }

    /**
     * Initialize header scroll shadow
     */
    function kj_initHeaderScroll() {
        const header = document.querySelector('header#masthead');
        if (!header) return;

        function updateHeaderScroll() {
            if (window.scrollY > 0) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        }

        // Check on load
        updateHeaderScroll();

        // Check on scroll
        window.addEventListener('scroll', updateHeaderScroll, { passive: true });
    }

    /**
     * Initialize radio buttons and checkboxes with icons
     * Adds icons to radio buttons and checkboxes based on their value
     */
    function kj_initRadioWithIcons() {
        // Handle radio buttons
        const radioFields = document.querySelectorAll('fieldset.gfield[class*="radio-with-icons"] .gchoice');
        
        radioFields.forEach(function(choice) {
            const radioInput = choice.querySelector('input[type="radio"]');
            const checkboxInput = choice.querySelector('input[type="checkbox"]');
            const input = radioInput || checkboxInput;
            const label = choice.querySelector('label');
            
            if (!input || !label) return;
            
            // Check if icon already exists
            if (label.querySelector('.gform-radio-icon')) return;
            
            const value = input.value;
            const iconPath = '/wp-content/themes/asbestverwijdering/assets/icons/' + value + '.svg';
            
            // Create icon wrapper
            const iconWrapper = document.createElement('div');
            iconWrapper.className = 'gform-radio-icon gform-theme__no-reset--el';
            // Add inline styles to override Gravity Forms reset
            iconWrapper.style.cssText = 'display: flex !important; align-items: center !important; justify-content: center !important; margin-right: 0.75rem !important; flex-shrink: 0 !important; position: relative !important; width: 40px !important; height: 40px !important; box-sizing: border-box !important;';
            
            // Create check indicator
            const checkIndicator = document.createElement('div');
            checkIndicator.className = 'gform-radio-check';
            checkIndicator.innerHTML = '<svg viewBox="0 0 11 10" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1 5L4 8L10 1" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>';
            
            // Load icon
            fetch(iconPath)
                .then(response => {
                    if (response.ok) {
                        return response.text();
                    }
                    return null;
                })
                .then(svgContent => {
                    if (svgContent) {
                        iconWrapper.innerHTML = svgContent;
                        // Add class and inline styles to SVG to exclude from reset
                        const svg = iconWrapper.querySelector('svg');
                        if (svg) {
                            svg.classList.add('gform-theme__no-reset--el');
                            // Add inline styles to ensure visibility
                            svg.style.cssText = 'display: block !important; visibility: visible !important; opacity: 0.6 !important; width: 100% !important; height: 100% !important; max-width: 100% !important; max-height: 100% !important; object-fit: contain !important; box-sizing: border-box !important; fill: #1A1603 !important; stroke: #1A1603 !important;';
                            // Also add to all child elements
                            svg.querySelectorAll('*').forEach(function(el) {
                                el.classList.add('gform-theme__no-reset--el');
                                el.style.cssText = 'display: revert !important; visibility: visible !important; opacity: 1 !important;';
                            });
                        }
                    }
                })
                .catch(() => {
                    // Icon not found, continue without icon
                });
            
            // Get text content from label
            const textContent = Array.from(label.childNodes).filter(node => 
                node.nodeType === Node.TEXT_NODE || 
                (node.nodeType === Node.ELEMENT_NODE && !node.matches('input'))
            );
            
            // Clear label and add icon, check, then other content
            label.innerHTML = '';
            label.appendChild(iconWrapper);
            label.appendChild(checkIndicator);
            if (input.parentNode !== label) {
                label.appendChild(input);
            }
            textContent.forEach(node => {
                if (node.nodeType === Node.TEXT_NODE) {
                    const span = document.createElement('span');
                    span.textContent = node.textContent.trim();
                    if (span.textContent) {
                        label.appendChild(span);
                    }
                } else {
                    label.appendChild(node);
                }
            });
        });
        
        // Re-apply styles after a short delay to ensure they override Gravity Forms reset
        setTimeout(function() {
            document.querySelectorAll('.gform-radio-icon svg').forEach(function(svg) {
                const label = svg.closest('label');
                const input = label ? label.querySelector('input[type="radio"]') : null;
                const isChecked = input && input.checked;
                
                if (!svg.hasAttribute('data-styled')) {
                    const opacity = isChecked ? '1' : '0.6';
                    const fillColor = isChecked ? '#fff' : '#1A1603';
                    const strokeColor = isChecked ? '#fff' : '#1A1603';
                    
                    svg.style.cssText = 'display: block !important; visibility: visible !important; opacity: ' + opacity + ' !important; width: 100% !important; height: 100% !important; max-width: 100% !important; max-height: 100% !important; object-fit: contain !important; box-sizing: border-box !important; fill: ' + fillColor + ' !important; stroke: ' + strokeColor + ' !important;';
                    svg.setAttribute('data-styled', 'true');
                    svg.setAttribute('data-checked', isChecked ? 'true' : 'false');
                    svg.querySelectorAll('*').forEach(function(el) {
                        el.style.cssText = 'display: revert !important; visibility: visible !important; opacity: 1 !important;';
                    });
                }
            });
            
            // Listen for changes to update opacity
            document.querySelectorAll('fieldset.gfield[class*="radio-with-icons"] input[type="radio"]').forEach(function(radio) {
                radio.addEventListener('change', function() {
                    setTimeout(function() {
                        document.querySelectorAll('.gform-radio-icon svg').forEach(function(svg) {
                            const label = svg.closest('label');
                            const input = label ? label.querySelector('input[type="radio"]') : null;
                            const isChecked = input && input.checked;
                            const opacity = isChecked ? '1' : '0.6';
                            const fillColor = isChecked ? '#fff' : '#1A1603';
                            const strokeColor = isChecked ? '#fff' : '#1A1603';
                            svg.style.opacity = opacity;
                            svg.style.fill = fillColor;
                            svg.style.stroke = strokeColor;
                        });
                    }, 10);
                });
            });
        }, 200);
    }

    // Re-initialize on Gravity Forms AJAX completion
    if (typeof jQuery !== 'undefined') {
        jQuery(document).on('gform_post_render', function() {
            kj_initRadioWithIcons();
        });
    }

})();

