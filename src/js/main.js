'use strict';

var $ = require('jquery');
var Cookies = require('js-cookie');


$(function(){

    window.requestAnimFrame = require('./requestAnimFrame.js');
    var throttle = require('./throttle.js');
    var checkInputs = require('./checkInputs.js');
    var noTransition = require('./noTransition.js');
    var langSwitcher = require('./langSwitcher.js');
    var sticky = require('./sticky.js');
    var scrollTo = require('./scrollTo.js');
    var animTopHome = require('./animTopHome.js');
    var animSchema = require('./animSchema.js');
    // var addUrlInputs = require('./addUrlInputs.js');
    var filterChannels = require('./filterChannels.js');
    var dropdown = require('./dropdown.js');
    var animBees = require('./animBees.js');
    var animFonctionnalites = require('./animFonctionnalites.js');
    var sliderPrices = require('./sliderPrices.js');
    var submenu = require('./submenu.js');

    var body = $('body');
    var menuMain = $('#menuMain');
    var containersMenu = $('#containerMenuMain, #containerMenuHead');

    // window.outerWidth returns the window width including the scroll, but it's not working with $(window).outerWidth
    var windowWidth = window.outerWidth, windowHeight = $(window).height();
    var tempo = 0.4;

    function resizeHandler() {
        windowWidth = window.outerWidth;
        windowHeight = $(window).height();
        langSwitcher.checkLangState(windowWidth);
        submenu(menuMain);        
    }
    
    // Petit hack dégueu pour IE11, les textes du schema etant décalés seulement sur ce browser
    if(!(window.ActiveXObject) && "ActiveXObject" in window) body.addClass('ie11');


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
    menuMain.on('mouseenter', '> li', function(){
        $(this).siblings().addClass('off');
    }).on('mouseleave', '> li', function(){
        $(this).siblings().removeClass('off');
    });

    // Submenus
    submenu(menuMain);

    // No transition on resize 
    noTransition(containersMenu);

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
    animTopHome($('#btnTopHome'));
    animSchema($('#schema'), windowWidth, tempo);

    //Anim fonctionnalités
    animFonctionnalites($('#animsFonctionnalites'), windowWidth, tempo);
    
    // Add url inputs
    // addUrlInputs($('#addUrlInput'), $('#newInputsCount'));

    // Remove form success opacity
    // body.on('click', 'form', function(){
    //     if($(this).hasClass('success')){
    //         $(this).removeClass('success');
    //     }
    // });

    // Slider price tarif
    sliderPrices($('#tarifHeader'));

    // Networks page: dinamically get channels by country
    filterChannels(wp, $('#channels'), $('#channelsCountrySelect'), $('#channelsSectorSelect'), $('#channelsList'));

    // Dropdowns
    dropdown($('.js-btn-list'));

    // Bees anim
    animBees($('.js-bees'));

    // Cookies
    body.on('click', '#btnCookies', function(e){
        e.preventDefault();
        Cookies.set('beez-cookies', true, { expires: 30, path: '/' });
        $(this).parents('#cookies').addClass('off');
    });


    $(window).on('resize', throttle(function () {
        requestAnimFrame(resizeHandler);
    }, 60));

});
