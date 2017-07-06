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
        TweenLite.to(eltsToMove, 0.3, {  rotation: '0.01deg', z: 0.01, y: '0px', force3D:true });
    }else{
        langOpen ? TweenLite.to(eltsToMove, 0.3, { y: '0px' }) : TweenLite.to(eltsToMove, 0.3, { rotation: '0.01deg', z: 0.01, y: langHeight + 'px' , force3D:true});
    }
}    

var clickOnLanguage = function(windowWidth){
    langHeight = listLang.height();
    containerMenuHead.toggleClass('open');
    
    if(windowWidth <= 960){
        langOpen ? TweenLite.to(eltsToMove, 0.3, {  rotation: '0.01deg', z: 0.01, y: langHeight + 'px', force3D:true }) : TweenLite.to(eltsToMove, 0.3, { rotation: '0.01deg', z: 0.01, y: '0px', force3D:true});
    }

    langOpen = !langOpen;
}


module.exports = {
    checkLangState: checkLangState,
    clickOnLanguage : clickOnLanguage
}