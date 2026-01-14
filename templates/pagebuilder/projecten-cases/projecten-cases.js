/**
 * Projecten en Cases Block JavaScript
 * 
 * @package asbestverwijdering
 * @version 1.0.0
 * @author Kay Jilesen
 */

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

