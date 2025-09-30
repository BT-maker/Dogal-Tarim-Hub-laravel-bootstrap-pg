/**
 * Yeşil Toprak - Organik Tarım Blog Teması JavaScript
 * Modern ve interaktif kullanıcı deneyimi için gerekli fonksiyonlar
 */

document.addEventListener('DOMContentLoaded', function() {
    // Initialize all components
    initScrollAnimations();
    initBackToTop();
    initSmoothScrolling();
    initLazyLoading();
    initSearchFunctionality();
    initCategoryFiltering();
    initNewsletterForm();
    initTooltips();
    initImageModal();
    initLoadingStates();
});

/**
 * Scroll Animations
 * Elements fade in as they come into view
 */
function initScrollAnimations() {
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    // Observe all elements with scroll-animate class
    document.querySelectorAll('.scroll-animate').forEach(el => {
        observer.observe(el);
    });
}

/**
 * Back to Top Button
 * Shows/hides based on scroll position
 */
function initBackToTop() {
    // Create back to top button if it doesn't exist
    let backToTopBtn = document.querySelector('.back-to-top');
    if (!backToTopBtn) {
        backToTopBtn = document.createElement('button');
        backToTopBtn.className = 'back-to-top';
        backToTopBtn.innerHTML = '<i class="bi bi-arrow-up"></i>';
        backToTopBtn.setAttribute('aria-label', 'Başa dön');
        document.body.appendChild(backToTopBtn);
    }

    // Show/hide on scroll
    window.addEventListener('scroll', () => {
        if (window.pageYOffset > 300) {
            backToTopBtn.classList.add('show');
        } else {
            backToTopBtn.classList.remove('show');
        }
    });

    // Smooth scroll to top
    backToTopBtn.addEventListener('click', () => {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
}

/**
 * Smooth Scrolling for Anchor Links
 */
function initSmoothScrolling() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
}

/**
 * Lazy Loading for Images
 */
function initLazyLoading() {
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.classList.remove('lazy');
                    imageObserver.unobserve(img);
                }
            });
        });

        document.querySelectorAll('img[data-src]').forEach(img => {
            imageObserver.observe(img);
        });
    }
}

/**
 * Search Functionality
 */
function initSearchFunctionality() {
    const searchInput = document.querySelector('#search-input');
    const searchResults = document.querySelector('#search-results');
    let searchTimeout;

    if (searchInput) {
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            const query = this.value.trim();

            if (query.length < 2) {
                hideSearchResults();
                return;
            }

            searchTimeout = setTimeout(() => {
                performSearch(query);
            }, 300);
        });

        // Hide results when clicking outside
        document.addEventListener('click', function(e) {
            if (!searchInput.contains(e.target) && !searchResults?.contains(e.target)) {
                hideSearchResults();
            }
        });
    }

    function performSearch(query) {
        // Show loading state
        showSearchLoading();

        // Simulate API call (replace with actual search endpoint)
        fetch(`/api/search?q=${encodeURIComponent(query)}`)
            .then(response => response.json())
            .then(data => {
                displaySearchResults(data.results);
            })
            .catch(error => {
                console.error('Search error:', error);
                hideSearchResults();
            });
    }

    function showSearchLoading() {
        if (searchResults) {
            searchResults.innerHTML = `
                <div class="search-loading p-3 text-center">
                    <div class="loading-spinner"></div>
                    <span class="ms-2">Aranıyor...</span>
                </div>
            `;
            searchResults.style.display = 'block';
        }
    }

    function displaySearchResults(results) {
        if (!searchResults) return;

        if (results.length === 0) {
            searchResults.innerHTML = `
                <div class="search-no-results p-3 text-center text-muted">
                    <i class="bi bi-search mb-2 d-block"></i>
                    Sonuç bulunamadı
                </div>
            `;
        } else {
            const resultsHtml = results.map(result => `
                <a href="${result.url}" class="search-result-item d-block p-3 text-decoration-none border-bottom">
                    <h6 class="mb-1">${result.title}</h6>
                    <p class="mb-1 text-muted small">${result.excerpt}</p>
                    <small class="text-success">${result.category}</small>
                </a>
            `).join('');
            
            searchResults.innerHTML = resultsHtml;
        }
        
        searchResults.style.display = 'block';
    }

    function hideSearchResults() {
        if (searchResults) {
            searchResults.style.display = 'none';
        }
    }
}

/**
 * Category Filtering
 */
function initCategoryFiltering() {
    const categoryFilters = document.querySelectorAll('.category-filter');
    const postCards = document.querySelectorAll('.post-card');

    categoryFilters.forEach(filter => {
        filter.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Update active state
            categoryFilters.forEach(f => f.classList.remove('active'));
            this.classList.add('active');
            
            const category = this.dataset.category;
            
            // Filter posts
            postCards.forEach(card => {
                if (category === 'all' || card.dataset.categories?.includes(category)) {
                    card.style.display = 'block';
                    card.classList.add('animate-fade-in-up');
                } else {
                    card.style.display = 'none';
                }
            });
            
            // Update URL without page reload
            const url = new URL(window.location);
            if (category === 'all') {
                url.searchParams.delete('category');
            } else {
                url.searchParams.set('category', category);
            }
            window.history.pushState({}, '', url);
        });
    });
}

/**
 * Newsletter Form
 */
function initNewsletterForm() {
    const newsletterForm = document.querySelector('#newsletter-form');
    
    if (newsletterForm) {
        newsletterForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const email = this.querySelector('input[type="email"]').value;
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            
            // Show loading state
            submitBtn.innerHTML = '<div class="loading-spinner"></div>';
            submitBtn.disabled = true;
            
            // Simulate API call
            setTimeout(() => {
                // Show success message
                showNotification('Başarıyla abone oldunuz! Teşekkürler.', 'success');
                this.reset();
                
                // Reset button
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }, 1500);
        });
    }
}

/**
 * Initialize Tooltips
 */
function initTooltips() {
    // Initialize Bootstrap tooltips if available
    if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }
}

/**
 * Image Modal for Post Images
 */
function initImageModal() {
    const postImages = document.querySelectorAll('.post-content img');
    
    postImages.forEach(img => {
        img.style.cursor = 'pointer';
        img.addEventListener('click', function() {
            openImageModal(this.src, this.alt);
        });
    });
}

function openImageModal(src, alt) {
    // Create modal if it doesn't exist
    let modal = document.querySelector('#image-modal');
    if (!modal) {
        modal = document.createElement('div');
        modal.id = 'image-modal';
        modal.className = 'modal fade';
        modal.innerHTML = `
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header border-0">
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body text-center p-0">
                        <img src="" alt="" class="img-fluid">
                    </div>
                </div>
            </div>
        `;
        document.body.appendChild(modal);
    }
    
    // Update image
    const modalImg = modal.querySelector('img');
    modalImg.src = src;
    modalImg.alt = alt;
    
    // Show modal
    if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
        const bsModal = new bootstrap.Modal(modal);
        bsModal.show();
    }
}

/**
 * Loading States for Buttons
 */
function initLoadingStates() {
    document.querySelectorAll('.btn-loading').forEach(btn => {
        btn.addEventListener('click', function() {
            if (!this.disabled) {
                const originalText = this.innerHTML;
                this.innerHTML = '<div class="loading-spinner me-2"></div>Yükleniyor...';
                this.disabled = true;
                
                // Reset after 3 seconds (adjust as needed)
                setTimeout(() => {
                    this.innerHTML = originalText;
                    this.disabled = false;
                }, 3000);
            }
        });
    });
}

/**
 * Notification System
 */
function showNotification(message, type = 'info', duration = 5000) {
    // Create notification container if it doesn't exist
    let container = document.querySelector('#notification-container');
    if (!container) {
        container = document.createElement('div');
        container.id = 'notification-container';
        container.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            max-width: 350px;
        `;
        document.body.appendChild(container);
    }
    
    // Create notification
    const notification = document.createElement('div');
    notification.className = `alert alert-${type} alert-dismissible fade show shadow-sm`;
    notification.style.cssText = `
        margin-bottom: 10px;
        border: none;
        border-radius: 10px;
    `;
    
    const iconMap = {
        success: 'bi-check-circle-fill',
        error: 'bi-exclamation-triangle-fill',
        warning: 'bi-exclamation-triangle-fill',
        info: 'bi-info-circle-fill'
    };
    
    notification.innerHTML = `
        <div class="d-flex align-items-center">
            <i class="bi ${iconMap[type]} me-2"></i>
            <div>${message}</div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
        </div>
    `;
    
    container.appendChild(notification);
    
    // Auto remove after duration
    setTimeout(() => {
        if (notification.parentNode) {
            notification.remove();
        }
    }, duration);
}

/**
 * Utility Functions
 */

// Debounce function
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Throttle function
function throttle(func, limit) {
    let inThrottle;
    return function() {
        const args = arguments;
        const context = this;
        if (!inThrottle) {
            func.apply(context, args);
            inThrottle = true;
            setTimeout(() => inThrottle = false, limit);
        }
    };
}

// Format date
function formatDate(date, locale = 'tr-TR') {
    return new Intl.DateTimeFormat(locale, {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    }).format(new Date(date));
}

// Copy to clipboard
function copyToClipboard(text) {
    if (navigator.clipboard) {
        navigator.clipboard.writeText(text).then(() => {
            showNotification('Panoya kopyalandı!', 'success', 2000);
        });
    } else {
        // Fallback for older browsers
        const textArea = document.createElement('textarea');
        textArea.value = text;
        document.body.appendChild(textArea);
        textArea.select();
        document.execCommand('copy');
        document.body.removeChild(textArea);
        showNotification('Panoya kopyalandı!', 'success', 2000);
    }
}

// Share functionality
function shareContent(title, text, url) {
    if (navigator.share) {
        navigator.share({
            title: title,
            text: text,
            url: url
        }).catch(err => console.log('Error sharing:', err));
    } else {
        // Fallback to copy URL
        copyToClipboard(url);
    }
}

// Performance monitoring
function measurePerformance() {
    if ('performance' in window) {
        window.addEventListener('load', () => {
            setTimeout(() => {
                const perfData = performance.getEntriesByType('navigation')[0];
                console.log('Page Load Time:', perfData.loadEventEnd - perfData.loadEventStart, 'ms');
            }, 0);
        });
    }
}

// Initialize performance monitoring in development
if (window.location.hostname === 'localhost' || window.location.hostname === '127.0.0.1') {
    measurePerformance();
}

// Export functions for global use
window.OrganicTheme = {
    showNotification,
    copyToClipboard,
    shareContent,
    formatDate
};