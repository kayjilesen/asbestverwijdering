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
    });

    /**
     * Initialize mobile menu
     */
    function kj_initMobileMenu() {
        const menuToggle = document.querySelector('.mobile-menu-toggle');
        const mobileNav = document.querySelector('.mobile-navigation');
        
        if (menuToggle && mobileNav) {
            menuToggle.addEventListener('click', function() {
                const isExpanded = this.getAttribute('aria-expanded') === 'true';
                this.setAttribute('aria-expanded', !isExpanded);
                mobileNav.setAttribute('aria-hidden', isExpanded);
                
                // Lock/unlock body scroll
                if (!isExpanded) {
                    document.body.style.overflow = 'hidden';
                } else {
                    document.body.style.overflow = '';
                }
            });

            // Close menu when clicking outside
            mobileNav.addEventListener('click', function(e) {
                if (e.target === mobileNav) {
                    menuToggle.setAttribute('aria-expanded', 'false');
                    mobileNav.setAttribute('aria-hidden', 'true');
                    document.body.style.overflow = '';
                }
            });

            // Close menu on escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && mobileNav.getAttribute('aria-hidden') === 'false') {
                    menuToggle.setAttribute('aria-expanded', 'false');
                    mobileNav.setAttribute('aria-hidden', 'true');
                    document.body.style.overflow = '';
                }
            });
        }
    }

    /**
     * Initialize mobile submenus
     */
    function kj_initMobileSubmenus() {
        const menuItemsWithChildren = document.querySelectorAll('.mobile-navigation .menu-item-has-children');
        
        menuItemsWithChildren.forEach(function(menuItem) {
            const menuLink = menuItem.querySelector('> a');
            
            if (menuLink) {
                menuLink.addEventListener('click', function(e) {
                    e.preventDefault();
                    menuItem.classList.toggle('menu-open');
                });
            }
        });
    }

})();


