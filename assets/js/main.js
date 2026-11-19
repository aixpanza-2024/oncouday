(function () {
    'use strict';

    var $ = function (sel, ctx) { return (ctx || document).querySelector(sel); };
    var $$ = function (sel, ctx) { return Array.prototype.slice.call((ctx || document).querySelectorAll(sel)); };
    var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    function onReady(fn) {
        if (document.readyState !== 'loading') { fn(); } else { document.addEventListener('DOMContentLoaded', fn); }
    }

    function toast(message) {
        var el = $('#ouToast');
        if (!el || !window.bootstrap) { return; }
        $('.toast-body', el).textContent = message;
        bootstrap.Toast.getOrCreateInstance(el, { delay: 3500 }).show();
    }

    function initAOS() {
        if (!window.AOS) { return; }
        AOS.init({ duration: 750, easing: 'ease-out-cubic', once: true, offset: 50, disable: reduceMotion });
        window.addEventListener('load', function () { AOS.refresh(); });
    }

    function initScrollUI() {
        var header = $('#siteHeader');
        var bar = $('.scroll-progress span');
        var toTop = $('.back-to-top');
        var ticking = false;

        function update() {
            var y = window.scrollY;
            var max = document.documentElement.scrollHeight - window.innerHeight;
            if (header) { header.classList.toggle('is-scrolled', y > 10); }
            if (bar) { bar.style.transform = 'scaleX(' + (max > 0 ? Math.min(y / max, 1) : 0) + ')'; }
            if (toTop) { toTop.classList.toggle('is-visible', y > 600); }
            ticking = false;
        }
        window.addEventListener('scroll', function () {
            if (!ticking) { window.requestAnimationFrame(update); ticking = true; }
        }, { passive: true });
        update();

        if (toTop) {
            toTop.addEventListener('click', function (e) {
                e.preventDefault();
                window.scrollTo({ top: 0, behavior: reduceMotion ? 'auto' : 'smooth' });
            });
        }
    }

    function initLanguage() {
        var allowed = ['en', 'hi', 'ml'];
        $$('.lang-btn').forEach(function (btn) {
            btn.addEventListener('click', function () {
                var code = btn.getAttribute('data-lang');
                if (allowed.indexOf(code) === -1) { return; }
                $$('.lang-btn').forEach(function (b) {
                    var on = b.getAttribute('data-lang') === code;
                    b.classList.toggle('active', on);
                    b.setAttribute('aria-pressed', on ? 'true' : 'false');
                });
                try { localStorage.setItem('ou_lang', code); } catch (err) {  }
                if (code !== 'en') {
                    toast(btn.textContent.trim() + ' — translated pages are being prepared and will be available soon.');
                }
            });
        });
    }

    function initChats() {
        var chats = $$('.js-chat');
        if (!chats.length) { return; }
        if (reduceMotion || !('IntersectionObserver' in window)) { return; }

        chats.forEach(function (chat) { chat.classList.add('is-ready'); });

        var io = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (!entry.isIntersecting) { return; }
                io.unobserve(entry.target);
                playChat(entry.target);
            });
        }, { threshold: 0.35 });
        chats.forEach(function (c) { io.observe(c); });
    }

    function playChat(chat) {
        var items = $$(':scope > .chat-msg, :scope > .chat-options, :scope > .chat-note', chat);
        var typing = $('.chat-typing', chat);
        var i = 0;

        function next() {
            if (i >= items.length) { chat.classList.add('is-done'); return; }
            var item = items[i];
            var isIncoming = item.classList.contains('in');
            if (typing && isIncoming && i > 0) {
                item.parentNode.insertBefore(typing, item);
                typing.classList.add('is-active');
                setTimeout(function () {
                    typing.classList.remove('is-active');
                    item.classList.add('is-visible');
                    i++; setTimeout(next, 500);
                }, 900);
            } else {
                item.classList.add('is-visible');
                i++; setTimeout(next, 650);
            }
        }
        setTimeout(next, 350);
    }

    function initCounters() {
        var nums = $$('[data-count]');
        if (!nums.length || reduceMotion || !('IntersectionObserver' in window)) { return; }
        var io = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (!entry.isIntersecting) { return; }
                io.unobserve(entry.target);
                var el = entry.target;
                var target = parseInt(el.getAttribute('data-count'), 10) || 0;
                var pad = parseInt(el.getAttribute('data-pad'), 10) || 0;
                var start = null;
                function step(ts) {
                    if (!start) { start = ts; }
                    var p = Math.min((ts - start) / 900, 1);
                    var val = String(Math.round(target * (1 - Math.pow(1 - p, 3))));
                    while (val.length < pad) { val = '0' + val; }
                    el.textContent = val;
                    if (p < 1) { requestAnimationFrame(step); }
                }
                requestAnimationFrame(step);
            });
        }, { threshold: 0.6 });
        nums.forEach(function (n) { io.observe(n); });
    }

    function initParallax() {
        if (reduceMotion || window.matchMedia('(hover: none)').matches) { return; }
        var heroes = $$('.hero, .page-hero, .reg-section');
        heroes.forEach(function (hero) {
            var art = $('.illus', hero);
            if (!art) { return; }
            hero.addEventListener('mousemove', function (e) {
                var r = hero.getBoundingClientRect();
                var x = (e.clientX - r.left) / r.width - 0.5;
                var y = (e.clientY - r.top) / r.height - 0.5;
                art.style.translate = (x * 18).toFixed(1) + 'px ' + (y * 14).toFixed(1) + 'px';
            });
            hero.addEventListener('mouseleave', function () { art.style.translate = '0 0'; });
        });
    }

    function initForms() {
        $$('.js-phone').forEach(function (input) {
            input.addEventListener('input', function () {
                var clean = input.value.replace(/\D/g, '').slice(0, 10);
                if (clean !== input.value) { input.value = clean; }
            });
        });

        $$('.js-counter').forEach(function (area) {
            var out = $('.js-counter-out', area.parentNode);
            if (!out) { return; }
            var update = function () { out.textContent = String(area.value.length); };
            area.addEventListener('input', update); update();
        });

        $$('.needs-validation').forEach(function (form) {
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                $$('input[type=text], input[type=email], textarea', form).forEach(function (f) { f.value = f.value.trim(); });

                if (!form.checkValidity()) {
                    form.classList.add('was-validated');
                    var firstInvalid = $(':invalid', form);
                    if (firstInvalid) { firstInvalid.focus({ preventScroll: true }); firstInvalid.scrollIntoView({ behavior: reduceMotion ? 'auto' : 'smooth', block: 'center' }); }
                    return;
                }

                var hp = $('input[name=website]', form);
                if (hp && hp.value !== '') { return; }

                var btn = $('.btn-submit', form);
                if (btn) { btn.classList.add('is-loading'); btn.disabled = true; }

                // For now we just show the thank-you message here.
                // Once the backend is ready, this is where the form gets posted to the server.
                setTimeout(function () {
                    if (btn) { btn.classList.remove('is-loading'); btn.disabled = false; }
                    showSuccess(form.getAttribute('data-success-title'), form.getAttribute('data-success-text'));
                    form.reset();
                    form.classList.remove('was-validated');
                    form.dispatchEvent(new Event('ou:reset'));
                }, 900);
            });
        });
    }

    function showSuccess(title, text) {
        var modal = $('#successModal');
        if (!modal || !window.bootstrap) { return; }
        $('[data-fill=title]', modal).textContent = title || 'Thank you!';
        $('[data-fill=text]', modal).textContent = text || '';
        bootstrap.Modal.getOrCreateInstance(modal).show();
    }

    function initDoctorMode() {
        var inputs = $$('.js-mode-input');
        if (!inputs.length) { return; }
        function apply() {
            var checked = $('.js-mode-input:checked');
            var mode = checked ? checked.value : 'running';
            $$('.js-mode-panel').forEach(function (p) { p.hidden = p.getAttribute('data-mode') !== mode; });
        }
        inputs.forEach(function (i) { i.addEventListener('change', apply); });
        var form = inputs[0].form;
        if (form) { form.addEventListener('ou:reset', function () { setTimeout(apply, 0); }); }
        apply();
    }

    function initMultiSelect() {
        $$('.js-multi-select').forEach(function (wrap) {
            var label = $('.js-multi-label', wrap);
            var placeholder = wrap.getAttribute('data-placeholder') || '';
            function update() {
                var picked = $$('input:checked', wrap).map(function (c) {
                    var l = $('label[for="' + c.id + '"]', wrap);
                    return l ? l.textContent.trim() : c.value;
                });
                label.textContent = picked.length === 0 ? placeholder
                    : (picked.length <= 2 ? picked.join(', ') : picked.length + ' cancer types selected');
            }
            wrap.addEventListener('change', update);
            var form = wrap.closest('form');
            if (form) { form.addEventListener('ou:reset', function () { setTimeout(update, 0); }); }
        });
    }

    function initAgeToggle() {
        var age = $('.js-age');
        if (!age) { return; }
        var guardianInput = $('#pGuardian');
        var nameLabel = $('.js-name-label');
        function apply() {
            var value = age.value.trim();
            var minor = value !== '' && Number(value) < 18;
            $$('.js-guardian').forEach(function (el) { el.hidden = !minor; });
            if (guardianInput) { guardianInput.required = minor; }
            if (nameLabel) { nameLabel.textContent = minor ? "Patient's full name" : 'Full name'; }
        }
        age.addEventListener('input', apply);
        if (age.form) { age.form.addEventListener('ou:reset', function () { setTimeout(apply, 0); }); }
        apply();
    }

    function citiesFor(city, state) {
        var map = {};
        try { map = JSON.parse(city.getAttribute('data-cities') || '{}'); } catch (err) { }
        if (state) { return Promise.resolve(map[state] || []); }
        var all = [];
        Object.keys(map).forEach(function (k) { all = all.concat(map[k]); });
        all.sort(function (a, b) { return a.name.localeCompare(b.name); });
        return Promise.resolve(all);
    }

    function fillCities(city, state) {
        var isForm = city.getAttribute('data-mode') === 'form';
        var keep = city.value;
        return (isForm && !state ? Promise.resolve([]) : citiesFor(city, state)).then(function (list) {
            var placeholder = isForm
                ? (state ? 'Select your city' : 'Select a state first')
                : (state ? 'All cities in ' + state : 'All cities');
            city.innerHTML = '';
            city.appendChild(new Option(placeholder, ''));
            list.forEach(function (c) { city.appendChild(new Option(c.name, c.slug)); });
            city.value = list.some(function (c) { return c.slug === keep; }) ? keep : '';
            if (isForm) { city.disabled = !state; }
        });
    }

    function initStateCity() {
        $$('.js-state').forEach(function (state) {
            var city = $('.js-city', state.form || document);
            if (!city) { return; }
            if (city.getAttribute('data-mode') === 'form') { fillCities(city, state.value); }
            state.addEventListener('change', function () { fillCities(city, state.value); });
            if (state.form) {
                state.form.addEventListener('ou:reset', function () { setTimeout(function () { fillCities(city, state.value); }, 0); });
            }
        });
    }

    function initExploreFilters() {
        var key = 'ou_explore_y';
        try {
            var saved = sessionStorage.getItem(key);
            if (saved !== null) {
                sessionStorage.removeItem(key);
                document.documentElement.style.scrollBehavior = 'auto';
                window.scrollTo(0, parseInt(saved, 10) || 0);
                document.documentElement.style.scrollBehavior = '';
            }
        } catch (err) { }

        function send(form) {
            try { sessionStorage.setItem(key, String(window.scrollY)); } catch (err) { }
            form.requestSubmit ? form.requestSubmit() : form.submit();
        }

        var form = $('.js-filter-form');
        if (form) {
            var timer;
            // Any filter change reloads the page so the server can send back the matching trials.
            form.addEventListener('change', function (e) {
                if (e.target.name === 'q') { return; }
                if (e.target.name === 'state') {
                    var city = $('select[name=city]', form);
                    if (city) { city.value = ''; }
                }
                send(form);
            });
            var q = $('input[name=q]', form);
            if (q) {
                // Wait until the user stops typing before asking the server, so we don't send a request on every key.
                q.addEventListener('input', function () {
                    clearTimeout(timer);
                    timer = setTimeout(function () { send(form); }, 700);
                });
            }
        }

        var sort = $('.js-sort-form select');
        // Changing the sort order asks the server for the same results in the new order.
        if (sort) { sort.addEventListener('change', function () { send(sort.form); }); }
    }

    function initEnrolment() {
        var modal = $('#enrolmentModal');
        if (!modal) { return; }
        document.addEventListener('click', function (e) {
            var btn = e.target.closest('.js-enrolment');
            if (!btn || !window.bootstrap) { return; }
            ['title', 'cancer', 'hospital', 'registry'].forEach(function (key) {
                var target = $('[data-fill=' + key + ']', modal);
                if (target) { target.textContent = btn.getAttribute('data-' + key) || '—'; }
            });
            bootstrap.Modal.getOrCreateInstance(modal).show(btn);
        });
    }

    function initFaqSearch() {
        var input = $('.js-faq-search');
        if (!input) { return; }
        var empty = $('.js-faq-empty');
        input.addEventListener('input', function () {
            var term = input.value.trim().toLowerCase();
            var anyVisible = false;
            $$('.tab-content > .tab-pane').forEach(function (pane) {
                if (term) { pane.classList.add('show', 'active'); }
            });
            $$('.js-faq-item').forEach(function (item) {
                var match = !term || item.textContent.toLowerCase().indexOf(term) !== -1;
                item.hidden = !match;
                if (match) { anyVisible = true; }
            });
            if (!term) {
                var activeTab = $('.faq-tools [data-bs-toggle=pill].active');
                var target = activeTab ? activeTab.getAttribute('data-bs-target') : null;
                $$('.tab-content > .tab-pane').forEach(function (pane) {
                    var on = target && ('#' + pane.id) === target;
                    pane.classList.toggle('show', on);
                    pane.classList.toggle('active', on);
                });
            }
            if (empty) { empty.hidden = anyVisible; }
        });
        $$('.faq-tools [data-bs-toggle=pill]').forEach(function (tab) {
            tab.addEventListener('show.bs.tab', function () {
                input.value = '';
                $$('.js-faq-item').forEach(function (i) { i.hidden = false; });
                if (empty) { empty.hidden = true; }
            });
        });
    }

    function initToastButtons() {
        document.addEventListener('click', function (e) {
            var btn = e.target.closest('.js-toast');
            if (btn) { toast(btn.getAttribute('data-toast') || ''); }
        });
    }

    function initMobileNav() {
        var nav = $('#mainNav');
        if (!nav) { return; }
        $$('a', nav).forEach(function (a) {
            a.addEventListener('click', function () {
                if (window.bootstrap && nav.classList.contains('show')) {
                    bootstrap.Offcanvas.getOrCreateInstance(nav).hide();
                }
            });
        });
    }

    onReady(function () {
        initAOS();
        initScrollUI();
        initLanguage();
        initChats();
        initCounters();
        initParallax();
        initForms();
        initDoctorMode();
        initMultiSelect();
        initAgeToggle();
        initStateCity();
        initExploreFilters();
        initEnrolment();
        initFaqSearch();
        initToastButtons();
        initMobileNav();
    });
})();
