var $ = require('jquery');

var TweenLite = require('gsap/TweenLite');
var TimelineLite = require('gsap/TimelineLite');
require('gsap/src/uncompressed/plugins/DrawSVGPlugin');


module.exports = function(schema, windowWidth){
    if(!schema.length || windowWidth < 781) return;

    var tl, tempo = 0.5;
    var cables = schema.find('.cable');
    var cables1 = cables.filter('.js-cable-1'), cables2 = cables.filter('.js-cable-2');
    var cables3 = cables.filter('.js-cable-3'), cables4 = cables.filter('.js-cable-4');
    var billeys = schema.find('.js-billey');
    var countBilley = 0;
    var billeyTween1, billeyTween2;
    var firstRound = true, currentBilley, currentBilleyHtml;
    var ease = Power3.easeOut;
    var random;


    function tweenBilley(){
        currentBilley = billeys.eq(countBilley);

        if(!firstRound){
            currentBilley = billeys.eq(0);
            TweenLite.set(currentBilley, {className: '-=on'});
            currentBilleyHtml = currentBilley;
            currentBilley.remove();
            billeys.last().after(currentBilleyHtml);
            billeys = schema.find('.js-billey');
            currentBilley = billeys.last();
        }

        TweenLite.to(billeys.filter('.on'), tempo, {y: '+=5px', ease: Power0.easeNone});

        billeyTween1 = TweenLite.fromTo(currentBilley, tempo, {x: '-75px', y: '-40px'}, {x: '45px', y: '25px', ease: ease});
        billeyTween2 = TweenLite.to(currentBilley, tempo, {y: '+=30px', className: '+=on', ease: ease});

        random = Math.floor(Math.random() * 7);
        cables.removeClass('hidden').filter('.js-cable-box-' + random).addClass('hidden');

        tl.add(billeyTween1).add(billeyTween2);
    }

    function updateBilley(){
        billeyTween1.kill();
        billeyTween2.kill();
        
        countBilley ++;

        if(countBilley > 3){
            countBilley = 0;
            firstRound = false;
        }

        tweenBilley();
    }

    function createTimeline(){
        tl = new TimelineLite({onComplete: function(){
            updateBilley();
            tl.restart();
        }});

        tl.to(cables1, tempo, {drawSVG: '0 100%'})
          .add([
            TweenLite.to(cables1, tempo, {drawSVG: '100% 100%', ease: ease}),
            TweenLite.to(cables2, tempo, {drawSVG: '0 100%', ease: ease})
        ]).add([
            TweenLite.to(cables2, tempo, {drawSVG: '100% 100%', ease: ease}),
            TweenLite.to(cables3, tempo, {drawSVG: '0 100%', ease: ease})
        ])
          .to(cables3, tempo, {drawSVG: 0, ease: ease})
          .to(cables4, tempo, {drawSVG: '0 100%', ease: ease})
          .to(cables4, tempo, {drawSVG: 0, ease: ease});

        billeyTween1 = TweenLite.to(billeys.eq(0), tempo, {x: '45px', y: '25px', ease: ease});
        billeyTween2 = TweenLite.to(billeys.eq(0), tempo, {y: '+=30px', className: '+=on', ease: ease});

        tl.add(billeyTween1).add(billeyTween2);
    }

    
    TweenLite.set([cables1, cables2], {drawSVG: 0});
    TweenLite.set([cables3, cables4], {drawSVG: '100% 100%'});
    cables.addClass('on');

    TweenLite.set(billeys, {x: '-75px', y: '-40px', opacity: 1});
    billeys.eq(0).addClass('on');

    schema.on('mouseenter', 'a', function(){
        TweenLite.to(
            [$(this).children('.box-top'), $('[data-schema-text="' + $(this).attr('id') + '"]')],
            0.3, {y: '-20px'}
        );
    }).on('mouseleave', 'a', function(){
        TweenLite.to(
            [$(this).children('.box-top'), $('[data-schema-text="' + $(this).attr('id') + '"]')],
            0.3, {y: '0px'}
        );
    });


    createTimeline();
}