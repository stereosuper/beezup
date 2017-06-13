var $ = require('jquery');

var throttle = require('./throttle.js');
window.requestAnimFrame = require('./requestAnimFrame.js');

var TweenLite = require('gsap/TweenLite');
var TimelineLite = require('gsap/TimelineLite');
require('gsap/src/uncompressed/plugins/DrawSVGPlugin');

module.exports = function(schema){
    if(!schema.length) return;

    var tl, tempo = 1;
    var cables = schema.find('.cable');
    var cables1 = cables.filter('.js-cable-1'), cables2 = cables.filter('.js-cable-2');
    var cables3 = cables.filter('.js-cable-3'), cables4 = cables.filter('.js-cable-4');
    var billeys = schema.find('.js-billey');
    var countBilley = 0;
    var billeyTween1, billeyTween2;
    var firstRound = true, currentBilley, currentBilleyHtml;


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

        TweenLite.to(billeys.filter('.on'), tempo, {y: '+=5px'});

        billeyTween1 = TweenLite.fromTo(currentBilley, tempo, {x: '-75px', y: '-40px'}, {x: '45px', y: '25px'});
        billeyTween2 = TweenLite.to(currentBilley, tempo, {y: '+=30px', className: '+=on'});

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
            TweenLite.to(cables1, tempo, {drawSVG: '100% 100%'}),
            TweenLite.to(cables2, tempo, {drawSVG: '0 100%'})
        ]).add([
            TweenLite.to([schema.find('a').children('.box-top'), $('[data-text]')], 0.2, {y: '-10px', onComplete: function(){
                TweenLite.to([schema.find('a').children('.box-top'), $('[data-text]')], 0.1, {y: '0'});
            }}),
            TweenLite.to(cables2, tempo, {drawSVG: '100% 100%'}),
            TweenLite.to(cables3, tempo, {drawSVG: '0 100%'})
        ])
          .to(cables3, tempo, {drawSVG: 0})
          .to(cables4, tempo, {drawSVG: '0 100%'})
          .to(cables4, tempo, {drawSVG: 0});

        billeyTween1 = TweenLite.to(billeys.eq(0), tempo, {x: '45px', y: '25px'});
        billeyTween2 = TweenLite.to(billeys.eq(0), tempo, {y: '+=30px', className: '+=on'});

        tl.add(billeyTween1).add(billeyTween2);
    }

    
    TweenLite.set([cables1, cables2], {drawSVG: 0});
    TweenLite.set([cables3, cables4], {drawSVG: '100% 100%'});
    cables.addClass('on');

    TweenLite.set(billeys, {x: '-75px', y: '-40px', opacity: 1});
    billeys.eq(0).addClass('on');

    schema.on('mouseenter', 'a', function(){
        TweenLite.to(
            [$(this).children('.box-top'), $('[data-text="' + $(this).attr('id') + '"]')],
            0.3, {y: '-20px'}
        );
    }).on('mouseleave', 'a', function(){
        TweenLite.to(
            [$(this).children('.box-top'), $('[data-text="' + $(this).attr('id') + '"]')],
            0.3, {y: '0px'}
        );
    });


    $(window).on('load', function(){
        createTimeline();
    });
}