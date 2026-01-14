/**
 * Veelgestelde Vragen Block JavaScript
 * 
 * @package asbestverwijdering
 * @version 1.0.0
 * @author Kay Jilesen
 */

(function() {
    'use strict';

    // DOM Ready
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize FAQ accordion functionality
        const faqBlocks = document.querySelectorAll('[data-faq-toggle]');
        
        if (faqBlocks.length === 0) return;
        
        faqBlocks.forEach(function(toggle) {
            toggle.addEventListener('click', function() {
                const item = this.closest('.veelgestelde-vragen-block__item');
                const isActive = item.classList.contains('is-active');
                const content = item.querySelector('[data-faq-content]');
                const answerId = this.getAttribute('aria-controls');
                
                // Close all other items in the same FAQ block
                const faqContainer = item.closest('.veelgestelde-vragen-block__items');
                const allItems = faqContainer.querySelectorAll('.veelgestelde-vragen-block__item');
                
                allItems.forEach(function(otherItem) {
                    if (otherItem !== item) {
                        otherItem.classList.remove('is-active');
                        const otherToggle = otherItem.querySelector('[data-faq-toggle]');
                        const otherContent = otherItem.querySelector('[data-faq-content]');
                        if (otherToggle) {
                            otherToggle.setAttribute('aria-expanded', 'false');
                        }
                        if (otherContent) {
                            otherContent.style.maxHeight = '0';
                        }
                    }
                });
                
                // Toggle current item
                if (isActive) {
                    item.classList.remove('is-active');
                    this.setAttribute('aria-expanded', 'false');
                    if (content) {
                        content.style.maxHeight = '0';
                    }
                } else {
                    item.classList.add('is-active');
                    this.setAttribute('aria-expanded', 'true');
                    if (content) {
                        // Set max-height to scrollHeight for smooth animation
                        content.style.maxHeight = content.scrollHeight + 'px';
                    }
                }
            });
        });
    });
})();




