const $ = require('jquery');
const Cookies = require('js-cookie');

$(() => {
    window.requestAnimFrame = require('./requestAnimFrame.js');
    const throttle = require('./throttle.js');
    const checkInputs = require('./checkInputs.js');
    const noTransition = require('./noTransition.js');
    const langSwitcher = require('./langSwitcher.js');
    const sticky = require('./sticky.js');
    const scrollTo = require('./scrollTo.js');
    const animTopHome = require('./animTopHome.js');
    const animSchema = require('./animSchema.js');
    // var addUrlInputs = require('./addUrlInputs.js');
    const filterChannels = require('./filterChannels.js');
    const dropdown = require('./dropdown.js');
    const animBees = require('./animBees.js');
    const animFonctionnalites = require('./animFonctionnalites.js');
    const sliderPrices = require('./sliderPrices.js');
    const submenu = require('./submenu.js');
    const selectForm = require('./selectForm.js');
    const initVideo = require('./initVideo.js');
    const contactAnchor = require('./contactAnchor.js');
    const contactFormSuccess = require('./contactFormSuccess.js');

    const body = $('body');
    const menuMain = $('#menuMain');
    const containersMenu = $('#containerMenuMain, #containerMenuHead');

    // window.outerWidth returns the window width including the scroll, but it's not working with $(window).outerWidth
    let windowWidth = window.outerWidth,
        windowHeight = $(window).height();
    const tempo = 0.4;

    function resizeHandler() {
        windowWidth = window.outerWidth;
        windowHeight = $(window).height();
        langSwitcher.checkLangState(windowWidth);
        submenu(menuMain);
    }

    // Petit hack dégueu pour IE11, les textes du schema etant décalés seulement sur ce browser
    if (!window.ActiveXObject && 'ActiveXObject' in window)
        body.addClass('ie11');

    // Lang Switcher
    body.on('click', '#current-language', () => {
        langSwitcher.clickOnLanguage(windowWidth);
    });
    langSwitcher.checkLangState(windowWidth);

    // Header responsive
    body.on('click', '#btnMenu, #btnMenuClose, #bgMobile', () => {
        $('#header').toggleClass('deployed');
        body.toggleClass('no-scroll');
    });

    // Header rollover
    menuMain
        .on('mouseenter', '> li', function() {
            $(this)
                .siblings()
                .addClass('off');
        })
        .on('mouseleave', '> li', function() {
            $(this)
                .siblings()
                .removeClass('off');
        });

    // Submenus
    submenu(menuMain);

    // No transition on resize
    noTransition(containersMenu);

    // Newsletter inputs
    checkInputs($('.js-inline-form'));

    // Sticky
    sticky($('#tarifHeader'), 0, {
        minimumWidth: 1200,
    });
    sticky($('#sideLinksNav'), 50, {
        unit: 'vh',
    });

    if ($('.inner-video').length) {
        initVideo();
    }

    // Fixed meu
    scrollTo($('#sideLinksNav'), true);
    scrollTo($('#menuFonctionnalites'));

    contactAnchor();
    contactFormSuccess();

    // Anim top home
    animTopHome($('#btnTopHome'));
    animSchema($('#schema'), windowWidth, tempo);

    // Anim fonctionnalités
    animFonctionnalites($('#animsFonctionnalites'), windowWidth, tempo);

    // Slect form
    selectForm(wp, $('#subject'), $('#theform'), $('#listid'));

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
    filterChannels(
        wp,
        $('#channels'),
        $('#channelsCountrySelect'),
        $('#channelsSectorSelect'),
        $('#channelsList')
    );

    // Dropdowns
    dropdown($('.js-btn-list'));

    // Bees anim
    animBees($('.js-bees'));

    // Cookies
    body.on('click', '#btnCookies', function(e) {
        e.preventDefault();
        Cookies.set('beez-cookies', true, { expires: 30, path: '/' });
        $(this)
            .parents('#cookies')
            .addClass('off');
    });

    $(window).on(
        'resize',
        throttle(() => {
            requestAnimFrame(resizeHandler);
        }, 60)
    );
});
