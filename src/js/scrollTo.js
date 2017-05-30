var $ = require('jquery');

require('gsap/CSSPlugin');
require('gsap/ScrollToPlugin');
var TweenLite = require('gsap/TweenLite');

window.requestAnimFrame = require('./requestAnimFrame.js');
var throttle = require('./throttle.js');

module.exports = function(elt, activeClass = false){
    if (!elt.length) return;
    
    var target, scrollPos, currLink, refElement;

    function scrollTo(e) {
        e.preventDefault();
        var link = e.target.hash;
        TweenLite.to(window, 1, {scrollTo: { y: $(link).offset().top - 70 }, onComplete: function () {
            history.pushState(null, null, link);
        }});
    }

    function onScroll(){
        if (!activeClass) return;
        scrollPos = $(document).scrollTop();
        elt.find('a[href^="#"]').each(function () {
            currLink = $(this);
            refElement = $(currLink.attr("href"));
            if (refElement.data('top')-100 <= scrollPos && refElement.data('top')+ refElement.data('height')+100 > scrollPos) {
                elt.find('li').removeClass("active");
                currLink.parent().addClass("active");
            }
            else{
                currLink.parent().removeClass("active");
            }
        });
    }

    function onResize() {
        elt.find('a[href^="#"]').each(function () {
            target = $($(this).attr('href'));
            target.data('top', target.offset().top).data('height', target.height());
        });
    }

    elt.on('click', 'a', scrollTo).find('a[href^="#"]').each(function () {
        target = $($(this).attr('href'));
        target.data('top', target.offset().top).data('height', target.height());
    });

    $(window).on('resize', throttle(function(){
        requestAnimFrame(onResize);
    }, 60));


    $(document).on('scroll', throttle(function(){
        requestAnimFrame(onScroll);
    }, 10));
}
