var $ = require('jquery-slim');

window.requestAnimFrame = require('./requestAnimFrame.js');
var throttle = require('./throttle.js');

module.exports = function(stickyElt, givenPosition, unit = 'px'){
    if(!stickyElt.length) return;

    var position,
        eltHeight;
    var windowHeight = $(window).height(); 
    var scrollTop = $(document).scrollTop();

    function checkWindowHeight() {
        windowHeight = $(window).height();
        if (unit == 'vh') {
            eltHeight = stickyElt.height();
            position = windowHeight / (100/givenPosition) - eltHeight/2;
        } else {
            position = givenPosition;
        }
    }
    
    function scrollHandler() {
        scrollTop = $(document).scrollTop();
        if (scrollTop >= stickyElt.data('offsetTop') - position) {
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
        stickyElt.data({
            'offsetBottom': stickyElt.closest('.wrapper-sticky').offset().top + stickyElt.closest('.wrapper-sticky').outerHeight(),
            'height': stickyElt.height()
        });
        scrollHandler();
    }


    stickyElt.data({
        'initialPos': stickyElt.css('top'),
        'offsetTop': stickyElt.offset().top,
        'offsetBottom': stickyElt.closest('.wrapper-sticky').offset().top + stickyElt.closest('.wrapper-sticky').outerHeight(),
        'height': stickyElt.height()
    });


    checkWindowHeight();


    
    $(document).on('scroll', throttle(function(){
        requestAnimFrame(scrollHandler);
    }, 10));

    $(window).on('resize', throttle(function(){
        requestAnimFrame(resizeHandler);
    }, 10));
}
