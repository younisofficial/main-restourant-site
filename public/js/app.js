// Zaiqa Restaurant - small front-end helpers (no build step needed)
document.addEventListener('DOMContentLoaded', function () {
    const csrf = document.querySelector('meta[name="csrf-token"]')?.content;
    const stack = document.getElementById('toastStack');

    // ---- toast helper ----
    function toast(message, type = 'success') {
        if (!stack) return;
        const el = document.createElement('div');
        el.className = 'flash' + (type === 'error' ? ' error' : '');
        el.setAttribute('role', 'status');
        el.innerHTML = '<i class="bi ' + (type === 'error' ? 'bi-exclamation-circle' : 'bi-check-circle-fill') + '"></i>' +
            '<span></span><button type="button" class="btn-close" aria-label="Close"></button>';
        el.querySelector('span').textContent = message;
        el.querySelector('.btn-close').onclick = () => el.remove();
        stack.appendChild(el);
        setTimeout(() => el.remove(), 4000);
    }

    // auto-hide server flash messages
    document.querySelectorAll('.flash').forEach(function (el) {
        el.querySelector('.btn-close')?.addEventListener('click', () => el.remove());
        setTimeout(() => el.remove(), 5000);
    });

    // ---- Add to cart without page reload (falls back to normal form post) ----
    document.querySelectorAll('form.add-to-cart').forEach(function (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            const btn = form.querySelector('button[type="submit"]');
            const original = btn.innerHTML;
            btn.disabled = true;

            fetch(form.action, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                body: new FormData(form)
            })
                .then(r => r.ok ? r.json() : Promise.reject(r))
                .then(data => {
                    document.querySelectorAll('.cart-badge').forEach(function (b) {
                        b.textContent = data.count;
                        b.classList.remove('d-none', 'bump');
                        void b.offsetWidth;
                        b.classList.add('bump');
                    });
                    btn.classList.add('added');
                    btn.innerHTML = '<i class="bi bi-check-lg"></i> Added';
                    toast(data.message);
                    setTimeout(() => { btn.classList.remove('added'); btn.innerHTML = original; }, 1500);
                })
                .catch(() => form.submit())
                .finally(() => { btn.disabled = false; });
        });
    });

    // ---- Quantity +/- buttons in cart ----
    document.querySelectorAll('[data-qty-form]').forEach(function (form) {
        const input = form.querySelector('input[name="quantity"]');
        form.querySelectorAll('[data-step]').forEach(function (b) {
            b.addEventListener('click', function () {
                input.value = Math.max(0, parseInt(input.value, 10) + parseInt(b.dataset.step, 10));
                form.submit();
            });
        });
    });

    // ---- Confirm dialogs ----
    document.querySelectorAll('[data-confirm]').forEach(function (el) {
        el.addEventListener('submit', function (e) {
            if (!confirm(el.dataset.confirm)) e.preventDefault();
        });
    });
});
