const $ = require('jquery');
const TweenLite = require('gsap/TweenLite');
require('gsap/ScrollToPlugin');
require('gsap/CSSPlugin');

module.exports = () => {
    const scroll = hash => {
        if ($(`${hash}-will-scroll`).length) {
            TweenLite.to(window, 1, {
                scrollTo: {
                    y: $(`${hash}-will-scroll`).offset().top,
                    offsetY: 10,
                    autoKill: false,
                },
                onAfter: () => {
                    window.history.pushState(null, null, hash);
                },
            });
        }
    };

    $('.page-template-contact .cards a').on('click', function scrollToSection(
        e
    ) {
        e.preventDefault();

        const href = $(this).attr('href');
        scroll(href);
    });

    document.addEventListener('readystatechange', () => {
        if (document.readyState === 'complete') {
            setTimeout(() => {
                const hash = $(window.location)
                    .attr('hash')
                    .replace('/', '');

                scroll(hash);
            }, 100);
        }
    });
};
