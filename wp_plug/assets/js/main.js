/**
 * Main ESNP Kit JS
 */
(function () {
    'use strict';

    const ESNPKit = {
        init: function () {
            this.initMobileMenu();
            this.initStickyHeader();
            this.initFAQ();
            this.initSearch();
            this.initHeadline();
            this.initCarousel();
            this.initLottie();
            this.initCountdown();
            this.initTOC();
            this.initProgress();
            this.initAlly();
        },

        initAlly: function () {
            const wrapper = document.querySelector('.esnp-ally-wrapper');
            if (!wrapper) return;

            const toggle = wrapper.querySelector('.esnp-ally-toggle');
            const btns = wrapper.querySelectorAll('[data-ally]');

            toggle.addEventListener('click', () => wrapper.classList.toggle('esnp-is-open'));

            btns.forEach(btn => {
                btn.addEventListener('click', () => {
                    const type = btn.dataset.ally;
                    const body = document.body;

                    if (type === 'reset') {
                        body.classList.remove('esnp-ally-contrast', 'esnp-ally-grayscale', 'esnp-ally-font-large');
                    } else if (type === 'contrast') {
                        body.classList.toggle('esnp-ally-contrast');
                    } else if (type === 'grayscale') {
                        body.classList.toggle('esnp-ally-grayscale');
                    } else if (type === 'font-size') {
                        body.classList.toggle('esnp-ally-font-large');
                    }
                });
            });
        },

        initTOC: function () {
            const toc = document.querySelector('.esnp-toc-wrapper');
            if (!toc) return;

            const selectors = toc.dataset.selectors || 'h2,h3';
            const headers = document.querySelectorAll(selectors);
            const list = toc.querySelector('.esnp-toc-list');

            headers.forEach((header, i) => {
                if (!header.id) header.id = 'esnp-toc-' + i;
                const li = document.createElement('li');
                li.className = 'esnp-toc-item esnp-toc-item-' + header.tagName.toLowerCase();
                li.innerHTML = `<a href="#${header.id}" class="esnp-toc-link">${header.innerText}</a>`;
                list.appendChild(li);
            });
        },

        initProgress: function () {
            const tracker = document.querySelector('.esnp-progress-tracker');
            if (!tracker) return;

            const fill = tracker.querySelector('.esnp-progress-fill');
            const isCircular = tracker.classList.contains('esnp-tracker-circular');

            const update = () => {
                const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
                const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
                const scrolled = (winScroll / height) * 100;

                if (isCircular) {
                    const offset = 283 - (scrolled * 2.83);
                    fill.style.strokeDashoffset = offset;
                } else {
                    fill.style.width = scrolled + '%';
                }
            };

            window.addEventListener('scroll', update);
            update();
        },

        initCountdown: function () {
            const countdowns = document.querySelectorAll('.esnp-countdown');
            countdowns.forEach(el => {
                const targetDate = new Date(el.dataset.date).getTime();

                const update = () => {
                    const now = new Date().getTime();
                    const distance = targetDate - now;

                    if (distance < 0) {
                        el.innerHTML = '<div class="esnp-countdown-expired">Expired</div>';
                        return;
                    }

                    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                    const dEl = el.querySelector('.esnp-days');
                    if (dEl) dEl.innerText = days.toString().padStart(2, '0');
                    el.querySelector('.esnp-hours').innerText = hours.toString().padStart(2, '0');
                    el.querySelector('.esnp-minutes').innerText = minutes.toString().padStart(2, '0');
                    el.querySelector('.esnp-seconds').innerText = seconds.toString().padStart(2, '0');
                };

                update();
                setInterval(update, 1000);
            });
        },

        initLottie: function () {
            const containers = document.querySelectorAll('.esnp-lottie-container');
            containers.forEach(container => {
                const url = container.dataset.lottieUrl;
                if (!url) return;

                const animation = bodymovin.loadAnimation({
                    container: container,
                    path: url,
                    renderer: 'svg',
                    loop: container.dataset.loop === 'yes',
                    autoplay: container.dataset.autoplay === 'yes'
                });

                const speed = parseFloat(container.dataset.speed);
                if (speed !== 1) animation.setSpeed(speed);
            });
        },

        initCarousel: function () {
            const carousels = document.querySelectorAll('.esnp-carousel-pro');
            carousels.forEach(carousel => {
                const track = carousel.querySelector('.esnp-carousel-track');
                const slides = Array.from(track.children);
                const dots = Array.from(carousel.querySelectorAll('.esnp-carousel-dot'));
                const nextBtn = carousel.querySelector('.esnp-carousel-next');
                const prevBtn = carousel.querySelector('.esnp-carousel-prev');

                let currentSlide = 0;
                let autoplayTimer;

                const updateSlider = (index) => {
                    track.style.transform = `translateX(-${index * 100}%)`;
                    slides.forEach((s, i) => s.classList.toggle('esnp-is-active', i === index));
                    dots.forEach((d, i) => d.classList.toggle('esnp-is-active', i === index));
                    currentSlide = index;
                };

                nextBtn?.addEventListener('click', () => {
                    let next = (currentSlide + 1) % slides.length;
                    updateSlider(next);
                });

                prevBtn?.addEventListener('click', () => {
                    let prev = (currentSlide - 1 + slides.length) % slides.length;
                    updateSlider(prev);
                });

                dots.forEach((dot, i) => {
                    dot.addEventListener('click', () => updateSlider(i));
                });

                if (carousel.dataset.autoplay === 'yes') {
                    autoplayTimer = setInterval(() => nextBtn.click(), 5000);
                    if (carousel.dataset.pause === 'yes') {
                        carousel.addEventListener('mouseenter', () => clearInterval(autoplayTimer));
                        carousel.addEventListener('mouseleave', () => autoplayTimer = setInterval(() => nextBtn.click(), 5000));
                    }
                }
            });
        },

        initSearch: function () {
            const searchInputs = document.querySelectorAll('.esnp-search-input');
            searchInputs.forEach(input => {
                const wrapper = input.closest('.esnp-search-wrapper');
                if (!wrapper || wrapper.dataset.ajax !== 'yes') return;

                const resultsDiv = wrapper.querySelector('.esnp-search-results');
                let debounceTimer;

                input.addEventListener('input', function () {
                    const query = this.value.trim();
                    clearTimeout(debounceTimer);

                    if (query.length < 2) {
                        resultsDiv.style.display = 'none';
                        return;
                    }

                    debounceTimer = setTimeout(() => {
                        fetch(`${esnpData.ajaxUrl}?action=esnp_ajax_search&search_query=${query}`)
                            .then(response => response.text())
                            .then(data => {
                                resultsDiv.innerHTML = data;
                                resultsDiv.style.display = 'block';
                            });
                    }, 300);
                });

                document.addEventListener('click', (e) => {
                    if (!wrapper.contains(e.target)) {
                        resultsDiv.style.display = 'none';
                    }
                });
            });
        },

        initFAQ: function () {
            const faqs = document.querySelectorAll('.esnp-faq-question');
            faqs.forEach(faq => {
                faq.addEventListener('click', function () {
                    const item = this.closest('.esnp-faq-item');
                    if (item) item.classList.toggle('esnp-is-active');
                });
            });
        },

        initHeadline: function () {
            const headlines = document.querySelectorAll('.esnp-anim-rotate .esnp-headline-rotate');
            headlines.forEach(headline => {
                headline.classList.add('esnp-animating');
            });
        },

        initMobileMenu: function () {
            const toggles = document.querySelectorAll('.esnp-mobile-toggle');
            toggles.forEach(toggle => {
                toggle.addEventListener('click', function () {
                    const targetId = this.getAttribute('data-target');
                    const target = document.getElementById(targetId);
                    if (target) {
                        target.classList.toggle('esnp-is-active');
                        this.classList.toggle('esnp-is-active');
                    }
                });
            });
        },

        initStickyHeader: function () {
            const headers = document.querySelectorAll('.esnp-sticky-header');
            if (headers.length === 0) return;

            let lastScrollTop = 0;

            window.addEventListener('scroll', () => {
                let scrollTop = window.pageYOffset || document.documentElement.scrollTop;

                headers.forEach(header => {
                    const hideOnScroll = header.getAttribute('data-hide-on-scroll') === 'yes';

                    if (scrollTop > 100) {
                        header.classList.add('esnp-is-sticky');

                        if (hideOnScroll) {
                            if (scrollTop > lastScrollTop) {
                                header.classList.add('esnp-header-hidden');
                            } else {
                                header.classList.remove('esnp-header-hidden');
                            }
                        }
                    } else {
                        header.classList.remove('esnp-is-sticky');
                    }
                });

                lastScrollTop = scrollTop <= 0 ? 0 : scrollTop;
            }, { passive: true });
        }
    };

    document.addEventListener('DOMContentLoaded', () => {
        ESNPKit.init();
    });
})();
