var $ = require('jquery');

var TimelineLite = require('gsap/TimelineLite');


module.exports = function(containersBees, timing = 3, returnTl, delay = 0){
    
    if(!containersBees.length) return;

    var bees, containerMiddle, beeMiddle, directionBee,
        offset, nbCurrentBee = 0, tlAnimBees = [],
        randomX, randomY, randomDelay, opacity = returnTl ? 1 : 0.1;


    function getMiddleInPage(elem){
        offset = elem.offset();
        
        return {
            top: offset.top + elem.outerHeight()/2,
            left: offset.left + elem.outerWidth()/2
        };
    }

    function animBee(elemToAnim, direction, nbBee){
        tlAnimBees[nbBee] = new TimelineLite({onComplete: function(){
            if(!returnTl) tlAnimBees[nbBee].restart();
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

        tlAnimBees[nbBee].to(elemToAnim, timing, {x: randomX, y: randomY, opacity: opacity, delay: delay+randomDelay});

        if(returnTl){
            tlAnimBees[nbBee].to(elemToAnim, timing, {opacity: 0});
        }
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


    return tlAnimBees;
}