'use strict';

var $ = require('jquery-slim');

// require('gsap');
// require('gsap/CSSPlugin');
// var TweenLite = require('gsap/TweenLite');


$(function(){

    window.requestAnimFrame = require('./requestAnimFrame.js');
    var throttle = require('./throttle.js');
    var checkInputs = require('./checkInputs.js');
    var langSwitcher = require('./langSwitcher.js');
    var sticky = require('./sticky.js');
    var scrollTo = require('./scrollTo.js');

    var body = $('body');
    // window.outerWidth returns the window width including the scroll, but it's not working with $(window).outerWidth
    var windowWidth = window.outerWidth, windowHeight = $(window).height();

    function resizeHandler() {
        windowWidth = window.outerWidth;
        windowHeight = $(window).height();
        langSwitcher.checkLangState(windowWidth);
    }

    // Lang Switcher
    $('#current-language').on('click', function (){
        langSwitcher.clickOnLanguage(windowWidth);
    });
    langSwitcher.checkLangState(windowWidth);

    // Header responsive
    $('#btnMenu, #btnMenuClose, #bgMobile').on('click', function (){
        $('#header').toggleClass('deployed'); 
        body.toggleClass('no-scroll');
    });

    // Newsletter inputs
    checkInputs($('#theform'));
    
    // Sticky
    sticky($('#btnDemo'), 15);
    sticky($('#sideLinksNav'), 50, 'vh');

    // Fixed meu
    scrollTo($('#sideLinksNav'), true);
    scrollTo($('#menuFonctionnalites'));


    $(window).on('resize', throttle(function(){
        requestAnimFrame(resizeHandler);
    }, 60)).on('load', function(){

    });
 
    $(document).on('scroll', throttle(function(){
    
    }, 60));

});
