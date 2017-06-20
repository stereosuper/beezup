var $ = require('jquery');

// var throttle = require('./throttle.js');
// window.requestAnimFrame = require('./requestAnimFrame.js');

// var TweenLite = require('gsap/TweenLite');
var TimelineLite = require('gsap/TimelineLite');

module.exports = function(containersBees){
    if(!containersBees.length) return;

    var bees, containerMiddle, beeMiddle, directionBee,
        offset, nbCurrentBee = 0, tlAnimBees = [],
        randomX, randomY, randomDelay;


    function getMiddleInPage(elem){
        offset = elem.offset();
        
        return {
            top: offset.top + elem.outerHeight()/2,
            left: offset.left + elem.outerWidth()/2
        };
    }

    function animBee(elemToAnim, direction, nbBee){
        tlAnimBees[nbBee] = new TimelineLite({onComplete: function(){
            tlAnimBees[nbBee].restart();
        }});

        randomX = Math.random() * 40;
        randomY = Math.random() * 40;
        randomDelay = Math.random() * 0.2;

        switch(direction){
            case 'topRight':
                randomY = -randomY;
                break;
            case 'bottomLeft':
                randomX = -randomX;
                break;
            case 'topLeft':
                randomX = -randomX;
                randomY = -randomY;
                break;
            // case 'bottomRight':
            //     break;
        }

        tlAnimBees[nbBee].to(elemToAnim, 3, {x: randomX, y: randomY, opacity: 0.1, delay: randomDelay});
        
    }


    containersBees.each(function(){
        bees = $(this).find('.js-bee');
        containerMiddle = getMiddleInPage($(this));

        bees.each(function(){
            beeMiddle = getMiddleInPage($(this));
            
            if(beeMiddle.top >= containerMiddle.top && beeMiddle.left >= containerMiddle.left){
                directionBee = 'topRight';
            }else if(beeMiddle.top < containerMiddle.top && beeMiddle.left < containerMiddle.left){
                directionBee = 'bottomLeft';
            }else if(beeMiddle.top >= containerMiddle.top && beeMiddle.left < containerMiddle.left){
                directionBee = 'topLeft';
            }/*else{
                directionBee = 'bottomRight';
            }*/

            animBee($(this), directionBee, nbCurrentBee);
            nbCurrentBee ++;
        });
    });
}