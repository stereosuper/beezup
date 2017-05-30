var $ = require('jquery');

var throttle = require('./throttle.js');
window.requestAnimFrame = require('./requestAnimFrame.js');

var TweenLite = require('gsap/TweenLite');
var scrambleText = require('gsap/ScrambleTextPlugin');
var sticky = require('./sticky.js');

module.exports = function(){
    if(!$('body').hasClass('home')) return;

    var windowHeight, windowScroll, windowBottom;
    var titleHome = $('#titleHome h1'), titleHomePrimary = $('#titleHomePrimary'), titleHomeBlack = $('#titleHomeBlack');

    function initTitleTxt(){
        titleHomePrimary.html(titleHomePrimary.data('before'));
        titleHomeBlack.html(titleHomeBlack.data('before'));
        TweenLite.set(titleHome, {opacity: 1});
    }

    function animTitleTxt(){
        windowHeight = $(window).height();
        windowScroll = $(window).scrollTop();
        windowBottom = windowScroll + windowHeight;

        if(windowScroll >= 50){
            TweenLite.to(titleHomePrimary, 0.3, {delay: 3, scrambleText: titleHomePrimary.data('after'), speed: 0.1, ease:Linear.easeNone, onComplete:function(){
                titleHomePrimary.html(titleHomePrimary.data('after'));
            }});
            TweenLite.to(titleHomeBlack, 0.3, {delay: 3, scrambleText: titleHomeBlack.data('after'), speed: 0.1, ease:Linear.easeNone, onComplete:function(){
                titleHomeBlack.html(titleHomeBlack.data('after'));
            }});
        }else{

        }
    }

    initTitleTxt();
    sticky($('#titleHome'), 15);

    var scrollHandler = throttle(function(){
        requestAnimFrame(animTitleTxt);
    }, 40);

    $(document).on('scroll', scrollHandler);
    $(window).on('resize', scrollHandler);
}