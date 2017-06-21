var $ = require('jquery');

var TweenLite = require('gsap/TweenLite');
var TimelineLite = require('gsap/TimelineLite');
require('gsap/src/uncompressed/plugins/DrawSVGPlugin');
require('gsap/src/uncompressed/easing/CustomEase');


module.exports = function(windowWidth, tempo){
    if(windowWidth < 581) return;
    //var cables = schema.find('.cable');

    var easeOut = Power3.easeOut, easeIn = Power3.easeIn;
    var random, bounce = CustomEase.create('custom', 'M0,0 C0.4,0 0.593,0.983 0.6,1 0.662,0.916 0.664,0.88 0.7,0.88 0.742,0.88 0.8,0.985 0.814,0.998 0.825,0.994 1,1 1,1');

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
        ];
        var checks = [
            svg.find('#check-1'),
            svg.find('#check-2'),
            svg.find('#check-3'),
            svg.find('#check-4'),
            svg.find('#check-5'),
            svg.find('#check-6'),
            svg.find('#check-7'),
            svg.find('#check-8')
        ];
        var containerBlocks = svg.find('#blocks');
        var tlLoop = new TimelineLite({ delay: tempo * 2 });
        var tlCheck= new TimelineLite({ delay: tempo * 2 });
        var yMove = -50, xMove = 66;
        var lastBloc, lastElt;
        var idLoop = 8;
        var tuyau = svg.find('#trace-4');

        function loopMove() {
            (idLoop < 1 ) ? idLoop = 8 : idLoop = idLoop;
            lastBloc = blocks[blocks.length - 1];        
            lastElt = lastBloc.clone().appendTo(containerBlocks);
            lastElt.attr('transform', 'matrix(1,0,0,1,' + xMove * -idLoop +',' + yMove * -idLoop +')');
            blocks.unshift(lastElt);
            tlCheck.set(lastElt.find('.anim4-check'), { y: -50, opacity: 0 });
            tlLoop.to(blocks, tempo*2, {
                 x: '+=' + xMove, y: '+=' + yMove, ease: easeIn, delay: tempo, onComplete: function () {
                     blocks[blocks.length - 1].remove();
                     blocks.pop();
                     checkMove(idLoop);
            }});
            idLoop--;
        }

        function checkMove(i = 8) {
            var j = i - 4;
            j < 1 ? j = i + 4 : j = j;
            checks = [
                svg.find('#check-1'),
                svg.find('#check-2'),
                svg.find('#check-3'),
                svg.find('#check-4'),
                svg.find('#check-5'),
                svg.find('#check-6'),
                svg.find('#check-7'),
                svg.find('#check-8')
            ];

            var currentCheck = checks[j - 1];

            tlCheck.fromTo(tuyau, tempo, {drawSVG: 0}, { drawSVG: '0% 100%', ease: easeIn })
            .to(tuyau, tempo, { drawSVG: '100% 100%', delay: tempo*2, ease: easeOut})
            .to(currentCheck, tempo, {opacity: 1, delay: -tempo*2, ease: easeIn, onComplete: function () {
                    loopMove();
            }})
                .add([
                    TweenLite.to(currentCheck, tempo, { y: 0, ease: bounce, delay: -tempo*2})
                ]);
        }

        tlCheck.set(tuyau, { drawSVG: 0 });
        tlCheck.set([checks[3], checks[2],checks[1],checks[0]], { y: -50, opacity: 0 });
        checkMove();
    }

    function anim5(svg) {
        var h1 = svg.find('#hour-5-1');
        var h2 = svg.find('#hour-5-2');
        var h3 = svg.find('#hour-5-3');
        var h4 = svg.find('#hour-5-4');
        var b1 = svg.find('#connecteur-5-1');
        var b2 = svg.find('#connecteur-5-2');
        var b3 = svg.find('#connecteur-5-3');
        var b4 = svg.find('#connecteur-5-4');
        var t2 = svg.find('#txt-5-2');
        var tl = new TimelineLite({
            onComplete: function () {
            reset();
        }});
        var tlReset = new TimelineLite({
            onComplete: function () {
                tl.restart();
        }});
        
        function reset() {
            tlReset.staggerTo([b1, b2, b3, b4], tempo, { delay: tempo*2, opacity: 0, y: -50, ease: easeOut }, 0.1)
                .add([
                    TweenLite.to([h1, h2, h3, h4], tempo*2, { opacity: 0, ease: easeOut, delay: -tempo }),
                    TweenLite.to(t2, tempo*2, { fill: '#0096E0', ease:easeOut, delay: -tempo})
            ]);
        }

        tl.set([h1, h2, h3, h4], { opacity: 0, fill: '#0FA1E7'});
        tl.set([b1, b2, b3, b4], { opacity: 0, y: -50 });
        tl.set(t2, { fill: '#0096E0' });

        tl.to(h1, tempo, { opacity: 1, ease: easeIn, delay: tempo*2 })
        .to(b1, tempo, {opacity: 1, y: 0, delay: tempo, ease: bounce})
        .to(h2, tempo, { opacity: 1, ease: easeIn, delay: tempo*2 })
        .to(b2, tempo, {opacity: 1, y: 0, delay: tempo, ease: bounce})
        .add([
            TweenLite.to(t2, tempo, { delay: -tempo, ease:easeIn, fill: '#1D1D1B' }),
            TweenLite.to(h2, tempo, { delay: -tempo, ease:easeIn, fill: '#DE0C20'})
        ])
        .to(h3, tempo, { opacity: 1, ease: easeIn, delay: tempo*2 })
        .to(b3, tempo, {opacity: 1, y: 0, delay: tempo, ease: bounce})
        .to(h4, tempo, { opacity: 1, ease: easeIn, delay: tempo*2 })
        .to(b4, tempo, {opacity: 1, y: 0, delay: tempo, ease: bounce});
    }

    function anim6(svg) {
        var blocks = svg.find('.bloc-6');

        var ombres = [
            svg.find('#ombre-6-1'),
            svg.find('#ombre-6-2'),
            svg.find('#ombre-6-3'),
            svg.find('#ombre-6-4')
        ];
        
        console.log(blocks);

        // Mieux gérer les timing + ombres sur le bloc du haut
        
        blocks.each(function (i, el) {
            var tl = new TimelineLite({
                onComplete: function () {
                    tl.restart();  
            }});
            tl.to(el, 2, { y: -10, delay: i})
                .add(
                    TweenLite.to(ombres[i], 2, {opacity: 0.2, delay: -2})
                )    
            .to(el, 2, { y: -5 })
                .add(
                    TweenLite.to(ombres[i], 2, {opacity: 0.3, delay: -2})
                )     
            .to(el, 2, { y: -8 })
                .add(
                    TweenLite.to(ombres[i], 2, {opacity: 0.24, delay: -2})
                )     
            .to(el, 2, { y: 0 })
                .add(
                    TweenLite.to(ombres[i], 2, {opacity: 0.4, delay: -2})
                );
        })
        
    }

    anim1($('#anim1'));
    anim2($('#anim2'));
    anim3($('#anim3'));
    anim4($('#anim4'));
    anim5($('#anim5'));
    anim6($('#anim6'));



}