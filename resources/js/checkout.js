// Enhanced checkout page functionality
document.addEventListener('DOMContentLoaded', function() {
    initializeCheckoutEnhancements();
});

function initializeCheckoutEnhancements() {
    // Form validation and enhancement
    setupFormValidation();
    
    // Loading states
    setupLoadingStates();
    
    // Smooth animations
    setupAnimations();
    
    // Accessibility improvements
    setupAccessibility();
    
    // Auto-save form data
    setupAutoSave();
}

// Enhanced form validation
function setupFormValidation() {
    const inputs = document.querySelectorAll('input[required], textarea[required]');
    
    inputs.forEach(input => {
        // Real-time validation
        input.addEventListener('input', function() {
            validateFieldRealTime(this);
        });
        
        // Blur validation
        input.addEventListener('blur', function() {
            validateField(this);
        });
        
        // Focus enhancement
        input.addEventListener('focus', function() {
            enhanceFocusState(this);
        });
    });
}

function validateFieldRealTime(field) {
    clearValidationError(field);
    
    if (field.value.trim()) {
        field.classList.remove('border-red-500');
        field.classList.add('border-green-500');
        
        // Add success icon
        addSuccessIcon(field);
    } else {
        field.classList.remove('border-green-500');
        removeSuccessIcon(field);
    }
}

function validateField(field) {
    const value = field.value.trim();
    const fieldType = field.type;
    const fieldName = field.getAttribute('name') || field.id;
    
    // Remove existing validation classes
    field.classList.remove('border-red-500', 'border-green-500');
    clearValidationError(field);
    
    if (!value) {
        field.classList.add('border-red-500');
        showFieldError(field, `${getFieldLabel(fieldName)} is required`);
        addErrorIcon(field);
        return false;
    }
    
    // Specific validation rules
    if (fieldType === 'tel' && !isValidPhoneNumber(value)) {
        field.classList.add('border-red-500');
        showFieldError(field, 'Please enter a valid phone number');
        addErrorIcon(field);
        return false;
    }
    
    if (fieldType === 'email' && !isValidEmail(value)) {
        field.classList.add('border-red-500');
        showFieldError(field, 'Please enter a valid email address');
        addErrorIcon(field);
        return false;
    }
    
    // Success state
    field.classList.add('border-green-500');
    addSuccessIcon(field);
    return true;
}

function enhanceFocusState(field) {
    // Add focus ring animation
    field.style.transform = 'scale(1.02)';
    field.style.transition = 'all 0.2s ease';
    
    field.addEventListener('blur', function() {
        field.style.transform = 'scale(1)';
    }, { once: true });
}

function addSuccessIcon(field) {
    removeIcons(field);
    const icon = createIcon('success');
    insertIcon(field, icon);
}

function addErrorIcon(field) {
    removeIcons(field);
    const icon = createIcon('error');
    insertIcon(field, icon);
}

function removeSuccessIcon(field) {
    removeIcons(field);
}

function removeIcons(field) {
    const existingIcon = field.parentNode.querySelector('.field-icon');
    if (existingIcon) {
        existingIcon.remove();
    }
}

function createIcon(type) {
    const icon = document.createElement('div');
    icon.className = 'field-icon absolute right-4 top-1/2 transform -translate-y-1/2 w-5 h-5';
    
    if (type === 'success') {
        icon.innerHTML = `
            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
        `;
    } else if (type === 'error') {
        icon.innerHTML = `
            <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        `;
    }
    
    return icon;
}

function insertIcon(field, icon) {
    if (field.parentNode.style.position !== 'relative') {
        field.parentNode.style.position = 'relative';
    }
    field.parentNode.appendChild(icon);
}

function clearValidationError(field) {
    field.classList.remove('border-red-500');
    clearFieldError(field);
    removeIcons(field);
}

function showFieldError(field, message) {
    clearFieldError(field);
    const errorDiv = document.createElement('div');
    errorDiv.className = 'form-error mt-1 flex items-center text-red-500 text-sm';
    errorDiv.innerHTML = `
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        ${message}
    `;
    errorDiv.id = `error-${field.id}`;
    field.parentNode.appendChild(errorDiv);
}

function clearFieldError(field) {
    const existingError = document.getElementById(`error-${field.id}`);
    if (existingError) {
        existingError.remove();
    }
}

function getFieldLabel(fieldName) {
    const labels = {
        'customerName': 'Full name',
        'mobileNumber': 'Mobile number',
        'address': 'Address',
        'customer-name': 'Full name',
        'mobile-number': 'Mobile number'
    };
    return labels[fieldName] || fieldName;
}

function isValidPhoneNumber(phone) {
    const phoneRegex = /^[\+]?[0-9\s\-\(\)]{10,}$/;
    return phoneRegex.test(phone);
}

function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

// Loading states management
function setupLoadingStates() {
    const submitButton = document.querySelector('[wire\\:click="placeOrder()"]');
    
    if (submitButton) {
        submitButton.addEventListener('click', function() {
            if (validateAllFields()) {
                setButtonLoading(this, true);
            }
        });
    }
}

function validateAllFields() {
    const inputs = document.querySelectorAll('input[required], textarea[required]');
    let allValid = true;
    
    inputs.forEach(input => {
        if (!validateField(input)) {
            allValid = false;
        }
    });
    
    if (!allValid) {
        scrollToFirstError();
        showNotification('Please fill in all required fields correctly', 'error');
    }
    
    return allValid;
}

function setButtonLoading(button, loading = true) {
    if (loading) {
        button.disabled = true;
        button.classList.add('loading', 'opacity-75');
        const originalText = button.innerHTML;
        button.setAttribute('data-original-text', originalText);
        button.innerHTML = `
            <div class="flex items-center justify-center space-x-3">
                <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span>Processing Order...</span>
            </div>
        `;
    } else {
        button.disabled = false;
        button.classList.remove('loading', 'opacity-75');
        const originalText = button.getAttribute('data-original-text');
        if (originalText) {
            button.innerHTML = originalText;
        }
    }
}

// Smooth animations
function setupAnimations() {
    // Animate cards on scroll
    const cards = document.querySelectorAll('.checkout-card');
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('fade-in-up');
            }
        });
    }, { threshold: 0.1 });
    
    cards.forEach(card => {
        observer.observe(card);
    });
    
    // Animate progress steps
    animateProgressSteps();
}

function animateProgressSteps() {
    const steps = document.querySelectorAll('.progress-step');
    steps.forEach((step, index) => {
        setTimeout(() => {
            step.style.transform = 'scale(1.1)';
            setTimeout(() => {
                step.style.transform = 'scale(1)';
            }, 200);
        }, index * 100);
    });
}

// Accessibility improvements
function setupAccessibility() {
    // Add ARIA labels
    const inputs = document.querySelectorAll('input, textarea');
    inputs.forEach(input => {
        const label = input.parentNode.querySelector('label');
        if (label && !input.getAttribute('aria-label')) {
            input.setAttribute('aria-label', label.textContent);
        }
    });
    
    // Keyboard navigation
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' && e.target.tagName === 'INPUT') {
            const form = e.target.closest('form');
            if (form) {
                const inputs = Array.from(form.querySelectorAll('input, textarea'));
                const currentIndex = inputs.indexOf(e.target);
                const nextInput = inputs[currentIndex + 1];
                
                if (nextInput) {
                    nextInput.focus();
                    e.preventDefault();
                }
            }
        }
    });
}

// Auto-save form data
function setupAutoSave() {
    const inputs = document.querySelectorAll('input, textarea');
    
    inputs.forEach(input => {
        // Load saved data
        const savedValue = localStorage.getItem(`checkout_${input.id}`);
        if (savedValue && !input.value) {
            input.value = savedValue;
        }
        
        // Save on input
        input.addEventListener('input', function() {
            localStorage.setItem(`checkout_${this.id}`, this.value);
        });
    });
    
    // Clear saved data on successful submission
    document.addEventListener('checkout-success', function() {
        inputs.forEach(input => {
            localStorage.removeItem(`checkout_${input.id}`);
        });
    });
}

// Utility functions
function scrollToFirstError() {
    const firstError = document.querySelector('.border-red-500');
    if (firstError) {
        firstError.scrollIntoView({ 
            behavior: 'smooth', 
            block: 'center' 
        });
        firstError.focus();
    }
}

function showNotification(message, type = 'info') {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg max-w-sm transform transition-all duration-300 translate-x-full`;
    
    if (type === 'error') {
        notification.classList.add('bg-red-500', 'text-white');
    } else if (type === 'success') {
        notification.classList.add('bg-green-500', 'text-white');
    } else {
        notification.classList.add('bg-blue-500', 'text-white');
    }
    
    notification.innerHTML = `
        <div class="flex items-center space-x-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span>${message}</span>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    // Animate in
    setTimeout(() => {
        notification.classList.remove('translate-x-full');
    }, 100);
    
    // Auto remove
    setTimeout(() => {
        notification.classList.add('translate-x-full');
        setTimeout(() => {
            notification.remove();
        }, 300);
    }, 5000);
}

// Listen for Livewire events
document.addEventListener('livewire:init', () => {
    Livewire.on('form-submitted', () => {
        const submitButton = document.querySelector('[wire\\:click="placeOrder()"]');
        if (submitButton) {
            setButtonLoading(submitButton, true);
        }
    });
    
    Livewire.on('form-completed', () => {
        const submitButton = document.querySelector('[wire\\:click="placeOrder()"]');
        if (submitButton) {
            setButtonLoading(submitButton, false);
        }
    });
    
    Livewire.on('checkout-success', () => {
        showNotification('Order placed successfully!', 'success');
        document.dispatchEvent(new CustomEvent('checkout-success'));
    });
    
    Livewire.on('checkout-error', (message) => {
        showNotification(message, 'error');
    });
});

// Export functions for global use
window.checkoutEnhancements = {
    scrollToFirstError,
    setButtonLoading,
    showNotification,
    validateAllFields
};