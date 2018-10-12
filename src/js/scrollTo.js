const $ = require('jquery');

require('gsap/CSSPlugin');
require('gsap/ScrollToPlugin');
const TweenLite = require('gsap/TweenLite');

window.requestAnimFrame = require('./requestAnimFrame.js');
const throttle = require('./throttle.js');

module.exports = function(elt, activeClass = false) {
    if (!elt.length) return;

    let target, scrollPos, currLink, refElement, link;

    function scrollTo(e) {
        e.preventDefault();
        link = e.target.hash;
        TweenLite.to(window, 1, {
            scrollTo: { y: $(link).offset().top - 70 },
            onComplete() {
                history.pushState(null, null, link);
            },
        });
    }

    function setData() {
        elt.find('a[href^="#"]').each(function() {
            target = $($(this).attr('href'));
            target
                .data('top', target.offset().top)
                .data('height', target.height());
        });
    }

    function onScroll() {
        if (!activeClass) return;

        scrollPos = $(document).scrollTop();

        elt.find('a[href^="#"]').each(function() {
            currLink = $(this);
            refElement = $(currLink.attr('href'));

            if (
                refElement.data('top') - 100 <= scrollPos &&
                refElement.data('top') + refElement.data('height') + 100 >
                    scrollPos
            ) {
                currLink
                    .parent()
                    .addClass('active')
                    .siblings()
                    .removeClass('active');
            } else {
                currLink.parent().removeClass('active');
            }
        });
    }

    elt.on('click', 'a[href^="#"]', scrollTo);
    setData();

    $(window).on(
        'resize',
        throttle(() => {
            requestAnimFrame(setData);
        }, 60)
    );

    $(document).on(
        'scroll',
        throttle(() => {
            requestAnimFrame(onScroll);
        }, 10)
    );
};
