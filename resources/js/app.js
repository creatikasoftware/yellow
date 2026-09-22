import './bootstrap';

document.addEventListener('DOMContentLoaded', function () {
    const path = window.location.pathname.replace(/\/+$/, '') || '/';
    document.querySelectorAll('.navbar .nav-link').forEach((link) => {
        const href = link.getAttribute('href');
        if (href && href.startsWith('#')) return;
        if (href && path.endsWith(href.replace('./', ''))) link.classList.add('active');
    });

    initCountdowns();
});

function initCountdowns() {
    const pad = (n) => String(Math.max(n, 0)).padStart(2, '0');

    document.querySelectorAll('[data-countdown]').forEach((el) => {
        const target = new Date(el.dataset.countdown).getTime();
        if (Number.isNaN(target)) return;

        const days = el.querySelector('[data-countdown-days]');
        const hours = el.querySelector('[data-countdown-hours]');
        const mins = el.querySelector('[data-countdown-mins]');
        const secs = el.querySelector('[data-countdown-secs]');

        const tick = () => {
            const diff = target - Date.now();

            if (diff <= 0) {
                [days, hours, mins, secs].forEach((node) => node && (node.textContent = '00'));
                clearInterval(timer);
                return;
            }

            const totalSeconds = Math.floor(diff / 1000);
            if (days) days.textContent = pad(Math.floor(totalSeconds / 86400));
            if (hours) hours.textContent = pad(Math.floor((totalSeconds % 86400) / 3600));
            if (mins) mins.textContent = pad(Math.floor((totalSeconds % 3600) / 60));
            if (secs) secs.textContent = pad(totalSeconds % 60);
        };

        tick();
        const timer = setInterval(tick, 1000);
    });
}
