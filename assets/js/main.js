/**
 * ProAudio Tech - Main JavaScript File
 * Handles interactive functionality, form validation, and user experience enhancements
 */

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    initializeNavigation();
    initializeFormValidation();
    // Disable scroll effects temporarily to fix disappearing content
    // initializeScrollEffects();
    initializeCarousels();
    initializeAnimations();
    initializeLazyLoading();
    initializeAccessibility();
});

/**
 * Navigation functionality
 */
function initializeNavigation() {
    const navbar = document.querySelector('.navbar');
    const navbarToggler = document.querySelector('.navbar-toggler');
    const navbarCollapse = document.querySelector('.navbar-collapse');
    
    // Smooth scrolling for anchor links
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
    
    // Navbar scroll effect
    window.addEventListener('scroll', function() {
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });
    
    // Close mobile menu when clicking outside
    document.addEventListener('click', function(e) {
        if (!navbar.contains(e.target) && navbarCollapse.classList.contains('show')) {
            navbarToggler.click();
        }
    });
    
    // Close mobile menu when clicking on a nav link
    document.querySelectorAll('.navbar-nav .nav-link').forEach(link => {
        link.addEventListener('click', function() {
            if (navbarCollapse.classList.contains('show')) {
                navbarToggler.click();
            }
        });
    });
}

/**
 * Form validation and enhancement
 */
function initializeFormValidation() {
    const contactForm = document.querySelector('.contact-form');
    if (!contactForm) return;
    
    const fileInput = document.getElementById('file');
    const phoneInput = document.getElementById('phone');
    const emailInput = document.getElementById('email');
    const nameInput = document.getElementById('name');
    const messageInput = document.getElementById('message');
    
    // File upload validation
    if (fileInput) {
        fileInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const fileSize = file.size / 1024 / 1024; // Convert to MB
                const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'application/pdf'];
                
                // File size validation
                if (fileSize > 16) {
                    showNotification('O arquivo deve ter no máximo 16MB', 'error');
                    this.value = '';
                    return;
                }
                
                // File type validation
                if (!allowedTypes.includes(file.type)) {
                    showNotification('Apenas arquivos JPG, PNG e PDF são permitidos', 'error');
                    this.value = '';
                    return;
                }
                
                // Show file info
                const fileInfo = document.createElement('small');
                fileInfo.className = 'text-success mt-1 d-block';
                fileInfo.textContent = `Arquivo selecionado: ${file.name} (${(fileSize).toFixed(2)} MB)`;
                
                // Remove existing file info
                const existingInfo = this.parentNode.querySelector('.file-info');
                if (existingInfo) existingInfo.remove();
                
                fileInfo.classList.add('file-info');
                this.parentNode.appendChild(fileInfo);
            }
        });
    }
    
    // Phone number formatting
    if (phoneInput) {
        phoneInput.addEventListener('input', function() {
            let value = this.value.replace(/\D/g, '');
            
            // Apply Brazilian phone number format
            if (value.length >= 11) {
                value = value.replace(/(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
            } else if (value.length >= 7) {
                value = value.replace(/(\d{2})(\d{4})(\d{0,4})/, '($1) $2-$3');
            } else if (value.length >= 3) {
                value = value.replace(/(\d{2})(\d{0,5})/, '($1) $2');
            }
            
            this.value = value;
        });
    }
    
    // Real-time email validation
    if (emailInput) {
        emailInput.addEventListener('blur', function() {
            const email = this.value.trim();
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            
            if (email && !emailRegex.test(email)) {
                this.classList.add('is-invalid');
                showValidationError(this, 'Por favor, insira um e-mail válido');
            } else {
                this.classList.remove('is-invalid');
                removeValidationError(this);
            }
        });
    }
    
    // Name validation
    if (nameInput) {
        nameInput.addEventListener('blur', function() {
            const name = this.value.trim();
            if (name.length < 2) {
                this.classList.add('is-invalid');
                showValidationError(this, 'Nome deve ter pelo menos 2 caracteres');
            } else {
                this.classList.remove('is-invalid');
                removeValidationError(this);
            }
        });
    }
    
    // Message validation
    if (messageInput) {
        messageInput.addEventListener('input', function() {
            const remaining = 1000 - this.value.length;
            let counter = this.parentNode.querySelector('.char-counter');
            
            if (!counter) {
                counter = document.createElement('small');
                counter.className = 'char-counter text-muted';
                this.parentNode.appendChild(counter);
            }
            
            counter.textContent = `${remaining} caracteres restantes`;
            
            if (remaining < 0) {
                counter.classList.add('text-danger');
                counter.classList.remove('text-muted');
            } else {
                counter.classList.remove('text-danger');
                counter.classList.add('text-muted');
            }
        });
    }
    
    // Form submission handling
    contactForm.addEventListener('submit', function(e) {
        // Additional client-side validation before WhatsApp redirect
        const requiredFields = this.querySelectorAll('input[required], textarea[required]');
        let isValid = true;
        
        // Clear previous validation states
        requiredFields.forEach(field => {
            field.classList.remove('is-invalid');
            removeValidationError(field);
        });
        
        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                field.classList.add('is-invalid');
                showValidationError(field, 'Este campo é obrigatório');
                isValid = false;
            }
        });
        
        // Validate email format
        const emailField = this.querySelector('#email');
        if (emailField && emailField.value && !isValidEmail(emailField.value)) {
            emailField.classList.add('is-invalid');
            showValidationError(emailField, 'Por favor, insira um e-mail válido');
            isValid = false;
        }
        
        // Validate phone format if provided
        const phoneField = this.querySelector('#phone');
        if (phoneField && phoneField.value && !isValidPhone(phoneField.value)) {
            phoneField.classList.add('is-invalid');
            showValidationError(phoneField, 'Por favor, insira um telefone válido');
            isValid = false;
        }
        
        if (!isValid) {
            e.preventDefault();
            showNotification('Por favor, corrija os campos destacados', 'error');
            // Focus on first invalid field
            const firstInvalid = this.querySelector('.is-invalid');
            if (firstInvalid) {
                firstInvalid.focus();
                firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
            return;
        }
        
        // Show loading state
        const submitBtn = this.querySelector('button[type="submit"]');
        if (submitBtn) {
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Salvando e redirecionando...';
            submitBtn.disabled = true;
            
            // Re-enable after 8 seconds (in case of issues)
            setTimeout(() => {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }, 8000);
        }
        
        showNotification('💾 Salvando dados e preparando WhatsApp...', 'success');
    });
    
    // Helper functions for validation
    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }
    
    function isValidPhone(phone) {
        // Remove all non-digit characters
        const digitsOnly = phone.replace(/\D/g, '');
        // Brazilian phone should have 10 or 11 digits
        return digitsOnly.length >= 10 && digitsOnly.length <= 11;
    }
}

/**
 * Scroll effects and animations
 */
function initializeScrollEffects() {
    // Intersection Observer for fade-in animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -100px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-fade-in');
                entry.target.style.visibility = 'visible';
            }
        });
    }, observerOptions);
    
    // Prepare elements for animation by setting initial state
    document.querySelectorAll('.service-card, .gallery-item, .tech-card, .maintenance-card, .problem-card, .feature-card, .partner-card, .stat-card').forEach(el => {
        el.style.visibility = 'visible'; // Ensure elements are visible by default
        observer.observe(el);
    });
}

/**
 * Carousel enhancements
 */
function initializeCarousels() {
    const newsCarousel = document.querySelector('#newsCarousel');
    if (!newsCarousel) return;
    
    // Auto-play carousel
    const carousel = new bootstrap.Carousel(newsCarousel, {
        interval: 8000,
        ride: 'carousel',
        pause: 'hover'
    });
    
    // Keyboard navigation
    newsCarousel.addEventListener('keydown', function(e) {
        if (e.key === 'ArrowLeft') {
            carousel.prev();
        } else if (e.key === 'ArrowRight') {
            carousel.next();
        }
    });
    
    // Touch/swipe support for mobile
    let startX = 0;
    let startY = 0;
    
    newsCarousel.addEventListener('touchstart', function(e) {
        startX = e.touches[0].clientX;
        startY = e.touches[0].clientY;
    });
    
    newsCarousel.addEventListener('touchend', function(e) {
        const endX = e.changedTouches[0].clientX;
        const endY = e.changedTouches[0].clientY;
        const diffX = startX - endX;
        const diffY = startY - endY;
        
        // Check if horizontal swipe is longer than vertical
        if (Math.abs(diffX) > Math.abs(diffY)) {
            if (diffX > 50) {
                carousel.next();
            } else if (diffX < -50) {
                carousel.prev();
            }
        }
    });
}

/**
 * Animations and transitions
 */
function initializeAnimations() {
    // Add CSS classes for animations
    const style = document.createElement('style');
    style.textContent = `
        .animate-fade-in {
            animation: fadeInUp 0.6s ease forwards;
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0.7;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .navbar.scrolled {
            background-color: rgba(26, 26, 26, 0.95) !important;
            backdrop-filter: blur(10px);
        }
        
        .hover-lift {
            transition: transform 0.3s ease;
        }
        
        .hover-lift:hover {
            transform: translateY(-5px);
        }
    `;
    document.head.appendChild(style);
    
    // Add hover effects to cards
    document.querySelectorAll('.service-card, .tech-card, .maintenance-card, .problem-card, .feature-card, .partner-card').forEach(card => {
        card.classList.add('hover-lift');
    });
}

/**
 * Lazy loading for images
 */
function initializeLazyLoading() {
    const images = document.querySelectorAll('img[data-src]');
    const imageObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.classList.remove('lazy');
                imageObserver.unobserve(img);
            }
        });
    });
    
    images.forEach(img => imageObserver.observe(img));
}

/**
 * Accessibility enhancements
 */
function initializeAccessibility() {
    // Skip to main content link
    const skipLink = document.createElement('a');
    skipLink.href = '#main-content';
    skipLink.className = 'skip-link sr-only';
    skipLink.textContent = 'Pular para o conteúdo principal';
    skipLink.style.cssText = `
        position: absolute;
        top: -40px;
        left: 6px;
        background: var(--warning-yellow);
        color: var(--primary-black);
        padding: 8px;
        z-index: 9999;
        text-decoration: none;
        transition: top 0.2s;
    `;
    
    skipLink.addEventListener('focus', function() {
        this.style.top = '6px';
    });
    
    skipLink.addEventListener('blur', function() {
        this.style.top = '-40px';
    });
    
    document.body.insertBefore(skipLink, document.body.firstChild);
    
    // Add main content ID
    const mainContent = document.querySelector('.main-content');
    if (mainContent) {
        mainContent.id = 'main-content';
    }
    
    // Enhanced focus management for modals and dropdowns
    document.addEventListener('shown.bs.modal', function(e) {
        const modal = e.target;
        const focusableElements = modal.querySelectorAll('button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])');
        if (focusableElements.length > 0) {
            focusableElements[0].focus();
        }
    });
    
    // Announce page changes for screen readers
    const pageTitle = document.title;
    const announcement = document.createElement('div');
    announcement.setAttribute('aria-live', 'polite');
    announcement.setAttribute('aria-atomic', 'true');
    announcement.className = 'sr-only';
    announcement.textContent = `Página carregada: ${pageTitle}`;
    document.body.appendChild(announcement);
}

/**
 * Utility functions
 */
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `alert alert-${type === 'error' ? 'danger' : type} alert-dismissible fade show notification`;
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
        min-width: 300px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
    `;
    
    notification.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    document.body.appendChild(notification);
    
    // Auto-remove after 5 seconds
    setTimeout(() => {
        if (notification.parentNode) {
            notification.remove();
        }
    }, 5000);
}

function showValidationError(field, message) {
    removeValidationError(field);
    
    const errorDiv = document.createElement('div');
    errorDiv.className = 'invalid-feedback';
    errorDiv.textContent = message;
    
    field.parentNode.appendChild(errorDiv);
}

function removeValidationError(field) {
    const existingError = field.parentNode.querySelector('.invalid-feedback');
    if (existingError) {
        existingError.remove();
    }
}

// Performance optimization: Debounce scroll events
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

// Apply debounce to scroll events
const debouncedScroll = debounce(() => {
    // Scroll-based animations and effects
    const scrolled = window.pageYOffset;
    const navbar = document.querySelector('.navbar');
    
    if (scrolled > 50) {
        navbar.classList.add('scrolled');
    } else {
        navbar.classList.remove('scrolled');
    }
}, 10);

window.addEventListener('scroll', debouncedScroll);

// Export functions for testing or external use
window.ProAudioTech = {
    showNotification,
    showValidationError,
    removeValidationError
};
