var $ = require('jquery');

var throttle = require('./throttle.js');
window.requestAnimFrame = require('./requestAnimFrame.js');

var TweenLite = require('gsap/TweenLite');
var scrambleText = require('gsap/ScrambleTextPlugin');
var sticky = require('./sticky.js');

module.exports = function(){
    if(!$('body').hasClass('home')) return;

    var windowHeight, windowScroll, windowBottom;
    var titleHome = $('#titleHome h1'), textToAnim = $('.textToAnim'), btnTopHome = $('#btnTopHome'), introHome = $('#introHome');
    var isOverBaseline = true;

    function initTitleTxt(){
        textToAnim.each(function(){
            $(this).html($(this).data('before'));
        });
        TweenLite.to(titleHome, 0.3, {opacity: 1});
    }
    function animScrambleText(dataToAnimate){
        textToAnim.each(function(){
            TweenLite.to($(this), 0.3, {scrambleText: $(this).data(dataToAnimate), speed: 0.1, ease: Linear.easeNone, onComplete:function(){
                $(this).html($(this).data(dataToAnimate));
            }});
        });
        isOverBaseline = !isOverBaseline;
    }
    function animTitleTxt(){
        windowHeight = $(window).height();
        windowScroll = $(window).scrollTop();
        windowBottom = windowScroll + windowHeight;

        if(windowScroll >= 200 && isOverBaseline){
            animScrambleText('after');
            introHome.slideToggle(300, function(){
                TweenLite.to(introHome, 0.3, {opacity: 1});
            });
        }else if(windowScroll < 200 && !isOverBaseline){
            animScrambleText('before');
            TweenLite.to(introHome, 0.3, {opacity: 0, onComplete: function(){
                introHome.slideToggle(300);
            }});
        }
    }

    initTitleTxt();
    sticky($('#titleHome'), 15);

    btnTopHome.on('click', function(e){
        e.preventDefault();
    });

    var scrollHandler = throttle(function(){
        requestAnimFrame(animTitleTxt);
    }, 40);

    $(document).on('scroll', scrollHandler);
    $(window).on('resize', scrollHandler);
}