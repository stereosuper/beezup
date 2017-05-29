var $ = require('jquery');

require('gsap/CSSPlugin');
var TweenLite = require('gsap/TweenLite');

window.requestAnimFrame = require('./requestAnimFrame.js');
var throttle = require('./throttle.js');

module.exports = function(elt, activeClass = false){
    if(!elt.length) return;

    function scrollTo(e) {
        e.preventDefault();
        var link = e.target.hash;
        TweenLite.to(window, 1, {scrollTo:{y:$(link).offset().top - 70}});
        window.location.hash = link;
    }

    function onScroll(){
        if (!activeClass) return;
        var scrollPos = $(document).scrollTop();
        elt.find('a[href^="#"]').each(function () {
            var currLink = $(this);
            var refElement = $(currLink.attr("href"));
            if (refElement.offset().top-100 <= scrollPos && refElement.offset().top + refElement.height()+100 > scrollPos) {
                elt.find('li').removeClass("active");
                currLink.parent().addClass("active");
            }
            else{
                currLink.parent().removeClass("active");
            }
        });
    }

    elt.find('a').on('click', function (e) {
        scrollTo(e);
    });


    $(document).on('scroll', throttle(function(){
        requestAnimFrame(onScroll);
    }, 10));
}
