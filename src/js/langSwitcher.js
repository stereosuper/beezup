var $ = require('jquery');

require('gsap/CSSPlugin');
var TweenLite = require('gsap/TweenLite');


var containerMenuHead = $('#containerMenuHead');
var langOpen = false;
var langHeight;
var eltsToMove = [$('#header-lang-switcher'), $('#menuHead')];
var listLang = $('#otherLanguage');


var checkLangState = function(windowWidth){
    langHeight = listLang.height();
    
    if(windowWidth > 960){
        TweenLite.to(eltsToMove, 0.3, { y: '0px' });
    }else{
        langOpen ? TweenLite.to(eltsToMove, 0.3, { y: '0px' }) : TweenLite.to(eltsToMove, 0.3, { y: langHeight + 'px' });
    }
}    

var clickOnLanguage = function(windowWidth){
    langHeight = listLang.height();
    containerMenuHead.toggleClass('open');
    
    if(windowWidth <= 960){
        langOpen ? TweenLite.to(eltsToMove, 0.3, { y: langHeight + 'px', rotation: 0.01 }) : TweenLite.to(eltsToMove, 0.3, { y: '0px' });
    }

    langOpen = !langOpen;
}


module.exports = {
    checkLangState: checkLangState,
    clickOnLanguage : clickOnLanguage
}