var $ = require('jquery');

window.requestAnimFrame = require('./requestAnimFrame.js');
var throttle = require('./throttle.js');

module.exports = function(stickyElt, givenPosition, unit = 'px', updateHeightOnScroll = false, wrapper = true){
    if(!stickyElt.length) return;

    var position,
        eltHeight,
        posTop;
    var windowHeight = $(window).height(); 
    var scrollTop = $(document).scrollTop();
    var wrapperSticky = stickyElt.closest('.wrapper-sticky');

    function checkWindowHeight() {
        windowHeight = $(window).height();
        if (unit === 'vh') {
            eltHeight = stickyElt.outerHeight();
            position = windowHeight / (100/givenPosition) - eltHeight/2;
        } else {
            position = givenPosition;
        }
    }
    
    function scrollHandler() {
        if(updateHeightOnScroll && stickyElt.hasClass('sticky')){
            stickyElt.data('height', stickyElt.outerHeight());
        }
        scrollTop = $(document).scrollTop();
        if (stickyElt.data('initialPos') === 'auto'){
            posTop = 0;
        } else{
            posTop = parseFloat(stickyElt.data('initialPos'), 10);
        }
         
        if (scrollTop >= stickyElt.data('offsetTop') - position + posTop) {
            stickyElt.addClass('sticky').css('top', position+'px');
            if (scrollTop + position + stickyElt.data('height') >= stickyElt.data('offsetBottom')) {
                stickyElt.removeClass('sticky').addClass('sticky-stuck').css({'top': 'auto', 'bottom': '0'});
            }else {
                stickyElt.addClass('sticky').removeClass('sticky-stuck').css({ 'top': position + 'px', 'bottom': '' });
            }
        }else {
            stickyElt.removeClass('sticky').css('top', stickyElt.data('initialPos'));
        }
    }

    function resizeHandler() {
        checkWindowHeight();
        // scrollTop = $(document).scrollTop();
        // console.log(scrollTop);

        if (wrapper) {
            stickyElt.data({
                'offsetTop': wrapperSticky.offset().top,
            });
            console.log('wrap');
        } else {
            stickyElt.data({
                'offsetTop': stickyElt.offset().top,
            });
            console.log('el');
        }
        stickyElt.data({
            'offsetBottom': wrapperSticky.offset().top + wrapperSticky.outerHeight(),
            'height': stickyElt.outerHeight()
        });
        scrollHandler();
    }



    if (wrapper) {
        stickyElt.data({
            'offsetTop': wrapperSticky.offset().top
        });
        console.log('wrap');
    } else {
        stickyElt.data({
            'offsetTop': stickyElt.offset().top
        });
        console.log('el');
    }

    stickyElt.data({
        'initialPos': stickyElt.css('top'),
        'offsetBottom': wrapperSticky.offset().top + wrapperSticky.outerHeight(),
        'height': stickyElt.outerHeight()
    });

    console.log(stickyElt.data('initialPos'));


    checkWindowHeight();

    
    $(document).on('scroll', throttle(function(){
        requestAnimFrame(scrollHandler);
    }, 10));

    $(window).on('resize', throttle(function(){
        requestAnimFrame(resizeHandler);
    }, 10));
}
