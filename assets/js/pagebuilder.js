/**
 * Pagebuilder Blocks JavaScript
 * Auto-generated file - Do not edit manually
 * 
 * @package asbestverwijdering
 * @version 1.0.0
 * @author Kay Jilesen
 * 
 * This file combines all pagebuilder block JavaScript files.
 * Generated: 2026-01-19T14:04:45.504Z
 */

(function() {
    'use strict';

    // hero block
    // DOM Ready
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize hero functionality if needed
        });

    // text-image block
    // DOM Ready
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize text image functionality if needed
        });

    // projecten-cases block
    // DOM Ready
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize projecten cases swipers
        const swipers = document.querySelectorAll('.js-projecten-cases-swiper');

        if (swipers.length === 0 || typeof Swiper === 'undefined') return;

        swipers.forEach(function(swiperEl) {
            // eslint-disable-next-line no-new
            new Swiper(swiperEl, {
                slidesPerView: 1,
                spaceBetween: 24,
                navigation: {
                    nextEl: swiperEl.querySelector('.swiper-button-next'),
                    prevEl: swiperEl.querySelector('.swiper-button-prev'),
                },
                breakpoints: {
                    640: {
                        slidesPerView: 2,
                        spaceBetween: 24,
                    },
                    1024: {
                        slidesPerView: 3,
                        spaceBetween: 32,
                    },
                },
                loop: false,
                speed: 600,
                grabCursor: true,
            });
        });
    });

    // reviews block
    // DOM Ready
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize reviews swipers
            const swipers = document.querySelectorAll('.js-reviews-swiper');

            if (swipers.length === 0 || typeof Swiper === 'undefined') return;

            swipers.forEach(function(swiperEl) {
                // eslint-disable-next-line no-new
                new Swiper(swiperEl, {
                    slidesPerView: 1,
                    spaceBetween: 24,
                    navigation: {
                        nextEl: swiperEl.querySelector('.swiper-button-next'),
                        prevEl: swiperEl.querySelector('.swiper-button-prev'),
                    },
                    scrollbar: {
                        el: swiperEl.querySelector('.swiper-scrollbar'),
                        draggable: true,
                    },
                    breakpoints: {
                        1024: {
                            slidesPerView: 2,
                            spaceBetween: 32,
                        },
                    },
                    loop: false,
                    speed: 600,
                    grabCursor: true,
                });
            });
        });

    // waar block
    // Initialize Waar? block functionality if needed
        document.addEventListener('DOMContentLoaded', function() {
            // Add any interactive functionality here if needed
        });

    // veelgestelde-vragen block
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

    // uitdagingen block
    // Add any JavaScript functionality for the uitdagingen block here

    // highlights block
    // DOM Ready
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize highlights swipers
            const swipers = document.querySelectorAll('.js-highlights-swiper');

            if (swipers.length === 0 || typeof Swiper === 'undefined') return;

            swipers.forEach(function(swiperEl) {
                // eslint-disable-next-line no-new
                new Swiper(swiperEl, {
                    slidesPerView: 1,
                    spaceBetween: 24,
                    navigation: {
                        nextEl: swiperEl.querySelector('.swiper-button-next'),
                        prevEl: swiperEl.querySelector('.swiper-button-prev'),
                    },
                    pagination: {
                        el: swiperEl.querySelector('.swiper-pagination-custom'),
                        type: 'fraction',
                    },
                    breakpoints: {
                        768: {
                            slidesPerView: 2,
                            spaceBetween: 16,
                        },
                        1024: {
                            slidesPerView: 2,
                            spaceBetween: 24,
                        },
                    },
                    loop: false,
                    speed: 600,
                    grabCursor: true,
                });
            });
        });

    // hero-offerte block
    // Add any JavaScript functionality here if needed

    // stappen block
    // Block-specific JavaScript if needed

    // sparren block
    // Sparren block functionality (if needed)

    // zakelijke-aanvraag block
    // Block-specific JavaScript can be added here if needed

    // kennisbank block
    // DOM Ready
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize kennisbank swipers
            const swipers = document.querySelectorAll('.js-kennisbank-swiper');

            if (swipers.length === 0 || typeof Swiper === 'undefined') return;

            swipers.forEach(function(swiperEl) {
                // eslint-disable-next-line no-new
                new Swiper(swiperEl, {
                    slidesPerView: 1,
                    spaceBetween: 24,
                    navigation: {
                        nextEl: swiperEl.querySelector('.swiper-button-next'),
                        prevEl: swiperEl.querySelector('.swiper-button-prev'),
                    },
                    breakpoints: {
                        640: {
                            slidesPerView: 2,
                            spaceBetween: 24,
                        },
                    },
                    loop: false,
                    speed: 600,
                    grabCursor: true,
                });
            });
        });

    // offerte block
    // Add any JavaScript functionality here if needed

    // text block
    // No JavaScript required for this block

})();
