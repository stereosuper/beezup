var $ = require('jquery');

var TweenLite = require('gsap/TweenLite');
var TimelineLite = require('gsap/TimelineLite');
require('gsap/src/uncompressed/plugins/DrawSVGPlugin');
require('gsap/src/uncompressed/easing/CustomEase');


module.exports = function(windowWidth, tempo){
    if(windowWidth < 581) return;
    //var cables = schema.find('.cable');

    var countBilley = 0;
    var billeyTween1, billeyTween2;
    var firstRound = true, currentBilley, currentBilleyHtml;
    var easeOut = Power3.easeOut, easeIn = Power3.easeIn;
    var random, bounce = CustomEase.create('custom', 'M0,0 C0.4,0 0.593,0.983 0.6,1 0.662,0.916 0.664,0.88 0.7,0.88 0.742,0.88 0.8,0.985 0.814,0.998 0.825,0.994 1,1 1,1');
    var survol;

    function anim1(svg) {
        var tl = new TimelineLite({onComplete: function(){
            tl.restart();
        }});
        var tuyau1 = svg.find('#tuyau1').find('#trace');
        var tuyau2 = svg.find('#tuyau2').find('#trace_1_');

        tl.set([tuyau1, tuyau2], { drawSVG: 0 });
        
        tl.to(tuyau1, tempo, {drawSVG:"0% 100%", ease:easeIn})
        .to(tuyau1, tempo, {drawSVG:"100% 100%", ease:easeOut})
        .to(tuyau2, tempo, {drawSVG:"0% 100%", ease:easeIn, delay: tempo*2})
        .to(tuyau2, tempo, {drawSVG:"100% 100%", ease:easeOut});
    }

    function anim2(svg) {
        var tl = new TimelineLite({onComplete: function(){
            tl.restart();
        }});
        var tuyau = svg.find('#tuyau-2').find('#trace-2');

        tl.set(tuyau, {drawSVG: 0});

        tl.to(tuyau, tempo, { drawSVG: "0% 100%", ease: easeOut, delay: tempo })
        .to(tuyau, tempo, { drawSVG: "100% 100%", ease: easeOut, delay: tempo*2 });
    }

    function anim3(svg){
        var tlBox = new TimelineLite();
        var tl1 = new TimelineLite({delay: tempo*2, onComplete: function(){
            tl1.restart();
        }});
        var tl2 = new TimelineLite({delay: tempo*6, onComplete: function(){
            tl2.restart();
        }});
        var tl4 = new TimelineLite({delay: tempo*14, onComplete: function(){
            tl4.restart();
        }});

        var t1 = svg.find('#tube-3-1').find('#trace-3-1');
        var t2 = svg.find('#tube-3-2').find('#trace-3-2');
        var t4 = svg.find('#tube-3-4').find('#trace-3-4');

        var c1 = svg.find('#connecteur-3-1');
        var c2 = svg.find('#connecteur-3-2');
        var c3 = svg.find('#connecteur-3-3');
        var c4 = svg.find('#connecteur-3-4');

        tlBox.set([c1, c2, c3, c4], { y: -50, opacity: 0 });
        tl1.set(t1, { drawSVG: 0 });
        tl2.set(t2, { drawSVG: 0 });
        tl4.set(t4, { drawSVG: 0 });
        

        tlBox.to(c1, tempo, { opacity: 1, ease: easeIn })
            .add([
                TweenLite.to(c1, tempo * 2, { y: 0, ease: bounce, delay: -tempo})
            ])
        .to(c2, tempo, { opacity: 1, ease: easeIn, delay: tempo*2})
            .add([
                TweenLite.to(c2, tempo * 2, { y: 0, ease: bounce, delay: -tempo})
            ])
        .to(c3, tempo, { opacity: 1, ease: easeIn, delay: tempo*2})
            .add([
                TweenLite.to(c3, tempo * 2, { y: 0, ease: bounce, delay: -tempo})
            ])
        .to(c4, tempo, { opacity: 1, ease: easeIn, delay: tempo*2})
            .add([
                TweenLite.to(c4, tempo * 2, { y: 0, ease: bounce, delay: -tempo})
            ]);
        
        tl1.to(t1, tempo, { drawSVG: "0% 100%", ease: easeIn})
        .to(t1, tempo*2, { drawSVG: "100% 100%", ease: easeOut, delay: tempo });
        
        tl2.to(t2, tempo, { drawSVG: "0% 100%", ease: easeIn})
        .to(t2, tempo*2, { drawSVG: "100% 100%", ease: easeOut, delay: tempo });
        
        tl4.to(t4, tempo, { drawSVG: "0% 100%", ease: easeIn})
        .to(t4, tempo*2, { drawSVG: "100% 100%", ease: easeOut, delay: tempo});
    }

    function anim4(svg) {
        var blocks = [
            svg.find('#bloc-1'),
            svg.find('#bloc-2'),
            svg.find('#bloc-3'),
            svg.find('#bloc-4'),
            svg.find('#bloc-5'),
            svg.find('#bloc-6'),
            svg.find('#bloc-7'),
            svg.find('#bloc-8')
        ]
        var containerBlocks = svg.find('#blocks');
        var tl = new TimelineLite();
        var yMove = -50;
        var xMove = 66;
        var lastBloc = blocks[blocks.length - 1];

        lastBloc.clone().appendTo(containerBlocks);




    //     tl.to(blocks, tempo, {
    //         x: xMove, y: yMove, ease: easeIn, delay: tempo, onComplete: function () {
    //             console.log(blocks[blocks.length - 1]);
    //             blocks[blocks.length - 1].remove();
    //    }});


    }

    anim1($('#anim1'));
    anim2($('#anim2'));
    anim3($('#anim3'));
    anim4($('#anim4'));



}