var $ = require('jquery');

var TweenLite = require('gsap/TweenLite');
var TimelineLite = require('gsap/TimelineLite');
require('gsap/src/uncompressed/plugins/DrawSVGPlugin');
require('gsap/src/uncompressed/easing/CustomEase');

var animBees = require('./animBees.js');


module.exports = function(schema, windowWidth, tempo){
    if(!schema.length || windowWidth < 781) return;

    var tl;
    var cables = schema.find('.cable');
    var cables1 = cables.filter('.js-cable-1'), cables2 = cables.filter('.js-cable-2');
    var cables3 = cables.filter('.js-cable-3'), cables4 = cables.filter('.js-cable-4');
    var billeys = schema.find('.js-billey');
    var countBilley = 0;
    var billeyTween1, billeyTween2, lastCableTween;
    var firstRound = true, currentBilley, currentBilleyHtml;
    var easeOut = Power3.easeOut, easeIn = Power3.easeIn;
    var random, bounce = CustomEase.create('custom', 'M0,0 C0.4,0 0.593,0.983 0.6,1 0.662,0.916 0.664,0.88 0.7,0.88 0.742,0.88 0.8,0.985 0.814,0.998 0.825,0.994 1,1 1,1');
    var rollover;
    var beesBilleys = schema.find('.js-bees-billeys'), beesProc = schema.find('.js-bees-proc');
    var beesBilleysTl, beesProcTl;


    function addTweenTl(){
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

        TweenLite.to(billeys.filter('.on'), 4*tempo, {y: '+=5px', ease: Power0.easeNone, delay: 4*tempo});


        lastCableTween = TweenLite.fromTo(cables4, tempo, {drawSVG: '0 100%'}, {drawSVG: 0, ease: easeOut});

        beesBilleysTl = animBees(beesBilleys, tempo, true);

        billeyTween1 = TweenLite.fromTo(currentBilley, 2*tempo, {x: '-75px', y: '-40px'}, {x: '45px', y: '25px', ease: Power4.easeOut});
        billeyTween2 = TweenLite.to(currentBilley, tempo, {y: '+=30px', className: '+=on', ease: bounce});

        random = Math.floor(Math.random() * 7);
        cables.removeClass('hidden').filter('.js-cable-box-' + random).addClass('hidden');


        tl.add([lastCableTween, beesBilleysTl, billeyTween1]).add(billeyTween2).restart();
    }

    function updateTl(){
        billeyTween1.kill();
        billeyTween2.kill();
        lastCableTween.kill();
        beesBilleysTl.forEach(function(elt){ 
            elt.kill();
        });
        tl.remove([billeyTween1, billeyTween2, lastCableTween, beesBilleysTl]);
        
        countBilley ++;

        if(countBilley > 3){
            countBilley = 0;
            firstRound = false;
        }

        addTweenTl();
    }

    function createTimeline(){
        tl = new TimelineLite({onComplete: function(){
            updateTl();
        }});

        lastCableTween = TweenLite.to(cables4, tempo, {drawSVG: 0, ease: easeOut});

        beesBilleysTl = animBees(beesBilleys, tempo, true);
        beesProcTl = animBees(beesProc, tempo, true);

        billeyTween1 = TweenLite.to(billeys.eq(0), 2*tempo, {x: '45px', y: '25px', ease: Power4.easeOut});
        billeyTween2 = TweenLite.to(billeys.eq(0), tempo, {y: '+=30px', className: '+=on', ease: bounce});

        tl.to(cables1, tempo, {drawSVG: '0 100%', ease: easeIn})
          .add([
            TweenLite.to(cables1, tempo, {drawSVG: '100% 100%', ease: easeOut, delay: tempo*2}),
            TweenLite.to(cables2, tempo, {drawSVG: '0 100%', ease: easeIn}),
            beesProcTl
          ])
          .add([
              TweenLite.to(cables2, tempo, {drawSVG: '100% 100%', ease: easeOut})
          ])
          .to(cables3, tempo, {drawSVG: '0 100%', ease: easeIn, delay: tempo*2})
          .add([
              TweenLite.to(cables3, tempo, {drawSVG: 0, ease: easeOut, delay: tempo*2}),
              TweenLite.to(cables4, tempo, {drawSVG: '0 100%', ease: easeIn})
          ])
          .add([lastCableTween, billeyTween1, beesBilleysTl])
          .add(billeyTween2);
    }

    
    TweenLite.set([cables1, cables2], {drawSVG: 0});
    TweenLite.set([cables3, cables4], {drawSVG: '100% 100%'});
    cables.addClass('on');

    TweenLite.set(billeys, {x: '-75px', y: '-40px', opacity: 1});
    billeys.eq(0).addClass('on');

    TweenLite.set([beesBilleys.children('.js-bee'), beesProc.children('.js-bee')], {opacity: 0})

    schema.on('mouseenter', 'a', function(){
        rollover = $(this).data('size') === 'small' ? 30 : 45;
        
        TweenLite.to(
            [$(this).children('.box-top'), $('[data-schema-text="' + $(this).attr('id') + '"]')],
            0.3, {y: '-' + rollover + 'px', ease: easeOut}
        );
    }).on('mouseleave', 'a', function(){
        TweenLite.to(
            [$(this).children('.box-top'), $('[data-schema-text="' + $(this).attr('id') + '"]')],
            0.2, {y: '0px', ease: bounce}
        );
    });


    createTimeline();
}