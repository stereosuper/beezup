var $ = require('jquery');

var TweenLite = require('gsap/TweenLite');
var TimelineLite = require('gsap/TimelineLite');
require('gsap/src/uncompressed/plugins/DrawSVGPlugin');
require('gsap/src/uncompressed/easing/CustomEase');


module.exports = function(windowWidth, tempo){
    if(windowWidth < 581) return;

    var easeOut = Power3.easeOut, easeIn = Power3.easeIn;
    var bounce = CustomEase.create('custom', 'M0,0 C0.4,0 0.593,0.983 0.6,1 0.662,0.916 0.664,0.88 0.7,0.88 0.742,0.88 0.8,0.985 0.814,0.998 0.825,0.994 1,1 1,1');
    var revBounce = CustomEase.create('custom', 'M0,0 C0,0 0.061,-0.004 0.095,-0.015 0.178,-0.043 0.229,-0.074 0.315,-0.104 0.353,-0.118 0.38,-0.124 0.42,-0.13 0.441,-0.133 0.458,-0.132 0.48,-0.129 0.498,-0.126 0.513,-0.124 0.53,-0.115 0.566,-0.095 0.596,-0.078 0.625,-0.048 0.667,-0.004 0.694,0.035 0.725,0.091 0.767,0.169 0.788,0.223 0.82,0.309 0.86,0.421 0.879,0.487 0.91,0.604 0.949,0.757 1,1 1,1');

    function animMapping(svg){
        var tl = new TimelineLite({onComplete: function(){
            tl.restart();
        }});
        var cable1 = svg.find('#cable1'), cable2 = svg.find('#cable2');

        tl.set([cable1, cable2], { drawSVG: 0 })
          .to(cable1, tempo, {drawSVG: '0% 100%', ease: easeIn})
          .to(cable1, tempo, {drawSVG: '100% 100%', ease: easeOut})
          .to(cable2, tempo, {drawSVG: '0% 100%', ease: easeIn, delay: tempo*2})
          .to(cable2, tempo, {drawSVG: '100% 100%', ease: easeOut});
    }

    function animImpact(svg){
        var tl = new TimelineLite({onComplete: function(){
            tl.restart();
        }});
        var cable = svg.find('#cable-2');

        tl.set(cable, {drawSVG: 0})
          .to(cable, tempo, {drawSVG: '0% 100%', ease: easeOut, delay: tempo})
          .to(cable, tempo, {drawSVG: '100% 100%', ease: easeOut, delay: tempo*2});
    }

    function animChoose(svg){
        var tlBox = new TimelineLite({ onComplete: reset });
        var tlReset = new TimelineLite({onComplete: function(){
            tlBox.restart();
        }});

        var t1 = svg.find('#cable-3-1');
        var t2 = svg.find('#cable-3-2');
        var t4 = svg.find('#cable-3-4');

        var c1 = svg.find('#connector-3-1');
        var c2 = svg.find('#connector-3-2');
        var c3 = svg.find('#connector-3-3');
        var c4 = svg.find('#connector-3-4');

        function reset(){
            tlReset.staggerTo([c1, c2, c3, c4], tempo, {delay: tempo*2, opacity: 0, y: -50, ease: easeOut}, 0.1);
        }

        tlBox.set([c1, c2, c3, c4], { y: -50, opacity: 0 });
        tlBox.set([t1, t2, t4], { drawSVG: 0 });
        
        tlBox.to(c1, tempo, {opacity: 1, ease: easeIn })
             .to(c1, tempo * 2, { y: 0, ease: bounce, delay: -tempo })
             .to(t1, tempo, {drawSVG: '0% 100%', ease: easeIn})
             .to(t1, tempo*2, {drawSVG: '100% 100%', ease: easeOut})
             .to(c2, tempo, {opacity: 1, ease: easeIn, delay: tempo})
             .to(c2, tempo * 2, {y: 0, ease: bounce, delay: -tempo})
             .to(t2, tempo, {drawSVG: '0% 100%', ease: easeIn})
             .to(t2, tempo*2, {drawSVG: '100% 100%', ease: easeOut})
             .to(c3, tempo, {opacity: 1, ease: easeIn, delay: tempo})
             .to(c3, tempo * 2, {y: 0, ease: bounce, delay: -tempo})
             .to(c4, tempo, {opacity: 1, ease: easeIn, delay: tempo*4})
             .to(c4, tempo * 2, { y: 0, ease: bounce, delay: -tempo })
             .to(t4, tempo, {drawSVG: '0% 100%', ease: easeIn})
             .to(t4, tempo*2, {drawSVG: '100% 100%', ease: easeOut});
    }

    function animImport(svg){
        var blocks = svg.find('.anim4-block').toArray().reverse();
        var checks = svg.find('.anim4-check').toArray().reverse();
        var containerBlocks = svg.find('#blocks');
        var cable = svg.find('#cable-4');
        var tlLoop = new TimelineLite({ delay: tempo * 2 });
        var tlCheck = new TimelineLite({ delay: tempo * 2 });
        var yMove = -50, xMove = 66, lastBloc, lastElt, idLoop = 8;

        function loopMove(){
            idLoop = idLoop < 1 ? 8 : idLoop;

            lastBloc = blocks[blocks.length - 1];  
            lastElt = $(lastBloc).clone().appendTo(containerBlocks);
            TweenLite.set(lastElt, {x: xMove * -idLoop, y: yMove * -idLoop});
            blocks.unshift(lastElt);
            tlCheck.set(lastElt.find('.anim4-check'), {y: -50, opacity: 0});

            tlLoop.to(blocks, tempo*2, {x: '+=' + xMove, y: '+=' + yMove, ease: easeIn, delay: tempo, onComplete: function(){
                blocks[blocks.length - 1].remove();
                blocks.pop();
                checkMove(idLoop);
            }});
            idLoop--;
        }

        function checkMove(i = 8){
            var j = i - 4 < 1 ? i + 4 : i - 4;

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

            tlCheck.fromTo(cable, tempo, {drawSVG: 0}, {drawSVG: '0% 100%', ease: easeIn})
                   .to(cable, tempo, { drawSVG: '100% 100%', delay: tempo*2, ease: easeOut})
                   .to(currentCheck, tempo, {opacity: 1, delay: -tempo*2, ease: easeIn, onComplete: loopMove})
                   .to(currentCheck, tempo, {y: 0, ease: bounce, delay: -tempo*2});
        }

        tlCheck.set(cable, {drawSVG: 0});
        tlCheck.set([checks[3], checks[2], checks[1], checks[0]], {y: -50, opacity: 0});
        checkMove();
    }

    function animHistory(svg){
        var h1 = svg.find('#hour-5-1');
        var h2 = svg.find('#hour-5-2');
        var h3 = svg.find('#hour-5-3');
        var h4 = svg.find('#hour-5-4');
        var b1 = svg.find('#connector-5-1');
        var b2 = svg.find('#connector-5-2');
        var b3 = svg.find('#connector-5-3');
        var b4 = svg.find('#connector-5-4');
        var t2 = svg.find('#txt-5-2');
        var tl = new TimelineLite({onComplete: reset});
        var tlReset = new TimelineLite({onComplete: function(){
            tl.restart();
        }});
        
        function reset(){
            tlReset.staggerTo([b1, b2, b3, b4], tempo, {delay: tempo*2, opacity: 0, y: -50, ease: easeOut}, 0.1)
                .add([
                    TweenLite.to([h1, h2, h3, h4], tempo*2, {opacity: 0, ease: easeOut, delay: -tempo}),
                    TweenLite.to(t2, tempo*2, {fill: '#0096E0', ease:easeOut, delay: -tempo})
                ]);
        }

        tl.set([h1, h2, h3, h4], {opacity: 0, fill: '#0FA1E7'})
          .set([b1, b2, b3, b4], {opacity: 0, y: -50})
          .set(t2, {fill: '#0096E0'})
          .to(h1, tempo, {opacity: 1, ease: easeIn, delay: tempo*2})
          .to(b1, tempo, {opacity: 1, y: 0, delay: tempo, ease: bounce})
          .to(h2, tempo, {opacity: 1, ease: easeIn, delay: tempo*2})
          .to(b2, tempo, {opacity: 1, y: 0, delay: tempo, ease: bounce})
          .add([
            TweenLite.to(t2, tempo, {delay: -tempo, ease:easeIn, fill: '#1D1D1B'}),
            TweenLite.to(h2, tempo, {delay: -tempo, ease:easeIn, fill: '#DE0C20'})
          ])
          .to(h3, tempo, {opacity: 1, ease: easeIn, delay: tempo*2})
          .to(b3, tempo, {opacity: 1, y: 0, delay: tempo, ease: bounce})
          .to(h4, tempo, {opacity: 1, ease: easeIn, delay: tempo*2})
          .to(b4, tempo, {opacity: 1, y: 0, delay: tempo, ease: bounce});
    }

    function animStats(svg){
        var blocks = svg.find('.bloc-6');
        var shadows = svg.find('.shade-6').toArray();

        // Mieux gérer les timing + ombres sur le bloc du haut
        blocks.each(function(i, el){
            var tl = new TimelineLite({onComplete: function(){
                tl.restart();  
            }});
            
            tl.to(el, 2, {y: -10, delay: i*0.2})
              .to(shadows[i], 2, {opacity: 0.2, delay: -2})
              .to(el, 2, {y: -5})
              .to(shadows[i], 2, {opacity: 0.3, delay: -2})   
              .to(el, 2, {y: -8 })
              .to(shadows[i], 2, {opacity: 0.24, delay: -2})  
              .to(el, 2, {y: 0})
              .to(shadows[i], 2, {opacity: 0.4, delay: -2});
        });
    }

    function animOptimize(svg) {
        var t1 = svg.find('#cable-7-1');
        var t2 = svg.find('#cable-7-2');
        var t3 = svg.find('#cable-7-3');
        var t4 = svg.find('#cable-7-4');
        var p1 = svg.find('#percent-7-1');
        var p2 = svg.find('#percent-7-2');
        var p3 = svg.find('#percent-7-3');
        var p4 = svg.find('#percent-7-4');
        var b1 = svg.find('#connector-7-1');
        var b2 = svg.find('#connector-7-2');
        var b3 = svg.find('#connector-7-3');
        var b4 = svg.find('#connector-7-4');
        var s2 = svg.find('#symbol-7-2');
        var s4 = svg.find('#symbol-7-4');
        var tl = new TimelineLite({onComplete: reset});
        var tlReset = new TimelineLite({onComplete: function(){
            tl.restart();
        }});

        function reset(){
            tlReset.staggerTo([b1, b2, b3, b4], tempo, {delay: tempo*2, opacity: 0, y: -50, ease: easeOut}, 0.1)
                .add([
                    TweenLite.to([p1, p2, p3, p4], tempo*2, {opacity: 0, ease: easeOut, delay: -tempo}),
                    TweenLite.to([s2, s4], tempo*2, {fill: '#0096E0', ease:easeOut, delay: -tempo})
                ]);
        }

        tl.set([p1, p2, p3, p4], {opacity: 0, fill: '#0FA1E7'})
          .set([b1, b2, b3, b4], {opacity: 0, y: -50})
          .set([s2, s4], {fill: '#0096E0'})
          .set([t1, t2, t3, t4], {drawSVG: 0})
          .to(p1, tempo, {opacity: 1, ease: easeIn, delay: tempo*2})
          .to(b1, tempo, {opacity: 1, y: 0, delay: tempo, ease: bounce})
          .to(t1, tempo, {drawSVG: '0% 100%', ease: easeIn})
          .to(t1, tempo, {drawSVG: '100% 100%', ease: easeOut})    
          .to(p2, tempo, {opacity: 1, ease: easeIn, delay: tempo*2})
          .to(b2, tempo, {opacity: 1, y: 0, delay: tempo, ease: bounce})
          .add([
            TweenLite.to(s2, tempo, {delay: -tempo, ease:easeIn, fill: '#BD0314'}),
            TweenLite.to(p2, tempo, {delay: -tempo, ease:easeIn, fill: '#DE0C20'})
          ])  
          .to(p3, tempo, {opacity: 1, ease: easeIn, delay: tempo*2})
          .to(b3, tempo, {opacity: 1, y: 0, delay: tempo, ease: bounce})
          .to(t3, tempo, {drawSVG: '0% 100%', ease: easeIn})
          .to(t3, tempo, {drawSVG: '100% 100%', ease: easeOut})   
          .to(p4, tempo, {opacity: 1, ease: easeIn, delay: tempo*2})
          .to(b4, tempo, {opacity: 1, y: 0, delay: tempo, ease: bounce})
          .add([
            TweenLite.to(s4, tempo, {delay: -tempo, ease:easeIn, fill: '#24DA4B'}),
            TweenLite.to(p4, tempo, {delay: -tempo, ease:easeIn, fill: '#24DA4B'})
          ])
          .to(t4, tempo, { drawSVG: '0% 100%', ease: easeIn })
          .to(t4, tempo, {drawSVG: '100% 100%', ease: easeOut});
    }

    function animOrders(svg){
        var boxes = svg.find('#boxes-8');
        var tl = new TimelineLite();
        var xMove = 48, yMove = 36;
        var loop = 0, newElt;
        var t1 = svg.find('#cable-8-1');
        var t2 = svg.find('#cable-8-2');
        var t3 = svg.find('#cable-8-3');

        tl.set([t1, t2, t3], { drawSVG: '100% 100%' });

        function resetLast(last, row){
            if(row === 3 || row === 0){
                tl.to(t3, tempo, {drawSVG: '0 100%', ease: easeIn, delay: tempo})
                  .to(t3, tempo, {drawSVG: '0% 0%', ease: easeIn, delay: tempo})
                  .to(t1, tempo, {drawSVG: '0 100%', ease: easeIn, delay:-tempo})
                  .to(t1, tempo, {drawSVG: '0% 0%', ease: easeIn, delay: tempo, onComplete: loopMove})
            }else if (row === 1){
                tl.to(t2, tempo, {drawSVG: '0 100%', ease: easeIn, delay: tempo})
                  .to(t2, tempo, {drawSVG: '0% 0%', ease: easeIn, delay: tempo})
                  .to(t1, tempo, {drawSVG: '0 100%', ease: easeIn, delay:-tempo})
                  .to(t1, tempo, {drawSVG: '0% 0%', ease: easeIn, delay: tempo, onComplete: loopMove})
            }
            
            tl.set([t1, t2, t3], {drawSVG: '100% 100%'});
            newElt = last.clone().prependTo(boxes);
            TweenLite.set(newElt, {x: xMove * -row, y: yMove * -row});
            last.remove();
            TweenLite.fromTo(newElt, tempo, {y: '-=50', opacity: 0}, {y: '+=50', opacity: 1, ease: bounce, delay: tempo*5});
        }

        function loopMove(){
            var boxes = svg.find('.box');
            var box1 = svg.find('#box-1'), box2 = svg.find('#box-2'), box3 = svg.find('#box-3');

            loop = loop > 4 ? 0 : loop;
            
            if(loop === 1){
                tl.to(boxes, tempo, {x: '+=' + xMove, y: '+=' + yMove, ease: easeOut, delay: tempo * 4})
                  .to(box3, tempo, {y: '-=50', opacity: 0, ease: revBounce, onCompleteParams: [box3, 3], onComplete: resetLast});
            }else if(loop === 3){
                tl.to(boxes, tempo, {x: '+=' + xMove, y: '+=' + yMove, ease: easeOut, delay: tempo * 4})
                  .to(box2, tempo, {y: '-=50', opacity: 0, ease: revBounce, onCompleteParams: [box2, 1], onComplete: resetLast});
            }else if(loop === 4){
                tl.to(boxes, tempo, {x: '+=' + xMove, y: '+=' + yMove, ease: easeOut, delay: tempo * 4})
                  .to(box1, tempo, {y: '-=50', opacity: 0, ease: revBounce, onCompleteParams: [box1, 0], onComplete: resetLast});
            }else{
                tl.to(boxes, tempo, {x: '+=' + xMove, y: '+=' + yMove, ease: easeOut, onComplete: loopMove, delay: tempo * 4});
            }

            loop++;
        }
        loopMove();
    }

    function animStock(svg){
        
    }


    animMapping($('#animMapping'));
    animImpact($('#animImpact'));
    animChoose($('#animChoose'));
    animImport($('#animImport'));
    animHistory($('#animHistory'));
    animStats($('#animStats'));
    animOptimize($('#animOptimize'));
    animOrders($('#animOrders'));
    animStock($('#animStock'));
}