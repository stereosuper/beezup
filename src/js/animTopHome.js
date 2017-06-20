var $ = require('jquery');

var TweenLite = require('gsap/TweenLite');

module.exports = function(btnTopHome){
    if(!btnTopHome.length) return;

    btnTopHome.on('click', function(e){
        e.preventDefault();

        TweenLite.to(window, 0.7, {scrollTo: { y: $('#titleHome').offset().top - 50 }});
    });
}