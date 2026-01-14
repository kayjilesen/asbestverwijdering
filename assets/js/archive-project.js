/**
 * Project Archive Filters
 * 
 * @package asbestverwijdering
 * @version 1.0.0
 * @author Kay Jilesen
 */

(function() {
    'use strict';

    const initProjectArchiveFilters = () => {
        const filterButtons = document.querySelectorAll('.project-archive-filter-btn');
        const projectItems = document.querySelectorAll('.project-archive-item');
        const projectsGrid = document.getElementById('projects-grid');

        if (!filterButtons.length || !projectItems.length) {
            return;
        }

        filterButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                
                const filterValue = this.getAttribute('data-filter');
                
                // Update active state
                filterButtons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');
                
                // Filter projects
                let visibleCount = 0;
                projectItems.forEach(item => {
                    const itemFilters = item.getAttribute('data-filter') || 'all';
                    const itemFilterArray = itemFilters.split(' ');
                    
                    if (filterValue === 'all' || itemFilterArray.includes(filterValue)) {
                        item.classList.remove('hidden');
                        item.style.display = '';
                        visibleCount++;
                    } else {
                        item.classList.add('hidden');
                        item.style.display = 'none';
                    }
                });
                
                // Fade in animation
                if (projectsGrid) {
                    projectsGrid.style.opacity = '0';
                    setTimeout(() => {
                        projectsGrid.style.opacity = '1';
                    }, 150);
                }
                
                // Scroll to top of grid if items are filtered
                if (filterValue !== 'all' && projectsGrid) {
                    projectsGrid.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });
    };

    // Initialize on DOM ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initProjectArchiveFilters);
    } else {
        initProjectArchiveFilters();
    }
})();




