var $ = require('jquery');

var throttle = require('./throttle.js');
window.requestAnimFrame = require('./requestAnimFrame.js');

var TweenLite = require('gsap/TweenLite');
var TimelineLite = require('gsap/TimelineLite');

module.exports = function(containersBees){
    var bees, 
        containerMiddleHeight, containerMiddleWidth, 
        beeMiddleHeight, beeMiddleWidth,
        directionBee,
        nbCurrentBee = 0, tlAnimBees = [];

    function getMiddleInPage(elem){
        return {
            top: elem.offset().top + elem.outerHeight()/2,
            left: elem.offset().left + elem.outerWidth()/2
        };
    }

    function animBee(elemToAnim, direction, nbBee){
        switch(direction){
            case 'topRight':
                console.log('topRight');
                break;
            case 'bottomLeft':
                break;
            case 'topLeft':
                break;
            case 'bottomRight':
                break;
        }
        tlAnimBees[nbBee] = new TimelineLite({repeat: -1});
        tlAnimBees[nbBee].to(elemToAnim, 5, {x: -10, y: -10, opacity: 0});
    }

    containersBees.each(function(indexContainer){
        bees = $(this).find('.beeToAnim');
        containerMiddleHeight = getMiddleInPage($(this)).top;
        containerMiddleWidth = getMiddleInPage($(this)).left;
        bees.each(function(indexBee){
            beeMiddleHeight = getMiddleInPage($(this)).top;
            beeMiddleWidth = getMiddleInPage($(this)).left;
            if((beeMiddleHeight >= containerMiddleHeight) && (beeMiddleWidth >= containerMiddleWidth)){
                directionBee = 'topRight';
            }else if((beeMiddleHeight < containerMiddleHeight) && (beeMiddleWidth < containerMiddleWidth)){
                directionBee = 'bottomLeft';
            }else if((beeMiddleHeight >= containerMiddleHeight) && (beeMiddleWidth < containerMiddleWidth)){
                directionBee = 'topLeft';
            }else{
                directionBee = 'bottomRight';
            }
            animBee($(this), directionBee, nbCurrentBee);
            nbCurrentBee ++;
        });
    });
}