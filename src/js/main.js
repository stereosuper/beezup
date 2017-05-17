'use strict';

var $ = require('jquery-slim');

// require('gsap');
require('gsap/CSSPlugin');
var TweenLite = require('gsap/TweenLite');


$(function(){

    window.requestAnimFrame = require('./requestAnimFrame.js');
    var throttle = require('./throttle.js');
    var checkInputs = require('./checkInputs.js');
    var langSwitcher = require('./langSwitcher.js');

    var body = $('body');
    // window.outerWidth returns the window width including the scroll, but it's not working with $(window).outerWidth
    var windowWidth = window.outerWidth, windowHeight = $(window).height();

    function resizeHandler() {
        windowWidth = window.outerWidth;
        windowHeight = $(window).height();
        langSwitcher.checkLangState(windowWidth);
    }
 
    $('#current-language').on('click', function () {
        langSwitcher.clickOnLanguage(windowWidth);
    });

    $('#btn-menu, #btn-menu-close').on('click', function () {
        $('#header').toggleClass('deployed'); 
        $('body').toggleClass('no-scroll')
    });

    checkInputs($('form'));
    langSwitcher.checkLangState(windowWidth);

    $(window).on('resize', throttle(function(){
        requestAnimFrame(resizeHandler);
    }, 60)).on('load', function(){

    });


    $(document).on('scroll', throttle(function(){

    }, 60));

});
