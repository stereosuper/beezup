var $ = require('jquery');

var throttle = require('./throttle.js');
window.requestAnimFrame = require('./requestAnimFrame.js');

var TweenLite = require('gsap/TweenLite');
require('gsap/ScrambleTextPlugin');
var sticky = require('./sticky.js');

module.exports = function(){
    if(!$('body').hasClass('home')) return;

    var windowWidth = window.outerWidth, windowScroll;
    var blockTitle = $('#titleHome'), titleHome = blockTitle.find('h1'), btnTopHome = $('#btnTopHome'), introHome = $('#introHome');
    var baseline = 200, isOverBaseline = true, largeScreen = true, alreadyInitLarge = true;


    function initTitleTxt(){
        titleHome.html(titleHome.data('before'));
        TweenLite.set(introHome, {display: 'none', opacity: 0});
    }

    function animScrambleText(dataToAnimate){
        TweenLite.to(titleHome, 0.5, {scrambleText: {text: titleHome.data(dataToAnimate), speed: 0.5, chars: 'lowerCase'}, ease: Linear.easeNone, onComplete: function(){
            titleHome.html(titleHome.data(dataToAnimate));
        }});
        isOverBaseline = !isOverBaseline;
    }

    function animTitleTxt(){
        windowWidth = window.outerWidth;
        windowScroll = $(window).scrollTop();
        
        if(windowWidth > 780){
            if(windowScroll >= baseline && isOverBaseline){
                animScrambleText('after');
                TweenLite.killTweensOf(introHome, true);
                introHome.stop().slideToggle(300, function(){
                    TweenLite.to(introHome, 0.3, {opacity: 1});
                });
            }else if(windowScroll < baseline && !isOverBaseline){
                animScrambleText('before');
                TweenLite.killTweensOf(introHome, true);
                introHome.stop();
                TweenLite.to(introHome, 0.3, {opacity: 0, onComplete: function(){
                    introHome.slideToggle(300);
                }});
            }
        }else if(alreadyInitLarge){
            titleHome.html(titleHome.data('after'));
        }
    }


    if(windowWidth > 780){
        initTitleTxt();
    }else{
        largeScreen = false;
        alreadyInitLarge = false;
    }

    sticky(blockTitle, 150, 'px', true);
    TweenLite.to(titleHome, 0.3, {opacity: 1});

    btnTopHome.on('click', function(e){
        e.preventDefault();
    });

    var scrollHandler = throttle(function(){
        requestAnimFrame(animTitleTxt);
    }, 40);

    $(document).on('scroll', scrollHandler);
    $(window).on('resize', scrollHandler);
}