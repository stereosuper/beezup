'use strict';

var $ = require('jquery');
var Cookies = require('js-cookie');

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
    var animTopHome = require('./animTopHome.js');
    var animSchema = require('./animSchema.js');
    var addUrlInputs = require('./addUrlInputs.js');
    var filterChannels = require('./filterChannels.js');
    var dropdown = require('./dropdown.js');
    var animBees = require('./animBees.js');

    var body = $('body');
    var forms = $('form');
    var bees = $('.js-bees');
    // window.outerWidth returns the window width including the scroll, but it's not working with $(window).outerWidth
    var windowWidth = window.outerWidth, windowHeight = $(window).height();

    // On window resize
    function resizeHandler(){
        windowWidth = window.outerWidth;
        windowHeight = $(window).height();
        
        langSwitcher.checkLangState(windowWidth);
    }

    // Lang Switcher
    body.on('click', '#current-language', function(){
        langSwitcher.clickOnLanguage(windowWidth);
    });
    langSwitcher.checkLangState(windowWidth);

    // Header responsive
    body.on('click', '#btnMenu, #btnMenuClose, #bgMobile', function(){
        $('#header').toggleClass('deployed'); 
        body.toggleClass('no-scroll');
    });

    // Header rollover
    $('#menuMain').on('mouseenter', '> li', function(){
        $(this).siblings().addClass('off');
    }).on('mouseleave', '> li', function(){
        $(this).siblings().removeClass('off');
    });

    // Newsletter inputs
    checkInputs($('.js-inline-form'));
    
    // Sticky
    sticky($('#btnDemo'), 15, {
        wrapper: false 
    });
    sticky($('#tarifHeader'), 0, {
        minimumWidth: 1200
    });
    sticky($('#sideLinksNav'), 50, {
        unit: 'vh'
    });

    
    // Fixed meu
    scrollTo($('#sideLinksNav'), true);
    scrollTo($('#menuFonctionnalites'));

    // Anim top home
    animTopHome();
    animSchema($('#schema'), windowWidth);
    
    // Add url inputs
    addUrlInputs($('#addUrlInput'), $('#newInputsCount'));

    // Remove form success opacity
    if(forms.length){
        forms.each(function(){
            $(this).on('click', function(){
                if($(this).hasClass('success')){
                    $(this).removeClass('success');
                }
            });
        });
    }

    // Slider price tarif
    $('#tarifHeader').find('.js-btnPrice').each(function () {
        $(this).on('click', function () {
            $('#tarifHeader').find('.js-price.selected').removeClass('selected');
            $(this).parent().addClass('selected');

            var price = $(this)[0].dataset.price;
            var classPrice = '.js-field' + price;
            $('#tarifOffers').find('.price:not("hidden")').addClass('hidden');
            $('#tarifOffers').find(classPrice).removeClass('hidden');

                
        });
    });

    

    // Networks page: dinamically get channels by country
    filterChannels(wp, $('#channels'), $('#channelsCountrySelect'), $('#channelsSectorSelect'), $('#channelsList'));

    // Dropdowns
    dropdown($('.js-btn-list'));

    // Bees anim
    if(bees.length){
        animBees(bees);
    }

    // Cookies
    body.on('click', '#btnCookies', function(e){
        e.preventDefault();
        Cookies.set('beez-cookies', true, { expires: 30, path: '/' });
        $(this).parents('#cookies').addClass('off');
    });


    $(window).on('resize', throttle(function(){

        requestAnimFrame(resizeHandler);

    }, 60)).on('load', function(){

    });
 
    $(document).on('scroll', throttle(function(){
    
    }, 60));

});
