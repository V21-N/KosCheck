/**
 * Micro Interactions
 * Button ripple effects, shake, bounce, and other micro animations
 */
export function initMicroInteractions() {
    // Button ripple effect
    document.querySelectorAll('button:not([data-no-ripple]), a.btn, a.button').forEach(btn => {
        btn.addEventListener('click', function(e) {
            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;

            const ripple = document.createElement('span');
            ripple.style.cssText = `position:absolute;width:${size}px;height:${size}px;left:${x}px;top:${y}px;border-radius:50%;background:rgba(255,255,255,0.3);pointer-events:none;transform:scale(0);animation:ripple-animate 0.6s ease-out;`;

            if (window.getComputedStyle(this).position === 'static') {
                this.style.position = 'relative';
            }
            this.style.overflow = 'hidden';

            this.appendChild(ripple);
            setTimeout(() => ripple.remove(), 600);
        });
    });

    // Input focus animation
    document.querySelectorAll('input[type="text"], input[type="email"], input[type="password"], textarea').forEach(input => {
        input.addEventListener('focus', () => input.parentElement?.classList.add('input-focused'));
        input.addEventListener('blur', () => input.parentElement?.classList.remove('input-focused'));
    });

    // Checkbox bounce animation
    document.querySelectorAll('input[type="checkbox"], input[type="radio"]').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            this.parentElement?.classList.add('checkbox-animate');
            setTimeout(() => this.parentElement?.classList.remove('checkbox-animate'), 300);
        });
    });

    // Shake animation on invalid input
    document.querySelectorAll('[data-shake]').forEach(el => {
        el.addEventListener('click', () => {
            el.style.animation = 'shake 0.5s ease-in-out';
            setTimeout(() => { el.style.animation = ''; }, 500);
        });
    });
}

export function animateCounter(element, target, duration = 1000) {
    if (typeof element === 'string') element = document.querySelector(element);
    if (!element) return;

    const start = parseInt(element.dataset.value || element.textContent) || 0;
    const increment = (target - start) / (duration / 16);
    let current = start;

    const timer = setInterval(() => {
        current += increment;
        if ((increment > 0 && current >= target) || (increment < 0 && current <= target)) {
            element.textContent = target.toLocaleString('id-ID');
            clearInterval(timer);
        } else {
            element.textContent = Math.floor(current).toLocaleString('id-ID');
        }
    }, 16);
}

export function bounce(element) {
    if (typeof element === 'string') element = document.querySelector(element);
    if (!element) return;
    element.style.animation = 'bounce 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94)';
    setTimeout(() => { element.style.animation = ''; }, 600);
}

export function pulse(element) {
    if (typeof element === 'string') element = document.querySelector(element);
    if (!element) return;
    element.style.animation = 'pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite';
}

export function shake(element) {
    if (typeof element === 'string') element = document.querySelector(element);
    if (!element) return;
    element.style.animation = 'shake 0.5s ease-in-out';
    setTimeout(() => { element.style.animation = ''; }, 500);
}

window.animateCounter = animateCounter;
window.bounce = bounce;
window.pulse = pulse;
window.shake = shake;
