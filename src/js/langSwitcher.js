var $ = require('jquery-slim');


require('gsap/CSSPlugin');
var TweenLite = require('gsap/TweenLite');

var containerMenuHead = $('#container-menu-head');
var langOpen = false;
var langHeight;
var eltsToMove = [$('#header-lang-switcher'), $('#menu-head')];
var listLang = $('#otherLanguage');

var checkLangState = function (windowWidth) {
    langHeight = listLang.height();
    if (windowWidth > 960) {
        TweenLite.to(eltsToMove, 0.3, { y: '0px' });
    } else {
        if (!langOpen) {
            TweenLite.to(eltsToMove, 0.3, { y: langHeight+'px' });
        } else {
            TweenLite.to(eltsToMove, 0.3, { y: '0px' });
        }    
    }
}    

var clickOnLanguage = function (windowWidth) {
    langHeight = listLang.height();
    containerMenuHead.toggleClass('open');
    if (windowWidth <= 960) {
        if (langOpen) {
            TweenLite.to(eltsToMove, 0.3, { y: langHeight+'px' });
        } else {
            TweenLite.to(eltsToMove, 0.3, { y: '0px' });
        }    
    }
    langOpen = !langOpen;
}

module.exports = {
    checkLangState: checkLangState,
    clickOnLanguage : clickOnLanguage
}