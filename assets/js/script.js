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

})();

