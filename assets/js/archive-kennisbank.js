/**
 * Kennisbank Archive Filters
 * 
 * @package asbestverwijdering
 * @version 1.0.0
 * @author Kay Jilesen
 */

(function() {
    'use strict';

    const initKennisbankArchiveFilters = () => {
        const filterButtons = document.querySelectorAll('.kennisbank-archive-filter-btn');
        const postItems = document.querySelectorAll('.kennisbank-archive-item');
        const postsGrid = document.getElementById('posts-grid');

        if (!filterButtons.length || !postItems.length) {
            return;
        }

        filterButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                
                const filterValue = this.getAttribute('data-filter') || 'alle';
                
                // Update active state
                filterButtons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');
                
                // Filter posts
                let visibleCount = 0;
                postItems.forEach(item => {
                    // Get categories from item classes (they are added as class names)
                    const itemCategories = Array.from(item.classList).filter(cls => 
                        cls !== 'kennisbank-archive-item' && 
                        cls !== 'kennisbank-archive-item--featured' &&
                        cls !== 'hide' &&
                        cls !== 'hidden'
                    );
                    
                    // Check if item matches filter
                    const matchesFilter = filterValue === 'alle' || 
                        itemCategories.some(cat => cat === filterValue);
                    
                    if (matchesFilter) {
                        item.classList.remove('hidden');
                        item.style.display = '';
                        visibleCount++;
                    } else {
                        item.classList.add('hidden');
                        item.style.display = 'none';
                    }
                });
                
                // Fade in animation
                if (postsGrid) {
                    postsGrid.style.opacity = '0';
                    setTimeout(() => {
                        postsGrid.style.opacity = '1';
                    }, 150);
                }
                
                // Scroll to top of grid if items are filtered
                if (filterValue !== 'alle' && postsGrid) {
                    postsGrid.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });
    };

    // Initialize on DOM ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initKennisbankArchiveFilters);
    } else {
        initKennisbankArchiveFilters();
    }
})();
