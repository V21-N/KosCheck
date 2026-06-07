/**
 * Form Validation
 * Client-side form validation with real-time feedback
 */
export function initFormValidation() {
    const forms = document.querySelectorAll('form[data-validate], form.needs-validation');

    forms.forEach(form => {
        form.addEventListener('submit', (e) => {
            if (!validateForm(form)) {
                e.preventDefault();
                e.stopPropagation();
            }
        });

        // Real-time validation on blur and change
        form.querySelectorAll('input, textarea, select').forEach(field => {
            field.addEventListener('blur', () => validateField(field));
            field.addEventListener('change', () => validateField(field));
            field.addEventListener('input', () => clearFieldError(field));
        });
    });
}

export function validateForm(form) {
    let isValid = true;
    const fields = form.querySelectorAll('input, textarea, select');

    fields.forEach(field => {
        if (!validateField(field)) {
            isValid = false;
        }
    });

    return isValid;
}

export function validateField(field) {
    const value = field.value.trim();
    const type = field.type;
    const required = field.hasAttribute('required');
    let isValid = true;
    let errorMessage = '';

    clearFieldError(field);

    if (required && !value) {
        isValid = false;
        errorMessage = 'Field ini wajib diisi';
    } else if (type === 'email' && value && !isEmailValid(value)) {
        isValid = false;
        errorMessage = 'Email tidak valid';
    } else if (type === 'password' && value && value.length < 6) {
        isValid = false;
        errorMessage = 'Password minimal 6 karakter';
    } else if (field.name === 'phone' && value && !isPhoneValid(value)) {
        isValid = false;
        errorMessage = 'Nomor telepon tidak valid';
    } else if (field.minLength > 0 && value && value.length < field.minLength) {
        isValid = false;
        errorMessage = `Minimal ${field.minLength} karakter`;
    } else if (field.maxLength > 0 && value && value.length > field.maxLength) {
        isValid = false;
        errorMessage = `Maksimal ${field.maxLength} karakter`;
    } else if (field.pattern && value && !new RegExp(field.pattern).test(value)) {
        isValid = false;
        errorMessage = field.dataset.error || 'Format tidak valid';
    }

    if (!isValid) {
        showFieldError(field, errorMessage);
    } else {
        field.classList.add('input-valid');
    }

    return isValid;
}

function showFieldError(field, message) {
    field.classList.add('input-error');
    const existingError = field.parentElement?.querySelector('.field-error');
    if (!existingError) {
        const errorEl = document.createElement('span');
        errorEl.className = 'field-error';
        errorEl.textContent = message;
        field.parentElement?.appendChild(errorEl);
    }
}

function clearFieldError(field) {
    field.classList.remove('input-error', 'input-valid');
    const errorEl = field.parentElement?.querySelector('.field-error');
    if (errorEl) errorEl.remove();
}

function isEmailValid(email) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
}

function isPhoneValid(phone) {
    return /^(?:\+62|0)[0-9]{9,12}$/.test(phone.replace(/\D/g, ''));
}

window.validateForm = validateForm;
window.validateField = validateField;
