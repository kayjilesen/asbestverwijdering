/**
 * Highlights Block JavaScript
 * 
 * @package asbestverwijdering
 * @version 1.0.0
 * @author Kay Jilesen
 */

(function() {
    'use strict';

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
})();

